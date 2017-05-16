<section class="main-section bgf6">
            <div class="container h-grade-head clearfix mg-f1">
                <div class="h-grade-info clearfix">
                    <h3 class="nickname"><i class="h-icon-integral"></i>当前等级<a href="{$RuleUrl}" class="h-right">如何获得贡献值</a></h3>
                    <p class="level grey999"><img src="{$resourcePath}/imgs/iconsmall{$memberGradelevel}.png" class="h-icon-grade"> {$memberGradeName}</p>
                    <p class="score">贡献值：{$totalContribute}</p>
                    <div class="bar-bg mt-8">
                        <div class="bar" style="width:{$memberGradePercent}%"></div>
                    </div>
                </div>
            </div>
            <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">                    
                    <h3 class="nickname"><i class="h-icon-integral2"></i>等级说明</h3>
                    <dl class="h-grade-box active">
                        <dt>等级</dt>
                        <dd>贡献值</dd>
                    </dl>
                    <dl class="h-grade-box">
                        <dt><img src="{$resourcePath}/imgs/iconsmall1.png" class="h-icon-grade2">水晶</dt>
                        <dd>0-2500</dd>
                    </dl>
                    <dl class="h-grade-box">
                        <dt><img src="{$resourcePath}/imgs/iconsmall2.png" class="h-icon-grade2">彩金</dt>
                        <dd>2501-5000</dd>
                    </dl>
                    <dl class="h-grade-box">
                        <dt><img src="{$resourcePath}/imgs/iconsmall3.png" class="h-icon-grade2">铂金</dt>
                        <dd>5001-10000</dd>
                    </dl>
                    <dl class="h-grade-box">
                        <dt><img src="{$resourcePath}/imgs/iconsmall4.png" class="h-icon-grade2">钻石</dt>
                        <dd>10001以上</dd>
                    </dl>
                </div>
            </div>
            {*
            <div class="container h-grade-head clearfix">
                <div class="h-grade-info clearfix">
                    
                    <h3 class="nickname"><i class="h-icon-change"></i>等级权益</h3>
                    <ul class="h-grade-ul">
                        <li class="h-crystal"><a href="#"><span class="h-icon"></span>水晶用户兑换专区</a></li>
                        <li class="h-colorgold"><a href="#"><span class="h-icon"></span>彩金用户兑换专区</a></li>
                        <li class="h-platinum"><a href="#"><span class="h-icon"></span>铂金用户兑换专区</a></li>
                        <li class="h-diamond"><a href="#"><span class="h-icon"></span>钻石用户兑换专区</a></li>
                     </ul>
                </div>
            </div>
            *}
        </section>