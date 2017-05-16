<?php

/*
* @author xuduorui
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

        $now = time();
        // 查找今日checkIn记录
        //$event_id = $params['_event_tpl']['event_id'];
        //$checkInList = EventLogModel::model()->find('event_key="'.EventPointsChange::EVENT_KEY.'" and pre_event_id="'.$event_id.'" and sender_mid=:member_id and create_time>="'.date('Y-m-d 00:00:00', $now).'"', array(':member_id'=>$member_id));
        $startTime = date('Y-m-d 00:00:00', $now);
        // 当日签到记录
        $checkInLog	= Yii::app()->getModule('points')->getCheckInLog($member_id, $startTime);
        // 如果有连续签到 引发的积分变动事件 则不再添加积分变动事件
        if ($checkInLog) {
            $ret = false;
            Yii::log(__METHOD__ .': cannot reduplicate add '.self::EVENT_KEY.' event! member_id='.$member_id.' date='.date('Y-m-d', $now), 'warning', 'EventModule');
        }

        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 积分变动（签到）事件，每天唯一
        
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
}
