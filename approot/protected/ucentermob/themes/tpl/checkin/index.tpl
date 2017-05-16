{if $status=='success'}
        <section class="h-hint main-section">
                <div class="h-box-bgff-p10">
                        <h1 class="orange"><i class="icon-smile"></i> 签到成功！</h1>
                        <h1 class="score pd-b80">您获得<span class="orange">{$point}</span>点积分</h1>
                </div>
                {*
                <div class="h-box-bgff-p10">
                        <a class="more" href="{$PointRuleUrl}">看看还能做什么
                                <i class="icon-angle-right"></i>
                        </a>
                </div>
                *}
        </section>
{else}
        <section class="h-hint main-section">
                <div class="h-box-bgff-p10">
                        <h1 class="oranges"><i class="icon-remove-sign"></i> 签到失败！</h1>
                        <h1 class="score pd-b80">您今天已经签到！</h1>
                </div>
                {*
                <div class="h-box-bgff-p10">
                        <a class="more" href="{$PointRuleUrl}">看看还能做什么
                                <i class="icon-angle-right"></i>
                        </a>
                </div>
                *}
        </section>
{/if}