<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<meta name="format-detection" content="telephone=no" />
    <title>{$pageTitle} - 房乎</title>
    <!--coolie-->
    <link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/base.css" />
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
