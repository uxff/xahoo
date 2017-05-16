{if !empty($arrMsgStack)}
    <section class="msg-container" style="display: none">
            <div class="h-alert h-alert-danger">
                    <button type="button" class="h-close">&times;</button>
                    {foreach from=$arrMsgStack key=msgType item=msgText}
                        <p id="errMsg">{$msgText}</p>
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
        <form action="{yii_createurl c=account a=addTradingPlatformForm}" method="post" id="bindTradingPlatform">
                <ul class="h-add-form">
                        <li> 
                                <div class="status status2">
                                        真实姓名：
                                    <span class="telspan">{substr_replace($objMember.member_fullname, '*', 3 , 3)}</span>
                                    <input type="text" name="BindPlatform[real_name]" value="{$objMember.member_fullname}" hidden/>
                                </div>
                        </li>
                        <li> 
                                <div class="status">
                                        选择支付平台：
                                        <select name="BindPlatform[platform_type]" class="sel" id="platformType">
                                                <option value="1">支付宝</option>
                                        </select>
                                        <!-- <i href="" class="icon-angle-right"></i> -->
                                </div>
                        </li>
                        <li> 
                                <div class="status">
                                        平台账号：
                                        <input type="text" name="BindPlatform[platform_account]" id="platformAccount" maxlength="15" value="" class="h-check">
                                </div>
                        </li>
                        <li class="status status2">
                            手机号码：
                            <span class="telspan">{substr_replace($objMember.member_mobile, '****', 3, 4)}</span>
                            <input type="text" id="mobile" name="BindPlatform[member_mobile]" value="{$objMember.member_mobile}" hidden/>
                        </li>
                        <li>
                                <div class="status">
                                        验证码：
                                        <input type="text" name="BindPlatform[code]" maxlength="16" value="" id="code" class="h-check" placeholder="请输入验证码">
                                        <input type="button" name="" value="获取验证码" onclick="settime(this)" class="h-signin-btn">
                                        <!-- <input type="button" name="" value="39秒后重新发" class="h-signin-btn h-grey-bg"> -->
                                </div>
                        </li>
                        <li class="h-bordernone">
                                <input class="btn-orange100" type="button" id="bindTradingPlatformBtn" name="" value="提交">
                        </li>
                </ul>  
        </form> 
</section>