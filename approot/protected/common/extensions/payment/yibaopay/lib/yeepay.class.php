<?php
/**
 * 易宝投资通接口
 */

class yeepay {

	// CURL 参数
	public $http_info;
	public $http_header = array();
	public $http_code;
	public $useragent = 'Yeepay MobilePay PHPSDK v1.1x';
	public $connecttimeout = 30;
	public $timeout = 30;
	public $ssl_verifypeer = FALSE;
	// Yeepay 参数
	private $merchantAccount;
	private $merchartPublicKey;
	private $merchantPrivateKey;
	private $yeepayPublicKey;
	private $bindBankcardURL;
	private $confirmBindBankcardURL;
	private $directBindPayURL;
	private $paymentQueryURL;
	private $paymentConfirmURL;
	private $withdrawURL;
	private $queryWithdrawURL;
	private $queryAuthbindListURL;
	private $bankCardCheckURL;
	private $payClearDataURL;
	private $refundURL;
	private $refundQueryURL;
	private $refundClearDataURL;
	// 加密
	private $RSA;
	private $AES;
	private $AESKey;

	public  $debug = false ;

	public static $logKey = '[ares_log_error][qjs_yeepay_billing]';

	public function __construct($config) {


		$dir = dirname(dirname(__FILE__));

		include $dir.'/crypt/Rijndael.php';
		include $dir.'/crypt/AES.php';
		include $dir.'/crypt/DES.php';
		include $dir.'/crypt/Hash.php';
		include $dir.'/crypt/RSA.php';
		include $dir.'/crypt/TripleDES.php';
		include $dir.'/math/BigInteger.php';

		// 加密类
		$this->RSA = new Crypt_RSA();
		$this->RSA->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		$this->RSA->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
		$this->AES = new Crypt_AES(CRYPT_AES_MODE_ECB);

		// 商户配置
		$this->merchantAccount = $config['merchantAccount'];
		$this->merchartPublicKey = $config['merchantPublicKey'];
		$this->merchantPrivateKey = $config['merchantPrivateKey'];
		$this->yeepayPublicKey = $config['yeepayPublicKey'];

		// API URI 配置
		$this->bindBankcardURL = 'https://ok.yeepay.com/payapi/api/tzt/invokebindbankcard';
		$this->confirmBindBankcardURL = 'https://ok.yeepay.com/payapi/api/tzt/confirmbindbankcard';
		$this->directBindPayURL = 'https://ok.yeepay.com/payapi/api/tzt/directbindpay';//'https://ok.yeepay.com/payapi/api/tzt/pay/bind/reuqest';
		$this->paymentQueryURL = 'https://ok.yeepay.com/merchant/query_server/pay_single';
		$this->paymentConfirmURL = 'https://ok.yeepay.com/payapi/api/tzt/pay/confirm/validatecode';
		$this->withdrawURL = 'https://ok.yeepay.com/payapi/api/tzt/withdraw';
		$this->queryWithdrawURL = 'https://ok.yeepay.com/payapi/api/tzt/drawrecord';
		$this->queryAuthbindListURL = 'https://ok.yeepay.com/payapi/api/bankcard/bind/list';
		$this->bankCardCheckURL = 'https://ok.yeepay.com/payapi/api/bankcard/check';
		$this->payClearDataURL = 'https://ok.yeepay.com/merchant/query_server/pay_clear_data';
		$this->refundURL = '';
		$this->refundQueryURL = '';
		$this->refundClearDataURL = '';

	}

	/**
	 * 获取商户编号
	 * @return type
	 */
	public function getMerchartAccount() {
		return $this->merchantAccount;
	}

	/**
	 * 获取商户私匙
	 * @return type
	 */
	public function getMerchantPrivateKey() {
		return $this->merchantPrivateKey;
	}

	/**
	 * 获取商户AESKey
	 * @return type
	 */
	public function getmerchantAESKey() {
		return $this->random(16, 1);
	}

