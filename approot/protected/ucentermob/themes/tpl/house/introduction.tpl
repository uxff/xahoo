<header class="header3 header">
    <p class="h-top">项目详情</p>
    <a href="{yii_createurl c=house a=detail house_id=$house_id}" class="h-item-left icon-angle-left"></a>
    <!-- <a href="javascript:;" class="h-item-right  h-icon-th click-show-hide"></a> -->
    <div class="dialog-pic-icon" style="display: none;border-top:1px solid #d7d7d7;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="clearfloat"></ul>
</header>
<section class="h-index main-section">
    <div>
        <div class="clearfix mg-b10 h-container">
            <div class="h-grade-info clearfix">
                <ul class="h-itemintro-list">
                    <li>
                        <a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}" class="h-thumb">
                            <img src="{$houseDetail.house_thumb}" data-src="holder.js/120x70/auto/sky" style="width:120px;height:70px;" alt="120x70" data-holder-rendered="false">
                        </a>
                        <div class="list-r h-myhouse-list">
                            <h3 class="desc"><a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}">{$houseDetail.house_name} {$houseDetail.house_type}</a></h3>
                            <p class="time mg-b18">￥{floatval($houseDetail.house_num_price)}万/套</p>
                            <p class="pink2">￥{$houseDetail.house_avg_price}万/份</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix mg-t10 mg-b10 h-container">
            <div class="h-grade-info clearfix" id="grade-info">
                <h3 class="nickname mg-l10">项目简介</h3>
                {$houseDetail.house_desc}
            </div>
        </div>
    </div>
</section>