<?php
/**
 * task 模块
 * coderxx@qq.com
 */
class TaskTypeInvite extends TaskTypeAbs
{
    private $_model;
    private $_type;
    
    /*
        判断是否完成
        @param MemberTaskModel
    */
	public function isFinished($instModel)
	{
        $this->_model = $instModel;
        $realStepCount = $this->calcStep($instModel);
        return ($this->_model && ($this->_model->step_count>=$this->_model->step_need_count) && ($realStepCount>=$this->_model->step_need_count));
	}
    
    /*
        计算完成程度
        @param MemberTaskModel
    */
	public function calcStep($instModel)
	{
        $this->_model = $instModel;
        $startTime = '0000-00-00 00:00:00'; // 如果不限当日
        $startTime = date('Y-m-d 00:00:00', time()); // 如果限制当日邀请够一定个数个
        // 查询计算邀请数量
        $inviteCodeModel = MemberInviteCodeModel::model()->with('who_use_me')->find('t.member_id=:mid and who_use_me.create_time>=:startTime', [
            ':mid' => $instModel->member_id,
            ':startTime' => $startTime,
        ]);
        if (!$inviteCodeModel) {
            Yii::log('member('.$instModel->member_id.') has no invite code?', 'error', __METHOD__);
            return false;
        }
        $successNum = count($inviteCodeModel->who_use_me);
        return $successNum;
	}
    

}
