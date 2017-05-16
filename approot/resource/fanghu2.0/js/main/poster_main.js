/************************************************
 * @authors:Hu gang
 * @description:
 * @date:2016-07-13
 * @version:
************************************************/

define(function(require){
	// jquery模块
	require("../lib/jquery/jquery-1.10.1.min.js");
	// 二维码模块
	require("../lib/jquery-qrcode/jquery.qrcode.min.js");

	$(function(){
		var poster = {
			init: function(){
				this.qrcode();
			},
			qrcode: function(){
				$("#code").qrcode({
				    text: 'http://www.baidu.com'
				}); 
			}
		}
		poster.init();
	})
})