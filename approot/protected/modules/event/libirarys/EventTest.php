<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventTest extends EventAbs {

    const EVENT_KEY = 'event_test';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        $event_key = $params['event_key'];
        
        //echo __CLASS__." is called!\n";
        $nextEvents = $params['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        // 按照条件 继续
        
        if ($ret) {
            unset($params['event_next']);
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
