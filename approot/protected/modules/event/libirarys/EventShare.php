<?php

/*
* @author xuduorui
* @date 2016-2-26  
* @desc 事件处理类 普通资讯分享，派发分享积分；任务分享，触发尝试完成任务
*/

class EventShare extends EventAbs {

    const EVENT_KEY = 'share';

    /*
    * 处理事件
    * 继承自 EventAbs::process()
    * @param $member_id 用户id
    * @param $params    array 格式的事件参数
    * @param $params['articleId'] 资讯id
    * @param $params['platId']    平台id
    * @param $params['articleUrl']    
    * @param $params['visitUrl']    
    * @param $params['articleUrl']    
    * @param $params['shareCode']       // 必须
    * @param $params['taskTplId']       // 记录任务 如果有
    */
    public function process($member_id, $params) {
        $this->preProcess($member_id, $params);
        
        $nextEvents = $params['_event_tpl']['event_next'];
        $nextEvents = explode(',', $nextEvents);
        $ret = false;

        Yii::app()->getModule('friend');
        Yii::app()->getModule('mtask');
        // 分享规则
        // 一用户一文章 分享到1平台 奖励一次
        $articleId  = (int)$params['articleId']; //资讯id
        $platId     = (int)$params['platId'];    //平台id
        $taskTplId  = (int)$params['taskTplId'];    //平台id
        // member_id 可能是空
        if (!$member_id) {
            // 通过shareCode查询
            $inviteCodeModel = MemberInviteCodeModel::model()->find('invite_code=:code', array(':code'=>$params['shareCode']));
            $member_id = $inviteCodeModel->member_id;
        }
        // 判断是否已共享
        $shareLogModel = ShareLogModel::model()->find('article_id=:aid and member_id=:mid and task_tpl_id=:tpl_id and plat_type=:platId', array(
            ':aid' => $articleId,
            ':platId' => $platId,
            ':mid' => $member_id,
            ':tpl_id' => $taskTplId,
        ));
        if (!$shareLogModel) {
            $shareLogModel = new ShareLogModel;
            $shareLogModel->article_id = $articleId;
            $shareLogModel->task_tpl_id = $taskTplId;
            $shareLogModel->member_id = $member_id;
            $shareLogModel->plat_type = $platId;
            $shareLogModel->visit_url = $params['visitUrl'];
            $shareLogModel->use_invite_code = $params['shareCode'];
            $shareLogModel->article_url = $params['articleUrl'];
            if (!$shareLogModel->save()) {
                Yii::log('save shareLogModel error:'.$shareLogModel->lastError().' @'.__FILE__.':'.__LINE__,'error',__METHOD__);
            }
            Yii::log('new share log! mid='.$member_id.' aid='.$articleId.' platId='.$platId.' @'.__FILE__.':'.__LINE__,'warning',__METHOD__);
            $ret = true;
        } else {
            $shareLogModel->view_count += 1;
            $shareLogModel->save();
            $ret = false;
            Yii::log('already shared! mid='.$member_id.' aid='.$articleId.' platId='.$platId.' @'.__FILE__.':'.__LINE__,'warning',__METHOD__);
        }
        
        $shareTitle = '分享';
        if ($articleId) {
            $articleModel = ArticleModel::model()->findByPk($articleId);
            if ($articleModel) {
                $shareTitle = '分享：' .$articleModel->title;
            }
        }

        // 给对应的任务进度+1
        //$taskTplId = (int)$params['taskTplId'];
        if ($taskTplId) {
            $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
            if ($taskInst) {
                $taskInst->stepForward();
                Yii::log('update his('.$member_id.') task('.$taskTplId.')'.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                $shareTitle = '分享任务：'.$taskInst->getModel()->task_tpl->task_name;
                //if ($taskInst->isTaskFinished() && !$taskInst->isTaskRewarded()) {
                //    // 发送任务完成事件
                //    Yii::app()->getModule('points')->execRuleByRuleKey($member_id, $this->model->use_rule_key);
                //    $taskInst->markTaskRewarded();
                //}
            }
        }
        
        // 封装下一个事件的参数
        $params['points_rule_key'] = $params['_event_tpl']['use_rule_key'];
        $params['pre_event_key'] = self::EVENT_KEY;
        $params['pre_event_id'] = $params['_event_tpl']['event_id'];

        // 按照条件 继续 下一个事件 points_change
        if ($ret) {
            if (!empty($this->model->use_rule_key)) {
                // use_rule_key = share
                Yii::app()->getModule('points')->execRuleByRuleKey($member_id, $this->model->use_rule_key, 0, $shareTitle);
            }
            if (!empty($nextEvents))
            foreach ($nextEvents as $nextEvent) {
                if ($nextEvent != '') {
                    Yii::app()->getModule('event')->pushEvent($member_id, $nextEvent, $params);
                }
            }
        }
        
        // 必然调用的事件
        if ($taskTplId) {
            Yii::app()->getModule('event')->pushEvent($member_id, 'try_to_finish_task', $params);
        }
        
        $this->afterProcess($member_id, $params);
        return true;
    }
}
