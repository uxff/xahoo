<header class="header2 header">
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
        <li class="active"><a href="{yii_createurl c=house a=purchaseRights house_id=$house_id}">认购权益</a></li>
        <li><a href="{yii_createurl c=house a=contractList house_id=$house_id}">合同公示</a></li>
        <li><a href="{yii_createurl c=house a=orderList house_id=$house_id}">认购记录</a></li>
    </ul>
</header>
<section class="h-index main-section">
    <!-- 空div 站位-->
    <div class="nomovebox1"> </div>
    <!-- 选项卡 -->
    <div id="panel" class="h-box-bgff-p10">
        {$purchaseRights.revenue_desc}
    </div>
</section>
