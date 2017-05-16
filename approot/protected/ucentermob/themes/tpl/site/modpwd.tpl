{if !empty($message)}
        <section class="msg-container" style="">
                <div class="h-alert h-alert-danger">
                        <button type="button" class="h-close">&times;</button>
                        <p>{$message}</p>
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
        <form action="{yii_createurl c=site a=ResetPwd return_url=$return_url}" method="post" name="frm">
                <ul class="h-form">
                        {*<li>*}
                                {*<label class="label" for="">原密码</label>*}
                                {*<div class="status">*}
                                        {*<input type="password" placeholder="6-16个字符，区分大小写" name='old_password' id="oldPwd" maxlength="16" value="">*}
                                {*</div>*}
                        {*</li>*}
                        <li>
                                <label class="label" for="">新密码</label>
                                <div class="status">
                                        <input type="password" placeholder="6-16个字符，区分大小写" name="new_password" id="newPwd" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密码确认</label>
                                <div class="status">
                                        <input type="password" placeholder="6-16个字符，区分大小写" name='confirm_password' id="confirmPwd" maxlength="16" value="">
                                </div>
                        </li>
                        <li>
                                <input class="btn-ora-line" type="button" onClick="r_submit()" value="保存">
                        </li>
                </ul>
        </form>
</section>
