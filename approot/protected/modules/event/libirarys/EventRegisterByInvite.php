<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventRegisterByInvite extends EventRegister {

    const EVENT_KEY = 'register_by_invite';

    /*
    * 处理事件
        内容： 增加注册积分 完成下一事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['inviter']    必须参数 try_to_finish_task 事件使用
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        // 为用户初始化基本信息：积分
        Yii::app()->getModule('points')->initMemberTotalInfo($member_id);
        // 添加好友
        Yii::app()->getModule('friend')->makeFriendShip($member_id, $params['inviter']);
        Yii::app()->getModule('mtask');
        // 初始化邀请码
        //Yii::app()->getModule('friend')->makeInviteCode($member_id);
        // 如果有对应的任务
        $taskTplModel = TaskTplModel::model()->find('task_type='.TaskTplModel::TASK_TYPE_INVITE);
        if ($taskTplModel) {
            $taskTplId = $taskTplModel->task_id;
            $taskInst = TaskInst::makeInstByTpl($params['inviter'], $taskTplId);
            if ($taskInst) {
                $taskInst->stepForward();
                Yii::log('update his('.$params['inviter'].') task('.$taskTplId.')'.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                //$shareTitle = '分享：'.$taskInst->getModel()->task_tpl->task_name;
                if ($taskInst->isTaskFinished() && !$taskInst->isTaskRewarded()) {
                    // 奖励任务
                    //$taskInst->markTaskRewarded();
                    Yii::app()->getModule('mtask')->rewardTaskInst($params['inviter'], $taskTplId);
                }
            }
        }
        
        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 按照条件 继续 下一事件： points_change,try_to_finish_task,try_to_finish_invite_friend
        if ($ret) {
            if (!empty($this->model->use_rule_key)) {
                Yii::app()->getModule('points')->execRuleByRuleKey($member_id, $this->model->use_rule_key);
            }
            if (!empty($nextEvents))
            foreach ($nextEvents as $nextEvent) {
                if ($nextEvent != '') {
                    Yii::app()->getModule('event')->pushEvent($member_id, $nextEvent, $params);
                }
            }
        }
        $this->afterProcess($member_id, $params);
        return true;
    }
}
