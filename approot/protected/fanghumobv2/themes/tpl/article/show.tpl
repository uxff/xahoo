<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/detaile.css" />
<!--/coolie-->
{literal}
<style type="text/css">
	.share-btn,.footer{ position: fixed; } .header{ position: relative; } 
</style>
{/literal}

<!--内容区 start-->
{if $iframeUrl}
<section class="task-list" style="padding: 0 0 11.624rem;">
<iframe src="{$iframeUrl}" style="width:100%;min-height:800px;color:" border="0" frameborder="no">
</iframe>
</section>
{else}
<section class="task-list">
    {$articleModel.content}
</section>
{/if}
<!--内容区 end-->
{if $gShowFooter}
<section class="share-btn">
    <!-- 本期不做收藏
    <a href="#" class="fl"><i class="iconfont">&#xe601;</i>立即收藏</a>
    -->
    <span style="line-height:2.083rem;">注册分享赚积分</span>
    <a href="#" class="fr"><i class="iconfont">&#xe603;</i>马上分享</a>
</section>
{/if}
<!--
    <a href="{$shareCallbackUrl}">马上分享</a>
-->
{include file="../common/weixin_share.tpl"}
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"  data-config="../../conf/coolie-config.js"  data-main="../main/article_main.js"></script>