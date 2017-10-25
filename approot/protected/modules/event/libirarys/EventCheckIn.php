<?php

/*
* @author coderxx
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventCheckIn extends EventAbs {

    const EVENT_KEY = 'check_in';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    *   这里实现积分变动（签到）事件，每天唯一
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        Yii::app()->getModule('points')->checkIn($member_id);

        // 积分变动（签到）事件，每天唯一
        
        if ($ret) {
            /*
            if (!empty($this->model->use_rule_key)) {
                Yii::app()->getModule('points')->execRuleByRuleKey($member_id, $this->model->use_rule_key);
            }
            */
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
