<!-- body -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <!-- content -->
            <div class="content">
            <table>
                <tr>
                    <td>
                        <p>亲爱的会员 <?php echo $EMAIL_TXT_WELCOME_NAME; ?>，您好:</p>
                        <p>您的密码已经发起重置，新的密码为：<strong><?php echo $EMAIL_TXT_NEW_PASSWORD; ?></strong></p>
                        <p>请使用新密码登录，登录后请尽快进入个人中心进行密码修改！</p>
                        
                        <h3>点击下面链接登录</h3>
                        <p><a href="<?php echo $EMAIL_LINK_LOGIN; ?>"><?php echo $EMAIL_LINK_LOGIN; ?></a></p>
                        
                        <h4>该邮件请妥善保存，切勿向第三方透露。</h4>
                        <p>欢迎回家~！</p>
                        <p>您的<a href="<?php echo $EMAIL_LINK_WEBSITE; ?>"><?php echo $EMAIL_TXT_WEBSITE_SHORT_NAME; ?></a></p>
                    </td>
                </tr>
            </table>
            </div>
            <!-- /content -->
            
        </td>
        <td></td>
    </tr>
</table>
<!-- /body -->