<?php


//易宝业务类
require_once 'lib/yeepay.class.php';


class YeepayBase extends yeepay{


	public static $logKey = '[ares_log_error][xqsj_yeepay_billing]';

	private $_callbackurl = '';//回调地址

	private $_ip = '';//本地ip

	private $_identitytype = 2;//用户识别类型

	private $_requestid ;//请求流水号

	private $_userbaseinfo = array();//用户基本信息

	private $_member_id   = 0 ;//用户编号

	public  $_error   = '';//错误
	public  $_error_id   = 0;//错误编号

	private  $_des_key   = 'QADCJNBGF';//错误编号


	//易宝支持的银行列表
	private  $_suport_bank_list = array(

			'ICBC'=>'工商银行',
			'BOC'=>'中国银行',
			'CCB'=>'建设银行',
			'POST'=>'邮政储蓄',
			'ECITIC'=>'中信银行',
			'CEB'=>' 光大银行',
			'HXB'=>' 华夏银行',
			'CMBCHINA'=>'招商银行',
			'CIB'=>'兴业银行',
			'SPDB'=>'浦发银行',
			'PINGAN'=>'平安银行',
			'GDB'=>'广发银行',
			'CMBC'=>'民生银行',
			'ABC'=>'农业银行',
			'BOCO'=>'交通银行',
	);


	public function __construct($member_id = 0){


		//初始化
		$this->_init($member_id);

		//		$config = array(
		//		    'merchantAccount' => '10000419568',
		//		    'merchantPublicKey' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCKxayKB/TqDXtcKaObOPPzVL3r++ghEP45nai9cjG0JQt9m0F5+F8RVygizxS83iBTHd5bJbrMPLDh3GvjGm1bbJhzO4m2bF2fQm2uJ0C3ckdm9AZK8fqzcncpu2dy1zFyucFyHhKIgZryqfW5PS3G9UohS4698qA5j4dceWf5PwIDAQAB',
		//		    'merchantPrivateKey' => 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAIrFrIoH9OoNe1wpo5s48/NUvev76CEQ/jmdqL1yMbQlC32bQXn4XxFXKCLPFLzeIFMd3lslusw8sOHca+MabVtsmHM7ibZsXZ9Cba4nQLdyR2b0Bkrx+rNydym7Z3LXMXK5wXIeEoiBmvKp9bk9Lcb1SiFLjr3yoDmPh1x5Z/k/AgMBAAECgYEAgAjVohypOPDraiL40hP/7/e1qu6mQyvcgugVcYTUmvK64U7HYHNpsyQI4eTRq1f91vHt34a2DA3K3Phzifst/RoonlMmugXg/Klr5nOXNBZhVO6i5XQ3945dUeEq7LhiJTTv0cokiCmezgdmrW8n1STZ/b5y5MIOut8Y1rwOkAECQQC+an4ako+nPNw72kM6osRT/qC589AyOav60F1bHonK6NWzWOMiFekGuvtpybgwt4jbpQxXXRPxvJkgBq873fwBAkEAupGaEcuqXtO2j0hJFOG5t+nwwnOaJF49LypboN0RX5v8nop301//P16Bs/irj5F/mAs9lFR4GZ3bxL8zs5r1PwJBALa1MDMHFlf+CcRUddW5gHCoDkjfLZJDzEVp0WoxLz5Hk2X3kFmQdHxExiCHsfjs4qD/CYx6fzyhHrygLVxgcAECQAT8z3maUDuovUCnVgzQ2/4mquEH5h8Cxe/02e46+rPrn509ZmaoMlKnXCBLjYqRATA3XLYSbAODTNS9p8wtYFECQHa/xgB+nYWoevPC/geObOLAP9HMdNVcIAJq2rgeXVI4P7cFXvksRborHmjuy1fltoR0003qlSg82mxzABbzYUs=',
		//		    'yeepayPublicKey' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCj4k0oTc05UzrvBB6g24wsKawTlIX5995q3CQYrgM5un9mKEQc/NQIsJqqG2RUHyXUIBogMaMqG1F1QPoKMaXeVfVUSYa8ZU7bV9rOMDUT20BxAmPbtLlWdTSXDxXKXQxwkyfUAih1ZgTLI3vYg3flHeUA6cZRdbwDPLqXle8SIwIDAQAB'
		//		    );


		if(Yii::app()->params['yeepay']['merchantAccount'] != ""){
			$config = array(
		    'merchantAccount' =>  Yii::app()->params['yeepay']['merchantAccount'],
		    'merchantPublicKey' =>  Yii::app()->params['yeepay']['merchantPublicKey'],
		    'merchantPrivateKey' =>  Yii::app()->params['yeepay']['merchantPrivateKey'],
		    'yeepayPublicKey' =>  Yii::app()->params['yeepay']['yeepayPublicKey']
			);
		}else{

			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ yeepay init error need merchantAccount,merchantPublicKey ect ++++', 'parameters' =>array(), 'response' => array('request_url'=>$_SERVER['QUERY_STRING'],'reqeust'=>$_REQUEST)));
			$this->error = '缺少支付配置';
			return false ;

		}

		parent::__construct($config);

	}


