{if !empty($arrMsgStack)}
    <section class="msg-container" style="display: none">
        <div class="h-alert h-alert-danger">
            <button type="button" class="h-close">&times;</button>
            {foreach from=$arrMsgStack key=msgType item=msgText}
                <p id="errMsg">{$msgText}</p>
            {/foreach}
        </div>
    </section>
{else}
    <section class="msg-container" style="display:none">
        <div class="h-alert h-alert-danger">
            <button type="button" class="h-close">&times;</button>
            <p></p>
        </div>
    </section>
{/if}
<section class="main-section">
    <form action="{yii_createurl c=account a=bindTradingPlatformForm}" method="post" id="bindTradingPlatform">
        <ul class="h-add-form">
            <li>
                <div class="status">
                    交易密码：
                    <input type="password" name="deal_password" id="dealPassword" maxlength="15" value="" class="h-check">
                </div>
            </li>
            <li class="h-bordernone">
                <input class="btn-orange100" type="button" id="bindTradingPlatformBtn" name="" value="提交">
            </li>
        </ul>
    </form>
</section>