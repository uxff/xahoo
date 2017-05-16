var zhff = {};
zhff.langs = {
    "errTpl": {
        "noText": "请输入{0}.",
        "isNumber": "请输入数字",
        "isChinese": "请输入汉字",
        "isEnglish": "请输入字母",
        "invalidName": "请输入汉字(至少2个)或者英文名字(至少4个)",
        "shortCharacter": "请至少输入 {0} 个字符.",
        "shortNumber": "请至少输入 {0} 个数字.",
        "moreCharacter": "请输入不超过 {0} 个字符.",
        "rightText": "请输入正确的{0}",
        "instit": "请输入{0}位字母或数字",
        "numAabc":'请输入字母或者数字',
        "numOrabc":'请输入包含数字、大小写字母及常用符号的字符',
        "character":'请输入{0}字符',
        "characters":'请输入{0}-{1}个字符',

        "rightnumber":'请输入{0}位数字',
        "numbers":'请输入{0}-{1}位数',

        "chineses":'请输入{0}-{1}个汉字',
        "letter":'请输入{0}-{1}个字母',
        "select":'请选择{0}',
        "account":'请输入数字、大小写字母及常用符号的字符',

    },
    "errTxt": {
        "housesq": "请输入户型面积，可保留两位小数.",
        "most": "{0}最多为{1}",
        "lest": "{0}最少为{1}",
        "big": "输入值最大为{0}",
        "small": "输入值最小为{0}",
        
    }
};

