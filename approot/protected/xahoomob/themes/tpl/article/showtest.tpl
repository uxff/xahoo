<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/detaile.css" />
{literal}
<!--/coolie-->
<style type="text/css" coolieignore>
	.share-btn,.footer{ position: fixed; } 
</style>
{/literal}

<div class="container">
<header class="header">
    <a href="javascript:history.go(-1);"class="fl"><i class="iconfont">&#xe604;</i></a>
    <span>{$articleModel.title}</span>
    <a href="javascr:;" class="fr"><i class="iconfont icon-fx">&#xe603;</i></a>
</header>

<!--内容区 start-->
<section class="task-list">
    {$articleModel.content}
</section>
<!--内容区 end-->
<section class="share-btn">
    <!-- 本期不做收藏
    <a href="#" class="fl"><i class="iconfont">&#xe601;</i>立即收藏</a>
    -->
    <a href="#" class="fr"><i class="iconfont">&#xe603;</i>马上分享</a>
</section>
<!--
    <a href="{$shareCallbackUrl}">马上分享</a>
-->
{include file="../common/weixin_share_test.tpl"}
<script coolie src="../../../../../resource/xahoo3.0/js/lib/coolie/coolie.min.js"  data-config="../../conf/coolie-config.js"  data-main="../main/article_main.js"></script>