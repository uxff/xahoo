<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventFinishInviteFriend extends EventAbs {

    const EVENT_KEY = 'finish_invite_friend';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['inviter']    必须参数 points_change 事件使用
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];
        $inviter = (int)$params['inviter'];

        // 按照条件 继续 下一事件 points_change
        if ($ret) {
            if (!empty($this->model->use_rule_key)) {
                Yii::app()->getModule('points')->execRuleByRuleKey($member_id, $this->model->use_rule_key);
            }
            if (!empty($nextEvents))
            foreach ($nextEvents as $nextEvent) {
                if ($nextEvent != '') {
                    Yii::app()->getModule('event')->pushEvent($inviter, $nextEvent, $params);
                }
            }
        }
        $this->afterProcess($member_id, $params);
        return true;
    }
}
