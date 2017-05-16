<div class="page-content-area">
    <div class="page-header">
        <h1> 会员 <small> <i class="ace-icon fa fa-angle-double-right"></i>{$member_information.member_nickname}的信息</small> </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table>
                        <tr>
                            <th class="col-sm-2">头像</th>
                            <td class="col-sm-2">

                                <img src="{$member_information.member_avatar}" alt="会员头像"/>
                            </td>
                            <td class="col-sm-2"></td>
                            <th class="col-sm-2">姓名</th>
                            <td class="col-sm-2">{$member_information.member_name}</td>
                            <td class="col-sm-2"></td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">QQ</th>
                            <td class="col-sm-2">{$member_information.member_qq}</td>
                            <td class="col-sm-2"></td>
                            <th class="col-sm-2">邮箱</th>
                            <td class="col-sm-2">{$member_information.member_email}</td>
                            <td class="col-sm-2">{if $member_information.member_email_verified == 0}邮箱验证{else}已验证{/if}</td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">手机</th>
                            <td class="col-sm-2">{$member_information.member_mobile}</td>
                            <td class="col-sm-2">{if $member_information.member_mobile_verified == 0}手机验证{else}已验证{/if}</td>
                            {*<th class="col-sm-2">会员住址</th>*}
                            {*<td class="col-sm-2">{$member_information.member_address}</td>*}
                            {*<td class="col-sm-2"></td>*}
                        </tr>
                        <tr>
                            <th class="col-sm-2">等级</th>
                            <td class="col-sm-2">{$member_information.member_level.level_name}</td>
                            <td class="col-sm-2">贡献获取详情</td>
                            <th class="col-sm-2">积分</th>
                            <td class="col-sm-2">{$member_total.total_point}</td>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=member/pointlog&id={$member_information.member_id}">积分获取详情</a></td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">任务</th>
                            <td class="col-sm-2"></td>
                            <td class="col-sm-2">
                                <a href="fanghuadmin.php?r=member/taskArticle&id={$member_information.member_id}">资讯任务</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="fanghuadmin.php?r=member/taskBuilding&id={$member_information.member_id}">楼盘任务</a>
                            </td>
                            <th class="col-sm-2">收藏</th>
                            <td class="col-sm-2"></td>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=member/favorite&id={$member_information.member_id}">会员收藏的任务</a></td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">预约</th>
                            <td class="col-sm-2"></td>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=member/appointment&id={$member_information.member_id}">查看会员预约</a></td>
                            <th class="col-sm-2">佣金</th>
                            <td class="col-sm-2">{$member_total.total_reward}</td>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=member/brokeragelog&id={$member_information.member_id}">会员佣金</a></td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">婚恋状态</th>
                            <td class="col-sm-2">{if $member_information.member_is_married == 0}未婚{else}已婚{/if}</td>
                            <td class="col-sm-2"></td>
                            <th class="col-sm-2">收货地址</th>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=memberaddress/view&id={$member_information.default_address.id}">{$member_information.default_address.address}</a></td>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=member/address&id={$member_information.member_id}">查看该会员所有收货地址</a></td>
                        </tr>
                        <tr>
                            <th class="col-sm-2">会员身份证号</th>
                            <td class="col-sm-2">{$member_information.member_id_number}</td>
                            <td class="col-sm-2">{if $member_information.member_identify_verified == 1}已验证{else}未验证{/if}</td>
                            <th class="col-sm-2">小伙伴</th>
                            <td class="col-sm-2">小伙伴数量</td>
                            <td class="col-sm-2"><a href="fanghuadmin.php?r=member/relations&id={$member_information.member_id}">查看小伙伴</a></td>
                        </tr>
                    </table>
                </div><!-- /.col-xs-12 -->
            </div><!-- /.row -->
        </div><!-- /.ol-xs-12 -->
    </div><!-- /.row -->
</div>
<!-- /.page-content-area --> 