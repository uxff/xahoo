<?php
class JdCompanyData extends JdCompanyDataBase
{

    // default sub_company_id
    const SUB_COMPANY_ID_DEFAULT = 0;
    // default borrow_id
    const SUB_BORROW_ID_DEFAULT = 0;
    
	
    // data_type
    const DATA_TYPE_QUALIFICATION   = 1;    // 公司资质
    const DATA_TYPE_FINANCE         = 2;    // 财务信息
    const DATA_TYPE_CORPORATION     = 3;    // 法人资料

    // data_type2 qualification
    const DATA_TYPE_QUA_LICENCE                 = 1010;    // 营业执照
    const DATA_TYPE_QUA_ORG_CODE                = 1020;    // 组织机构代码证
    const DATA_TYPE_QUA_TAX_REG                 = 1040;    // 税务登记证
    const DATA_TYPE_QUA_BY_LOWS                 = 1050;    // 公司章程
    const DATA_TYPE_QUA_FIELD                   = 1060;    // 经营场地证明

    // data_type2 finance
    const DATA_TYPE_FIN_ACC_LIC                 = 2010;    // 基本账户开户许可证
    const DATA_TYPE_FIN_VERI_REPORT             = 2020;    // 企业验资报告
    const DATA_TYPE_FIN_STATEMENT               = 2030;    // 财务报表
    const DATA_TYPE_FIN_STATEMENT_3YEAR         = 2031;    //   近三年年报 + 近三个月的财务报表
    const DATA_TYPE_FIN_STATEMENT_3MONTH        = 2032;    
    const DATA_TYPE_FIN_TAX                     = 2040;    // 完税证明
    const DATA_TYPE_FIN_TAX_PAID_BUSINESS       = 2041;    //   营业税 + 增值税 + 所得税
    const DATA_TYPE_FIN_TAX_ADDED_VALUE         = 2042;    
    const DATA_TYPE_FIN_TAX_INCOME              = 2043;    
    const DATA_TYPE_FIN_TAX_RETURN              = 2050;    // 纳税申报表
    const DATA_TYPE_FIN_TAX_RETURN_LASTYEAR     = 2051;    //   上一年 + 近一期
    const DATA_TYPE_FIN_TAX_RETURN_RECENT       = 2052;    
    const DATA_TYPE_FIN_BANK_STATEMENT          = 2060;    // 银行对账单

    // data_type2 corporation
    const DATA_TYPE_COR_CIVIL_ID                = 3010;    // 身份认证
    const DATA_TYPE_COR_CIVIL_ID_A              = 3011;    //   正面 + 反面
    const DATA_TYPE_COR_CIVIL_ID_B              = 3012;    
    const DATA_TYPE_COR_SPOUSE_CIVIL_ID         = 3020;    // 配偶身份认证
    const DATA_TYPE_COR_SPOUSE_CIVIL_ID_A       = 3021;    //   正面 + 反面
    const DATA_TYPE_COR_SPOUSE_CIVIL_ID_B       = 3022;    
    const DATA_TYPE_COR_MARRIAGE_CERT           = 3030;    // 结婚证
    const DATA_TYPE_COR_RES_REG                 = 3040;    // 户口簿
    const DATA_TYPE_COR_RES_REG_MAIN            = 3041;    //   簿主页、索引页、法定代表人页、配偶页
    const DATA_TYPE_COR_RES_REG_INDEX           = 3042;    
    const DATA_TYPE_COR_RES_REG_REPRE           = 3043;    
    const DATA_TYPE_COR_RES_REG_SPOUSE          = 3044;    
    const DATA_TYPE_COR_AC_CIVIL_ID             = 3110;    // 实际控制人身份认证
    const DATA_TYPE_COR_AC_CIVIL_ID_A           = 3111;    //   正面 + 反面
    const DATA_TYPE_COR_AC_CIVIL_ID_B           = 3112;    
    const DATA_TYPE_COR_AC_SPOUSE_CIVIL_ID      = 3120;    // 实际控制人配偶身份认证
    const DATA_TYPE_COR_AC_SPOUSE_CIVIL_ID_A    = 3121;    //  正面 + 反面
    const DATA_TYPE_COR_AC_SPOUSE_CIVIL_ID_B    = 3122;    
    const DATA_TYPE_COR_AC_MARRIAGE_CERT        = 3130;    // 实际控制人结婚证
    const DATA_TYPE_COR_AC_RES_REG              = 3140;    // 实际控制人户口簿
    const DATA_TYPE_COR_AC_RES_REG_MAIN         = 3141;    //   簿主页、索引页、法定代表人页、配偶页
    const DATA_TYPE_COR_AC_RES_REG_INDEX        = 3142;    
    const DATA_TYPE_COR_AC_RES_REG_REPRE        = 3143;    
    const DATA_TYPE_COR_AC_RES_REG_SPOUSE       = 3144;    

