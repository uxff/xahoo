define(function(require){
	//JQuery模块
	require('../lib/jquery/jquery-1.10.1.min.js');
	//layer模块
	var css = require('../lib/layer/skin/layer.css','css|url');
	var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
	$($('head')[0]).find('title').after(linkTag);
	require('../lib/layer/layer.js');
	
	//非模块化JS
	$(function(){
		//点击分享
		$('.btn-link > button.btn').on('click',function(){
			if($('.detaile-fxb').length){
				$('.detaile-fxb').show();
			}else{
				var $imgbox = $('<div class="detaile-fxbg"><img src="' + paths + '/images/article/fx_bg.png" /></div>');
				$('.task-list').after($imgbox);
			}
			$('.detaile-fxbg img').on('click',function(){
				$('.detaile-fxbg').hide();
			})
		})
		
	})
})
