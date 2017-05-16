<section class="">
    <form id="idCashForm" action="{yii_createurl c=cash a=initChargeOrder}" method="POST">
        <ul class="h-add-form">
            <li class="h-bordernone">
              <div class="status2">充值至当前账户：{$member_nickname}</div>
            </li>
            <li>
              <div class="status">
                  充值金额：
                  <input type="text" id="cashAmount" name="cash_amount" maxlength="16" value="" class="h-check">
              </div>
            </li>
            <span class="errTip"></span>
            <li class="h-bordernone">
                <input class="btn-orange100" id="idSmtBtn" type="submit" value="下一步">
            </li>
        </ul>  
    </form> 
</section>