<section class="">
    <div class="h-income-box">
        <h3 class="tit no-bd-top clearfix"><i class="h-icon-comm"></i> 我的资金总览{*<a href="#" class="h-right orange">什么是资产总价值</a>*}</h3>
        <div class="all-num">
            <i>￥</i><span>{$myAllAccountTotal}</span><br>
            <div class="myass">我的资产总价值</div>
        </div>
    </div>
    <div class="h-income-box mg-t10">
        <h3 class="tit clearfix">现金账户（可提现账户）<a href="#" class="h-right grey999">什么是可提现账户</a></h3>
        <a href="{yii_createurl c=cash a=detail}"><div class="myassnum">{$myCashTotal}</div></a>
        <h3 class="tit clearfix">资产账户<a href="#" class="h-right grey999">什么是资产账户</a></h3>
        <ul class="myassnumul">
            <!--<li><a href="{$zcRevenueIndexUrl}">
                <h3>我在众筹<span class="h-right grey999">认筹项目：{$myZCProjectCount}</span></h3>
                <div class="myassnum2">{$myZCAccountTotal}</div>
                <p class="grey999">认筹资产总值</p>
            </a></li>-->
            <li><a href="{$fqCardIndexUrl}">
                <h3>我在分权 <i> · </i> 交易<span class="h-right grey999">持有产权：{$myFQProjectCount}</span></h3>
                <div class="myassnum2">{$myFQAccountTotal}</div>
                <p class="grey999">分权 <i> · </i> 交易产品总值</p>
            </a></li>
            {*
            <li><a href="{$fhRewardIndexUrl}">
                <h3>我在房乎<span class="h-right grey999">小伙伴数目：{$myFHBuddyCount}</span></h3>
                <div class="myassnum2">{$myFHAccountTotal}</div>
                <p class="grey999">认筹资产总值</p>
            </a></li>
            *}
        </ul>
    </div>
</section>