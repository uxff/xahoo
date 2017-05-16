{if $gShowHeader}
        <header class="header">
                <p class="h-top">{if !empty($headerTitle)}{$headerTitle}{/if}</p>
                 <!-- {if !empty($return_url)}<a href="{$return_url}" class="icon-angle-left"></a>{/if} -->
                {if empty($userUrl) }
                        <a href="{$urlReferrer}" class="icon-angle-left"> </a>
                {else}
                        <a href="{$userUrl}" class="icon-angle-left"> </a>
                {/if}
                <!--
                <a href="javascript:;" onclick="toggleKey();" class="h-icon-th"></a>
                <nav class="h-navcl clearfix" id="navcl">
                        <a href="{yii_createurl c=site a=index}">
                                <i class="h-icon-home"></i><br/>
                                首页
                        </a>
                        <a href="{yii_createurl c=task a=index}">
                                <i class="h-icon-money"></i><br/>
                                立赚
                        </a>
                        <a href="{yii_createurl c=member a=index}">
                                <i class="h-icon-user"></i><br/>
                                我的
                        </a>
                </nav>
                -->
        </header>
{/if}