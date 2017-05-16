<?php
class JdMemberData extends JdMemberDataBase
{

    // default sub_company_id
    const SUB_COMPANY_ID_DEFAULT = 0;
    // default borrow_id
    const SUB_BORROW_ID_DEFAULT = 0;
    
	
    // data_type
    const DATA_TYPE_PERSON              = 1;    // 个人信息
    const DATA_TYPE_JOB                 = 2;    // 职业信息
    const DATA_TYPE_CREDIT              = 3;    // 信用信息

    // data_type2 个人信息
    const DATA_TYPE_PERSON_CIVIL_ID     = 1010;    // 身份证
    const DATA_TYPE_PERSON_CIVIL_ID_A   = 1011;    // 正面
    const DATA_TYPE_PERSON_CIVIL_ID_B   = 1012;    // 反面
    //const DATA_TYPE_PERSON_CIVIL_ID_C   = 1013;    // 手持身份证

    const DATA_TYPE_PERSON_RES_REG      = 1020;    // 户口簿
    const DATA_TYPE_PERSON_RES_REG_A    = 1021;    // 户口簿1
    const DATA_TYPE_PERSON_RES_REG_B    = 1022;    // 户口簿2
    const DATA_TYPE_PERSON_RES_REG_C    = 1023;    // 户口簿3
    const DATA_TYPE_PERSON_RES_REG_D    = 1024;    // 户口簿4
    const DATA_TYPE_PERSON_RES_REG_E    = 1025;    // 户口簿5

    const DATA_TYPE_PERSON_JUZHU      	= 1030;    // 居住证明
    const DATA_TYPE_PERSON_ROOM        	= 1040;    // 房产证
    const DATA_TYPE_PERSON_ZULIN        = 1050;    // 租赁合同
    const DATA_TYPE_PERSON_ZULIN_A      = 1051;    // 租赁合同1
    const DATA_TYPE_PERSON_ZULIN_B      = 1052;    // 租赁合同2
    const DATA_TYPE_PERSON_ZULIN_C      = 1053;    // 租赁合同3

    const DATA_TYPE_PERSON_MARRIAGE_ONA       = 1060;    //
    const DATA_TYPE_PERSON_MARRIAGE_ONA_A     = 1061;    //结婚证1
    const DATA_TYPE_PERSON_MARRIAGE_ONA_B     = 1062;    //结婚证2
    const DATA_TYPE_PERSON_MARRIAGE_ONB       = 1065;    //
    const DATA_TYPE_PERSON_MARRIAGE_ONB_A     = 1066;    //配偶身份证1
    const DATA_TYPE_PERSON_MARRIAGE_ONB_B     = 1067;    //配偶身份证2

    const DATA_TYPE_PERSON_MARRIAGE_OFF       = 1070;    //
    const DATA_TYPE_PERSON_MARRIAGE_OFF_A     = 1071;    //离婚证1
    const DATA_TYPE_PERSON_MARRIAGE_OFF_B     = 1072;    //离婚证2


    // data_type2 职业信息
    const DATA_TYPE_JOB_INCOME          = 2010;    // 收入证明
    const DATA_TYPE_JOB_BANK_SELF            = 2020;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_1            = 2021;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_2            = 2022;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_3            = 2023;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_4            = 2024;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_5            = 2025;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_6            = 2026;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_7            = 2027;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_8            = 2028;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_9            = 2029;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_10            = 2030;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_11            = 2031;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_12            = 2032;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_13            = 2033;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_14            = 2034;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_15            = 2035;    // 银行流水
    const DATA_TYPE_JOB_BANK_SELF_16            = 2036;    // 银行流水

    const DATA_TYPE_JOB_BANK_PARTNER            = 2040;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_1            = 2041;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_2            = 2042;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_3            = 2043;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_4            = 2044;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_5            = 2045;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_6            = 2046;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_7            = 2047;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_8            = 2048;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_9            = 2049;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_10            = 2050;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_11            = 2051;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_12            = 2052;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_13            = 2053;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_14            = 2054;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_15            = 2055;    // 银行流水
    const DATA_TYPE_JOB_BANK_PARTNER_16            = 2056;    // 银行流水

    // data_type2 信用信息
    
    const DATA_TYPE_CREDIT_ONE          = 3010;//人民银行信用报告 本人
    const DATA_TYPE_CREDIT_TWO          = 3020;//人民银行信用报告 配偶

