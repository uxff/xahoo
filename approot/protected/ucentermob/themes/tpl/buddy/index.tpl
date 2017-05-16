<section class="h-friend">
        <div class="h-box-bgff-p10 profile clearfix">
                {if $parent_depth != 0}
                        <i class="level-{$parent_depth} mg-t10"></i>
                {/if}
                <a class="media-left" href="">
                		{if !empty({$member->member_avatar})}
                        <img src="{$member->member_avatar}" width="100px" height="100px"   alt="">
                        {else}
                         <img src="{$resourcePath}/imgs/h-per-head.png" width="100px" height="100px"  alt="">
                        {/if}
                </a>
                <div class="media-body">
                        <h3 class="nick">{$member->member_nickname}</h3>
                        <p class="info"><span>姓名：</span>{$member->member_fullname}</p>
                        <p class="info"><span>电话：</span>{$member->member_mobile}</p>
                        <!-- 当用户是2,3,4,5度时 -->
                        <!--  <p class="info"><span>姓名：</span>王**</p>
                        <p class="info"><span>电话：</span>158****1339</p> -->

                        <p class="info"><span>推荐人：</span>{if $member->parent_id==0}无{else}{$memberParent->member_fullname}{/if}</p>

                        <p class="info"><span>注册：</span>{$member->create_time|date_format:'%Y-%m-%d'}</p>
                </div>
        </div>


        <ul class="tab-v3 clearfix" id="tab">
                <li><a href="javascript:;">购买记录</a></li>
                <li class="active"><a href="javascript:;">{if $parent_depth==0}我的小伙伴{else}TA的小伙伴{/if}</a></li>
        </ul>

        <div id="panel">
                <!-- 购买记录 -->
                <ul class="h-buy-log paneldiv">
                		{if $parent_depth < 2}
                        <li>
                                <div class="tab-v4 clearfix" id="tab2">
                                        {*<a class="active" href="javascript:;">众筹<span class="num">（{$zc_total}）</span></a>*}
                                        <a class="active" href="javascript:;">逸乐通<span class="num">（{$fq_total}）</span></a>
                                        {*<a href="javascript:;">意向房源<span class="num">（{$fh_total}）</span></a>*}
                                </div>
                        </li>
                        <li id="panel2">
                                <!-- 众筹 -->
                                {*
                                <div class="h-log-panel pd-b55">
                                		{if empty($zc_data)}
                                        	<p class="nobuy">暂无购买记录！</p>
                                        {else}
                                            <div id="morewrap1">
                                                {foreach from=$zc_data item=i}
                                                <div class="log-item-box">
                                                        <a class="tit clearfix">
                                                                <strong>{$i['task_building']['task_title']}</strong>
                                                                <span>认购:2份</span>
                                                        </a>
                                                        <div class="log-item">
                                                                <dl class="imgbg">
                                                                        <dt class="begin line">
                                                                        <span class="ok">认购</span>
                                                                        <span class="date">{$i['statusdate3']}</span>
                                                                        </dt>
                                                                        {if $i['statusdate4']=='0000-00-00'}
                                                                            <dd class="end unok">清算</dd>
                                                                        {else}
                                                                            <dd class="end">
                                                                                    <span class="ok">清算</span>
                                                                                    <span class="date">{$i['statusdate4']}</span>
                                                                            </dd>
                                                                        {/if}
                                                                </dl>
                                                        </div>
                                                </div>
                                                {/foreach}
                                            </div>
                                            {if $zc_total>10}
                                            	<div class="clickmore" id="clickmore1" alt="{$zc_total}">点击加载更多</div>
                                            {/if}
                                        {/if}
                                         
										{if $parent_depth == 1}
                                        	<div class="h-fixed"><a class="btn-ora" href="">推荐其他众筹项目</a></div>
                                        {/if}
                                        
                                </div>
                                *}
                                <!-- h-log-panel -->
                                <!-- 分权 -->
                                <div class="h-log-panel">
                                		{if empty($fq_data)}
                                        	<p class="nobuy">暂无购买记录！</p>
                                        {else}
                                            <div id="morewrap2">
                                                {foreach from=$fq_data item=i}
                                                <div class="log-item-box">
                                                        <a class="tit clearfix">
                                                                <strong>{$i['task_building']['task_title']}</strong>
                                                                <span>认购:{$i['item_quantity']}份</span>
                                                        </a>
                                                        <div class="log-item">
                                                                <dl class="imgbg">
                                                                        <dt class="begin line">
                                                                        <span class="ok">签约</span>
                                                                        <span class="date">{$i['statusdate3']}</span>
                                                                        </dt>
                                                                        {if $i['statusdate4']=='0000-00-00'}
                                                                            <dd class="end unok">成交</dd>
                                                                        {else}
                                                                            <dd class="end">
                                                                                    <span class="ok">成交</span>
                                                                                    <span class="date">{$i['statusdate4']}</span>
                                                                            </dd>
                                                                        {/if}
                                                                </dl>
                                                        </div>
                                                </div>
                                                {/foreach}
                                            </div>
                                            {if $fq_total>10}
                                            	<div class="clickmore" id="clickmore2" alt="{$fq_total}">点击加载更多</div>
                                            {/if}
                                        {/if}
                                        <!-- log-item-box -->

                                </div><!-- h-log-panel -->
                                <!-- 意向房源 -->
                                {*
                                <div class="h-log-panel pd-b55">
                                		{if empty($fh_data)}
                                        	<p class="nobuy">暂无购买记录！</p>
                                        {else}
                                            <div id="morewrap3">
                                                {foreach from=$fh_data item=i}
                                                <div class="log-item-box">
                                                        <a class="tit clearfix" >
                                                                <strong>{$i['task_building']['task_title']}</strong>
                                                                <span>均价{$i['task_building']['building_price']}</span>
                                                        </a>
                                                        <div class="log-item">
                                                                <dl class="imgbg step4">
                                                                        <dd class="begin line step4">
                                                                                <span class="ok">预约</span>
                                                                                <span class="date">{$i['statusdate1']}</span>
                                                                        </dd>
                                                                        {if $i['statusdate2']=='0000-00-00'}
                                                                            <dd class="next2 unok">到访</dd>
                                                                        {else}
                                                                            <dd class="next2">
                                                                                    <span class="ok">到访</span>
                                                                                    <span class="date">{$i['statusdate2']}</span>
                                                                            </dd>
                                                                        {/if}
                                                                        {if $i['statusdate3']=='0000-00-00'}
                                                                            <dd class="next3 unok">签约</dd>
                                                                        {else}
                                                                            <dd class="next3">
                                                                                    <span class="ok">签约</span>
                                                                                    <span class="date">{$i['statusdate3']}</span>
                                                                            </dd>
                                                                        {/if}
                                                                        {if $i['statusdate4']=='0000-00-00'}
                                                                            <dd class="end unok">成交</dd>
                                                                        {else}
                                                                            <dd class="end">
                                                                                    <span class="ok">成交</span>
                                                                                    <span class="date">{$i['statusdate4']}</span>
                                                                            </dd>
                                                                        {/if}
        
                                                                </dl>
                                                        </div>
                                                </div>
                                                {/foreach}
                                            </div>
                                            {if $fh_total>10}
                                            	<div class="clickmore" id="clickmore3" alt="{$fh_total}">点击加载更多</div>
                                            {/if}
                                        {/if}
                                    
										{if $parent_depth == 1}
                                        	<div class="h-fixed"><a class="btn-ora" href="{$recommend_url}">推荐意向房源</a></div>
                                        {/if}
                                         
                                </div>
                                *}
                                <!-- h-log-panel -->
                        </li>
                        {else}
                        	<p class="nopower">抱歉，购买记录仅1度小伙伴可见！</p>
                        {/if}
                </ul>

                <!-- 我的小伙伴 -->
                <div class="paneldiv">
                    <ul class="fri-list" id="morewrap4">
                            {if empty($childrenlist)}
                                <p class="nopower">没有小伙伴！</p>	
                            {else}
                            {foreach from=$childrenlist item=i}
                                    <li>
                                            <i class="level-{$i.degree}"></i>
                                            <a class="media" href="{yii_createurl c=buddy a=index id=$i.member_id}">
                                                    <img class="media-left" {if !empty({$i.member_avatar})}src="{$i.member_avatar}"{else}src="{$resourcePath}/imgs/h-per-head.png"{/if}  width="50px" height="50px" alt="">
                                                    <div class="media-body">
                                                            <h4 class="nick">{$i.member_nickname}（{$i.member_fullname}）</h4>
                                                            <p class="log clearfix">
                                                                    <span>{$i.member_mobile}</span>
                                                                    <span>{if $i.status_time!='0000-00-00'}{$i.status_time}{/if}</span>
                                                                    <span>{if $i.status_value}{$i.status_value}{/if}</span>
                                                            </p>
                                                    </div>
                                            </a>
                                    </li>
                            {/foreach}
                            {/if}
                            
                    </ul>
                    {if $buddy_total>10}
                    <div class="clickmore" id="clickmore4" alt="{$buddy_total}">点击加载更多</div>
					{/if}	
                    <div class="h-fixed"><a class="btn-ora" href="{$friendinvite_url}">邀请小伙伴</a></div>
                </div>
        </div>
</section>