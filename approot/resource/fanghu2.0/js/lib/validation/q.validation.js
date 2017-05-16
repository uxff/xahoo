/**
 *@des 校验一些常数据，如手机，身份证，等
 * author : sichaoyun
 */
  var xqsj = xqsj || {};
;( function() {"use strict";
       var validation = {
            /**
             * @param {Object} options
             * @param options.content 需要校验的内容
             * @param options.val 校验后的内容
             * @param options.msg 定义校验错误信息
             * @param options.is_format 是否格式化为130 1122 3344
             * @param return {code:,msg,val}
             */
            mobile : function(val) {
                //为0时表示检查通过
                var code = 0, msg = '';
                //如果参数不是对象则默认为需要校验的内容
  
                msg = {
                    '1' : '请输入11位手机号码',
                    '2' : '请输入正确的手机号码'
                };

               // val = Q.string.dbc_to_sbc(options.content).replace(/\D/g, '');
                var reg = /^1[^01269]\d{9}$/gi;
                if (val) {
                    if (!reg.test(val)) {
                        code = 2;
                    }
                } else {
                    code = 1;
                }

                return {
                    code : code,
                    msg : msg[code + ''] || '',
                    val : $.trim(val)
                };
            }, //支付密码
            //如果通过检查，会多返回一个密码等级
            paypass : function(val) {
                //为0时表示检查通过

                var code = 0, msg;

                msg = {
                    '1' : '请输入6-18位密码，至少包含字母和数字',
                    '2' : '密码至少要包含一个字母',
                    '3' : '密码至少要包含一个数字',
                    '4' : '密码长度需在6-18位之间',
                    '5' : '密码不能为中文等非英文字符'
                };


                var t_val = val.replace(/[^\x00-\xff]/gi, '');
                var zb_val = val.replace(/[a-z]/gi, '');
                var sz_val = val.replace(/[0-9]/g, '');
                var ts_val = val.replace(/^a-z0-9/gi, '');
                var ul_val = val.replace(/[A-Z]/g, '');
                var level = 1, lvl = '';
                var len = val.length;
                if (val == t_val) {
                    if (val) {
                        //检查有没有字母
                        if (zb_val == val) {
                            code = 2;
                        }
                        //检查有没有数字
                        if (sz_val == val) {
                            code = 3;
                        }
                        //检查长度
                        if (len < 6 || len > 18) {
                            code = 4;
                        }
                        if (len > 8) {
                            level++;
                        }
                        //检查有没有特殊字符
                        if (ts_val != val) {
                            level += 2;
                        }
                        //检查有没有大写
                        if (ul_val != val) {
                            level += 2;
                        }
                    } else {
                        //为空
                        code = 1;
                    }
                } else {
                    code = 5;
                }

                return {
                    code : code,
                    msg : msg[code + ''] || '',
                    val : val
                    
                };
            },
            //真实姓名,必须为中文
            realname : function(val) {
                //为0时表示检查通过
                var code = 0, msg = '';
                 msg = {
                    '1' : '请输入真实姓名',
                    '2' : '请输入正确的真实姓名'
                };
                var reg = /^[\u4e00-\u9fa5]{2,}(|[\.。·][\u4e00-\u9fa5]+)$/gi;
                if (val) {
                    if (!reg.test(val)) {
                        code = 2;
                    }
                } else {
                    code = 1;
                }
                return {
                    code : code,
                    msg : msg[code + ''] || '',
                    val : val
                };
            },
            //email地址
            email : function(val) {
                //为0时表示检查通过
                var code = 0, msg = '';
                 msg = {
                    '1' : '请输入email地址',
                    '2' : '请输入正确的email地址'
                };
                var reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/gi;
                if (val) {
                    if (!reg.test(val)) {
                        code = 2;
                    }
                } else {
                    code = 1;
                }
                return {
                    code : code,
                    msg : msg[code + ''] || '',
                    val : val
                };
            },
            //银行卡
            card : function(val) {
                //为0时表示检查通过
                var code = 0, msg = '';
                 msg = {
                    '1' : '请输入银行卡号',
                    '2' : '请输入正确的银行卡号'
                };
                var reg = /^(\d{16}|\d{19})$/;
                if (val) {
                    if (!reg.test(val)) {
                        code = 2;
                    }
                } else {
                    code = 1;
                }
                return {
                    code : code,
                    msg : msg[code + ''] || '',
                    val : val
                };
            },            
            //身份证
            ident : function(val) {
                //为0时表示检查通过
                var code = 0, msg = '';
                //如果参数不是对象则默认为需要校验的内容

                msg = {
                    '1' : '请输入18位身份证号码',
                    '2' : '请输入正确的身份证号码',
                    '3' : '请输入真实身份证号',
                    '4' : '未满18周岁'
                };

                var chk_ident_last = function(code) {
                    var sum = 0;
                    var w = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                    var chk = [1, 0, 'x', 9, 8, 7, 6, 5, 4, 3, 2];
                    for (var i = 0; i < 17; i++) {
                        sum += code[i] * w[i];
                    }
                    return chk[sum % 11] == code[17];
                };


                var reg = /^\d{17}[\dx]$/gi;
                if (val) {
                    if (reg.test(val)) {
                        //是否符合身份证规则
                        if (!chk_ident_last(val)) {
                            code = 3;
                        }
                    } else {
                        code = 2;
                    }
                } else {
                    code = 1;
                }

                return {
                    code : code,
                    msg : msg[code + ''] || '',
                    val : $.trim(val)
                };
            }
        };
        xqsj.validation = validation;
    }());
