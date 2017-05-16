{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
				
				
                function r_submit() {
                        var newPwd = $("#newPwd").val();
                        var confirmPwd = $("#confirmPwd").val();
                        if (newPwd.length == 0) {
								alert('请输入新密码');
                                //$('.msg-container').css('display', '').find('p').html('请输入新密码');
                                return false;
                        } else if (newPwd.length < 6 || newPwd.length > 18) {
								alert('您输入的密码保持在6-18位');
                                //$('.msg-container').css('display', '').find('p').html('您输入的密码保持在6-18位');
                                return false;
                        }
                        if (confirmPwd.length == 0) {
								alert('请再次输入新密码');
                                //$('.msg-container').css('display', '').find('p').html('请再次输入新密码');
                                return false;
                        }
                        if (newPwd !== confirmPwd) {
								alert('两次密码输入不一致');
                                //$('.msg-container').css('display', '').find('p').html('两次密码输入不一致');
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}