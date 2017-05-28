<?php
class UcMember extends UcMemberBase
{

    const MEMBER_FROM_XQSJ_PCREG    = '2';  // PC注册
    const MEMBER_FROM_XQSJ_MREG     = '3';  // M站注册
    const MEMBER_FROM_XQSJ_APPREG   = '4';  // APP注册
    const MEMBER_FROM_FANGHU_REG    = '11'; // Xahoo注册
    const MEMBER_FROM_FANGHU_INVITE = '12'; // Xahoo邀请注册
    const MEMBER_FROM_WX_FANGHU     = '21'; // 关注Xahoo公众号的 属于临时账号 不显示
    static $ARR_MEMBER_FROM = [
        self::MEMBER_FROM_XQSJ_PCREG    => '新奇世界PC',
        self::MEMBER_FROM_XQSJ_MREG     => '新奇世界M站', 
        self::MEMBER_FROM_XQSJ_APPREG   => '新奇世界APP', 
        self::MEMBER_FROM_FANGHU_REG    => 'Xahoo注册',
        self::MEMBER_FROM_FANGHU_INVITE => 'Xahoo邀请',
        //self::MEMBER_FROM_WX_FANGHU     => '临时用户(作废)',
    ];
    
    const STATUS_VALID      = 1;    // 有效
    const STATUS_DELETED    = 99;   // 删除
    static $ARR_STATUS = [
        self::STATUS_VALID  => '有效',
        self::STATUS_DELETED=> '删除',
    ];

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		//新增的在这里面加，如果修改 需要修改父类中的Rule
		$curRules = array(
		);
		return array_merge(parent::rules(), $curRules);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		$curRelations = array(
            'member_total' => array(self::HAS_ONE, 'MemberTotalModel', '', 'on' => 'member_total.member_id=t.member_id and member_total.accounts_id=1'),
		);
		return array_merge(parent::relations(), $curRelations);
	}

    /**
     * custom defined scope
     * @param  string $order 排序条件
     * @return object
     */
    public function orderBy($order = 't.last_modified DESC') {

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
		$curLables = array(
		);
		return array_merge(parent::attributeLabels(), $curLables);
	}
	public function mySearch($condition = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = $this->getBaseCDbCriteria();

        if(isset($condition['start_time']))
        {
            $criteria->addCondition(" t.create_time >= '{$condition['start_time']}'");
        }
        if(isset($condition['end_time']))
        {
            $criteria->addCondition(" t.create_time <= '{$condition['end_time']}'");
        }
        // 不包含临时用户
        $criteria->addCondition(" t.member_mobile != ''");
        //$criteria->addCondition(" t.member_from != '".self::MEMBER_FROM_WX_FANGHU."'");
        
		//为$criteria新增设置
		$count = $this->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
		$pager->pageVar = 'page'; //修改分页参数，默认为page
		$pager->params = array('type' => 'msg'); //分页中添加其他参数
		$pager->applyLimit($criteria);
		$list = $this->orderBy('t.member_id desc')->findAll($criteria);
		$pages = array(
                    'curPage' => $pager->currentPage+1,
                    'totalPage' => ceil($pager->itemCount/$pager->pageSize),
                    'pageSize' => $pager->pageSize,
                    'totalCount'=>$pager->itemCount,
                    'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
		);
		return array('pages' => $pages, 'list' => $list);
	}
	public function mySearchForReport($condition = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = $this->getBaseCDbCriteria();
        $criteria->with = ['member_total'];

        if(isset($condition['start_time']))
        {
            $criteria->addCondition(" t.create_time >= '{$condition['start_time']}'");
        }
        if(isset($condition['end_time']))
        {
            $criteria->addCondition(" t.create_time <= '{$condition['end_time']}'");
        }
        // 不包含临时用户
        $criteria->addCondition(" t.member_mobile != ''");
        //$criteria->addCondition(" t.member_from != '".self::MEMBER_FROM_WX_FANGHU."'");
        
		//为$criteria新增设置
		$count = $this->count($criteria);
		$pager = new CPagination($count);
		$pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
		$pager->pageVar = 'page'; //修改分页参数，默认为page
		$pager->params = array('type' => 'msg'); //分页中添加其他参数
		$pager->applyLimit($criteria);
		$list = $this->orderBy('t.member_id desc')->findAll($criteria);
		$pages = array(
                    'curPage' => $pager->currentPage+1,
                    'totalPage' => ceil($pager->itemCount/$pager->pageSize),
                    'pageSize' => $pager->pageSize,
                    'totalCount'=>$pager->itemCount,
                    'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
		);
		return array('pages' => $pages, 'list' => $list);
	}
	public function mySearchForReport2($condition=array(), $pageNo=1, $pageSize=10)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
        $sql = 'select u.member_id,u.member_mobile,u.member_fullname,t.points_total,t.points_gain,t.points_consume,t.level,t.money_total,t.money_gain,t.money_withdraw,u.status,u.member_from,u.create_time,u.fh_last_login from xqsj_db.uc_member u left join fh_member_total t on t.member_id=u.member_id where u.member_mobile !=""';
        $where = '';
        $orderBy = ' order by t.points_total desc,u.member_id';
        if(isset($condition['start_time'])) {
            $where .= " and u.create_time >= '{$condition['start_time']}'";
        }
        if(isset($condition['end_time'])) {
            $where .= " and u.create_time <= '{$condition['end_time']}'";
        }
        if(isset($condition['order_by'])) {
            $orderBy = ' order by '.$condition['order_by'].' ';
            //print_r($condition['order_by']);exit;
        }
        //print_r($orderBy);exit;
        $limit = ' limit '.(($pageNo-1)*$pageSize).','.$pageSize;
        //$sql .= ' limit '.$limit;

        $sqlCount = 'select count(u.member_id) cnt, sum(t.points_total) points_total, sum(t.points_gain) points_gain,sum(t.points_consume) points_consume,sum(t.money_total) money_total,sum(t.money_gain) money_gain,sum(t.money_withdraw) money_withdraw from xqsj_db.uc_member u left join fh_member_total t on t.member_id=u.member_id where u.member_mobile !=""';
        
        $cnt = Yii::app()->db->createCommand($sqlCount.$where)
            ->queryAll();
        //print_r($cnt);exit;
        //print_r($sql.$where.$orderBy);print_r($condition);exit;
        $list = Yii::app()->db->createCommand($sql.$where.$orderBy.$limit)
            ->queryAll();
        

		$pages = array(
                    'curPage' => $pageNo,
                    'totalPage' => ceil($cnt[0]['cnt']/$pageSize),
                    'pageSize' => $pageSize,
                    'totalCount'=>$cnt[0]['cnt'],
                    'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
		);
		return array('pages' => $pages, 'list' => $list, 'totalInfo' => $cnt[0]);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your UCenterActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UcMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	/**
	 * 插入数据前对身份证号进行加密
	 */
	public function beforesave(){

        parent::beforesave();

		if(trim($this->member_id_number)!=""){
			$AresObj = new AresCryptDes(DES_KEY);
			$this->member_id_number = $AresObj->encrypt($this->member_id_number);
		}
		return true ;

	}

	/**
	 * 查出数据后对数据身份证号进行解密
	 */
	public function afterfind(){
        parent::afterfind();
		!defined('DES_KEY')?define('DES_KEY', ''):'';
		if($this->member_id_number!=""){
			$AresObj = new AresCryptDes(DES_KEY);
			$result = $AresObj->decrypt($this->member_id_number);
			if($result){
				$this->member_id_number = $result ;
			}

		}
		return true ;

	}
}
