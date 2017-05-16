<?php
/**
 * Ares登陆用户类
 */
class LoginUser extends CWebUser {

    const LOGIN_USER_INFO_KEY = '__loginInfo'; // 登陆用户信息
    const LOGIN_USER_ID_KEY = '__uid'; // 登陆用户ID
    const LOGIN_USER_USERNAME_KEY = '__userName'; // 登陆用户名
    const COOKIE_LIFETIME = 432000; // 3600 * 24 * 5day;

    const SESSION_KEY_PREFIX = 'FHLOGIN-';

    /*
        设置特有的session前缀
    */
    public function init() {
        parent::init();
        $this->setStateKeyPrefix(self::SESSION_KEY_PREFIX);
    }

    /**
     * 登陆并保存数据值session
     * 
     * @param  object $identity 用户身份对象
     * @return void
     */
    public function loginAndSaveStates($identity) {
        // set state
        $this->setState(self::LOGIN_USER_INFO_KEY, $identity->getLoginData());
        $this->setState(self::LOGIN_USER_ID_KEY, $identity->getUserId());
        $this->setState(self::LOGIN_USER_USERNAME_KEY, $identity->getUserName());
        // login
        $this->login($identity, self::COOKIE_LIFETIME);
    }

    /**
     * [__get description]
     *  
     *  @param  string $name 属性名
     *  @return string
     */
    public function __get($name) {
        if ($this->hasState(self::LOGIN_USER_INFO_KEY)) {
            $loginData = $this->getState(self::LOGIN_USER_INFO_KEY, array());
            if (isset($loginData[$name])) {
                return $loginData[$name];
            }
        }
        return parent::__get($name);
    }

    /**
     * 判断用户否已登陆状态
     * 
     * @return boolean
     */
    public function getIsGuest() {
        return $this->getState(self::LOGIN_USER_ID_KEY) === null;
    }

    /**
     * 获取当前用户ID
     * 
     * @return string
     */
    public function getUserId() {
        return $this->getState(self::LOGIN_USER_ID_KEY, 0);
    } 

    /**
     * 获取当前用户名
     * 
     * @return array
     */
    public function getUserName() {
        return $this->getState(self::LOGIN_USER_USERNAME_KEY);
    }

    /**
     * 获取当前用户信息
     * 
     * @return array
     */
    public function getUserInfo() {
        return $this->getState(self::LOGIN_USER_INFO_KEY);
    }

    /**
     * 重设用户信息, 覆盖state中的__loginInfo
     *
     * @param  $params array 
     */
    public function setUserInfo($params) {
        if (!empty($params)) {
            if ($this->hasState(self::LOGIN_USER_INFO_KEY)) {
                $loginData = $this->getState(self::LOGIN_USER_INFO_KEY, array());
                // merge data
                $loginData = array_merge($loginData, (array)$params);             
                $this->setState(self::LOGIN_USER_INFO_KEY, $loginData);
            }
        }
    }
    

    /**
     * 登出并清除session
     * 
     * @return [type] [description]
     */
    public function logoutAndClearStates() {
        //$this->clearStates();
        $this->logout();
    }

}