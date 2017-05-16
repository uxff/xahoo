{literal}
        <script>
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });

                //提交注册时 检测
                function r_submit() {
                        //邮箱
                        var email = $('#email').val().trim();

                        var emailRule = /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i;
                        //判断邮箱是否为空
                        if (email.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入邮箱');
                                return false;
                        } else if (!emailRule.test(email)) {
                                $('.msg-container').css('display', '').find('p').html('请输入正确的邮箱格式');
                                return false;
                        }

                        //检测
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckOldEmail'), {email: email}, function(data) {
                                if (data.status == "fail") {
                                        //显示错误信息 
                                        $('.msg-container').css('display', '').find('p').html(data.message);
                                        return false;
                                } else {
                                        frm.submit();
                                }
                        });
                }
        </script>
{/literal}