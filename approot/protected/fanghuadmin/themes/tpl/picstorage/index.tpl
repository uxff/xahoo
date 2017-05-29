<div class="page-content-area">
        <div class="page-header">
                <h1> PicStorageModel <small> <i class="ace-icon fa fa-angle-double-right"></i> List </small> </h1>
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
                                                <form class="form-horizontal"  id="picstorage-form" role="form" action="#" method="GET">
                                                        <input type="hidden" name="r" value="{$route}" />
                                                        <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicStorageModel_pic_set_id">所属图库id</label>
                    <div class="col-sm-7"><input type="text" id="PicStorageModel_pic_set_id" name="PicStorageModel[pic_set_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.pic_set_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicStorageModel_pic_set_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicStorageModel_used_type">使用类型</label>
                    <div class="col-sm-7"><select class="form-control" id="PicStorageModel_used_type" name="PicStorageModel[used_type]" style="width:120px;">   <option value="1"{if $dataObj.used_type eq "1"} selected="selected"{/if}>banner图库</option>   <option value="2"{if $dataObj.used_type eq "2"} selected="selected"{/if}>热门推荐封面图</option>   <option value="3"{if $dataObj.used_type eq "3"} selected="selected"{/if}>任务封面图</option>   <option value="4"{if $dataObj.used_type eq "4"} selected="selected"{/if}>活动CMS上传图</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicStorageModel_used_type_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicStorageModel_file_path">文件路径</label>
                    <div class="col-sm-7"><input type="text" id="PicStorageModel_file_path" name="PicStorageModel[file_path]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.file_path}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicStorageModel_file_path_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicStorageModel_file_ext">文件类型</label>
                    <div class="col-sm-7"><input type="text" id="PicStorageModel_file_ext" name="PicStorageModel[file_ext]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.file_ext}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicStorageModel_file_ext_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicStorageModel_is_local">是否是本服务器路径</label>
                    <div class="col-sm-7"><input type="text" id="PicStorageModel_is_local" name="PicStorageModel[is_local]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.is_local}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicStorageModel_is_local_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PicStorageModel_weight">排序值:越小越靠前</label>
                    <div class="col-sm-7"><input type="text" id="PicStorageModel_weight" name="PicStorageModel[weight]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.weight}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PicStorageModel_weight_em_">  </span> </div>
                </div>
                                                        <div class="clearfix form-actions">
                                                                <div class="col-md-offset-5 col-md-9">
                                                                        <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 查询 </button>
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
                                                        <a href="backend.php?r=picstorage/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
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
                                                                        <td><span class="label label-sm label-success">有效</span></td>
                                                                        {elseif $attrId == 'status' && $objModel.status == 0}
                                                                        <td><span class="label label-sm label-warning">无效</span></td>
                                                                        {else}
                                                                        <td>{$objModel.$attrId}</td>
                                                                        {/if}
                                                                        {/foreach}
                                                                        <td><div class="hidden-sm hidden-xs btn-group">
                                                                                        <a href="backend.php?r=picstorage/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                                                                                        <a href="backend.php?r=picstorage/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                                                                        <button onclick="delConfirm('backend.php?r=picstorage/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                                                                                </div>
                                                                                <div class="hidden-md hidden-lg">
                                                                                        <div class="inline position-relative">
                                                                                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                                                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                                        <li> <a href="backend.php?r=picstorage/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                                                                                        <li> <a href="backend.php?r=picstorage/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                                                                                        <li> <button onclick="delConfirm('backend.php?r=picstorage/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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