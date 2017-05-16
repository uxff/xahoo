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
                        <p><?php echo $EMAIL_TXT_VERIFY_CONTENT; ?></p>

                        <h3>请点击下面的链接激活您的账号</h3>
                        <p><a href="<?php echo $EMAIL_LINK_VERIFY; ?>"><?php echo $EMAIL_LINK_VERIFY; ?></a></p>
                        <p>激活后则可以使用该邮箱进行登录。</p>
                        
                        <h4>该邮件请妥善保存，切勿向第三方透露。</h4>
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