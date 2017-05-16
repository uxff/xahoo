<?php
/**
 * 支付宝支付控制器
 */
class BillingController extends BaseController {

	/* 日志key */
    public static $logKey = '[ares_log_error][uc_billing]';


    /**
     * 处理支付宝同步(return)回调接口
     * 
     * @return [type] [description]
     */
    public function actionProcessReturn() {

        $getParams = $_GET;
        unset($getParams['r']);
        
        // log
        AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'get alipay data from return_url', 'parameters' => $params, 'response' => $getParams));

        // 验证请求合法性
        $objAlipayDirect = new AlipayDirect();
        $isVerified = $objAlipayDirect->verifyReturn($getParams);

        // 验证成功
        if ($isVerified) {
            // log
            AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'verified alipay return data', 'parameters' => array(), 'response' => array()));

            // 获取订单号
            $order_id = AresUtil::getOrderIdFromDisplayOrderId($getParams['out_trade_no']);

            // 交易成功
            if($getParams['trade_status'] == 'TRADE_FINISHED' || $getParams['trade_status'] == 'TRADE_SUCCESS') {

                // 处理支付事务
                $paymentData = array_merge($getParams, 
                    array(
                        'ipn_mode' => 1, //同步
                    )
                );
                $result = $this->_processPaymentSuccessTransaction($order_id, $paymentData);
                // log
                AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'OK Trade _processPaymentSuccessTransaction', 'parameters' => $paymentData, 'response' => array('result'=>$result)));

                // 事务结果
                if($result) {
                    $this->redirect($this->createAbsoluteUrl('cash/chargeSuccess', array('order_id' => $order_id)));
                } else {
                    $this->redirect($this->createAbsoluteUrl('cash/chargeFail', array('order_id' => $order_id)));
                }

            } elseif ($getParams['trade_status'] == 'WAIT_BUYER_PAY') { // 等待买家付款
                //
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'NOK Trade WAIT_BUYER_PAY', 'parameters' => $getParams, 'response' => $response));
                // 充值确认页
                $this->redirect($this->createAbsoluteUrl('cash/chargeConfirm', array('order_id' => $order_id)));

            } elseif ($getParams['trade_status'] == 'TRADE_PENDING') { // 等待卖家收款(卖家账号被冻结)
                // 
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'NOK Trade TRADE_PENDING', 'parameters' => $getParams, 'response' => $response));
                // 充值确认页
                $this->redirect($this->createAbsoluteUrl('cash/chargeConfirm', array('order_id' => $order_id)));
            } elseif ($getParams['trade_status'] == 'TRADE_CLOSED') { // 交易结束(指定时间内未支付时关闭的交易，)
                // 
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'NOK Trade TRADE_CLOSED', 'parameters' => $getParams, 'response' => $response));
                // 充值确认页
                $this->redirect($this->createAbsoluteUrl('cash/chargeConfirm', array('order_id' => $order_id)));
            } else { // 未知交易
                //
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'unkonwn alipay trade_status', 'parameters' => $getParams, 'response' => $response));
                // error handler
                $this->redirect($this->createAbsoluteUrl('cash/chargeFail', array('order_id' => $order_id)));
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
        $objAlipayDirect = new AlipayDirect();
        $isVerified = $objAlipayDirect->verifyNotify($postParams);

        // 验证成功
        if ($isVerified) {
            $processResult['isVerified'] = true;
            // log
            AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'verified alipay notify data', 'parameters' => array(), 'response' => array()));

            // 获取订单号
            $order_id = AresUtil::getOrderIdFromDisplayOrderId($postParams['out_trade_no']);

            // 交易成功
            if($postParams['trade_status'] == 'TRADE_FINISHED' || $postParams['trade_status'] == 'TRADE_SUCCESS') {

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

            } elseif ($postParams['trade_status'] == 'WAIT_BUYER_PAY') { // 等待买家付款
                // TODO
                // 
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'NOK Trade WAIT_BUYER_PAY', 'parameters' => $postParams, 'response' => $response));
            } elseif ($postParams['trade_status'] == 'TRADE_PENDING') { // 等待卖家收款(卖家账号被冻结)
                // TODO
                // 
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'NOK Trade TRADE_PENDING', 'parameters' => $postParams, 'response' => $response));
            } elseif ($postParams['trade_status'] == 'TRADE_CLOSED') { // 交易结束(指定时间内未支付时关闭的交易，)
                // TODO
                // 
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'NOK Trade TRADE_CLOSED', 'parameters' => $postParams, 'response' => $response));
            } else { // 未知交易
                AresLogManager::log_error(array('logKey' => self::$logKey, 'desc' => 'unkonwn alipay trade_status', 'parameters' => $postParams, 'response' => $response));
                
                // TODO
                // error handler
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
    private function _processPaymentSuccessTransaction($order_id, $paymentData) {
        
        // 获取订单信息
        $objOrder = UcMemberOrder::model()->findByPk($order_id);

        // 获取用户ID, 会话失效则使用订单中客户ID
        $member_id = Yii::app()->loginUser->getUserId();
        if (empty($member_id)) {
            $member_id = intval($objOrder->member_id);
        }

        // 订单已支付
        if ($objOrder->order_status == 2) {
            return true;
        }

        // 设置订单支付成功
        $objOrder->order_status = 2;
        $objOrder->payment_method = 1;
        $objOrder->payment_vendor_code = 'alipay';
                
        // STEP_0: 更新订单状态为支付成功
        if ($objOrder->update()) {
            // log
            AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update UcMemberOrder status=2 success', 'parameters' => (array)$objOrder->attributes, 'response' => $response ));

            // STEP_1: 插入支付宝支付历史
            $objPaymentAlipay = new UcMemberPaymentAlipay();
            $objPaymentAlipay->order_id = $order_id;
            $objPaymentAlipay->subject = $paymentData['subject'];
            $objPaymentAlipay->body = $paymentData['body'];
            $objPaymentAlipay->total_fee = $paymentData['total_fee'];
            $objPaymentAlipay->trade_status = $paymentData['trade_status'];
            $objPaymentAlipay->exterface = $paymentData['exterface'];
            $objPaymentAlipay->trade_no = $paymentData['trade_no'];
            $objPaymentAlipay->buyer_email = $paymentData['buyer_email'];
            $objPaymentAlipay->buyer_id = $paymentData['buyer_id'];
            $objPaymentAlipay->out_trade_no = $paymentData['out_trade_no'];
            $objPaymentAlipay->payment_type = $paymentData['payment_type'];
            $objPaymentAlipay->seller_id = $paymentData['seller_id'];
            $objPaymentAlipay->notify_id = $paymentData['notify_id'];
            $objPaymentAlipay->notify_time = $paymentData['notify_time'];
            $objPaymentAlipay->notify_type = $paymentData['notify_type'];
            $objPaymentAlipay->ipn_mode = $paymentData['ipn_mode'];
            $objPaymentAlipay->status = 1;
            

            if($objPaymentAlipay->save() == false) {
                // log
                AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert UcMemberPaymentAlipay fail', 'parameters' => (array)$objPaymentAlipay->attributes, 'response' => $response ));
                
                return false;
            }
            // log
            AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert UcMemberPaymentAlipay success', 'parameters' => (array)$objPaymentAlipay->attributes, 'response' => $response ));

            // STEP_2: 插入订单状态历史
            $objOrderStatusHistory = new UcMemberOrderStatusHistory();
            $objOrderStatusHistory->order_id = $order_id;
            $objOrderStatusHistory->order_status = 2;//order 表 更改 状态值 已支付
            $objOrderStatusHistory->status_comment = '';

            if($objOrderStatusHistory->save() == false) {
                // log
                AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert UcMemberOrderStatusHistory fail', 'parameters' => (array)$objOrderStatusHistory->attributes, 'response' => $response ));
                
                return false;
            }
            // log
            AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert UcMemberOrderStatusHistory success', 'parameters' => (array)$objOrderStatusHistory->attributes, 'response' => $response ));

            // STEP_3: 更新会员现金账号总额表
            $arrMemberTotalParams = array(
                'condition' => 't.member_id='. $member_id,
            );
            $objMemberTotal = UcMemberTotal::model()->find($arrMemberTotalParams);
            $cash_total_before = $objMemberTotal->total_cash;

            // 添加充值金额至现金总额
            $objMemberTotal->total_cash += floatval($objOrder->order_total);
            //
            if ($objMemberTotal->update()) {
                // log
                AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update UcMemberTotal success', 'parameters' => (array)$objMemberTotal->attributes, 'response' => $response ));

                // STEP_3.1: 插入现金历史表
                $objCashLog = new UcMemberCashLog();
                $objCashLog->member_id = $member_id;
                $objCashLog->order_id = $objOrder->order_id;
                $objCashLog->order_numberid = $this->getDisplayChargeOrderId($objOrder->order_id, $objOrder->create_time);
                $objCashLog->cash_amount = floatval($objOrder->order_total);
                $objCashLog->cash_before = floatval($cash_total_before);
                $objCashLog->cash_after = floatval($cash_total_before) + floatval($objOrder->order_total);
                $objCashLog->operate_type = 1;
                $objCashLog->description = '';
                $objCashLog->source = 1;
                $objCashLog->status = 1;
                    
                if($objCashLog->save() == false) {
                    // log
                    AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert UcMemberCashLog success', 'parameters' => (array)$objCashLog->attributes, 'response' => $response ));
                    return false;
                }
                // log
                AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'insert UcMemberCashLog success', 'parameters' => (array)$objCashLog->attributes, 'response' => $response ));

            } else {
                // log
                AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update UcMemberTotal fail', 'parameters' => (array)$objMemberTotal->attributes, 'response' => $response ));
                return false;
            }

            return true;
        } else {
            AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'update UcMemberOrder status=2 fail', 'parameters' => (array)$objOrder->attributes, 'response' => $response ));
            return false;
        }


    } 


}