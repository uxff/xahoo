<?php

class SysAdminUser extends SysAdminUserBase {

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
                    'role' => array(self::MANY_MANY, 'SysRole', 'sys_role_user(user_id,role_id)'),
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

        public function mySearch() {
                // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                $criteria->order = 'id desc';
                //为$criteria新增设置
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize']) ? Yii::app()->params['pageSize'] : 10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->with('role')->findAll($criteria);
                $pages = array(
                    'curPage' => $pager->currentPage + 1,
                    'totalPage' => ceil($pager->itemCount / $pager->pageSize),
                    'pageSize' => $pager->pageSize,
                    'totalCount' => $pager->itemCount,
                    'url' => preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl()) . "&page=",
                );
                return array('pages' => $pages, 'list' => $list);
        }

        public function getUserAccessNode() {
                $role_id = 1;
                $this->findAll('role_id=:role_id', array(':role_id' => $role_id));
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return SysAccess the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

        //beforeSave()这个方法是yii自带的
        public function beforeSave() {
                if (parent::beforeSave()) {
                        //$this->isNewRecord  是否为新添加用户（新纪录）
                        if ($this->isNewRecord) {
                                $this->password = $this->encypt($this->password);
                        }
                        return true;
                } else {
                        return false;
                }
        }

//给密码进行md5加密
        public function encypt($pass) {
                return md5($pass);
        }

        /**
         * Checks if the given password is correct.
         * @param string the password to be validated
         * @return boolean whether the password is valid
         */
        public function validatePassword($password) {
                return $this->hashPassword($password) === $this->password;
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

}
