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
                        var code = $('#code').val().trim();
                        if (code.length == 0) {
								alert('请输入验证码');
                                //$('.msg-container').css('display', '').find('p').html('请输入验证码');
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}