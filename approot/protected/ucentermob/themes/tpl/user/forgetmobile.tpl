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
        <form action="{yii_createurl c=user a=mobilePwd}" method="post" name="frm" onSubmit="return checkAll();" class="h-log-form">
        		<input type="hidden" name="return_url" value="{$return_url}" />
                <ul class="h-form h-login-form">
                        <li>
                                <label class="label" for="">手机号</label>  
                                <div class="status">
                                        <input type="text" placeholder="请输入您的手机号"  maxlength="16" name="username" id="username">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">验证码</label>  
                                <div class="status">
                                        <input type="text" placeholder="请输入验证码"  id="code" name="vetify_code" maxlength="16" value="" class="h-check">
                                        <input type="button" id="btn" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">新密码设置</label>  
                                <div class="status">

                                        <input type="password" id="pwd" placeholder="密码为6-18位字符，必须包含英文字母和数字"  name="password" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">确认新密码</label>  
                                <div class="status">

                                        <input type="password" id="confirm_password" placeholder="请再次输入新密码"  name="confirm_password" maxlength="16" value="">
                                </div>
                        </li>
                        <li class="h-bordernone h-gray">
                                {*<a href="{yii_createurl c=user a=forgetemail return_url=$return_url}" class="h-left">邮箱找回</a><span class="h-left">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href="{yii_createurl c=user a=forgotquestion return_url=$return_url}" class="h-left">密保问题</a>*}<a href="{$sbd_url}"  class="h-right">收不到验证码</a>
                        </li>
                        <li class="h-bordernone">
                                <input class="btn-ora-line" type="submit" name="" value="提交">
                        </li>
                </ul>  
        </form>
</section>