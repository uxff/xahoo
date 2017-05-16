<?php

/**
 * 公用业务逻辑
 */
class BaseController extends Controller {

    // 订单ID显示用前缀
    const CHARGE_ORDER_ID_DISPLAY_PREFIX = 'CZ-';
    // 订单ID显示用前缀
    const WITHDRAW_ORDER_ID_DISPLAY_PREFIX = 'TQ-';
    // 订单说明分隔符
    const ORDER_EXTRA_SEPERATOR = '  ####====####  ';

    /**
     * 获取充值订单显示ID
     * 
     * @param  string $order_id       订单ID
     * @param  string $date_purchased 购买时间
     * @return string                 显示订单号
     */
    public function getDisplayChargeOrderId($order_id, $date_purchased = '') {
        return AresUtil::formatDisplayOrderId($order_id, $date_purchased, self::CHARGE_ORDER_ID_DISPLAY_PREFIX);
    }

    /**
     * 获取提现订单显示ID
     * 
     * @param  string $order_id       订单ID
     * @param  string $date_purchased 购买时间
     * @return string                 显示订单号
     */
    public function getDisplayWithdrawOrderId($order_id, $date_purchased = '') {
        return AresUtil::formatDisplayOrderId($order_id, $date_purchased, self::WITHDRAW_ORDER_ID_DISPLAY_PREFIX);
    }

}