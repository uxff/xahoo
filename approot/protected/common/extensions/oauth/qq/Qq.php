<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/13
 * Time: 12:10
 */

class Qq {
    //qq第三方web应用id
    private $_appid = '101218622';

    //qq第三方web应用key
    private $_appkey = '9c09ae4164ca2c34a3ceee949f2dce78';

    //基础授权url

    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    //access_token获取地址
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";
    const GET_USER_INFO_URL = "https://graph.qq.com/user/get_user_info";
    //回调地址
//    private $_callback_url = 'http://testhifang.fangfull.com/ucneterpc.php?r=OAuth/qqLogin&ft=qq';
    public $_callback_url = 'http://testhifang.fangfull.com/ucenterpc.php/OAuth/qqLogin';
//    private $_callback_url = 'http://testhifang.fangfull.com/ucenterpc.php?r=OAuth/qqLogin';

    //授权范围
    private $_scope = 'get_user_info,add_share';



    //open_uid获取地址
    private $_open_uid_url = '';


    //授权url获取方法
    public function getAuthUrl($callback_url = '') {
        $appid = $this->_appid;
        if(!empty($callback_url)) {
            $callback = $callback_url;
        } else {
            $callback = $this->_callback_url;
        }

        $scope = $this->_scope;
        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
        $_SESSION['state'] = $state;
        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",
            "client_id" => $appid,
            "redirect_uri" => urlencode($callback),
            "state" => $state,
            "scope" => $scope
        );

        $login_url =  $this->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
        return $login_url;
        //header("Location:$login_url");

    }

    /**
     * combineURL
     * 拼接url
     * @param string $baseURL   基于的url
     * @param array  $keysArr   参数列表数组
     * @return string           返回拼接的url
     */
    public function combineURL($baseURL,$keysArr){
        $combined = $baseURL."?";
        $valueArr = array();
        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);
        return $combined;
    }


    /**
     * get_contents
     * 服务器通过get请求获得内容
     * @param string $url       请求的url,拼接后的
     * @return string           请求返回的内容
     */
    public function get_contents($url){
        if (ini_get("allow_url_fopen") == "1") {
            $response = file_get_contents($url);
        }else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $response =  curl_exec($ch);
            curl_close($ch);
        }

        //-------请求为空
        if(empty($response)){
            $this->error->showError("50001");
        }

        return $response;
    }

    /**
     * get
     * get方式请求资源
     * @param string $url     基于的baseUrl
     * @param array $keysArr  参数列表数组
     * @return string         返回的资源内容
     */
    public function get($url, $keysArr){
        $combined = $this->combineURL($url, $keysArr);
        return $this->get_contents($combined);
    }

    /**
     * post
     * post方式请求资源
     * @param string $url       基于的baseUrl
     * @param array $keysArr    请求的参数列表
     * @param int $flag         标志位
     * @return string           返回的资源内容
     */
    public function post($url, $keysArr, $flag = 0){

        $ch = curl_init();
        if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);
        curl_setopt($ch, CURLOPT_URL, $url);
        $ret = curl_exec($ch);

        curl_close($ch);
        return $ret;
    }



    public function qq_callback(){
//        $state = $this->recorder->read("state");
        $state = $_SESSION['state'];
        $appid = $this->_appid;
        $callback = $this->_callback_url;
        $scope = $this->_scope;
        //--------验证state防止CSRF攻击
        if($_GET['state'] != $state){
            echo 1;
            //$this->error->showError("30001");
        }

        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $appid,
            "redirect_uri" => urlencode($callback),
            "client_secret" => $this->_appkey,
            "code" => $_GET['code']
        );

        //------构造请求access_token的url
        $token_url = $this->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
        $response = $this->get_contents($token_url);

        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
//                $this->error->showError($msg->error, $msg->error_description);
            }
        }

        $params = array();
        parse_str($response, $params);
        //$this->recorder->write("access_token", $params["access_token"]);
        return $params["access_token"];

    }



    public function get_openid($access_token){

        //-------请求参数列表
        $keysArr = array(
//            "access_token" => $this->recorder->read("access_token")
            "access_token" => $access_token
        );
        $graph_url = $this->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->get_contents($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
//            $this->error->showError($user->error, $user->error_description);
        }

        //------记录openid
        //$this->recorder->write("openid", $user->openid);
        return $user->openid;

    }

    /**
     * 获取用户qq信息
     */
    public function getUserInfo() {
//        session_start();
        $access_token = $_SESSION['token']['access_token'];
        $uid = $_SESSION['token']['uid'];
        $appid = $this->_appid;

        $keysArr = array(
            "oauth_consumer_key" => $appid,
            "access_token" => $access_token,
            "openid" => $uid,
            'format' => 'json'
        );
//        $url = $this->combineURL(self::GET_USER_INFO_URL, $keysArr);
        $user_info = $this->get(self::GET_USER_INFO_URL, $keysArr);
        return $user_info;

    }
} 