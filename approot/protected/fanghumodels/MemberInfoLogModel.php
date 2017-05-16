<?php
class MemberInfoLogModel extends CActiveRecord
{
	static $ARR_TYPE = array(
			1 => '修改信息',
			2 => '完善信息',
			3 => '注册会员',
	);
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
			return 'fh_member_info_log';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
            array('id, member_id,type', 'numerical','integerOnly'=>true),
            array('content', 'length', 'max'=>255),
            array('editor,role', 'length', 'max'=>32),
            array('create_time', 'safe'),
        );
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
	 * custom defined scope
	 * @param  string $order 排序条件
	 * @return object
	 */
	public function orderBy($order = 't.create_time DESC') {

		if (!empty($order)) {
			$this->getDbCriteria()->mergeWith(array('order' => $order));
		}

		return $this;
	}

	/**
	 * 与Smarrty中的文本提示相对应，可以修改成中文提示
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			   'id' => '日志ID',
			   'member_id' => '会员ID',
			   'editor' => '操作人',
			   'role' => '角色',
			   'type' => '操作类型(1:修改信息；2：完善信息；3：注册会员)',
			   'content' => '操作详细说明',
			   'create_time' => '操作时间',
	   );
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SysNode the static model class
	 */
	public static function model($className = __CLASS__) {
			return parent::model($className);
	}
	public function toArray() {
		return OBJTool::convertModelToArray($this);
	}
	
	/**
	 * 根据会员ID查询会员的信息操作日志列表
	 */
	public static function getMemberInfoLog($member_id,$page, $pageSize) {
		if (empty($member_id) || !is_numeric($member_id)) {
			return false;
		}
		
		$arrSqlParam = array(
            'condition' => 'member_id=:mid',
            'params' => array(
                ':mid'		=> $member_id,
                ),
        );

        $count	= self::model()->count($arrSqlParam);
        $list	= self::model()->orderBy()->pagination($page, $pageSize)->findAll($arrSqlParam);
		$list	= OBJTool::convertModelToArray($list);
		$pager	= new CPagination($count);
		$pager->pageSize	= !empty($pageSize)?$pageSize:Yii::app()->params['pageSize'];
		$pager->pageVar		= 'page'; //修改分页参数，默认为page
		$pager->params		= array('type' => 'msg'); //分页中添加其他参数
		$pages	= array(
                    'curPage'	=> $pager->currentPage+1,
                    'totalPage' => ceil($pager->itemCount/$pager->pageSize),
                    'pageSize'	=> $pager->pageSize,
                    'totalCount'=> $pager->itemCount,
                    'url'		=> preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
                );
				
		$list	= self::model()->orderBy()->pagination($pager->currentPage+1, $pager->pageSize)->findAll($arrSqlParam);
		$list	= OBJTool::convertModelToArray($list);		
        $arrRet = array(
            'pages'		=> $pages,
            'pageSize'	=> $pageSize,
            'total'		=> $total,
            'list'		=> $list,
        );
        return $arrRet;
		
	}
      
	/**
     * 添加记录
     */
    public function add($member_id, $editor, $role, $type, $content){

            $this->member_id	= $member_id;
            $this->editor		= $editor;
            $this->role			= $role;
            $this->type			= $type;
            $this->content		= $content;
            $this->create_time	= date("Y-m-d H:i:s",time());
			$result				= array("code"=>1,"msg"=>"操作失败","value"=>"");
			
			//校验参数
            if(!$this->validate()){
				$result['msg']	= "参数错误！";
				$error = $this->getErrors();
				array_shift($error);
				$result['data']	= is_array($error) ? $error[0] : '';
            }
            if($this->save()){
				$result['code']		= 0;
				$result['msg']		= "保存成功！";
            }
			
			return $result;
    }
}
