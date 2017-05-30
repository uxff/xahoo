<?php
/**
 * task 模块
 * xuduorui@qq.com
 */
class TaskInst
{
    //private $_member_id;
    //private $_taskTplId;
    //private $_instId;
    private $_model; // MemberTaskModel
    //private $_rule;
    private $_type;  // TaskTypeShare|TaskTypeInvite|TaskTypeFillAvatar
    
    /*
        构造函数
        @param MemberTaskModel $instModel
    */
    public function __construct($instModel = null) {
        //if (get_class($instModel)=='MemberTask') {
            $this->_model = $instModel;
        //}
        //echo 'task_type=';print_r($this->_model->task_tpl->task_type);
        if ($instModel && $instModel->task_tpl) {
            $this->_type = TaskTypeFactory::create($instModel->task_tpl->task_type);
        }
        //$this->_rule = TaskRuleFactory::create($instModel->rule_id);
    }
    
    /*
        获得实例的静态方法
    */
	static public function makeInstByTpl($member_id, $taskTplId)
	{
        $instModel = MemberTaskModel::model()->with('task_tpl')->find('member_id=:mid and t.task_id=:task_id', array(':mid'=>$member_id, ':task_id'=>$taskTplId));
        
        if ($instModel) {
            return new TaskInst($instModel);
        }
        return null;
	}
    
    /*
        获得实例的静态方法
    */
	static public function makeInst($instId)
	{
        $instModel = MemberTaskModel::model()->with('task_tpl')->findByPk($instId);
        if ($instModel) {
            return new TaskInst($instModel);
        }
        return null;
	}

    public function setModel($instModel) {
        $this->_model = $instModel;
    }
    public function getModel() {
        return $this->_model;
    }
    public function isAlready() {
        return $this->_model;
    }
    /**
    * 为用户派发任务
    *   // 用户领取任务时调用
    * @param $member_id
    * @param $taskTplId
    */
    public function dispatchTask($member_id, $taskTplId) {
    }
    
    /**
    * 强制完成任务
    * @param $member_id
    * @param $taskTplId
    * @return 任务是否完成
    */
    public function finishTask() {
        if ($this->_model->status == MemberTaskModel::STATUS_FINISHED) {
            // 任务已完成
            return true;
        }
        $this->_model->step_count = $this->_model->step_need_count;
        $this->_model->finish_time = date('Y-m-d H:i:s', time());
        $this->_model->status = MemberTaskModel::STATUS_FINISHED;
        $ret = $this->_model->save();
        if (!$ret) {
            Yii::log($this->_model->lastError().' mid='.$this->_model->member_id.' taskTplId='.$this->_model->task_id, 'error', __METHOD__);
        }
        return $ret;
    }

    /*
        任务是否完成
        @param $member_id
        @param $taskTplId
    */
    public function isTaskFinished() {
        //return ($this->_model && ($this->_model->step_need_count==$this->_model->step_count));
        //echo __METHOD__;print_r($this->_type);
        return $this->_type && $this->_type->isFinished($this->_model);
    }

    /*
        任务进度 前进一步
    */
    public function stepForward() {
        if ($this->_model->status == MemberTaskModel::STATUS_FINISHED) {
            // 任务已完成
            return true;
        }
        $this->_model->step_count += 1;
        if ($this->_model->step_count >= $this->_model->step_need_count) {
            $this->_model->finish_time = date('Y-m-d H:i:s', time());
            $this->_model->status = MemberTaskModel::STATUS_FINISHED;
        }
        $ret = $this->_model->save();
        if (!$ret) {
            Yii::log($this->_model->lastError().' mid='.$this->_model->member_id.' taskTplId='.$this->_model->task_id, 'error', __METHOD__);
        }
        return $ret;
    }

    /*
        刷新任务进度
        @param $member_id
        @param $taskTplId
    */
    public function flushTaskStatus() {
        if ($this->_model->status == MemberTaskModel::STATUS_FINISHED) {
            // 任务已完成
            return true;
        }
        $ret = false;
        $realStepCount = $this->_type ? $this->_type->calcStep($this->_model) : 0;
        if ($realStepCount && $this->_model->step_count != $realStepCount) {
            $this->_model->step_count = $realStepCount;
        }
        if ($this->_model->step_count >= $this->_model->step_need_count) {
            $this->_model->finish_time = date('Y-m-d H:i:s', time());
            $this->_model->status = MemberTaskModel::STATUS_FINISHED;
            $ret = $this->_model->save();
            if (!$ret) {
                Yii::log($this->_model->lastError().' mid='.$this->_model->member_id.' taskTplId='.$this->_model->task_id, 'error', __METHOD__);
            }
        }
        return $ret;
    }

    /*
        任务是否派发
        @param $member_id
        @param $taskTplId
    */
    public function isTaskRewarded() {
        if ($this->_model->task_tpl->reward_type) {
            return $this->_model->reward_status & MemberTaskModel::REWARD_STATUS_DONE_POITNS;
        } elseif ($this->_model->task_tpl->reward_type_money) {
            return $this->_model->reward_status & MemberTaskModel::REWARD_STATUS_DONE_MONEY;
        }
        return false;
    }

    /*
        任务是否派发
        @param $member_id
        @param $taskTplId
    */
    public function markTaskRewarded($rewardStatus) {
        //if ($this->_model->task_tpl->reward_type) {
        //    return $this->_model->reward_status &= MemberTaskModel::REWARD_STATUS_DONE_POITNS;
        //} elseif ($this->_model->task_tpl->reward_type_money) {
        //    return $this->_model->reward_status &= MemberTaskModel::REWARD_STATUS_DONE_MONEY;
        //}
        if ($this->_model && ($this->_model->reward_status &= $rewardStatus)) {
            if (!$this->_model->save()) {
                Yii::log('save member task failed:'.$this->_model->lastError().' mid='.$this->_model->member_id.' taskTplId='.$this->_model->task_id, 'error', __METHOD__);
            }
        }
    }

}
