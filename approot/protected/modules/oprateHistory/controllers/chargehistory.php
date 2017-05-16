<?php
//https://itest.xqshijie.com/xqsjadmin.php?r=history/default
class chargehistory extends chargeInterface
{
    /**
     * 构建
     */
    public function __construct(){}
	
    /**
     * 测试
     */
    public function test(){
        echo 'test pass<br/>';
        var_dump(parent::$OpType);
        die;
    }
    /**
     * 后台插入opHistory记录 YII外接
     * @param type $opTypeId 操作ID 对应字典
     * @param type $needStr 操作补充串 金额，可留空
     * @param type $orderId 操作订单ID
     * @param type $status 操作订单的状态值
     * @return boolean 
     */
    public function insertApi($opTypeId,$needStr = '',$orderId,$status = '1'){
        $roleId = Yii::app()->adminUser->getRole();
        $roleName = SysRole::model()->find("id='".$roleId."'");//obj
        
        $userId = Yii::app()->adminUser->id;
        $userName = Yii::app()->adminUser->name;
        
        $opType = parent::$OpType;
        $opTypeDetail = parent::$OpTypeDetail;

        $opTypeId = $opTypeId;//need opType 
        if(empty($opTypeId))return true;
        $needStr = $needStr;
        $opHistoryObj = new OpHistory;
        $opHistoryObj->orderId       = $orderId;
        $opHistoryObj->userId       = $userId;
        $opHistoryObj->userName     = $userName;
        $opHistoryObj->roleId       = $roleId;
        $opHistoryObj->roleName     = $roleName->name;
        $opHistoryObj->status       = $status;//need
        $opHistoryObj->opType       = $opTypeId;//need
        $opHistoryObj->opTypeName   = $opType[$opTypeId];//need
        $opHistoryObj->remark       = $opTypeDetail[$opTypeId].$needStr;//need
        $bool = $opHistoryObj->save();
        return $bool;
    }
    /**
     * 前台插入订单历史接口
     * @param type $opTypeId
     * @param type $needStr
     * @param type $orderId
     * @return boolean
     */
    public function insertApiUser($opTypeId,$needStr = '',$orderId){
        
        $userId = Yii::app()->loginUser->getUserId();
        //telephone
//        $userName = Yii::app()->loginUser->getUserName();
//        member_fullname
//        $userName = Yii::app()->loginUser->getUserInfo();
        $userInfo = UcMember::model()->find("member_id = '".$userId."'");
        
        $userName = $userInfo->member_fullname;
//        var_dump($userName);
//        die;
        $opType = parent::$OpType;
        $opTypeDetail = parent::$OpTypeDetail;

        $opTypeId = $opTypeId;//need opType 
        if(empty($opTypeId))return true;
        $needStr = $needStr;
        $opHistoryObj = new OpHistory;
        $opHistoryObj->orderId       = $orderId;
        $opHistoryObj->userId       = $userId;
        $opHistoryObj->userName     = $userName;
        $opHistoryObj->roleId       = '0';
        $opHistoryObj->roleName     = '';
        $opHistoryObj->opType       = $opTypeId;//need
        $opHistoryObj->opTypeName   = $opType[$opTypeId];//need
        $opHistoryObj->remark       = $opTypeDetail[$opTypeId].$needStr;//need
        $bool = $opHistoryObj->save();
        
        return $bool;
    }
    /**
     * 查询opHistory记录 列表接口--做测试用
     * @param type $search 预留查询条件
     * @param type $page_size 分页器参数
     * @param type $page_no 分页器参数
     * @return type 返回数据组
     */
    public function searchApi($search = array(),$page_size,$page_no){
        $condition ='';
        if($search['orderId']){ $condition.=" and t.orderId = '".$search['orderId']."'"; }
        
        $condition = array(
                'condition'=>' 1=1 '.$condition,
                'order' => 't.id desc',
                );

        $total = OpHistory::model()->count($condition);
        $list=OpHistory::model()->pagination($page_no, $page_size)->findAll($condition);
        $returnArr=array(
	        "list"=>$list,
	        "total"=>$total,
	        "page_size"=>$page_size,
	        "page_no"=>$page_no
	    );
        return $returnArr;
    }
    /**
     * 查询单个订单的
     * @param type $search 预留查询条件
     * @param type $orderId 订单ID
     * @return type
     */
    public function searchOrderApi($orderId){
        $condition ='';
        $condition = array(
                'condition'=>"t.orderId='{$orderId}'".$condition,
                'order' => 't.id desc',
                );
        $list=OpHistory::model()->findAll($condition);
       
        return $list;
    }
   
}