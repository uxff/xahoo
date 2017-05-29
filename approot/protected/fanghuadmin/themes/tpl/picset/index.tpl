<div class="page-content-area">
    <div class="page-header">
        <h1> 图库管理<small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
    </div>
    <!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12"> 
            <!-- PAGE CONTENT BEGINS -->
            <div id="searchContainer" >  

                <form class="form-horizontal"  id="picset-form" role="form" action="backend.php?r=picset/index" method="GET">
                    <input type="hidden" name="r" value="{$route}" />

                    <div class="col-xs-12">
                        <br/>
                        <div class="form-group col-xs-3">
                            <label class="col-xs-3 control-label no-padding-right" for="PicSetModel_title">图片标题</label>
                            <div class="col-xs-8">
                                <input class="col-xs-12" type="text" id="PicSetModel_title" name="PicSetModel[title]" size="60"
                                 maxlength="200"  value="{$dataObj.title}" />
                            </div>
                        </div>
                        <div class="form-group col-xs-3">
                            <label class="col-xs-3 control-label no-padding-right" for="PicSetModel_type">图片类型</label>
                            <div class="col-xs-8">
                                <select class="form-control" id="PicSetModel_type" name="PicSetModel[type]" style="width:120px;">
                                <option value="" >请选择</option>
                                <option value="1"{if $dataObj.type eq "1"} selected="selected"{/if}>单张图片</option>
                                <option value="2"{if $dataObj.type eq "2"} selected="selected"{/if}>多张轮播</option>
                                </select>
                            </div>
                        </div>

                        <!--
                        <div class="form-group col-xs-3">
                            <label class="col-sm-23control-label no-padding-right" for="PicSetModel_circle_sec">轮播间隔</label>
                            <div class="col-sm-8"><select class="form-control" id="PicSetModel_circle_sec" name="PicSetModel[circle_sec]" style="width:120px;">   <option value="0"{if $dataObj.circle_sec eq "0"} selected="selected"{/if}>永久停留</option>   <option value="3"{if $dataObj.circle_sec eq "3"} selected="selected"{/if}>3s</option>   <option value="4"{if $dataObj.circle_sec eq "4"} selected="selected"{/if}>4s</option>   <option value="5"{if $dataObj.circle_sec eq "5"} selected="selected"{/if}>5s</option>   <option value="6"{if $dataObj.circle_sec eq "6"} selected="selected"{/if}>6s</option>   <option value="7"{if $dataObj.circle_sec eq "7"} selected="selected"{/if}>7s</option>   <option value="8"{if $dataObj.circle_sec eq "8"} selected="selected"{/if}>8s</option>   <option value="9"{if $dataObj.circle_sec eq "9"} selected="selected"{/if}>9s</option></select></div>
                            <div class="col-sm-2"> <span class="help-inline middle" id="PicSetModel_circle_sec_em_">  </span> </div>
                        </div>
                        

                        <div class="form-group col-xs-3">
                            <label class="col-sm-3 control-label no-padding-right" for="PicSetModel_status">状态:1=有效</label>
                            <div class="col-sm-8"><input type="text" id="PicSetModel_status" name="PicSetModel[status]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.status}" /></div>
                            <div class="col-sm-3"> <span class="help-inline middle" id="PicSetModel_status_em_">  </span> </div>
                        </div>
                        


                        <div class="form-group col-xs-3">
                            <label class="col-sm-4 control-label no-padding-right" for="PicSetModel_admin_id">创建人id</label>
                            <div class="col-sm-8"><input type="text" id="PicSetModel_admin_id" name="PicSetModel[admin_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.admin_id}" /></div>
                            <div class="col-sm-4"> <span class="help-inline middle" id="PicSetModel_admin_id_em_">  </span> </div>
                        </div>
                        -->
                        <div class="form-group col-xs-3">
                            <label class="col-xs-3 control-label no-padding-right" for="PicSetModel_admin_name">创建人</label>
                            <div class="col-xs-8">
                                <input class="col-xs-12" type="text" id="PicSetModel_admin_name" name="PicSetModel[admin_name]" size="60" maxlength="200" value="{$dataObj.admin_name}"/>
                            </div>
                        </div>

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
                            &nbsp;
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
                    <a href="backend.php?r=picset/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
                </span>
            </div>
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>图片标题</th>
                    <th>图片用途</th>
                    <th>图片类型</th>
                    <th>创建人</th>
                    <th>创建时间</th>
                    <th>最后更新时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td>{$i+1}</td>
                    <td>{$objModel.title}</td>
                    <td>
                        {if (isset($arrUsedType[$objModel.used_type]))}
                            {$arrUsedType[$objModel.used_type]}
                        {else}
                            -
                        {/if}
                    </td>
                    <td>
                        {if (isset($arrType[$objModel.type]))}
                            {$arrType[$objModel.type]}
                        {else}
                            -
                        {/if}
                    </td>
                    <td>{$objModel.admin_name}</td>
                    <td>{$objModel.create_time}</td>
                    <td>{$objModel.last_modified}</td>
                    <td><div class="hidden-sm hidden-xs btn-group">
                        <a href="backend.php?r=picset/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                        <a href="backend.php?r=picset/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                        <!--
                        <button onclick="delConfirm('backend.php?r=picset/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                        -->
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div class="inline position-relative">
                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li> <a href="backend.php?r=picset/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                    <li> <a href="backend.php?r=picset/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                    <li> <button onclick="delConfirm('backend.php?r=picset/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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
    </div><!-- /.ol-xs-12 -->
</div><!-- /.row -->
</div>
<!-- /.page-content-area --> 