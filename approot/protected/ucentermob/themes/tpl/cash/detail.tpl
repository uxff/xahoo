<section class="">
    <div class="h-income-box">
        <h3 class="tit no-bd-top clearfix"><i class="h-icon-comm"></i> 可提现余额</h3>
        <p class="all-num">￥<span>{$myCashTotal}</span></p>

        <ul class="income-detail clearfix">
            <a href="{yii_createurl c=cash a=charge}">
                <li><span class="recharge">充值</span></li>
            </a>
            <a href="{yii_createurl c=cash a=withdraw}">
                <li><span class="withdraw">提现</span></li>
            </a>
        </ul>
    </div>
    <div class="h-income-box mg-t10">
        <h3 class="tit clearfix">账单明细<a href="{yii_createurl c=cash a=history}" class="h-right orange">查看全部</a></h3>
        <ul class="h-uc-detail">
            {foreach from=$arrCashLog item=CashLog}
            <li>
                <h3 class="h-fs1 tit2">{$CashLog.display_cash_source}
                {if $CashLog.operate_type == 1}
                <span class="income">+{$CashLog.cash_amount}</span>
                {elseif $CashLog.operate_type == 2}
                <span class="income">-{$CashLog.cash_amount}</span>
                {/if}
                </h3>
                {if $CashLog.display_order_id}
                <p class="clearfix">{$CashLog.display_order_id}</p>
                {/if}
                <span class="date">{$CashLog.display_operate_time}</span>
            </li>
            {/foreach}
        </ul>
    </div>
</section>