define(function(require){
	//JQuery模块
	require('../lib/jquery/jquery-1.10.1.min.js');
	//layer模块
	var css = require('../lib/layer/skin/layer.css','css|url');
	var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
	$($('head')[0]).find('title').after(linkTag);
	require('../lib/layer/layer.js');
	
	/*非模块化JS*/
	$(function(){
		 var paypass = {
    	init : function(){
             	var is_mobile = 0;
             //验证手机
           $('#tel').on('blur',function(){
               var _this = $(this);
               var val = _this.val();
               var paypass = xqsj.validation.mobile(val);
               if(paypass.code == 0){
                  is_mobile = 1;
               }else {
                  layer.msg(paypass.msg);
                  is_mobile = 0;
               }
           });
 
          $('.lot-btn').on('click',function(){
              $('#tel').trigger('blur');
               if(is_mobile){
                   tel = $('#tel').val();
                   desc = $('#desc').val();
                   nickname = $('#nickname').val();
                   url = $(this).attr('url');
                   layer.load(2);
                    $.ajax({
              					 	url: url,
              					 	type: 'post',
              					 	dataType: 'json',
              					 	data: {tel: tel, nickname: nickname, desc: desc},
              					 	success: function (res) {
                            layer.closeAll('loading');
              					 		if(res.code == 0){
              					 			layer.msg(res.msg);
                              // 关闭微信窗口
                              setTimeout('wx.closeWindow()', 1000);
              		           }else{
              		           		layer.msg(res.msg);
              		           }
              					 	},
              					 	error: function (err) {
              					 		layer.msg('出现错误，请重试');
              					 	}
              		 });
               }
           });
         }
      }
     paypass.init();
	})
})


