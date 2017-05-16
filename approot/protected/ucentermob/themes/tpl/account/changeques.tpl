<section class="msg-container" style="display: none">
    <div class="h-alert h-alert-danger">
        <button type="button" class="h-close">×</button>
        <p></p>
    </div>
</section>
<section class="main-section">
    <form action="" id="set_new_ques">
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
                    <!-- <i href="" class="icon-angle-right"></i> -->
                </div>

            </li>
            <li>
                <div class="status status2">
                    <input type="text" name="SecurityQuestion[answer]" maxlength="15" value="" id="answer"  class="h-check" placeholder="答案字符长度不能超过15个字符">
                </div>
            </li>
            <li class="h-bordernone">
                <div>手机号：{$member_mobile}</div>
            </li>
            <li>
                <div class="status status2">
                    <input type="text" value="{$member.member_mobile}"  hidden id="username"/>
                    <input type="text" name="" maxlength="16" value="" class="h-check" id="code"  placeholder="请输入验证码" >
                    <input type="button" name="" onclick="settime(this)" value="获取验证码" class="h-signin-btn h-signin-btn2">
                </div>
            </li>
            <li class="h-bordernone">
                <input class="btn-orange100" type="button" name="" value="确认" onclick="r_submit()" id="btn">
            </li>
            <!--<li class="h-bordernone">
                <span class="h-fs12">温馨提示：<br>通过您设置的问题，帮助找回中弘众筹交易密码等。</span>
            </li>-->
        </ul>
    </form>
</section>