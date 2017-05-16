<header class="header2">
    <p class="h-top">我的产权</p>
    <a href="{yii_createurl c=customer a=index}" class="h-item-left icon-angle-left"></a>
    <a href="javascript:;" class="h-item-right  h-icon-th click-show-hide"></a>
    <div class="dialog-pic-icon" style="display: none;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="tab-nav tab-nav2 clearfix clearfloat" id="tab">
        <li {if $type == 0}class="active"{/if}><a href="{yii_createurl c=customer a=cardList}">全部产权</a></li>
        <li {if $type == 1}class="active"{/if}><a href="{yii_createurl c=customer a=cardList type=1}">持有</a></li>
        <li {if $type == 2}class="active"{/if}><a href="{yii_createurl c=customer a=cardList type=2}">已交易</a></li>
        <li {if $type == 3}class="active"{/if}><a href="{yii_createurl c=customer a=cardList type=3}">已过期</a></li>
    </ul>
</header>
<section class="main-section">
    <!-- 空div 站位-->
    <div class="nomovebox1"> </div>
    <!-- 选项卡 -->
    <div id="panel">
        <div class="order01"><!-- 第一个页面 -->
            <!-- 待付款 -->
            {if !empty($arrCardToHouse)}
                {foreach from=$arrCardToHouse key=index item=i}
                    <div class="h-order mg-t10">
                        <p class="order-id clearfix">卡号：NO:{$i.identity_id} <a class="detail" href="{yii_createurl c=house a=detail house_id=$i.house.house_id}">项目详情</a></p>
                        <div class="h-order-main h-border-b">
                            <a class="tit clearfix" href="{yii_createurl c=customer a=cardDetail card_id=$i.card_id}">{$i.house.house_name} {$i.house.house_type}<span class="status pink2">{$i.card_status_chinese}</span></a>
                            <div class="h-thumb2 clearfix">
                                <a href="{yii_createurl c=customer a=cardDetail card_id=$i.card_id}" class="thumb">
                                    <img src="{$i.house.house_thumb}"  data-src="holder.js/120x70/auto/sky"  style="width:120px;height:70px" alt="120x70" data-holder-rendered="false">
                                </a>
                                <ul class="thumb-r">
                                    <li class="clearfix">{$i.house.province.sys_region_name} {$i.house.city.sys_region_name}<span>{$i.house.house_area}平米</span></li>
                                    <li class="clearfix">认购价格：<span><em class="lit">￥</em>{$i.house.house_avg_pricemillion}万</span></li>
                                    <li class="clearfix">有效期至：<span>{$i.end_time}</span></li>
                                </ul>
                            </div>
                        </div>
                        {if $i.type==1}        
                            <div class="pay-time clearfix mg-t10">
                                <a class="pinkbtn h-right" href="">交易</a>
                            </div>
                        {/if}
                        <!-- <div class="pay-time clearfix mg-t10">
                <a class="bluebtn h-right" href="#">查看交易</a>
                <p class="mg-t10 red">交易状态：挂单中</p>
            </div>-->
                    </div>
                {/foreach}
                
            {else}
                <div class="h-order mg-t10">
                    <p class="order-id clearfix">暂无此数据</p>
                </div>
            {/if}
        </div><!-- 第一个页面/ -->
        {if $total>$pageSize}<p id="more" alt="{$total}" class="h-resur-more">点击加载更多</p>{/if}
    </div><!-- /banner -->
</section>