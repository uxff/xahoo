<section class="msg-container" style="display:none">
    <div class="h-alert h-alert-danger">
        <button type="button" class="h-close">×</button>
        <p></p>
    </div>
</section>
<section class="main-section">
    <form action="" id="reset_ques" >
        <ul class="h-form h-login-form">
            <li>
                <label class="label" for="">验证邮箱：</label>
                <div class="status">

                    <input type="text" name="email" maxlength="30" value="{$email}" readonly class="h-check">
                    <input type="text" name="email" maxlength="30" value="{$or_email}"  class="h-check" id="email" hidden>
                </div>
            </li>
            <li>
                <label class="label" for="">手机号：</label>
                <div class="status">
                    <input type="text" maxlength="16" name="" readonly value="{$member_mobile}">
                    <input type="text" maxlength="16" name="username" id="username" hidden value="{$mobile}">
                </div>
            </li>
            <li>
                <label class="label" for="">验证码：</label>
                <div class="status">
                    <input type="text" id="code" name="vetify_code" maxlength="16" value="" class="h-check">
                    <input type="button" id="btn" onclick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                </div>
            </li>
            <li class="h-bordernone">
                <input class="btn-orange100" type="button" onclick="r_submit()" name="" value="发送验证邮件">
            </li>
        </ul>
    </form>
</section>