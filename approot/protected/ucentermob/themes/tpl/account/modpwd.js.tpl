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

						val.removeAttribute("disabled");
						showtime(val);

						//发送验证码
						$.getJSON(gYiiCreateUrl('ajax', 'SendMobileCode'), {}, function(data) {
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
				
                function r_submit() {
                        var oldPwd = $("#oldPwd").val();
                        var newPwd = $("#newPwd").val();
                        var confirmPwd = $("#confirmPwd").val();
                        var code = $('#code').val().trim();
						var passRule = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
                        if (oldPwd.length == 0) {
                                alert('请输入原密码');
                                // $('.msg-container').css('display', '').find('p').html('请输入原密码');
                                return false;
                        }
                        if (newPwd.length == 0) {
                                alert('请输入新密码');
                                // $('.msg-container').css('display', '').find('p').html('请输入新密码');
                                return false;
                        } else if (newPwd.length < 6 || newPwd.length > 18 || !passRule.test(newPwd)) {
                                alert('您输入的密码保持在6-18位,必须包含英文字母和数字');
                                // $('.msg-container').css('display', '').find('p').html('您输入的密码保持在6-18位');
                                return false;
                        }
                        if (oldPwd === newPwd) {
                                alert('新密码不能与旧密码一致');
                                // $('.msg-container').css('display', '').find('p').html('新密码不能与旧密码一致');
                                return false;
                        }
                        if (confirmPwd.length == 0) {
                                alert('请再次输入新密码');
                                // $('.msg-container').css('display', '').find('p').html('请再次输入新密码');
                                return false;
                        }
                        if (newPwd !== confirmPwd) {
                                alert('两次密码输入不一致');
                                // $('.msg-container').css('display', '').find('p').html('两次密码输入不一致');
                                return false;
                        }
                        if (code.length == 0) {
                                alert('请输入验证码');
                                // $('.msg-container').css('display', '').find('p').html('请输入验证码');
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}