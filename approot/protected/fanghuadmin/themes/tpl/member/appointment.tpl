<div class="page-content-area">
        <div class="page-header">
                <h1> {$member.member_nickname}  <small> <i class="ace-icon fa fa-angle-double-right"></i> 的预约信息 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <a href="#" onclick="$('#searchContainer').toggle();
                                                    return false">检索条件</a><br />
                                        <div id="searchContainer" style="display: {if $searchForm}block;{else}none;{/if}">                                      
                                                <form class="form-horizontal"  id="memberAppointment-form" role="form" action="fanghuadmin.php?r=member/appointment&id={$member.member_id}" method="GET">
                                                        <input type="hidden" name="r" value="{$route}" />
                {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_member_id">会员编号</label>*}
                    {*<div class="col-sm-7"><input type="text" id="MemberAppointment_member_id" name="MemberAppointment[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>*}
                    {*<div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_member_id_em_">  </span> </div>*}
                {*</div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_appointment_date">预约时间</label>
                    <div class="col-sm-7"><input type="text" id="MemberAppointment_appointment_date" name="MemberAppointment[appointment_date]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.appointment_date}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_appointment_date_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_house_url">预约房源链接</label>
                    <div class="col-sm-7"><input type="text" id="MemberAppointment_house_url" name="MemberAppointment[house_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.house_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_house_url_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_status">预约状态</label>
                    <div class="col-sm-7"><select class="form-control" id="MemberAppointment_status" name="MemberAppointment[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>预约</option>   <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>履约</option>   <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>爽约</option>   <option value="4"{if $dataObj.status eq "4"} selected="selected"{/if}>取消</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_status_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_dealed">是否处理</label>
                    <div class="col-sm-7">
                        {*<input type="text" id="MemberAppointment_dealed" name="MemberAppointment[dealed]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.dealed}" />*}
                        <select name="MemberAppointment[dealed]" id="MemberAppointment_deled">
                            <option value="1" {if $dataObj.dealed == 1}selected{/if}>已处理</option>
                            <option value="0" {if $dataObj.dealed == 0}selected{/if}>未处理</option>
                        </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_dealed_em_">  </span> </div>
                </div>
                                                        <div class="clearfix form-actions">
                                                                <div class="col-md-offset-5 col-md-9">
                                                                        <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
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
                                                        {*<a href="fanghuadmin.php?r=memberAppointment/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>*}
                                                </span>
                                        </div>
                                        <div class="table-responsive">
                                                <table id="idTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                                <tr>
                                                                        {foreach from=$arrAttributeLabels item=labelName}
                                                                        <th>{$labelName}</th>
                                                                        {/foreach}
                                                                        <th>操作</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                                {foreach from=$arrData key=i item=objModel}
                                                                <tr>
                                                                        {foreach from=$arrAttributeLabels key=attrId item=labelName}
                                                                        {if $attrId == 'status' && $objModel.status == 1}
                                                                        <td><span class="label label-sm label-success">预约</span></td>
                                                                        {elseif $attrId == 'status' && $objModel.status == 2}
                                                                        <td><span class="label label-sm label">履约</span></td>
                                                                        {elseif $attrId == 'status' && $objModel.status == 3}
                                                                        <td><span class="label label-sm label-warning">爽约</span></td>
                                                                        {elseif $attrId == 'status' && $objModel.status == 4}
                                                                        <td><span class="label label-sm">取消</span></td>
                                                                        {elseif $attrId == 'dealed' && $objModel.dealed == 0}
                                                                        <td><span class="label label-sm label-warning">未处理</span></td>
                                                                        {elseif $attrId == 'dealed' && $objModel.dealed != 0}
                                                                        <td><span class="label label-sm label-success">已处理</span></td>
                                                                        {else}
                                                                        <td>{$objModel.$attrId}</td>
                                                                        {/if}
                                                                        {/foreach}
                                                                        <td><div class="hidden-sm hidden-xs btn-group">
                                                                                        <a href="fanghuadmin.php?r=memberAppointment/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                                                                                        <a href="fanghuadmin.php?r=memberAppointment/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                                                                        {*<button onclick="delConfirm('fanghuadmin.php?r=memberAppointment/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>*}
                                                                                </div>
                                                                                <div class="hidden-md hidden-lg">
                                                                                        <div class="inline position-relative">
                                                                                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                                                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                                        <li> <a href="fanghuadmin.php?r=memberAppointment/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                                                                                        <li> <a href="fanghuadmin.php?r=memberAppointment/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                                                                                        <li> <button onclick="delConfirm('fanghuadmin.php?r=memberAppointment/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
                                                                                                </ul>
                                                                                        </div>
                                                                                </div></td>
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
                                </div><!-- /.col-xs-12 -->
                        </div><!-- /.row -->
                </div><!-- /.ol-xs-12 -->
        </div><!-- /.row -->
</div>
<!-- /.page-content-area --> 