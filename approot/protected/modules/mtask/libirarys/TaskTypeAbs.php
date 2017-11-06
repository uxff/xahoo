<?php
/**
 * task 模块
 * coderxx@qq.com
 */
abstract class TaskTypeAbs
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
        Yii::log(__METHOD__ .': illegal taskType:'.$instModel->task_tpl->task_type, 'error', 'TaskModule');
        return false;
	}
    

}
