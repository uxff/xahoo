<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/record.css" />
<section class="record">
{foreach from=$listData key=lk item=lv}
	<div class="record_item">
		<div class="fl">
			<p class="record_title">{$lv.remark}</p>
			<p class="record_time">{$lv.create_time}</p>
		</div>
		<div class="fr">
			<p class="record_price">{$lv.money}元</p>
		</div>
	</div>
{/foreach}
</section>