    // audit status
    const AUDIT_STATUS_UNDONE   = 0;    // 未审核
    const AUDIT_STATUS_ALLOW    = 1;    // 审核通过
    const AUDIT_STATUS_DISALLOW = 2;    // 审核不通过

    static public $DATA_TYPE_QUA_ARR = array(
        self::DATA_TYPE_PERSON_CIVIL_ID  => array(
            'name'=>'身份证',
            'desc'=>'',
            //'desc'=>'身份证正背面、手持身份证照片，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_PERSON_CIVIL_ID_A=>array('name'=>'正面','desc'=>'','isMust'=>1,),
                self::DATA_TYPE_PERSON_CIVIL_ID_B=>array('name'=>'反面','desc'=>'','isMust'=>1,),
                //self::DATA_TYPE_PERSON_CIVIL_ID_C=>array('name'=>'手持身份证','desc'=>'','isMust'=>1,),
            ),
        ),
    	self::DATA_TYPE_PERSON_RES_REG  => array(
    		'name'=>'户口簿',
    		'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_PERSON_RES_REG_A=>array('name'=>'户口簿1','desc'=>'','isMust'=>1,),
                self::DATA_TYPE_PERSON_RES_REG_B=>array('name'=>'户口簿2','desc'=>'(可选)'),
                self::DATA_TYPE_PERSON_RES_REG_C=>array('name'=>'户口簿3','desc'=>'(可选)'),
                self::DATA_TYPE_PERSON_RES_REG_D=>array('name'=>'户口簿4','desc'=>'(可选)'),
                self::DATA_TYPE_PERSON_RES_REG_E=>array('name'=>'户口簿5','desc'=>'(可选)'),
            ),
    	),
        self::DATA_TYPE_PERSON_JUZHU  => array(
            'name'=>'居住证明',
            'desc'=>'以下居住证明、房产证、房屋租赁合同三选一。',
            'sub'=>array(
                self::DATA_TYPE_PERSON_JUZHU=>array('name'=>'居住证','desc'=>''),
            ),
        ),
        self::DATA_TYPE_PERSON_ROOM  => array(
            'name'=>'房产证',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_PERSON_ROOM=>array('name'=>'房产证','desc'=>''),
            ),
        ),
        self::DATA_TYPE_PERSON_ZULIN  => array(
            'name'=>'租赁合同',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_PERSON_ZULIN_A=>array('name'=>'租赁合同1','desc'=>''),
                self::DATA_TYPE_PERSON_ZULIN_B=>array('name'=>'租赁合同2','desc'=>''),
                self::DATA_TYPE_PERSON_ZULIN_C=>array('name'=>'租赁合同3','desc'=>''),
            ),
        ),
        self::DATA_TYPE_PERSON_MARRIAGE_ONA  => array(
            'name'=>'结婚证',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_PERSON_MARRIAGE_ONA_A=>array('name'=>'结婚证主页','desc'=>''),
                self::DATA_TYPE_PERSON_MARRIAGE_ONA_B=>array('name'=>'本人页','desc'=>''),
            ),
        ),
        self::DATA_TYPE_PERSON_MARRIAGE_ONB  => array(
            'name'=>'配偶身份证',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_PERSON_MARRIAGE_ONB_A=>array('name'=>'正面','desc'=>''),
                self::DATA_TYPE_PERSON_MARRIAGE_ONB_B=>array('name'=>'反面','desc'=>''),
            ),
        ),
        self::DATA_TYPE_PERSON_MARRIAGE_OFF  => array(
            'name'=>'离婚证',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_PERSON_MARRIAGE_OFF_A=>array('name'=>'离婚证主页','desc'=>''),
                self::DATA_TYPE_PERSON_MARRIAGE_OFF_B=>array('name'=>'本人页','desc'=>''),
            ),
        ),

      
    );

    static public $DATA_TYPE_FIN_ARR = array(
        
        self::DATA_TYPE_JOB_INCOME  => array(
            'name'=>'收入证明',
            'desc'=>'证明中应包括本人姓名、身份证号、入职时间、职务、收入、用人单位人事或财务部门的联系人姓名、联系电话，且印章清晰。 支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_JOB_INCOME=>array('name'=>'收入证明','desc'=>'','isMust'=>1,),
            ),
        ),
        //self::DATA_TYPE_INCOME                 => array(
        //    'name'=>'收入证明',
        //    'desc'=>'上传公司近半年完税证明，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
        //),
    	self::DATA_TYPE_JOB_BANK_SELF           => array(
    		'name'=>'本人银行流水',
    		'desc'=>'请上传工资卡近半年内流水，必须是距提交日一个月内打印，已婚客户需上传配偶银行流水，内容清晰可见，支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_JOB_BANK_SELF_1=>array('name'=>'银行流水','desc'=>'','isMust'=>1),
                self::DATA_TYPE_JOB_BANK_SELF_2=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_3=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_4=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_5=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_6=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_7=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_8=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_9=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_10=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_11=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_12=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_13=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_14=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_15=>array('name'=>'银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_SELF_16=>array('name'=>'银行流水','desc'=>''),
            ),
    	),

        self::DATA_TYPE_JOB_BANK_PARTNER           => array(
            'name'=>'配偶银行流水',
            'desc'=>'请上传工资卡近半年内流水，必须是距提交日一个月内打印，已婚客户需上传配偶银行流水，内容清晰可见，支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_JOB_BANK_PARTNER_1=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_2=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_3=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_4=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_5=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_6=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_7=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_8=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_9=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_10=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_11=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_12=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_13=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_14=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_15=>array('name'=>'配偶银行流水','desc'=>''),
                self::DATA_TYPE_JOB_BANK_PARTNER_16=>array('name'=>'配偶银行流水','desc'=>''),
            ),
        ),

    );

    static public $DATA_TYPE_COR_ARR = array(
       
       self::DATA_TYPE_CREDIT_ONE        => array(
            'name'=>'本人征信报告',
            'desc'=>'请上传由中国人民银行出具，反映个人信用基本状况的文件，支持PDF格式。',
            'sub'=>array(
                self::DATA_TYPE_CREDIT_ONE=>array('name'=>'信用报告','desc'=>'','isMust'=>1,),
            ),
            
        ),

        self::DATA_TYPE_CREDIT_TWO        => array(
            'name'=>'配偶征信报告',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_CREDIT_TWO=>array('name'=>'信用报告','desc'=>''),
            ),

        ),

       
    );

        /**
         * @return array validation rules for model attributes.
         */
        public function rules() {
                //新增的在这里面加，如果修改 需要修改父类中的Rules
                $curRules = array(
                );
                return array_merge(parent::rules(), $curRules);
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
         * @param  integer $limit 数量
         * @return object
         */
        public function recently($limit = 5) {

            $this->getDbCriteria()->mergeWith(array('order' => 't.last_modified DESC', 'limit' => $limit));

            return $this;
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
        public function mySearch()
        {
               // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                $criteria->with = array('author','borrow');
                $criteria->group = 't.member_id';
                $criteria->order = 't.id desc';
                $criteria->compare('t.id',$_GET['memberinfo']['id']);
                $criteria->compare('author.member_fullname',$_GET['memberinfo']['member_fullname'],true);
                $criteria->compare('author.member_id_number',$_GET['memberinfo']['member_id_number'],true);
                $criteria->compare('author.member_mobile',$_GET['memberinfo']['member_mobile'],true);
                $criteria->compare('borrow.borrow_name',$_GET['memberinfo']['borrow_name'],true);
                
                //}
                
              	//$criteria->condition .= "author.member_fullname='123123'";
              	//$criteria->condition .= " and borrow.borrow_name='上影安吉影视产业园唐韵组团A11地块7号1103aa'";
                //$criteria->compare('member_fullname',$_GET['memberinfo']['member_fullname'],true);
               /*  if($_GET['memberinfo']['member_fullname']) {
                	
                } */
                //为$criteria新增设置
                //$criteria->select = 't.*,uc_member.member_fullname';
                //$criteria->join = "JOIN uc_member on t.member_id=uc_member.member_id";
                //$criteria->condition = "idc_user.idc_id=$idc_id";
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->findAll($criteria);//var_dump($list);
                //$list = $this->findAll($criteria);var_dump($list);

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
         * @return JdCompanyData the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        
    public static function getDataType() {
        return array(
            self::DATA_TYPE_PERSON,
            self::DATA_TYPE_JOB,
            self::DATA_TYPE_CREDIT,
        );
        
    }
    public static function getDataTypeArr() {
        return array(
            self::DATA_TYPE_PERSON  =>'个人信息',
            self::DATA_TYPE_JOB     =>'职业信息',
            self::DATA_TYPE_CREDIT  =>'信用信息',
        );
        
    }
    public static function getDataType2($dataType) {
        switch ($dataType) {
            case self::DATA_TYPE_PERSON:
                return self::$DATA_TYPE_QUA_ARR;
            case self::DATA_TYPE_JOB:
                return self::$DATA_TYPE_FIN_ARR;
            case self::DATA_TYPE_CREDIT:
                return self::$DATA_TYPE_COR_ARR;
        }
        return array();
    }
    public static function getDataTypeDesc($dataType) {
        $desc = '';
        switch ($dataType) {
            case self::DATA_TYPE_PERSON:
                $desc = '个人信息';
                break;
            case self::DATA_TYPE_JOB:
                $desc = '职业信息';
                break;
            case self::DATA_TYPE_CREDIT:
                $desc = '信用信息';
                break;
        }
        return $desc;
    }
    public static function getDataType2Desc($dataType2) {
        $desc = '';
        $dataType = (int)($dataType2 / 1000);
        $dataType2Arr = self::getDataType2($dataType);
        foreach ($dataType2Arr as $key=>$val) {
            if ($key == $dataType2) {
                $desc = $val['name'];
                break;
            }
            if (isset($val['sub']) && !empty($val['sub'])) {
                foreach ($val['sub'] as $skey=>$sval) {
                    if ($skey == $dataType2) {
                        $desc = $val['name'].$sval['name'];
                        break;
                    }
                }
            }
        }
        return $desc;
    }
    public static function showlist($member_id) {
    	foreach(JdMemberData::$DATA_TYPE_QUA_ARR as $k=>$v) {
    		$arr[$k]['name'] = $v['name'];
    		$arr[$k]['id'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->id;
    		$arr[$k]['file_path'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->file_path;
    		$arr[$k]['audit_status'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->audit_status;
    	}
    	foreach(JdMemberData::$DATA_TYPE_FIN_ARR as $k=>$v) {
    		$arr[$k]['name'] = $v['name'];
    		$arr[$k]['id'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->id;
    		$arr[$k]['file_path'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->file_path;
    		$arr[$k]['audit_status'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->audit_status;
    	}
    	foreach(JdMemberData::$DATA_TYPE_COR_ARR as $k=>$v) {
    		$arr[$k]['name'] = $v['name'];
    		$arr[$k]['id'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->id;
    		$arr[$k]['file_path'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->file_path;
    		$arr[$k]['audit_status'] = JdMemberData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->audit_status;
    	}
    	return $arr;
    }
    public static function getRealPath($pathInDb, $func=null) {
        if (empty($pathInDb)) {
            return false;
        }

        $realPath = dirname(Yii::app()->BasePath).$pathInDb;
        if (function_exists($func)) {
            $func($realPath);
        }
        return $realPath;
    }
    public static function removeDataFromFs($pathInDb) {
        //$pathInDb = '/upload/201511/720x500/201511040256161446602176379.png';
        return self::getRealPath($pathInDb, 'unlink');
    }
    public static function calcListByType($memberId, $columnType = 'member_id') {
        if (!$memberId) {
            return false;
        }
        if ($columnType!='member_id' && $columnType!='work_order_id') {
            $columnType = 'member_id';
            //return false;
        }
        $uploadedData = JdMemberData::model()->findAll($columnType.'=:member_id', array(':member_id'=>$memberId));
        $uploadedData = OBJTool::convertModelToArray($uploadedData);
        $dataTypeArr = JdMemberData::getDataType();
        $dataTypeCalcArr = array();

        foreach ($dataTypeArr as $dataType) {
            
            $dataType2Arr = JdMemberData::getDataType2($dataType);


            $allNum = 0;
            $needNum = 0;
            $uploadedNum = 0;
            $needUpedNum = 0;
            $needAuditOkNum = 0;
            $auditOkNum = 0;
            $auditDisNum = 0;
            $auditRemark = '';
            if (!empty($uploadedData) && !empty($dataType2Arr))
            foreach ($dataType2Arr as $k=>$v) {
                if (isset($v['sub']) && !empty($v['sub'])) {
                    foreach ($v['sub'] as $sk=>$sv) {
                        ++$allNum;
                        $needNum += $sv['isMust'];
                        foreach ($uploadedData as $ck=>$cv) {
                            if ($cv['data_type2'] == $sk) {
                                $dataType2Arr[$k]['sub'][$sk]['files'][] = $cv;
                                ++$uploadedNum;
                                $needUpedNum += $sv['isMust'];
                                $auditOkNum += $cv['audit_status'] == JdMemberData::AUDIT_STATUS_ALLOW ? 1 : 0;
                                $auditDisNum += $cv['audit_status'] == JdMemberData::AUDIT_STATUS_DISALLOW ? 1 : 0;
                                $needAuditOkNum += ($sv['isMust'] && $cv['audit_status'] == JdMemberData::AUDIT_STATUS_ALLOW) ? 1 : 0;
                                $auditRemark = $cv['audit_remark'];
                            }
                        }
                    }
                } else {
                    $needNum += $v['isMust'];
                    foreach ($uploadedData as $ck=>$cv) {
                        if ($cv['data_type2'] == $k) {
                            $dataType2Arr[$k]['files'][] = $cv;
                            ++$uploadedNum;
                            $needUpedNum += $v['isMust'];
                            $auditOkNum += $cv['audit_status'] == JdMemberData::AUDIT_STATUS_ALLOW ? 1 : 0;
                            $auditDisNum += $cv['audit_status'] == JdMemberData::AUDIT_STATUS_DISALLOW ? 1 : 0;
                            $needAuditOkNum += ($v['isMust'] && $cv['audit_status'] == JdMemberData::AUDIT_STATUS_ALLOW) ? 1 : 0;
                            $auditRemark = $cv['audit_remark'];
                        }
                    }
                }
            }
            $dataTypeCalcArr[$dataType] = array(
                'calcList'=>$dataType2Arr,
                'allNum'=>$allNum,
                'needNum'=>$needNum ? $needNum : 1,
                'uploadedNum'=>$uploadedNum,
                'needUpedNum'=>$needUpedNum,
                'auditOkNum'=>$auditOkNum,
                'auditDisNum'=>$auditDisNum,
                'isAuditable'=>$needNum==$needUpedNum,
                'isAuditOk'=>$auditOkNum==$needNum,
                'needAuditOkNum'=>$needAuditOkNum,
                'auditRemark'=>$auditRemark,
            );
            
        }
        return $dataTypeCalcArr;
    }
    static public function calcListAllType($memberId) {
        $arr = self::calcListByType($memberId);
        $ret = array();
        $allNeedNum = 0;
        $allNeedUpedNum = 0;
        $allAuditOkNum = 0;
        $allAuditDisNum = 0;
        $allNeedAuditOkNum = 0;
        foreach ($arr as $dataType1=>$v) {
            $allNeedNum += $v['needNum'];
            $allNeedUpedNum += $v['needUpedNum'];
            $allAuditDisNum += $v['auditDisNum'];
            $allAuditOkNum += $v['auditOkNum'];
            $allNeedAuditOkNum += $v['needAuditOkNum'];
        }
        return array(
            'calcList'=>$arr,
            'allNeedNum'        => $allNeedNum,
            'allNeedUpedNum'    => $allNeedUpedNum,
            'allAuditOkNum'     => $allAuditOkNum,
            'allAuditDisNum'    => $allAuditDisNum,
            'allNeedAuditOkNum' => $allNeedAuditOkNum,
            
        );
    }
    static public function getNeedNum($dataType=0) {
        $dataType2Arr = array();
        $dataTypeArr = self::getDataType();
        if ($dataType == 0) {
            
            foreach ($dataTypeArr as $dataType1) {
                $dataType2Arr[] = self::getDataType2($dataType1);
            }
        } else {
            $dataType2Arr[] = self::getDataType2($dataType);
        }
        $needNum = 0;
        foreach ($dataType2Arr as $dataType1=>$arr) {
            foreach ($arr as $k=>$v) {
                if (isset($v['sub'])) {
                    foreach ($v['sub'] as $sk=>$sv) {
                        if ($sv['isMust']) {
                            ++$needNum;
                        }
                    }
                } else {
                    if ($v['isMust']) {
                        ++$needNum;
                    }
                }
            }
        }
        return $needNum;
    }
}
