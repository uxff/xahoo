<section class="main-section">
        <ul class="h-addres">		
                {foreach from=$arrAddress item=i}
                    <li {if $i.is_default == 1}class="active"{/if}>
                            <a href="{yii_createurl c=address a=modaddress id=$i.id}" title="">
                                    <i class="icon-angle-right"></i>
                                    {if $i.is_default == 1}
                                        <span class="h-addres-right"><i class="icon-ok "></i></span>
                                        {/if}
                                    <div class="h-addres-infor">
                                            <div class="">
                                                    <span class="h-addres-name">{$i.consignee_name}</span>
                                                    <span class="h-right">{substr_replace($i.consignee_mobile, '****', 3 ,4)}</span>
                                            </div>
                                            <div class="">{$i.address}</div>
                                    </div>
                            </a>
                    </li>
                {/foreach}
        </ul>
        <ul class="h-box-bgff-p10 clearfix text-c h-desc-btn">
                <li class="btn-ora h-addressbtn"><a href="{yii_createurl c=address a=modaddress}"> 添加新地址</a></li>
        </ul>
</section>