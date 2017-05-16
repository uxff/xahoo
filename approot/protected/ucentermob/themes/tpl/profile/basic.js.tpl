{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
				
                function r_submit() {
						/*
                        var newName = $("#member_fullname").val();
                        var CnameRule = /^[\u4E00-\u9FA5]+$/;
                        var EnameRule = /^[A-Za-z0-9]+$/;
                        if (newName.length < 2 || newName.length > 16)
                        {
                                $('.msg-container').css('display', '').find('p').html('请输入大于2位小于16的字母、数字、文字的姓名');
                                return false;
                        } else if (!CnameRule.test(newName) && !EnameRule.test(newName)) {
                                $('.msg-container').css('display', '').find('p').html('请您输入正确的姓名');
                                return false;
                        }
						*/
                        var member_qq = $("#member_qq").val().trim();
                        var QQRule = /^[1-9][0-9]{4,10}$/;
                        if (member_qq.length != 0) {
                                if (!QQRule.test(member_qq)) {
                                        $('.msg-container').css('display', '').find('p').html('请您输入正确的QQ');

                                        return false;
                                }
                        }

                        frm.submit();

                }
        </script>
{/literal}