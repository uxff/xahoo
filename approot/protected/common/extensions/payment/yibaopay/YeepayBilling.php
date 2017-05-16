<?php




class YeepayBilling extends BaseController{

	public static $logKey = '[ares_log_error][qjs_billing]';

	/**
	 * 处理支付宝同步(return)回调接口
	 *
	 * @return [type] [description]
	 */
	public function parseReturn($getParams) {




		// log
		AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'get alipay data from return_url', 'parameters' => $params, 'response' => $getParams));

		// 验证请求合法性
		$objYeepayBase = new YeepayBase();



		$verifyData = $objAlipayDirect->parseReturnData($getParams);

		// 验证成功
		if (!empty($verifyData)) {
			// log
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'verified alipay return data', 'parameters' => array(), 'response' => array()));

			// 获取订单号
			$order_id = AresUtil::getOrderIdFromDisplayOrderId($getParams['orderid']);

			// 交易成功
			if($getParams['status']) {

				// 处理支付事务
				$paymentData = array_merge($getParams,
				array(
                        'ipn_mode' => 1, //同步
				)
				);

				// 调取事务
				$result = $this->_processPaymentSuccessTransaction($order_id, $paymentData);
				// log
				AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'OK Trade _processPaymentSuccessTransaction', 'parameters' => $paymentData, 'response' => array('result'=>$result)));

				// 事务结果
				if($result) {
					$this->redirect($this->createAbsoluteUrl('checkout/paySuccess', array('order_id' => $order_id)));
				} else {
					$this->redirect($this->createAbsoluteUrl('checkout/payFail', array('order_id' => $order_id)));
				}

			}

		} else { // 验证失败
			AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'illegal alipay return data', 'parameters' => array(), 'response' => array()));
		}

	}

	/**
	 * 处理支付宝异步(nofity)回调接口
	 * 返回处理结果给notify_url
	 *
	 * @return json
	 */
	public function actionProcessNotify() {
		// 获取参数
		$postParams = $_POST;

		// 异步处理处理结果
		$processResult = array(
            'isVerified' => false,
            'isProcessed' => false,
		);

		// log
		AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'get alipay data from notify_url', 'parameters' => $params, 'response' => $postParams));

		// 验证请求合法性
		$objYeepayBase = new YeepayBase();
		$VerifyData = $objYeepayBase->parseReturnData($postParams);

		// 验证成功
		if (!empty($VerifyData)) {
				
			$processResult['isVerified'] = true;
			// log
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'verified alipay notify data', 'parameters' => array(), 'response' => array()));

			// 获取订单号
			$order_id = AresUtil::getOrderIdFromDisplayOrderId($postParams['orderid']);
				

			// 交易成功
			if($postParams['status'] == 1) {

				// 处理支付事务
				$paymentData = array_merge($postParams,
				array(
                        'exterface' => 'create_direct_pay_by_user',
                        'notify_time' => $postParams['gmt_payment'],
                        'ipn_mode' => 2, //异步
				)
				);
				$result = $this->_processPaymentSuccessTransaction($order_id, $paymentData);
				// log
				AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'OK Trade _processPaymentSuccessTransaction', 'parameters' => $paymentData, 'response' => array('result'=>$result)));

				// 处理结果
				$processResult['isProcessed'] = $result;

			}

		} else { // 验证失败
			AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'illegal alipay notify data', 'parameters' => array(), 'response' => array()));

		}

		// 返回处理结果给notify_url
		echo json_encode($processResult);
	}
	/**
	 * 处理之后事务
	 *
	 * @param  array $paymentData    支付数据
	 * @return boolean
	 */

	private function _processPaymentSuccessTransaction($order_id, $paymentData, $payDeposit = false){
		// 获取订单信息
		$objOrder = LcOrder::model()->published()->findByPk($order_id);

		// 获取用户ID, 会话失效则使用订单中客户ID
		$customer_id = Yii::app()->loginUser->getUserId();
		if (empty($customer_id)) {
			$customer_id = intval($objOrder->customer_id);
		}

		// 订单已支付
		if ($objOrder->order_status == 2) {
			return true;
		}

		// 设置订单支付成功
		$objOrder->order_status = 2;
		$objOrder->payment_method = 1;
		$objOrder->payment_vendor_code = 'yeepay';

		// log
		AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update LcOrder status='.$objOrder->order_status.' success', 'parameters' => (array)$objOrder->attributes, 'response' => $response ));

		if($objOrder->update()){
				
				
			// STEP_1: 插入支付宝支付历史
			$objLcPaymentAlipay = new ZcPaymentYeepay();
			$objLcPaymentAlipay->orderid = $order_id;
			//			$objLcPaymentAlipay->subject = $paymentData['subject'];
			//			$objLcPaymentAlipay->body = $paymentData['body'];
			$objLcPaymentAlipay->amount = $paymentData['amount'];
			$objLcPaymentAlipay->merchantaccount = $paymentData['merchantaccount'];
			$objLcPaymentAlipay->yborderid = $paymentData['yborderid'];
			$objLcPaymentAlipay->identityid = $paymentData['identityid'];
			$objLcPaymentAlipay->card_top = $paymentData['card_top'];
			$objLcPaymentAlipay->card_last = $paymentData['card_last'];
			$objLcPaymentAlipay->status = $paymentData['status'];
			$objLcPaymentAlipay->errorcode = $paymentData['payment_type'];
			$objLcPaymentAlipay->errormsg = $paymentData['seller_id'];
			$objLcPaymentAlipay->sign = $paymentData['sign'];



			if($objLcPaymentAlipay->save() == false) {
				// log
				AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert LcPaymentAlipay fail', 'parameters' => (array)$objLcPaymentAlipay->attributes, 'response' => $response ));

				return false;
			}
			// log
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert LcPaymentAlipay success', 'parameters' => (array)$objLcPaymentAlipay->attributes, 'response' => $response ));

			// STEP_2: 插入订单状态历史
			$LcOrderHistory = new LcOrderStatusHistory();
			$LcOrderHistory->order_id = $order_id;
			$LcOrderHistory->order_status = 2;
			$LcOrderHistory->status_comment = '';

			if($LcOrderHistory->save()) {
				AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert LcOrderStatusHistory success', 'parameters' => (array)$LcOrderHistory->attributes, 'response' => $response ));

				// 收益统计

				// STEP_3.1: 更新或插入收益表
				$objLcRevenue = new LcRevenue();
				$objLcRevenue->customer_id = $customer_id;
				$objLcRevenue->order_id = $order_id;
				$objLcRevenue->borrow_id = $objOrder->item_id;
				$objLcRevenue->borrow_source = $objOrder->item_source;
				$objLcRevenue->capital_total = $objOrder->order_total;
				$objLcRevenue->revenue_capital_total = $objOrder->order_total;
				$objLcRevenue->revenue_base_total = $objOrder->order_total;
				$objLcRevenue->status = 1;
				if ( $objOrder->item_source == 1 ) {
					$arrParamConds = array(
                        'condition' => 't.borrow_id='. $objOrder->item_id .' AND t.status in (4,5,6,7,8) ',
					);
					$objLcProject = JdBorrow::model()->find($arrParamConds);

					$objLcRevenue->revenue_rate = $objLcProject->annual_rate;
					$objLcRevenue->start_time = date('Y-m-d H:i:s', strtotime('+ 1 days', strtotime($objOrder->create_time)));
					$objLcRevenue->end_time = date('Y-m-d H:i:s', strtotime('+' . $objLcProject->borrow_duration . ' months', strtotime($objLcRevenue->start_time)));

				} elseif ( $objOrder->item_source == 2 ) {
					$objLcProject = JyZhaiquanProject::model()->findByPk($objOrder->item_id);
					$objLcRevenue->borrow_id = $objLcProject->borrow_id;
					$objLcRevenue->revenue_rate = $objLcProject->annual_rate;
					$objLcRevenue->start_time = date('Y-m-d H:i:s', strtotime('+ 1 days', time()));
					$objLcRevenue->end_time = $objLcProject->revenue_end_time;

				}

				if($objLcRevenue->save() == false) {
					// log
					AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert LcRevenue success', 'parameters' => (array)$objLcRevenue->attributes, 'response' => $response ));
					return false;
				} else {
					// log
					AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert LcRevenue success', 'parameters' => (array)$objLcRevenue->attributes, 'response' => $response ));
					// lc_capital_history 操作记录
					$lcCapitalHistory = new LcCapitalHistory();
					$lcCapitalHistory->customer_id = $customer_id;
					$lcCapitalHistory->borrow_id = $objLcRevenue->borrow_id;
					$lcCapitalHistory->borrow_source = $objOrder->item_source;
					$lcCapitalHistory->order_id = $order_id;
					$lcCapitalHistory->capital_amount = $objOrder->order_total;
					$lcCapitalHistory->calculate_type = 1;
					$lcCapitalHistory->operate_type = $objOrder->item_source == 2 ? 1 : 0;
					if ( $lcCapitalHistory->insert() ) {
						AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert lcCapitalHistory success', 'parameters' => (array)$lcCapitalHistory->attributes, 'response' => $response ));
					} else {
						AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert lcCapitalHistory fail', 'parameters' => (array)$lcCapitalHistory->attributes, 'response' => $response ));
					}

				}

			} else {
				// log
				AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert lcOrderHistory fail', 'parameters' => (array)$LcOrderHistory->attributes, 'response' => $response ));
				return false;
			}

			// STEP_4: 支付账号信息同步给UCenter
			$params = array(
                'buyer_email' => $paymentData['buyer_email'],
                'member_id' => $customer_id,//用户id
                'platform_type' => 1,
			);
			$objRestClient = new AresRESTClient();
			$restResult = $objRestClient->doGet($this->createUCenterUrl('api/bindPaymentVendor'), $params);
			// log
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'sync buyer_email to ucenter', 'parameters' => $params, 'response' => $restResult ));

			// STEP_5: 判断项目是否还有可购买金额 借贷理财项目
			if ( $objOrder->item_source == 1 ) {
				$arrBorrow = $this->_getBorrowDetail(array($objOrder->item_id));
				$borrowDetail = $arrBorrow['0'];
				if ($borrowDetail['surplus_amount_total']==0) {
					$objBorrow = JdBorrow::model()->findByPk($objOrder->item_id);
					$objBorrow->status = 6;
					if ($objBorrow->update()) {
						// 填充状态变化历史表
						$objBorrowStatusHistory = new JdBorrowStatusHistory();
						$objBorrowStatusHistory->borrow_id = $objOrder->item_id;
						$objBorrowStatusHistory->borrow_status = 6;
						$objBorrowStatusHistory->status_comment = '';
						//
						$objBorrowStatusHistory->save();

						AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update JdBorrow status='.$objBorrow->status.' success', 'parameters' => (array)$objBorrow->attributes ));
					}
				}
			}elseif ( $objOrder->item_source == 2 ) { // 债权项目
				$objLcProject = JyZhaiquanProject::model()->findByPk($objOrder->item_id);
				$objLcProject->sold_quantity += $objOrder->item_quantity;
				$objLcProject->sold_total += $objOrder->order_total;

				if ($objLcProject->update()) {
					AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update JyZhaiquanProject sold_total,sold_quantity success', 'parameters' => (array)$objLcProject->attributes ));
					// 扣除收益金额&&用户钱包转入卖出的债权金额
					$objRevenue = LcRevenue::model()->findByAttributes(array('order_id' => $objLcProject->order_id,'customer_id' => $objLcProject->order_uid));
					if ($objRevenue->revenue_capital_total >= $objOrder->order_total) {
						// 减去卖出的债权金额
						$objRevenue->revenue_capital_total = $objRevenue->revenue_capital_total - $objOrder->order_total;
						$objRevenue->revenue_base_total = $objRevenue->revenue_base_total - $objOrder->order_total;
						if ($objRevenue->update()) {
							AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update LcRevenue revenue_base_total,revenue_base_total success', 'parameters' => (array)$objRevenue->attributes ));
							// lc_capital_history 操作记录
							$lcCapitalHistory = new LcCapitalHistory();
							$lcCapitalHistory->customer_id = $objRevenue->customer_id;
							$lcCapitalHistory->borrow_id = $objRevenue->borrow_id;
							$lcCapitalHistory->borrow_source = $objOrder->item_source;
							$lcCapitalHistory->order_id = $objRevenue->order_id;
							$lcCapitalHistory->capital_amount = $objOrder->order_total;
							$lcCapitalHistory->calculate_type = -1;
							$lcCapitalHistory->operate_type = $objOrder->item_source == 2 ? 1 : 0;
							if ( $lcCapitalHistory->insert() ) {
								AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert lcCapitalHistory success', 'parameters' => (array)$lcCapitalHistory->attributes, 'response' => $response ));
							} else {
								AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert lcCapitalHistory fail', 'parameters' => (array)$lcCapitalHistory->attributes, 'response' => $response ));
							}

							$app_secrect = Yii::app()->params['app_secrect'];
							//
							$objRestClient = new AresRESTClient();

							$getParams = array(
                                'member_id' => $objLcProject->order_uid,
                                'order_id' => $order_id, // 订单ID
                                'source' => '5', // 1|充值,2|房乎转入,3|众筹转入,4|分权转入,5|债权变卖转入,6|产权变卖转入,101|提取,102|房乎支付,103|众筹支付,104|分权支付,105|理财买入支付,106|产权买入支付,191|还款支付
							);
							$restResponse = $objRestClient->doGet( $this->createUCenterUrl('api/getCashToken'), $getParams );
							$arrResponse = json_decode($restResponse, true);

							if ($arrResponse['data']['token']) {
								$token = $arrResponse['data']['token'];

								$postParams = $getParams;
								$postParams['amount'] = $objOrder->order_total;
								$postParams['token'] = $token;
								$postParams['order_numberid'] =  $this->getDisplayOrderId($order_id, $objOrder->create_time);

								$signed_params_str = AresApiUtil::signURLParameters($postParams, array('sign'), $app_secrect);
								$postParams['sign'] = $signed_params_str;

								$restResponse = $objRestClient->doPost( $this->createUCenterUrl('api/chargeCash'), $postParams );
								$arrResponse = json_decode($restResponse, true);

								if ( isset($arrResponse['data']['result']) && $arrResponse['data']['result'] ) {
									// success
									AresLogManager::log_bi( array('logKey' => self::$logKey, 'desc' => 'update UcMemberCash success', 'parameters' => (array)$postParams, 'response' => $arrResponse ));
								} else {
									// fail
									AresLogManager::log_bi( array('logKey' => self::$logKey, 'desc' => 'update UcMemberCash fail', 'parameters' => (array)$postParams, 'response' => $arrResponse ));
								}

							} else {
								// error
								AresLogManager::log_bi( array('logKey' => self::$logKey, 'desc' => 'update UcMemberCash fail', 'parameters' => (array)$postParams, 'response' => $arrResponse ));
							}
						}
					}
				}

			}

			//  STEP_6: 成交调用秒秒赚佣金接口
			$time_sign = time();
			$appkey = 'test';
			$appsecret = '123456';
			$token = strtoupper(md5($appkey . $appsecret . $time_sign));
			$order_numberid = $this->getDisplayOrderId($objOrder->order_id, $objOrder->create_time);
			$arrParmas = array(
                'member_id' => $customer_id,
                'item_id' => $objOrder->item_id,
                'item_name' => $objOrder->item_name,
                'order_id' => $objOrder->order_id,
                'order_numberid' => $order_numberid,
                'deal_amount' => $objOrder->order_total,
                'token' => $token,
                'time_sign' => $time_sign,
			);
			$mmzApi = $this->createMmzServiceUrl('api/orderPaymentByLc');
			$this->doPost($mmzApi, $arrParmas);
			// log
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'sync reward to fanghu', 'parameters' => $arrParmas, 'response' => $fanghuResult ));

			// STEP_7: 发送短信提醒用户购买成功

			//新浪短链接
			$shortUrl = AresUtil::sinaShortUrlService($this->createAbsoluteUrl('lcOrder/detail',array('order_id'=>$objOrder->order_id)));
			if ($shortUrl['status']=='success') {
				$url = $shortUrl['message']['url_short'];
			} else {
				$url = Yii::app()->request->hostInfo;
			}

			$smsParams = array(
                    'user_name' => $objOrder->cusomter_name,
                    'project_name' => $objOrder->item_name,
                    'number' => $objOrder->order_total,
                    'order_detail' => $url,
			);
			// TODO
			//$sendSmsResult = SmsService::sendLcOrderOkCode($objOrder->cusomter_phone,$smsParams);

			// log
			//AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'send sms after order payment success', 'parameters' => $smsParams, 'response' => $sendSmsResult ));

			return true;
		} else {
			AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update LcOrder status=2 fail', 'parameters' => (array)$objOrder->attributes, 'response' => $response ));
			return false;
		}

	}


}