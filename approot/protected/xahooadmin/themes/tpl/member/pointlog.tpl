<div class="page-content-area">
        <div class="page-header">
                <h1> MemberPointLog <small> <i class="ace-icon fa fa-angle-double-right"></i> 会员{$member.member_name}的积分收支明细 </small> </h1>
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
                                                <form class="form-horizontal"  id="memberPointLog-form" role="form" action="#" method="GET">
                                                        <input type="hidden" name="r" value="{$route}" />
                                                        {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_member_id">会员id</label>*}
                    {*<div class="col-sm-7"><input type="text" id="MemberPointLog_member_id" name="MemberPointLog[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>*}
                    {*<div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_member_id_em_">  </span> </div>*}
                {*</div>*}
                                                    <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_rule_id">积分规则id</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_rule_id" name="MemberPointLog[rule_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_rule_id_em_">  </span> </div>
                </div>
                                                    <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_rule_point">积分分值</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_rule_point" name="MemberPointLog[rule_point]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_point}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_rule_point_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_operate_type">操作类型</label>
                    <div class="col-sm-7"><select class="form-control" id="MemberPointLog_operate_type" name="MemberPointLog[operate_type]" style="width:120px;">   <option value="1"{if $dataObj.operate_type eq "1"} selected="selected"{/if}>增加积分</option>   <option value="2"{if $dataObj.operate_type eq "2"} selected="selected"{/if}>扣除积分</option>  </select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_operate_type_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_description">描述</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_description" name="MemberPointLog[description]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.description}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_description_em_">  </span> </div>
                </div>
                                                    {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_point_before">之前积分数量</label>*}
                    {*<div class="col-sm-7"><input type="text" id="MemberPointLog_point_before" name="MemberPointLog[point_before]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.point_before}" /></div>*}
                    {*<div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_point_before_em_">  </span> </div>*}
                {*</div>*}
                                                    {*<div class="form-group">*}
                    {*<label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_point_after">积分数量</label>*}
                    {*<div class="col-sm-7"><input type="text" id="MemberPointLog_point_after" name="MemberPointLog[point_after]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.point_after}" /></div>*}
                    {*<div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_point_after_em_">  </span> </div>*}
                {*</div>*}
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
                                                {*<span class="pull-right">*}
                                                        {*<a href="backend.php?r=memberPointLog/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>*}
                                                {*</span>*}
                                        </div>
                                        <div class="table-responsive">
                                                <table id="idTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                                {*<tr>*}
                                                                        {*<th class="center"> <label class="position-relative">*}
                                                                                        {*<input type="checkbox" class="ace" />*}
                                                                                        {*<span class="lbl"></span> </label>*}
                                                                        {*</th>*}
                                                                        {*<th>*}

                                                                        {*</th>*}
                                                                        {*{foreach from=$arrAttributeLabels item=labelName}*}
                                                                        {*<th>{$labelName}</th>*}
                                                                        {*{/foreach}*}
                                                                        {*<th>操作</th>*}
                                                                {*</tr>*}
                                                        </thead>
                                                        <tbody>
                                                                {foreach from=$arrData key=i item=objModel}
                                                                <tr>
                                                                        {*<td class="center"><label class="position-relative">*}
                                                                                        {*<input type="checkbox" class="ace" />*}
                                                                                        {*<span class="lbl"></span> </label>*}
                                                                        {*</td>*}
                                                                        <td>
                                                                            {$objModel.create_time}因<span style="color: #0000ff">&nbsp;&nbsp;&nbsp;&nbsp;{$objModel.rule.rule_name}&nbsp;&nbsp;&nbsp;&nbsp;</span>{if $objModel.operate_type == 1}<span style="color: darkgreen">获取</span>{else}<span style="color: red">消耗</span>{/if}{$objModel.rule_point}点积分,总积分由{$objModel.point_before}{if $objModel.operate_type == 1}&nbsp;&nbsp;&nbsp;&nbsp;增长&nbsp;&nbsp;&nbsp;&nbsp;{else}&nbsp;&nbsp;&nbsp;&nbsp;下降&nbsp;&nbsp;&nbsp;&nbsp;{/if}到{$objModel.point_after}
                                                                        </td>
                                                                        {*{foreach from=$arrAttributeLabels key=attrId item=labelName}*}
                                                                        {*{if $attrId == 'status' && $objModel.status == 1}*}
                                                                        {*<td><span class="label label-sm label-success">有效</span></td>*}
                                                                        {*{elseif $attrId == 'rule_id'}*}
                                                                        {*<td><span class="">{$objModel.rule.rule_name}</span></td>*}
                                                                        {*{elseif $attrId == 'operate_type' && $objModel.operate_type == 1}*}
                                                                        {*<td><span class="">获取{$objModel.rule_point}积分</span></td>*}
                                                                        {*{elseif $attrId == 'operate_type' && $objModel.operate_type == 2}*}
                                                                        {*<td><span class="">消耗积分</span></td>*}
                                                                        {*{elseif $attrId == 'status' && $objModel.status == 0}*}
                                                                        {*<td><span class="label label-sm label-warning">无效</span></td>*}
                                                                        {*{else}*}
                                                                        {*<td>{$objModel.$attrId}</td>*}
                                                                        {*{/if}*}
                                                                        {*{/foreach}*}
                                                                        {*<td><div class="hidden-sm hidden-xs btn-group">*}
                                                                                        {*<a href="backend.php?r=memberPointLog/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>*}
                                                                                        {*<a href="backend.php?r=memberPointLog/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>*}
                                                                                        {*<button onclick="delConfirm('backend.php?r=memberPointLog/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>*}
                                                                                {*</div>*}
                                                                                {*<div class="hidden-md hidden-lg">*}
                                                                                        {*<div class="inline position-relative">*}
                                                                                                {*<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>*}
                                                                                                {*<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">*}
                                                                                                        {*<li> <a href="backend.php?r=memberPointLog/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>*}
                                                                                                        {*<li> <a href="backend.php?r=memberPointLog/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>*}
                                                                                                        {*<li> <button onclick="delConfirm('backend.php?r=memberPointLog/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>*}
                                                                                                {*</ul>*}
                                                                                        {*</div>*}
                                                                                {*</div>*}
                                                                        {*</td>*}
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