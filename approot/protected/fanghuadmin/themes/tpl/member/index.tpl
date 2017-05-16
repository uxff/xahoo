<div class="page-content-area">
    <div class="page-header">
        <h1> Member
            <small><i class="ace-icon fa fa-angle-double-right"></i> List</small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <a href="#" onclick="$('#searchContainer').toggle();
                                                    return false">检索条件</a><br/>

                    <div id="searchContainer" style="display: {if $searchForm}block;{else}none;{/if}">
                        <form class="form-horizontal" id="member-form" role="form" action="#" method="GET">
                            <input type="hidden" name="r" value="{$route}"/>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_account">会员帐号</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_account"
                                                             name="Member[member_account]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_account}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_account_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_password">会员密码</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_password"
                                                             name="Member[member_password]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_password}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_password_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_from">会员来源</label>

                                <div class="col-sm-7"><select class="form-control" id="Member_member_from"
                                                              name="Member[member_from]" style="width:120px;">
                                        <option value="1"{if $dataObj.member_from eq "1"} selected="selected"{/if}>注册
                                        </option>
                                        <option value="2"{if $dataObj.member_from eq "2"} selected="selected"{/if}>邀请
                                        </option>
                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_from_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_has_children">是否有小伙伴</label>

                                <div class="col-sm-7"><select class="form-control" id="Member_has_children"
                                                              name="Member[has_children]" style="width:120px;">
                                        <option value="0"{if $dataObj.has_children eq "0"} selected="selected"{/if}>没有
                                        </option>
                                        <option value="1"{if $dataObj.has_children eq "1"} selected="selected"{/if}>有
                                        </option>
                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_has_children_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_parent_id">会员上级编号</label>

                                <div class="col-sm-7"><input type="text" id="Member_parent_id" name="Member[parent_id]"
                                                             size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.parent_id}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_parent_id_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="Member_member_level_id">会员等级ID</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_level_id"
                                                             name="Member[member_level_id]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_level_id}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_level_id_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_name">会员姓名</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_name"
                                                             name="Member[member_name]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.member_name}"/>
                                </div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_name_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_sex">性别</label>

                                <div class="col-sm-7">
                                    <select class="form-control" id="Member_member_sex"
                                                              name="Member[member_sex]" style="width:120px;">
                                        <option value="0"{if $dataObj.member_sex eq "0"} selected="selected"{/if}>保密</option>
                                        <option value="1"{if $dataObj.member_sex eq "1"} selected="selected"{/if}>男
                                        </option>
                                        <option value="2"{if $dataObj.member_sex eq "2"} selected="selected"{/if}>女
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_sex_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_birthday">会员生日</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_birthday"
                                                             name="Member[member_birthday]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_birthday}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_birthday_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_mobile">会员手机号</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_mobile"
                                                             name="Member[member_mobile]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_mobile}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_mobile_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_mobile_verified">会员手机号是否认证</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_mobile_verified"
                                                             name="Member[member_mobile_verified]" size="60"
                                                             maxlength="200" class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_mobile_verified}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_mobile_verified_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_nickname">会员昵称</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_nickname"
                                                             name="Member[member_nickname]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_nickname}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_nickname_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_email">会员电子邮箱</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_email"
                                                             name="Member[member_email]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_email}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_email_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_email_verified">会员电子邮箱是否认证</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_email_verified"
                                                             name="Member[member_email_verified]" size="60"
                                                             maxlength="200" class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_email_verified}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_email_verified_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="Member_member_avatar">会员头像</label>

                                <div class="col-sm-7"><input type="text" id="Member_member_avatar"
                                                             name="Member[member_avatar]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5"
                                                             value="{$dataObj.member_avatar}"/></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="Member_member_avatar_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="Member_status">状态</label>

                                <div class="col-sm-7"><select class="form-control" id="Member_status"
                                                              name="Member[status]" style="width:120px;">
                                        <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}></option>
                                        <option value="有效"{if $dataObj.status eq "有效"} selected="selected"{/if}>0
                                        </option>
                                        <option value="无效"{if $dataObj.status eq "无效"} selected="selected"{/if}></option>
                                        <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}></option>
                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle" id="Member_status_em_">  </span>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-5 col-md-9">
                                    <button class="btn btn-info" type="submit"><i
                                                class="ace-icon fa fa-check bigger-110"></i> 提交
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-header">
                        {if $pages.totalCount>$pages.pageSize}
                            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.curPage*$pages.pageSize} of {$pages.totalCount} results
                        {else}
                            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.totalCount} of {$pages.totalCount} results
                        {/if}
                        <span class="pull-right">
                                                        <a href="fanghuadmin.php?r=member/create"
                                                           class="btn btn-xs btn-success"><i
                                                                    class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
                                                </span>
                    </div>
                    <div class="table-responsive">
                        <table id="idTable" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                {*<th class="center"><label class="position-relative">*}
                                        {*<input type="checkbox" class="ace"/>*}
                                        {*<span class="lbl"></span> </label>*}
                                {*</th>*}
                                {foreach from=$arrAttributeLabels item=labelName}
                                    <th>{$labelName}</th>
                                {/foreach}
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$arrData key=i item=objModel}
                                <tr>
                                    {*<td class="center"><label class="position-relative">*}
                                            {*<input type="checkbox" class="ace"/>*}
                                            {*<span class="lbl"></span> </label></td>*}
                                    {foreach from=$arrAttributeLabels key=attrId item=labelName}
                                        {if $attrId == 'status' && $objModel.status == 1}
                                            <td><span class="label label-sm label-success">有效</span></td>
                                        {elseif $attrId == 'status' && $objModel.status == 0}
                                            <td><span class="label label-sm label-warning">无效</span></td>
                                        {elseif $attrId == 'member_sex' && $objModel.member_sex == 0}
                                            <td><span class="">保密</span></td>
                                        {elseif $attrId == 'member_sex' && $objModel.member_sex == 1}
                                            <td><span class="">男</span></td>
                                        {elseif $attrId == 'member_sex' && $objModel.member_sex == 2}
                                            <td><span class="">女</span></td>
                                        {elseif $attrId == 'member_mobile_verified' && $objModel.member_mobile_verified == 0}
                                            <td><span class="label label-sm label-warning">末验证</span></td>
                                        {elseif $attrId == 'member_mobile_verified' && $objModel.member_mobile_verified == 1}
                                            <td><span class="label label-sm label-success">已验证</span></td>
                                        {elseif $attrId == 'member_email_verified' && $objModel.member_email_verified == 0}
                                            <td><span class="label label-sm label-warning">末验证</span></td>
                                        {elseif $attrId == 'member_email_verified' && $objModel.member_email_verified == 1}
                                            <td><span class="label label-sm label-success">已验证</span></td>
                                        {elseif $attrId == 'member_avatar'}
                                            <td><span class=""><img src="{$objModel.member_avatar}" alt="会员头像"/></span></td>
                                        {else}
                                            <td>{$objModel.$attrId}</td>
                                        {/if}
                                    {/foreach}
                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <a href="fanghuadmin.php?r=member/update&id={$objModel.$modelId}"
                                               class="btn btn-xs btn-success"> <i
                                                        class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                            <a href="fanghuadmin.php?r=member/detail&id={$objModel.$modelId}"
                                               class="btn btn-xs btn-success"> <i
                                                        class="ace-icon fa fa-search-plus bigger-120"></i>查看会员详情</a>
                                            <button onclick="delConfirm('fanghuadmin.php?r=member/delete&id={$objModel.$modelId}');"
                                                    data-url="" class="btn btn-xs btn-danger"><i
                                                        class="ace-icon fa fa-trash-o bigger-120"></i>删除
                                            </button>
                                        </div>
                                        <div class="hidden-md hidden-lg">
                                            <div class="inline position-relative">
                                                <button class="btn btn-minier btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" data-position="auto"><i
                                                            class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                    <li>
                                                        <a href="fanghuadmin.php?r=member/update&id={$objModel.$modelId}"
                                                           class="tooltip-success" data-rel="tooltip" title="Edit">
                                                            <span class="green"> <i
                                                                        class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span>
                                                        </a></li>
                                                    <li>
                                                        <button onclick="delConfirm('fanghuadmin.php?r=member/delete&id={$objModel.$modelId}');"
                                                                class="tooltip-error" data-rel="tooltip" title="Delete">
                                                            <span class="red"> <i
                                                                        class="ace-icon fa fa-trash-o bigger-120"></i> </span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                    <div class="dataTables_paginate">
                        <!-- #section:widgets/pagination -->
                        {include file="../widgets/pagination.tpl"}
                        <!-- /section:widgets/pagination -->
                    </div>
                </div>
                <!-- /.col-xs-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.ol-xs-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.page-content-area --> 