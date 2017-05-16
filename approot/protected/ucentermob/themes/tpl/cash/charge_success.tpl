<section class="">
    <div class="x-conh">
        {if $orderDetail.order_status == 2}
        <h2 class="green"><i class="icon-ok-sign"></i>充值成功!</h2>
        {else}
        <h2 class="red"><i class="icon-remove-circle"></i>充值失败!</h2>
        {/if}
    </div>
    <ul class="x-lbc">
        <li>充值到当前账户：{$member_nickname}</li>
        <li>充值金额：￥{$orderDetail.order_total}</li>
    </ul>
    {if $orderDetail.order_status == 2}
    <a href="{yii_createurl c=cash a=index}" class="btn-orange100 x-btn-lr">查看我的资产</a>
    {else}
    <a href="{yii_createurl c=cash a=chargeConfirm order_id=$order_id}" class="btn-orange100 x-btn-lr">重新支付</a>
    {/if}
</section>