
    <script>
		var house_id = {$house_id};
		{literal}		
        $(function() {
            // showmsg('网络无响应，无法生成订单，请检查您的网络连接，并重新提交！');
            inputVal($('#realName'));
            inputVal($('#ID'));
            inputVal($('#phoneNo'));
            buyAmount(1);

            $(".x-hitems").hide();
            $(".x-ysd").hide();
            if ( $('.mt').length > 0){
             $('.mt').get(0).checked = true;
            }
            $(".x-ialak").on('click', function() {
                $(".x-hitems").hide();
                $(".x-abot").show();
                $(".x-ysd").show();
            });
            $(".row_abot").on('click', function() {
            	$('#address').val('');
                $(".site").attr("disabled", "disabled");
                $(".x-hitems").show();
                $(".x-ysd").hide();
                $(".x-ysd").attr('alt', 'hidden');
                for (var i = 0; i < $('.mt').length; i++) {
                    $('.mt').get(i).checked = false;
                }
            })
            $('.x-abot li').on('click', function() {
                $('.mt').get(0).checked = false;
                $(this).find('.mt').get(0).checked = true;
                $(".x-hitems").hide();
                $(".x-ysd").show();
                $(".x-ysd").attr('alt','');
            });

            $('.mt').on('click', function() {
               $('#address').val($(this).prev().html());
            });

            // form submit
            $('#placeOrderSmtBtn').on('click', function() {

                //check form
                //TODO 封装为checkForm公用方法
                var customerName = $('#realName').val().trim();
                var customerID = $('#ID').val().trim();
                var customerPhone = $('#phoneNo').val().trim();
                var address = $("#address").val();
                var provinceID = $('#provinceID').val();
                var isAddress = $(".x-ysd").attr('alt');
                var cityID = $('#cityID').val();
                var countryID = $("#countryID").val();
                var addressinfo = $("#particular").val();
                var telRule = /^((13[0-9])|(14[0-9])|(15[0-9])|(17[0-9])|(18[0-9]))\d{8}$/;
                var IDRule = validateIdCard(customerID);
                if (customerName == '') {
                    alert('请填写您的真实姓名');
                    return false;
                }

                if (customerID == '') {
                    alert('请填写您的身份证号');
                    return false;
                }
                else if (!IDRule[0]) {
                    alert(IDRule[1]);
                    return false;
                }

                if (customerPhone == '') {
                    alert('请填写您的真实手机号');
                    return false;
                }
                else if (!telRule.test(customerPhone)) {
                    alert('手机号格式不正确');
                    return false;
                }

                if ($("#select").is(':checked') == false) {
                    alert('必须确认且同意协议');
                    return false;
                }

                if (address == '' && isAddress == '') {
                    alert('请添加邮寄地址');
                    return false;
                }

                if (isAddress != '') {
                    if (provinceID == '0' || cityID == '0') {
                        alert('省市区不能为空');
                        return false;
                    }

                    if (addressinfo == '') {
                        alert('详情地址不能为为空');
                        return false;
                    }
                }

                // disable submit button
                $('#placeOrderSmtBtn').attr({'value': '正在处理中...', 'class': 'processing', 'disabled': true});

                $('#placeOrderForm').submit();

                //loading mask
                return false;
            });

            $("#select").on('click', function() {
                if (this.checked == false) {
                    alert('必须确认且同意协议');
                }
            });

            $("#refresh").on('click', function() {

                $.ajax({
                    type: "POST",
                    url: gYiiCreateUrl('ajax', 'houseDetail'),
                    data: "house_id=" + house_id,
                    success: function(msg) {
                        var dataObj = JSON.parse(msg);
                        $("#ratio").html(dataObj.ratio + '%');
                        $("#surplus").html(dataObj.surplus_item_total);
                        $("#Num").attr('data-max', dataObj.surplus_item_total)
                    }
                });
            });
        });

        //点击X 清空输入内容
        function inputVal(obj) {
            //点击X 清空输入内容
            $(obj).next('i').tap(function() {
                $(obj).val('');
                $(this).css('display', 'none');
            })

            if (obj.val().length > 0) {
                obj.next('i').css('display', 'table-cell');
            } else {
                obj.next('i').css('display', 'none');
            }
            obj.on('input propertychange', function() {
                //console.log($(this).val().length);
                if ($(this).val().length != 0) {
                    $(this).next('i').css('display', 'table-cell');
                } else {
                    $(this).next('i').css('display', 'none');
                }
            })
        }

        //计算认购金额
        function buyAmount(num) {
            var per = $('#Amount'),
                    perTxt = per.attr('data-mon'), all;
            all = Number(num) * Number(perTxt),
                    $('#AmountInd').val(all);
            per.text(Number(all).formatMoney(2, "￥", ","));
        }



        function addPlus(cta, plus, minus) {
            var cta = $(cta), num,
                    max = $(cta).attr('data-max');
            num = parseInt(cta.val());
            if (num < max) {
                num = num + 1;
                cta.val(num);
                buyAmount(num);
                $(minus).removeAttr("disabled");
            } else {
                $(plus).attr("disabled", "disabled");
                alert('最大不能大于' + max);
            }
        }

        function cutMinus(cta, plus, minus) {
            var cta = $(cta), num;
            num = parseInt(cta.val());
            if (num > 1) {
                num = num - 1;
                cta.val(num);
                buyAmount(num);
                $(plus).removeAttr("disabled");
            } else {
                $(minus).attr("disabled", "disabled");
                alert('最小不能小于1');
            }
        }

        function modVal(cta) {
            var cta = $(cta), num,
                    max = $(cta).attr('data-max'),
                    reg = new RegExp(/^[0-9]*[1-9][0-9]*$/);
            num = parseInt(cta.val());
            if (!reg.test(num)) {
                cta.val('1');
                alert("请输入数字！");
            } else if (num > max) {
                cta.val('1');
                alert('最大不能超过' + max);
            } else {
                buyAmount(num);
            }
        }
    </script>
    <script>
        //显示城市
        $("#provinceID").change(function() {
            $.ajax({
                type: 'POST',
                url: gYiiCreateUrl('ajax', 'listCity'),
                data: {'sys_region_index': $(this).val()},
                datatype: 'json',
                success: function(data) {
                    var data = eval(data);
                    var html = '<option value="0">请选择</option>';
                    $.each(data, function() {
                        html += "<option value='" + this.sys_region_index + "'>" + this.sys_region_name + "</option>";

                    })
                    $("#cityID").html(html);
                    $("#countryID").html('<option value="0">请选择</option>');
                }
            });
        });

        //显示县区
        $("#cityID").change(function() {
            $.ajax({
                type: 'POST',
                url: gYiiCreateUrl('ajax', 'listCounty'),
                data: {'sys_region_index': $(this).val()},
                datatype: 'json',
                success: function(data) {
                    var data = eval(data);
                    if (data != '') {
                        $("#countryID").show();
                        var html = '<option value="0">请选择</option>';
                        $.each(data, function() {
                            html += "<option value='" + this.sys_region_index + "'>" + this.sys_region_name + "</option>";

                        })
                        $("#countryID").html(html);
                    } else {
                        $("#countryID").hide();
                        $("#countryID").html('<option value="">请选择</option>');
                    }
                }
            });
        });
  {/literal}      
{if $error!=""}
alert('{$error}');
{/if}
</script>
