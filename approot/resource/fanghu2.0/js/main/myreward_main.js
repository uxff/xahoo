/************************************************
 * @authors:Hu gang
 * @description:
 * @date:2016-08-17
 * @version:
************************************************/
define(function(require,exports,module){
	//JQuery模块
	require('../lib/jquery/jquery-1.10.1.min.js');

	$(function(){
		var myreward = {
			init:function(){
				var _this = this;
				$('.min-cashBtn').on('click',function(){
					console.log(1);
					var txt = $('.min-cash').val();
					_this.message(txt);
				})
			},
			message:function(txt){
				$('.cash-pop').text(txt);
				var DivWidth = $('.cash-pop').width();
				$('.cash-pop').css("margin-left","-"+DivWidth/2+"px").show();

				setTimeout(function(){$('.cash-pop').hide();},2000);
			},
		}
		myreward.init();
	})
})