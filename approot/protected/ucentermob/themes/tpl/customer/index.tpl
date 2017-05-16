


<section class="h-user" style="display:block">
    <h1 class="h-tit clearfix">
        新奇世界通行证账户
        <!-- <i class="icon-envelope-alt"></i> -->
        <!-- <span class="mailnum">23</span> -->
    </h1>
    <div class="container h-user-head clearfix">
        {if $userProfile.userAvatar == ''}
            <img src="{$resourcePath}/imgs/h-per-head.png" width="60px" height="60px" data-src="holder.js/60x60/sky/text:头像" alt="">
        {else}
            <img src="{$userProfile.userAvatar}" width="60px" height="60px" data-src="holder.js/60x60/sky/text:头像" alt="">
        {/if}
        <!-- <img src="{$userProfile.userAvatar}" width="60px" height="60px" data-src="holder.js/60x60/sky/text:头像" alt=""> -->
        <a href="{$ucenterMyProfileUrl}" class="picmask"></a>
        <div class="h-user-info clearfix">
            {*<a href="{$ucenterCheckinUrl}" class="{if $sign_status == null}orgbtnbg{else}orgbtnbg2{/if}" {if $sign_status != null}style="background: darkgrey !important"{/if} {if $sign_status != null}onclick="return false;" {/if}>{if $sign_status == null}签到{else}已签到{/if}</a>*}
            {*<a href="{$ucenterCheckinUrl}" class="orgbtnbg">签到</a>*}
            <h2 class="nickname"><a href="{$ucenterMyProfileUrl}" class="font-index-19">{$userProfile.welcomeName}</a></h2>
            <a href='{$ucenterGradeUrl}'>
            <p class="level"><img src="{$resourcePath}/imgs/iconsmall1.png" class="h-icon-grade">{$userProfile.memberGradeName}</p>
            <p class="score">贡献值：{$userProfile.totalContribute}</p>
            <div class="bar-bg">
                <div class="bar" style="width:{$userProfile.memberGradePercent}%"></div>
            </div>
            </a>
        </div>
    </div>

    <ul class="container h-li-4c clearfix h-bd-top">
        <li>
            <a href="{$ucenterMyPointUrl}">
                <span><i class="h-icon-score"></i></span><br>
                我的积分
            </a>
        </li>
        <li>
            <a href="{$ucenterMyCapitalUrl}">
                <span><i class="h-icon-task"></i></span><br>
                我的资产
            </a>
        </li>
        <li>
            <a href="{$ucenterMyFavoriteUrl}">
                <span><i class="h-icon-heart"></i></span><br>
                我的收藏
            </a>
        </li>
        <!--====================通过切换类名来显示购物车的亮与暗    h-icon-shop h-icon-shop-normal-->
        <!--
        <li>
            <a href="{$ucenterShopMallUrl}">{*{$ucenterShopMallUrl}*}
                <span><i class="h-icon-shop h-icon-shop-normal"></i></span><br>
                积分商城
            </a>
        </li>
        
        <li>
            <a href="{$ucenterContactUsUrl}">
                <span><i class="h-icon-listen"></i></span><br>
                联系我们
            </a>
        </li>
        -->
    </ul>
    <!-- 热推房源 -->
    <div class="h-box">
        <h2 class="h-tit">逸乐通</h2>
        <ul class="container h-li-4c clearfix">
            <!--<li>
                <a href="{$zcOrderListUrl}">
                    <span><i class="h-icon-comm2"></i></span><br>
                    众筹订单
                </a>
            </li>
            <li>
                <a href="{$zcRevenueListUrl}">
                    <span><i class="h-icon-task"></i></span><br>
                    众筹收益
                </a>
            </li>-->
            <li>
                <a href="{$fqOrderListUrl}">
                    <span><i class="h-icon-house"></i></span><br>
                    逸乐通订单
                </a>
            </li>
            <!--
            <li>
                <a href="{$fqCardListUrl}">
                    <span><i class="h-icon-partner"></i></span><br>
                    逸乐通产权
                </a>
            </li>
            -->
        </ul>
    </div><!-- /热推房源 -->
    <!-- 热推咨询 -->
    <div class="h-box">
      <h2 class="h-tit">更多产品</h2>
        <ul class="container h-li-4c clearfix h-borderb">
            <li  class="index-float-none" >
                <a  class="" href="{$fanghuIndexUrl}">
                    <img class="app-icon index-mg-30" src="{$resourcePath}/imgs/fanghu_icon.png" width="40px" data-src="holder.js/30x30/auto/sky" alt="">
                
                </a>
            </li>
            <li class="index-tpl-li-pos">赚积分、赚佣金尽在房乎</li>
            <div class="index-float-none-xia" >
            	<p class="index-mg-t15">房乎 </p>
            </div>
        </ul>
         
    </div><!-- /热推咨询 -->
</section>