define(function(require){
	
	//表单验证模块
	var Validate = require('../module/form_validate.js');
	var validate = new Validate('.form-box');
	
	//验证码模块
	var Yzm = require('../module/yzm.js');
	var yzm = new Yzm('#yzm_txt');
	
	//点击获取验证码按钮
    $('.btn-yzm').on('click',function(){
    	//验证是否输入手机号
		if(!yzm.render()){return false;}
		//发送验证码
		var phone = $('#username').val();
		$.ajax({
			url: '?r=ajaxuc/CheckOldMobile&mobile='+phone,
			type: 'post',
			dataType: 'json',
			success: function (res) {
                // 手机号注册过 才能找回密码
				if(res.code == 0){
					layer.msg(res.msg);
					return false;
				}else{
                    var token = $('#token').val();
                    var valicode = $('#valicode').val();
      				$.ajax({
						url: '?r=ajaxuc/SendCode',
						type: 'post',
                        data: {token:token, mobile:phone, valicode:valicode},
						dataType: 'json',
						success: function (res) {
							if(res.code == 1){
								layer.msg(res.msg);
								return false;
							}else{
		          				layer.msg(res.msg);
		          				yzm._fsYzm();
							}
						},
						error:function(err)
						{
							layer.msg('出现错误请重试');
						}
					});
				}
			},
			error:function(err)
			{
				layer.msg('出现错误请重试');
			}
		});
		
	});
	//点击注册
	$('.btn-link > button.btn').on('click',function(){
		//前端校验
		if(!validate.render()){return false;}

		//后台校验
		$.ajax({
			url: '?r=user/mobilePwd',
			type: 'post',
			dataType: 'json',
			data: $("#form").serialize(),
			success: function (res) {
				if(res.code == 0){
					layer.msg(res.msg);
					window.location.href = $('#return_url').val()+"&mobile="+$("#username").val();
				}else{
      				layer.msg(res.msg);
      				return false;
				}
			},
			error: function (err) {
				layer.msg('出现错误，请重试');
			}
		});
	})
    $('.reloadCode').on('click', function (){
        var time = Math.random();

        var src = 'index.php?r=ajaxuc/ValidationCode&width=80&height=30&cache='+time;

        $('#reloadValicode').attr('src',src);
    });
})
