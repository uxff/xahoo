
<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="backend.php?r=pointsLevel">PointsLevelModel</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
                <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <!--
                        <div class="alert alert-block alert-success">
                                <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                </button>
                                <i class="ace-icon fa fa-check green"></i>
            
                        </div>
                        -->
                        {if $errormsgs}
                        <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                </button>
                                {$errormsgs}
                        </div>
                        {/if}

                        <form class="form-horizontal"  id="pointsLevel-form" role="form" action="backend.php?r=pointsLevel/create" method="POST">
                            <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_min_points">等级最少需要的积分</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_min_points" name="PointsLevelModel[min_points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.min_points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_min_points_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_max_points">等级需要的最多积分</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_max_points" name="PointsLevelModel[max_points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.max_points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_max_points_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_name">等级名称</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_name" name="PointsLevelModel[name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_name_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_desc">等级描述</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_desc" name="PointsLevelModel[desc]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.desc}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_desc_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_thumb_url">显示缩略图</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_thumb_url" name="PointsLevelModel[thumb_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.thumb_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_thumb_url_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_title">等级头衔</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_title" name="PointsLevelModel[title]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_title_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsLevelModel_title2">等级头衔2</label>
                    <div class="col-sm-7"><input type="text" id="PointsLevelModel_title2" name="PointsLevelModel[title2]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.title2}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsLevelModel_title2_em_">  </span> </div>
                </div>                                <!--
                                {foreach from=$FormElements key=attributeName item=item}
                                {if !$item.autoIncrement}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="{$modelName}_{$attributeName}"> {$item.comment}: </label>
                                    <div class="col-sm-7">
                                        <input type="text" id="{$modelName}_{$attributeName}" name="{$modelName}[{$attributeName}]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="" />
                                    </div>
                                    <div class="col-sm-2"> <span class="help-inline middle" id="{$modelName}_{$attributeName}_em_"> </span> </div>
                                </div>
                                {/if}
                                {/foreach}
                                -->
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