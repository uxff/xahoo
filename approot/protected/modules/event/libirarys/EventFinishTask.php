<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventFinishTask extends EventAbs {

    const EVENT_KEY = 'finish_task';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['taskTplId']   任务模板id
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        // 判断任务积分是否发放 按照任务规则
        $taskModule = Yii::app()->getModule('mtask');
        $taskModule = Yii::app()->getModule('points');
        // 完成任务只能发放一次积分
        // 查找rule_id发放积分
        $taskTplId = (int)$params['taskTplId'];
        //if (!$taskTplId) {
        //    Yii::log('illegal task_id:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        //}
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if (!$taskInst) {
            Yii::log('illegal task_id:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            $ret = false;
        }

        $rule_id = $taskInst->getModel()->task_tpl->rule_id;
        $params['points_rule_key'] = $taskInst->getModel()->task_tpl->rule_id;
        $params['points_rule_key_type'] = 'rule_id';

        if ($ret) {
            // 已完成可执行-> 
            // 判断派发积分还是奖励金额
            switch ($taskInst->getModel()->task_tpl->reward_type) {
                case 1:
                    // 继续派发积分
                    $ret = true;
                    Yii::log('will dispatch points:'.' mid='.$member_id.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                    // 查找是否发放过
                    $pointsLog = MemberPointsHistoryModel::model()->find('member_id=:mid and rule_id=:rule_id', array(
                        ':mid' => $member_id,
                        ':rule_id' => $rule_id,
                    ));
                    if ($pointsLog) {
                        $ret = false;
                        Yii::log(''.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                    } else {
                        $ret = true;
                    }
                    break;
                case 2:
                    // 不需要继续派发积分
                    $ret = false;
                    // 派发金额
                    if ($taskInst->getModel()->dispatch_id) {
                        Yii::log('he('.$member_id.') as already got task('.$taskTplId.') money!'.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                        break;
                    }
                    Yii::log('will dispatch money:'.' mid='.$member_id.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                    $remark = '完成任务：'.$taskInst->getModel()->task_tpl->task_name;
                    $dispatch_id = Yii::app()->getModule('fhmoney')->dispatchMoneyToMember($member_id, $taskInst->getModel()->task_tpl->reward_money, $remark);
                    if (!$dispatch_id) {
                        Yii::log('dispatch money failed:'.' mid='.$member_id.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                    } else {
                        $taskInst->getModel()->dispatch_id = $dispatch_id;
                        $taskInst->getModel()->save();
                    }
                    break;
                default:
                    break;
            }
        }
        
        // 封装下一个事件的参数
        $ruleKey = $params['points_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];
        
        // 按照条件 继续添加 points_change 事件
        if ($ret) {
            // use_rule_key = task_share
            Yii::app()->getModule('points')->execRuleByRuleKey($member_id, PointsRuleModel::RULE_KEY_TASK_SHARE, $taskInst->getModel()->task_tpl->reward_points, '分享任务：'.$taskInst->getModel()->task_tpl->task_name);

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
