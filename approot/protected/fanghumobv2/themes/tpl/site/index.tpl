<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/index.css" />
<!--/coolie-->
<header class="index-header">
<!--首页header特殊-->
</header>
<section class="banner" >
    <div class="swiper-container">
        <div class="swiper-wrapper" id="big_swiper">
        {if $bannerModel}
        {foreach from=$bannerModel.pics key=picsId item=picObj}
            <div class="swiper-slide index-banner">
            	<a href="{$picObj.link_url|default:'javascript:;'}">
            		<img src="{$picObj.file_path}" coolieignore/>	
            	</a>
            </div>
        {/foreach}
        {else}
            <div class="swiper-slide index-banner">
            	<a href="/">
            		<img src="../../../../../resource/fanghu2.0/images/index/index_banner.jpg"/>	
            	</a>
            </div>
        {/if}
        </div>
        <!-- 如果需要分页器 -->
        {if count($bannerModel.pics)}
        <div class="swiper-pagination"></div>
        {/if}
        <input type="hidden" id="banner_pic_circle_sec" value="{$bannerModel.circle_sec*1000}">
    </div>
</section>
<section class="index-nav">
    <ul>
        <li>
            <a href="{yii_createurl c=my a=checkin}">
                <p>天天领积分</p>
                <span>百万积分任你领</span>
            </a>
        </li>
        <li>
            <a href="{yii_createurl c=user a=memberrights}" class="nav-qy">
                <p>会员权益说明</p>
                <span>会员权益积分机制</span>
            </a>
        </li>
    </ul>
</section>
<section class="sm-banner" >
    <div class="sm-swiper-container">
        <div class="swiper-wrapper sm-swiper-wrapper">
            {foreach from=$actPicsModel.pics key=picsId item=picObj}
            <div class="swiper-slide sm-index-banner">
                <a href="{$picObj.link_url|default:'javascript:;'}">
                	<img src="{$picObj.file_path}" alt="" coolieignore/>
                </a>
            </div>
            {/foreach}
        </div>
        <!-- 如果需要分页器 -->
        <div class="sm-pagination swiper-pagination"></div>
        <input type="hidden" id="art_pic_circle_sec" value="{$actPicsModel.circle_sec*1000}">
    </div>
</section>
<section class="index-list">
    <h2>热门推荐</h2>
    <ul>
        {foreach from=$hotArtModels key=k item=hotArtModel}
        <li>
            <a href="{$hotArtModel.url}">
            	<img data-original="{$hotArtModel.surface_url}" coolieignore src="../../../../../resource/fanghu2.0/images/integral/bg_big.png" />
            </a>
            <p class="fl">{$hotArtModel.title}</p>
            <span class="fr"><font>{$hotArtModel.tips}</font></span>
        </li>
        {/foreach}
    </ul>
</section>
<footer class="index-footer">
    <nav class="footer-nav">
        <ul>
            <li class="active"><a href="{yii_createurl c=site a=index}"><i class="iconfont index-iconfont">&#xe602;</i>首页</a></li>
            <li><a href="{yii_createurl c=lizhuan a=index}"><i class="iconfont index-iconfont">&#xe606;</i>任务</a></li>
            <li><a href="{yii_createurl c=my a=index}"><i class="iconfont index-iconfont">&#xe610;</i>我的</a></li>
        </ul>
    </nav>
</footer>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"  data-config="../../conf/coolie-config.js"  data-main="../main/index_main.js"></script>
