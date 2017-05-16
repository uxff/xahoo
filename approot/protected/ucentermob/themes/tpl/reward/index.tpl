<section class="main-section">
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname"><i class="h-icon-comm"></i>当前佣金<span class="h-right orange"><a href="{$RuleUrl}">如何获得佣金</a> | <a href="{$CashUrl}">申请提现</a></span></h3>
                        <h2 class="h-myintegral-orange"><span class="small">￥</span>{$total_reward}</h2>
                </div>
        </div>
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname"><i class="h-icon-integral2"></i>佣金明细<a href="{$ListUrl}" class="h-right">查看全部</a></h3>
                </div>
                <div class="h-comm-detail">
                		<div class="panel-v2" id="panel" >
							<ul class="all" style="display:block">
									{if empty($arrRewardAll)}
                                        <!-- 没有佣金状态 -->
                                        <li class="nocomm">
                                            您还没有获得佣金哦，<br>
                                            推荐小伙伴看房，<a class="orange" href="{$FanghuUrl}">立赚佣金</a>！
                                        </li> 
                                    {else}
                                        {foreach from=$arrRewardAll item=i}
                                        <li class="listdash">
                                                <a class="detail clearfix">
                                                		{if $i.member.member_avatar}
                                                        	<img src="{$i.member.member_avatar}" height="40" width="40"/>
                                                        {else} 
                                                        	<img src="{$resourcePath}/imgs/h-per-head.png" height="40" width="40" alt="">
                                                        {/if}   
                                                        <div class="detail-body">
                                                                <h4 class="">
                                                                        <span class="tit">{$i.member.member_nickname}（{$i.degree}度小伙伴）</span>
                                                                        <strong class="comm">+{$i.reward_score}</strong>
                                                                </h4>
                                                                <p class="">{$i.last_modified|date_format:"%Y-%m-%d"}
                                                                        {if $i.status==1}<span class="state orange">等待结算</span>{/if}
                                                                        {if $i.status==2}<span class="state">获得佣金</span>{/if}
                                                                </p>
                                                        </div>
                                                </a>
                                        </li>
                                        {/foreach}
                                    {/if}
                                </ul>
                		</div>
                
                         
                         
                </div>
        </div>
		{*
        <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                        <h3 class="nickname"><i class="h-icon-change"></i>佣金活动</h3>
                        <img class="mg-t20" src="" data-src="holder.js/100%x50/auto/sky" alt="">
                        <img class="mg-t10" src="" data-src="holder.js/100%x50/auto/sky" alt="">
                </div>
        </div>
        *}
</section>