<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventPointsChange extends EventAbs {

    const EVENT_KEY = 'points_change';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['points_rule_key']    必须参数
    * @param $params['points_rule_key_type']    如果没有 ruleKeyType = rule_key
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        $pointsModule = Yii::app()->getModule('points');
        $ruleKeyType = $params['points_rule_key_type']=='rule_id' ? 'rule_id' : 'rule_key';
        $ruleKey = $params['points_rule_key'];

        unset($params['points_rule_key']);
        unset($params['points_rule_key_type']);

        if ($ruleKey) {
            $ret = $pointsModule->execRule($member_id, $ruleKey, $ruleKeyType);
        } else {
            Yii::log(__METHOD__ .': no points_rule_key for points_change event: '.@json_encode($params), 'error', 'EventModule');
        }

        // 封装下一个事件的参数
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];
        
        // 按照条件 继续 下一个事件 try_to_level_up
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
