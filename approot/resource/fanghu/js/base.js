/**
 * loadMask 添加遮罩层
 */
function loadMask() {
  $('<div id="gLoadingMask" class="h-mask-container"><div class="h-mask-gif"></div></div>').appendTo('body');
  $('#gLoadingMask').css('display', 'block');
}
/**
 * removeMask 移除遮罩层
 */
function removeMask() {
  $('#gLoadingMask').remove();
}
/**
 * 下拉导航
 */
function toggleKey(){
    if(document.getElementById('navcl').style.display=='block'){
        document.getElementById('navcl').style.display='none';
    }else{
        document.getElementById('navcl').style.display='block';
    }
}
/**
 * 弹出提示信息
 */
function showmsg(msg)
{

    if ($('#maskBox').length > 0)
    {
        $('#maskBox').remove();
    }
    var html = '<div id="maskBox"><div id="gLoadingMask" class="h-mask-container"></div><div class="mask-alert"><p class="cue">'+msg+'</p><button id="msgbtn" class="btn-white">取消</button></div></div>';
    $(html).appendTo($(document.body));
    $('#gLoadingMask').css('display', 'block');

    $('#msgbtn').tap(function(){
        $('#maskBox').remove();
    });
}
/**
 * 阻止冒泡
 */ 
function stopBubble(e){   
    if(e && e.stopPropagation){
        e.stopPropagation();    //w3c
    }else{
        window.event.cancelBubble=true; //IE
    }
}
$(function(){
	var headerHeight = $(".header").height();
	var footerHeight = $(".h-foot").height();
	if($('.main-section').length>0){
		$('.main-section').css('min-height',($(window).height()-headerHeight-footerHeight)+"px");
	}
});