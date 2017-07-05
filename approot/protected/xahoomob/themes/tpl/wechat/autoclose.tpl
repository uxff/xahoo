<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/integral.css" />
<section class="">
    <div class="invite_reg_banner">
        <img src="../../../../../resource/fanghu2.0/images/integral/integ_friend.jpg" alt="">
    </div>
    <div class="invite_reg_info">
        <p>登录成功，页面将在2秒后关闭并返回聊天界面，如不跳转请点击<a href="{yii_createurl c=site a=index}">&nbsp;&nbsp;首&nbsp;&nbsp;页&nbsp;&nbsp;</a></p>
    </div>
</section>
{include file="../site/weixin_firend.tpl"}
{literal}
<script>
//alert('will close');
setTimeout('wx.closeWindow()', 3000);
//wx.closeWindow();
</script>
{/literal}
