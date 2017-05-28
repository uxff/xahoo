<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/lottery.css" />
<header class="header"><a href="{yii_createurl c=site a=index}" class="fl"><i class="iconfont"></i></a>积分抽奖</header>
<header class="index-header"></header>

<section class="lottery-box" >
    {if $member_id}
    <div class="banner">
        <span class="txt">您的积分: <span class="money  ponts_total"> {$totalInfo.points_total*1} </span></span>
        <span class="txt">今日剩余抽奖次数: <span class="money remain_times"> {$myBetTimes} </span></span>
    </div>
    {/if}
    <div class="t-bg"></div>
    <div class="turnt">
        <div class="start">
            <a href="#" class="start-btn"><img src="../../../../../resource/fanghu2.0/images/lottery/start.png"></a>
        </div>
        <ul class="lot start-list" >
            <li><div class="lot_1"></div></li>
            <li><div class="lot_2"></div></li>
            <li class="cur"><div class="lot_3"></div></li>
            <li><div class="lot_4"></div></li>
            <li><div class="lot_5"></div></li>
            <li><div class="lot_6"></div></li>
            <li><div class="lot_7"></div></li>
            <li><div class="lot_8"></div></li>
        </ul>
        <div class="txt-h"><img src="../../../../../resource/fanghu2.0/images/lottery/zi.png"></div>
    </div>
    {if empty($myWinList)}
    <div class="myprize" style="display:none">
        <div class="my-btn"><div class="txt"><a href="javascript:;">我的奖品</a></div></div>
    </div>
    <div class="prize-content" style="display:none">
        <div class="device" style="overflow:hidden">
		    <a class="arrow-left" href="#"></a> 
		    <a class="arrow-right" href="#"></a>
		    <div class="swiper-container" >
		      <div class="swiper-wrapper" >
		      </div>
            </div>
        </div>
    </div>
    {else}
    <div class="myprize">
        <div class="my-btn"><div class="txt"><a href="javascript:;">我的奖品</a></div></div>
    </div>
    <div class="prize-content">
        <div class="device" style="overflow:hidden">
            <input type="hidden" value="{$listSum}" name="listSum"/>
            {if $listSum ==1}
                <a class="arrow-left" href="javascript:;" style="display:none"></a> 
                <a class="arrow-right" href="javascript:;" style="display:none"></a>
            {else}
                <a class="arrow-left" href="javascript:;" ></a> 
                <a class="arrow-right" href="javascript:;"></a>
            {/if}
		    <div class="swiper-container" >
		      <div class="swiper-wrapper" >
              {foreach from=$myWinList key=k item=mo}
		        <div class="swiper-slide" prod_id="{$mo.product_id}">
		         <div class="txt fl">
		           <p>{$mo.create_time}</p>
                   <p>{$mo.prize}</p>
		         </div>
		         <div class="pic fr"><img src="{$mo.pic_url}" coolieignore /></div>
		        </div>
               {/foreach}
		      </div>
            </div>
        </div>
    </div>
    {/if}
    <div class="myprize">
        <div class="my-btn"><div class="txt"><a href="javascript:;">中奖名单</a></div></div>
    </div>
    <div class="prize-content">
        <ul class="prize-list prize-one">
            <li><span class="fl">用户</span><span class="fr">奖品</span></li>
        </ul>
        <div id="wrap">
          	<ul class="prize-list list">
            {foreach from=$allWinList key=k item=o}
          		<li><span class="fl">{$o.member_mobile}</span><span class="fr">{$o.prize}</span></li>
            {/foreach}
          	</ul>
        </div>
    </div>
    <div class="myprize">
        <div class="my-btn"><div class="txt"><a href="javascript:;">活动规则</a></div></div>
    </div>
    <div class="prize-content">
        <div class="pri-txt">
            <p>一、活动时间：2016.9.28-2016.12.31</p>
            <p>二、活动形式：</p>
            <p class="pri-txt-t"> 1、每次抽奖需要扣除200积分，扣除的积分不退还，每天最多抽奖三次；</p>
            <p class="pri-txt-t">2、本活动奖品为：iPhone6s、小米48英寸液晶电视、京东E卡、积分，每天奖品数量超过1万份。</p>
            <p>三、领取方式：</p>               
            <p class="pri-txt-t"> 1、中奖积分我们将直接发放到您的积分账户中，请在Xahoo中查看“我的”→“我的积分”；</p>
            <p class="pri-txt-t">2、京东E卡由专人通过手机短信的方式将京东E卡的账号和密码发送到您的手机上；</p>
            <p class="pri-txt-t">3、小米48英寸液晶电视和iPhone6s需到新奇世界由山由谷或者御马坊项目案场领取奖品。</p>
            <p>四、最终解释权归Xahoo所有。</p>
            </p>
        </div>
    </div>
    <div class="d-bg"></div>
    
</section>
<input type="hidden" id="token" value="{$token}">

<!--footer class="index-footer">
    <nav class="footer-nav">
        <ul>
            <li><a href="{yii_createurl c=site a=index}"><i class="iconfont index-iconfont">&#xe602;</i>首页</a></li>
            <li><a href="{yii_createurl c=lizhuan a=index}"><i class="iconfont index-iconfont">&#xe606;</i>任务</a></li>
            <li><a href="{yii_createurl c=my a=index}"><i class="iconfont index-iconfont">&#xe610;</i>我的</a></li>
        </ul>
    </nav>
</footer><br><br-->


<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
    data-config="../../conf/coolie-config.js"
    data-main="../main/lottery.js"></script>
