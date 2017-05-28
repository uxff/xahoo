{if $gShowFooter}
		<footer class="footer">
            {if $gIsGuest}
			<ul>
				<li><a href="{yii_createurl c=user a=login}">登录</a></li>
				<li><a class="active" href="{yii_createurl c=user a=register}">注册</a></li>
				<li><a href="{yii_createurl c=site a=aboutus}">关于我们</a></li>
			</ul>
            {else}
			<ul>
				<li><span style="color:#333333;"><a href="{yii_createurl c=my a=index}">{$member_nickname}</a></span></li> 
				<li><a href="{yii_createurl c=my a=logout logout_return_url=$logout_return_url}">退出登录</a></li>
				<li><a href="{yii_createurl c=site a=aboutus}">关于我们</a></li>
			</ul>
            {/if}
			<p>copyright@2014-{$smarty.now|date_format:'%Y'} 京ICP备15028464号-4</p>
		</footer>
{/if}
</div>
