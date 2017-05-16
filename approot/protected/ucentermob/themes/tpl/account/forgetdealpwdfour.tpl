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
        <form action="{yii_createurl c=account a=forgetdealpwdfive}" method="post" name="frm">
        		<input type="hidden" name="answer" value="{$answer}" />
                <input type="hidden" name="member_id_number" value="{$member_id_number}" />
                <input type="hidden" name="new_password" value="{$new_password}" />
                <ul class="h-form">
                        <li>
                                <label class="label" for="">手机号</label>
                                <div class="status">
                                        <p>{$mobile}</p>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">验证码</label>
                                <div class="status authcode clearfix">
                                        <input type="text" placeholder="请输入验证码"  name="verify_code" id="code" value="">
                                        <input type="button" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora-line" type="button" onClick="r_submit()" value="确定">
                        </li>
                </ul>
        </form>
</section>
