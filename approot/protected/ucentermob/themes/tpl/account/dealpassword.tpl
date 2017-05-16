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
        <form action="{yii_createurl c=account a=dealpassword}" method="post" name="frm">
                <ul class="h-form">
                        <li>
                                <label class="label" for="">设置密码</label>  
                                <div class="status">
                                		<input type="password" placeholder="字母、数字、下划线或组合" name="new_password" id="newPwd" maxlength="18" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密码确认</label>  
                                <div class="status">
                                		<input type="password" placeholder="字母、数字、下划线或组合" name='confirm_password' id="confirmPwd" maxlength="18" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">手机号</label>
                                <div class="status">
                                        <p>{$mobile}</p>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">手机验证码</label>
                                <div class="status authcode clearfix">
                                        <input type="text" placeholder=""  name="verify_code" id="code" value="">
                                        <input type="button" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" onClick="r_submit()" type="button" value="保存">
                        </li>
                </ul>  
        </form>
</section>