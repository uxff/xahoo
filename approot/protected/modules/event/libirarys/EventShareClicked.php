<?php

/*
* @author coderxx
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventShareClicked extends EventAbs {

    const EVENT_KEY = 'share_clicked';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['taskTplId']   必须
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = false;

        // 一个用户的分享 一个文章 只派发一次
        $taskTplId = (int)$params['taskTplId'];
        if (!$taskTplId) {
            Yii::log('illegal task_id:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        } else {
            $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
            if (!$taskInst) {
                Yii::log('he('.$member_id.') has no task:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            } else {
                $isDispatched = $taskInst->getModel()->view_count > 1;
                $ret = !$isDispatched;
            }
        }

        
        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

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
