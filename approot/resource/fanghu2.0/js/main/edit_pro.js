define(function(require){
	//表单验证模块
	var Validate = require('../module/form_validate.js');
	var validate = new Validate('.form-box');
	
	var css = require('../lib/layer/skin/layer.css','css|url');
	var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
	$($('head')[0]).find('title').after(linkTag);
	require('../lib/layer/layer.js');
	/*非模块化JS*/
	$(function(){
		//uploader组件初始化按钮大小
		$('.webuploader-pick').next('div').css({'width':'3.83rem','height':'3.83rem'});
		$('.user_name input').on('focus',function(){
			if(!$(this).prop('readonly')){
				$('.user_name i').show();	
			}
		});
		$('.user_name input').on('blur',function(){
			if(!$(this).prop('readonly')){
				$('.user_name i').hide();	
			}
		});
		$('.btn-link .btn').on('click',function(){
			//前端校验
			var nickName = $("#nickname"),
				fullName = $("#fullname"),
				phone = $('#phone'),
				email = $('#email');

			if(validate._nicname(nickName)&&validate._userName(fullName)&&validate._email(email)){
				var imgUrl = $('#front').find('img').eq(0).prop('src');
				//后台上传
					$.ajax({
						url: $('#msgUpload').val(),
						type: 'post',
						dataType: 'json',
						data: {
							member_nickname: $('#nickname').val(),
							member_fullname: $('#fullname').val(),
							member_email: $('#email').val(),
							token: $('#token').val(),
							member_avatar: imgUrl
						},
						success: function (res) {
							if(res.code == 0){
								layer.msg('保存成功');
                                if (res.returnurl != undefined) {
                                    window.location.href = res.returnurl;
                                }
							}
						}
					});
			}
		})
	})
})
