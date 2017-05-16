<header class="header3">
    <p class="h-top">我在逸乐通的收藏</p>
    <a href="{$returnUrl}" class="h-item-left icon-angle-left"></a>
</header>

<section class="bgf0 main-section main-section">
    <div>
        <div class="clearfix h-container">
            <div class="h-grade-info clearfix">
                {if !empty($houseList)}
                    <ul class="h-fav-list">
                        {foreach from=$houseList key=index item=i}
                            <li>
                                <a href="{yii_createurl c=house a=detail house_id=$i.house_id}" class="h-thumb">
                                    <img src="{$i.house_thumb}"  data-src="holder.js/120x70/auto/sky" alt="120x70" style="width: 120px;height: 70px" data-holder-rendered="false" class="img-responsive">
                                </a>
                                <div class="list-r">
                                    <h3 class="desc"><a href="{yii_createurl c=house a=detail house_id=$i.house_id}">{$i.house_name} {$i.house_type}</a></h3>
                                    <p class="grey999 mg-b20">￥{$i.house_num_price}万/套</p>
                                    <p class="pink2 h-fs16">￥{$i.house_avg_price}万/份</p>
                                </div>
                            </li>
                        {/foreach}
                    </ul>
                    {if $total>$pageSize}<p id="more" alt="{$total}" class="h-resur-more">点击加载更多</p>{/if}
                {else}
                    <p>暂无收藏信息</p>
                {/if}
            </div>
        </div>
    </div><!-- 第一个页面/ -->
</section>
