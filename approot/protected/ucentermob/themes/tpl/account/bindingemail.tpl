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
        <form action="" method="post" name="frm">
                <ul class="h-form">
                        <li>
                                <label class="label" for="">绑定邮箱</label>  
                                <div class="status">
                                        <input type="email" placeholder="请输入绑定的邮箱" name="email" id="email" value="">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" onClick="r_submit()" type="button" value="发送验证邮件">
                        </li>
                </ul>  
        </form>
</section>