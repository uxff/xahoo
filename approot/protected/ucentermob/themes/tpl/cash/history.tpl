<section class="">
    <div class="h-income-box mg-t10">
        <h3 class="tit clearfix">账单明细</h3>
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