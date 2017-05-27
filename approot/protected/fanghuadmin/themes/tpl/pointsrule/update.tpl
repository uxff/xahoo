<div class="page-content-area">
        <div class="page-header">
            <h1> <a href="fanghuadmin.php?r=pointsRule">积分规则</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="pointsRule-form" role="form" action="fanghuadmin.php?r=pointsRule/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_key">规则意义</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_key" name="" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_key}" readonly/></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_key_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_name">规则名称</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_name" name="PointsRuleModel[rule_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_name_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_points">积分分值</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_points" name="PointsRuleModel[points]" size="60" maxlength="4" class="col-xs-10 col-sm-5" value="{if ($dataObj.points_desc)}{$dataObj.points_desc}{else}{$dataObj.points}{/if}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="">  </span> </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_key">规则key</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_key" name="PointsRuleModel[rule_key]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_key}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_key_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_desc">规则描述</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_desc" name="PointsRuleModel[desc]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.desc}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_desc_em_">  </span> </div>
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