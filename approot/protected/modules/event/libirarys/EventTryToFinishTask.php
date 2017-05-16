<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventTryToFinishTask extends EventAbs {

    const EVENT_KEY = 'try_to_finish_task';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = false;

        $taskRuleKey = $params['task_rule_key'];
        $pointsModule = Yii::app()->getModule('points');
        $taskModule = Yii::app()->getModule('mtask');

        // 根据上一个事件 看需要判断什么任务
        $preEventKey = $params['pre_event_key'];
        switch ($preEventKey) {
            case 'register_by_invite':
                $params['task_rule_key'] = 'task_invite_friend';
                $ret = $this->isFinishInviteTask($member_id, $params);
                break;
            case 'share':
                $ret = $this->isFinishShareTask($member_id, $params);

                break;
            default:
                $ret = false;
                break;
        }
        
        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 按照条件 继续
        if ($ret) {
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
    /*
        判断邀请任务是否完成
        @param $params['inviter'] 判断完成谁的任务
        @param $params['task_rule_key'] 判断完成任务的rule_key
    */
    public function isFinishInviteTask($member_id, $params) {
        $ret = false;
        $inviter = $params['inviter'];
        if (empty($inviter)) {
            Yii::log(__METHOD__ .': illegal inviter:'.$inviter, 'warning', 'EventModule');
            return false;
        }
        //$inviteCodeModel = MemberInviteCodeModel::model()->find('member_id=:mid', array(':mid'=>$inviter));
        $inviteCodeModel = Yii::app()->getModule('friend')->getInviteCodeModel($inviter);
        if (empty($inviteCodeModel)) {
            Yii::log(__METHOD__ .': no invite code of inviter:'.$inviter, 'warning', 'EventModule');
            return false;
        }
        $taskRuleKey = $params['task_rule_key'];
        $pointsModule = Yii::app()->getModule('points');
        $taskModule = Yii::app()->getModule('mtask');
        //$pointsRuleModel = PointsRuleModel::model()->find('rule_key=:rule_key', array(':rule_key'=>$taskRuleKey));
        //$taskTplModel = $taskModule->getTaskTplByRule($pointsRuleModel->rule_id);
        $pointsRuleModel = PointsRuleModel::model()->with('task_tpl')->find('t.rule_key=:rule_key', array(':rule_key'=>$taskRuleKey));
        if ($pointsRuleModel) {
            $taskTplId = $pointsRuleModel->task_tpl->task_id;
            // 查看任务是否完成
            $isTaskFinished = $taskModule->flushTaskStatus($inviter, $taskTplId);
            $ret = $isTaskFinished == true;
        } else {
            Yii::log(__METHOD__ .': cannot find rule_key:'.$taskRuleKey, 'error', 'EventModule');
        }
        return $ret;
    }
    /*
        判断邀请任务是否完成
        @param $params['taskTplId']
        @param $params['taskTplId']
    */
    public function isFinishShareTask($member_id, $params) {
        $ret = false;
        $taskTplId = (int)$params['taskTplId'];
        if (!$taskTplId) {
            Yii::log('illegal task_id:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if (!$taskInst) {
            Yii::log('member('.$member_id.') has no task:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        return $taskInst->isTaskFinished();
    }
}
