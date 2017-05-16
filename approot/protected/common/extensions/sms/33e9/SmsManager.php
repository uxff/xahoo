<?php
/**
 * SmsManager class file.
 * @author liutao@fangfull.com
 * @copyright Copyright &copy; fangfull 2015
 * 
 */

// load class
require_once('lib/nusoap.php');

/**
 * 短信服务管理类
 */
class SmsManager extends CApplicationComponent {

    // 账号密码
    private $_account_username = '69195:admin';
    private $_account_password = '65945198';

    // WSDL地址
    const SMS_SERVICE_ENDPOINT_WSDL = 'http://ws.iems.net.cn/GeneralSMS/ws/SmsInterface?wsdl';

    // SERVICE常量
    const SMS_SERVICE_GETUSERINFO = 'getUserInfo';
    const SMS_SERVICE_CLUSTERSEND = 'clusterSend';

    // 错误码
    const SMS_ERROR_CODE_OK = '1000'; //操作成功
	const SMS_ERROR_CODE_UNAUTHORIZED = '1001'; //用户名不存在或密码出错
	const SMS_ERROR_CODE_FORBITTED = '1002'; //用户被禁用
	const SMS_ERROR_CODE_BALANCE_NOT_ENOUGH = '1003'; //余额不足
	const SMS_ERROR_CODE_REQUEST_TOO_MANY = '1004'; //请求频繁
	const SMS_ERROR_CODE_TEXT_TOO_MANY = '1005'; //内容超长(70汉字，最多不超过300汉字)
    const SMS_ERROR_CODE_MOBILE_ILLEGAL = '1006'; //非法手机号码
    const SMS_ERROR_CODE_KEYWORD_FILTER = '1007'; //关键字过滤
    const SMS_ERROR_CODE_TO_MOBILE_TOO_MANY = '1008'; //接收号码数量过多
    const SMS_ERROR_CODE_ACCOUNT_INVALID = '1009'; //账号过期
    const SMS_ERROR_CODE_PARAMETERS_FORMAT_ERROR = '1010'; //参数格式错误
    const SMS_ERROR_CODE_OTHER_ERROR = '1011'; //未知错误
    const SMS_ERROR_CODE_DATABASE_BUSY = '1012'; //数据库繁忙
    const SMS_ERROR_CODE_PRESENDTIME_ILLEGAL = '1013'; //非法发送时间
    

    // 致命错误码，记录错误日志，邮件提醒
    static $arrFatalErrorCode = array('1001','1002','1003','1009','1011','1012');

    // 短信服务错误日志key
    const ERROR_LOG_KEY = '[third_service_error][33e9_sms]';


    /**
     * [__construct description]
     */
    public function __construct($params) {
        if (!empty($params['username'])) {
            $this->_account_username = $params['username'];
        }
        if (!empty($params['passowrd'])) {
            $this->_account_password = $params['passowrd'];
        }
    }

    /**
     * 获取账号信息
     * @return [type] [description]
     */
    public function getUserInfo() {
    	// parameter
    	$parameters = array(
    		$this->_account_username,
    		$this->_account_password,
    	);
    	//
    	return $this->_call(self::SMS_SERVICE_GETUSERINFO, $parameters);
    }

    /**
     * 发送短信息
     * @param  string $to       手机号
     * @param  string $text     短信内容
     * @param  string $from     发送号
     * @param  string $is_voice 短信类别
     * @return void
     */
    public function sendSMS($to, $text, $is_voice='0|0|0|0') {
    	// parameters
    	$parameters = array(
            $this->_account_username,
            $this->_account_password,
    		'000', //from固定写死即可
    		$to,
    		$text,
    		'', //date('Y-m-d H:i:s'),
    		$is_voice,
    	);
    	//
    	return $this->_call(self::SMS_SERVICE_CLUSTERSEND, $parameters);
    }


    /************* private functions *************/
    /**
     * SOAP方式调用底层服务
     * @param  string  $service    [description]
     * @param  array   $parameters [description]
     * @return mixed
     */
    private function _call($service, $parameters) {
        //
        $client = new nusoap_client(self::SMS_SERVICE_ENDPOINT_WSDL, true);
        $client->soap_defencoding = 'utf-8';   
        $client->decode_utf8 = false;   
        $client->xml_encoding = 'utf-8'; 
        //
        $response = $client->call($service, (array)$parameters);
        AresLogManager::log_bi(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service log!', 'parameters' => array('service'=>$service, 'parameters'=>$parameters), 'response' => $response));
        //
       	if ($err = $client->getError()) {
            AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service error!', 'parameters' => $parameters, 'error' => $err));
            return false;
        } else {
        	// response
        	$response = self::xml2Array($response);
            if (!empty($response['code']) && ($response['code'] == self::SMS_ERROR_CODE_OK)) {
            	return true;
            } elseif (!empty($response['code']) && in_array($response['code'], self::$arrFatalErrorCode)) {
                AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service error!', 'parameters' => $parameters, 'response' => $response));
                return false;
            } else {
            	return false;
            }
        }
    }

    /**
     * [xml2Array description]
     * @param  [type] $xml_str [description]
     * @return [type]          [description]
     */
    public static function xml2Array($xml_str) {
    	return json_decode(json_encode((array)simplexml_load_string($xml_str)), true);
    }

}