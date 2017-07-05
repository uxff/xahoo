define(function(require){
	//懒加载模式
	require('../lib/jquery-lazyload/jquery-lazyload.js');
	
	//首页轮播
	var Swiper = require('../lib/swiper/swiper-3.3.0.jquery.min.js');
	
	$(document).ready(function () {
		
		var box = $('#big_swiper');
		var list = box.find('.swiper-slide').length;
		if(list!=1){
			//大轮播图
			var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: true,
			    speed:500, 
			    autoplay: $('#banner_pic_circle_sec').val(),
			    // 如果需要分页器
			    pagination: '.swiper-pagination'
			})    
		}else{
			box.find('.swiper-pagination').hide();
			var mySwiper = new Swiper ('.swiper-container', {
			    direction: 'horizontal',
			    loop: false
			})
		}
		
		var smBox = $('.sm-swiper-wrapper');
		var smList = smBox.find('.swiper-slide').length;
		if(smList!=1){
			//小广告轮播图
			var smSwiper = new Swiper ('.sm-swiper-container', {
			    direction: 'horizontal',
			    loop: true,
			    speed:500, 
			    autoplay: $('#art_pic_circle_sec').val(),
			    // 如果需要分页器
			    pagination: '.sm-pagination'
			})
		}else{
			box.find('.swiper-pagination').hide();
			var smSwiper = new Swiper ('.sm-swiper-container', {
			    direction: 'horizontal',
			    loop: false
			})
		}
		
		//懒加载
		$("img").lazyload({effect: "fadeIn",threshold : 300,skip_invisible : false,failurelimit : 4});
		
		var oBtn = $('<a href="javascript:;" class="goTop"></a>');
		$('body').append(oBtn);
		oBtn.bind('click',function(){
			goTop(600);
		});

		$(window).scroll(function(){
			if($(window).scrollTop()>=$(window).height()){
				oBtn.css({'zIndex':2,'opacity':1});
			}else{
				oBtn.css({'zIndex':-3,'opacity':0});
			}
		});
		function goTop(times){
			if(!times){
				$(window).scrollTop(0);
				return;
			}
 
			var sh=$(window).scrollTop();//移动总距离
			var inter=13.333;//ms,每次移动间隔时间
			var forCount=Math.ceil(times/inter);//移动次数
			var stepL=Math.ceil(sh/forCount);//移动步长
			var timeId=null;
			function ani(){
				timeId&&clearTimeout(timeId);
				timeId=null;

				if($(window).scrollTop()<=0||forCount<=0){//移动端判断次数好些，因为移动端的scroll事件触发不频繁，有可能检测不到有<=0的情况
					$(window).scrollTop(0);
					return;
				}
				forCount--;
				sh-=stepL;
				$(window).scrollTop(sh);
				timeId=setTimeout(function(){ani();},inter);
			}
			ani();
		}
	})
})
