<div class="page-content-area">
<div class="page-header">
    <h1> 活动管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表</small> </h1>
</div>
<div class="row">
    <div class="col-xs-12"> 
        <!-- PAGE CONTENT BEGINS -->
    <!--
    <a href="#" onclick="$('#searchContainer').toggle();return false">检索条件</a><br />
    -->
    <div id="searchContainer" >
        <form class="form-horizontal"  id="actcms-form" role="form" action="backend.php?r=actcms/index" method="GET">
            <input type="hidden" name="r" value="{$route}" />
                
            <div class="col-xs-12">
                <br/>
                <div class="form-group  col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="ArticleModel_title">活动名称</label>
                    <div class="col-xs-8"><input type="text" id="ArticleModel_title" name="ArticleModel[title]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.title}" /></div>
                </div>
                <div class="form-group  col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="ArticleModel_type">活动分类</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="ArticleModel_type" name="ArticleModel[type]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.type eq "1"} selected="selected"{/if}>活动分享</option>
                        <option value="2"{if $dataObj.type eq "2"} selected="selected"{/if}>项目分享</option>
                        <option value="3"{if $dataObj.type eq "3"} selected="selected"{/if}>企业资讯</option>
                        <option value="4"{if $dataObj.type eq "4"} selected="selected"{/if}>其他</option>
                        </select>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_content">内容</label>
                    <div class="col-sm-7"><textarea id="ArticleModel_content" name="ArticleModel[content]" class="col-xs-10 col-sm-5" placeholder="内容">{$dataObj.content}</textarea></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_content_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_visit_url">本文对外链接</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_visit_url" name="ArticleModel[visit_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.visit_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_visit_url_em_">  </span> </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_abstract">摘要</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_abstract" name="ArticleModel[abstract]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.abstract}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_abstract_em_">  </span> </div>
                </div>
                -->
                <div class="form-group col-xs-3">
                    <label class="col-sm-3 control-label no-padding-right" for="ArticleModel_status">活动状态</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="ArticleModel_status" name="ArticleModel[status]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>未发布</option>
                        <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>已发布</option>
                        <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>已撤销</option>
                        </select>
                    </div>
                    <div class="col-sm-3"> <span class="help-inline middle" id="ArticleModel_status_em_">  </span> </div>
                </div>

                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_remark">备注</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_remark" name="ArticleModel[remark]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.remark}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_remark_em_">  </span> </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_view_count">阅读量</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_view_count" name="ArticleModel[view_count]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.view_count}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_view_count_em_">  </span> </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_share_count">分享次数</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_share_count" name="ArticleModel[share_count]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.share_count}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_share_count_em_">  </span> </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_favor_count">收藏数量</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_favor_count" name="ArticleModel[favor_count]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.favor_count}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_favor_count_em_">  </span> </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_comment_count">评论数量</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_comment_count" name="ArticleModel[comment_count]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.comment_count}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_comment_count_em_">  </span> </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="ArticleModel_admin_id">创建人id</label>
                    <div class="col-sm-7"><input type="text" id="ArticleModel_admin_id" name="ArticleModel[admin_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.admin_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="ArticleModel_admin_id_em_">  </span> </div>
                </div>
                -->

                 <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="create_time">创建时间</label>
                    <div class="col-xs-8">
                        <div class="input-group lablediv1" style="width:270px;" style="float:right;">
                            <input type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd"
                                   id="create_time_start" name="condition[create_time_start]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$condition.create_time_start}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            <input type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd"
                                   id="create_time_end" name="condition[create_time_end]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$condition.create_time_end}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12">
                <div class="form-group col-xs-3">
                    <label class="col-sm-3 control-label no-padding-right" for="ArticleModel_admin_name">创建人</label>
                    <div class="col-sm-8"><input type="text" id="ArticleModel_admin_name" name="ArticleModel[admin_name]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.admin_name}" /></div>
                    <div class="col-sm-3"> <span class="help-inline middle" id="ArticleModel_admin_name_em_">  </span> </div>
                </div>
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                    <div class="col-xs-offset-2 col-xs-11" style="display:inline-block; white-space:nowrap;">
                        <button style="float:right;width:120px;" class="btn btn-info col-xs-12" type="submit"> 查询 </button>
                        <!--
                        <button style="float:right;width:120px;" class="btn btn-info col-xs-12" type="submit" name="export" value="export"> 导出 </button>
                        -->
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
            </div>
            </form>
        </div>
        <div class="table-header">
            {if $pages.totalCount>$pages.pageSize}
            <!--
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.curPage*$pages.pageSize} of {$pages.totalCount} results
            -->
                共{$pages.totalCount}条记录，当前为第{($pages.curPage-1)*$pages.pageSize+1}到{$pages.curPage*$pages.pageSize}条记录
            {else}
                <!--
                Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.totalCount} of {$pages.totalCount} results
                -->
                共{$pages.totalCount}条记录，当前为第{($pages.curPage-1)*$pages.pageSize+1} 到{$pages.totalCount}条记录
            {/if}
            <span class="pull-right">
                    <a href="backend.php?r=actcms/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
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
                    <td>{$i+1}</td>
                    <td>{$objModel.title}</td>
						<td style="font-size:10px;">{$objModel.visit_url}</td>
                    <td>
                        {if isset($arrType[$objModel.type])}
                            {$arrType[$objModel.type]}
                        {else}
                            <span title="其他未知类型：{$objModel.type}">其他</span>
                        {/if}
                    </td>
                    <td>{$objModel.admin_name}</td>
                    <td>{$objModel.last_modified}</td>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                            <a href="backend.php?r=actcms/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                            <a href="backend.php?r=actcms/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                           
                            <!--
                            <button onclick="delConfirm('backend.php?r=actcms/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                            -->
                            </div>
                            <div class="hidden-md hidden-lg">
                                <div class="inline position-relative">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li> <a href="backend.php?r=actcms/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                        <li> <a href="backend.php?r=actcms/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                        <li> <button onclick="delConfirm('backend.php?r=actcms/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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
        </div><!-- /.col-xs-12 -->
    </div><!-- /.row -->
</div>
    <!-- /.page-content-area --> 