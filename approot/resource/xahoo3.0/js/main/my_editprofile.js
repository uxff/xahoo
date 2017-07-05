define(function(require){
	
	//首页轮播
	var css =  require('../lib/swiper/swiper-3.3.0.min.css','css|url');
	
	var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
	$($('head')[0]).find('title').after(linkTag);
	
	var Swiper = require('../lib/swiper/swiper-3.3.0.jquery.min.js');
	
	$(document).ready(function () {
        // 页面自己的处理
        var urlUploadAvatar = $('#frmUploadAvatar').action;
        console.log(urlUploadAvatar);
	});


})
