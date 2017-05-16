{literal}
        <script>

                var dataObj = '';
                var isConfirm = $('#confirm').val();
                var selectedValues = new Array();
                $(document).ready(function() {
                        $.ajax({
                                type: 'post',
                                url: 'ucenter.php?r=Ajax/GetQuestions',
                                success: function(data) {
                                        dataObj = JSON.parse(data);
                                        var htmlstr = "<option value='0'>请选择密保问题</option>";
                                        $.each(dataObj.data, function(i, item) {
                                                htmlstr += "<option value='" + item.id + "' error='" + item.rule + "' answer_type='" + item.answer_type + "'>" + item.question + "</option>";
                                        });
                                        $('#sel_1, #sel_2, #sel_3').append(htmlstr);
                                }
                        });
                });

                //密保问题选择
                $('#sel_1, #sel_2, #sel_3').on({
                        'change': function() {
                                var selectedId = $(this).val();
                                var sort = $(this).attr('sort');
                                var rule = '';
                                var answerType = '';
                                var htmlstr = "<option value='0'>请选择密保问题</option>";
                                var selArr = [1, 2, 3];
                                var otherValue = new Array();

                                $.each(dataObj.data, function(i, item) {
                                        if (item.id == selectedId) {
                                                rule = item.rule;
                                                answerType = item.answer_type;
                                        } else {
                                                //判断其他下拉框中已经选的密保问题
                                                $.each(selArr, function(key, value) {
                                                        //判断是否为非当前下拉框
                                                        if (value != sort) {
                                                                //取得非当前下拉框中已选的值
                                                                otherValue[value] = $('#sel_' + value).val();
                                                        }
                                                })
                                        }
                                        htmlstr += "<option value='" + item.id + "' error='" + item.rule + "' answer_type='" + item.answer_type + "'>" + item.question + "</option>";

                                })
                                if (selectedId == 0) {
                                        $('#sel_' + item).html(htmlstr);
                                }
                                //提示问题答案格式规则
                                $('#answer_' + sort).attr('placeholder', rule);
                                //向答案输入框中加入答案类型
                                $('#answer_' + sort).attr('answer_type', answerType);


                                //将筛选过的密保问题添加到余下的下拉框中
                                $.each(selArr, function(i, item) {
                                        //取得每个下拉框中的所有选项
                                        var options = $('#sel_' + item + '> option');
                                        //遍历所有选项
                                        $.each(options, function(key, option) {

                                                if (item == sort) {    //当前下拉框选项
                                                        //当前下拉框已经选值不做判断
                                                        if (option.value != selectedId && in_array(option.value, selectedValues)) {
                                                                option.hidden = true;
                                                                option.disabled = true;
                                                        } else {
                                                                option.hidden = false;
                                                                option.disabled = false;

                                                        }
                                                        //将当前下拉框已经选的值加到已选数组中
                                                        selectedValues[sort] = selectedId;
                                                } else {    //非当前下拉框选项
                                                        //其他的下拉框判断
                                                        if (!option.selected && in_array(option.value, selectedValues)) {
                                                                option.hidden = true;
                                                                option.disabled = true;
                                                        } else {
                                                                option.hidden = false;
                                                                option.disabled = false;
                                                        }
                                                }
                                        })

                                });

                        }
                });
        </script>
        <script>
                $('#security_question').on({
                        'submit': function() {
                                //验证密保问题选择是否为空，密保问题是否符合规则
                                var selValue = '';
                                var ansType = '';
                                var ansContent = '';
                                for (var i = 1; i <= 3; i++) {
                                        selValue = $('#sel_' + i).val();
                                        ansContent = $('#answer_' + i).val();
                                        ansType = $('#answer_' + i).attr('answer_type');
                                        if (selValue == 0) {
                                                //提示请选择密保问题
                                                errorNotice('请选择密保问题');
                                                return false;
                                        }

                                        if (ansContent == '') {
                                                //提示请填写密保问题
                                                errorNotice('请填写密保问题')
                                                return false;
                                        }

                                        //验证密保问题是否符合规则
                                        var rel = questionsValidate(ansContent, ansType);
                                        if (!rel['state']) {
                                                errorNotice('密保问题答案不符规则')
                                                return false;
                                        }

                                }
                                //
                        }
                });
        </script>
        <script>
                function questionsValidate(content, type) {
                        var parten = '';
                        var errorInfo = '';
                        var response = new Array();
                        if (type == 1) {
                                //验证姓名规则
                                parten = /[\u4e00-\u9fa5]{2,8}/;
                                errorInfo = '请输入2到4个汉字';
                        } else if (type == 2) {
                                //验证日期规则
                                parten = /([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})(((0[13578]|1[02])(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)(0[1-9]|[12][0-9]|30))|(02(0[1-9]|[1][0-9]|2[0-8])))/;
                                errorInfo = '请输入正确的时间格式';
                        } else if (type == 3) {
                                //验证数字规则
                                parten = /[\d]{1,8}/;
                                errorInfo = '请输入2到8位数字';
                        }
                        //            alert(content);
                        var match = parten.test(content);
                        if (match) {
                                response['state'] = true;
                                response['error'] = errorInfo;
                        } else {
                                response['state'] = false;
                                response['error'] = errorInfo;
                        }

                        return response;
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
        <script>
                function in_array(search, array) {
                        for (var i in array) {
                                if (array[i] == search) {
                                        return true;
                                }
                        }
                        return false;
                }
        </script>
{/literal}