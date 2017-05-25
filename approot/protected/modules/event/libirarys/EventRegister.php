<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventRegister extends EventAbs {

    const EVENT_KEY = 'register';

    /*
    * 处理事件
        内容：增加注册积分
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['member_mobile']   必须
    * @param $params['invite_code']     可选
    * @param $params['inviter']         可选
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = true;

        // 为用户初始化基本信息：积分
        Yii::app()->getModule('points')->initMemberTotalInfo($member_id);
        // 初始化邀请码
        //Yii::app()->getModule('friend')->makeInviteCode($member_id);
        
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
    /*
        事前
    */
    public function afterProcess($member_id, $params) {
        
        // 记录日志
        $logModel = new MemberInfoLogModel;
        $logModel->member_id = $member_id;
        $logModel->editor = $params['member_mobile'];
        $logModel->role = '会员';
        $logModel->type = 3;
        $logModel->content = '通过M站注册';
        $logModel->create_time = date('Y-m-d H:i:s');
        $logModel->save();
        return true;
    }
}
