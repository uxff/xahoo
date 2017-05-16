<?php

Yii::import("application.common.service.SmsManager");
Yii::import("application.common.extensions.AresUtil");
Yii::import("application.common.extensions.AresLogManager");
/**
 *
 *短信发送
 */

class SmsService {

	//$params  array(
	//         code             => 验证码 
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         number           => 购买份数
	//         project_url      => 链接地址
	//         order_detail     => 订单详情
	//         webname          => 网站名称
	//         service_hotline  => 服务热线
	//         front_money      => 定金
	//         partner_name     => 小伙伴名称
	//         account_name     => 账户名
	//         date_format      => 时间  （05月24日09:43）
	//         account_number   => 金额
	//         target_account   => 转账账户
	//         )


	//传参数  
	const SMS_TPL_ZHUCE = '%(code)s（新奇世界通行证注册验证码，请完成注册），如非本人操作，请忽略本短信。';//注册 ---- 验证码
	const SMS_TPL_ZHUCEOK = '恭喜！您已成为新奇世界会员，用户名 %(user_name)s 。您的信任我们深感荣幸。更多精彩请见指尖上的新奇世界 %(webname)s【新奇世界/房乎网】';//模块, 注册 ---- 验证码
	const SMS_TPL_ACCOUNT = '%(code)s（新奇世界通行证手机动态码，请完成验证），如非本人操作，请忽略本短信。';//模块 个人资料/账户与安全信息修改
	const SMS_TPL_REMIND = '您在新奇世界关注的众筹项目【 %(project_name)s 】已经开始众筹，请您及时登录网站查看购买，项目不多先来先得哦~众筹项目详情 %(project_url)s 客服电话 400-958-1000';//众筹频道  提醒(项目为收藏项目且状态从展示中转为众筹中----点击-众筹开始发送提醒按钮)
	const SMS_TPL_ORDER ='%(user_name)s，您在新奇世界购买的【 %(project_name)s 】购买份数： %(number)s ，还有十分钟订单就自动取消了，请您尽快登录支付。认筹订单详情 %(order_detail)s 客服电话 400-958-1000';//众筹频道 订单系统 生成新订单-未支付----自动取消前10分钟 
	const SMS_TPL_ORDEROK = '%(user_name)s，您已在新奇世界成功购买【 %(project_name)s 】购买份数： %(number)s ，将于购买后第二日起产生收益，届时可登陆新奇世界个人中心-众筹收益模块中进行查看。认筹订单详情 %(order_detail)s 客服电话 400-958-1000';//众筹频道 订单系统 支付完成新订单
	const SMS_TPL_FQREMIND = '您在新奇世界关注的逸乐通项目【 %(project_name)s 】已经开始认购了，请您及时登录网站查看购买，项目不多先来先得哦~逸乐通项目详情 %(order_detail)s 客服电话 400-958-1000';//逸乐通频道 提醒  项目为收藏项目且状态从展示中转为认购中
	const SMS_TPL_FQORDER = '%(user_name)s，您在新奇世界购买的【 %(project_name)s 】购买份数： %(number)s ，还有十分钟订单就自动取消了，请您尽快登录支付。认筹订单详情 %(order_detail)s 客服电话 400-958-1000';//逸乐通频道 订单系统 生成新订单-未支付----自动取消前10分钟
	const SMS_TPL_FQDINGJIN = '%(user_name)s，您已在新奇世界成功提交 %(front_money)s 元定金，预定项目为【 %(project_name)s 】购买份数： %(number)s 。为了避免不必要损失，请于10天内完成付款，尽快完成登录支付。认筹订单详情 %(order_detail)s 客服电话 400-958-1000';//逸乐通频道 订单系统 生成新订单-已支付2000元定金
	const SMS_TPL_FQORDEROK = '%(user_name)s，您已在新奇世界成功购买【 %(project_name)s 】购买份数： %(number)s ，可登陆新奇世界个人中心进行查看。认购订单详情 %(order_detail)s 客服电话 400-958-1000';//逸乐通频道 订单系统 支付完成新订单

	
	/*************************购卡流程短信发送模板开始****************************/
	//预购开始
	//预购全款
	const SMS_TPL_FQORDER_YUGOU_QUANKUAN_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已预定购买新奇世界- %(project_name)s逸乐通卡，由于您指定的项目暂未开放预售，目前您无法进行余款支付，待开放预售后，我们会以短信方式告知您，请保持电话畅通， 如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任！[中弘控股-新奇世界]';//逸乐通频道  预购  全款  支付首付款

