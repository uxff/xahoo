<div class="page-content-area">
    <div class="page-header">
        <h1>节点管理 <small> <i class="ace-icon fa fa-angle-double-right"></i>
                列表 </small></h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12"><a href="#"
                                          onclick="$('#searchContainer').toggle();
                                                                  return false">检索条件</a><br />
                    <div id="searchContainer" style="display:none">
                        <form class="form-horizontal" id="node-form" role="form" action="#"
                              method="GET"><input type="hidden" name="r" value="{$route}" />
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_url">URL</label>
                                <div class="col-sm-7"><input type="text" id="SysNode_url"
                                                             name="SysNode[url]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.url}" /></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_url_em_"> </span></div>
                            </div>
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_name">名字</label>
                                <div class="col-sm-7"><input type="text" id="SysNode_name"
                                                             name="SysNode[name]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.name}" /></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_name_em_"> </span></div>
                            </div>
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_title">显示名称</label>
                                <div class="col-sm-7"><input type="text" id="SysNode_title"
                                                             name="SysNode[title]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_title_em_"> </span></div>
                            </div>
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_status">状态</label>
                                <div class="col-sm-7"><select class="form-control" id="SysNode_status"
                                                              name="SysNode[status]" style="width: 120px;">
                                        <option value="1" {if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                                        <option value="2" {if $dataObj.status eq "2"} selected="selected"{/if}>无效</option>
                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_status_em_"> </span></div>
                            </div>
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_remark">备注</label>
                                <div class="col-sm-7"><input type="text" id="SysNode_remark"
                                                             name="SysNode[remark]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.remark}" /></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_remark_em_"> </span></div>
                            </div>
                            <!--<div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_sort">排序</label>
                                <div class="col-sm-7"><input type="text" id="SysNode_sort"
                                                             name="SysNode[sort]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.sort}" /></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_sort_em_"> </span></div>
                            </div>
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_pid">父级ID</label>
                                <div class="col-sm-7"><input type="text" id="SysNode_pid"
                                                             name="SysNode[pid]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.pid}" /></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_pid_em_"> </span></div>
                            </div>-->
                            <div class="form-group"><label
                                    class="col-sm-2 control-label no-padding-right" for="SysNode_level">级别</label>
                                <div class="col-sm-7"><select class="form-control" id="SysNode_level"
                                                              name="SysNode[level]" style="width: 120px;">
                                        <option value="1" {if $dataObj.level eq "1"} selected="selected"{/if}>分组</option>
                                        <option value="2" {if $dataObj.level eq "2"} selected="selected"{/if}>controller</option>
                                        <option value="3" {if $dataObj.level eq "3"} selected="selected"{/if}>action</option>
                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="SysNode_level_em_"> </span></div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="text-center">
                                    <button class="btn btn-info" type="submit"><i
                                            class="ace-icon fa fa-check bigger-110"></i> 提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-header">{if $pages.totalCount>$pages.pageSize} Showing
                        {($pages.curPage-1)*$pages.pageSize+1} to
                        {$pages.curPage*$pages.pageSize} of {$pages.totalCount} results {else}
                            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.totalCount} of
                            {$pages.totalCount} results {/if} <span class="pull-right"> <a
                                        href="fanghuadmin.php?r=node/create&pid={$pid}"
                                        class="btn btn-xs btn-success"><i
                                            class="ace-icon fa fa-plus bigger-120"></i>新增 </a> </span></div>
                            <div class="table-responsive">
                                <table id="idTable"
                                       class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            {*<th class="center"><label class="position-relative"> <input*}
                                                        {*type="checkbox" class="ace" /> <span class="lbl"></span> </label></th>*}
                                                    {foreach from=$arrAttributeLabels item=labelName}
                                                <th>{$labelName}</th>
                                                {/foreach}
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach from=$arrData key=i item=objModel}
                                            <tr>
                                                {*<td class="center"><label class="position-relative"> <input*}
                                                            {*type="checkbox" class="ace" /> <span class="lbl"></span> </label></td>*}
                                                        {foreach from=$arrAttributeLabels key=attrId item=labelName} {if
			$attrId == 'status' && $objModel.status == 1}
                                                    <td><span class="label label-sm label-success">有效</span></td>
                                                    {elseif $attrId == 'status' && $objModel.status == 0}
                                                        <td><span class="label label-sm label-warning">无效</span></td>
                                                        {elseif $attrId == 'pid'}
                                                            <td>{$nodeName[$objModel[$attrId]]}</td>
                                                            {elseif $attrId == 'level'}
                                                                <td>{$level[$objModel[$attrId]]}</td>
                                                                {elseif $attrId == 'display'}
                                                                    <td>{$display[$objModel[$attrId]]}</td>
                                                                    {else}
                                                                        <td>{$objModel.$attrId}</td>
                                                                        {/if} {/foreach}
                                                                                <td>
                                                                                    <div class="hidden-sm hidden-xs btn-group"><a
                                                                                            href="fanghuadmin.php?r=node/index&pid={$objModel.id}"
                                                                                            class="btn btn-xs btn-info"> <i
                                                                                                class="ace-icon fa fa-search-plus bigger-120"></i>查看子节点 </a> <a
                                                                                            href="fanghuadmin.php?r=node/update&id={$objModel.$modelId}"
                                                                                            class="btn btn-xs btn-success"> <i
                                                                                                class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                                                                        <button
                                                                                            onclick="delConfirm('fanghuadmin.php?r=node/delete&amp;id={$objModel.$modelId}');"
                                                                                            data-url="" class="btn btn-xs btn-danger"><i
                                                                                                class="ace-icon fa fa-trash-o bigger-120"></i>删除</button>
                                                                                    </div>
                                                                                    <div class="hidden-md hidden-lg">
                                                                                        <div class="inline position-relative">
                                                                                            <button class="btn btn-minier btn-primary dropdown-toggle"
                                                                                                    data-toggle="dropdown" data-position="auto"><i
                                                                                                    class="ace-icon fa fa-cog icon-only bigger-110"></i></button>
                                                                                            <ul
                                                                                                class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                                <li><a href="fanghuadmin.php?r=node/view&id={$objModel.$modelId}"
                                                                                                       class="tooltip-info" data-rel="tooltip" title="View"> <span
                                                                                                            class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                                        </span> </a></li>
                                                                                                <li><a href="fanghuadmin.php?r=node/update&id={$objModel.$modelId}"
                                                                                                       class="tooltip-success" data-rel="tooltip" title="Edit"> <span
                                                                                                            class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                                        </span> </a></li>
                                                                                                <li>
                                                                                                    <button
                                                                                                        onclick="delConfirm('fanghuadmin.php?r=node/delete&amp;id={$objModel.$modelId}');"
                                                                                                        class="tooltip-error" data-rel="tooltip" title="Delete"><span
                                                                                                            class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span>
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
                                                                    <div class="dataTables_paginate"><!-- #section:widgets/pagination -->
                                                                        {include file="../widgets/pagination.tpl"} <!-- /section:widgets/pagination -->
                                                                    </div>
                                                                </div>
                                                                <!-- /.col-xs-12 --></div>
                                                            <!-- /.row --></div>
                                                        <!-- /.ol-xs-12 --></div>
                                                    <!-- /.row --></div>
                                                <!-- /.page-content-area -->
