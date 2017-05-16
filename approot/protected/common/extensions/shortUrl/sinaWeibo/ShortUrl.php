<?php
Yii::import('application.common.extensions.shortUrl.sinaWeibo.ShortUrlError');
/**
 * Created by 【中弘集团】.
 * User: 张文庆
 * Date: 2015/7/15
 * Time: 22:55
 * Description: 短连接类
 */
class ShortUrl {

    /**
     * 新浪微博应用秘钥
     * 公司注册秘钥，受保护,未经允许，不要乱改
     * */
    private static $_app_key = '4173435454';

    /**
     *  新浪微博短连接调用接口
     * */
//    private static $_callUrl = 'http://api.t.sina.com.cn/short_url/shorten.json';
    private static $_callUrl = 'http://api.weibo.com/2/short_url/shorten.json';

    /**
     * 获取短连接
     *
     * @param $url
     * @return mixed
     */
    public static function getShortUrl($url) {
        $args = array(
            'source'=>self::$_app_key,
            'url_long'=>$url
        );

        $url = self::$_callUrl . '?' . http_build_query($args);
        $result = self::_curl_get($url);

        if(isset($result['error']) && isset($result['error_code'])){
            $codeDesc = ShortUrlError::getErrorMessage($result['error_code']);
            $result['error'] = $codeDesc;
            return $result;
        }else{
            return $result;
        }
    }

    /**
     * 访问新浪微博API
     * @param $url
     * @param array $opt
     * @return mixed
     */
    private static function _curl_get($url , $args = array()) {
        $ch = curl_init();
        $opts = array(
            CURLOPT_URL=>$url,
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_HEADER=>0,
            CURLOPT_HTTPGET=>1,
            CURLOPT_SSL_VERIFYPEER=>0,
            CURLOPT_HTTPHEADER=>array('Content-type:application/json')
        );
        curl_setopt_array($ch, ($opts + $args));
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

}