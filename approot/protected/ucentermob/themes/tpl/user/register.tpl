{if !empty($arrMsgStack)}
<section class="msg-container" style="display: none;">
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
  <form action="{yii_createurl c=user a=registerform}" method="post" name="frm" onSubmit="return checkAll();" class="h-log-form">
    <input type="hidden" name="return_url" value="{$return_url}" />
    <input type="hidden" name="signage" value="{$signage}" />
    <ul class="h-form h-login-form">
      <li>
      <label class="label" for="">手机号</label>  
      <div class="status status3">
        <input type="text" maxlength="16" name="username" id="username" placeholder="请填写手机号">
      </div>
      </li>
      <li>
      <label class="label" for="">验证码</label>  
      <div class="status status3">
        <input type="text" id="code" name="vetify_code" maxlength="16" value="" class="h-check" placeholder="请填写验证码">
        <input type="button" id="btn" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
      </div>
      </li>
      <li>
      <label class="label" for="">密码</label>  
      <div class="status status3">

        <input type="password" id="pwd" name="password" maxlength="16" value="" placeholder="密码为6-18位字符，必须包含英文字母和数字">
      </div>
      </li>
      <li>
      <label class="label" for="">确认密码</label>  
      <div class="status status3">

        <input type="password" id="confirm_password" name="confirm_password" maxlength="16" value="" placeholder="请再次输入新密码">
      </div>
      </li>
      <li class="h-bordernone h-gray">
      {*<a href="{yii_createurl c=user a=registeremail return_url=$return_url}" class="h-left">邮箱注册</a>*}<a href="{$sbd_url}"  class="h-right">收不到验证码</a>
      </li>
      <li class="h-bordernone">
      <input class="btn-ora" type="submit" name="" value="注册">
      </li>
      <li class="h-bordernone h-sign-agree">
      {*<span class="">注册即视为同意XXX的</span><a href="#"  class="h-orange">服务协议</a>*}
      </li>
    </ul>  
  </form>
</section>
