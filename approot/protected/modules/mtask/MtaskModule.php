<?php
/**
 * mtask 模块
 * xuduorui@qq.com
 */
class MtaskModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
            'application.common.extensions.*',
            'application.ucentermob.api.*',
            'application.ucentermodels.*',
            'application.xahoomodels.*',
            'mtask.libirarys.*',
			'mtask.controllers.*',
			'mtask.models.*',
		));
        Yii::app()->getModule('points');
	}

	public function welcome() 
	{
		echo "welcome to ".__CLASS__."\n";
		return false;
	}
    
    /**
    * 为用户派发任务
    *   // 用户领取任务时调用
    * @param $member_id
    * @param $taskTplId
    */
    public function dispatchTask($member_id, $taskTplId) {
        if (!$member_id || !$taskTplId) {
            Yii::log('member_id or taskTplId must not be null!'.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
            return false;
        }

        $taskTplModel = TaskTplModel::model()->findByPk($taskTplId);
        if (!$taskTplModel) {
            Yii::log('taskTplId('.$taskTplId.') not exist!'.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
            return false;
        }

        $taskInstModel = new MemberTaskModel;
        $taskInstModel->member_id = $member_id;
        $taskInstModel->task_id = $taskTplId;
        $taskInstModel->rule_id = $taskTplModel->rule_id;
        $taskInstModel->step_need_count = $taskTplModel->step_need_count;

        if (!$taskInstModel->save()) {
            Yii::log('cannot create MemberTaskModel(mid='.$member_id.',tid='.$taskTplId.') :'.$taskInstModel->lastError().' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        $taskInstModel->task_tpl = $taskTplModel;

        $taskInst = new TaskInst($taskInstModel);
        return $taskInst;
    }
    
    /**
    * 完成任务
    * @param $member_id
    * @param $taskTplId
    * @return bool $isTaskFinished
    */
    public function finishTask($member_id, $taskTplId){
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if ($taskInst && $taskInst->isAlready()) {
            return $taskInst->finishTask();
        }
        Yii::log('cannot find task inst: mid='.$member_id.' taskTplId='.$taskTplId.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
        return false;
    }

    /*
        任务是否完成
        @param $member_id
        @param $taskTplId
    */
    public function isTaskFinished($member_id, $taskTplId){
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if ($taskInst && $taskInst->isAlready()) {
            return $taskInst->isTaskFinished();
        }
        Yii::log('taskInst not exist! mid='.$member_id.' taskTplId='.$taskTplId.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
        return false;
    }

    /*
        刷新任务进度，尝试更新任务状态
        @param $member_id
        @param $taskTplId
    */
    public function flushTaskStatus($member_id, $taskTplId){
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if ($taskInst && $taskInst->isAlready()) {
            return $taskInst->flushTaskStatus();
        }
        Yii::log('taskInst not exist! mid='.$member_id.' taskTplId='.$taskTplId.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
        return false;
    }

    /*
        更新任务进度
        @param $member_id
        @param $taskTplId
    */
    public function stepForward($member_id, $taskTplId){
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if ($taskInst && $taskInst->isAlready()) {
            return $taskInst->stepForward();
        }
        Yii::log('taskInst not exist! mid='.$member_id.' taskTplId='.$taskTplId.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
        return false;
    }

    /*
        增加任务模板
            需要同步添加rule_id
        @param array $taskTplAttr
        @param $taskTplAttr['TaskTplModel'] 必须 包含TaskTplModel的成员
    */
    public function addTaskTpl($taskTplAttr) {
        $model = new TaskTplModel;
        $model->attributes = $taskTplAttr['TaskTplModel'];
        // 如果是分享类型的 需要指定rule_id 
        if ($taskTplAttr['TaskTplModel']['task_type'] == TaskTplModel::TASK_TYPE_SHARE) {
            /*
            $ruleModel = new PointsRuleModel;
            $ruleModel->rule_key = 'share_'.date('YmdHis_').mt_rand(100, 999);
            $ruleModel->rule_name = '任务：'.$model->task_name;
            $ruleModel->points = $model->reward_points;
            $ruleModel->flag = 2;
            $ret = $ruleModel->save();
            if (!$ret) {
                Yii::log('save rule failed: '.$ruleModel->lastError().' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
                return false;
            }
            */
            $model->rule_id = PointsRuleModel::RULE_ID_FOR_TASK; //$ruleModel->rule_id;
            if (!$model->save()) {
                //print_r($model->getErrors());print_r($taskTplAttr);exit;
                Yii::log('save taskTplModel failed: '.$model->lastError().' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
                return false;
            }
            
        } else {
            Yii::log('task type '.$model->task_type.' not valid!'.' @'.__FILE__ .':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        return $model;
    }
    
    /*
        更新taskTpl
        @param $member_id
        @param $rule_id
    */
    public function updateTaskTpl($tplId, $data) {
        return $ret;
    }
    
    /*
        按规则查找任务模板
            一个任务模板只有一个规则id 一个规则id只对应一个任务
        @param $rule_id
    */
    public function getTaskTplByRule($rule_id) {
        $taskTplModel = TaskTplModel::model()->find('rule_id=:rule_id', array(':rule_id'=>$rule_id));
        return $taskTplModel;
    }
    
    /*
        获取某人的任务
    */
    public function getMemberTaskList($member_id, $condition=array(), $page=1, $pageSize=10) {
        $arrSqlParam = array(
            'condition' => 'member_id=:mid',
            'params' => array(
                ':mid' => $member_id,
                ),
            'order' => 't.id desc',
        );

        if (isset($condition['status'])) {
            $arrSqlParam['condition'] .= ' and t.status=:status';
            $arrSqlParam['params'][':status'] = $condition['status'];
        }

        $total = MemberTaskModel::model()->count($arrSqlParam);
        $list = MemberTaskModel::model()->with('task_tpl')->pagination($page, $pageSize)->findAll($arrSqlParam);
        foreach ($list as $k=>$v) {
            $list[$k] = $v->toArray();
            $list[$k]['_reward_desc'] = $v['task_tpl']['reward_type']==2 ? ('￥'.$v['task_tpl']['reward_money']) : ($v['task_tpl']['reward_points'].'积分');
        }

        $arrRet = array(
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'list' => $list,
        );
        return $arrRet;
    }

    /*
        为任务派发奖励
            派发奖励并标记为已派发奖励 不关心是否已完成
        @param $member_id
    */
    public function rewardTaskInst($member_id, $taskTplId) {
        $taskInst = $this->getTaskInst($member_id, $taskTplId);
        if (!($taskInst instanceof TaskInst)) {
            Yii::log('cannot find task inst: mid='.$member_id.' tplId='.$taskTplId, 'error', __METHOD__);
            return false;
        }

        $ret = false;
        $ruleId = $taskInst->getModel()->task_tpl->rule_id;
        $rewardPoints = 0;
        $rewardMoney  = 0;

        try {
            // 是否符合任务中的派发条件 在这里面判断
            if (!$taskInst->markTaskRewarded($taskInst->getModel()->task_tpl->reward_type | $taskInst->getModel()->task_tpl->reward_type_money, $taskInst->getModel()->task_tpl->reward_points, $taskInst->getModel()->task_tpl->reward_money)) {
                throw new CException('mark task reward failed');
            }

            // 分别派发积分奖励和金额奖励
            if ($taskInst->getModel()->task_tpl->reward_type == 1) {
                $rewardPoints  = $taskInst->getModel()->task_tpl->reward_points;

                // 查看任务派发是否重复
                $taskPointsLog = MemberPointsHistoryModel::model()->find('member_id=:mid and rule_id=:rule_id', array(
                    ':mid' => $member_id,
                    ':rule_id' => $taskInst->getModel()->task_tpl->rule_id,
                ));

                if ($taskPointsLog) {
                    Yii::log('he('.$member_id.') as already got task('.$ruleId.') reward!', 'warning', __METHOD__);
                } else {
                    // 需要派发积分
                    $remark = '完成任务：'.$taskInst->getModel()->task_tpl->task_name;
                    if (!Yii::app()->getModule('points')->execRuleByRuleId($member_id, $ruleId, $rewardPoints, $remark)) {
                        throw new CException('cannot reward points failed');
                    }
                }
            }

            if ($taskInst->getModel()->task_tpl->reward_type == 2) {
                //$rewardStatus |= MemberTaskModel::REWARD_STATUS_DONE_MONEY;
                $rewardMoney   = $taskInst->getModel()->task_tpl->reward_money;

                // 需要派发金额
                if ($taskInst->getModel()->dispatch_id) {
                    Yii::log('he('.$member_id.') as already got task('.$taskTplId.') money!', 'warning', __METHOD__);
                } else {
                    Yii::log('will dispatch money:'.' mid='.$member_id.' tplId='.$taskTplId, 'warning', __METHOD__);

                    $remark = '完成任务：'.$taskInst->getModel()->task_tpl->task_name;
                    $dispatch_id = Yii::app()->getModule('fhmoney')->dispatchMoneyToMember($member_id, $rewardMoney, $remark);
                    if (!$dispatch_id) {
                        throw new CException('dispatch money failed');
                    } else {
                        $taskInst->getModel()->dispatch_id = $dispatch_id;
                        if ($taskInst->getModel()->save()) {
                            throw new CException('save task inst failed:'.$taskInst->getModel()->lastError());
                        }
                    }
                }
            }

            Yii::log('reward task success: mid='.$member_id.' tplId='.$taskTplId.' rule_id='.$ruleId, 'warning', __METHOD__);
            $ret = true;
        } catch (CException $e) {
            Yii::log('reward task failed:'.$e->getMessage().' mid='.$member_id.' tplId='.$taskTplId.' rule_id='.$ruleId, 'error', __METHOD__);
        }

        return $ret;
    }

    /*
        标记为已发放
        @param TaskInst $taskInst
    */
    public function markTaskInstAsRewarded(TaskInst $taskInst, $rewardStatus, $rewardPoints = 0, $rewardMoney = 0) {
        if (!($taskInst instanceof TaskInst)) {
            return false;
        }
        return $taskInst->markTaskRewarded($rewardStatus, $rewardPoints, $rewardMoney);
    }
    
    /*
        标记为已发放
        @param $member_id
    */
    public function markTaskAsRewarded($member_id, $taskTplId, $rewardStatus, $rewardPoints = 0, $rewardMoney = 0) {
        $taskInst = $this->getTaskInst($member_id, $taskTplId);
        if (!($taskInst instanceof TaskInst)) {
            return false;
        }
        return $taskInst->markTaskRewarded($rewardStatus, $rewardPoints, $rewardMoney);
    }
    
    /*
        获取taskInst
        @param $member_id
        @param $taskTplId
    */
    public function getTaskInst($member_id, $taskTplId) {
        return TaskInst::makeInstByTpl($member_id, $taskTplId);
    }
}
