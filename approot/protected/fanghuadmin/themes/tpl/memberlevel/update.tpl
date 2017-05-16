<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="fanghuadmin.php?r=memberLevel">MemberLevel</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="memberLevel-form" role="form" action="fanghuadmin.php?r=memberLevel/update&id={$model[$primaryKey]}" method="POST">
                              <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberLevel_level_name">会员等级名称</label>
                    <div class="col-sm-7"><input type="text" id="MemberLevel_level_name" name="MemberLevel[level_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.level_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberLevel_level_name_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberLevel_level_contribution_value">等级所需贡献值</label>
                    <div class="col-sm-7"><input type="text" id="MemberLevel_level_contribution_value" name="MemberLevel[level_contribution_value]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.level_contribution_value}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberLevel_level_contribution_value_em_">  </span> </div>
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