    // audit status
    const AUDIT_STATUS_UNDONE   = 0;    // 未审核
    const AUDIT_STATUS_ALLOW    = 1;    // 审核通过
    const AUDIT_STATUS_DISALLOW = 2;    // 审核不通过

    static public $DATA_TYPE_QUA_ARR = array(
        self::DATA_TYPE_QUA_LICENCE  => array(
            'name'=>'营业执照',      
            'desc'=>'基本账户开户许可证复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
        self::DATA_TYPE_QUA_ORG_CODE => array(
            'name'=>'组织机构代码证','desc'=>'组织机构代码复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
        self::DATA_TYPE_QUA_TAX_REG  => array(
            'name'=>'税务登记证',    'desc'=>'税务登记证副本复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
        self::DATA_TYPE_QUA_BY_LOWS  => array(
            'name'=>'公司章程',      'desc'=>'公司章程（盖章版），内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
        self::DATA_TYPE_QUA_FIELD    => array(
            'name'=>'经营场地证明',
            'desc'=>'租赁合同或经营场地房产证，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
    );

    static public $DATA_TYPE_FIN_ARR = array(
        self::DATA_TYPE_FIN_ACC_LIC             => array(
            'name'=>'基本账户开户许可证',
            'desc'=>'基本账户开户许可证复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
        self::DATA_TYPE_FIN_VERI_REPORT         => array(
            'name'=>'验资报告',
            'desc'=>'上传企业验资报告，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
        self::DATA_TYPE_FIN_STATEMENT           => array(
            'name'=>'财务报表', '',
            'desc'=>'上传近三年年报、及近三个月的财务报表，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'sub'=>array(
                self::DATA_TYPE_FIN_STATEMENT_3YEAR     => array(
                    'name'=>'近三年年报', '',
                    'desc'=>'',
                    'isMust'=>1,
                    ),
                self::DATA_TYPE_FIN_STATEMENT_3MONTH    => array(
                    'name'=>'近三个月的财务报表',
                    'desc'=>'',
                    'isMust'=>1,
                    ),
                ),
        ),
        self::DATA_TYPE_FIN_TAX                 => array(
            'name'=>'完税证明',
            'desc'=>'上传公司近半年完税证明，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'sub'=>array(
                self::DATA_TYPE_FIN_TAX_PAID_BUSINESS   => array(
                    'name'=>'营业税',
                    'desc'=>'',
                    'isMust'=>1,
                ),
                self::DATA_TYPE_FIN_TAX_ADDED_VALUE     => array(
                    'name'=>'增值税',
                    'desc'=>'',
                    'isMust'=>1,
                ),
                self::DATA_TYPE_FIN_TAX_INCOME          => array(
                    'name'=>'所得税',
                    'desc'=>'',
                    'isMust'=>1,
                ),
            ),
        ),
        self::DATA_TYPE_FIN_TAX_RETURN => array(
            'name'=>'纳税申报表',
            'desc'=>'',
            'sub'=>array(
                self::DATA_TYPE_FIN_TAX_RETURN_LASTYEAR => array(
                    'name'=>'上一年纳税申报表',
                    'desc'=>'',
                    'isMust'=>1,
                ),
                self::DATA_TYPE_FIN_TAX_RETURN_RECENT   => array(
                    'name'=>'近一期纳税申报表',
                    'desc'=>'',
                    'isMust'=>1,
                ),
            ),
        ),
        self::DATA_TYPE_FIN_BANK_STATEMENT      => array(
            'name'=>'银行对账单',
            'desc'=>'上传公司主要结算账户6个月的银行对账单，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小.',
            'isMust'=>1,
        ),
    );

    static public $DATA_TYPE_COR_ARR = array(
        self::DATA_TYPE_COR_CIVIL_ID             => array(
            'name'=>'身份认证',
            'desc'=>'上传法定代表人身份证正背面，，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_COR_CIVIL_ID_A           => array(
                    'name'=>'正面',
                    'desc'=>'',
                    'isMust'=>1,
                ),
                self::DATA_TYPE_COR_CIVIL_ID_B           => array(
                    'name'=>'反面',
                    'desc'=>'',
                    'isMust'=>1,
                ),
            ),
        ),
        self::DATA_TYPE_COR_SPOUSE_CIVIL_ID      => array(
            'name'=>'配偶身份认证',
            'desc'=>'上传法定代表人配偶身份证正背面，，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_COR_SPOUSE_CIVIL_ID_A    => array(
                    'name'=>'正面',
                    'desc'=>'',
                    'isMust'=>1,
                ),
                self::DATA_TYPE_COR_SPOUSE_CIVIL_ID_B    => array(
                    'name'=>'反面',
                    'desc'=>'',
                    'isMust'=>1,
                ),
            ),
        ),
        self::DATA_TYPE_COR_MARRIAGE_CERT        => array(
            'name'=>'结婚证',
            'desc'=>'上传法定代表人结婚证复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
            ),
            'isMust'=>1,
        ),
        self::DATA_TYPE_COR_RES_REG              => array(
            'name'=>'户口簿',
            'desc'=>'上传法定代表人户口簿主页、索引页、法定代表人页、配偶页的复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_COR_RES_REG_MAIN         => array(
                    'name'=>'主页',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_RES_REG_INDEX        => array(
                    'name'=>'索引页',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_RES_REG_REPRE        => array(
                    'name'=>'法定代表人页',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_RES_REG_SPOUSE       => array(
                    'name'=>'配偶页的复印件',
                    'desc'=>'',
                ),
            ),
            'isMust'=>1,
        ),
        self::DATA_TYPE_COR_AC_CIVIL_ID          => array(
            'name'=>'实际控制人身份认证',
            'desc'=>'上传法定代表人身份证正背面，，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_COR_AC_CIVIL_ID_A        => array(
                    'name'=>'正面',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_AC_CIVIL_ID_B        => array(
                    'name'=>'反面',
                    'desc'=>'',
                ),
            ),
        ),
        self::DATA_TYPE_COR_AC_SPOUSE_CIVIL_ID   => array(
            'name'=>'实际控制人配偶身份认证',
            'desc'=>'上传法定代表人配偶身份证正背面，，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_COR_AC_SPOUSE_CIVIL_ID_A => array(
                    'name'=>'正面',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_AC_SPOUSE_CIVIL_ID_B => array(
                    'name'=>'反面',
                    'desc'=>'',
                ),
            ),
        ),
        self::DATA_TYPE_COR_AC_MARRIAGE_CERT     => array(
            'name'=>'实际控制人结婚证',
            'desc'=>'上传法定代表人结婚证复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
            ),
        ),
        self::DATA_TYPE_COR_AC_RES_REG           => array(
            'name'=>'户口簿',
            'desc'=>'上传法定代表人户口簿主页、索引页、法定代表人页、配偶页的复印件，内容清晰可见。支持JPG、JPEG、PNG格式，2M以内大小',
            'sub'=>array(
                self::DATA_TYPE_COR_AC_RES_REG_MAIN      => array(
                    'name'=>'主页',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_AC_RES_REG_INDEX     => array(
                    'name'=>'索引页',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_AC_RES_REG_REPRE     => array(
                    'name'=>'法定代表人页',
                    'desc'=>'',
                ),
                self::DATA_TYPE_COR_AC_RES_REG_SPOUSE    => array(
                    'name'=>'配偶页的复印件',
                    'desc'=>'',
                ),
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
                $criteria->group = 'member_id';
                $criteria->order = 'id desc';
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
            self::DATA_TYPE_QUALIFICATION,
            self::DATA_TYPE_FINANCE      ,
            self::DATA_TYPE_CORPORATION  ,
        );
    }
    public static function getDataTypeArr() {
        return array(
            self::DATA_TYPE_QUALIFICATION=>'企业信息',
            self::DATA_TYPE_FINANCE      =>'财务信息',
            self::DATA_TYPE_CORPORATION  =>'法人信息',
        );
    }
    public static function getDataType2($dataType) {
        switch ($dataType) {
            case self::DATA_TYPE_QUALIFICATION:
                return self::$DATA_TYPE_QUA_ARR;
            case self::DATA_TYPE_FINANCE:
                return self::$DATA_TYPE_FIN_ARR;
            case self::DATA_TYPE_CORPORATION:
                return self::$DATA_TYPE_COR_ARR;
        }
        return array();
    }
    public static function getDataTypeDesc($dataType) {
        $desc = '';
        switch ($dataType) {
            case self::DATA_TYPE_QUALIFICATION:
                $desc = '企业信息';
                break;
            case self::DATA_TYPE_FINANCE:
                $desc = '财务信息';
                break;
            case self::DATA_TYPE_CORPORATION:
                $desc = '法人信息';
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
    	foreach(JdCompanyData::$DATA_TYPE_QUA_ARR as $k=>$v) {
    		if($v['sub']) {
    			foreach($v['sub'] as $key=>$value) {
    				$arr[$key]['name'] = $v['name'].$value['name'];
    				$arr[$key]['id'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->id;
    				$arr[$key]['file_path'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->file_path;
    				$arr[$key]['audit_status'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->audit_status;
    			}
    		} else {
    			$arr[$k]['name'] = $v['name'];
    			$arr[$k]['id'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->id;
    			$arr[$k]['file_path'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->file_path;
    			$arr[$k]['audit_status'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->audit_status;
    		}
    	}
    	foreach(JdCompanyData::$DATA_TYPE_FIN_ARR as $k=>$v) {
    		if($v['sub']) {
    			foreach($v['sub'] as $key=>$value) {
    				$arr[$key]['name'] = $v['name'].$value['name'];
    				$arr[$key]['id'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->id;
    				$arr[$key]['file_path'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->file_path;
    				$arr[$key]['audit_status'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->audit_status;
    			}
    		} else {
    			$arr[$k]['name'] = $v['name'];
    			$arr[$k]['id'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->id;
    			$arr[$k]['file_path'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->file_path;
    			$arr[$k]['audit_status'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->audit_status;
    		}
    		 
    	}
    	foreach(JdCompanyData::$DATA_TYPE_COR_ARR as $k=>$v) {
    		if($v['sub']) {
    			foreach($v['sub'] as $key=>$value) {
    				$arr[$key]['name'] = $v['name'].$value['name'];
    				$arr[$key]['id'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->id;
    				$arr[$key]['file_path'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->file_path;
    				$arr[$key]['audit_status'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$key'"))->audit_status;
    			}
    		} else {
    			$arr[$k]['name'] = $v['name'];
    			$arr[$k]['id'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->id;
    			$arr[$k]['file_path'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->file_path;
    			$arr[$k]['audit_status'] = JdCompanyData::model()->find(array('condition'=>"member_id='$member_id' and data_type2='$k'"))->audit_status;
    		}
    	}//print_r($arr);
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
            //return false;
        }
        if ($columnType!='member_id' && $columnType!='work_order_id') {
            $columnType = 'member_id';
            //return false;
        }
        $uploadedData = JdCompanyData::model()->findAll($columnType.'=:member_id', array(':member_id'=>$memberId));
        $uploadedData = OBJTool::convertModelToArray($uploadedData);
        $dataTypeArr = JdCompanyData::getDataType();
        $dataTypeCalcArr = array();
        foreach ($dataTypeArr as $dataType) {
            
            $dataType2Arr = JdCompanyData::getDataType2($dataType);


            $allNum = 0;
            $needNum = 0;
            $uploadedNum = 0;
            $needUpedNum = 0;
            $auditOkNum = 0;
            $auditDisNum = 0;
            $needAuditOkNum = 0;
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
                                $auditOkNum += $cv['audit_status'] == JdCompanyData::AUDIT_STATUS_ALLOW;
                                $auditDisNum += $cv['audit_status'] == JdCompanyData::AUDIT_STATUS_DISALLOW;
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
                            $auditOkNum += $cv['audit_status'] == JdCompanyData::AUDIT_STATUS_ALLOW;
                            $auditDisNum += $cv['audit_status'] == JdCompanyData::AUDIT_STATUS_DISALLOW;
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
            'isAuditOk' => $allNeedNum == $allNeedAuditOkNum,
            
        );
    }
}
