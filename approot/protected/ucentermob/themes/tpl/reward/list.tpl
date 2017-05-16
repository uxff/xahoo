<section class="main-section">
        <div class="container h-grade-head clearfix">
        		<div class="panel-v2" id="panel">
                                <ul class="all" style="display:block">
									{if empty($arrRewardAll)}
                                        <!-- 没有佣金状态 -->
                                        <li class="nocomm">
                                            您还没有获得佣金哦，<br>
                                            推荐小伙伴看房，<a class="orange" href="{$FanghuUrl}">立赚佣金</a>！
                                        </li> 
                                    {else}
                                    	<div id="morewrap1">
                                            {foreach from=$arrRewardAll item=i}
                                            <li class="listdash">
                                                    <a  class="detail clearfix">
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
                                        </div>
                                        {if $RewardMadeTotal>10}
                                        	<div class="clickmore" id="clickmore1" alt="{$RewardMadeTotal}">点击加载更多</div>
                                        {/if}
                                    {/if}
                                </ul>
                                
                                 

                        </div>
 
        </div>
</section>
