<header class="header3 header">
    <p class="h-top">项目详情</p>
    <a href="{yii_createurl c=house a=detail house_id=$house_id}" class="h-item-left icon-angle-left"></a>
    <!-- <a href="javascript:;" class="h-item-right  h-icon-th click-show-hide"></a> -->
    <div class="dialog-pic-icon" style="display: none;border-top:1px solid #d7d7d7;" >
        <span class="icon-one"><a class="pic-icon-one" href="{$xqsjIndexUrl}"><p class="p1-pos">首页</p></a></span>
        <!--<span class="icon-two"><a class="pic-icon-two" href="{$zcIndexUrl}"><p class="p2-pos">众筹</p></a></span>-->
        <span class="icon-three"><a class="pic-icon-three" href="{$fqIndexUrl}"><p class="p3-pos">逸乐通</p></a></span>
        <span class="icon-four"><a class="pic-icon-four" href="{yii_createurl c=customer a=index}"><p class="p4-pos">我的</p></a></span>
    </div>
    <ul class="clearfloat"></ul>
</header>
<section class="h-index main-section">
    <div>
        <div class="clearfix mg-b10 h-container">
            <div class="h-grade-info clearfix">
                <ul class="h-itemintro-list pd-15">
                    <li>
                        <a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}" class="h-thumb">
                            <img src="{$houseDetail.house_thumb}" data-src="holder.js/120x70/auto/sky" style="width:120px;height:70px;" alt="120x70" data-holder-rendered="false">
                        </a>
                        <div class="list-r h-myhouse-list">
                            <h3 class="desc"><a href="{yii_createurl c=house a=detail house_id=$houseDetail.house_id}">{$houseDetail.house_name} {$houseDetail.house_type}</a></h3>
                            <p class="time mg-b18">￥{$houseDetail.house_num_price}万/套</p>
                            <p class="pink2">￥{$houseDetail.house_avg_price}万/份</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix mg-t10 mg-b10 h-container">
            <div class="clearfix">
                <h3 class="nickname mg-l10">资产管理方</h3>
                <ul class="pd-10 grey6e clearfix h-item-infor">
                    <li>公司名称：{$assetCompany.company_name}</li>
                    <li>地址：{$assetCompany.company_address}</li>
                    <li>电话：{$assetCompany.company_telephone}</li>
                    <li>法人代表：{$assetCompany.company_legal_person}</li>
                    <li>注册资金：{$assetCompany.company_registered_capital}</li>
                    <li>营业执照号：{$assetCompany.company_licence_no}</li>
                    <li>经营范围：{$assetCompany.company_business_scope}</li>
                </ul>
                <a href="javascript:;" class="h-asset-imgbox"><img src="{$assetCompany.company_licence_img}"  data-src="holder.js/280x370/auto/sky" width="100%" alt="100%x80%" data-holder-rendered="false"></a>
                <ul class="pd-10 grey6e clearfix h-item-infor h-asset-ul">
                    <li>项目开户行：{$assetCompany.company_bank_name}</li>
                    <li>项目银行帐号：{$assetCompany.company_bank_account}  </li>
                    <li>帐号监管机构：{$assetCompany.company_regulatory_partner}</li>
                    <li>项目担保机构：{$assetCompany.company_guarantee_partner} </li>
                </ul>
            </div>
        </div>
    </div>
</section>