	/**
	 * 获取易宝公匙
	 * @return type
	 */
	public function getYeepayPublicKey() {
		return $this->yeepayPublicKey;
	}

	/**
	 * 格式化字符串
	 * @param type $text
	 * @return type
	 */
	public function formatString($text) {
		return $text == '' || empty($text) || is_null($text) ? '' : trim($text);
	}

	/**
	 * String2Integer
	 * @param type $text
	 * @return type
	 */
	public function string2Int($text) {
		return $text == '' || empty($text) || is_nan($text) ? 0 : intval($text);
	}

	/**
	 * 生成随机字符串
	 * @param type $length 字符串长度
	 * @param type $numeric 数字模式
	 * @return type string
	 */
	public function random($length, $numeric = 0) {
		$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for ($i = 0; $i < $length; $i++) {
			$hash .= $seed{mt_rand(0, $max)};
		}
		return $hash;
	}

	/**
	 * 绑卡请求接口请求地址
	 * @return type
	 */
	public function getBindBankcardURL() {
		return $this->bindBankcardURL;
	}

	/**
	 * 绑卡确认接口请求地址
	 * @return type
	 */
	public function getConfirmBindBankcardURL() {
		return $this->confirmBindBankcardURL;
	}

	/**
	 * 支付接口请求地址
	 * @return type
	 */
	public function getDirectBindPayURL() {
		return $this->directBindPayURL;
	}

	/**
	 * 订单查询请求地址
	 * @return type
	 */
	public function getPaymentQueryURL() {
		return $this->paymentQueryURL;
	}

	/**
	 * 确定支付请求地址
	 * @return type
	 */
	public function getpaymentConfirmURL() {
		return $this->paymentConfirmURL;
	}

	/**
	 * 取现接口请求地址
	 * @return type
	 */
	public function getWithdrawURL() {
		return $this->withdrawURL;
	}

	/**
	 * 取现查询请求地址
	 * @return type
	 */
	public function getQueryWithdrawURL() {
		return $this->queryWithdrawURL;
	}

	/**
	 * 取现查询请求地址
	 * @return type
	 */
	public function getQueryAuthbindListURL() {
		return $this->queryAuthbindListURL;
	}

	/**
	 * 银行卡信息查询请求地址
	 * @return type
	 */
	public function getBankCardCheckURL() {
		return $this->bankCardCheckURL;
	}

	/**
	 * 支付清算文件下载请求地址
	 * @return type
	 */
	public function getPayClearDataURL() {
		return $this->payClearDataURL;
	}

	/**
	 * 单笔退款请求地址
	 * @return type
	 */
	public function getRefundURL() {
		return $this->refundURL;
	}

	/**
	 * 退款查询请求地址
	 * @return type
	 */
	public function getRefundQueryURL() {
		return $this->refundQueryURL;
	}

	/**
	 * 退款清算文件请求地址
	 * @return type
	 */
	public function getRefundClearDataURL() {
		return $this->refundClearDataURL;
	}

	/**
	 * 绑定银行卡
	 * @param type $identityid
	 * @param type $identitytype
	 * @param type $requestid
	 * @param type $cardno
	 * @param type $idcardno
	 * @param type $username
	 * @param type $phone
	 * @param type $registerphone
	 * @param type $registerdate
	 * @param type $registerip
	 * @param type $registeridcardno
	 * @param type $registercontact
	 * @param type $os
	 * @param type $imei
	 * @param type $userip
	 * @param type $ua
	 * @return type
	 */
	public function bindBankcard($identityid, $identitytype, $requestid, $cardno, $idcardno, $username, $phone, $registerphone, $registerdate, $registerip, $registeridcardno, $registercontact, $os, $imei, $userip, $ua) {

		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'identityid' => strval($identityid),
		    'identitytype' => $identitytype,
		    'requestid' => $requestid,
		    'cardno' => $cardno,
		    'idcardtype' => '01',
		    'idcardno' => $idcardno,
		    'username' => $username,
		    'phone' => $phone,
		    'registerphone' => $registerphone,
		    'registerdate' => $registerdate,
		    'registerip' => $registerip,
		    'registeridcardtype' => '01',
		    'registeridcardno' => $registeridcardno,
		    'registercontact' => $registercontact,
		    'os' => $os,
		    'imei' => $imei,
		    'userip' => $userip,
		    'ua' => $ua
		);




