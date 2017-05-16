{if !empty($arrMsgStack)}
    <section class="msg-container" style="">
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
        <form action="{yii_createurl c=account a=ModPwd}" method="post" name="frm">
                <ul class="h-form">
                        <li>
                                <label class="label" for="">原密码</label>
                                <div class="status">
                                        <input type="password" placeholder="请输入原密码" name='old_password' id="oldPwd" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">新密码</label>
                                <div class="status">
                                        <input type="password" placeholder="密码为6-18位字符，必须包含英文字母和数字" name="new_password" id="newPwd" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密码确认</label>
                                <div class="status">
                                        <input type="password" placeholder="请再次输入新密码" name='confirm_password' id="confirmPwd" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">手机号</label>
                                <div class="status">
                                        <p>{$mobile}</p>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">验证码</label>
                                <div class="status authcode clearfix">
                                        <input type="text" placeholder="" name="verify_code" id="code" value="">
                                        <input type="button" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" type="button" onClick="r_submit()" value="保存">
                        </li>
                </ul>
        </form>
</section>
