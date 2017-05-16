{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                function r_submit() {

                        var newName = $("#member_fullname").val();
                        var CnameRule = /^[\u4E00-\u9FA5]+$/;
                        var EnameRule = /^[A-Za-z0-9]+$/;
                        if (newName.length < 2 || newName.length > 16)
                        {
                                alert('请输入大于2位小于16的字母、数字、文字的姓名');
                                // $('.msg-container').css('display', '').find('p').html('请输入大于2位小于16的字母、数字、文字的姓名');
                                return false;
                        } else if (!CnameRule.test(newName) && !EnameRule.test(newName)) {
                                alert('请您输入正确的姓名');
                                // $('.msg-container').css('display', '').find('p').html('请您输入正确的姓名');
                                return false;
                        }


                        var member_id_number = $("#member_id_number").val();
                        var IdNumberRule = /^[0-9]{18}$/;
                        if (!IdNumberRule.test(member_id_number)) {
                                alert('请您输入正确的身份证号');
                                // $('.msg-container').css('display', '').find('p').html('请您输入正确的身份证号');
                                return false;
                        }

                        frm.submit();

                }
        </script>
{/literal}