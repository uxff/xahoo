<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/integral.css" />
<section class="task-list">
	<div class="add_friend"><a href="{yii_createurl c=my a=invitefriend}"><span class="iconfont add_icon">&#xe605;</span>新的朋友</a></div>
	<h3 class="exchange_tl">我的好友</h3>


	<div class="friend_con list-tab" name="all-friends">
		{foreach from=$friends['list'] item=friendObj}
		<a href="javasrcipt:;" class="friend_item">
			<div class="fl friend_icon">
                {if !empty($friendObj['member_avatar'])}
				<img src="{$friendObj['member_avatar']}" alt="" coolieignore>
                {else}
				<img src="../../../../../resource/fanghu2.0/images/integral/friend_icon.png" alt="">
                {/if}
			</div>
			<div class="fl">
				<p class="friend_name">{$friendObj['member_fullname']}</p>
				<p class="friend_phone">{$friendObj['member_mobile']}</p>
			</div>
		</a>
		{/foreach}
	</div>
</section>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
	data-config="../../conf/coolie-config.js"
	data-main="../main/myfriend_main.js"></script>
<script>
	var url = '{yii_createurl c=my a=ajaxMyFriend}';
	var resource_path = '{$resourcePath}';
</script>
