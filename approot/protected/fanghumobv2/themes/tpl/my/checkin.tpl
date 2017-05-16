
<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/edit.css" />
<!--/coolie-->
<section class="task-list">
    <div class="check">
        <div class="check_jf">我的积分<br/><span>{$totalInfo.points_total*1}</span></div>
        <div class="check_box">
            <a href="{yii_createurl c=my a=submitcheckin token=$csrfToken}">
            <span class="check_tl">{if $isCheckedToday}已签到{else}签 到{/if}</span><br/><span class="hr"></span>
            </a>
            <br/>
            <span class="check_des">连续{$theContinuedNum*1}天</span>
        </div>
        <div class="day_list">
            {foreach from=$arrFutrueDays key=k item=checkOnce}
            <div class="day_item {$checkOnce['css']}">
                <span class="day_bot"></span><i class="day_time">{$checkOnce['dayShort']}</i>
            </div>
            {/foreach}
        </div>
    </div>
    <div class="index-list">
        <h2>热门推荐</h2>
        <ul>
            {foreach from=$hotArtModels key=k item=hotArtModel}
            <li>
                <a href="{$hotArtModel.url}" target="_blank">
                <img src="{$hotArtModel.surface_url}" coolieignore/>
                </a>
                <p class="fl">{$hotArtModel.title}</p>
                <span class="fr"><font>{$hotArtModel.tips}</font></span>
            </li>
            {/foreach}
        </ul>
    </div>
</section>
