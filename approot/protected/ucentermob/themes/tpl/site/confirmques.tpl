<section class="main-section">
        <div class="h-alert h-alert-danger"{if $error == ''}style="display: none"{/if} onclick="delErrorInfo()">
                <button type="button" class="h-close">×</button>
                <h4>错误提示：</h4>
                <p>{$error}</p>
        </div>
        <form action="{yii_createurl c=site a=FindPasswordByQuestion return_url=$return_url}" method="post" name="frm" id="questions_confirm">
                <input type="text" name="SecurityQuestion[member_id]" hidden value="{$arrData.member_id}"/>
                <ul class="h-form">
                        <li>
                                <label class="label" for="">密保问题1</label>
                                <div class="status">
                                        <input type=" text" value="{$arrData.question_1.question_text}" disabled/>
                                        <input type=" text" value="{$arrData.security_question_id_1}" name="SecurityQuestion[security_question_id_1]" hidden/>

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
                                        <input type=" text" value="{$arrData.question_2.question_text}" disabled/>
                                        <input type=" text" value="{$arrData.security_question_id_2}" name="SecurityQuestion[security_question_id_2]" hidden/>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保答案2</label>
                                <div class="status">

                                        <input type="text" placeholder="" name="SecurityQuestion[answer_2]" maxlength="30" value="" id="answer_2">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保问题3</label>
                                <div class="status">
                                        <input type=" text" value="{$arrData.question_3.question_text}" disabled/>
                                        <input type=" text" value="{$arrData.security_question_id_3}" name="SecurityQuestion[security_question_id_3]" hidden/>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">密保答案3</label>
                                <div class="status">

                                        <input type="text" placeholder="" name="SecurityQuestion[answer_3]" maxlength="30" value="" id="answer_3">
                                </div>
                        </li>
                        <li>
                                <input class="btn-ora-line" type="submit" value="保存">

                        </li>
                </ul>
        </form>
</section>