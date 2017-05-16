{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                function r_submit() {
//                        var oldPwd = $("#oldPwd").val();
                        var newPwd = $("#newPwd").val();
                        var confirmPwd = $("#confirmPwd").val();
//                        if (oldPwd.length == 0) {
//                                $('.msg-container').css('display', '').find('p').html('请输入原密码');
//                                return false;
//                        }
                        if (newPwd.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入新密码');
                                return false;
                        } else if (newPwd.length < 6 || newPwd.length > 18) {
                                $('.msg-container').css('display', '').find('p').html('您输入的密码保持在6-18位');
                                return false;
                        }
//                        if (oldPwd === newPwd) {
//                                $('.msg-container').css('display', '').find('p').html('新密码不能与旧密码一致');
//                                return false;
//                        }
                        if (confirmPwd.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请再次输入新密码');
                                return false;
                        }
                        if (newPwd !== confirmPwd) {
                                $('.msg-container').css('display', '').find('p').html('两次密码输入不一致');
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}