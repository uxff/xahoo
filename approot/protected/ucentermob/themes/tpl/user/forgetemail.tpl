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
        <section class="msg-container" style="display:none">
                <div class="h-alert h-alert-danger">
                        <button type="button" class="h-close">&times;</button>
                        <p></p>
                </div>
        </section>
{/if}

<section class="main-section">
        <form action="{yii_createurl c=user a=emailPwd}" method="post" name="frm" class="h-log-form">
        		<input type="hidden" name="return_url" value="{$return_url}" />
                <ul class="h-form h-login-form">
                        <li>
                                <label class="label" for="">邮箱</label>  
                                <div class="status">
                                        <input type="text" maxlength="26" name="email" id="email">
                                </div>
                        </li>
                        <li class="h-bordernone h-gray">
                                <a href="{yii_createurl c=user a=forgetmobile return_url=$return_url}" class="h-left">手机找回</a>
                        </li>
                        <li class="h-bordernone">
                                <input class="btn-ora-line" onClick="r_submit()" type="button" value="发送验证邮箱">
                        </li>
                </ul>  
        </form>
</section>