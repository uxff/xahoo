{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                function r_submit() {
                        var newName = $("#name").val();
                        var CnameRule = /^[\u4E00-\u9FA5]+$/;
                        var EnameRule = /^[A-Za-z0-9]+$/;
                        if (newName.length < 2 || newName.length > 16)
                        {
                                $('.msg-container').css('display', '').find('p').html('请输入大于2位小于16的字母、数字、文字');
                                return false;
                        } else if (!CnameRule.test(newName) && !EnameRule.test(newName)) {
                                $('.msg-container').css('display', '').find('p').html('请您输入正确的姓名');
                                return false;
                        }

                        var tel = $('#mobile').val().trim();
                        var telrule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
                        //判断手机号码是否为空
                        if (tel.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('请输入您的手机号');
                                return false;
                        } else if (!telrule.test(tel)) {
                                $('.msg-container').css('display', '').find('p').html('请输入正确的手机号格式');
                                return false;
                        }

                        var address = $("#address").val().trim();
                        if (address.length == 0) {
                                $('.msg-container').css('display', '').find('p').html('配送地址不能为空');
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}