String.prototype.stringFormat = function() {
    var formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var regexp = new RegExp('\\{' + i + '\\}', 'gi');
        formatted = formatted.replace(regexp, arguments[i])
    };
    return formatted
};
$.fn.formCheck = function(items, params, type) {
    if (!params) params = {};
    params.rules = $.extend({
        'null': function(obj, checks) {
            return $.trim($(obj).val()).length > 0
        },
        'maxlength': function(obj, checks) {
            return $.trim($(obj).val()).length <= checks.maxlength
        },
        'minlength': function(obj, checks) {
            return $.trim($(obj).val()).length >= checks.minlength
        },
        'rightlength': function(obj, checks) {
            return $.trim($(obj).val()).length == checks.rightlength
        },
        'digitMinlength': function(obj, checks) {
            return $.trim($(obj).val().replace(/[^0-9]/g, '')).length >= checks.minlength
        },
        'digitMaxlength': function(obj, checks) {
            return $.trim($(obj).val().replace(/[^0-9]/g, '')).length <= checks.maxlength
        },
        'min': function(obj, checks) {

            return parseInt($.trim($(obj).val())) >= checks.min
        },
        'max': function(obj, checks) {
            return parseInt($(obj).val()) <= checks.max
        },
        'number': function(obj, checks) {

            return /^[0-9]+$/.test($.trim($(obj).val()))
        },
        'numbers': function(obj, checks) {
            return /^[0-9\-]+$/.test($.trim($(obj).val()))
        },

        'numberx': function(obj, checks) {
            return /^[0-9x]+$/i.test($.trim($(obj).val()))
        },
        'numAabc': function(obj, checks) {
            // /^((.*[0-9]+.*[a-z]+.*)|(.*[a-z]+.*[0-9]+.*))$/i
            return /([0-9]+.*[a-z\-\_\.]+)|([a-z\-\_\.]+.*[0-9]+)|([a-z]+.*[\-\_\.]+)|([\-\_\.]+.*[a-z]+)|([\-]+.*[\_\.]+)|([\_\.]+.*[\-]+)|([\_]+.*[\.]+)|([\.]+.*[\_]+)/i.test($.trim($(obj).val()))
        },
        'numOabc': function(obj, checks) {
            return /^[a-zA-Z0-9]+$/.test($.trim($(obj).val()))
        },
        'numAbcs': function(obj, checks) {
            return /^[a-zA-Z0-9-\_\.]+$/.test($.trim($(obj).val()))
        },
        'nums': function(obj, checks) {
            return /^[a-zA-Z0-9\.]+$/.test($.trim($(obj).val()))
        },

        'numd': function(obj, checks) {
            return /^[0-9\.]+$/.test($.trim($(obj).val()))
        },
        'select': function(obj, checks) {
            return $(obj).val() != 0
        },
        'checked': function(obj, checks) {
            return obj.checked
        },
        //   必须使用英文、数字或“-”、“_”、“.”符号
        
        'account': function(obj, checks) {
            return /^[a-z0-9-\_\.]+$/i.test($(obj).val().replace(/-|\//g, ''))
        },
        'email': function(obj, checks) {
            return /(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/.test($(obj).val().replace(/-|\//g, ''))
        },
        'passwordOrnull': function(obj, checks) {
           return /([0-9]+.*[a-z\-\_\.]+)|([a-z\-\_\.]+.*[0-9]+)|([a-z]+.*[\-\_\.]+)|([\-\_\.]+.*[a-z]+)|([\-]+.*[\_\.]+)|([\_\.]+.*[\-]+)|([\_]+.*[\.]+)|([\.]+.*[\_]+)/i.test($.trim($(obj).val()))
        },
        'chineses':function(obj, checks){
            return /^[\u4e00-\u9fa5]+$/.test($.trim($(obj).val())) && $.trim($(obj).val()).replace(/[\s]+/g, ' ').length <= checks.maxlength
        },
        'chinese':function(obj, checks){
            return /^[\u4e00-\u9fa5]+$/.test($.trim($(obj).val()))
        },

        'english':function(obj, checks){
            return /^[a-z]+$/i.test($.trim($(obj).val()))
        },
        'cellphone': function(obj, checks) {
            return /(^((13[0-9])|(15[0-9])|(170)|(18[0-9])|)\d{8}$)/.test($(obj).val())
        },
        'telephone': function(obj, checks) {
            return /(^(0[1-9]\d{1,2}\-?)?[1-9]\d{6,7}$)/.test($(obj).val())
        },
        'telephone2': function(obj, checks) {
            return /(^[1-9]\d{6,7}$)/.test($(obj).val())
        },
        'telephone3': function(obj, checks) {
            return /(^(0[1-9]\d{1,2}\-?)[1-9]\d{6,7}$)/.test($(obj).val())
        },
        'phone': function(obj, checks) {
            return /(^((13[0-9])|(15[0-9])|(170)|(18[0-9])|)\d{8}$)|(^(0[1-9]\d{1,2}\-?)?[1-9]\d{6,7}$)/.test($(obj).val())
        },
        'custName':function(obj, checks){
            return /(^[a-zA-Z]{3,30}$)|^[\u4e00-\u9fa5]{2,10}$/.test($.trim($(obj).val()))
        },
        'double':function(obj, checks){
            return /^[0-9]+(\.\d{1,2})?$/.test($.trim($(obj).val()))

        },
        'doubles':function(obj, checks){
            return /^[0-9]+(\.\d{1,})?$/.test($.trim($(obj).val()))

        },
        'cardId':function(obj, checks){
            return /(^[1-9]\d{14}$)|(^[1-9]\d{17}$)|(^[1-9]\d{16}(\d|X|x)$)/.test($.trim($(obj).val()))
        },
        'user': function(obj, checks) {
            return /^(?!\d)[a-zA-Z0-9\u4e00-\u9fa5_]{5,18}$/.test($.trim($(obj).val()))
        },
    },
    params.rules);
    var result = true,
    focused = false;
    function checkItem(item, checks) {
        for (j in checks) {
           
            if (params.rules[checks[j].type]) if (params.rules[checks[j].type](item, checks[j])) continue;
            if (!focused && !checks[j].noFocus) {
                if ($(item).offset().top < $(window).scrollTop()) {
                    $('html, body').animate({
                        scrollTop: $(item).offset().top
                    },
                    'fast')
                }
                focused = true
            };

            if (checks[j].showError) {
                checks[j].showError();
                result = false;
                break
            } else if (params.showErrType1) {
                params.showErrType1($(item), checks[j].errMsg);
                result = false;
                break
            } else if (params.errinfoFinder) {
                params.errinfoFinder($(item)).next('.errMsgP').remove()
                params.errinfoFinder($(item)).after('<p class="errMsgP">'+checks[j].errMsg+'</p>');
                if(checks[j].errMsg.length>0)
                {
                    params.errinfoFinder($(item)).addClass('red')
                }
                $(item).focus(function() {
                    params.errinfoFinder($(item)).next().remove();
                    params.errinfoFinder($(item)).removeClass('red')
                });
                if ($(item).attr('type') != null && $(item).attr('type').toLowerCase() == 'checkbox') {
                    $(item).click(function() {
                        $(item).focus()
                    })
                };
                result = false;
                break
            } else if (params.errinfoFinder2) {
                params.errinfoFinder2($(item)).parents('td').next().children('.errMsgP').remove();
                params.errinfoFinder2($(item)).parents('td').next().append('<p class="errMsgP">'+checks[j].errMsg+'</p>');
                if(checks[j].errMsg.length>0)
                {
                    params.errinfoFinder2($(item)).addClass('red');
                }
                $(item).focus(function() {
                    params.errinfoFinder2($(item)).parents('td').next().children('.errMsgP').remove();
                    params.errinfoFinder2($(item)).removeClass('red');
                });
                if ($(item).attr('type') != null && $(item).attr('type').toLowerCase() == 'checkbox') {
                    $(item).click(function() {
                        $(item).focus()
                    })
                };
                result = false;
                break
            } else if (checks[j].errMsg) {
                alert(checks[j].errMsg);
                return false
            }
        };
        return true
    };
    function checkElm(elm) {
        for (i = 0; i < elm.length; i++) {

            if ($(elm[i]).attr('id') && $(elm[i]).attr('id').length == 0 || $(elm[i]).attr('disabled')) continue;
            var checks = items[$(elm[i]).attr('id')];
            if (!checks) continue;//没有规则 继续下一个表单元素
            if (!checkItem(elm[i], checks)) return false
        }
    }
    if (type) {
        for (n = 0; n < type.length; n++) {
            checkElm(this.find(type[n]))
        }
    } else {
        checkElm(this[0])
    }
    if(result){
         $("#"+params.submitBtn).attr("disabled",true);

    }

    return result;
};