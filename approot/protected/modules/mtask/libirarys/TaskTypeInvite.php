<?php
/**
 * task 模块
 * xuduorui@qq.com
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
        return ($this->_model && ($this->_model->step_count>=$this->_model->step_need_count));
	}
    
    /*
        计算完成程度
        @param MemberTaskModel
    */
	public function calcStep($instModel)
	{
        $this->_model = $instModel;
        // 查询计算邀请数量
        $inviteCodeModel = MemberInviteCodeModel::model()->with('who_use_me')->find('t.member_id='.$instModel->member_id);
        if (!$inviteCodeModel) {
            Yii::log(__METHOD__ .': member('.$instModel->member_id.') has no invite code?', 'error', 'TaskModule');
            return false;
        }
        $successNum = count($inviteCodeModel->who_use_me);
        return $successNum;
	}
    

}