	//初始化类的配置项
	private function _init($member_id){


		AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ yeepay init start ++++', 'parameters' =>array(), 'response' => array('request_url'=>$_SERVER['QUERY_STRING'],'reqeust'=>$_REQUEST)));


		//检查yii配置项
		if(!is_array(Yii::app()->params['yeepay'])){
			die('need yeepay config!');
		}

		$this->_member_id  = $member_id;

		//		$_GET['debug'] = '1';

		$this->debug =  $_GET['debug'] == '1'?true:false;

		$this->_callbackurl = Yii::app()->params['yeepay']['callback_url'];

		$this->_ip = Yii::app()->params['yeepay']['server_ip'];

		$this->_requestid  = date('YmdHis') . rand(1000000, 9000000);



	}



	//查询用户基本信息
	public function getUserBaseInfo(){

		//远程连接地址
		$url = $this->createOtherAppUrl('UCenterServerName','api/getUserInfo', array('memberIds' =>$this->_member_id));

		//调用远程接口，获取用户基干信息
		$restResponse = file_get_contents($url);

		//判断远程是否有数据	
		if( $restResponse != "" ){
			$arrResponse = json_decode($restResponse, true);
			if( !empty($arrResponse) ){
				return  $arrResponse['data'][$this->_member_id]['userinfo'];
			}
		}else{
			return false ;
		}

	}


	//按用户id和平台编号获取用户信息
	public function getPlatInfo($platform_type = 3){

		if($this->_member_id!=''){

			$arrSqlParams = array(
            	'condition' => "member_id='{$this->_member_id}' and platform_type='{$platform_type}' ",
			);

			//查询 uc_trading_platform 用户信息
			$platObject = UcTradingPlatform::model()->find($arrSqlParams);
			$platinfo = OBJTool::convertModelToArray($platObject);

			$platinfo['platinfo'] = $platinfo;

			$baseinfo = $this->getUserBaseInfo();

			if( $baseinfo !== false ){
					
				$platinfo['userinfo'] = $baseinfo;
					
			}

			// get user base info
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ get user base info ready+++++\r\n ', 'parameters' => $platinfo, 'response' => array('request_url'=>$_SERVER['QUERY_STRING'],'reqeust'=>$_REQUEST)));

			return $platinfo;

		}else{
			$this->error = '用户编号不能为空';
			$this->error_id = 1007011;
			return false ;
		}

	}

	/**
	 * 根据卡号查询用户绑卡信息
	 * @param unknown_type $card_no
	 */
	function getPlatInfoById($plat_id,$get_all = false){

		$arrSqlConditon = array(
			'condition' => 't.id="'.intval($plat_id).'"',
		);

		$result = UcTradingPlatform::model()->with('member')->find( $arrSqlConditon );

		//判断信息是否存在
		if(!empty($result)){
			$platinfo = OBJTool::convertModelToArray($result);

			if(!$get_all){
				$userinfo = array(
		        'member_id' => $platinfo['member_id'],
				'bind_status' => $platinfo['bind_status'],
	         	'real_name' => $platinfo['real_name'],
	         	'platform_account' => $platinfo['platform_account'],
	        	'member_mobile'=>$platinfo['member_mobile'],
	        	'member_id_number'=>$platinfo['member']['member_id_number'],
			    'deal_password'=>$platinfo['member']['deal_password'],
				'deal_password'=>$platinfo['member']['deal_password']
				);

				return $userinfo;
			}else{
				return $platinfo;
			}

		}else{
			return false ;
		}
	}

