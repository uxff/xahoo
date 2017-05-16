<?php

class PmAdminLog extends PmAdminLogBase
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		//新增的在这里面加，如果修改 需要修改父类中的Rules
		$curRules = array(
		);
		return array_merge(parent::rules(), $curRules);
	}
	
	//批量更新，可以采用链式条件调用，而原始的只能单独传条件,不能连续
	public  static  function addLog($message = '',$url='') {
		$model=new self();
		$model->admin_id=Yii::app()->adminUser->getRole();
		$model->description= $message;
		$model->url= $url;
		$model->prameter= json_encode($_REQUEST);
		return  $model->save();
	}
	/**
	 * custom defined scope
	 */
	public function inId($id =[]) {
		if (!empty($id)) {
			$id=(array)$id;
			$this->getDbCriteria()->addInCondition('log_id', $id);
		}
		return $this;
	}
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		$curRelations = array(
		);
		return array_merge(parent::relations(), $curRelations);
	
	}
	/**
	 * custom defined scope
	 * @param  integer $newType 新闻类型: 1.普通 2.置顶 3.默认
	 * @return object
	 */
	public function orderBy($order = 't.create_time DESC') {
	
		if (!empty($order)) {
			$this->getDbCriteria()->mergeWith(array('order' => $order));
		}
	
		return $this;
	}
	//批量更新，可以采用链式条件调用，而原始的只能单独传条件,不能连续
	public function updateBatchAll($attributes,$condition = '') {
		$builder = $this->getCommandBuilder();
		$criteria=$this->getDbCriteria();
		if (!empty($condition)) {
			$this->getDbCriteria()->mergeWith(array('condition' => $condition));
		}
		$command = $builder->createUpdateCommand($this->getTableSchema(), $attributes, $criteria);
		return $command->execute();
	}
	/**
	 *  @return boolean whether the softDelete is successful
	 */
	public function softDelete() {
		$criteria=$this->getDbCriteria();
		return 	$this->updateAll(['status'=>0],$criteria);
	}
	/**
	 * custom defined scope
	 * @param  integer $pageNo   页码
	 * @param  integer $pageSize 每页大小
	 * @return object
	 */
	public function pagination($pageNo = 1, $pageSize = 20) {
	
		$offset = ($pageNo > 1) ? ($pageNo - 1) * $pageSize : 0;
		$limit = ($pageSize > 0) ? $pageSize : 20;
	
		$this->getDbCriteria()->mergeWith(array('limit' => $limit, 'offset' => $offset));
	
		return $this;
	}
	/**
	 * 与Smarrty中的文本提示相对应，可以修改成中文提示
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		$curLables = array(
		);
		return array_merge(parent::attributeLabels(), $curLables);
	}
	public function mySearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = $this->getBaseCDbCriteria();
		//为$criteria新增设置
		$count = $this->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
		$pager->pageVar = 'page'; //修改分页参数，默认为page
		$pager->params = array('type' => 'msg'); //分页中添加其他参数
		$pager->applyLimit($criteria);
		$list = $this->findAll($criteria);
		$pages = array(
				'curPage' => $pager->currentPage+1,
				'totalPage' => ceil($pager->itemCount/$pager->pageSize),
				'pageSize' => $pager->pageSize,
				'totalCount'=>$pager->itemCount,
				'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
		);
		return array('pages' => $pages, 'list' => $list);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PmOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
