<?php
/**
 * 现金资产控制器
 */
class CashController extends BaseController {

    /* 日志key */
    public static $logKey = '[ares_log_error][uc_cash]';

    /**
     * 我的资产
     * @return void
     */
    public function actionIndex() {
        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/index') );
        
        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();

        // 获取用户现金信息
        $arrMemberTotalParams = array(
            'condition' => 't.member_id='. $member_id,
        );
        $objMemberTotal = UcMemberTotal::model()->find($arrMemberTotalParams);
        $myCashTotal = floatval($objMemberTotal->total_cash);

        // 1. 获取用户众筹资产信息
        $objRestClient = new AresRESTClient();
        $restResponse = $objRestClient->doGet($this->createXqsjZCServerUrl('api/getMyRevenue'), array('member_id' => $member_id));
        $arrMyRenue = CJSON::decode($restResponse);
        $objRestClient = null;
        // rest API result
        if ($arrMyRenue['code'] == 0 && !empty($arrMyRenue['data'])) {
	        $myZCProjectCount = intval($arrMyRenue['data']['allProjectCount']);
	        $myZCCapitalTotal = floatval($arrMyRenue['data']['allCapitalTotal']);
	        $myZCRevenueTotal = floatval($arrMyRenue['data']['allRevenueTotal']);
        } else {
	        $myZCProjectCount = 2;
	        $myZCCapitalTotal = 0.00;
	        $myZCRevenueTotal = 0.00;
        }

        // 2. 获取用户分权资产信息
        $objRestClient = new AresRESTClient();
        $restResponse = $objRestClient->doGet($this->createXqsjFQServerUrl('api/getMyCapital'), array('member_id' => $member_id));
        $arrMyFQCapital = CJSON::decode($restResponse);
        $objRestClient = null;
        // rest API result
        if ($arrMyFQCapital['code'] == 0 && !empty($arrMyFQCapital['data'])) {
	        $myFQProjectCount = intval($arrMyFQCapital['data']['allCardCount']);
	        $myFQCapitalTotal = ($arrMyFQCapital['data']['allCapitalTotal']);
        } else {
	        $myFQProjectCount = 0;
	        $myFQCapitalTotal = 0.00;
        }

        // 3. 获取用户分权交易资产信息
        $myTradeRevenueTotal = 0.99;

        // 4. 获取用户xahoo小伙伴以及佣金信息
        $arrMemberBuddyParams = array(
            'condition' => 't.parent_id='. $member_id,
        );
        $queryResultMemberBuddy = UcMemberRelationMap::model()->count($arrMemberBuddyParams);
        // result
        $myFHBuddyCount = intval($queryResultMemberBuddy);
        $myFHRewardTotal = floatval($objMemberTotal->total_reward);


        // 我的账户总价值
        $myAllAccountTotal = $myCashTotal + $myZCCapitalTotal + $myZCRevenueTotal + $myFQCapitalTotal + $myFHRewardTotal;
        $myZCAccountTotal = $myZCCapitalTotal + $myZCRevenueTotal;
        $myFQAccountTotal = $myFQCapitalTotal;
        $myFHAccountTotal = $myFHRewardTotal;

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '我的资产',
            'return_url' => $this->checkReturnUrl(),
            //
            'myAllAccountTotal' => AresUtil::formatLocalPrice($myAllAccountTotal, 2),
            'myCashTotal' => AresUtil::formatLocalPrice($myCashTotal, 2),
            // 众筹
            'myZCProjectCount' => $myZCProjectCount,
            'myZCAccountTotal' => AresUtil::formatLocalPrice($myZCAccountTotal, 2),
            'myZCCapitalTotal' => AresUtil::formatLocalPrice($myZCCapitalTotal, 2),
            'myZCRevenueTotal' => AresUtil::formatLocalPrice($myZCRevenueTotal, 2),
            'zcRevenueIndexUrl' => $this->createXqsjZCServerUrl('revenue/list'),
            // 分权
            'myFQProjectCount' => $myFQProjectCount,
            'myFQAccountTotal' => AresUtil::formatLocalPrice($myFQAccountTotal, 2),
            'myFQCapitalTotal' => AresUtil::formatLocalPrice($myFQCapitalTotal, 2),
            'fqCardIndexUrl' => $this->createXqsjFQServerUrl('customer/cardList'),
            // 交易
            'myTradeRevenueTotal' => AresUtil::formatLocalPrice($myTradeRevenueTotal, 2),
            // fh
            'myFHBuddyCount' => $myFHBuddyCount,
            'myFHAccountTotal' => AresUtil::formatLocalPrice($myFHAccountTotal, 2),
            'myFHRewardTotal' => AresUtil::formatLocalPrice($myFHRewardTotal, 2),
            'fhRewardIndexUrl' => $this->createAbsoluteUrl('reward/index'),
        );

