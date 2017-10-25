<?php

/**
 * UserIdentity represents the data needed to identity a customer.
 * It contains the authentication method that checks if the provided
 * data can identity the customer.
 */
class UserIdentity extends CUserIdentity {

        const LOGIN_MODE_EMAIL = '1'; //邮箱登录
        const LOGIN_MODE_MOBILE = '2'; //手机号登录
        const LOGIN_MODE_UNKOWN = '0'; //未知登录

        // 记录登录信息

        private $_loginData = array();
        private $_userId = 0;
        private $_userName = '';

        /**
         * Authenticates a customer.
         * implement parent same function
         * 
         * @return boolean whether authentication succeeds.
         */
        public function authenticate() {
                $loginMode = $this->_getLoginMode($this->username);
                $lowerUserName = strtolower($this->username);
				
                switch ($loginMode) {
                        case self::LOGIN_MODE_EMAIL:
                                $objMember = UcMember::model()->find('LOWER(member_email)=:member_email', array('member_email' => $lowerUserName));
                                break;
                        case self::LOGIN_MODE_MOBILE:
                                $objMember = UcMember::model()->find('member_mobile=:member_mobile', array('member_mobile' => $lowerUserName));
                                break;
                        default:
                                $objMember = UcMember::model()->find('LOWER(member_email)=:member_email', array('member_email' => $lowerUserName));
                                break;
                }

                // check customer is valid
                if ($objMember === null) {
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                } elseif (!AresUtil::validatePassword($this->password, $objMember->member_password)) {
                        $this->errorCode = self::ERROR_PASSWORD_INVALID;
                } else {

                        // set login data
                        $this->_loginData = $objMember->attributes;

                        // set user id
                        $this->_userId = $objMember->member_id;

                        // set user name
                        $this->_userName = $this->username;

                        $this->errorCode = self::ERROR_NONE;
                }

                return $this->errorCode;
        }

        /**
         * Authenticates a customer. for Fanghu
         * implement parent same function
         * @author: coderxx
         * @return boolean whether authentication succeeds.
         */
        public function authenticateFanghu() {
                $loginMode = $this->_getLoginMode($this->username);
                $lowerUserName = strtolower($this->username);
				
                switch ($loginMode) {
                        case self::LOGIN_MODE_EMAIL:
                                $objMember = UcMember::model()->find('LOWER(member_email)=:member_email', array('member_email' => $lowerUserName));
                                break;
                        case self::LOGIN_MODE_MOBILE:
                                $objMember = UcMember::model()->find('member_mobile=:member_mobile', array('member_mobile' => $lowerUserName));
                                break;
                        default:
                                $objMember = UcMember::model()->find('LOWER(member_email)=:member_email', array('member_email' => $lowerUserName));
                                break;
                }

                // check customer is valid
                if ($objMember === null) {
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                } elseif (!AresUtil::validatePassword($this->password, $objMember->member_password)) {
                        $this->errorCode = self::ERROR_PASSWORD_INVALID;
                } else {

                        // set login data
                        $this->_loginData = $objMember->attributes;

                        // set user id
                        $this->_userId = $objMember->member_id;

                        // set user name
                        $this->_userName = $this->username;

                        $this->errorCode = self::ERROR_NONE;
                }

                return $this->errorCode;
        }

        /**
         *
         */
        public function authenticateadd() {
                $objMember = UcMember::model()->findByAttributes(array('member_mobile' => $this->username));

                if ($objMember === null) {
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                } else {
                        // set login data
                        $this->_loginData = $objMember->attributes;
                        // set user id
                        $this->_userId = $objMember->member_id;
						$this->_userName = $objMember->member_nickname;

                        $this->errorCode = self::ERROR_NONE;
                }
                return $this->errorCode;
        }

        /**
         * @return array the data of the customer
         */
        public function getLoginData() {
                return $this->_loginData;
        }

        /**
         * 获取用户ID
         * @return [type] [description]
         */
        public function getUserId() {
                return $this->_userId;
        }

        /**
         * 获取用户登陆用户名
         * @return [type] [description]
         */
        public function getUserName() {
                return $this->_userName;
        }

        /************ private functions ************/

        private function _getLoginMode($username) {
                $loginMode = self::LOGIN_MODE_UNKOWN;

                if (AresValidator::isValidEmail($username)) {
                        $loginMode = self::LOGIN_MODE_EMAIL;
                } elseif (AresValidator::isValidChineseMobile($username)) {
                        $loginMode = self::LOGIN_MODE_MOBILE;
                } else {
                        $loginMode = self::LOGIN_MODE_UNKOWN;
                }

                return $loginMode;
        }

        public function thirdPartLogin($id) {
                $objMember = UcMember::model()->findByPk($id);

                if ($objMember === null) {
                        $this->errorCode = self::ERROR_USERNAME_INVALID;
                } else {
                        // set login data
                        $this->_loginData = array(
                            'memberId' => $objMember->member_id,
                            'signage' => $objMember->signage,
                            'member_nickname' => $objMember->member_nickname,
                        );

                        // set user id
                        $this->_userId = $objMember->member_id;
                        $this->_userName = $objMember->member_nickname;

                        $this->errorCode = self::ERROR_NONE;
                }
                return $this->errorCode;
        }

}
