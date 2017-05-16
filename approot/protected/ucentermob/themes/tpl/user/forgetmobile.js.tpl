{literal}
        <script>
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });

                //发送短信验证码后，提示重新操作时间
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

                        //判断手机号格式是否正确，是否已经注册 
                        var tel = $('#username').val().trim();
                        var telrule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
                        //判断手机号码是否为空
                        if (tel.length == 0) {
								alert('请输入您的手机号');
                                //$('.msg-container').css('display', '').find('p').html('请输入您的手机号');
                                return false;
                        } else if (!telrule.test(tel)) {
								alert('请输入正确的手机号格式');
                                //$('.msg-container').css('display', '').find('p').html('请输入正确的手机号格式');
                                return false;
                        }
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckOldMobile'), {mobile: tel}, function(data) {

                                if (data.status == "fail") {
                                        //显示错误信息 
                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                        return false;
                                } else {
                                        val.removeAttribute("disabled");
                                        showtime(val);
                                        //发送验证码
                                        $.getJSON(gYiiCreateUrl('ajax', 'SendCode', "mobile=" + tel), function(data) {

                                                if (data.status == "fail") {
                                                        //显示错误信息 
                                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                } else {
                                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                                }
                                        });

                                }
                        });
                }

                //提交注册时 检测
                function checkAll() {
                        //手机号
                        var tel = $('#username').val().trim();
                        //验证码
                        var code = $('#code').val().trim();
                        //密码
                        var pwd = $("#pwd").val().trim();
                        //确认密码
                        var confirm_pwd = $("#confirm_password").val().trim();

                        var telrule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
						var passRule = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
                        //判断手机号码是否为空
                        if (tel.length == 0) {
								alert('请输入您的手机号');
                                //$('.msg-container').css('display', '').find('p').html('请输入您的手机号');
                                return false;
                        } else if (!telrule.test(tel)) {
								alert('请输入正确的手机号格式');
                                //$('.msg-container').css('display', '').find('p').html('请输入正确的手机号格式');
                                return false;
                        }
                        //判断验证码是否为空
                        if (code.length == 0) {
								alert('验证码不能为空');
                                //$('.msg-container').css('display', '').find('p').html('验证码不能为空');
                                return false;
                        }
                        //判断密码是否为空
                        if (pwd.length == 0) {
								alert('请输入密码');
                                //$('.msg-container').css('display', '').find('p').html('请输入密码');
                                return false;
                        } else if (pwd.length < 6 || pwd.length > 18 || !passRule.test(pwd)) {
								alert('密码为6-18位字符,必须包含英文字母和数字');
                                //$('.msg-container').css('display', '').find('p').html('密码为6-18位字符,必须包含英文字母和数字');
                                return false;
                        }
                        //判断确认密码是否为空
                        if (confirm_pwd.length == 0) {
								alert('请输入确认密码');
                                //$('.msg-container').css('display', '').find('p').html('请输入确认密码');
                                return false;
                        } else if (pwd != confirm_pwd) {
								alert('密码和确认密码不一样');
                                //$('.msg-container').css('display', '').find('p').html('密码和确认密码不一样');
                                return false;
                        }

                        frm.submit();
                        return false;
                }
        </script>
{/literal}