{if !empty($arrMsgStack)}
        <section class="msg-container" style="">
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
        <form name="frm" action="{yii_createurl c=profile a=nick}" method="post" >
                <ul class="h-form">
                        <li>
                                <label class="label" for="">昵称</label>
                                <div class="status"> 
                                        <input type="text" name="new_name" id="newName" value="{$nickName}">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" type="button" onClick="r_submit()" value="保存">
                        </li>
                </ul>
        </form>
</section>