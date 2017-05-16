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
        <form action="" method="post" name="frm">
                <ul class="h-form">
                        <li>
                                <label class="label" for="">原绑定邮箱</label>  
                                <div class="status">
                                        {if empty($email)}<p class="grey999">未设置</p>{else}<p>{$email}</p>{/if}
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">新绑定邮箱</label>  
                                <div class="status">
                                        <input type="email" placeholder="请输入新邮箱" name="new_email" id="email" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">邮箱验证码</label>  
                                <div class="status authcode clearfix">
                                        <input type="text" id="code" name="vetify_code" placeholder="" maxlength="16" value="" class="h-check">
                                        <input type="button" id="btn" onClick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
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
                                        <input type="text" placeholder=""  name="verify_code_tel" id="code_tel" value="">
                                        <input type="button" onClick="settimetel(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" onClick="r_submit()" type="button" value="保存">
                        </li>
                </ul>  
        </form>
</section>