<?php
/**
 * task 模块
 * xuduorui@qq.com
 */
class TaskTypeFillAvatar extends TaskTypeAbs
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
        计算是否完成
        @param MemberTaskModel
    */
	public function calcStep($instModel)
	{
        $this->_model = $instModel;
        $ret = ($this->_model && ($this->_model->step_need_count==$this->_model->step_count));
        return $ret;
	}
    

}
