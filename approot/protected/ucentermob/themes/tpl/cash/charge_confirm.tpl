<section class="">
    <div class="container recharge_two">
        <p>订单号：<span>{$displayOrderId}</span></p>
        <p>充值金额：<span>￥{$orderDetail.order_total}</span></p>
    </div>
    <form action="{yii_createurl c=cash a=chargePay}" method="POST">
        <input type="hidden" name="order_id" value="{$order_id}" />
        <ul class="h-add-form h-add-form-recharge_two">
            <li>
              <div class="status recharge_two_status">&nbsp;选择支付方式</div>
              <div class="recharge_two_zhifubao"><img src="{$resourcePath}/imgs/zfb.png" alt="" /><span class="zfb-font">支付宝支付</span><input class="mt" type="radio" checked="checked" name="payment_module_code" value="alipay"></div>
              <!--
              <div class="recharge_two_weixin"><img src="{$resourcePath}/imgs/wx.png" alt="" /><span class="zfb-font">微信支付</span><input class="mt" type="radio" name="payment_module_code" value="tenpay"></div>
              <div class="recharge_two_yinhangka"><img src="{$resourcePath}/imgs/yhk.png" alt="" /><span class="zfb-font">银行卡支付</span><input class="mt" type="radio" name="payment_module_code" value="unionpay"></div>
              --> 
            </li>
            
            <li class="h-bordernone">
                <input class="btn-orange1000" type="submit" value="马上支付">
            </li>
        </ul>  
    </form> 
</section>