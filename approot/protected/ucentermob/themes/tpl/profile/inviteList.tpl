<style>
.my-tmembers-tpa {
    background: none repeat scroll 0 0;
    border-bottom: 1px solid #d8d8da;
    height: 96px;
    margin-bottom: 10px;
    margin-top: -13px;
}
.my-tmembers-tpa a {
    display: inline-block;
    height: 96px;
    width: 49%;
}
.my-tmembers-tpa a:first-child {
    border-right: 1px solid #d8d8da;
}
.my-tmembers-list {
    border-top: 1px solid #dcdcdc;
}

.my-tmembers-list li {
    border-bottom: 1px solid #dcdcdc;
    height: 45px;
    padding: 0 10px;
}

.my-tmembers-list li a {
    display: block;
    height: 45px;
    color: #333333;
    text-decoration: none;
}
.my-tmembers-list li a p {
    line-height:45px;
}
</style>

{if !empty($arrMsgStack)}
        <section class="msg-container" style="">
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
       <div class="my-tmembers-tpa">
           <a href="javascript:void(0);" id='l_invite' style="float:left;">
               <p style="padding-top: 45px; text-align: center;">我的专属二维码</p>
           </a>
           <a href="javascript:void(0);" id='J_invite'>
               <p style="padding-top: 45px; text-align: center;">我的邀请记录</p>
           </a>
       </div>
       
        <div style="display:none;" id="invite_img">
           <ul class="my-tmembers-list" >
            {if !empty($invitelist)}
             {foreach from=$invitelist key=i item=val}
               <li>
                   <a href="javascript:void(0);">
                       <p style="float:left;">{$val->member_mobile}</p>
                       <p style="color:#888; float:right;">注册日期：{$val->create_time}</p>
                   </a>
               </li>
             {/foreach}
            {else}
                   <li class='mg-t10 bordert'>
                       <a href="javascript:void(0);">
                           <p>你还没有邀请过人</p>
                       </a>
                   </li>
             {/if}
           </ul>
       </div>
       <div style="display:block; text-align:center;" id="invite_list">
           <p style="line-height:45px;margin-left: 10px;">我的专属二维码</p>
           <img src="http://qr.liantu.com/api.php?w=110&m=10&text={$encodedInviteUrl}" class="share-ewm"/>
       </div>
</section>