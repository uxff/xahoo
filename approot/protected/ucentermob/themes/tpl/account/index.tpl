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
    <section class="msg-container" style="display:none" id="container">
            <div class="h-alert h-alert-danger">
                    <button type="button" class="h-close">&times;</button>
                    <p></p>
            </div>
    </section>
{/if}
<section class="main-section">
        <ul class="h-form" id="set">
                <li> <a href="{yii_createurl c=account a=modtel}">
                                <label class="label" for="">手机绑定</label>
                                <div class="status">
                                        {if $arrMember['is_mobile_actived']==1}<p>{$arrMember['member_mobile']}</p>{else}<p class="grey999">未设置</p>{/if}
                                        <i class="icon-angle-right"></i> </div>
                        </a> </li>
                <li>
                        <label class="label" for="">密保问题</label>
                        <div class="status">
                                <p class="grey999">
                                        {if $isSetQuestions == 1}
                                            <a href="{yii_createurl c=account a=changequestion} " class="grey999">修改</a>
                                        {else}
                                            <span id="set_ques" ><a href="#" class="grey999">未设置</a></span>
                                        {/if}
                                </p>
                                <i class="icon-angle-right"></i>
                        </div>
                </li>
                <li> <a href="{yii_createurl c=account a=modid}">
                                <label class="label" for="">身份验证</label>
                                <div class="status">
                                        {if $arrMember['is_idnumber_actived']==1}<p>{$arrMember['member_id_number']}</p>{else}<p class="grey999">未设置</p>{/if}
                                        <i class="icon-angle-right"></i> </div>
                        </a> </li>
                <li> <a href="{yii_createurl c=account a=modemail}">
                                <label class="label" for="">邮箱绑定</label>
                                <div class="status">
                                        {if $arrMember['is_email_actived']==1}<p>{$arrMember['member_email']}</p>{else}<p class="grey999">未设置</p>{/if}
                                        <i class="icon-angle-right"></i> </div>
                        </a> 
                </li>
                <li> 
                        <label class="label" for="">交易密码</label>
                        <div class="status">
                                {if $is_dealpwd_lock ==1}
                                    <p class="grey999">原密码输入错误3次，请第二天再编辑</p>
                                {else}
                                    {if empty($arrMember['deal_password'])}
                                        <p><a href="{yii_createurl c=account a=dealpassword}" class="grey999">未设置</a></p>
                                    {else}
                                        <p><a href="{yii_createurl c=account a=moddealpwd}" class="grey999">修改</a></p>
                                    {/if}
                                {/if}

                                <i class="icon-angle-right"></i> 
                        </div>

                </li>               
                <li> 
                        <a href="{yii_createurl c=account a=bindTradingPlatform}">
                                <label class="label" for="">支付平台</label>
                                <div class="status">
                                        <p class="grey999">绑定支付平台</p>
                                        <i class="icon-angle-right"></i> 
                                </div>
                        </a>


                </li>               
                <li class="bord-b"> <a href="{yii_createurl c=account a=modpwd}">
                                <label class="label" for="">修改密码</label>
                                <div class="status">
                                        <p>********</p>
                                        <i class="icon-angle-right"></i> </div>
                        </a> </li>
        </ul>
</section>
