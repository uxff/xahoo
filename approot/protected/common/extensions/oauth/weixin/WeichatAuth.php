<?php

/**
 * 微信授权相关接口
 * 
 * 
 */
class WeichatAuth {

//高级功能-》开发者模式-》获取
        private $app_id = 'wx7345a7e7764a9f88';
        private $app_secret = 'c93a33ab13d71229fe65dff4d8a5e100';
        private $redirect_uri = '';
        /**
         * 获取微信授权链接
         * 
         * @param string $redirect_uri 跳转地址
         * @param mixed $state 参数
         */
        public function get_authorize_url($redirect_uri = 'http://testhifang.fangfull.com/ucenter.php?r=OAuth/weixinLogin', $state = '123') {
                $redirect_uri = urlencode($redirect_uri);
                return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state={$state}#wechat_redirect";
        }

        /**
         * 获取授权token
         * 
         * @param string $code 通过get_authorize_url获取到的code
         */
        public function get_access_token($code = '') {
                $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
                $token_data = $this->http($token_url, 'GET');

                if ($token_data[0] == 200) {
                        return json_decode($token_data[1], TRUE);
                }

                return FALSE;
        }

        /**
         * 获取授权后的微信用户信息
         * 
         * @param string $access_token
         * @param string $open_id
         */
        public function get_user_info($access_token = '', $open_id = '') {
                if ($access_token && $open_id) {
                        $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
                        $info_data = $this->http($info_url, 'GET');

                        if ($info_data[0] == 200) {
                                return json_decode($info_data[1], TRUE);
                        }
                }

                return FALSE;
        }

        /**
         * 验证授权
         * 
         * @param string $access_token
         * @param string $open_id
         */
        public function check_access_token($access_token = '', $open_id = '') {
                if ($access_token && $open_id) {
                        $info_url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
                        $info_data = $this->http($info_url,'POST');

                        if ($info_data[0] == 200) {
                                return json_decode($info_data[1], TRUE);
                        }
                }

                return FALSE;
        }

//curl
        public function http($url, $method, $postfields = null, $headers = array(), $debug = false) {
                $ci = curl_init();
                /* Curl settings */
                curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ci, CURLOPT_TIMEOUT, 30);
                curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

                switch ($method) {
                        case 'POST':
                                curl_setopt($ci, CURLOPT_POST, true);
                                if (!empty($postfields)) {
                                        curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                                        $this->postdata = $postfields;
                                }
                                break;
                }
                curl_setopt($ci, CURLOPT_URL, $url);
                curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ci, CURLINFO_HEADER_OUT, true);

                $response = curl_exec($ci);
                $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

                if ($debug) {
                        echo "=====post data======\r\n";
                        var_dump($postfields);

                        echo '=====info=====' . "\r\n";
                        print_r(curl_getinfo($ci));

                        echo '=====$response=====' . "\r\n";
                        print_r($response);
                }
                curl_close($ci);
                return array($http_code, $response);
        }

}
/**
//demo
//微信认证链接
public function wxurl(){
import('MyClass.Wechatauth', APP_PATH);
$Wechat = new wechatauth();
$token = session('token'); //查看是否已经授权
if (!empty($token)) {
print_r($token);
$state = $Wechat->check_access_token($token['access_token'], $token['openid']); //检验token是否可用(成功的信息："errcode":0,"errmsg":"ok")
print_r($state);
}
$url = $Wechat->get_authorize_url('http://twx.vjiankang.org/wsite/test/wxrurl', '1'); //此处链接授权后，会跳转到下方处理
echo '<a href='.$url.'>授权</a>';
}

//微信返回字符串
public function wxrurl(){
import('MyClass.Wechatauth', APP_PATH);
$Wechat = new wechatauth();
print_r($_GET); //授权成功后跳转到此页面获取的信息
$token = $Wechat->get_access_token('', '', $_GET['code']); //确认授权后会，根据返回的code获取token
print_r($token);
session('token', $token); //保存授权信息
$user_info = $Wechat->get_user_info($token['access_token'], $token['openid']); //获取用户信息
print_r($user_info);
}
 * 
 */
