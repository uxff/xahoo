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
{if $arrMember.is_idnumber_actived==1}
    <section class="main-section">

            <ul class="h-form">
                    <li>
                            <label class="label" for="">真实姓名</label>  
                            <div class="status">
                                    <p class="grey999">{$arrMember.member_fullname}</p>
                            </div>
                    </li>
                    <li>
                            <label class="label" for="">身份证号</label>  
                            <div class="status">
                                    <p class="grey999">{$arrMember.member_id_number}</p>
                            </div>
                    </li>
            </ul>  

    </section>
{else}
    <section class="main-section">
            <form action="{yii_createurl c=account a=modid}" method="post" name="frm">
                    <ul class="h-form">
                            <li>
                                    <label class="label" for="">真实姓名</label>  
                                    <div class="status">
                                            <input type="text" placeholder="输入真实姓名" name="member_fullname" id="member_fullname" maxlength="30" value="{$arrMember.member_fullname}">
                                    </div>
                            </li>
                            <li>
                                    <label class="label" for="">身份证号</label>  
                                    <div class="status">

                                            <input type="text" placeholder="输入身份证号" name="member_id_number" id="member_id_number" maxlength="18" value="{$arrMember.member_id_number}">
                                    </div>
                            </li>
                            <li class="no-bg">
                                    <input class="btn-ora" type="button" onClick="r_submit()" value="保存">
                            </li>
                    </ul>  
            </form>
    </section>
{/if}