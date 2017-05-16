<?php

class Member extends MemberBase {

    const MEMBER_FROM_BACKEND_ADD   = 1;    // 后台添加
    const MEMBER_FROM_XQSJ_PC_REG   = 2;    // 新奇世界pc注册
    const MEMBER_FROM_XQSJ_M_REG    = 3;    // 新奇世界m站注册
    const MEMBER_FROM_FANGHU_REG    = 11;   // 房乎新注册用户
    const MEMBER_FROM_FANGHU_INVITE = 12;   // 房乎新邀请注册用户
    const MEMBER_FROM_XQSJ_TO_FANGHU_REG    = 13;   // 已在新奇世界注册用户
    const MEMBER_FROM_XQSJ_TO_FANGHU_INVITE = 14;   // 已在新奇世界注册用户，受邀请
    static $ARR_MEMBER_FROM = array(
        self::MEMBER_FROM_BACKEND_ADD => '后台添加',
        self::MEMBER_FROM_XQSJ_PC_REG => '新奇世界pc注册',
        self::MEMBER_FROM_XQSJ_M_REG => '新奇世界m站注册',
        self::MEMBER_FROM_FANGHU_REG => '房乎注册',
        self::MEMBER_FROM_FANGHU_INVITE => '房乎邀请注册',
        //self::MEMBER_FROM_XQSJ_TO_FANGHU_REG => '新奇世界注册',
        //self::MEMBER_FROM_XQSJ_TO_FANGHU_INVITE => '新奇世界注册，并使用房乎用户邀请码',
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
                    'member_level' => array(self::HAS_ONE, 'MemberLevel', 'level_id'),
//                    'tasks' => array(self::MANY_MANY, 'PointTask', 'member_to_task(member_id, task_id)', 'on'=>'tasks_tasks.status=1'),
                    'tasks' => array(self::MANY_MANY, 'PointTask', 'member_to_task(member_id, task_id)'),
                    'favorates' => array(self::MANY_MANY, 'PointTask', 'member_favorite(member_id, task_id)'),
                    // add by xdr
                    'level' => array(self::HAS_ONE, 'PointsLevelModel', '', 'on'=>'t.member_level_id=level.level_id'),
                    'total_info' => array(self::HAS_ONE, 'MemberTotalModel', '', 'on'=>'t.member_id=total_info.member_id'),
                );
                return array_merge(parent::relations(), $curRelations);
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

        public function mySearch($start_time , $end_time) {
                // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
				
				if(($start_time !="") && ($end_time !=""))
				{
					//为$criteria新增设置
					$sql=" create_time >= '$start_time'  and   create_time <= '$end_time'";
					$criteria->addCondition($sql);
				}
			
                //为$criteria新增设置
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize']) ? Yii::app()->params['pageSize'] : 10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->findAll($criteria);
                $pages = array(
                    'curPage' => $pager->currentPage + 1,
                    'totalPage' => ceil($pager->itemCount / $pager->pageSize),
                    'pageSize' => $pager->pageSize,
                    'totalCount' => $pager->itemCount,
                    'url' => preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl()) . "&page=",
                );
                return array('pages' => $pages, 'list' => $list);
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return Member the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

        public function validatePassword($password) {
                return $this->hashPassword($password) === $this->member_password;
        }

        /**
         * Generates the password hash.
         * @param string password
         * @param string salt
         * @return string hash
         */
        public function hashPassword($password, $salt = '') {
                return md5($salt . $password);
        }

        /**
         * Generates a salt that can be used to generate a password hash.
         * @return string the salt
         */
        protected function generateSalt() {
                return uniqid('', true);
        }

    /*
        复制一份 UcMember 对象
    */
    static public function cloneUcMember($ucMember) {
        $member = new Member;
        $member->member_account = $ucMember->member_mobile;
        $member->member_mobile = $ucMember->member_mobile;
        $member->member_password = $ucMember->member_password;
        $member->member_mobile_verified = 1;//$ucMember->is_mobile_actived;
        $member->signage = $ucMember->signage;
        //$member->member_from = $inviteCodeModel ? Member::MEMBER_FROM_XQSJ_TO_FANGHU_INVITE:Member::MEMBER_FROM_XQSJ_TO_FANGHU_REG;
        $member->member_from = $ucMember->member_from;
        $member->create_time = date('Y-m-d H:i:s');
        return $member;
    }
}
