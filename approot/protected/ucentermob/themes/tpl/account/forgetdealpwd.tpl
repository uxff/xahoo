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
        <form action="{yii_createurl c=account a=forgetdealpwdtwo}" method="post" name="frm">
                <ul class="h-form h-login-form">
                        <li class="h-bordernone">
                                <div class="">
                                        {$question.question_text}
                                        <a href="{yii_createurl c=account a=resetQuestion}" class="h-right mg-t10 orange">忘记答案</a>
                                </div>

                        </li>
                        <li>
                                <div class="status status2">
                                        <input type="text" placeholder="答案字符长度不能超过15个字符" name="answer" maxlength="30" value="" id="answer" class="h-check">
                                        {*<input type="text" name="" maxlength="15" value="" class="h-check" placeholder="答案字符长度不能超过15个字符">*}
                                </div>
                        </li>
                        <li class="h-bordernone no-bg">
                                <input class="btn-orange100" type="button"  onClick="r_submit()" name="" value="下一步" >

                        </li>
                </ul>
        </form>
</section>
