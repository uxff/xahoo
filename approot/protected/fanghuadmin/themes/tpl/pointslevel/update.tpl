<div class="page-content-area">
        <div class="page-header">
            <h1> <a href="fanghuadmin.php?r=pointsLevel">会员您登记</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="pointsLevel-form" role="form" action="fanghuadmin.php?r=pointsLevel/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="">等级</label>
                    <div class="col-sm-7">
                        <input type="text" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="LV{$dataObj.level_id}" disabled/>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_max_points">积分</label>
                    <div class="col-sm-7">
                        <input type="text" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$objModel.min_points}{if $objModel.max_points>0}-{$objModel.max_points}{else}以上{/if}" disabled/>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_title">等级名称</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_title" name="PointsLevelModel[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_title_em_">  </span> </div>
                </div>
                <div class="clearfix form-actions">
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