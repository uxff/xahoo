{literal}
    <script>

        var errMsg = $('#errMsg').html();
        if(null != errMsg) {
            alert(errMsg);
        }
        //发送短信验证码后，提示重新操作时间
        var countdown = 90;
        //

        function showtime(val) {
            //60s不能点击发送验证码按钮
            if (countdown == 0) {
                val.removeAttribute("disabled");
                val.setAttribute("class", 'h-signin-btn');
                val.value = "重新获取";
                countdown = 90;
                return false;
            } else {
                val.setAttribute("disabled", true);
                val.setAttribute("class", 'h-signin-btn h-grey-bg');
                val.value = "重新获取(" + countdown + ")";
                countdown--;
            }
            setTimeout(function() {
                showtime(val)
            }, 1000);
        }


        function settime(val) {
            //判断手机号格式是否正确，是否已经注册
            var tel = $('#mobile').val().trim();
            showtime(val);
            //发送验证码
            $.getJSON(gYiiCreateUrl('ajax', 'SendCode'), {mobile: tel}, function (data) {

                if (data.status == "fail") {
                    //显示错误信息
                    alert('验证发送失败');
                    return false;
                } else {
                    alert(data.message);
                }
            });
        }

    </script>

    <script>
        $('#bindTradingPlatformBtn').on({
            click       :       function() {
                var platformType = $('#platformType').val().trim();     //平台类型
                var platformAccount = $('#platformAccount').val().trim();     //平台帐号
                var code = $('#code').val().trim();     //平台帐号

                if(platformType == 0) {
                    alert('请选择支付平台');
                    return false;
                }

                if(platformAccount == '') {
                    alert('请输入支付帐号');
                    return false;
                }

                if(code == ''){
                    alert('请输入验证码');
                    return false;
                }

                $('#bindTradingPlatform').submit();
                return false;
            }
        });
    </script>
{/literal}