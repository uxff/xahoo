{if !empty($arrMsgStack)}
    <section class="msg-container">
            <div class="h-alert h-alert-danger">
                    <button type="button" class="h-close">&times;</button>
                    {foreach from=$arrMsgStack key=msgType item=msgText}
                        <p>{$msgText}</p>
                    {/foreach}
            </div>
    </section>
{else}
    <section class="msg-container" style="display:none" id="container">
            <div class="h-alert h-alert-danger">
                    <button type="button" class="h-close">&times;</button>
                    <p></p>
            </div>
    </section>
{/if}

<section class="main-section">
        <form action="">
                <ul class="h-add-form">
                        <li> 

                                     <!-- <div class="status">
                                            <select name="" class="sel2">
                                                {foreach from=$list item=item}
                                                    <option value="{$item.id}">{if  $item.platform_type == 1}支付宝{elseif $item.platform_type == 2}微信{/if}（{$item.platform_account}）</option>
                                                {/foreach}
                                            </select>
                                            <i class="icon-angle-right"></i>
                                    </div>  -->
                            <div class="status">
                               {foreach from=$list item=item}
                                   <span> 支付类型:{if  $item.platform_type == 1}支付宝{elseif $item.platform_type == 2}微信{elseif $item.platform_type == 3}易宝支付{/if}     &nbsp;  支付账户: （{$item.platform_account}）</span><br/>
                               {/foreach}  
                            </div>        

                        </li>
                        <li class="h-bordernone">
                                <input class="btn-orange100" type="button" name="" value="添加支付平台" onclick="window.location.href='{yii_createurl c=account a=addTradingPlatform}';return false;">
                        </li>
                        <li class="h-bordernone">
                                <span class="h-fs12 grey6e">温馨提示：<br>为了保障您的账户安全，提现时只支持本人实名下的银行储蓄卡，不支持信用卡，请添加储蓄卡正确信息，以免影响提现。</span>
                        </li>
                </ul>  
        </form> 
</section>