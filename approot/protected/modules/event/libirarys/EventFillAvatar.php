<?php

/*
* @author xuduorui
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

        $pointsModule = Yii::app()->getModule('points');
        $pointsRuleModel = PointsRuleModel::model()->find('rule_key=:rule_key', array(':rule_key'=>$taskRuleKey));
        $taskRuleId = $pointsRuleModel->rule_id;
        // isTaskFinished
        $taskModule = Yii::app()->getModule('mtask');
        $taskTplModel = $taskModule->getTaskTplByRule($taskRuleId);
        //echo 'taskTplModel=';print_r($taskTplModel);
        //$isTaskFinished = $taskModule->isTaskFinished($member_id, $taskTplModel->task_id);
        $isTaskFinished = $taskModule->finishTask($member_id, $taskTplModel->task_id);
        
        //$taskModule->isTaskFinished($member_id, $taskRuleKey);
        //Yii::log(__METHOD__ .': going to invoke isTaskFinished('.$member_id.','.$taskRuleKey.')='.$isTaskFinished, 'warning', 'EventModule');
        
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];
        if ($isTaskFinished) {
            // 是否已奖励任务积分
            $taskPointsLog = MemberPointsHistoryModel::model()->find('member_id=:mid and rule_id=:rule_id', array(
                ':mid' => $member_id,
                ':rule_id' => $taskRuleId,
            ));
            if ($taskPointsLog) {
                $ret = false;
                Yii::log('he('.$member_id.') as already got task('.$taskRuleKey.') reward!'.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            } else {
                $ret = true;
            }
            
            $params['taskTplId'] = $taskTplModel->task_id;
            if ($ret) {
                // 完善任务的事件有多项 但是完成积分增加 和完成任务 只有一项
                Yii::app()->getModule('event')->pushEvent($member_id, 'finish_task', $params);
            }
        }

        // 是否已奖励普通积分
        $pointsRuleModel = PointsRuleModel::model()->find('rule_key=:rule_key', array(':rule_key'=>$params['_event_tpl']['use_rule_key']));
        $pointsLog = MemberPointsHistoryModel::model()->with('rule')->find('member_id=:mid and rule.rule_id=:rule_id', array(
            ':mid' => $member_id,
            ':rule_id' => $pointsRuleModel->rule_id,
        ));

        if ($pointsLog) {
            $ret = false;
            Yii::log('he('.$member_id.') as already got points('.$params['_event_tpl']['use_rule_key'].') reward!'.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
        } else {
            $ret = true;
        }

        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        unset($params['taskTplId']);
        //unset($params['points_rule_key']);

        // 此事件将触发两个积分规则事件 普通的积分增长和任务

        // 按照条件 继续 下一个事件 points_change
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
