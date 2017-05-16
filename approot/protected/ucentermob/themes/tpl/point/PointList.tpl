<section class="main-section">
		{if $curmontharr}
		<div class="container h-myint2-head clearfix">
            <div class="clearfix h-myint2-info pd-b10">
                <h3 class="h-myint2-date">本月</h3>
                {foreach from=$curmontharr item=i}
                <dl class="h-myintegral-box">
                    <dt>{$i.create_time|date_format:"%Y-%m-%d"}</dt>
                    <dd class="h-myint-dd2">{$i.description}</dd>
                      <dd>{if $i.operate_type==1}+{else}-{/if}{$i.rule_point}</dd> 
                     <!--<dd>{if  $i.operate_type==1}+{$i.rule_point}{else if $i.operate_type==3}+{$i.rule_point}&nbsp;(冻结){/if}</dd>-->
                </dl>
                {/foreach}
            </div>
        </div>
        {/if}
        {if $newothermontharr}
        		{foreach from=$newothermontharr key=myId item=i}
                    <div class="container h-myint2-head clearfix">
                        <div class="clearfix h-myint2-info pd-b10">
                            <h3 class="h-myint2-date">{$myId}</h3>
                            {foreach from=$i item=j }
                            <dl class="h-myintegral-box">
                                <dt>{$j.create_time|date_format:"%Y-%m-%d"}</dt>
                                <dd class="h-myint-dd2">{$j.description}</dd>
                                <dd>{if $j.operate_type==1}+{else}-{/if}{$j.rule_point}</dd>
                            </dl>
                            {/foreach}
                        </div>
                    </div>
				{/foreach}
        {/if}
</section>
