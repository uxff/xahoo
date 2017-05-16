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
            'application.fanghumodels.*',
            'mtask.libirarys.*',
			'mtask.controllers.*',
			'mtask.models.*',
		));
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
        // 如果是分享类型的 需要创建rule_id
        if ($taskTplAttr['TaskTplModel']['task_type'] == TaskTplModel::TASK_TYPE_SHARE) {
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
            $model->rule_id = $ruleModel->rule_id;
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
}
