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
                        <p>亲爱的会员 ，您好:</p>
                        <p><?php echo $EMAIL_TXT_VERIFY_CONTENT; ?></p>
                        <h3>您只需点击下面的链接即可重设您的密保：</h3>
                        <p><?php echo $URL; ?></p>
                        
                        <h4>该邮件请妥善保存，切勿向第三方透露。</h4>
                        <p>欢迎您回家~！</p>
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