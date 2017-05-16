{literal}
        <script type="text/javascript" >
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
				
                function r_submit() {
                        //邮箱
                        var email = $('#email').val().trim();
                        var emailRule = /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i;

                        if (email.length == 0) {
                                alert('请输入邮箱');
                                return false;
                        } else if (!emailRule.test(email)) {
                                alert('请输入正确的邮箱格式');
                                return false;
                        }
						
                        //检测
						
														$.getJSON(gYiiCreateUrl('ajax', 'SendEmailURL'), {email: email}, function(data) {
																if (data.status == "fail") {
																		alert(data.message);
																		//$('.msg-container').css('display', '').find('p').html(data.message);
																} else {
																		alert(data.message);
 																		setTimeout("window.location.href=gYiiCreateUrl('account', 'index')", 2000);
																}
														});
						/*
                        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmail'), {email: email}, function(data) {
                                if (data.status == "fail") {
                                        //显示错误信息 
										alert(data.message);
                                } else {
														$.getJSON(gYiiCreateUrl('ajax', 'SendEmailURL'), {email: email}, function(data) {
																if (data.status == "fail") {
																		alert(data.message);
																		//$('.msg-container').css('display', '').find('p').html(data.message);
																} else {
																		alert(data.message);
 																		setTimeout("window.location.href=gYiiCreateUrl('account', 'index')", 2000);
																}
														});
                                }
                        });
						*/
                        return false;
                }
        </script>
{/literal}