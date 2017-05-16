
{*<section>*}
{*<form action="{yii_createurl c=account a=setQuestion}" method="post"  name="frm" id="security_question">*}
{*<ul class="h-form">*}
{*<li>*}
{*<label class="label" for="">密保问题</label>  *}
{*<div class="status">*}
{*<input type="text" hidden name="member_id" value="{$member_id}"/>*}
{*<select name="SecurityQuestion[question]" id="sel">*}
{*{foreach from=$questions key=i item=q}*}
{*<option value="{$q.id}">{$q.question_text}</option>*}
{*{/foreach}*}
{*</select>*}
{*</div>*}
{*</li>*}
{*<li>*}
{*<label class="label" for="">密保答案</label>  *}
{*<div class="status">*}
{**}
{*<input type="text" placeholder="答案长度不超过15个字" name="SecurityQuestion[answer]" maxlength="30" value="" id="answer">*}
{*</div>*}
{*</li>*}
{*<li>*}
{*<input class="btn-ora-line" type="submit" name="" value="保存" id="sub">*}
{*</li>*}
{*</ul>  *}
{*</form>*}
{*</section>*}
<section class="main-section">
        <form action="{yii_createurl c=account a=setQuestion}" method="post"  name="frm" id="security_question">
                <ul class="h-form h-login-form">
                        <li class="h-bordernone">
                                <h3 class="h-weight">新问题</h3>
                        </li>
                        <li>
                                <div class="status status2">
                                        <input type="text" hidden name="member_id" value="{$member_id}"/>
                                        <select name="SecurityQuestion[question]" id="sel">
                                                {foreach from=$questions key=i item=q}
                                                    <option value="{$q.id}">{$q.question_text}</option>
                                                {/foreach}
                                        </select>
                                        {*<i href="" class="icon-angle-right"></i>*}
                                </div>

                        </li>
                        <li>
                                <div class="status status2">
                                        <input type="text" placeholder="答案长度不超过15个字" name="SecurityQuestion[answer]" maxlength="30" value="" id="answer">
                                </div>
                        </li>

                        <li class="h-bordernone">
                                <input class="btn-orange100" type="submit" name="" value="确认">
                        </li>
                        <li class="h-bordernone">
                                <span class="h-fs12">温馨提示：<br>通过您设置的问题，帮助找回中弘众筹交易密码等。</span>
                        </li>
                </ul>
        </form>
</section>
