<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

abstract class EventAbs {
    
    const EVENT_KEY_TEST = 'event_test';
    const EVENT_KEY_TEST_NEXT = 'event_test_next';

    // 当前类对应的model
    public $model;

    /*
    * 处理事件
    * 继承自 EventAbs::process
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);

        Yii::app()->getModule('event')->pushEvent($member_id, EVENT_KEY_TEST, $params);

        $this->afterProcess($member_id, $params);
        return true;
    }
    /*
    * 预先处理事件
    * 继承自 EventAbs::preProcess
    * @param $member_id 用户id
    * @param $params    json 格式的事件参数
    */
    protected function preProcess($member_id, $params) {
        return true;
    }
    /*
    * 处理结束
    * 继承自 EventAbs::afterProcess
    * @param $member_id 用户id
    * @param $params    json 格式的事件参数
    */
    protected function afterProcess($member_id, $params) {
        return true;
    }
}
