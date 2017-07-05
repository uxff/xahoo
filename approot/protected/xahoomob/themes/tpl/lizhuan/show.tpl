<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/detaile.css" />
<!--/coolie-->
{literal}
<style type="text/css">
	.share-btn,.footer{ position: fixed; } .header{ position: fixed; } 
</style>
{/literal}
<div class="container">
<header class="header">
    <a href="javascript:history.go(-1);"class="fl"><i class="iconfont">&#xe604;</i></a>
    <a href="javascr:;" class="fr"><i class="iconfont icon-fx">&#xe603;</i></a>
    <span>{$pageTitle}</span>
</header>

<!--内容区 start-->
<section class="task-list" style="padding: 0 0 11.624rem;">
<iframe src="{$iframeUrl}" style="width:100%;min-height:800px" border="0" frameborder="no">
</iframe>
</section>
<!--内容区 end-->
<section class="share-btn">
    <!-- 本期不做收藏
    <a href="javascript:;" class="fl"><i class="iconfont">&#xe601;</i>立即收藏</a>
    -->
    <a href="javascript:;" class="fl btn-share-callback"><i class="iconfont">&#xe603;</i>分享回调</a>
    <a href="javascript:;" class="fr"><i class="iconfont">&#xe603;</i>马上分享</a>
</section>
<!--
    <a href="{$shareCallbackUrl}">马上分享</a>
-->
{include file="../common/weixin_share.tpl"}
<script coolie src="../../../../../resource/xahoo3.0/js/lib/coolie/coolie.min.js"  data-config="../../conf/coolie-config.js"  data-main="../main/article_main.js"></script>