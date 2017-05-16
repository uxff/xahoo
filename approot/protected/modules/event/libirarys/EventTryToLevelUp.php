<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventTryToLevelUp extends EventAbs {

    const EVENT_KEY = 'try_to_level_up';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        $event_key = $params['_event_tpl']['event_key'];
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);

        $ret = false;
        $pointsModule = Yii::app()->getModule('points');
        // 1 获取积分所得
        $memberInfo = $pointsModule->getMemberTotalInfo($member_id);
        // 2 判断积分所得是不是在等级中
        $calcLevel = $pointsModule->calcLevelByPoints($memberInfo->points_gain);
        if ($calcLevel>$memberInfo->level) {
            // 允许升级
            $ret = true;
            $params['level_to_up'] = $calcLevel;
        }

        // 封装下一个事件的参数
        //$params['points_rule_key'] = $taskRuleKey;
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 按照条件 继续 添加升级事件
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
