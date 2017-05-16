 

{if !empty($arrMsgStack)}
        <section class="msg-container">
                <div class="h-alert h-alert-danger">
                        <button type="button" class="h-close">&times;</button>
                        {foreach from=$arrMsgStack key=msgType item=msgText}
                                <p>{$msgText}</p>
                        {/foreach}
                </div>
        </section>
{else}
        <section class="msg-container" style="display:none">
                <div class="h-alert h-alert-danger">
                        <button type="button" class="h-close">&times;</button>
                        <p></p>
                </div>
        </section>
{/if}

<section class="main-section">
        <form action="{yii_createurl c=profile a=avatar}" class="h-name-form" method="post" name="frm" enctype="multipart/form-data">
                <ul class="h-form h-upimg">
                        <li>
                                <span class="tit">选择图片</span>  
                                <input type="file"  name="photo" id="photo" accept="image/*" onchange="preImg(this.id, 'imgPre');">

                        </li>
                        <li class="nobord-b">
                                {if $member_avatar}
                                        <img id="imgPre" src="{$member_avatar}"/>
                                {else}
                                        <img id="imgPre" src="{$resourcePath}/imgs/h-per-head.png"/>
                                {/if}
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" type="submit" name="" value="保存">
                        </li>
                </ul>  
        </form>
</section>
