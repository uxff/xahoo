{if $error != ''}
    <section class="msg-container hidden">
            <div class="h-alert h-alert-danger">
                    <button type="button" class="h-close">×</button>
                    <p>{$error}</p>
            </div>
    </section>
{/if}
<section class="main-section">
        <form action="{yii_createurl c=account a=confirm}" method="post" name="frm" id="security_question">
                <ul class="h-form">
                        <li>
                                <label class="label" for="">密保问题</label>  
                                <div class="status">
                                        <input type="text" name="ConfirmQuestion" value="{$question}" readonly/>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保答案</label>  
                                <div class="status">

                                        <input type="text" placeholder="答案长度不超过15个字" name="SecurityQuestion[answer]" maxlength="30" value="">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora-line" type="submit" name="" value="保存">
                        </li>
                </ul>  
        </form>
</section>
