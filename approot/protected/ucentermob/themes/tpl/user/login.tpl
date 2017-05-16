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
        <form action="{yii_createurl c=user a=loginForm}" method="POST" class="h-log-form" onSubmit="return check()">
                <input type="hidden" name="return_url" value="{$return_url}" />
                <ul class="h-form h-login-form">
                        <li>
                                <label class="label" for="">登录名</label>
                                <div class="status">
                                        <input type="text" placeholder="请输入手机号/邮箱" name="username" value="" maxlength="26" id="username"/>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密码</label>  
                                <div class="status">
                                        <input type="password" placeholder="请输入密码" name="password" value=""  id="password" maxlength="16">
                                </div>
                        </li>
                        <li class="h-bordernone h-gray">
                                <a href="{yii_createurl c=user a=register return_url=$return_url}" class="h-left">还没有账号？<span class="orange">手机号快速注册</span></a>
                                <a href="{yii_createurl c=user a=forgetmobile return_url=$return_url}" id="fogotpassword" class="h-right"><span class="orange">忘记密码</span></a>
                        </li>
                        <li class="h-bordernone">
                                <input class="btn-ora" type="submit" name="" value="登录">
                        </li>
                </ul>  
        </form>
        {*
        <div class="h-login-by">
                <span class="h-login-span">选择第三方登录</span>
                <ul class="h-login-ul">
                        <li><a href="{if isset($qq_url) && !empty($qq_url)}{$qq_url}{/if}" class="h-login-qq"></a></li>
                        <li><a href="{if isset($sina_url) && !empty($sina_url)}{$sina_url}{/if}" class="h-login-weibo"></a></li>
                        <li><a href="{if isset($weixin_url) && !empty($weixin_url)}{$weixin_url}{/if}" class="h-login-weixin"></a></li>
                </ul>
        </div>
        *}
</section>
