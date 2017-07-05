		<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/record.css" />
		<section class="record present">
        {if $datas}
            {foreach from=$datas key=k item=record}
			<div class="record_item">
				<div class="fl">
					<p class="record_title">提现</p>
					<p class="record_time">{$record['last_modified']}</p>
				</div>
				<div class="fr">
					<p class="record_price">{$record['withdraw_money']}元</p>
                    {if $record['status'] == 1}
					   <p class="record_tip record_on">审核中</p>                    
                    {elseif $record['status'] == 2}
					   <p class="record_tip record_on">审核不通过</p>                    
                    {elseif $record['status'] == 3}
					   <p class="record_tip record_on">审核中</p>                    
                    {elseif $record['status'] == 4}
					   <p class="record_tip record_on">已完成</p>                         
                    {/if}
				</div>
			</div>
            {/foreach}
        {else}
            <div class="record_item">
				<div class="fl">
					<p class="record_title">暂无提现记录</p>
				</div>
			</div>
        {/if}
		</section>