		if($this->debug){
			file_put_contents('/tmp/yeepay_debug.log', var_export($query, true), FILE_APPEND);
			//print_r($query);
		}

		return $this->post($this->getBindBankcardURL(), $query);
	}

	/**
	 * 确定绑卡
	 * @param type $requestid
	 * @param type $validatecode
	 * @return type
	 */
	public function bindBankcardConfirm($requestid, $validatecode) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'requestid' => $requestid,
		    'validatecode' => $validatecode
		);
		return $this->post($this->getConfirmBindBankcardURL(), $query);
	}

	/**
	 * 获取绑卡记录
	 * @param type $identityid
	 * @param type $identitytype
	 * @return type
	 */
	public function bankcardList($identityid, $identitytype) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'identityid' => $identityid,
		    'identitytype' => $identitytype,
		);
		return $this->get($this->getQueryAuthbindListURL(), $query);
	}

	/**
	 * 获取绑卡支付请求
	 * @param type $orderid
	 * @param type $transtime
	 * @param type $amount
	 * @param type $productname
	 * @param type $productdesc
	 * @param type $identityid
	 * @param type $identitytype
	 * @param type $card_top
	 * @param type $card_last
	 * @param type $orderexpdate
	 * @param type $callbackurl
	 * @param type $imei
	 * @param type $userip
	 * @param type $ua
	 * @return type
	 */
	public function directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'orderid' => $orderid,
		    'transtime' => $transtime,
		    'currency' => 156,
		    'amount' => $amount,
		    'productname' => $productname,
		    'productdesc' => $productdesc,
		    'identityid' => $identityid,
		    'identitytype' => $identitytype,
		    'card_top' => $card_top,
		    'card_last' => $card_last,
		    'orderexpdate' => $orderexpdate,
		    'callbackurl' => $callbackurl,
		    'imei' => $imei,
		    'userip' => $userip,
		    'ua' => $ua
		);

		if($this->debug){
			dump($query);
			file_put_contents('/tmp/yeepay_debug.log', var_export($query, true), FILE_APPEND);
		}


		return $this->post($this->getDirectBindPayURL(), $query);
	}

	/**
	 * 确认支付
	 * @param type $orderid
	 * @param type $validatecode
	 * @return type
	 */
	public function confirmPayment($orderid, $validatecode = '') {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'orderid' => $orderid,
		    'validatecode' => $validatecode
		);
		return $this->post($this->getpaymentConfirmURL(), $query);
	}

	/**
	 * 交易记录查询
	 * @param type $orderid
	 * @param type $yborderid
	 * @return type
	 */
	public function paymentQuery($orderid, $yborderid) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'orderid' => $orderid,
		    'yborderid' => $yborderid
		);
		return $this->get($this->getPaymentQueryURL(), $query);
	}

	/**
	 * 提现
	 * @param type $requestid
	 * @param type $identityid
	 * @param type $identitytype
	 * @param type $card_top
	 * @param type $card_last
	 * @param type $amount
	 * @param type $imei
	 * @param type $userip
	 * @param type $ua
	 * @return type
	 */
	public function withdraw($requestid, $identityid, $identitytype, $card_top, $card_last, $amount, $imei, $userip, $ua) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'requestid' => $requestid,
		    'identityid' => $identityid,
		    'identitytype' => $identitytype,
		    'card_top' => $card_top,
		    'card_last' => $card_last,
		    'amount' => $amount,
		    'currency' => 156,
		    'drawtype' => 'NATRALDAY_NORMAL',
		    'imei' => $imei,
		    'userip' => $userip,
		    'ua' => $ua
		);
		return $this->post($this->getWithdrawURL(), $query);
	}

	/**
	 * 银行卡信息查询
	 * @param type $cardno
	 * @return type
	 */
	public function bankcardCheck($cardno) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'cardno' => $cardno
		);
		return $this->post($this->getBankCardCheckURL(), $query);
	}

	/**
	 * 提现查询
	 * @param type $requestid
	 * @param type $ybdrawflowid
	 * @return type
	 */
	public function withdrawQuery($requestid, $ybdrawflowid) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'requestid' => $requestid,
		    'ybdrawflowid' => $ybdrawflowid
		);
		return $this->get($this->getQueryWithdrawURL(), $query);
	}

	/**
	 * 获取支付清算文件
	 * @param type $startdate
	 * @param type $enddate
	 * @return type
	 */
	public function payClearData($startdate, $enddate) {
		$query = array(
		    'merchantaccount' => $this->getMerchartAccount(),
		    'startdate' => $startdate,
		    'enddate' => $enddate
		);

		$url = $this->getUrl($this->getPayClearDataURL(), $query);
		$data = $this->http($url, 'GET');
		if ($this->http_info['http_code'] == 405) {
			throw new yeepayException('此接口不支持使用GET方法请求', 1003);
		}
		return $data;
	}

	/**
	 *
	 * @param string $url
	 * @param type $query
	 * @return string
	 */
	public function getUrl($url, $query) {
		$request = $this->buildRequest($query);
		$url .= '?' . http_build_query($request);
		return $url;
	}

	public function buildRequest($query) {
		if (!array_key_exists('merchantaccount', $query)) {
			$query['merchantaccount'] = $this->getMerchartAccount();
		}
		$sign = $this->RSASign($query);
		$query['sign'] = $sign;
		$request = array();
		$request['merchantaccount'] = $this->getMerchartAccount();
		$request['encryptkey'] = $this->getEncryptkey();
		$request['data'] = $this->AESEncryptRequest($query);
		return $request;
	}

	/**
	 * 用RSA 签名请求
	 * @param array $query
	 * @return string
	 */
	protected function RSASign(array $query) {
		if (array_key_exists('sign', $query)) {
			unset($query['sign']);
		}
		ksort($query);
		$this->RSA->loadKey($this->getMerchantPrivateKey());
		$sign = base64_encode($this->RSA->sign(join('', $query)));
		return $sign;
	}

	/**
	 * 通过RSA，使用易宝公钥，加密本次请求的AESKey
	 * @return string
	 */
	protected function getEncryptkey() {
		if (!$this->AESKey) {
			$this->generateAESKey();
		}
		$this->RSA->loadKey($this->yeepayPublicKey);
		$encryptKey = base64_encode($this->RSA->encrypt($this->AESKey));
		return $encryptKey;
	}

	/**
	 * 生成一个随机的字符串作为AES密钥
	 * @param number $length
	 * @return string
	 */
	protected function generateAESKey($length = 16) {
		$baseString = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$AESKey = '';
		$_len = strlen($baseString);
		for ($i = 1; $i <= $length; $i++) {
			$AESKey .= $baseString[rand(0, $_len - 1)];
		}
		$this->AESKey = $AESKey;
		return $AESKey;
	}

	/**
	 * 返回易宝返回数据的AESKey
	 * @param unknown $encryptkey
	 * @return Ambigous <string, boolean, unknown>
	 */
	protected function getYeepayAESKey($encryptkey) {
		$this->RSA->loadKey($this->merchantPrivateKey);
		$yeepayAESKey = $this->RSA->decrypt(base64_decode($encryptkey));
		return $yeepayAESKey;
	}

	/**
	 * 通过AES加密请求数据
	 * @param array $query
	 * @return string
	 */
	protected function AESEncryptRequest(array $query) {
		if (!$this->AESKey) {
			$this->generateAESKey();
		}
		$this->AES->setKey($this->AESKey);
		return base64_encode($this->AES->encrypt(json_encode($query)));
	}

	/**
	 * 模拟HTTP协议
	 * @param string $url
	 * @param string $method
	 * @param string $postfields
	 * @return mixed
	 */
	protected function http($url, $method, $postfields = NULL) {
		$this->http_info = array();
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
		curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
		curl_setopt($ci, CURLOPT_HEADER, FALSE);
		$method = strtoupper($method);
		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($postfields)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($postfields)) {
					$url = "{$url}?{$postfields}";
				}
		}
		curl_setopt($ci, CURLOPT_URL, $url);
		$response = curl_exec($ci);

		// Request failed
		if ($response === FALSE) {
			// throw error
			trigger_error('URL: ' .$url. 'ERROR_MSG:' .curl_error($ci), E_USER_ERROR);
		}

		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
		$this->url = $url;
		curl_close($ci);
		return $response;
	}

	/**
	 * Get the header info to store.
	 * @param type $ch
	 * @param type $header
	 * @return type
	 */
	public function getHeader($ch, $header) {
		$i = strpos($header, ':');
		if (!empty($i)) {
			$key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
			$value = trim(substr($header, $i + 2));
			$this->http_header[$key] = $value;
		}
		return strlen($header);
	}

	/**
	 * 解析返回数据
	 * @param type $data
	 * @return type
	 * @throws yeepayException
	 */
	public  function parseReturnData($data) {

		if(is_string($data)){
			$return = json_decode($data, true);
		}

		if(is_array($data)){
			$return = $data ;
		}

		//解析随机订单编号，使用真正订单号
		list($orderid, $time) = explode('_', $return['orderid']);
		$return['orderid'] = intval($orderid);


		try{
			if (array_key_exists('error_code', $return) && !array_key_exists('status', $return)) {
				throw new yeepayException($return['error_msg'], $return['error_code']);
			}

			$return  =  $this->parseReturn($return['data'], $return['encryptkey']);
			// request begin
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ yeepay return back first ++++', 'parameters' =>$return, 'response' => array('request_url'=>'','reqeust'=>array())));

				
			return $return;
		}catch(yeepayException $e){

			return $return;

		}
	}

	/**
	 * 解析返回数据
	 * @param type $data
	 * @param type $encryptkey
	 * @return type
	 * @throws yeepayException
	 */
	protected function parseReturn($data, $encryptkey) {
		$AESKey = $this->getYeepayAESKey($encryptkey);
		$return = $this->AESDecryptData($data, $AESKey);
		$return = json_decode($return, true);

		if($this->debug&&0){
			if (!array_key_exists('sign', $return)) {
				if (array_key_exists('error_code', $return)) {
					throw new yeepayException($return['error_msg'], $return['error_code']);
				}
				throw new yeepayException('请求返回异常', 1001);
			} else {
				if (!$this->RSAVerify($return, $return['sign'])) {
					throw new yeepayException('请求返回签名验证失败', 1002);
				}
			}
			if (array_key_exists('error_code', $return) && !array_key_exists('status', $return)) {
				throw new yeepayException($return['error_msg'], $return['error_code']);
			}
			unset($return['sign']);
		}

		if(isset($return['orderid'])){

			$order_id  = explode('_',$return['orderid']);

			$return['orderid'] = $order_id[0];

		}

		return $return;
	}

	/**
	 * 通过AES解密易宝返回的数据
	 * @param string $data
	 * @param string $AESKey
	 * @return Ambigous <boolean, string, unknown>
	 */
	protected function AESDecryptData($data, $AESKey) {
		$this->AES->setKey($AESKey);
		return $this->AES->decrypt(base64_decode($data));
	}

	/**
	 * 使用易宝公钥检测易宝返回数据签名是否正确
	 * @param array $query
	 * @param string $sign
	 * @return boolean
	 */
	protected function RSAVerify(array $return, $sign) {
		if (array_key_exists('sign', $return)) {
			unset($return['sign']);
		}
		ksort($return);
		$this->RSA->loadKey($this->yeepayPublicKey);
		foreach ($return as $k => $val) {
			if (is_array($val)) {
				$return[$k] = self::cn_json_encode($val);
			}
		}
		return $this->RSA->verify(join('', $return), base64_decode($sign));
	}

	/**
	 * json_encode
	 * @param type $value
	 * @return type
	 */
	public static function cn_json_encode($value) {
		if (defined('JSON_UNESCAPED_UNICODE')) {
			return json_encode($value, JSON_UNESCAPED_UNICODE);
		} else {
			$encoded = urldecode(json_encode(self::array_urlencode($value)));
			return preg_replace(array('/\r/', '/\n/'), array('\\r', '\\n'), $encoded);
		}
	}

	/**
	 * urlencode
	 * @param type $value
	 * @return type
	 */
	public static function array_urlencode($value) {
		if (is_array($value)) {
			return array_map(array('yeepay', 'array_urlencode'), $value);
		} elseif (is_bool($value) || is_numeric($value)) {
			return $value;
		} else {
			return urlencode(addslashes($value));
		}
	}

	/**
	 * 使用POST的方式发出API请求
	 * @param type $url
	 * @param type $query
	 * @return type
	 * @throws yeepayException
	 */
	protected function post($url, $query) {




		if($this->debug){
			echo "URL: $url <br>QUERY:";
			dump($query);
		}



		// request begin
		AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++yeepay request begin send +++++\r\n ', 'parameters' =>$query, 'response' => array('request_url'=>'','reqeust'=>array())));


		$request = $this->buildRequest($query);
		$data = $this->http($url, 'POST', http_build_query($request));
		if ($this->http_info['http_code'] == 405) {
			throw new yeepayException('此接口不支持使用POST方法请求', 1004);
		}
		return $this->parseReturnData($data);
	}

	/**
	 * 使用GET的模式发出API请求
	 * @param string $type
	 * @param string $method
	 * @param array $query
	 * @return array
	 */
	protected function get($url, $query) {

		if($this->debug){
			echo 'QUERY:';
			dump($query);
		}

		$request = $this->buildRequest($query);
		$url .= '?' . http_build_query($request);
		$data = $this->http($url, 'GET');
		if ($this->http_info['http_code'] == 405) {
			throw new yeepayException('此接口不支持使用GET方法请求', 1003);
		}
		return $this->parseReturnData($data);
	}


	/**
	 * 获取其他app的绝对URL
	 * NOTE: 使用配置文件中XXServerName，没有设置则使用当前host
	 *
	 * @param  string    $route     页面路由
	 * @param  array     $params    页面参数列表
	 * @return string               绝对路径
	 */
	public function createOtherAppUrl($serverName, $route = '', $params = array()) {
		// 路由参数设置
		$urlRoute = '';
		$urlParams = array();
		if (!empty($route)) {
			$urlRoute = $route;
		}
		if (!empty($params)) {
			$urlParams = $params;
		}

		// 生成url
		$otherAppUrl = Yii::app()->params[$serverName];
		if (empty($otherAppUrl)) {
			$otherAppUrl = Yii::app()->getRequest()->getHostInfo('http');
			$otherAppUrl .= Yii::app()->createUrl($urlRoute, $urlParams);
		} else {
			$url = Yii::app()->createUrl($urlRoute, $urlParams);
			$replace = Yii::app()->getRequest()->getScriptUrl();
			//left trim current script url
			$otherAppUrl .= (stripos($url, $replace) === 0) ? substr_replace($url, '', 0, strlen($replace)) : $url;
		}

		return $otherAppUrl;
	}

}

class yeepayException extends Exception {

}

function dump($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre><hr/>';
}