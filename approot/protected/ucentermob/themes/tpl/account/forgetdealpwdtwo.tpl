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
        <form action="{yii_createurl c=account a=forgetdealpwdthree}" method="post" name="frm">
                <input type="hidden" name="answer" value="{$answer}" />
                <ul class="h-form">
                        <li>
                                <label class="label" for="">身份证号</label>  
                                <div class="status">

                                        <input type="text" placeholder="输入身份证号" name="member_id_number" id="member_id_number" maxlength="18" value="">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-orange100" type="button" onClick="r_submit()" value="下一步">
                        </li>
                </ul>  
        </form>
</section>