	//预购借贷
	//const SMS_TPL_FQORDER_YUGOU_JIEDAI_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已预定购买新奇世界-%(project_name)s逸乐通卡，并申请贷款方式支付余款，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道 预购 借贷 支付首付款
	//const SMS_TPL_FQORDER_YUGOU_JIEDAI_REMAIN_TWODAYS='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，订单即将过期，为确保您的权益，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//预购  借贷 到期前两天，短信提醒
	const SMS_TPL_FQORDER_YUGOU_JIEDAI_FIRSTPAYOK='尊敬的%(user_name)s先生/女士，您已预订购买新奇世界-%(project_name)s逸乐通卡，并申请贷款方式支付余款，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道 预购 借贷 支付首付款
	
	const SMS_TPL_FQORDER_YUGOU_JIEDAI_DATASUBMITOK='尊敬的%(user_name)s先生/女士，您已成功提交借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡），我们将以短信方式告知您审核结果，请耐心等待。 [仟金所]';//预购借贷审核资料提交成功 和预售是一样的

	
	//预售开始
	//预售全款
	const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已成功预定新奇世界-%(project_name)s逸乐通卡，请于7个工作日内支付余款，逾期订单将自动取消，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道  预售  全款  支付首付款
	const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，订单即将过期，为确保您的权益，请尽快完成余款支付，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//预售  全款 到期前两天，短信提醒
	const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_PAYOK='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，现已成功支付，请尽快登陆个人中心“我的订单"下载、签署合同，并按照页面提示寄发。逸乐通卡会员尊享：超值回报，一卡游遍中国，全国自由换住，乐享新奇世界十五大超炫业态，更多权益详情请登陆新奇世界官网www.xqshijie.com或拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//预售全款 购卡成功
	const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_HETONGOK='尊敬的%(user_name)s先生/女士，恭喜您成功购买新奇世界-%(project_name)s逸乐通卡，成为新奇世界逸乐通卡会员。您签署的新奇世界-XX逸乐通卡相关合同已经寄出，请留意查收，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//销售中心合同管理员更改合同状态为“已签署”
	
    //预售借贷
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已预定购买新奇世界-%(project_name)s逸乐通卡，并申请贷款方式支付余款，请尽快登陆个人中心“我的订单“下载、签署合同，并按照页面提示寄发，同时请于7个工作日内提交借贷审核资料，逾期订单将自动取消，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道 预售 借贷 支付首付款
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，订单即将过期，为确保您的权益，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATASUBMITOK='尊敬的%(user_name)s先生/女士，您已成功提交借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡），我们将以短信方式告知您审核结果，请耐心等待。 [仟金所]';//借贷审核资料提交成功
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAOK='尊敬的%(user_name)s先生/女士，您提交的借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡）已通过审核，请按合同约定按时还款，非常感谢您的理解与信任。[仟金所]';//资料审核通过 借贷购卡成功且仟金所满标
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAFAIL_QIANJINS='尊敬的%(user_name)s先生/女士，您提交的借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡）未通过审核，您可在7个工作日内补充借贷审核资料。[仟金所]';//借贷审核未通过 仟金所名义发送短信
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAFAIL_XQSHIJIE='尊敬的%(user_name)s先生/女士，您为购买新奇世界-%(project_name)s逸乐通卡所提交的借贷审核资料未通过审核方审核，您可在7个工作日内登陆新奇世界官方网站选择全款购买。如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//借贷审核未通过 新奇世界名义发短信
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，由于未在7个工作日内申请全款购买或补充借贷审核资料，该订单现已过期，请登陆新奇世界官网进行退款申请，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任，我们由衷地期待与您的合作！[中弘控股-新奇世界]';//7日订单失败
	const SMS_TPL_FQORDER_YUSHOU_JIEDAI_HETONGOK='尊敬的%(user_name)s先生/女士，恭喜您成功购买新奇世界-%(project_name)s逸乐通卡，成为新奇世界逸乐通卡会员。您签署的新奇世界-%(project_name)s逸乐通卡相关合同已经寄出，请留意查收，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//合同已签署

