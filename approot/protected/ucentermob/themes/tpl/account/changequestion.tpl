<section class="main-section">
    <form action="#" id="old_ques">
        <ul class="h-form h-login-form">
            <li class="h-bordernone">
                <h3 class="h-weight">安全问题</h3>
            </li>
            <li class="h-bordernone">
                <div class="">
                    {$question.question_text}
                    <a href="{yii_createurl c=account a=resetQuestion}" class="h-right mg-t10 orange">忘记答案</a>

                </div>

            </li>
            <li>
                <div class="status status2">
                    <input type="text" placeholder="答案字符长度不能超过15个字符" name="answer" maxlength="30" value="" id="old_answer" class="h-check">
                    {*<input type="text" name="" maxlength="15" value="" class="h-check" placeholder="答案字符长度不能超过15个字符">*}
                </div>
            </li>
            <li class="h-bordernone">
                {*<input class="btn-orange100" type="submit" name="" value="确认">*}
                <input class="btn-orange100" type="submit" name="" value="确认" id="btn">
            </li>
        </ul>
    </form>
</section>
