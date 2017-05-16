<script>
    $('#old_ques').on({
        'submit'      :       function(){

            var oldAnswer = $('#old_answer').val().trim();
            if(oldAnswer.length > 15) {
                errorNotice('答案长度不能超过15个汉字');
                return false;
            }

            if('' == oldAnswer) {

                errorNotice('密保答案不能为空')
                return false;
            }
            if('' != oldAnswer){
                //如果答案不为空则对密保答案进行验证
                $.ajax({
                    data    :   'old_answer='+oldAnswer,
                    type    :   'post',
                    url     :   'ucenter.php?r=ajax/checkoldanswer',
                    success :   function(data){
                        var dataObj = JSON.parse(data);
                        if(dataObj.errorCode == '00') {
                            errorNotice('密保问题不正确');
                            return false;
                        } else {
                            window.location='ucenter.php?r=account/SetNewQuestion';
                            return false;
                        }

                    }
                });
            }
            return false;
        }
    });
</script>
<script>
    var errorNotice = function(errorInfo) {
        var errorDom = '';
        errorDom += '<div class="h-alert h-alert-warn">';
        errorDom += '<button type="button" class="h-close" onclick="delErrorInfo()">&times;</button>';
        errorDom += '<strong>' + errorInfo + '</strong>';
        errorDom += '</div>';
        $('.h-close').parent().remove();    //移除历史报错信息
        $('#old_ques').parent().prepend(errorDom);
    }
</script>
<script>
    //删除报错信息
    var delErrorInfo = function() {
        $('.h-close').parent().css('display', 'none');
    }
</script>