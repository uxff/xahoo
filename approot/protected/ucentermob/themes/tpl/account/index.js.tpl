<script>
                //出现点透等冒泡事件用click
                $('.h-close').on('click', function() {
                        $(this).parent().parent().css('display', 'none');
                });
    $('#set_ques').on({
        'click'     :       function(){
            $.ajax({
                url     :       'ucenter.php?r=ajax/checkemailbinded',
                type    :       'post',
                success :       function(data){
                    var dataObj = JSON.parse(data);
                    if(dataObj.errorCode == '00'){
                        errorNotice(dataObj.errorInfo);
                        return false
                    }else{
                        window.location='ucenter.php?r=account/securityquestions';
                        return false;
                    }

                }
            });
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
        $('#container').css('display', 'block');
        $('#container').prepend(errorDom);
    }
</script>
<script>
    //删除报错信息
    var delErrorInfo = function() {
        $('.h-close').parent().css('display', 'none');
        $('#container').css('display', 'none');
    }
</script>