	/**
	 * 绑卡
	 * @param unknown_type $member_id 用户编号
	 */
	public function bindYeepayCard($userinfo = array(),$plat_id = null){

		//按渠道编号查出
		if($plat_id != ""){
			$user = $this->getPlatInfoById($plat_id);

			$user['platform_account'] = $this->_decode_string($user['platform_account']);

			if($user === false ){
				$this->error = '支付信息不存在';
				$this->error_id = 1007014;
				return false ;
			}

		}elseif (!empty($userinfo)){//如果已指定绑定信息
			$user = $userinfo ;
		}else{
			$this->_checkUserBaseInfo();
			//获取用户信息
			$user = $this->_userbaseinfo;

		}

		$requestid = $this->_requestid;
		$identityid = $this->_getIdentitfyid($user);
		$identitytype = $this->_identitytype;

		$cardno =   trim($user['platform_account']);

		$idcardno = trim($user['member_id_number']);
		$username = trim($user['real_name']);
		$phone = trim($user['member_mobile']);

		//		$registerphone = trim($user['userinfo']['db_member_mobile']);
		//		$registerdate = trim($_POST['registerdate']);
		//		$registerip = trim($_POST['registerip']);

		$registeridcardno = trim($_POST['registeridcardno']);
		$registercontact = trim($_POST['registercontact']);

		//		$os = trim($_POST['os']);
		//		$imei = trim($_POST['imei']);

		$userip = '127.0.0.1';
		//		$ua = trim($_POST['ua']);

		$data = $this->bindBankcard($identityid, $identitytype, $requestid, $cardno, $idcardno, $username, $phone, $registerphone, $registerdate, $registerip, $registeridcardno, $registercontact, $os, $imei, $userip, $ua);
		//file_put_contents('/tmp/yeepay_debug.log', var_export($data, true), FILE_APPEND);

		if($plat_id!="") {
			$data['plat_id'] = $plat_id;
		}

		if(isset($data['error_code'])){
			AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => ' ++++++ request yeepay card bind fail ++\r\n ', 'parameters' =>$user , 'response' =>$data));
		}else{
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ request yeepay card bind success ++\r\n ', 'parameters' =>$user , 'response' =>$data));
		}

		return $data;

	}



	/**
	 * //确认银行卡绑定
	 * @param $requestid 绑卡返回的请求流水号
	 * @param $validatecode 手机验证码
	 */
	public function confirmCardBind($requestid, $validatecode,$plat_id){


		if($requestid!="" &&$validatecode!=""){


			//发送短信确认
			$data =  $this->bindBankcardConfirm($requestid, $validatecode);


			if(!isset($data['error_code'])){
				if($plat_id!=""){
					try{
						//更新绑定状态
						$condition = " id='{$plat_id}' or member_id ='".$this->_member_id."' ";

						$platObj = UcTradingPlatform::model()->find($condition);

						if(!empty($platObj)){

							$platObj->bind_status= 1;
							$platObj->bank_code= $data['bankcode'];//从接口中获取绑定卡号的银行代码
							$id = $platObj->save();
						}

					}catch(Exception $e){

						//					 echo $e->getMessage();
					}
				}else{
					$this->error = '缺乏支付渠道编号,plat_id!';
					$this->error_id = 1007016;
					return false ;
				}
			}

			if(isset($data['error_code'])){
				AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => ' ++++++ yeepay bind card confirm fail ++\r\n ', 'parameters' =>$user , 'response' =>$data));
			}else{
				AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ yeepay bind card confirm success ++\r\n ', 'parameters' =>$user , 'response' =>$data));
			}


			return $data ;

		}else{
			$this->error = '请求码或手机验证码或卡号不能为空';
			$this->error_id = 1007010;
			return false ;
		}

	}

	/**
	 * //查询支付结果
	 * @param unknown_type $orderid 订单编号
	 * @param unknown_type $yborderid 易宝流水号
	 */
	public function queryPay($orderid, $yborderid){

		if($orderid!="" &&$yborderid!=""){
			return $this->paymentQuery($orderid, $yborderid);
		}else{
			return false ;
		}

	}

	/**
	 * 支付
	 * @param unknown_type $order_id //订单编号
	 * @param unknown_type $pwd //交易密码
	 * @param unknown_type $plat_id //渠道id
	 * @return unknown|string|string
	 */
	public function directPay($order_id,$pwd,$plat_id,$amount_money = null){


		$this->_checkUserBaseInfo();

		//获取用户信息
		$user = $this->getPlatInfoById($plat_id);

		//如果绑定关系不存在
		if($user === false ){

			$this->error = '绑定关系不存在，请先绑定银行卡';
			$this->error_id = 1;
			return false ;
			exit();
		}

		//限定只能使用本人卡进行支付
		if($this->_member_id != $user['member_id']){

			$this->error = '请使用本人的银行卡';
			$this->error_id = 1;
			return false ;
			exit();
		}


		//验证交易密码
		$validate = AresUtil::validatePassword($pwd,$user['deal_password']);

		if($validate){

			// 获取订单信息
			$objOrder = LcOrder::model()->published()->findByPk($order_id);

			if(!empty($objOrder)){
				$order_info = OBJTool::convertModelToArray($objOrder);

				if(!empty($amount_money)&&intval($amount_money)>0){
					$amount = $amount_money;//
				}else{
					$amount = $order_info['order_total'];//
				}
				$amount *= 100;

				//+++++++++++++++ 注意！！！！正式环境需注释  $amount = 1 +++++++++++++++++++
				if(Yii::app()->params['yeepay']['test']!=""){
					$amount = 1;
				}
				//+++++++++++++++++++++++++++++++++++

				//使用真正订单号生成随机订单号
				$orderid = trim($order_id).'_'.time();
				$transtime = time();

				$productname = trim($order_info['item_name']);//*

				$identityid = $this->_getIdentitfyid($user);
				$identitytype = $this->_identitytype;

				$card_top = $this->_getCartNo($user,'card_top');
				$card_last = $this->_getCartNo($user,'card_last');

				$orderexpdate = intval(60);
				$callbackurl = trim($this->_callbackurl);
				$userip = trim($this->_ip);

				$data = $this->directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua);

				//保存支付记录
				if(!empty($data)&&!empty($order_info)){
					$savedata = array_merge($data,$order_info);
					$this->savePayLog($savedata);
				}

				return $data;
					
			}else{
				$this->error = '订单不存在';
				$this->error_id = 1007009;
				return false ;
			}

		}else{

			$this->error = '交易密码错误';
			$this->error_id = 1007008;
			return false ;
		}

	}


	/**
	 * 仟金所分权支付
	 * @param unknown_type $order_id //订单编号
	 * @param unknown_type $pwd //交易密码
	 * @param unknown_type $plat_id //渠道id
	 * @return unknown|string|string
	 */
	public function directQjsFqPay($order_id,$pwd,$plat_id,$amount_money = null){

		$this->_checkUserBaseInfo();

		//获取用户信息
		$user = $this->getPlatInfoById($plat_id);

		//验证交易密码
		$validate = AresUtil::validatePassword($pwd,$user['deal_password']);

		if($validate){

			// 获取订单信息
			$objOrder = FqFenquanOrder::model()->with('items')->findByPk($order_id);

			if(!empty($objOrder)){
				$order_info = OBJTool::convertModelToArray($objOrder);
				// 项目信息
				$objProject = FqHouse::model()->findByPk(intval($order_info['items']['0']['item_id']));
				$item_name = $objProject->house_name;

				//
				if(!empty($amount_money)&&intval($amount_money)>0){
					$amount = $amount_money;//
				}else{
					$amount = $order_info['order_total'];//
				}


				//使用真正订单号生成随机订单号
				$orderid = trim($order_id).'_'.time();
				$transtime = time();

				//++++++++++调试阶段完成后，去掉此段代码++++++++++
				//调试阶段将支付金额设定为1分
				//$amount = 1;//
				//++++++++++++++++++++
				$amount *= 100;

				if(Yii::app()->params['yeepay']['test']!=""){
					$amount = 1;
				}

				$productname = trim($item_name);//*

				$identityid = $this->_getIdentitfyid($user);
				$identitytype = $this->_identitytype;

				$card_top = $this->_getCartNo($user,'card_top');
				$card_last = $this->_getCartNo($user,'card_last');


				$orderexpdate = intval(60);
				$callbackurl = trim($this->_callbackurl);
				$userip = trim($this->_ip);

				$data = $this->directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua);


				//保存支付记录
				if(!empty($data)&&!empty($order_info)){
					$savedata = array_merge($data,$order_info);
					$this->savePayLog($savedata,'FqFenquanPaymentYeepay');
				}

				return $data;
					
			}else{
				$this->error = '订单不存在';
				$this->error_id = 1007009;
				return false ;
			}

		}else{

			$this->error = '交易密码错误';
			$this->error_id = 1007008;
			return false ;
		}

	}


	/**
	 * 分权支付
	 * @param unknown_type $order_id //订单编号
	 * @param unknown_type $pwd //交易密码
	 * @param unknown_type $plat_id //渠道id
	 * @return unknown|string|string
	 */
	public function directFqPay($order_id,$pwd,$plat_id,$amount_money = null){

		$this->_checkUserBaseInfo();

		//获取用户信息
		$user = $this->getPlatInfoById($plat_id);

		//验证交易密码
		$validate = AresUtil::validatePassword($pwd,$user['deal_password']);

		if($validate){

			// 获取订单信息

			$sql =  "SELECT * from `xqsj_db`.`fq_fenquan_order` where order_id='{$order_id}'";
			$connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$order_info = $command->queryRow();

			if(!empty($order_info)){
                $amount=$amount_money;
                //$amount = $order_info['order_total'];//设置支付金额

				//++++++++++调试阶段完成后，去掉此段代码++++++++++
				//调试阶段将支付金额设定为1分
				//$amount = 1;//
				//++++++++++++++++++++
				$amount *= 100;

				if(Yii::app()->params['yeepay']['test']!=""){
					$amount = 1;
				}

				//使用真正订单号生成随机订单号
				$orderid = trim($order_id).'_'.time();
				$transtime = time();

				$productname = trim($order_info['item_name']);//*

				$identityid = $this->_getIdentitfyid($user);
				$identitytype = $this->_identitytype;

				$card_top = $this->_getCartNo($user,'card_top');
				$card_last = $this->_getCartNo($user,'card_last');

				$orderexpdate = intval(60);
				$callbackurl = trim($this->_callbackurl);
				$userip = trim($this->_ip);

				$data = $this->directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua);


				//保存支付记录
				if(!empty($data)&&!empty($order_info)){
					$savedata = array_merge($data,$order_info);

					$sql = " INSERT INTO `xqsj_db`.`fq_fenquan_payment_yeepay` (`requestid`, `member_id`, `project_id`, `subject`, `body`, `merchantaccount`, `yborderid`,`sendorderid`, `identityid`, `card_last`, `status`, `errorcode`, `errormsg`, `sign`, `last_modified`,`create_time`,`pay_amount`)";

					$sql .= " VALUES ('{$this->_requestid}', '{$order_info['customer_id']}', '{$order_info['item_id ']}', '{$order_info['item_name']}', '', '', '{$data['yborderid']}','{$orderid}','','','' , '{$data['error_code']}', '{$data['error_msg']}', '', '', '".date('Y-m-d H:i:s')."','{$amount_money}');";

					$connection = Yii::app()->db;
					$command = $connection->createCommand($sql);
					$order_info = $command->execute();


				}

				return $data;
					
			}else{
				$this->error = '订单不存在';
				$this->error_id = 1007009;
				return false ;
			}

		}else{

			$this->error = '交易密码错误';
			$this->error_id = 1007008;
			return false ;
		}

	}


	/**
	 * 分权支付
	 * @param unknown_type $order_id //订单编号
	 * @param unknown_type $pwd //交易密码
	 * @param unknown_type $plat_id //渠道id
	 * @return unknown|string|string
	 */
	public function directZcPay($order_id,$pwd,$plat_id,$amount_money = null){

		$this->_checkUserBaseInfo();

		//获取用户信息
		$user = $this->getPlatInfoById($plat_id);

		//验证交易密码
		$validate = AresUtil::validatePassword($pwd,$user['deal_password']);

		if($validate){

			// 获取订单信息

			$sql =  "SELECT * from `xqsj_db`.`zc_order` where order_id='{$order_id}'";
			$connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$order_info = $command->queryRow();

			if(!empty($order_info)){


				$sql =  "SELECT * from `xqsj_db`.`zc_order_item` where order_id='{$order_id}'";
				$connection = Yii::app()->db;
				$command = $connection->createCommand($sql);
				$order_item = $command->queryRow();



				$amount = $order_info['order_total'];//

				//++++++++++调试阶段完成后，去掉此段代码++++++++++
				//调试阶段将支付金额设定为1分
				//$amount = 1;//
				//++++++++++++++++++++
				$amount *= 100;


				if(Yii::app()->params['yeepay']['test']!=""){
					$amount = 1;
				}

				//使用真正订单号生成随机订单号
				$orderid = trim($order_id).'_'.time();
				$transtime = time();

				$productname = trim($order_item['item_name']);//*

				$identityid = $this->_getIdentitfyid($user);
				$identitytype = $this->_identitytype;

				$card_top = $this->_getCartNo($user,'card_top');
				$card_last = $this->_getCartNo($user,'card_last');

				$orderexpdate = intval(60);
				$callbackurl = trim($this->_callbackurl);
				$userip = trim($this->_ip);

				$data = $this->directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua);


				//保存支付记录
				if(!empty($data)&&!empty($order_info)){
					$savedata = array_merge($data,$order_info);

					$sql = " INSERT INTO `xqsj_db`.`zc_payment_yeepay` (`requestid`, `member_id`, `project_id`, `subject`, `body`, `merchantaccount`, `yborderid`,`sendorderid` ,`identityid`,`card_last`, `status`, `errorcode`, `errormsg`, `sign`, `last_modified`,`create_time`)";

					$sql .= " VALUES ('{$this->_requestid}', '{$order_info['customer_id']}', '{$order_info['item_id ']}', '{$order_info['item_name']}', '', '', '{$data['yborderid']}','{$orderid}','','','','{$data['error_code']}', '{$data['error_msg']}', '', '', '".date('Y-m-d H:i:s')."')";

					$connection = Yii::app()->db;
					$command = $connection->createCommand($sql);
					$order_info = $command->execute();


				}

				return $data;
					
			}else{
				$this->error = '订单不存在';
				$this->error_id = 1007009;
				return false ;
			}

		}else{

			$this->error = '交易密码错误';
			$this->error_id = 1007008;
			return false ;
		}

	}


	/**
	 * 支付
	 * @param unknown_type $order_id //订单编号
	 * @param unknown_type $pwd //交易密码
	 * @param unknown_type $plat_id //渠道id
	 * @return unknown|string|string
	 */
	public function directRecharge($order_id,$pwd,$plat_id){

		//获取用户信息
		$user = $this->getPlatInfoById($plat_id);

		//验证交易密码
		$validate = AresUtil::validatePassword($pwd,$user['deal_password']);

		if($validate){

			// 获取订单信息
			$objOrder = UcMemberOrder::model()->published()->findByPk($order_id);

			if(!empty($objOrder)){

				$order_info = OBJTool::convertModelToArray($objOrder);

				$orderid = trim($order_id);//''.rand(1000,300000);//trim($order_id);//;trim($order_id);
				$transtime = time();
				//$amount = 1;
				$amount = 100 * intval($order_info['order_total']);//*
				$productname = trim('充值');//*

				$identityid = $this->_getIdentitfyid($user);
				$identitytype = $this->_identitytype;

				$card_top = $this->_getCartNo($user,'card_top');
				$card_last = $this->_getCartNo($user,'card_last');

				$orderexpdate = intval(10);

				$callbackurl = trim($this->_callbackurl);

				$userip = trim($this->_ip);

				$data = $this->directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua);

				return $data;
					
			}else{
				$this->error = '订单不存在';
				$this->error_id = 1007009;
				return false ;
			}

		}else{

			$this->error = '交易密码错误';
			$this->error_id = 1007008;
			return false ;
		}

	}


	//记录交易日志
	public function savePayLog($backData,$model = 'LcPaymentYeepay'){

		$lcPaymentObj = new $model();

		$lcPaymentObj->project_id = $backData['item_id'];
		$lcPaymentObj->subject = $backData['item_name'];

		$lcPaymentObj->requestid = $this->_requestid ;
		$lcPaymentObj->member_id = $backData['customer_id'] ;

		$lcPaymentObj->orderid = $backData['order_id'];

		if(isset( $backData['error_code'])){
			$lcPaymentObj->errorcode = $backData['error_code'];
			$lcPaymentObj->errormsg  = $backData['error_msg'];
		}else{
			$lcPaymentObj->amount = $backData['amount'];
		}

		$lcPaymentObj->yborderid = $backData['yborderid'];

		//防止多次提交造成的异常
		try{
			$lcPaymentObj->insert();
		}catch(Exception $e){

			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ++++++ save pay log fail reason:'.$lcPaymentObj->errors, 'parameters' => $lcPaymentObj->errors, 'response' => array('request_url'=>$_SERVER['QUERY_STRING'],'reqeust'=>$_REQUEST)));

		}

	}

	/**
	 * 提现
	 * @param unknown_type $member_id 用户编号
	 * @param unknown_type $amount 提现金额
	 * @param unknown_type $drawtype 提现类型  NATRALDAY_NORMAL = 自然日T+1 ，NATRALDAY_URGENT = 自然日T+
	 */
	public function doWithDraw($member_id,$amount = 0,$drawtype = 'NATRALDAY_NORMAL'){

		$this->_checkUserBaseInfo();

		//获取用户信息
		$user = $this->_userbaseinfo;

		//指定流水号
		$requestid = $this->_requestid;

		$identityid = $this->_getIdentitfyid($user);
		$identitytype = $this->_identitytype;

		$card_top = $this->_getCartNo($user,'card_top');
		$card_last = $this->_getCartNo($user,'card_last');


		$amount = 100 * intval($amount);
		//		$imei = trim($_POST['imei']);
		$userip = $this->_ip;
		//		$ua = trim($_POST['ua']);


		$data = $this->withdraw($requestid, $identityid, $identitytype, $card_top, $card_last, $amount, $imei, $userip, $ua,$drawtype);

		return $data;

	}

	//获取易宝支持的银行列表
	public function getBankList(){

		return $this->_suport_bank_list;

	}

	//获取易宝支持的银行列表
	public function getlocatBindList($customer_id){

		// 查看卡是否存在
		$condtion = array(
				'condition'=>" member_id='{$customer_id}' AND platform_type=3 and bind_status=1"
		);

		$ojbUcTradingPlatform = UcTradingPlatform::model()->orderBy('create_time desc')->findAll( $condtion );
		$platinfo = OBJTool::convertModelToArray($ojbUcTradingPlatform);


		//计算并添加一下前台要用到的数据 
		if(!empty($platinfo)){
			foreach($platinfo as $key=>$list){


				$cardno = $this->_decode_string($list['platform_account']);

				$platinfo[$key]['card_top'] = trim(substr($cardno,0,6));
				$platinfo[$key]['card_last'] = trim(substr($cardno,(strlen($cardno)-4),4));

				$platinfo[$key]['card_name'] = $this->_suport_bank_list[$list['bank_code']];
				$platinfo[$key]['plat_id'] = $list['id'];
			}

		}else{
			$platinfo = array();//为app处理方便起见，将此置为空数组
		}

		$back = array('cardlist'=>$platinfo,'identityid'=>$customer_id);

		return $back ;
	}




	//记录用户用于绑卡的基干信息
	public function installUserData( $userInfo = array(),$upbase = true){
		//
		if(!empty($userInfo)){

			$condtion= array(
				'condition'=>" t.bind_status=1 and ( member.member_id_number='".$this->_encode_string($userInfo['member_id_number'])."' or t.platform_account='".$this->_encode_string($userInfo['platform_account'])."' ) "
				);

				$ucmemberOjb = UcTradingPlatform::model()->with('member')->find($condtion);


				//身份证排重
				if(empty($ucmemberOjb)){

					$data = $this->bindYeepayCard($userInfo,null);



					//判断绑卡是否失败
					if($data['error_code'] == "" && $data['error_msg'] == "" ){


						// 更新用户信息
						$mem_update = array();
						if($userInfo['member_id_number']!="") {
							$mem_update['member_id_number'] = $userInfo['member_id_number'];
						}
						if($userInfo['real_name']!="") {
							$mem_update['member_fullname'] = $userInfo['real_name'];
						}
						if(trim($userInfo['deal_password'])!="") {
							$mem_update['deal_password'] = AresUtil::encryptPassword($userInfo['deal_password']);
						}


						$memberObj = UcMember::model()->findByPk($userInfo['member_id']);
						// update
						if(!empty($mem_update)&&!empty($memberObj)) {

							$memberObj->member_fullname = $userInfo['real_name'];
							$memberObj->member_id_number = $userInfo['member_id_number'];

							$memberObj->is_idnumber_actived = 1;

							try{
								$id = $memberObj->save();
							}catch(Exception $e){
								echo $e->getMessage();
							}

						}

						//对卡片信息进行加密
						$cardecode = $this->_encode_string($userInfo['platform_account']);
						// 查看卡是否存在
						$condtion = array(
				'condition'=>" member_id='{$userInfo['member_id']}' AND platform_type=3 AND platform_account='{$cardecode}'"
						);
						$ojbUcTradingPlatform = UcTradingPlatform::model()->find( $condtion );
						$platinfo = OBJTool::convertModelToArray($ojbUcTradingPlatform);

						// 不存在则创建对象
						if (empty($ojbUcTradingPlatform)) {

							$ojbUcTradingPlatform = new UcTradingPlatform();

						}

						// set attributes
						$ojbUcTradingPlatform->member_id = $userInfo['member_id'];
						$ojbUcTradingPlatform->real_name = $userInfo['real_name'];
						$ojbUcTradingPlatform->platform_type = 3;//平台设置为易宝
						$ojbUcTradingPlatform->platform_account = $this->_encode_string($userInfo['platform_account']);
						$ojbUcTradingPlatform->member_mobile = $userInfo['member_mobile'];
						$ojbUcTradingPlatform->bank_code = $userInfo['bank_code'];
						
						if(isset($ojbUcTradingPlatform->identitfyid)){
							
							$ojbUcTradingPlatform->identitfyid = $this->_getIdentitfyid($userinfo) ;
						
						}

						// 插入或更新数据
						$id = $ojbUcTradingPlatform->save();

						if(!empty($platinfo)){
							$data['plat_id'] = $platinfo['id'];
						}else{
							$data['plat_id'] = $ojbUcTradingPlatform->primaryKey;

						}


						return $data;

					}else{
						$this->error = $data['error_msg'];
						$this->error_id = $data['error_code'];
						return false ;
					}
				}else{
					$this->error = '该身份证或卡已被绑定';
					$this->error_id = '1';
					return false ;
				}
		}else{
			$this->error = '用户信息为空';
			$this->error_id = 1007015;
			return false ;
		}

		//没传用户信息
		return false ;
	}

	/**
	 *进行des加密
	 */
	private function _encode_string($str){

		$AresObj = new AresCryptDes($this->_des_key);

		return  $AresObj->encrypt($str);

	}

	/**
	 *进行des解密
	 */
	private function _decode_string($str){

		if(!is_numeric($str)){
			$AresObj = new AresCryptDes();

			$str = $AresObj->decrypt($str);
			if(!is_numeric($str)){
				$str = $AresObj->decrypt($str);
			}
		}

		//如果解密失败，在返回原字符串
		return $str;

	}

	/**
	 * 查询绑卡信息
	 * @param $member_id
	 */
	public function getBindList(){

		$this->_checkUserBaseInfo();
		//获取用户信息
		$user = $this->_userbaseinfo;

		$identityid = $this->_getIdentitfyid($user);

		$identitytype = $this->_identitytype;

		$data = $this->bankcardList($identityid, $identitytype);

		return $data ;


	}

	/**
	 * 获取用户识别码
	 * @param unknown_type $userinfo 用户信息
	 */
	private function _getIdentitfyid($userinfo){
		
		$platinfo = $this->getPlatInfo();
		
		if(isset($platinfo['identitfyid'])&&$platinfo['identitfyid']!=""){
		
		      return $platinfo['identitfyid'];
		      
		}

		if($this->_identitytype == 2){

			if (!empty($this->_member_id)) {
				$dentitfyid =  $this->_member_id;
			} else {
				$dentitfyid =  $userinfo['member_id'];
			}
		}

		if($this->_identitytype == 4){
			$dentitfyid =  $userinfo['member_mobile'];
		}

		if($this->_identitytype == 5){
			$dentitfyid =  $userinfo['db_member_id_number'];
		}

		$merchantAccount = trim(Yii::app()->params['yeepay']['merchantAccount']);
		
		$server_name = $_SERVER['SERVER_NAME'] ;

		if($merchantAccount == '10012472967' || strrpos($server_name,'shijie')!==false){
			return strval('xqsjcom0815_'.$dentitfyid);
		}else if ($merchantAccount == '10012478788' || $merchantAccount == '10000419568'){
			return strval('xqsjcom0815_'.$dentitfyid);
		}
		
		return strval('xqsjcom0815_'.$dentitfyid);
	}




	/**
	 * 按照指定类型，获取银行卡位数
	 * @param unknown_type $user 用户数据
	 * @param unknown_type $type card_top = 前6位,card_last 后4位
	 * @return string|string|string
	 */
	private function _getCartNo($user,$type){


		if(!is_numeric($user['platform_account'])){
			$card = trim($this->_decode_string($user['platform_account']));

			if(!is_numeric($card)){
					
				$card = trim($this->_decode_string($card));
			}

		}else{
			$card = $user['platform_account'];
		}


		if($type == 'card_top'){

			return trim(substr($card,0,6));
		}

		if($type == 'card_last'){

			return trim(substr($card,(strlen($card)-4),4));
		}

		return false ;

	}


	private function _checkUserBaseInfo(){


		if($this->_member_id>0){

			//初始化用户信息
			$this->_userbaseinfo = $this->getPlatInfo();
		}

		if(empty($this->_userbaseinfo['platinfo'])){
			$this->error = '缺乏用户支付平台信息';
			$this->error_id = 1007002;
			return false ;
		}

		if($this->_userbaseinfo['userinfo']['member_mobile'] == ""){
			$this->error = '缺乏用户手机号';
			$this->error_id = 1007003;
			return false ;
		}

		if($this->_userbaseinfo['userinfo']['member_fullname'] == ""){
			$this->error = '缺乏用户真实姓名';
			$this->error_id = 1007004;
			return false ;
		}

		if($this->_userbaseinfo['userinfo']['db_member_id_number'] == ""){
			$this->error = '缺乏身份证号';
			$this->error_id = 1007005;
			return false ;
		}

		if($this->_userbaseinfo['platinfo']['platform_account'] == ""){
			$this->error = '缺乏用于支付的银行卡号';
			$this->error_id = 1007006;
			return false ;
		}

		if($this->_userbaseinfo['platinfo']['member_mobile'] == ""){
			$this->error = '缺乏银行预留手机号';
			$this->error_id = 1007007;
			return false ;
		}

	}
}