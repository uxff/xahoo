<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/myreward.css" />
<div class="myreward-money">
	<span class="ye">余额</span>
	<span class="money">
		￥{number_format($last_cash, 2)}
	</span>
	<span class="name">{$data.wx_nickname}</span>
	<ul class="nav">
		<li>
			<span class="num">
				{$data.fans_total * 1}人
			</span>
			<span class="gray">总粉丝</span></li>
			<li><a class="line"></a>
		</li>
		<li>
			<span class="num">
				{$data.fans_first * 1}人
			</span>
			<span class="gray">直接粉丝</span>
		</li>
		<li><a class="line"></a></li>
		<li>
			<span class="num">
				{$data.fans_second * 1}人
			</span>
			<span class="gray">间接粉丝</span>
		</li>
	</ul>
</div>
<ul class="myreward-list">
	<li>
		<a href="{yii_createurl c=MyHaibao a=rewardrecord}">
			<span class="fl">
				<i class="iconfont icon-zuanshi"></i>奖励记录
			</span> 
			<span class="fr">
				{number_format($data.total.money_gain, 2)}元
				<i class="iconfont icon-jiantou"></i>
			</span>
		</a>
	</li>
	<li>
		<a href="{yii_createurl c=WithdrawCash a=record}">
			<span class="fl">
				<i class="iconfont icon-qianbao"></i>提现记录
			</span> 
			<span class="fr">
				{number_format($data.total.money_withdraw, 2)}元
				<i class="iconfont icon-jiantou"></i>
				
			</span>
		</a>
	</li>
	<li>
		<a href="{yii_createurl c=MyHaibao a=activityrule}">
			<span class="fl">
				<i class="iconfont icon-fenlei"></i>活动规则
			</span> 
			<span class="fr">
				<i class="iconfont icon-jiantou"></i>
			</span>
		</a>
	</li>
</ul>
<div class="myreward-btn">
<input type="hidden" class="min-cash" name="" value="最低提现金额{$data.withdraw_min}元">
{if $last_cash le 0 || $last_cash lt $data.withdraw_min}
<!--小于最低提现金额不能提现-->
<a href="javascript:;" class="btn lot-btn min-cashBtn">提现</a>
{else}
<a href="{yii_createurl c=WithdrawCash a=index}" class="btn lot-btn">提现</a>
{/if}
</div>
<section class="cash-pop"></section>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
        data-config="../../conf/coolie-config.js"
        data-main="../main/myreward_main.js"></script>