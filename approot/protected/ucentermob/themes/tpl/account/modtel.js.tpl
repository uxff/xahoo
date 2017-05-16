{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                //发送短信验证码后，提示重新操作时间
                var countdown = 60;

                var num = 0;
                function showtime(val) {
                        //60s不能点击发送验证码按钮 
                        if (countdown == 0) {
                                val.removeAttribute("disabled");
                                val.setAttribute("class", 'send');
                                val.value = "重新获取";
                                countdown = 60;
                                return false;
                        } else {
                                num = 1;
                                val.setAttribute("disabled", true);
                                val.setAttribute("class", 'send');
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
                        var tel = $('#mobile').val().trim();

                        //手机号码验证规则
                        var telrule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
                        if (tel.length == 0) {
                                alert('请输入您的手机号');
                                // $('.msg-container').css('display', '').find('p').html('请输入您的手机号');
                                return false;
                        } else if (!telrule.test(tel)) {
                                alert('您输入的手机号码格式不正确');
                                // $('.msg-container').css('display', '').find('p').html('您输入的手机号码格式不正确');
                                return false;
                        }

                        $.getJSON(gYiiCreateUrl('ajax', 'CheckModMobile'), {mobile: tel}, function(data) {

                                if (data.status == "fail") {
                                        //显示错误信息)
										alert(data.message);
                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                        return false;
                                } else {
                                        val.removeAttribute("disabled");
                                        showtime(val);

                                        //发送验证码
                                        $.getJSON(gYiiCreateUrl('ajax', 'SendCode'), {mobile: tel}, function(data) {
                                                if (data.status == "success") {
                                                        //显示错误信息
														alert(data.message);
                                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                }
                                                if (data.status == "fail") {
                                                        //显示错误信息 
														alert(data.message);
                                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                }
                                        });
                                }
                        });
                }

                //提交注册时 检测
                function checkAll() {
                        //手机号
                        var tel = $('#mobile').val().trim();
                        //验证码
                        var code = $('#code').val().trim();
						//入登陆密码	
						var password = $('#password').val().trim();
                        //手机号码验证规则
                        var telrule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
                        if (tel.length == 0) {
                                alert('请输入您的手机号');
                                // $('.msg-container').css('display', '').find('p').html('请输入您的手机号');
                                return false;
                        } else if (!telrule.test(tel)) {
                                alert('您输入的手机号码格式不正确');
                                // $('.msg-container').css('display', '').find('p').html('您输入的手机号码格式不正确');
                                return false;
                        }
			if (password.length == 0) {
                                alert('请输入登陆密码');
                                // $('.msg-container').css('display', '').find('p').html('请输入登陆密码');
                                return false;
                        }
                        if (code.length == 0) {
                                alert('请输入验证码');
                                // $('.msg-container').css('display', '').find('p').html('请输入验证码');
                                return false;
                        }
						
                        frm.submit();
                        return false;
                }
        </script>
{/literal}