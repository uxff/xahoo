{if !empty($message)}
        <section class="msg-container" style="">
                <div class="h-alert h-alert-danger">
                        <button type="button" class="h-close">&times;</button>
                        <p>{$message}</p>
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
        <form action="{yii_createurl c=account a=forgetdealpwdfour}" method="post" name="frm">
        		<input type="hidden" name="answer" value="{$answer}" />
                <input type="hidden" name="member_id_number" value="{$member_id_number}" />
                <ul class="h-form">
                        <li>
                                <label class="label" for="">设置密码</label>
                                <div class="status">
                                        <input type="password" placeholder="字母、数字、下划线或组合（6-18位）" name="new_password" id="newPwd" maxlength="18" value="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密码确认</label>
                                <div class="status">
                                        <input type="password" placeholder="字母、数字、下划线或组合（6-18位）" name='confirm_password' id="confirmPwd" maxlength="18" value="">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-orange100" type="button" onClick="r_submit()" value="下一步">
                        </li>
                </ul>
        </form>
</section>
