<div class="page-content-area">
    <div class="page-header">
        <h1> TaskArticle
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
                        <form class="form-horizontal" id="taskArticle-form" role="form" action="#" method="GET">
                            <input type="hidden" name="r" value="{$route}"/>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="TaskArticle_task_title">任务标题</label>

                                <div class="col-sm-7"><input type="text" id="TaskArticle_task_title"
                                                             name="TaskArticle[task_title]" size="60" maxlength="200"
                                                             class="col-xs-10 col-sm-5" value="{$dataObj.task_title}"/>
                                </div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="TaskArticle_task_title_em_">  </span></div>
                            </div>
                            {*<div class="form-group">*}
                                {*<label class="col-sm-2 control-label no-padding-right"*}
                                       {*for="TaskArticle_task_url">任务URL</label>*}

                                {*<div class="col-sm-7"><input type="text" id="TaskArticle_task_url"*}
                                                             {*name="TaskArticle[task_url]" size="60" maxlength="200"*}
                                                             {*class="col-xs-10 col-sm-5" value="{$dataObj.task_url}"/>*}
                                {*</div>*}
                                {*<div class="col-sm-2"><span class="help-inline middle"*}
                                                            {*id="TaskArticle_task_url_em_">  </span></div>*}
                            {*</div>*}
                            {*<div class="form-group">*}
                                {*<label class="col-sm-2 control-label no-padding-right" for="TaskArticle_task_detail">任务详情</label>*}

                                {*<div class="col-sm-7"><textarea id="TaskArticle_task_detail"*}
                                                                {*name="TaskArticle[task_detail]"*}
                                                                {*class="col-xs-10 col-sm-5"*}
                                                                {*placeholder="任务详情">{$dataObj.task_detail}</textarea>*}
                                {*</div>*}
                                {*<div class="col-sm-2"><span class="help-inline middle"*}
                                                            {*id="TaskArticle_task_detail_em_">  </span></div>*}
                            {*</div>*}
                            {*<div class="form-group">*}
                                {*<label class="col-sm-2 control-label no-padding-right"*}
                                       {*for="TaskArticle_task_img">任务配图</label>*}

                                {*<div class="col-sm-7"><input type="text" id="TaskArticle_task_img"*}
                                                             {*name="TaskArticle[task_img]" size="60" maxlength="200"*}
                                                             {*class="col-xs-10 col-sm-5" value="{$dataObj.task_img}"/>*}
                                {*</div>*}
                                {*<div class="col-sm-2"><span class="help-inline middle"*}
                                                            {*id="TaskArticle_task_img_em_">  </span></div>*}
                            {*</div>*}
                            {*<div class="form-group">*}
                                {*<label class="col-sm-2 control-label no-padding-right" for="TaskArticle_point_amount">积分数量</label>*}

                                {*<div class="col-sm-7"><input type="text" id="TaskArticle_point_amount"*}
                                                             {*name="TaskArticle[point_amount]" size="60" maxlength="200"*}
                                                             {*class="col-xs-10 col-sm-5"*}
                                                             {*value="{$dataObj.point_amount}"/></div>*}
                                {*<div class="col-sm-2"><span class="help-inline middle"*}
                                                            {*id="TaskArticle_point_amount_em_">  </span></div>*}
                            {*</div>*}
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right"
                                       for="TaskArticle_status">状态</label>

                                <div class="col-sm-7"><select class="form-control" id="TaskArticle_status"
                                                              name="TaskArticle[status]" style="width:120px;">
                                        <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                                        <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>无效</option>

                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="TaskArticle_status_em_">  </span></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="TaskArticle_flag">类型</label>

                                <div class="col-sm-7"><select class="form-control" id="TaskArticle_flag"
                                                              name="TaskArticle[flag]" style="width:120px;">
                                        <option value="1"{if $dataObj.flag eq "1"} selected="selected"{/if}>普通</option>
                                        <option value="2"{if $dataObj.flag eq "2"} selected="selected"{/if}>置顶</option>
                                        <option value="3"{if $dataObj.flag eq "3"} selected="selected"{/if}>默认</option>
                                    </select></div>
                                <div class="col-sm-2"><span class="help-inline middle"
                                                            id="TaskArticle_flag_em_">  </span></div>
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
                                                        <a href="fanghuadmin.php?r=taskArticle/create"
                                                           class="btn btn-xs btn-success"><i
                                                                    class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
                                                </span>
                    </div>
                    <div class="table-responsive">
                        <table id="idTable" class="table table-striped table-bordered table-hover"
                               style="width:100%">
                            <thead>
                            <tr>
                                {*<th class="center"> <label class="position-relative">*}
                                {*<input type="checkbox" class="ace" />*}
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
                                    {*<input type="checkbox" class="ace" />*}
                                    {*<span class="lbl"></span> </label></td>*}
                                    {foreach from=$arrAttributeLabels key=attrId item=labelName}
                                        {if $attrId == 'status' && $objModel.status == 1}
                                            <td><span class="label label-sm label-success">有效</span></td>
                                        {elseif $attrId == 'status' && $objModel.status == 0}
                                            <td><span class="label label-sm label-warning">无效</span></td>
                                        {elseif $attrId == 'task_img'}
                                            <td><span class=""><img src="{$objModel.$attrId}" width="100px" alt="任务配图"/></span>
                                            </td>
                                        {elseif $attrId == 'task_detail'}
                                            <td >{substr_replace($objModel.$attrId, '......', 18)}</td>
                                        {elseif $attrId == 'task_url'}
                                            <td><a href="{$objModel.$attrId}">查看任务</a></td>
                                        {else}
                                            <td>{$objModel.$attrId}</td>
                                        {/if}
                                    {/foreach}
                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <a href="fanghuadmin.php?r=taskArticle/view&id={$objModel.$modelId}"
                                               class="btn btn-xs btn-info"> <i
                                                        class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                                            <a href="fanghuadmin.php?r=taskArticle/update&id={$objModel.$modelId}"
                                               class="btn btn-xs btn-success"> <i
                                                        class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                            <button onclick="delConfirm('fanghuadmin.php?r=taskArticle/delete&amp;id={$objModel.$modelId}');"
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
                                                        <a href="fanghuadmin.php?r=taskArticle/view&id={$objModel.$modelId}"
                                                           class="tooltip-info" data-rel="tooltip" title="View"> <span
                                                                    class="blue"> <i
                                                                        class="ace-icon fa fa-search-plus bigger-120"></i> </span>
                                                        </a></li>
                                                    <li>
                                                        <a href="fanghuadmin.php?r=taskArticle/update&id={$objModel.$modelId}"
                                                           class="tooltip-success" data-rel="tooltip" title="Edit">
                                                            <span class="green"> <i
                                                                        class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span>
                                                        </a></li>
                                                    <li>
                                                        <button onclick="delConfirm('fanghuadmin.php?r=taskArticle/delete&amp;id={$objModel.$modelId}');"
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