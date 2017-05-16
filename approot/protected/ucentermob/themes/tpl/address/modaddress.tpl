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
        <form name="frm" action="{yii_createurl c=address a=modaddress id=$address.id}" method="post">
                <ul class="h-form">
                        <li>
                                <label class="label" for="">收件人：</label>  
                                <div class="status">
                                        <!-- <p>奥利奥</p> -->
                                        <input type="text" name="address[name]" id="name" value="{$address.consignee_name}">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">手机号：</label>  
                                <div class="status">
                                        <!-- <p>18675757405</p> -->
                                        <input type="tel" name="address[mobile]" id="mobile" value="{$address.consignee_mobile}">
                                </div>
                        </li>
                        <li>
                                <label class="label" for="">配送地址：</label>  
                                <div class="status">
                                        <!-- <p>北京市海淀区彩和坊路甲1号华裔控股大厦</p> -->

                                        <textarea name="address[address]" id="address">{$address.address}</textarea>
                                        <!-- <input type="text" name="" value=""> -->
                                </div>
                        </li>

                        <li class="no-bg">
                                <p class="set-def">
                                        <input id="setAdd" type="checkbox" name="address[is_default]" value="1"  {if $address.is_default==1}checked="checked"{/if}>
                                        <label for="setAdd"></label>&nbsp;
                                        设为默认地址
                                </p>
                                <input class="btn-ora" onClick="r_submit()" type="button" value="保存">
                        </li>
                </ul>  
        </form>
</section>