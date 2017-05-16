<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="fanghuadmin.php?r=pointsRule">积分规则</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                <!--
                                        <a href="#" onclick="$('#searchContainer').toggle();
                                                    return false">检索条件</a><br />
                                        <div id="searchContainer" style="display: {if $searchForm}block;{else}none;{/if}">                                      
                                                <form class="form-horizontal"  id="pointsRule-form" role="form" action="#" method="GET">
                                                        <input type="hidden" name="r" value="{$route}" />
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_key">规则key</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_key" name="PointsRuleModel[rule_key]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_key}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_key_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_name">中文名称</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_name" name="PointsRuleModel[rule_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_name_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_desc">规则描述</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_desc" name="PointsRuleModel[desc]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.desc}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_desc_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_points">规则对应的积分数</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_points" name="PointsRuleModel[points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_points_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_flag">标记：1=普通规则;2=可变规则(任务)</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_flag" name="PointsRuleModel[flag]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.flag}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_flag_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_status">状态：1=有效；2=无效</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_status" name="PointsRuleModel[status]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.status}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_status_em_">  </span> </div>
                </div>
                                                        <div class="clearfix form-actions">
                                                                <div class="col-md-offset-5 col-md-9">
                                                                        <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
                                                                </div>
                                                        </div>
                                                </form>
                                        </div>
                -->
        <div class="table-header">
            {if $pages.totalCount>$pages.pageSize}
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.curPage*$pages.pageSize} of {$pages.totalCount} results
            {else}
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.totalCount} of {$pages.totalCount} results
            {/if}
            <!--
            <span class="pull-right">
                    <a href="fanghuadmin.php?r=pointsRule/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
            </span>
            -->
        </div>
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>规则名称</th>
                    <th>积分分值</th>
                    <th>创建时间</th>
                    <th>最后更新时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td>{$i+($pages.curPage-1)*$pages.pageSize+1}</td>
                    <td>{$objModel.rule_name}</td>
                    <td>{if ($objModel.points_desc)}{$objModel.points_desc}{else}{$objModel.points}{/if}</td>
                    <td>{$objModel.create_time}</td>
                    <td>{$objModel.last_modified}</td>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                            <!--
                            <a href="fanghuadmin.php?r=pointsRule/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                            -->
                            <a href="fanghuadmin.php?r=pointsRule/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                            <!--
                            <button onclick="delConfirm('fanghuadmin.php?r=pointsRule/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                            -->
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div class="inline position-relative">
                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li> <a href="fanghuadmin.php?r=pointsRule/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                    <li> <a href="fanghuadmin.php?r=pointsRule/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                    <li> <button onclick="delConfirm('fanghuadmin.php?r=pointsRule/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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
                </div><!-- /.ol-xs-12 -->
        </div><!-- /.row -->
</div>
<!-- /.page-content-area --> 