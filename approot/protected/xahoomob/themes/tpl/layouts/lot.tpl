<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="format-detection" content="telephone=no"/>
		<title>积分抽奖</title>
		<!--coolie-->
		<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/base.css" />
		<!--/coolie-->
        {literal}
		<script>
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth>750){
                    	clientWidth = 750;
                    }
                    docEl.style.fontSize = 24 * (clientWidth / 640) + 'px';
                };


            // Abort if browser does not support addEventListener
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    	</script>
        {/literal}
	</head>
	<body>
    <!-- #section:basics/content.page_content_area -->
    {include file="$NACHO_PAGE_TPL_FILE"}
    <!-- /section:basics/content.page_content_area -->

    <footer class="footer_lot">
        {if $gIsGuest}
        <ul>
            <li><a href="{yii_createurl c=user a=login}">登录</a></li>
            <li><a class="active" href="{yii_createurl c=user a=register}">注册</a></li>
            <li><a href="{yii_createurl c=site a=aboutus}">关于我们</a></li>
        </ul>
        {else}
        <ul>
            <li><span style="color:#333333;"><a href="{yii_createurl c=my a=index}">{$member_nickname}</a></span></li> 
            <li><a href="{yii_createurl c=my a=logout logout_return_url=$logout_return_url}">退出登录</a></li>
            <li><a href="{yii_createurl c=site a=aboutus}">关于我们</a></li>
        </ul>
        {/if}
        <p>copyright@2014-{$smarty.now|date_format:'%Y'} 津ICP备16004915号-3</p>
    </footer>

    <!-- #section:basics/footer.tracking_js -->
    {include file="../common/footer_tracking.tpl"}
    <!-- #section:basics/footer.tracking_js -->
