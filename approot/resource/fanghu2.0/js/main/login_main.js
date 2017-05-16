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
		function GetRequest() {   
		   var url = location.search; //获取url中"?"符后的字串   
		   var theRequest = new Object();   
		   if (url.indexOf("?") != -1) {   
		      var str = url.substr(1);   
		      strs = str.split("&");   
		      for(var i = 0; i < strs.length; i ++) {   
		         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);   
		      }   
		   }   
		   return theRequest;   
		}
		var mobilUri = GetRequest();
		if(mobilUri.mobile != ''){
			$('#phone').val(mobilUri.mobile);
		}
		$('.btn-link .btn').on('click',function(){
			//前端校验
			var phone = $('#phone'),
				password = $('#password');

			if(validate._phone(phone)&&validate._password(password,'请输入密码')){
				//后台上传
					$.ajax({
						url: $('#postUri').val(),
						type: 'post',
						dataType: 'json',
						data: {
							username: $('#phone').val(),
							password: $('#password').val(),
                            return_url: $('#return_url').val()
						},
						success: function (res) {
							if(res.code == 0){
								layer.msg('恭喜您，登录成功！');
                                var return_url = res.data.return_url || $('#return_url').val();
                                //console.log(return_url);
								setTimeout('window.location.href = "'+return_url+'"', 1000);
							}else if(res.code == 1){
								layer.msg(res.msg);
							}
						}
					});
			}
		})
	})
})
