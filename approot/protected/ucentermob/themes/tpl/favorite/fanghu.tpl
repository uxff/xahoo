{*
<section>
<ul class="h-personlist">
{if empty($MemberFavorite_article)}
没有资讯收藏
{else}
资讯收藏：
{foreach from=$MemberFavorite_article item=i}
<div style="margin:10px;">
<a href="{yii_createurl c=Task a=ArticleView id=$i.task_article.task_id}">{$i.task_article.task_title}</a>
</div>
{/foreach}
{/if}
</ul>

<ul class="h-personlist">
{if empty($MemberFavorite_building)}
没有楼盘收藏
{else}
楼盘收藏：
{foreach from=$MemberFavorite_building item=i}
<div style="margin:10px;">
<a href="{yii_createurl c=Task a=BuildingView id=$i.task_building.task_id}">{$i.task_building.task_title}</a>
</div>
{/foreach}
{/if}
</ul>
</section>
*}
<section class="h-house main-section">

        <ul class="tab-nav clearfix" id="tab">
                <li class="active"><a href="javascript:;">任务赚积分</a></li>
                <li><a href="javascript:;">成交赚佣金</a></li>
        </ul>
        <div id="panel">
                <!-- 任务赚积分 -->

                <ul class="container h-hou-list data-list01">
                        {if empty($MemberFavorite_article)}
                                没有资讯收藏
                        {else}
                                {foreach from=$MemberFavorite_article item=i}
                                        <li>
                                                <a href="{yii_createurl c=task a=articleView id=$i.task_id}" class="h-thumb">
                                                        <img src="{$i.task_article.task_img}" class="img-responsive" data-src="holder.js/90x70/auto/sky" alt="">
                                                </a>
                                                <div class="list-r">
                                                        <h3 class="desc"><a href="{yii_createurl c=task a=articleView id=$i.task_id}">{$i.task_article.task_title}</a></h3>
                                                        <span class="orange">5积分</span>
                                                        <a class="btn-ora-line" href="{yii_createurl c=task a=articleView id=$i.task_id}"><i class="icon-share"></i> 马上分享</a>
                                                </div>
                                        </li>
                                {/foreach}	
                                {if $articleTotal>3}
                                        <p id="moreArticle" alt="{$articleTotal}" class="page-more">点击加载更多</p>
                                {/if}
                        {/if}
                </ul> <!-- /任务赚积分-->


                <!-- 成交赚佣金 -->

                <ul class="h-img-list data-list02">
                        {if empty($MemberFavorite_building)}
                                没有楼盘收藏
                        {else}
                                {foreach from=$MemberFavorite_building item=i}
                                        <li>
                                                <a class="h-link" href="{yii_createurl c=task a=buildingView id=$i.task_id}">
                                                        <img src="{$i.task_building.task_img}" data-src="holder.js/100%x160/auto/sky" alt="" class="img-responsive" width="100%" height="160">
                                                </a>
                                                <span class="tag"><em>最高佣金</em>￥<strong>{$i.task_building.brokerage_max}</strong></span>
                                                <p class="container desc clearfix">{$i.task_building.building_name}<span class="price">均价：{$i.task_building.building_price}万元/平米</span></p>
                                        </li>
                                {/foreach}
                                {if $buildingTotal>3}
                                        <p id="moreBuilding" alt="{$buildingTotal}" class="page-more">点击加载更多</p>
                                {/if}
                        {/if}
                </ul><!-- /成交赚佣金 -->

        </div>

</section>
