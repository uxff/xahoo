{if $gShowFooter}
        <footer class="h-foot">
                {if $gIsGuest}
                        <div class="h-foot1"><a href="{yii_createurl c=user a=login return_url=$return_url}">登录</a> | <a href="{yii_createurl c=user a=register}">注册</a> <a href="{$mobHelpAboutUrl}" class="h-foot2">关于我们</a></div>
                {else}
                    <div class="h-foot1">
                        <span style="color:#333333"><a href="{$userUrl}">{$member_nickname}</a> |</span>
                        <a href="{yii_createurl c=user a=logout}">退出登录</a>
                        <a href="{$mobHelpIndexUrl}" class="h-foot2">帮助中心</a>
                        <a href="{$mobHelpAboutUrl}" class="h-foot2">关于我们　|　</a>
                    </div>
                {/if}
                <div class="h-foot3">
                        <p>
                            <a href="#">手机版</a>  <font color='#000'>|</font>
                            <!--<a href="{yii_createurl c=pageView a=appDownload}">客户端</a> |
                            --><a href="http://www.xqshijie.com">电脑版</a>
                        </p>
                        <p class="h-ICP">Copyright ©{$smarty.now|date_format:'%Y'} xqshijie.com 津ICP备16004915号-3<!--京ICP备 14029702-3号--></p>
                </div>
        </footer>
        {literal}
            <script>
                var backToTop = function() {
                    $('html,body').scrollTop('0px');
                }
            </script>
        {/literal}
{/if}
