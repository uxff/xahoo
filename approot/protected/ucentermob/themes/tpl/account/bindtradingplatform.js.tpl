<script type="text/javascript" src="{$resourceThirdVendorPath}/jquery/jquery.min.js"></script>
{literal}
    <script>
        var errMsg = $('#errMsg').html();
        if(null != errMsg) {
            alert(errMsg);
        }
        jQuery(document).ready(function() {
            var url = gYiiCreateUrl('ajax', 'isSetDealPassword');
            $.ajax({
                url           :       url,
                type         :      'get',
                success     :       function(data) {
                    if(data == 00) {
                        alert('为了您的隐私和财产安全，请设置交易密码！', '温馨提示');
                        window.location.href=gYiiCreateUrl('account', 'dealpassword');
                        return false;
                    }
                }
            });


            $('#bindTradingPlatformBtn').on({
                click       :       function() {
                    var dealPassword = $('#dealPassword ').val().trim();


                    if(dealPassword == '') {
                        alert('请输入交易密码', '温馨提示');
                        return false;
                    }
                    $('#bindTradingPlatform').submit();
                }

            });
        });
    </script>
{/literal}