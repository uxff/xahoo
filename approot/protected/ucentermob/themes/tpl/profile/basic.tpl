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
        <form name="frm" action="{yii_createurl c=profile a=basic}" method="post" >
                <ul class="h-form">
						{*
                        <li>
                                <label class="label" for="">真实姓名</label>
                                <div class="status"> 
                                        <input type="text" name="member[member_fullname]" placeholder="请填写" id="member_fullname" value="{$MemberData['member_fullname']}">
                                </div>
                        </li>
                        *}
                        <li>
                                <label class="label" for="">性别</label>
                                <div class="status"> 
                                        <select name="member[member_gender]" id="member_gender">
                                                <option value="0" {if $MemberData['member_gender']==0}selected{/if}>请选择</option>
                                                <option value="1" {if $MemberData['member_gender']==1}selected{/if}>男</option>
                                                <option value="2" {if $MemberData['member_gender']==2}selected{/if}>女</option>
                                        </select>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">婚恋状态</label>
                                <div class="status"> 
                                        <select name="member[member_marriage_status]" id="member_marriage_status">
                                                <option value="0" {if $MemberData['member_marriage_status']==0}selected{/if}>请选择</option>
                                                <option value="1" {if $MemberData['member_marriage_status']==1}selected{/if}>未婚</option>
                                                <option value="2" {if $MemberData['member_marriage_status']==2}selected{/if}>已婚</option>
                                        </select>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">生日</label>
                                <div class="status">
                                        <input type="date" name="member[member_birthday]" id="member_birthday" value="{if $MemberData['member_birthday']!='0000-00-00'}{$MemberData['member_birthday']}{/if}"/>
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">QQ</label>
                                <div class="status"> 
                                        <input type="text" name="member[member_qq]" placeholder="请填写" id="member_qq" value="{$MemberData['member_qq']}">
                                </div>
                        </li>
                        <li class="no-bg">
                                <input class="btn-ora" type="button" onClick="r_submit()" value="保存">
                        </li>
                </ul>
        </form>
</section>
