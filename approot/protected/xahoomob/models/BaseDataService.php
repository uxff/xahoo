<?php
/**
 * Base数据服务类，主要负责系统公共模块化数据处理
 * 
 * @author liutao@fangfull.com
 * @date 2014/12/23 16:53:50
 */
class BaseDataService {

    /**
     * 生成绝地URL地址
     * 
     * @param  string $route     路由规则
     * @param  array  $urlParams 请求参数
     * @param  string $schema    https/http
     * @return string
     */
    public static function createUrl($route, $urlParams=array(), $schema='http') {
        $url = '';
        
        // 生成URL
        if (!empty($route)) {
            $url = Yii::app()->getRequest()->getHostInfo($schema);
            $url .= Yii::app()->createUrl($route, $urlParams);
        }

        return $url;
    }

    /**
     * 获取用户中心绝对URL
     * NOTE1: 使用配置文件中UCenterServerName，没有设置则使用当前host
     * NOTE2: UCenter不需要静态化操作
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createUCenterUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = self::createOtherAppUrl('UCenterServerName', $route, $params);

        return $ucenterUrl;
    }

    /**
     * 获取Xahoo绝对URL
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createFanghuUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = self::createOtherAppUrl('FanghuServerName', $route, $params);

        return $ucenterUrl;
    }

    /**
     * 获取即刻海外绝对URL
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createJkhwUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = self::createOtherAppUrl('JkhwServerName', $route, $params);

        return $ucenterUrl;
    }

    /**
     * 获取WEB绝对URL
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createXqsjPCServerUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = self::createOtherAppUrl('XqsjPCServerName', $route, $params);
        return $ucenterUrl;
    }

    /**
     * 获取分权绝对URL
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createXqsjFQServerUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = self::createOtherAppUrl('XqsjFQServerName', $route, $params);
        return $ucenterUrl;
    }

    /**
     * 获取众筹绝对URL
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createXqsjZCServerUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = self::createOtherAppUrl('XqsjZCServerName', $route, $params);

        return $ucenterUrl;
    }

    /**
     * 获取其他app的绝对URL
     * NOTE: 使用配置文件中XXServerName，没有设置则使用当前host
     * 
     * @param  string    $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function createOtherAppUrl($serverName, $route = '', $params = array()) {
        // 路由参数设置
        $urlRoute = '';
        $urlParams = array();
        if (!empty($route)) {
            $urlRoute = $route;
        }
        if (!empty($params)) {
            $urlParams = $params;
        }

        // 判断协议
        $schema = Yii::app()->getRequest()->getIsSecureConnection() ? 'https' : 'http';

        // 生成url
        $otherAppUrl = Yii::app()->params[$serverName];
        if (empty($otherAppUrl)) {
            $otherAppUrl = Yii::app()->getRequest()->getHostInfo($schema);
            $otherAppUrl .= Yii::app()->createUrl($urlRoute, $urlParams);
        } else {
            $url = Yii::app()->createUrl($urlRoute, $urlParams);
            $replace = Yii::app()->getRequest()->getScriptUrl();
            //left trim current script url
            $otherAppUrl .= (stripos($url, $replace) === 0) ? substr_replace($url, '', 0, strlen($replace)) : $url;
        }

        return $otherAppUrl;
    }
    

    /**
     * [doGet description]
     * @param  [type]  $url     [description]
     * @param  array   $params  [description]
     * @param  array   $headers [description]
     * @param  integer $timeout [description]
     * @return [type]           [description]
     */
    public static function doGet($url, $params=array(), $headers=array(), $timeout=30) {
        // 初始化URL
        if (! empty ( $params ) && is_array ( $params )) {
            $url .= (strpos($url,'?')===false? '?' : '&') . http_build_query( $params, null, '&');
        }

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        // 以返回的形式接收信息
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        // 设置为POST方式
        curl_setopt( $ch, CURLOPT_GET, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
        // 不验证https证书
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        // 设置超时
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        // 设置头信息
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        // 发送数据
        $response = curl_exec( $ch );
        if (curl_errno($ch)) {
            echo 'Curl URL: ' . $url . ' with GET error:' . curl_error($ch);
        }

        // 不要忘记释放资源
        curl_close( $ch );

        return $response;
    }

    /**
     * 发起一个post请求到指定接口
     * 
     * @param string   $url       请求的接口
     * @param array    $params    post参数
     * @param array    $headers   http头新新
     * @param integer  $timeout   超时时间
     * @return string  请求结果
     */
    public static function doPost($url, $params=array(), $headers=array(), $timeout=30) {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        // 以返回的形式接收信息
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        // 设置为POST方式
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
        // 不验证https证书
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        // 设置超时
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        // 设置头信息
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        // 发送数据
        $response = curl_exec( $ch );
        if (curl_errno($ch)) {
            echo 'Curl URL: ' . $url . ' with POST error:' . curl_error($ch);
        }

        // 解析json为数组
        $arrResult = json_decode($response, true);

        // 不要忘记释放资源
        curl_close( $ch );
        
        return $arrResult;
    }


}