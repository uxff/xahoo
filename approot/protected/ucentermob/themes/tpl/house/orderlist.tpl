<header class="header2">
    <p class="h-top">项目详情</p>
    <a href="{yii_createurl c=house a=list}" class="h-item-left icon-angle-left"></a>
     <!-- <a href="javascript:;" class="h-item-right  h-icon-th click-show-hide"></a> -->
    <div class="dialog-pic-icon" style="display: none;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="tab-nav tab-nav2 clearfix clearfloat" id="tab">
        <li><a href="{yii_createurl c=house a=detail house_id=$house_id}">项目介绍</a></li>
        <li><a href="{yii_createurl c=house a=purchaseRights house_id=$house_id}">认购权益</a></li>
        <li><a href="{yii_createurl c=house a=contractList house_id=$house_id}">合同公示</a></li>
        <li class="active"><a href="{yii_createurl c=house a=orderList house_id=$house_id}">认购记录</a></li>
    </ul>
</header>
    <section class="main-section">
    <!-- 空div 站位-->
    <div class="nomovebox1"> </div>
    <!-- 选项卡 -->
    <div id="panel" class="">
        <div>
            <ul class="h-itemintro-list">
                <li>
                    <a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}" class="h-thumb">
                        <img src="{$houseDetail.house_thumb}" data-src="holder.js/120x70/auto/sky" style="width:120px;height:70px;" alt="120x70" data-holder-rendered="false">
                    </a>
                    <div class="list-r h-myhouse-list">
                        <h3 class="desc"><a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}">{$houseDetail.house_name} {$houseDetail.house_type}</a></h3>
                        <p class="time mg-b18">{if $houseDetail.house_price|intval > 0}￥{floatval($houseDetail.house_num_price)}万/套{/if}</p>
                        <p class="pink2">{if $houseDetail.house_price|intval > 0}￥{floatval($houseDetail.house_avg_price)}万/份{else}待定{/if}</p>
                    </div>
                </li>
            </ul><!-- /media -->
            <!-- progress bar -->
            {if $houseDetail.is_sell !=0}
                <div class="h-buylog-bar">
                    <div class="bar-bg">
                        <div class="bar" style="width:{$houseDetail.ratio}%"></div>
                    </div>
                </div>

                <ul class="h-item-imgul clearfix">
                    <li class="h-xs-3"><span class="h-item-grey">已完成</span><span class="h-item-color">{floatval($houseDetail.ratio)}%</span></li>
                    <li class="h-xs-3"><span class="h-item-grey">已筹金额</span><span class="h-item-color">{$houseDetail.price_total}万</span></li>
                    <li class="h-xs-3"><span class="h-item-grey">剩余时间</span><span class="h-item-color">{$houseDetail.remaining_time}天</span></li>
                    <li class="h-xs-3"><span class="h-item-grey">剩余份数</span><span class="h-item-color">{$houseDetail.surplus_item_total}份</span></li>
                </ul>
            {/if}
            {if !empty($orderList)}
                <ul class="h-buylog-list mg-t10">
                    <li class="row">
                        <span>&nbsp;</span>
                        <span>认购人</span>
                        <span>时间</span>
                        <span>份数</span>
                        <span>金额</span>
                    </li>
                    {foreach from=$orderList key=index item=i}
                        <li class="row">
                            <span>{$index+1}</span>
                            <span>{$i.cusomter_name}</span>
                            <span>{$i.create_time}</span>
                            <span>{$i.item_quantity}</span>
                            <span>￥{$i.order_total}</span>
                        </li>
                    {/foreach}
                </ul>
            {else}
                <ul class="h-buylog-list mg-t10">
                    <p>暂无认购记录</p>
                </ul>
            {/if}
        </div><!-- 第四个页面/ -->
    </div><!-- /banner -->   
</section>