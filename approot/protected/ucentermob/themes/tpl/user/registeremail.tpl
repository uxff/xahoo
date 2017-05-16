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
        <form action="{yii_createurl c=user a=registeremailform}" method="post" name="frm" class="h-log-form">
                <input type="hidden" name="return_url" value="{$return_url}" />
                <ul class="h-form h-login-form">
                        <li>
                                <label class="label" for="">邮箱</label>  
                                <div class="status">
                                        <input type="text" maxlength="26" name="email" id="email">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">验证码</label>  
                                <div class="status">
                                        <input type="text" id="code" name="vetify_code" maxlength="16" value="" class="h-check">
                                        <input type="button" id="btn" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密码</label>
                                <div class="status">

                                        <input type="password" id="pwd" name="password" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">确认密码</label>  
                                <div class="status">

                                        <input type="password" id="confirm_password" name="confirm_password" maxlength="16" value="">
                                </div>
                        </li>
                        <li class="h-bordernone h-gray">
                                <a href="{yii_createurl c=user a=register return_url=$return_url}" class="h-left">手机注册</a>
                        </li>
                        <li class="h-bordernone">
                                <input class="btn-ora-line" onClick="r_submit()" type="button" value="注册">
                        </li>
                        <li class="h-bordernone h-sign-agree">
                                {*<span class="">注册即视为同意XXX的</span><a href="#"  class="h-orange">服务协议</a>*}
                        </li>
                </ul>  
        </form>
</section>