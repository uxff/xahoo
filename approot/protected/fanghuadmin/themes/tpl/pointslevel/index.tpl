<div class="page-content-area">
        <div class="page-header">
                <h1> 积分等级 <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
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
                                                <form class="form-horizontal"  id="pointsLevel-form" role="form" action="#" method="GET">
                                                        <input type="hidden" name="r" value="{$route}" />
                                                        <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_min_points">等级最少需要的积分</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_min_points" name="PointsLevelModel[min_points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.min_points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_min_points_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_max_points">等级需要的最多积分</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_max_points" name="PointsLevelModel[max_points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.max_points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_max_points_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_name">等级名称</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_name" name="PointsLevelModel[name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_name_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_desc">等级描述</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_desc" name="PointsLevelModel[desc]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.desc}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_desc_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_thumb_url">显示缩略图</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_thumb_url" name="PointsLevelModel[thumb_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.thumb_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_thumb_url_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_title">等级头衔</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_title" name="PointsLevelModel[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_title_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_title2">等级头衔2</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_title2" name="PointsLevelModel[title2]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title2}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_title2_em_">  </span> </div>
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
                            <a href="backend.php?r=pointsLevel/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
                    </span>
                    -->
            </div>
            <div class="table-responsive">
                <table id="idTable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>等级</th>
                        <th>积分</th>
                        <th>等级名称</th>
                        <th>创建时间</th>
                        <th>最后更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td>{$i+1}</td>
                    <td>LV{$objModel.level_id}</td>
                    <td>
                        {$objModel.min_points}
                        {if $objModel.max_points>0}
                            - {$objModel.max_points}
                        {else}
                            以上
                        {/if}
                    </td>
                    <td>{$objModel.title}</td>
                    <td>{$objModel.create_time}</td>
                    <td>{$objModel.last_modified}</td>
                    <td>
                    <div class="hidden-sm hidden-xs btn-group">
                        <!--
                        <a href="backend.php?r=pointsLevel/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                        -->
                        <a href="backend.php?r=pointsLevel/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                        <!--
                        <button onclick="delConfirm('backend.php?r=pointsLevel/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                        -->
                        </div>
                        <div class="hidden-md hidden-lg">
                                <div class="inline position-relative">
                                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                <li> <a href="backend.php?r=pointsLevel/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                                <li> <a href="backend.php?r=pointsLevel/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                                <li> <button onclick="delConfirm('backend.php?r=pointsLevel/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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