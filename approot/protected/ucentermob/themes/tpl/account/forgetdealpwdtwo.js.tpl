{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
                function r_submit() {
					
                        var member_id_number = $("#member_id_number").val();
                        var IdNumberRule = /^[0-9]{18}$/;
                        if (!IdNumberRule.test(member_id_number)) {
								alert('请您输入正确的身份证号');
                                //$('.msg-container').css('display', '').find('p').html('请您输入正确的身份证号');
                                return false;
                        }

                        frm.submit();

                }
        </script>
{/literal}