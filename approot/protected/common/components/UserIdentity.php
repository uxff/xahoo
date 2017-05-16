<?php

/**
 * UserIdentity represents the data needed to identity a customer.
 * It contains the authentication method that checks if the provided
 * data can identity the customer.
 */
class UserIdentity extends CUserIdentity {

    // 记录登录信息
    private $_loginData = array();
    // 登陆用户ID
    private $_userId = 0;
    // 登陆用户名
    private $_userName = '';
    // 登陆用户密文密码
    private $_userEncrypedPassword = '';

    /**
     * 设置用户信息
     * @param array $arrUser [description]
     *
     * @todo 完善细节
     */
    public function setUserIdentity($arrUser, $userId, $userEncrypedPassword, $userName) {
        // set user data
        if (!empty($arrUser)) {
            $this->_loginData = $arrUser;
        }
        // set user ID
        if (intval($userId) > 0) {
            $this->_userId = intval($userId);
        }
        // set user name
        if (!empty($userName)) {
            $this->_userName = $userName;
        }
        // set user password
        if (!empty($userEncrypedPassword)) {
            $this->_userEncrypedPassword = $userEncrypedPassword;
        }
    }

    /**
     * Authenticates a customer.
     * implement parent same function
     *
     * @param array $arrUser 
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        // check customer is valid
        if (empty($this->_loginData)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!AresUtil::validatePassword($this->password, $this->_userEncrypedPassword)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            // no error
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode;
    }

    /**
     * return the data of the customer
     *
     * @return array
     */
    public function getLoginData() {
        return $this->_loginData;
    }

    /**
     * return the login name of the customer
     * 
     * @return string 
     */
    public function getUserName() {
        return $this->_userName;
    }

    /**
     * return the ID of the customer
     * 
     * @return string 
     */
    public function getUserId() {
        return $this->_userId;
    }

}