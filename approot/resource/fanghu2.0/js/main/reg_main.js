define(function(require){
	//表单验证模块
	var Validate = require('../module/form_validate.js');
	var validate = new Validate('.reg-box');
	
	//验证码模块
	var Yzm = require('../module/yzm.js');
	var yzm = new Yzm('#yzm_txt');
	
	/*非模块化JS代码*/
	$(function(){	    
	    //邀请码显示
	    $('.reg-box>a').on('click',function(){
	    	var node = $('.reg-box').children('ul');
	    	if(node.children('li').filter(':last').is(':hidden')){
				node.children('li').filter(':last').show();
				$(this).hide().children('.iconfont').removeClass('icon-down').addClass('icon-up');
			}else{
				node.children('li').filter(':last').hide();
				$(this).children('.iconfont').removeClass('icon-up').addClass('icon-down');
			}
	    })
	    //邀请码存在 按钮隐藏
	    if($('#invite-code input').val()!=''){
	    	$('#invite-code-toggler').hide();
	    }
	    $('.reg_xy a').on('click',function(){
	    	$('.xy_cont').animate({'left':'0'},500);
	    });
	    $('.xy_cont header a').on('click',function(){
	    	$('.xy_cont').animate({'left':'100%'},500);
	    });
	    //点击获取验证码按钮
	    $('.btn-yzm').on('click',function(){
	    	//验证是否输入手机号
			if(!yzm.render()){return false;}
			//发送验证码
			var phone = $('#username').val();
			$.ajax({
				url: '?r=ajaxuc/CheckMobile&mobile='+phone,
				type: 'post',
				dataType: 'json',
				success: function (res) {
					if(res.code == 1){
						layer.msg(res.msg);
						return false;
					}else{
                        var token = $('#token').val();
                        var valicode = $('#valicode').val();
          				$.ajax({
							url: '?r=ajaxuc/SendCode',
							type: 'post',
                            data: {token: token, mobile:phone, valicode:valicode},
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
				url: '?r=user/registerform',
				type: 'post',
				dataType: 'json',
				data: $("#form").serialize(),
				success: function (res) {
					if(res.code == 0){
						layer.msg(res.msg);
                        var return_url = res.data.return_url || $('#return_url').val();
                        setTimeout('window.location.href = "'+return_url+'"', 1000);
						
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
	
})
