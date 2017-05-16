<section class="main-section">
        <ul class="h-per">
                <li>
                        <a href="{yii_createurl c=profile a=avatar}" class="clearfix">
                                <span>头像</span>
                                {if $arrMember.member_avatar}
                                        <img src="{$arrMember.member_avatar}"/>
                                {else}
                                        <img src="{$resourcePath}/imgs/h-per-head.png"/>
                                {/if}
                                <div class="picmask"></div>
                                <i class="icon-angle-right"></i>
                        </a>
                </li>
                <li>
                        <a href="{yii_createurl c=profile a=nick}" class="clearfix">
                                <span>昵称</span>
                                <strong>{$arrMember.member_nickname}</strong>
                                <i class="icon-angle-right"></i>
                        </a>
                </li>
                <li>
                        <a href="{yii_createurl c=profile a=basic}" class="bar-box clearfix">
                                <span>基础资料</span>
                                <div class="bar-bg">
                                        <div class="bar" style="width:{$basic_percent}%"></div>
                                </div>
                                <i class="icon-angle-right"></i>
                        </a>
                </li>
                <li>
                        <a href="{yii_createurl c=account a=index}"  class="bar-box clearfix">
                                <span>账号与安全</span>
                                <div class="bar-bg">
                                        <div class="bar" style="width:{$account_percent}%"></div>{*orange*}
                                </div>
                                <i class="icon-angle-right"></i>
                        </a>
                </li>
                <li>
                        <a href="{yii_createurl c=address a=index}" class="address clearfix">
                                <span>地址</span>
                                <strong>
                                    <t style="float: left;">{$arrAddress.consignee_name}</t>
                                    <t style="float: right;">{if $arrAddress.consignee_mobile}{substr_replace($arrAddress.consignee_mobile, '****', 3 ,4)}{/if}</t>
                                 <br>
                                 <t style="float: left;">{$arrAddress.address}</t>
                             </strong>
                                <i class="icon-angle-right"></i>
                        </a>
                </li>
                
                <li>
                        <a href="{yii_createurl c=profile a=inviteList}" class="bar-box clearfix">
                                <span>我的邀请</span>
                                <i class="icon-angle-right"></i>
                        </a>
                </li>
        </ul>
</section>