<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/login.css" />
<section class="poster-login">
    <div class="pic">
        {if $snsInfo}
        <img class="user" src="{$snsInfo.headimgurl}" style="width:140px;height:140px" coolieignore>
        {else}
        <img class="user" src="../../../../../resource/fanghu2.0/images/poster/user_head.jpg" >
        {/if}
    </div>
    <div class="input-box">
        <ul>
            <li>
                <span>昵称/姓名</span>
                <input type="text" placeholder="最多输入10个汉字或字符" class="cur" maxlength="10" id="nickname">
            </li>
            <li>
                <span>手机号码<i>*</i></span>
                {if $mobile}
                <input type="text" placeholder="请输入手机号码" class="input-input" maxlength="11" id="tel" value="{$mobile}" readonly>
                {else}
                <input type="text" placeholder="请输入手机号码" class="input-input" maxlength="11" id="tel" value="{$mobile}">
                {/if}
            </li>
            <li>
                <span>个性签名</span>
                <textarea  type="text" placeholder="最多输入20个汉字和字符"  maxlength="20" id="desc"></textarea>
            </li>
        </ul>
    </div>
</section>
<section class="login-link">
    <button type="submit" class="btn lot-btn" url="{yii_createurl c=wechat a=ajaxDiyHaibao}">提交</button>
</section>

{include file="../site/weixin_firend.tpl"}
<script  src="../../../../../resource/fanghu2.0/js/lib/validation/q.validation.js"></script>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
        data-config="../../conf/coolie-config.js"
        data-main="../main/poster_login.js"></script>
