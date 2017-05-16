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
        <form action="{yii_createurl c=account a=modtel}" method="post"  name="frm" >
                <ul class="h-form">
                        <li>
                                <label class="label" for="">已绑定手机号</label>
                                <div class="status">
                                        <p>{$mobile}</p>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">新手机号</label>
                                <div class="status">
                                        <input type="tel" placeholder="请输入新手机号码" name="new_mobile" id="mobile" maxlength="11" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">登陆密码</label>
                                <div class="status">
                                        <input type="password" placeholder="请输入登陆密码" name="password" id="password" maxlength="11" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">验证码</label>
                                <div class="status authcode clearfix">
                                        <input type="text" placeholder=""  name="verify_code" id="code" value="">
                                        <input type="button" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" type="button" onClick="checkAll()" value="保存">
                        </li>
                </ul>
        </form>
</section>
