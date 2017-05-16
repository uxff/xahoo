{literal}
        <script>
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                var errMsg = $('#errMsg').html();
                if(errMsg != null) {
                    alert(errMsg);
//                    console.log(errMsg);
                }
                function check() {
                        var username = $("#username").val();
                        var password = $("#password").val();
                        var flag = true;
                        if (username.length === 0) {
                                alert('请输入用户名');
//                                $('.msg-container').css('display', '').find('p').html('请输入用户名');
                                return false;
                        }

                        if (password.length === 0) {
                                alert('请输入密码');
//                                $('.msg-container').css('display', '').find('p').html('请输入密码');
                                return false;
                        }

//                        $.ajax({
//                                type: "POST",
//                                async: false, // 设置同步方式
//                                cache: false,
//                                url: gYiiCreateUrl('ajax', 'checkUserName'),
//                                data: "username=" + username,
//                                success: function(res) {
//                                        if (res == 'non-existent') {
//                                            alert('请输入密码');
////                                                $('.msg-container').css('display', '').find('p').html("该账号还未注册，请先注册");
//                                                flag = false;
//                                        }
//                                }
//                        });
//                        if (!flag) {
//                                return false;
//                        }
                }
        </script>
        <script>
                var childWindow;
                function toQzoneLogin()
                {
                        childWindow = window.open("oauth/index.php", "TencentLogin", "width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
                }
        </script>
{/literal}