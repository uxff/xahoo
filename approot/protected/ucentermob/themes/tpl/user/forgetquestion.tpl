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
        <form action="{yii_createurl c=site a=findpasswordbyquestion return_url=$return_url}" method="post" name="frm" class="h-log-form" id="frm">
                <ul class="h-form h-login-form">
                        <li>
                                <label class="label" for="">帐号</label>
                                <div class="status">
                                        <input type="text" maxlength="26" name="username" id="username">
                                        <input type="text" name="member_id" hidden id="member_id" value=""/>
                                </div>
                        </li>
                        <li class="h-bordernone h-gray">
                                <a href="{yii_createurl c=site a=forgetmobile}" class="h-left">手机找回</a><span class="h-left">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href="{yii_createurl c=site a=forgetemail}" class="h-left">邮箱找回</a>
                        </li>
                        <li class="h-bordernone">
                                <input class="btn-ora-line" type="button" value="找回密码" onclick="javascript:void(0)">
                        </li>
                </ul>  
        </form>
</section>