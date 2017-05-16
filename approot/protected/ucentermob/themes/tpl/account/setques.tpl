<section class="main-section">
        <form action="{yii_createurl c=account a=setQuestions}" method="post" name="frm" id="security_question">
                <input type="text" name="SecurityQuestion[member_id]" hidden value="{$member_id}"/>
                <ul class="h-form">
                        <li>
                                <label class="label" for="">密保问题1</label>
                                <div class="status">
                                        <select name="SecurityQuestion[security_question_id_1]" id="sel_1" sort="1">

                                        </select>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保答案1</label>
                                <div class="status">
                                        <input type="text" placeholder="" name="SecurityQuestion[answer_1]" maxlength="30" value="" id="answer_1">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保问题2</label>
                                <div class="status">
                                        <select name="SecurityQuestion[security_question_id_2]" id="sel_2" sort="2">

                                        </select>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保答案2</label>
                                <div class="status">

                                        <input type="text" placeholder="" name="SecurityQuestion[answer_2]" maxlength="30" value="" id="answer_2" answer_type="">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保问题3</label>
                                <div class="status">
                                        <select name="SecurityQuestion[security_question_id_3]" id="sel_3" sort="3">

                                        </select>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保答案3</label>
                                <div class="status">

                                        <input type="text" placeholder="" name="SecurityQuestion[answer_3]" maxlength="30" value="" id="answer_3" answer_type="">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora-line" type="submit" value="保存" id="security_sub">

                        </li>
                </ul>
        </form>
</section>