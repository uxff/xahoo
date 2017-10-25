<?php

/*
* @author coderxx
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventFillAvatar extends EventAbs {

    const EVENT_KEY = 'fill_avatar';
    const TASK_RULE_KEY = 'task_fill_avatar';

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

        // 根据前一个事件中的use_rule_key判断任务对应的规则
        $myPreEventKey = $params['pre_event_key'];
        $myPreEventId  = $params['pre_event_id'];
        $taskRuleKey   = self::TASK_RULE_KEY;//$params['_event_tpl']['use_rule_key'];

        $taskModule     = Yii::app()->getModule('mtask');
        $pointsModule   = Yii::app()->getModule('points');

        // 是否已奖励普通积分
        //$pointsRuleModel = PointsRuleModel::model()->find('rule_key=:rule_key', array(':rule_key'=>PointsRuleModel::RULE_KEY_FILL_AVATAR));
        $pointsLog = MemberPointsHistoryModel::model()->with('rule')->find('member_id=:mid and rule.rule_key=:rule_key', array(
            ':mid' => $member_id,
            ':rule_key' => PointsRuleModel::RULE_KEY_FILL_AVATAR,
        ));

        if ($pointsLog) {
            $ret = false;
            Yii::log('he('.$member_id.') as already got points('.PointsRuleModel::RULE_KEY_FILL_AVATAR.') reward!', 'warning', __METHOD__);
        } else {
            $ret = true;
            Yii::app()->getModule('points')->execRuleByRuleKey($member_id, PointsRuleModel::RULE_KEY_FILL_AVATAR);
        }

        // 尝试完成任务积分奖励
        $pointsRuleModel = PointsRuleModel::model()->find('rule_key=:rule_key', array(':rule_key'=>$taskRuleKey));
        $taskRuleId = $pointsRuleModel->rule_id;

        // isTaskFinished
        $taskTplModel = $taskModule->getTaskTplByRule($taskRuleId);

        // 直接完成完善个人信息任务
        $isTaskFinished = $taskModule->finishTask($member_id, $taskTplModel->task_id);

        // 完成后派发奖励
        if ($isTaskFinished) {
            $taskModule->rewardTaskInst($member_id, $taskTplModel->task_id);
        }

        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        unset($params['taskTplId']);
        //unset($params['points_rule_key']);

        // 此事件将触发两个积分规则事件 普通的积分增长和任务

        // 按照条件 继续 下一个事件 points_change
        if ($ret) {
            //if (!empty($this->model->use_rule_key)) {
            //}
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
