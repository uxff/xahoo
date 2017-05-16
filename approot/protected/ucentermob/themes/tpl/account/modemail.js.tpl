{literal}
        <script type="text/javascript" >
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
                                val.setAttribute("class", 'send');
                                val.value = "重新获取邮箱验证码";
                                countdown = 60;
                                return false;
                        } else {
                                val.setAttribute("disabled", true);
                                val.setAttribute("class", 'send');
                                val.value = "重新获取邮箱验证码(" + countdown + ")";
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
                                alert('请输入邮箱');
                                // $('.msg-container').css('display', '').find('p').html('请输入邮箱');
                                return false;
                        } else if (!emailRule.test(email)) {
                                alert('请输入正确的邮箱格式');
                                // $('.msg-container').css('display', '').find('p').html('请输入正确的邮箱格式');
                                return false;
                        }
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmail'), {email: email}, function(data) {
                                if (data.status == "fail") {
                                        //显示错误信息
										alert(data.message);  
                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                        return false;
                                } else {
                                        val.removeAttribute("disabled");
                                        showtime(val);
                                        //发送验证码
                                        $.getJSON(gYiiCreateUrl('ajax', 'SendEmailCode'), {email: email}, function(data) {
                                                if (data.status == "fail") {
                                                        //显示错误信息 
														alert(data.message);
                                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                }
                                                if (data.status == "success") {
														alert(data.message);
                                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                                        return false;
                                                }
                                        });

                                }
                        });
                }


                //发送短信验证码后，提示重新操作时间
                var countdowntel = 60;

                function showtimetel(val) {
                        //60s不能点击发送验证码按钮 
                        if (countdowntel == 0) {
                                val.removeAttribute("disabled");
                                val.setAttribute("class", 'send');
                                val.value = "重新获取手机验证码";
                                countdowntel = 60;
                                return false;
                        } else {
                                val.setAttribute("disabled", true);
                                val.setAttribute("class", 'send');
                                val.value = "重新获取手机验证码(" + countdowntel + ")";
                                countdowntel--;
                        }
                        setTimeout(function() {
                                showtimetel(val)
                        }, 1000);
                }
                //
                function settimetel(val) {

						val.removeAttribute("disabled");
						showtimetel(val);

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
                        //邮箱
                        var email = $('#email').val().trim();
                        var emailRule = /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i;
                        //验证码
                        var code = $('#code').val().trim();
						var code_tel = $('#code_tel').val().trim();
                        if (email.length == 0) {
                                alert('请输入邮箱');
                                // $('.msg-container').css('display', '').find('p').html('请输入邮箱');
                                return false;
                        } else if (!emailRule.test(email)) {
                                alert('请输入正确的邮箱格式');
                                // $('.msg-container').css('display', '').find('p').html('请输入正确的邮箱格式');
                                return false;
                        }
                        //判断验证码是否为空
                        if (code.length == 0) {
                                alert('邮箱验证码不能为空');
                                // $('.msg-container').css('display', '').find('p').html('邮箱验证码不能为空');
                                return false;
                        }

                        //判断手机验证码是否为空
                        if (code_tel.length == 0) {
                                alert('手机验证码不能为空');
                                // $('.msg-container').css('display', '').find('p').html('手机验证码不能为空');
                                return false;
                        }
						
                        //检测
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmail'), {email: email}, function(data) {
                                if (data.status == "fail") {
                                        //显示错误信息 
										alert(data.message);
                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                } else {
                                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmailCode'), {code: code, email: email}, function(data) {
                                                if (data.status == "fail") {
														alert(data.message);
                                                        //$('.msg-container').css('display', '').find('p').html(data.message);
                                                } else {
														$.getJSON(gYiiCreateUrl('ajax', 'CheckVerifyMobileCode'), {code: code_tel}, function(data) {
																if (data.status == "fail") {
																		alert(data.message);
																		//$('.msg-container').css('display', '').find('p').html(data.message);
																} else {
																		$.getJSON(gYiiCreateUrl('ajax', 'ResetEmail'), {email: email}, function(data) {
																				//提示修改成功 
																				alert(data.message);
																				//$('.msg-container').css('display', '').find('p').html(data.message);
																				if (data.status == "success") {
																						setTimeout("window.location.href=gYiiCreateUrl('account', 'index')", 2000);
																				}
																		});
																}
														});
                                                }
                                        });
                                }
                        });
                        return false;
                }
        </script>
{/literal}