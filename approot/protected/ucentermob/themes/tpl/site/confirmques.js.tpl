{literal}
        <script>
                //删除报错信息
                var delErrorInfo = function() {
                        $('.h-close').parent().css('display', 'none');
                }
        </script>
        <script>
                //验证提交表单不可为空
                $('#questions_confirm').on({
                        'submit': function() {
                                for (var i = 1; i <= 3; i++) {
                                        var answerValue = '';
                                        answerValue = $('#answer_' + i).val();
                                        if (answerValue == '') {
                                                errorNotice('密保问题' + '不能为空！');
                                                return false;
                                        }
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
                        $('#questions_confirm').parent().prepend(errorDom);
                }
        </script>
{/literal}