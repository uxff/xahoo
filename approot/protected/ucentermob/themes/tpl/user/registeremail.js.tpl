{literal}
        <script>
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });

                //发送邮箱验证码后，提示重新操作时间
                var countdown = 60;
                //
                function showtime(val) {
                        //60s不能点击发送验证码按钮 
                        if (countdown == 0) {
                                val.removeAttribute("disabled");
                                val.setAttribute("class", 'h-signin-btn h-signin-btn2');
                                val.value = "重新获取";
                                countdown = 60;
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
                //
                function settime(val) {

                        //判断邮箱格式是否正确，是否已经注册 
                        var email = $('#email').val().trim();
                        var emailRule = /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i;
                        //判断手机号码是否为空
                        if (email.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入邮箱');
                                return false;
                        } else if (!emailRule.test(email)) {
                                $('.msg-container').css('display', '').find('p').html('请输入正确的邮箱格式');
                                return false;
                        }
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmail'), {email: email}, function(data) {
                                if (data.status == "fail") {
                                        //显示错误信息 
                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                        return false;
                                } else {
                                        val.removeAttribute("disabled");
                                        showtime(val);
                                        //发送验证码
                                        $.getJSON(gYiiCreateUrl('ajax', 'SendEmailCode'), {email: email}, function(data) {
                                                if (data.status == "fail") {
                                                        //显示错误信息
                                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                }
                                                if (data.status == "success") {
                                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                }
                                        });

                                }
                        });
                }

                //提交注册时 检测
                function r_submit() {
                        //邮箱
                        var email = $('#email').val().trim();
                        //验证码
                        var code = $('#code').val().trim();
                        //密码
                        var pwd = $("#pwd").val().trim();
                        //确认密码
                        var confirm_pwd = $("#confirm_password").val().trim();

                        var emailRule = /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i;
                        //判断手机号码是否为空
                        if (email.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入邮箱');
                                return false;
                        } else if (!emailRule.test(email)) {
                                $('.msg-container').css('display', '').find('p').html('请输入正确的邮箱格式');
                                return false;
                        }
                        //判断验证码是否为空
                        if (code.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('验证码不能为空');
                                return false;
                        }
                        //判断密码是否为空
                        if (pwd.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入密码');
                                return false;
                        } else if (pwd.length < 6 || pwd.length > 18) {
                                $('.msg-container').css('display', '').find('p').html('您输入的密码保持在6-18位');
                                return false;
                        }

                        //判断确认密码是否为空
                        if (confirm_pwd.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入确认密码');
                                return false;
                        } else if (pwd != confirm_pwd) {
                                $('.msg-container').css('display', '').find('p').html('密码和确认密码不一样');
                                return false;
                        }

                        //检测
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmail'), {email: email}, function(data) {
                                if (data.status == "fail") {
                                        //显示错误信息 
                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                } else {
                                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmailCode'), {code: code, email: email}, function(data) {
                                                if (data.status == "fail") {
                                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                } else {
                                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                                        frm.submit();
                                                }
                                        });


                                }
                        });
                }
        </script>
{/literal}