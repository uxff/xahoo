
<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="backend.php?r=pointsRule">积分规则</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="pointsRule-form" role="form" action="backend.php?r=pointsRule/create" method="POST">
                            <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_key">规则key</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_key" name="PointsRuleModel[rule_key]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_key}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_key_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_rule_name">中文名称</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_rule_name" name="PointsRuleModel[rule_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_rule_name_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_desc">规则描述</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_desc" name="PointsRuleModel[desc]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.desc}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_desc_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_points">规则对应的积分数</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_points" name="PointsRuleModel[points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_points_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_flag">标记：1=普通规则;2=可变规则(任务)</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_flag" name="PointsRuleModel[flag]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.flag}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_flag_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointsRuleModel_status">状态：1=有效；2=无效</label>
                    <div class="col-sm-7"><input type="text" id="PointsRuleModel_status" name="PointsRuleModel[status]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.status}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="PointsRuleModel_status_em_">  </span> </div>
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