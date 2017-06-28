<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=picstorage">PicStorageModel</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
                <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
        </div>
        <!-- /.page-header -->



        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        {if $errormsgs}
                            <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">
                                            <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    {$errormsgs}
                            </div>
                        {/if}

                        <form class="form-horizontal" id="picstorage-form" role="form" action="backend.php?r=picstorage/update&id={$model[$primaryKey]}" method="POST">
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
                </div>                                <div class="clearfix form-actions">
                                        <div class="col-md-offset-5 col-md-9">
                                                <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
                                        </div>
                                </div>
                        </form>
                </div>
                <!-- /.col --> 
        </div>
        <!-- /.row --> 
</div>
{if !empty($jsShell)}
    {$jsShell}
{/if}
<!-- /.page-content-area --> 