<?php
/**
 * task 模块
 * xuduorui@qq.com
 */
class TaskTypeShare extends TaskTypeAbs
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
        return ($this->_model && ($this->_model->step_count>0));
	}
    
    /*
        计算完成程度
        @param MemberTaskModel
    */
	public function calcStep($instModel)
	{
        return $instModel->step_count;
	}
    

}
