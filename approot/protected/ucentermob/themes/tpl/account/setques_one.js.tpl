<script>
//    alert(11);
    $('#security_question').on({
        'submit'    :      function(){

            var answer = $('#answer').val();
//            alert(answer);
            if('' == answer){
                errorNotice('密保答案不能为空')
                return false;
            }



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
        $('#security_question').parent().prepend(errorDom);
    }
</script>
<script>
    //删除报错信息
    var delErrorInfo = function() {
        $('.h-close').parent().css('display', 'none');
    }
</script>