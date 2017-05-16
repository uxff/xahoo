<!-- 分享到 -->
<link rel="stylesheet" rev="stylesheet" href="{$resourcePath}/css/shareContain.css" type="text/css" />
<header class="header2">
    <p class="h-top">项目详情</p>
    <a href="{if $urlReferrer=='preSell'}{yii_createurl c=site a=preSell} {elseif $urlReferrer=='index'} {yii_createurl }{else}{yii_createurl c=house a=list}{/if}" class="h-item-left icon-angle-left"></a>
    <!-- <a href="javascript:;javascript:history.back()" class="h-item-right  h-icon-th click-show-hide"></a> -->
    <div class="dialog-pic-icon" style="display: none;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="tab-nav tab-nav2 clearfix clearfloat" id="tab">
        <li class="active"><a href="{yii_createurl c=house a=detail house_id=$house_id}">项目介绍</a></li>
        <li><a href="{yii_createurl c=house a=purchaseRights house_id=$house_id}">认购权益</a></li>
        <li><a href="{yii_createurl c=house a=contractList house_id=$house_id}">合同公示</a></li>
        <li><a href="{yii_createurl c=house a=orderList house_id=$house_id}">认购记录</a></li>
    </ul>
</header>
<section class="h-index">
    <!-- 空div 站位-->
    <div class="nomovebox1"> </div>
    <!-- 选项卡 -->
    <div id="panel">
        <div>
            <div class="h-item-imgbox">
                <p class="h-item-iconbox">
                    {if $houseDetail.is_sell ==0}
                        <span>展示中</span>
                    {elseif $houseDetail.is_sell ==1}
                        <span>认购中</span>
                    {elseif $houseDetail.is_sell ==2}
                        <span>已结束</span>
                    {/if}
                    <a id="share" href="javascript:;" class="h-item-shire"></a>
                    <a href="javascript:;" class="h-item-{if $isFavorite =='fail'}heard{else}heardred{/if}" onclick="c_favorite(2,{$houseDetail.house_id}, this,{$customer_id})"></a> 
                </p>
                <a href="{yii_createurl c=house a=photos house_id=$house_id}" id="photo">
                    <img src="{$houseDetail.house_thumb}" class="img-responsive" data-src="holder.js/100%x225/auto/sky" alt="">
                </a>
                <div class="h-item-iconbox2">
                    <h4 class="h-item-imgh4">{$houseDetail.house_name} {$houseDetail.house_type} </h4>
                    <p class="h-item-imgp">
                        <span>{$houseDetail.province.sys_region_name} {$houseDetail.county.sys_region_name}</span>
                        <span>{floatval($houseDetail.house_area)}平米</span>
                        <span class="h-right">{if $houseDetail.house_price|intval > 0}{$houseDetail.currency_code}{floatval($houseDetail.house_avg_price)}万/份{else}待定{/if}</span>
                    </p>
                </div>
            </div>
            {if $houseDetail.is_sell !=0}
                <ul class="h-item-imgul clearfix">
                    <li class="h-xs-3"><span class="h-item-grey">已完成</span><span class="h-item-color">{yii_formatpercent percent=$houseDetail.ratio decimals=2}%</span></li>
                    <li class="h-xs-3"><span class="h-item-grey">已筹金额</span><span class="h-item-color">{$houseDetail.price_total}万</span></li>
                    <li class="h-xs-3"><span class="h-item-grey">剩余时间</span><span class="h-item-color">{$houseDetail.remaining_time}天</span></li>
                    <li class="h-xs-3"><span class="h-item-grey">剩余份数</span><span class="h-item-color">{$houseDetail.surplus_item_total}份</span></li>
                </ul>
            {/if}

            {if !empty($houseDetail.house_short_desc)}
                <div class="clearfix mg-t10 mg-b10 h-container">
                    <div class="h-grade-info clearfix">
                        <h3 class="nickname ">项目简介</h3>
                        <p class="pd-10 grey6e">{$houseDetail.house_short_desc|truncate:50:"...":true}</p>
                        <a href="{yii_createurl c=house a=introduction house_id=$house_id}" class="nickname2">查看更多简介<span class="h-right icon-angle-right"></span></a>
                    </div>
                </div>
            {/if}

            {foreach from=$attributes key=id item=i}
                {if !empty($i.attribute_values)}
                    <div class="clearfix mg-t10 mg-b10 h-container">
                        <div class="clearfix">
                            <h3 class="nickname ">{$i.attribute_name}</h3>
                            <ul class="pd-10 grey6e clearfix h-item-infor">
                                {foreach from=$i.attribute_values key=myId item=type}
                                    <li class="h-col-2">{$type.name}：{$type.attribute_value}</li>
                                    {/foreach}
                            </ul>
                        </div>
                    </div>
                {/if}
            {/foreach}

            {if !empty($estateAgent.estate_agent_name)}
                <div class="clearfix mg-t10 mg-b10 h-container">
                    <div class="h-grade-info clearfix">
                        <h3 class="nickname">开发商</h3>
                        <p class="pd-10 grey6e">{$estateAgent.estate_agent_name}</p>
                    </div>
                </div>
            {/if}

            {if !empty($houseDetail.lbs_desc)}
                <div class="clearfix mg-t10 mg-b10 h-container">
                    <div class="h-grade-info clearfix">
                        <h3 class="nickname">地理位置</h3>
                        <p class="pd-10 grey6e">{$houseDetail.lbs_desc}</p>
                        <p class="pd-10 grey6e"> <img src="{$houseDetail.lbs_desc_img}" width="100%" data-src="holder.js/100%x250/auto/sky" alt=""></p>
                    </div>
                </div>
            {/if}

            {if !empty($assetCompany)}
                <div class="clearfix mg-t10 mg-b10 h-container">
                    <div class="h-grade-info clearfix">
                        <h3 class="nickname ">资产管理方</h3>
                        <p class="pd-10 grey6e">{$assetCompany.company_name}</p>
                        <a href="{yii_createurl c=house a=assetCompany house_id=$house_id}" class="nickname2">查看更多简介<span class="h-right icon-angle-right"></span></a>
                    </div>
                </div>
            {/if}

            {if $houseDetail.is_sell !=0 && $houseDetail.surplus_item_total !=0 &&  $houseDetail.is_sell !=2 && $sellstatus==1}
                <div>
                    <!-- 空div 站位-->
                    <div class="nomovebox2"> </div>
                    <div class="h-item-btnbox" id="itembtnbox">
                        <a href="{yii_createurl c=house a=placeOrder house_id=$house_id}" class="h-item-btn mg-t10">立即认购</a>
                        <!-- {if $hasSaleCompany}
                        <button id="lbsBtn" class="h-item-btn mg-t10">联系身边经纪人</button>
                        {/if} -->
                    </div><!-- / -->
                </div><!-- / -->
            {/if}

        </div>
    </div>
    <div class="share_contain">
        <div class="title"><span>分享到</span></div>
        <div class="jiathis_style_32x32">
            <div>
                <a class="copyBtn" title="复制网址" href="#" data-soj="copy"></a>
                <a class="copyBtn descr" href="#" title="复制网址" data-soj="copy">长按复制网址</a>
            </div>
            <div>
                <a class="jiathis_button_qzone" data-soj="qq" >

                </a>
                <a class="jiathis_button_qzone nobg" data-soj="qq">QQ空间</a>
            </div>
            <div>
                <a class="jiathis_button_cqq"></a>
                <a class="jiathis_button_qzone nobg" data-soj="qq">QQ好友</a>
            </div>
            <div>
                <a class="jiathis_button_tsina" data-soj="xlwb">

                </a>
                <a class="jiathis_button_tsina nobg" data-soj="xlwb">新浪微博</a>
            </div>
            <div>
                <a class="jiathis_button_tqq" data-soj="txwb">

                </a>
                <a class="jiathis_button_tqq nobg" data-soj="txwb">腾讯微博</a>
            </div>
            <div>
                <a class="jiathis_button_renren" data-soj="renren">

                </a>
                <a class="jiathis_button_renren nobg" data-soj="renren">人人网</a>
            </div>
        </div>
        <input type="button" value="取 消" class="jiathis_button">
    </div>
</section>
