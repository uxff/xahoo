<header class="header3">
    <p class="h-top">产权详情</p>
    <a href="{yii_createurl c=customer a=cardList}" class="h-item-left icon-angle-left"></a>
    <a href="javascript:;" class="h-item-right  h-icon-th click-show-hide"></a>
    <div class="dialog-pic-icon" style="display: none;border-top:1px solid #d7d7d7;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="clearfloat"></ul>
</header>
<section class="bgf0">
    <div class="clearfix mg-b10 h-container h-container-detail">

        <div class="clearfix">
            <ul class="h-itemintro-list pd-15">
                <li class="clearfix pd-b10 h-border-b">
                    <a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}" class="h-thumb">
                        <img src="{$houseDetail.house_thumb}" data-src="holder.js/103x60/auto/sky" style="width:103px;height:60px;" alt="103x60" data-holder-rendered="false">
                    </a>
                    <div class="list-r h-myhouse-list">
                        <p class="h-order-time mg-b10">项目名称：<span>{$houseDetail.house_name} {$houseDetail.house_type}</span> </p>
                        <p class="h-order-time mg-b10">认购金额：<span>￥{$cardDetail.order_total}</span> </p>
                        <p class="h-order-time mg-b10">认购人：<span>{$cardDetail.customer_name}</span> </p>
                    </div>
                </li>
                <li>
                    <ul>
                        <li class="h-order-time mg-t10">订单时间：<span>{$cardDetail.create_time}</span></li>
                        <li class="h-order-time mg-t10">身份证号：<span class="grey-color">{$cardDetail.customer_identity_id}</span></li>
                        <!-- <li class="h-order-time mg-t10">获得积分：<span>{$orderDetail.orderPoint}分</span><a href="{$ucenterShopMallUrl}"><span class="pull-right pink2 ">积分商城</span></a></li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--下面代码为持有的代码-->  
    <div class="card-number" style="display: block;">
        <ul class="list-unstyled {if $cardDetail.type==0 || $cardDetail==2}border-gray{else}border-blue{/if}">
            <li><span class="gray-color">实体卡号：</span> {$cardDetail.identity_id}<span class="pull-right pink2">获取实物卡</span></li>
            <li><span class="gray-color letter-space">状　　态： </span><span class="black">{$cardDetail.card_status_chinese}</span></li>
            <li>
                <span class="gray-color letter-space">权　　益：</span>
                <span class="span-pos">
                    {$cardDetail.equity_desc}
                </span>
            </li>
        </ul>
    </div>
    <!--<div class="clearfix mg-b10 h-container">

        <ul class="pd-lr10 h-ordersuccess-ul">
            <li>
                <span class="mg-l10">项目详情：</span>
                <span class="grey6e h-right mg-r20">查看合同</span>
            </li>
            <li>
                <span class="mg-l10">合　　同：</span>
                <span class="grey6e h-right mg-r20">积分商城</span>
            </li>
        </ul>
    </div>--> 

</section>