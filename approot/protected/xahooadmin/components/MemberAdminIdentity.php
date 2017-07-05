<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MemberAdminIdentity extends CUserIdentity {

        public $admin;
        public $_uid;
        public $username;
        public $role;

        /**
         * Authenticates a user.
         * The example implementation makes sure if the username and password
         * are both 'demo'.
         * In practical applications, this should be changed to authenticate
         * against some persistent user identity storage (e.g. database).
         * @return boolean whether authentication succeeds.
         */
        public function authenticate() {
                $user = SysAdminUser::model()->find('LOWER(account)=?', array(strtolower($this->username)));
                if ($user === null){
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                }else if (!$user->validatePassword($this->password)){
                        $this->errorCode = self::ERROR_PASSWORD_INVALID;
                }else {
                        $this->_uid = $user->id;
                        $this->username = $user->name;
                        $this->setUser($user);
                        $roleArr = OBJTool::convertModelToArray($user->role);
                        if ($roleArr) {
                                $role = $roleArr[0]['id'];
                        } else {
                                $role = NULL;
                        }
                        $this->setState('__role', $role);
                        $this->errorCode = self::ERROR_NONE;
                        //Yii::app()->user->setState("isadmin", true);
                }
                return $this->errorCode == self::ERROR_NONE;
        }

        /**
         * @return integer the ID of the user record
         */
        public function getUserId() {
                return $this->_uid;
        }

        public function getUser() {
                return $this->admin;
        }

        public function setUser(CActiveRecord $user) {
                $this->admin = $user->attributes;
        }

}
