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
class SmsDataService extends BaseDataService {
    
    // 短信服务
    const SMS_SERVICE_APP_KEY = '69a0df47b3ab'; // 房乎AppKey
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

}