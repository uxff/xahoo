<div class="container">
	<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/integral.css" />
	<section class="task-list">
		<div class="add_friend">使用Xahoo网站获得积分
			<div class="gain"><a href="{yii_createurl c=lizhuan a=index}">去赚积分</a><span class="iconfont">&#xe600;</span></div>
		</div>
		<div class="integral_table">
			<table cellpadding="0" cellspacing="0" border="0">
				<thead>
					<tr>
						<th width="80%">活动</th>
						<th width="20%">积分</th>
					</tr>
				</thead>
				<tbody>
					{if (!empty($arrData))}
					{foreach from=$arrData key=i item=objModel}
					<tr>
						<td>{$objModel.rule_name}</td>
						<td>{if $objModel.points}+{$objModel.points}{else}{$objModel.points_desc}{/if}</td>
					</tr>
					{/foreach}
					{/if}
				</tbody>
			</table>
		</div>
	</section>
	
</div>
	