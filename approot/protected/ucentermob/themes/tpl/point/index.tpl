<section class="main-section">
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname"><i class="h-icon-integral"></i>当前积分<a href="{$PointRuleUrl}" class="h-right">如何获得积分</a></h3>
                        <h2 class="h-myintegral-orange">{$total_point}</h2>
                </div>
        </div>
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname h-myint-nickname"><i class="h-icon-integral2"></i>积分明细<a href="{$PointListUrl}" class="h-right">查看全部</a></h3>
                        {foreach from=$memberpointlog item=i}
                                <dl class="h-myintegral-box">
                                        <dt>{$i.create_time|date_format:"%Y-%m-%d"}</dt>
                                        <dd class="h-myint-dd2">{$i.description}</dd>
                                        <!--<dd>{if  $i.operate_type==1}+{$i.rule_point}{else if $i.operate_type==3}+{$i.rule_point}&nbsp;(冻结){/if}</dd>-->
                                         <dd>{if $i.operate_type==1}+{else}-{/if}{$i.rule_point}</dd/> 
                                </dl>
                        {/foreach}
                </div>
        </div>
        {*
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname"><i class="h-icon-change"></i>我的兑换<a href="#" class="h-right">去商场看看</a></h3>
                        <div class="h-myintegral-change">
                                <h3>您还没有兑换</h3>
                                <p>积分可以兑换各种实物礼物，还可以换取优惠券哦！</p>
                        </div>

                </div>
        </div>
        {*
        
        <div class="container h-grade-head clearfix">
        <div class="h-grade-info clearfix">
        <h3 class="nickname"><i class="h-icon-change"></i>我的兑换<a href="#" class="h-right">查看全部</a></h3>
        <ul class="clearfix h-myint-things">
        <li>
        <a href="#">
        <span class="h-myint-span"><i class="h-icon-things1"></i><i class="h-myint-num">23</i></span>
        已收藏商品
        </a>
        </li>
        <li>
        <a href="#">
        <span class="h-myint-span"><i class="h-icon-things2"></i><i class="h-myint-num">6</i></span>
        已兑换商品
        </a>
        </li>
        </ul>
        </div>
        </div>
        *}
        {*
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname"><i class="h-icon-active"></i>积分活动</h3>
                        <div class="h-myintegral-change">
                                <img data-src="holder.js/100%x50" alt="" class="pd-b5">
                                <img data-src="holder.js/100%x50" alt="" class="pd-b5">
                                <img data-src="holder.js/100%x50" alt="">
                        </div><!-- / -->

                </div>
        </div>
        *}
</section>