<?php

class WebToken {
    const SIGN_KEY      = '-O=M<.`!';
    const SESSION_KEY   = 'ATOKEN';

    protected $token;
    
    function __construct() {
        session_start();
        $this->init();
    }
    
    public function init() {
    }
    
    public function makeToken($expire = 300) {
        $session_id = session_id();
        $time = microtime(true);
        $token = substr(md5($session_id.self::SIGN_KEY .$time), 3, 20);
        $this->saveToSession($token, $expire);
        return $token;
    }
    
    public function checkToken($token, $renew=1) {
        // 取出token并作废session
        $tokenInSession = $_SESSION[self::SESSION_KEY];
        unset($_SESSION[self::SESSION_KEY]);
        if ($renew) {
            $this->token = null;//$this->makeToken();
        }
        // 空则返回检查失败
        if (!$tokenInSession) {
            return false;
        }
        
        // 检查session的token是否过期
        if ($tokenInSession['e'] < time()) {
            unset($_SESSION[self::SESSION_KEY]);
            return false;
        }
        // 检查token值
        if (!empty($token) && $tokenInSession['t']==$token) {
            return true;
        }
        return false;
    }
    public function getToken() {
        if (!$this->token) {
            $this->token = $this->makeToken();
        }
        return $this->token;
    }
    protected function saveToSession($token, $expire=300) {
        $value = [
            't' => $token,  //token
            //'c' => time()+$expire, //create_time
            'e' => time()+(int)$expire,
        ];
        $_SESSION[self::SESSION_KEY] = $value;
        //$
        return $value;
    }
}
