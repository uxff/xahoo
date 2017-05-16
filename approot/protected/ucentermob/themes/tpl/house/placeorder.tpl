<header class="header3">
    <p class="h-top">填写认购信息</p>
    <a href="{yii_createurl c=house a=detail house_id=$house_id}" class="h-item-left icon-angle-left"></a>
</header>

{if !empty($houseDetail['surplus_item_total'])}
    <section class="h-item-buy">
        <form action="{yii_createurl c=checkout a=initOrder}" method="POST" id="placeOrderForm">
            <input type="hidden" name="FqFenquanOrder[item_id]" value="{$house_id}" />
            <input type="hidden" name="FqFenquanOrder[item_price]" value="{$houseDetail.house_avg_price*10000}" />
            <input type="hidden" name="FqFenquanOrder[final_price]" value="{$houseDetail.house_avg_price*10000}" />
            <input type="hidden" name="FqFenquanOrder[customer_id]" value="{$customer_id}" />

            <p class="h-explain red" style="display: none;">
                订单提交后会为您预留{if $orderOvertimeHours>1}{$orderOvertimeHours}小时{else}{$arrTimeMsg.minute}分钟{/if}进行支付。逾期未支付，系统将取消本次交易
            </p>
            <ul class="h-itemintro-list">
                <li>
                    <a href="{yii_createurl c=house a=detail house_id=$house_id}" class="h-thumb">
                        <img src="{$houseDetail.house_thumb}" data-src="holder.js/103x60/auto/sky" style="width:103px;height:60px;" alt="103x60" data-holder-rendered="false">
                    </a>
                    <div class="list-r h-myhouse-list">
                        <p class="buy-desc">项目名称: <span>{$houseDetail.house_name}</span></p>
                        <p class="buy-desc">{$houseDetail.province.sys_region_name} {$houseDetail.city.sys_region_name}　{floatval($houseDetail.house_area)}平米</p>
                    </div>
                </li>
            </ul>
            <!-- The progress of
            <div class="container">
                <ul class="h-buy-pro">
                    <li class="row">
                        <span>持有期限: <strong>{$houseDetail.holding_period}个月</strong></span>
                        <span>剩余时间: <strong>{$houseDetail.remaining_time}天</strong></span>
                    </li>
                    <li class="row">
                        <span>已完成: <strong id="ratio">{yii_formatpercent percent=$houseDetail.ratio decimals=2}%</strong></span>
                        <span>剩余份数: <strong id="surplus">{$houseDetail.surplus_item_total}</strong></span>
                    </li>
                </ul>
            </div>
             -->
            <!-- buy -->
            <!--
            <div class="h-buy-num">
                <p>认购份数：
                    <span class="clearfix counter">
                        <button type="button" class="icon-minus" id="Minus" onclick="cutMinus('#Num', '#Plus', '#Minus');"></button>
                        <input name="FqFenquanOrder[item_quantity]" type="text" data-max="{$houseDetail.surplus_item_total}" class="num" id="Num" value="1" onchange="modVal('#Num')">
                        <button type="button" class="icon-plus" id="Plus" onclick="addPlus('#Num', '#Plus', '#Minus');"></button>
                    </span>
                </p>
                <p>认购金额：<span class="pink2"><i id="Amount" data-mon="{$houseDetail.house_avg_price}">{$houseDetail.house_avg_price}</i></span></p>
                <input type="hidden" name="" id="AmountInd" value="{$houseDetail.house_avg_price}">
            </div>
            -->

            <p class="h-explain red" style="display: none;">
                请确认您的真实个人信息以保障认购权益
            </p>
             <p class="h-explain red">
                请您填写预购信息，以便我们及时通知您参与购买。
            </p>

            <div class="h-buy-form"> 
                <p class="row">
                    <label for="">真实姓名:</label>
                    <input type="text" id="realName" {$disabled} name="FqFenquanOrder[customer_name]" value="{if $frontedOrder.cusomter_name}{$frontedOrder.cusomter_name}{else}{$customerProfile.userProfile.member_fullname}{/if}">
                    <i class="icon-remove-sign"></i>
                </p>
                <p class="row">
                    <label for="">身份证号:</label>
                    <input type="text" id="ID" {$disabled} name="FqFenquanOrder[customer_identity_id]" value="{if $frontedOrder.cusomter_identity_id}{$frontedOrder.cusomter_identity_id}{else}{$customerProfile.userProfile.member_id_number}{/if}">
                    <i class="icon-remove-sign"></i>
                </p>
                <p class="row">
                    <label for="">手机号:</label>
                    <input type="text" id="phoneNo" name="FqFenquanOrder[customer_phone]" value="{$customerProfile.userProfile.member_mobile}">
                    <i class="icon-remove-sign"></i>
                </p>
                <!--
                <div class="x-text-area">
                    <label for="">邮寄地址:</label>
                    <textarea class="x-ialak" id="address" readonly name="FqFenquanOrder[address]">{$addressDetail['0'].province.sys_region_name}{$addressDetail['0'].city.sys_region_name}{$addressDetail['0'].county.sys_region_name}{$addressDetail['0'].address}</textarea>
                    <img class="x-ialak" src="{$resourcePath}/imgs/sle.png"/>
                </div>
                -->

                <div class="x-abot">
                    <ul>
                        {foreach from=$addressDetail key=index item=i}
                            <li>
                                <p>{$i.province.sys_region_name}{$i.city.sys_region_name}{$i.county.sys_region_name}{$i.address}</p>
                                <input class="mt" type="radio" value="{$i.id}" name="paypath">
                            </li>
                        {/foreach}
                    </ul>
                </div>
                <div class="row x-ysd" alt="">
                    <a class="row_abot">添加地址</a>
                </div>
                <div class="row x-hitems">
                    <label for="">所在地　</label>
                    <select name="FqFenquanOrder[province]" class="x_selbox" id="provinceID">
                        <option value="0">请选择</option>
                        {foreach from=$arrProvince key=index item=i}
                            <option value="{$i.sys_region_index}">{$i.sys_region_name}</option>
                        {/foreach}
                    </select>
                    <select name="FqFenquanOrder[city]" class="x_selbox" id="cityID">
                        <option value="0">请选择</option>
                    </select>
                    <select name="FqFenquanOrder[county]" class="x_selbox" id="countryID">
                        <option value="0">请选择</option>
                    </select>
                </div>
                <div class="row x-hitems">
                    <label for="">详细地址</label>
                    <input type="text" value="" name="FqFenquanOrder[withaddress]" id="particular">
                    <i class="icon-remove-sign"></i>
                </div>
                <p class="cue" style="display:none">
                    <input type="checkbox" name="agree_terms" value="1" checked="checked" id="select">
                    已阅读并同意<a href="{yii_createurl c=house a=contractDetail house_id=$houseDetail.house_id contract_id=9999999}">《认购合同》</a>，系统将根据您填写的个人信息填入合同条款，网签合同与纸质合同具有同等法律效力。
                </p>
                <p class="h-btn-box">
                <br /><br />
                    <input class="pinkbtn" type="submit" id="placeOrderSmtBtn" value="订单提交">
                </p>
            </div>
        </form>
    </section>
{else}
    <section class="h-item-buy">
        <p class="h-explain red">
            抱歉，该项目份额已售罄，请选择其他项目！
        </p>
        <p class="h-explain">
            <a href="{yii_createurl c=house a=list}"><button>查看其他项目</button></a>
        </p>
    </section>
{/if}