{*{if !empty($arrMsgStack)}*}
    {*<section class="msg-container">*}
            {*<div class="h-alert h-alert-danger">*}
                    {*<button type="button" class="h-close">&times;</button>*}
                    {*{foreach from=$arrMsgStack key=msgType item=msgText}*}
                        {*<p>{$msgText}</p>*}
                    {*{/foreach}*}
            {*</div>*}
    {*</section>*}
{*{else}*}
    {*<section class="msg-container" style="display:none">*}
            {*<div class="h-alert h-alert-danger">*}
                    {*<button type="button" class="h-close">&times;</button>*}
                    {*<p></p>*}
            {*</div>*}
    {*</section>*}
{*{/if}*}
<section class="main-section">
        <form action="{yii_createurl c=user a=createaccount from=$from}" method="post"  name="frm" >
                <ul class="h-form">
                        {*<li>*}
                        {*<label class="label" for="">原手机号</label>*}
                        {*<div class="status">*}
                        {*<p>{$mobile}</p>*}
                        {*</div>*}
                        {*</li>*}
                        <li>
                                <label class="label" for="">手机号</label>
                                <div class="status status3">
                                        <input type="tel" placeholder="请输入手机号码" name="member_mobile" id="mobile" maxlength="11" value="">
                                </div>
                        </li>
                        {*<li>*}
                                {*<label class="label" for="">邮箱</label>*}
                                {*<div class="status">*}
                                        {*<input type="tel" placeholder="请输入邮箱" name="member_email" id="mobile" maxlength="11" value="">*}
                                {*</div>*}
                        {*</li>*}
                        <li>
                                <label class="label" for="">验证码</label>
                                <div class="status status3">
                                        <input type="text" placeholder="请输入验证码"  name="verify_code" id="code" value="" style="width:130px">
                                        <input type="button" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li>
                                <input class="btn-ora-line" type="button" onClick="checkAll()" value="保存">
                        </li>
                </ul>
        </form>
</section>
