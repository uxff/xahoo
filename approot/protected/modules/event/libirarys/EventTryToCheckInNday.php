<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventTryToCheckInNday extends EventAbs {

    const EVENT_KEY = 'try_to_check_in_nday';
    const DAY_NUM = 7;//检查天数范围

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
return false;
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        $pointsModule = Yii::app()->getModule('points');
        $now = time();
        $event_id = $params['_event_tpl']['event_id'];

        $startDay = date('Y-m-d 00:00:00', $now-86400*(self::DAY_NUM-1));
        // 查找上次完成连续7天签到的日期
        //$lastCheckInNdayDate = EventLogModel::model()->orderBy('t.create_time DESC')->find('event_key="'.EventPointsChange::EVENT_KEY.'" and pre_event_key="'.EventCheckInNday::EVENT_KEY.'" and sender_mid=:member_id', array(':member_id'=>$member_id));
        
        $lastCheckInNdayDate = MemberPointsHistoryModel::model()->find('member_id=:mid and rule_id=2', [
            ':mid' => $member_id,
        ]);
        if ($lastCheckInNdayDate && $lastCheckInNdayDate->create_time >= $startDay) {
            // 7天内已经获得该成果，不能重复获取
            $ret = false;
            Yii::log(__METHOD__ .': already got points_change(check_in_nday): mid='.$member_id.' day='.$lastCheckInNdayDate->create_time, 'warning', 'EventModule');
        } else {
            // 查找7天points_change(pre_event_key=check_in)记录
            //$checkInList = EventLogModel::model()->findAll('event_key="'.EventPointsChange::EVENT_KEY.'" and pre_event_key="'.EventCheckIn::EVENT_KEY.'" and sender_mid=:member_id and create_time>="'.$startDay.'"', array(':member_id'=>$member_id));
            $checkInList = MemberPointsHistoryModel::model()->findAll('member_id=:mid and rule_id=1 and create_time>="'.$startDay.'"', [
                ':mid' => $member_id,
            ]);
            // 如果有连续签到 引发的积分变动事件 则不再添加积分变动事件
            if (count($checkInList) < self::DAY_NUM) {
                $ret = false;
                Yii::log(__METHOD__ .': not enough points_change(check_in) log: member_id='.$member_id.' startDay='.$startDay, 'warning', 'EventModule');
            }
        }
        
        // 封装下一个事件的参数
        //$params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 按照条件 允许下一个事件 check_in_nday
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
