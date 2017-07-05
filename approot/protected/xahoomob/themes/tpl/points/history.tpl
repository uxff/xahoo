<div class="container">
	<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/integral.css" />
	<section class="task-list list-tab" name="all-points">
		{if !empty($pointsHistory)}
			{foreach from=$pointsHistory key=key item=item}
				<div class="integral_con grp-{$key}">
					<div class="integral_tl">{$key}</div>
					{foreach from=$item item=list}
						<a class="integral_item">
							<div class="fl">
								<p class="ig_tl">{$list.remark}</p>
								<p class="ig_time">{$list.last_modified}</p>
							</div>
							<div class="fr"><span class="{$list.class}">{$list.points}</span></div>
						</a>
					{/foreach}
				</div>
			{/foreach}
		{/if}
	</section>
	
</div>
<script coolie src="../../../../../resource/xahoo3.0/js/lib/coolie/coolie.min.js"
	data-config="../../conf/coolie-config.js"
	data-main="../main/mypoints_main.js"></script>
<script>
	var url = '{yii_createurl c=myPoints a=AjaxGetPointsList}';
	var resource_path = '{$resourcePath}';
</script>