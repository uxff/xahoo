<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类
*/

class EventTryToFinishInviteFriend extends EventAbs {

    const EVENT_KEY = 'try_to_finish_invite_friend';
    const STEP_MAX_COUNT = 3;//每日邀请成功最多奖励十个

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['inviter']    必须参数 finish_invite_friend 事件使用
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = false;

        $pointsModule = Yii::app()->getModule('points');
        $inviter = (int)$params['inviter'];
        if (!$inviter) {
            Yii::log(__METHOD__ .': no inviter!', 'error', 'EventModule');
            $ret = false;
        }

        // 获取今日邀请小伙伴注册的个数
        $startDay = date('Y-m-d H:i:s', time());
        $inviteRuleKey = 'finish_invite_friend';
        $pointsLog = MemberPointsHistoryModel::model()->with('rule')->findAll('member_id=:mid and rule.rule_key=:rule_key and t.create_time>=:startDay', array(
            ':mid' => $inviter,
            ':startDay' => $startDay,
            ':rule_key' => $inviteRuleKey,
        ));
        $stepCount = count($pointsLog);
        if ($stepCount >= self::STEP_MAX_COUNT) {
            Yii::log(__METHOD__ .': mid('.$inviter.') have got full rewards of '.$inviteRuleKey.'!', 'warning', 'EventModule');
            $ret = false;
        } else {
            $ret = true;
        }
        // 应该校验真实的邀请次数
        //$inviteLogModel = MemberInviteLogModel::model()->find('inviter=:inviter', array(':inviter'=>$inviter));

        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 按照条件 继续 下一事件 finish_invite_friend
        // 注意 下一事件的主人是 $inviter
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
