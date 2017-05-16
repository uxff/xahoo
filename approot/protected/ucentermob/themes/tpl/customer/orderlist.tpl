<header class="header2">
    <p class="h-top">逸乐通订单</p>
    <a href="{yii_createurl c=customer a=index}" class="h-item-left icon-angle-left"></a>
    <a href="javascript:;" class="h-item-right  h-icon-th click-show-hide"></a>
    <div class="dialog-pic-icon" style="display: none;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="tab-nav tab-nav2 clearfix clearfloat" id="tab">
        <li {if $type == 0}class="active"{/if}><a href="{yii_createurl c=customer a=orderList}">全部订单</a></li>
        <li {if $type == 1}class="active"{/if}><a href="{yii_createurl c=customer a=orderList type=1}">待付款</a></li>
        <li {if $type == 2}class="active"{/if}><a href="{yii_createurl c=customer a=orderList type=2}">已付款</a></li>
        <li {if $type == 3}class="active"{/if}><a href="{yii_createurl c=customer a=orderList type=3}">已取消</a></li>
    </ul>
</header>
<section class="main-section">
    <!-- 空div 站位-->
    <div class="nomovebox1"> </div>
    <!-- 选项卡 -->
    <div id="panel">
        <div class="order01"><!-- 第一个页面 -->

            {if !empty($orderList)}
            {foreach from=$orderList key=index item=i}
            <div class="h-order2 mg-t10">
                {foreach from=$i.items key=pre item=m}
                {if $pre==0}
                    <p class="order-id clearfix">编号：<a href="{yii_createurl c=order a=orderDetail order_id = $i.order_id}">{$i.displayOrderId}</a> <a class="detail" href="{yii_createurl c=order a=orderDetail order_id = $i.order_id}">订单详情</a></p>
                    <div class="h-order-main bor-bt">
                            <a class="tit clearfix" href="{yii_createurl c=order a=orderDetail order_id=$i.order_id}">{$m.house.house_name} {$m.house.house_type}<span class="status pink2">{if $i.order_status == 1}待付款{elseif $i.order_status == 2}已支付{else}已取消{/if}</span></a>
                            <div class="h-thumb2">
                                <a href="{yii_createurl c=order a=orderDetail order_id=$i.order_id}" class="thumb">
                                    <img src="{$m.house.house_thumb}"  data-src="holder.js/130x70/auto/sky"  style="width:130px;height:70px" alt="130x70" data-holder-rendered="false">
                                </a>

                                <a href="{yii_createurl c=order a=orderDetail order_id=$i.order_id}">
                                    <ul class="thumb-r">
                                        <li class="clearfix">{$m.house.province.sys_region_name} {$m.house.city.sys_region_name}<span>{floatval($m.house.house_area)}平米</span></li>
                                        <li class="clearfix">每份价格：<span><em class="lit">￥</em>{$m.house.house_avg_price}万</span></li>
                                        <li class="pink2 clearfix">认购份数：<span>{$m.item_quantity}份</span></li>
                                        <li class="pink2 clearfix">认购金额：<span class="red big">￥{$m.pay_total}万</span></li>
                                    </ul>
                                </a>
                            </div>
                        </div>
                {else}
                    <div class="hide hiding">
                        <div class="h-order-main bor-bt">
                            <a class="tit clearfix" href="{yii_createurl c=order a=orderDetail order_id=$i.order_id}">{$m.house.house_name} {$m.house.house_type}<span class="status pink2">{if $i.order_status == 1}待付款{elseif $i.order_status == 2}已支付{else}已取消{/if}</span></a>
                            <div class="h-thumb2">
                                <a href="{yii_createurl c=order a=orderDetail order_id=$i.order_id}" class="thumb">
                                    <img src="{$m.house.house_thumb}"  data-src="holder.js/130x70/auto/sky"  style="width:130px;height:70px" alt="130x70" data-holder-rendered="false">
                                </a>

                                <a href="{yii_createurl c=order a=orderDetail order_id=$i.order_id}">
                                    <ul class="thumb-r">
                                        <li class="clearfix">{$m.house.province.sys_region_name} {$m.house.city.sys_region_name}<span>{floatval($m.house.house_area)}平米</span></li>
                                        <li class="clearfix">每份价格：<span><em class="lit">￥</em>{$m.house.house_avg_price}万</span></li>
                                        <li class="pink2 clearfix">认购份数：<span>{$m.item_quantity}份</span></li>
                                        <li class="pink2 clearfix">认购金额：<span class="red big">￥{$m.pay_total}万</span></li>
                                    </ul>
                                </a>
                            </div>
                        </div>
                    </div>
                {/if}
                {/foreach}
                {if count($i.items)>1}
                    <div class="clearfix bor-bt exhibit">
                        <p>显示其他{count($i.items)-1}个项目</p>
                    </div>
                {/if}
                    <div class="clearfix bor-bt paying">
                        <!-- <p>已付定金：<span>2000元</span></p> -->
                        <p>预付金额：<span>￥{$i.order_num_total}万</span></p>
                    </div>

                {if $i.order_status == 1}
                    <div class="pay-time clearfix">
                        <p class="red">支付剩余时间：<span class="hms" alt="{$i.time_long.surplusTime}">{$i.surplusFormateTime}</span></p>
                        <p><a class="cancel" href="{yii_createurl c=order a=cancelOrder order_id=$i.order_id}">取消订单</a></p>
                        <a class="pinkbtn pay" href="{yii_createurl c=checkout a=confirm order_id=$i.order_id}">立即付款</a>
                    </div>
                {/if}
                </div>
            {/foreach}
            {else}
                <div class="h-order mg-t10">
                    <p class="order-id clearfix" style="text-align: center">暂无该订单信息</p>
                </div>
            {/if}
        </div><!-- 第一个页面/ -->
        {if $total>$pageSize}<p id="more" alt="{$total}" class="h-resur-more">点击加载更多</p>{/if}
    </div><!-- /banner -->
</section>