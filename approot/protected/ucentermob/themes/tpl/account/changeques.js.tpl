{literal}
    <script>
        //出现点透等冒泡事件用click
        $('.h-close').on('click', function() {
            $(this).parent().parent().css('display', 'none');
        });

        //发送短信验证码后，提示重新操作时间
        var countdown = 60;
        //
        function showtime(val) {
            //60s不能点击发送验证码按钮
            if (countdown == 0) {
                val.removeAttribute("disabled");
                val.setAttribute("class", 'send');
                val.value = "重新获取";
                countdown = 60;
                return false;
            } else {
                val.setAttribute("disabled", true);
                val.setAttribute("class", 'send');
                val.value = "重新获取(" + countdown + ")";
                countdown--;
            }
            setTimeout(function() {
                showtime(val)
            }, 1000);
        }

        function settime(val) {
            //判断手机号格式是否正确，是否已经注册
            var tel = $('#username').val().trim();
            var telrule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
            //判断手机号码是否为空
            //console.log(tel.length);
            if (tel.length == 0) {
				alert('请输入您的手机号');
                //$('.msg-container').css('display', '').find('p').html('请输入您的手机号');
                return false;
            } else if (!telrule.test(tel)) {
				alert('请输入正确的手机号格式');
                //$('.msg-container').css('display', '').find('p').html('请输入正确的手机号格式');
                return false;
            }
//        $.getJSON(gYiiCreateUrl('ajax', 'CheckMobile'), {mobile: tel}, function(data) {

//            if (data.status == "fail") {
            //显示错误信息
//                $('.msg-container').css('display', '').find('p').html(data.message);
//                return false;
//            } else {
            val.removeAttribute("disabled");
            showtime(val);
            //发送验证码
            $.getJSON(gYiiCreateUrl('ajax', 'SendCode'), {mobile: tel}, function(data) {

                if (data.status == "fail") {
                    //显示错误信息
					alert(data.message);
                    //$('.msg-container').css('display', '').find('p').html(data.message);
                    return false;
                } else {
					alert(data.message);
                    //$('.msg-container').css('display', '').find('p').html(data.message);
                }
            });

//            }
//        });
        }


        function r_submit() {
            var sub = $('#set_new_ques').serialize();
            //答案
            var answer = $('#answer').val().trim();
//        var emailRule = /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i;
            var mobile = $('#username').val().trim();
            //验证码
            var code = $('#code').val().trim();

            if('' == answer) {
                errorNotice('密保答案不能为空');
                return false
            }

            if(answer.length > 15) {
                errorNotice('答案字符长度不能超过15个字符')
            }

            //判断验证码是否为空
            if (code.length == 0) {
                $('.msg-container').css('display', '').find('p').html('验证码不能为空');
                return false;
            }
            //检测
//        $.getJSON(gYiiCreateUrl('ajax', 'CheckEmail'), {email: email}, function(data) {
//            if (data.status == "fail") {
//                //显示错误信息
//                $('.msg-container').css('display', '').find('p').html(data.message);
//            } else {
            $.getJSON(gYiiCreateUrl('ajax', 'CheckVerifyCode'), {code: code, mobile: mobile}, function(data) {
                if (data.status == "fail") {
					alert(data.message);
                    //$('.msg-container').css('display', '').find('p').html(data.message);
                } else {
//                    $.getJSON(gYiiCreateUrl('ajax', 'SendEmail'), {email: email}, function(data) {
//                        //提示修改成功
//                        $('.msg-container').css('display', '').find('p').html(data.message);
//                        if (data.status == "success") {
//                            setTimeout("window.location.href=gYiiCreateUrl('account', 'index')", 3000);
//                        }
//                    });

                    $.ajax({
                        url     :      gYiiCreateUrl('account', 'SetQuestion'),
                        data    :      sub,
                        type    :      'post',
                        success :      function() {
                            window.location=gYiiCreateUrl('account', 'QuestionDone');
                        }
                    });
                }
            });

//
//            }
//        });
            return false;
        }
    </script>
    <script>
        var errorNotice = function(errorInfo) {
            var errorDom = '';
            errorDom += '<div class="h-alert h-alert-warn">';
            errorDom += '<button type="button" class="h-close" onclick="delErrorInfo()">&times;</button>';
            errorDom += '<strong>' + errorInfo + '</strong>';
            errorDom += '</div>';
            $('.h-close').parent().remove();    //移除历史报错信息
            $('#security_question').parent().prepend(errorDom);
        }
    </script>
    <script>
        //删除报错信息
        var delErrorInfo = function() {
            $('.h-close').parent().css('display', 'none');
        }
    </script>
{/literal}