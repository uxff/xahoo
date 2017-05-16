{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });

                function r_submit() {
                        var answer = $("#answer").val().trim();
                        if (answer.length == 0) {
								alert('密保答案不能为空');
                                //$('.msg-container').css('display', '').find('p').html('密保答案不能为空');
                                return false;
                        } else if (answer.length > 15) {
								alert('答案长度不能超过15个汉字');
                                //$('.msg-container').css('display', '').find('p').html('答案长度不能超过15个汉字');
                                return false;
                        }
                        frm.submit();

                }
        </script>
{/literal}