	/*************************购卡流程短信发送模板结束****************************/


	
	const SMS_TPL_FHRECOMMEND = '亲爱的 %(user_name)s，您是否正在考虑置业？您的小伙伴"%(partner_name)s"给您推荐了一个很棒的房源：%(project_name)s，点击链接查看详情：%(project_url)s ，注册加入，购房还可以有折扣哦！【房乎】';//房乎网 推荐小伙伴   ---用户于项目页下方，输入小伙伴手机号及姓名并提交，并判断该用户是否存在，如果不存在库中，则发送短信 
	const SMS_TPL_RECHARGE = '您的账户 %(account_name)s 于%(date_format)s已经成功充值%(account_number)s，请登录核实。';//账户充值成功
	const SMS_TPL_APPLYFOR = '您的账户 %(account_name)s 于%(date_format)s申请提取 %(account_number)s 至 %(target_account)s 已经成功提交，请等待审核。';//提交提现申请后
	const SMS_TPL_APPLYSUCCESS = '您的账户 %(account_name)s 于%(date_format)s申请提取 %(account_number)s 至 %(target_account)s 已经成功到账，请您查收。';//提现成功
	// 短信服务错误日志key
	const ERROR_LOG_KEY = '[third_service_error][chanzor_sms]';

	/**
	 * 发送验证码
	 *
	 * @param  string $phone     手机号
	 * @param  string $zoneCode  地区编号
	 * @return boolean           发送成功或是失败
	 */
	public static function sendVerifyCode($phone='', $zoneCode = '86') {

		//TODO
		$result = new SmsManager() ;
		print_r($result);
	}
	/*
	 * 注册 验证码 返回一个是手机号、内容
	 * @param params 数组形式
	 * @param  code 验证码
	 */
	//$params  array(
	//         code             => 验证码 
	//         )
	public static  function sendZhuceCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_ZHUCE,$params);
		}

		return self::sendSMS($phone,$content,'send zhuce code');
	}

	/*
	 * 注册 个人资料/账户与安全信息修改 
	 * @param params 数组形式
	 * @param  code 验证码 
	 */
	//$params  array(
	//         code             => 验证码 
	//         )
	public static  function sendAccountCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_ACCOUNT,$params);
		}

		return self::sendSMS($phone,$content,'send account code');
	}
	/*
	 * 众筹频道   提
	 */
	//$params  array(
	//         project_name     => 项目名称
	//         project_url      => 链接地址
	//         )
	public static  function sendZcRemindCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_REMIND,$params);
		}

		return self::sendSMS($phone,$content,'send zcRemind code');
	}
	/*
	 * 众筹频道   订单系统    生成新订单-未支付----自动取消前10分钟  
	 */
	//$params  array(
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         number           => 购买份数
	//         order_detail     => 订单详情
	//         )
	public static  function sendZcOrderCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_ORDER,$params);
		}

		return self::sendSMS($phone,$content,'send zcOrder code');
	}
	/*
	 * 众筹频道   订单系统    支付完成新订单    
	 */
	//$params  array(
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         number           => 购买份数
	//         order_detail     => 订单详情
	//         )
	public static  function sendZcOrderOkCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_ORDEROK,$params);
		}

		return self::sendSMS($phone,$content,'send zcOrderOk code');
	}
	/*
	 * 逸乐通频道   提醒
	 */
	//$params  array(
	//         project_name     => 项目名称
	//         order_detail     => 订单详情
	//         )
	public static  function sendFqRemindCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_FQREMIND,$params);
		}

		return self::sendSMS($phone,$content,'send fqRemind code');
	}
	/*
	 * 逸乐通频道   订单系统  生成新订单-未支付----自动取消前10分钟  
	 */
	//$params  array(
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         number           => 购买份数
	//         order_detail     => 订单详情
	//         )
	public static  function sendFqOrderCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_FQORDER,$params);
		}

		return self::sendSMS($phone,$content,'send fqOrder code');
	}
	/*
	 * 逸乐通频道   订单系统  生成新订单-已支付2000元定金 
	 */
	//$params  array(
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         number           => 购买份数
	//         order_detail     => 订单详情
	//         front_money      => 定金
	//         )
	public static  function sendFqDingjinCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_FQDINGJIN,$params);
		}

		return self::sendSMS($phone,$content,'send fqDingjin code');
	}
	/*
	 * 逸乐通频道   订单系统  支付完成新订单
	 */
	//$params  array(
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         number           => 购买份数
	//         order_detail     => 订单详情
	//         )
	public static  function sendFqOrderOkCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_FQORDEROK,$params);
		}

		return self::sendSMS($phone,$content,'send fqOrderOk code');
	}


	

	/**
	 * 发送短信通用接口 支付预购全款首付款
	 * @param unknown $phone 手机号
	 * @param unknown $params 短信参数
	 * @param unknown $smstpl 发送短信的模板变量名称
	 * @param string $zoneCode
	 * @return Ambigous <multitype:string , multitype:string returnstatus >
	 */
	public static  function sendFqOrderSMSCode($phone, $params,$smstpl,$sendtime='', $zoneCode = '86'){
	    if(!empty($params)){
	        //$smstpl=eval("self::".$smstpl);
	        $smstplinfo=constant( self.'::'.$smstpl);
	        $content = AresUtil::sprintfWithArray($smstplinfo,$params);
	    }
	    !$sendtime && $sendtime=date("Y-m-d H:i:s",time());
        $objFqOrderSms = new FqOrderSms();
        $objFqOrderSms->order_id=$params['order_id'];
        $objFqOrderSms->sms_mobile=$phone;
        $objFqOrderSms->sms_message=$content;
        $objFqOrderSms->smstpl=$smstpl;
        $objFqOrderSms->pre_send_time=$sendtime;
        if($objFqOrderSms->save()){
            return true;
        } else {
            return false;
        }

	
	    //return self::sendSMS($phone,$content,'send '.$smstpl.' code');
	}
	
	/******************************短信发送函数***********************************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	 * 账户充值  
	 */
	//$params  array(
	//         account_name     => 账户名
	//         date_format      => 时间  （05月24日09:43）
	//         account_number   => 金额
	//         )
	public static  function sendRechargeSuccess($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_RECHARGE,$params);
		}

		return self::sendSMS($phone,$content,'send recharge success');
	}
	/*
	 * 提交转账申请后
	 */
	//$params  array(
	//         account_name     => 账户名
	//         date_format      => 时间  （05月24日09:43）
	//         account_number   => 金额
	//         target_account   => 转账账户
	//         )
	public static  function sendApplyFor($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_APPLYFOR,$params);
		}

		return self::sendSMS($phone,$content,'send apply for');
	}
	/*
	 * 转账成功后 
	 */
	//$params  array(
	//         account_name     => 账户名
	//         date_format      => 时间  （05月24日09:43）
	//         account_number   => 金额
	//         target_account   => 转账账户    
	//         )
	public static  function sendApplySuccess($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_APPLYSUCCESS,$params);
		}

		return self::sendSMS($phone,$content,'send apply success');
	}
	/*
	 * 房乎网   推荐小伙伴 
	 */
	//$params  array(
	//         user_name        => 用户名
	//         project_name     => 项目名称
	//         project_url      => 链接地址
	//         partner_name     => 伙伴名称
	//         )
	public static  function sendFhRecommendCode($phone, $params, $zoneCode = '86'){
		if(!empty($params)){
			$content = AresUtil::sprintfWithArray(self::SMS_TPL_FHRECOMMEND,$params);
		}

		return self::sendSMS($phone,$content,'send fhRecommend code');
	}

	public static function sendSMS($phone, $content,$params) {

		// 实例化
		$smsManager = new SmsManager();
		//todo
		$response = $smsManager->send($phone,$content);

		//        $response = array('returnstatus' => 'Fail', 'message' => 'NOT ENABLE chanzor_sms');

		// add log
		$parameters = array('phone' => $phone,'content'=>$content);
		AresLogManager::log_bi(array('logKey' => '[sms][' . __METHOD__ . ']', 'desc' => $params, 'parameters' => $parameters, 'response' => $response));

		// response
		if ($response['returnstatus'] == 'Success') {
			return array('returnstatus' => 'Success');
		} elseif ($response['returnstatus'] == 'Fail') {
			//
			AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service error!', 'parameters' => $parameters, 'response' => $response));
			return array('returnstatus' => 'Fail','message'=>$response['message']);
		}
	}



}


?>