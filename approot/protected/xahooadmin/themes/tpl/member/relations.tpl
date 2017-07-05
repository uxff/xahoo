<div class="page-content-area">
    <div class="page-header">
        <h1> MemberToTask <small> <i class="ace-icon fa fa-angle-double-right"></i> {$member.member_name}的小伙伴 </small> </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                {*ajax获取数据*}
                {*<div id="member_info">*}
                    {*<div>*}
                        {*<img src="{$member.member_avatar}" alt="会员头像"/>*}
                    {*</div>*}
                    {*<div>*}
                        {*{$member.member_name}*}
                    {*</div>*}
                    {*<div id="level-1">*}
                        {*{foreach from=$partners key=index item=p}*}
                            {*<div class="" style="float: left">*}
                                {*<div class="partner_avatar partners" partner_id="{$p.member.member_id}">*}
                                    {*<img src="{$p.member.member_avatar}" alt="会员头像" title="1度小伙伴"/>*}
                                    {*<div class="partner_name">*}
                                        {*{$p.member.member_name}*}
                                    {*</div>*}
                                {*</div>*}

                            {*</div>*}
                        {*{/foreach}*}
                    {*</div>*}
                {*</div>*}


                <div id="member_info">
                    <div>
                    <img src="{$member.member_avatar}" alt="会员头像"/>
                    </div>
                    <div>
                    {$member.member_name}
                    </div>
                    <div id="level-1">
                        {foreach from=$partners key=index item=op}
                            {if $op.degree == 1}
                                <div class="" style="float: left">
                                    <div class="partner_avatar partners" partner_id="{$op.member_id}">
                                    <img src="{$op.member_avatar}" alt="会员头像" title="{$op.degree}度小伙伴"/>
                                        <div class="partner_name">
                                        {$op.member_name}
                                        </div>
                                    </div>
                                    {foreach from=$partners key=index item=tp}
                                        {if $tp.degree == 2 && $tp.parent_id == $op.member_id}
                                            <div class="" style="float: left">
                                                <div class="partner_avatar partners" partner_id="{$tp.member_id}">
                                                    <img src="{$tp.member_avatar}" alt="会员头像" title="{$tp.degree}度小伙伴"/>
                                                    <div class="partner_name">
                                                        {$tp.member_name}
                                                    </div>
                                                </div>
                                                {foreach from=$partners key=index item=thp}
                                                    {if $thp.degree == 3 && $thp.parent_id == $tp.member_id}
                                                        <div class="" style="float: left">
                                                            <div class="partner_avatar partners" partner_id="{$thp.member_id}">
                                                                <img src="{$thp.member_avatar}" alt="会员头像" title="{$thp.degree}度小伙伴"/>
                                                                <div class="partner_name">
                                                                    {$thp.member_name}
                                                                </div>
                                                            </div>
                                                            {foreach from=$partners key=index item=fp}
                                                                {if $fp.degree == 4 && $fp.parent_id == $thp.member_id}
                                                                    <div class="" style="float: left">
                                                                        <div class="partner_avatar partners" partner_id="{$fp.member_id}">
                                                                            <img src="{$fp.member_avatar}" alt="会员头像" title="{$fp.degree}度小伙伴"/>
                                                                            <div class="partner_name">
                                                                                {$fp.member_name}
                                                                            </div>
                                                                        </div>
                                                                        {foreach from=$partners key=index item=tvp}
                                                                            {if $fvp.degree == 4 && $fp.parent_id == $fp.member_id}
                                                                                <div class="" style="float: left">
                                                                                    <div class="partner_avatar partners" partner_id="{$fvp.member_id}">
                                                                                        <img src="{$fvp.member_avatar}" alt="会员头像" title="{$fvp.degree}度小伙伴"/>
                                                                                        <div class="partner_name">
                                                                                            {$fvp.member_name}
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            {/if}
                                                                        {/foreach}
                                                                    </div>
                                                                {/if}
                                                            {/foreach}
                                                        </div>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        {/if}
                                    {/foreach}
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </div>


            </div><!-- /.row -->
        </div><!-- /.ol-xs-12 -->
    </div><!-- /.row -->
</div>
<!-- /.page-content-area -->