        $this->smartyRender('cash/index.tpl', $arrRender);
    }


    /**
     * 现金详情
     * @return void
     */
    public function actionDetail() {
        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/detail') );
        
        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();
        
        // 获取用户现金信息
        $arrMemberTotalParams = array(
            'condition' => 't.member_id='. $member_id,
        );
        $objMemberTotal = UcMemberTotal::model()->find($arrMemberTotalParams);
        $myCashTotal = floatval($objMemberTotal->total_cash);

        // 获取现金收益记录
        $arrCashLogParams = array(
            'condition' => 't.member_id='. $member_id,
        );
        $objCashLog = UcMemberCashLog::model()->orderBy()->pagination(1, 10)->findAll($arrCashLogParams);
        $arrCashLog = $this->convertModelToArray($objCashLog);

        $formatedCashLog = array();
        if (!empty($arrCashLog)) {
            $cashSourceMapping = array('1'=>'充值', '2'=>'房乎佣金转入', '3'=>'众筹收益转入', '3'=>'产权项目转入', '101'=>'现金提取', '102'=>'在线支付-众筹项目', '103'=>'在线支付-分权项目');
            $cashNoteMapping = array('1'=>'现金转入', '2'=>'账号内部转入', '3'=>'账号内部转入', '3'=>'账号内部转入', '101'=>'现金提取', '102'=>'账号内部支出', '103'=>'账号内部支出');
            
            foreach ($arrCashLog as $item) {
                $formatedCashLog[] = array(
                    'display_cash_source' => $cashSourceMapping[$item['source']],
                    'order_id' => $item['order_id'],
                    'display_order_id' => $item['order_numberid'],
                    'cash_amount' => $item['cash_amount'],
                    'operate_type' => $item['operate_type'],
                    'display_operate_time' => date('Y-m-d H:i', strtotime($item['last_modified'])),
                    'display_cash_note' => $cashNoteMapping[$item['source']],
                );
            }
        }

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '现金账户',
            'return_url' => $this->createAbsoluteUrl('cash/index'),
            'myCashTotal' => $myCashTotal,
            'arrCashLog' => $formatedCashLog,
        );

        $this->smartyRender('cash/detail.tpl', $arrRender);
    }


    /**
     * 现金账单历史
     * @return void
     */
    public function actionHistory() {
          // 获取参数
        $page_no = isset($_GET['page_no']) ? $this->getInt($_GET['page_no']) : 1;
        $page_size = Yii::app()->params['pageSize'];

        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/history') );
        
        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();
        // 获取现金收益
        $arrCashLogParams = array(
            'condition' => 't.member_id='. $member_id,
        );
        $objCashLog = UcMemberCashLog::model()->orderBy()->pagination($page_no, $page_size)->findAll($arrCashLogParams);
        $arrCashLog = $this->convertModelToArray($objCashLog);

        $formatedCashLog = array();
        if (!empty($arrCashLog)) {
            $cashSourceMapping = array('1'=>'充值', '2'=>'房乎佣金转入', '3'=>'众筹收益转入', '3'=>'产权项目转入', '101'=>'现金提取', '102'=>'在线支付-众筹项目', '103'=>'在线支付-分权项目');
            $cashNoteMapping = array('1'=>'现金转入', '2'=>'账号内部转入', '3'=>'账号内部转入', '3'=>'账号内部转入', '101'=>'现金提取', '102'=>'账号内部支出', '103'=>'账号内部支出');
            
            foreach ($arrCashLog as $item) {
                $formatedCashLog[] = array(
                    'display_cash_source' => $cashSourceMapping[$item['source']],
                    'order_id' => $item['order_id'],
                    'display_order_id' => $item['order_numberid'],
                    'cash_amount' => $item['cash_amount'],
                    'operate_type' => $item['operate_type'],
                    'display_operate_time' => date('Y-m-d H:i', strtotime($item['last_modified'])),
                    'display_cash_note' => $cashNoteMapping[$item['source']],
                );
            }
        }

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '账单明细',
            'return_url' => $this->createAbsoluteUrl('cash/detail'),
            'arrCashLog' => $formatedCashLog,
        );

        $this->smartyRender('cash/history.tpl', $arrRender);
    }


    /**
     * 充值
     * @return void
     */
    public function actionCharge() {
        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/charge') );
        
        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();
        
        // 获取当前用户信息
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $memberDetail = $this->convertModelToArray($objMember);

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '充值',
            'return_url' => $this->createAbsoluteUrl('cash/detail'),
        );

        $this->smartyRender('cash/charge.tpl', $arrRender);
    }

    /**
     * 生成充值订单
     * @return void
     */
    public function actionInitChargeOrder() {
        // 获取参数
        $cash_amount = $this->getString($_POST['cash_amount']);

        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/charge') );
        
        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();

        // 订单
        $objOrder = new UcMemberOrder();
        $objOrder->member_id = $member_id;
        $objOrder->order_total = $cash_amount;
        $objOrder->order_type = 1;
        $objOrder->order_status = 1;

        // 订单事务
        if ($objOrder->save()) {
            // 插入历史记录
            $objOrderStatusHistory = new UcMemberOrderStatusHistory();
            $objOrderStatusHistory->order_id = $objOrder->order_id;
            $objOrderStatusHistory->order_status = $objOrder->order_status;
            $objOrderStatusHistory->save();

            // 支付
            $this->redirect( $this->createAbsoluteUrl('cash/chargeConfirm', array('order_id' => $objOrder->order_id)) );
        } else {
            Yii::app()->loginUser->setFlash('error', '充值失败，请重新操作');
            $this->redirect( $this->createAbsoluteUrl('cash/charge') );
        }

    }

    /**
     * 充值确认
     * @return void
     */
    public function actionChargeConfirm() {
        // 获取参数
        $order_id = $this->getInt($_GET['order_id']);

        // check login
        $this->checkLogin( $this->createAbsoluteUrl('cash/chargeConfirm', array('order_id' => $order_id)) );

        // 取出个人ID
        $member_id = Yii::app()->loginUser->getUserId();

        // 判断订单号是否存在
        if (empty($order_id)) {
            $this->redirect( $this->createAbsoluteUrl('cash/index') );
        }

         // 查询订单信息
        $queryResultOrder = UcMemberOrder::model()->published()->findByPk($order_id);
        $orderDetail = $this->convertModelToArray($queryResultOrder);

        // 订单不存在
        if (empty($orderDetail)) {
            $this->redirect($this->createAbsoluteUrl('cash/index'));
        }

        // 显示用订单号
        $display_order_id = $this->getDisplayChargeOrderId($orderDetail['order_id'], $orderDetail['create_time']);

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => false,
            'headerTitle' => '充值确认',
            'return_url' => $this->createAbsoluteUrl('cash/charge'),
            'order_id' => $order_id,
            'displayOrderId' => $display_order_id,
            'orderDetail' => $orderDetail,
        );

        $this->smartyRender('cash/charge_confirm.tpl', $arrRender);
    }    


    /**
     * 充值付款
     * @return [type] [description]
     */
    public function actionChargePay() {
        //获取参数
        $order_id = $this->getInt($_POST['order_id']);
        $payment_module_code = $this->getString($_POST['payment_module_code']);

        // 空订单号跳回首页
        if (empty($order_id)) {
            $this->redirect( $this->createAbsoluteUrl('cash/index') );
        }

        // check login
        $this->checkLogin( $this->createAbsoluteUrl('cash/chargePay', array('order_id'=>$order_id)) );
        
        // 取出个人ID
        $member_id = Yii::app()->loginUser->getUserId();

        // 获取订单信息
        $objOrder = UcMemberOrder::model()->published()->findByPk($order_id);
        $orderDetail = $this->convertModelToArray($objOrder);


        // 判断当前订单是否已支付订单且为当前用户的订单
        if ($objOrder->order_status == 2 || $objOrder->member_id != $member_id) {
            $this->redirect( $this->createAbsoluteUrl('cash/index') );
        }

        // TODO 根据不同支付方式进行处理
        // 目前暂支持支付宝
        //
        // 跳转到支付宝页面
        $objAlipayDirect = new AlipayDirect();

        // 支付参数
        $params = array(
            'order_id' => $order_id,
            'display_order_id' => $this->getDisplayChargeOrderId($order_id, $objOrder->create_time),
            'order_total' => floatval($objOrder->order_total),
            'display_payment_subject' => '充值',
            'display_payment_body' => '',
            'return_url' => '',
            'notify_url' => '',
            'show_url' => '',
            'extra_common_param' => basename(Yii::app()->getRequest()->getScriptUrl(), '.php'), //
        );

        $alipay_url = $objAlipayDirect->getAlipayUrl($params);

        //
        AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => 'send request to alipay', 'parameters' => $params, 'response' => array('alipay_url'=>$alipay_url)));

        // 跳转到支付宝页面
        $this->redirect($alipay_url);
    }


    /**
     * 充值成功
     * @return [type] [description]
     */
    public function actionChargeSuccess() {
        // 获取参数
        $order_id = $this->getInt($_GET['order_id']);

        // 空订单号跳回首页
        if (empty($order_id)) {
            $this->redirect( $this->createAbsoluteUrl('cash/index') );
        }

        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/chargeSuccess', array('order_id'=>$order_id)) );

        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();
        // 获取当前用户信息
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $memberDetail = $this->convertModelToArray($objMember);

        // 获取订单信息
        $objOrder = UcMemberOrder::model()->published()->findByPk($order_id);
        $orderDetail = $this->convertModelToArray($objOrder);

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '充值结果',
            'return_url' => $this->createAbsoluteUrl('cash/detail'),
            'order_id' => $order_id,
            'memberDetail' => $memberDetail,
            'orderDetail' => $orderDetail,
        );

        $this->smartyRender('cash/charge_success.tpl', $arrRender);
    }    


    /**
     * 充值失败
     * @return [type] [description]
     */
    public function actionChargeFail() {
        // 获取参数
        $order_id = $this->getInt($_GET['order_id']);

        // 空订单号跳回首页
        if (empty($order_id)) {
            $this->redirect( $this->createAbsoluteUrl('cash/index') );
        }

        // 检查是否登陆状态
        $this->checkLogin( $this->createAbsoluteUrl('cash/chargeFail', array('order_id'=>$order_id)) );
        
        // 获取当前用户ID
        $member_id = Yii::app()->loginUser->getUserId();
        // 获取当前用户信息
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $memberDetail = $this->convertModelToArray($objMember);

        // 获取订单信息
        $queryResultOrder = UcMemberOrder::model()->published()->findByPk($order_id);
        $orderDetail = $this->convertModelToArray($queryResultOrder);


        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '充值结果',
            'return_url' => $this->createAbsoluteUrl('cash/detail'),
            'order_id' => $order_id,
            'memberDetail' => $memberDetail,
            'orderDetail' => $orderDetail,
        );

        $this->smartyRender('cash/charge_success.tpl', $arrRender);
    }


    /**
     * 提取
     * @return [type] [description]
     */
    public function actionWithdraw() {
        //todo
        

        // render
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'headerTitle' => '现金提取',
            'return_url' => $this->createAbsoluteUrl('cash/detail'),
        );

        $this->smartyRender('cash/withdraw.tpl', $arrRender);
    }

}