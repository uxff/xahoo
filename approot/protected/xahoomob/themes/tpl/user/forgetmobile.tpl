<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/reg.css" />
<form onsubmit="return false" id="form" method="post" name="frm" >
    <input type="hidden" name="return_url" id="return_url" value="{$return_url}" />
    <input type="hidden" name="token" id="token" value="{$token}" />
    <section class="form-box">
        <ul>
            <li>
                <span>手机号码</span>
                <input type="tel" class="form-input"  name="username" id="username" placeholder="请输入真实手机号"    />
            </li>
            <li>
                <span>图形码：</span>
                <input type="text" name="valicode" id="valicode" class="form-input" placeholder="请输入图形验证码" maxlength="6"/>
                <div  class="form_cord">
                <img style="cursor:pointer" class="reloadCode" title="点击换一张" src="{yii_createurl c=ajaxuc a=ValidationCode width=80 height=30}" id="reloadValicode" coolieignore/>
                </div>
            </li>
            <li>
                <span>验证码</span>
                <input type="tel" class="form-input"  id="code" name="vetify_code"   placeholder="请输入验证码" />
                <input type="button" id="yzm_txt" class="btn-yzm" value="获取验证码" />
            </li>
            <li>
                <span>新密码</span>
                <input type="password" class="form-input" id="pwd" name="password" placeholder="请设置新密码，不少于6位" />
            </li>
        </ul>
    </section>
    <section class="btn-link">
        <button class="btn lot-btn" type="button">确定</button>
    </section>
</form>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
    data-config="../../conf/coolie-config.js"
    data-main="../main/forget_password.js"></script>