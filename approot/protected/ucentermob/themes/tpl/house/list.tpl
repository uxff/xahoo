<section class="h-index">
    <!-- tab -->
    <ul class="tab-nav clearfix" id="tab">
        <li><a href="{yii_createurl c=site a=index}">逸乐通首页</a></li>
        <li  class="active"><a href="{yii_createurl c=house a=list}">逸乐通项目</a></li>
        <li><a href="{yii_createurl c=site a=fqProcess}">逸乐通流程</a></li>
    </ul>
    <div id="panel">
        <div class="houlist">
            <ul class="data-list">
                {foreach from=$list key=index item=i}
                    <li class="h-inlist">
                        <a href="{yii_createurl c=house a=detail house_id = $i.house_id}">
                            <div class="h-bgtext-t {if $i.is_sell < 2}ing{else}over{/if}">
                                {if $i.is_sell ==0}
                                    <p class="info"><span></span></p>
                                    <h1 class="status">展示中</h1>
                                {elseif $i.is_sell == 1}
                                    <p class="info"><span>已参加： {$i.customer_total}人</span>{$i.ratio}%</p>
                                    <h1 class="status">认购中</h1>
                                {elseif $i.is_sell ==2}
                                    <p class="info"><span>已参加： {$i.customer_total}人</span>{$i.ratio}%</p>
                                    <h1 class="status">已结束</h1>
                                {/if}
                            </div>
                            <img src="{$i.house_thumb}" data-src="holder.js/100%x225/auto/sky" alt="">
                            <div class="h-bgtext">
                                <div class="clearfix">
                                    <p class="h-bgtext-l">
                                        <span class="h-fsb">{$i.house_name}</span><br/>
                                        {$i.province.sys_region_name} {$i.city.sys_region_name} {floatval(round($i.house_area))}平米
                                    </p>
                                    <p class="h-bgtext-r">
                                        {if $i.house_price|intval >0}
                                        ￥{floatval($i.house_num_price)}万/套 <br/> 
                                        约<span class="h-fsbc">￥{floatval($i.house_avg_price)}万/份</span>
                                        {else}
                                        待定
                                        {/if}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                {/foreach}
            </ul>
            {if $total>$pageSize}<p id="more" alt="{$total}" class="h-resur-more">点击加载更多</p>{/if}
        </div><!-- /houlist -->   
    </div>
</section>
