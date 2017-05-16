<?php
/**
 * 数据服务层，主要负责模块化数据处理，第三方服务访问
 * 
 * @author liutao@fangfull.com
 * @date 2014/12/24 10:53:50
 *
 * curl -k -d 'appkey=46139a1b7720&phone=18701595943&zone=86' 'https://120.132.154.117:8443/sms/sendmsg'
 * curl -k -d 'appkey=46139a1b7720&phone=18701595943&zone=86&code=2467' 'https://120.132.154.117:8443/sms/checkcode'
 */
class SmsManager {
    
    // 短信服务
    const SMS_SERVICE_APP_KEY = '8be0f67a4014'; // 仟金所AppKey
    const SMS_SERVICE_ENDPOINT = 'https://120.132.154.117:8443'; // SMS服务器地址
    const SMS_API_CHECK_STATUS = '/check/status'; // 服务器装填监测接口
    const SMS_API_SEND_MSG = '/sms/sendmsg'; // 发送验证码接口
    const SMS_API_CHECK_CODE = '/sms/checkcode'; // 验证验证码接口

    // 错误码
    const SMS_ERROR_CODE_OK = '200'; //操作成功
    const SMS_ERROR_CODE_REJECT = '512'; //服务器拒绝访问，或者拒绝操作
    const SMS_ERROR_CODE_UNAUTHORIZED = '513'; //Appkey不存在或被禁用
    const SMS_ERROR_CODE_NO_PERMISSION = '514'; //权限不足
    const SMS_ERROR_CODE_INTERNAL_ERROR = '515'; //服务器内部错误 
    const SMS_ERROR_CODE_MISSING_PARAMETERS = '517'; //缺少必要的请求参数
    const SMS_ERROR_CODE_INVALID_MOBILE = '518'; //请求中用户的手机号格式不正确（包括手机的区号）
    const SMS_ERROR_CODE_OVER_LIMITED = '519'; //请求发送验证码次数超出限制
    const SMS_ERROR_CODE_INVALID_VERIFYCODE = '520'; //无效验证码
    const SMS_ERROR_CODE_BALANCE_NOT_ENOUGH = '526'; //余额不足
    
    // 致命错误码，记录错误日志，邮件提醒
    static $arrFatalErrorCode = array('512','513','514','515','526');

    // 短信服务错误日志key
    const ERROR_LOG_KEY = '[third_service_error][mob_sms]';

    /**
     * mob.com SMS服务状态检查
     * 
     * @return boolean
     */
    public static function checkSmsServiceStatus() {
        // api setting
        $url = self::SMS_SERVICE_ENDPOINT . self::SMS_API_CHECK_STATUS;

        $postParams = array();

        // request
        $response = self::doPost( $url, $postParams );

        $result = false;
        if (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_OK)) {
            $result = true;
        } else {
        	// error log
        	AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service is down!', 'parameters' => array(), 'response' => $response));
        }

        return $result;
    }

    /**
     * 发送验证码
     * 
     * @param  string $phone     手机号
     * @param  string $zoneCode  地区编号
     * @return boolean           发送成功或是失败
     */
    public static function sendVerifyCode($phone, $zoneCode='86') {
        // sms service health check
        $isServiceOk = self::checkSmsServiceStatus();
        
        $result = false;
        if ($isServiceOk) {

            // rest setting
            $url = self::SMS_SERVICE_ENDPOINT . self::SMS_API_SEND_MSG;
            $postParams = array(
                'appkey' => self::SMS_SERVICE_APP_KEY,
                'phone' => $phone,
                'zone' => $zoneCode,
                //'tempCode' => '', //非必填项
            );

            // request
            $response = self::doPost( $url, $postParams );

            // add log
            $parameters = array_merge( array('url'=>$url), $postParams );
            AresLogManager::log_bi(array('logKey' => '[sms]['.__METHOD__.']', 'desc' => 'send verify code', 'parameters' => $parameters, 'response' => $response));

            // response
            if (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_OK)) {
            	//
                $result = true;
            } elseif (!empty($response['status']) && in_array($response['status'], self::$arrFatalErrorCode)) {
            	//
                AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service error!', 'parameters' => $parameters, 'response' => $response));
            }
        }       

        return $result;
    }


    /**
     * 校验验证码是否有效
     * 
     * @param  string $phone      手机号
     * @param  string $verifyCode 用户获取的验证码
     * @param  string $zoneCode   地区编号
     * @return array              验证成功或失败
     */
    public static function verify($phone, $verifyCode, $zoneCode='86') {
        // sms service health check
        $isServiceOk = self::checkSmsServiceStatus();
        
        $result = array();
        if ($isServiceOk) {

            // rest setting
            $url = self::SMS_SERVICE_ENDPOINT . self::SMS_API_CHECK_CODE;
            $postParams = array(
                'appkey' => self::SMS_SERVICE_APP_KEY,
                'phone' => $phone,
                'zone' => $zoneCode,
                'code' => $verifyCode,
            );

            // request
            $response = self::doPost( $url, $postParams );

            // add log
            $parameters = array_merge( array('url'=>$url), $postParams );
            AresLogManager::log_bi(array('logKey' => '[sms]['.__METHOD__.']', 'desc' => 'check verify code', 'parameters' => $parameters, 'response' => $response));
            
            // response
            if (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_OK)) {
                $result['code'] = '200';
                $result['msg'] = '验证成功';
            } elseif (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_OVER_LIMITED)) {
                $result['code'] = '519';
                $result['msg'] = '请求发送验证码次数超出限制';
            } elseif (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_INVALID_VERIFYCODE)) {
                $result['code'] = '520';
                $result['msg'] = '验证码无效';
            } elseif (!empty($response['status']) && in_array($response['status'], self::$arrFatalErrorCode)) {
                AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service error!', 'parameters' => $parameters, 'response' => $response));
            }

        }       

        return $result;
    }

    /******************* common *******************/

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