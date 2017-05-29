<div class="page-content-area">
    <div class="page-header">
        <h1><a href="backend.php?r=pointRule">PointRule</a>
            <small><i class="ace-icon fa fa-angle-double-right"></i> 编辑</small>
        </h1>
        <br/>

        <h1> 提示信息：
            <small> 以下均为必选项</small>
        </h1>
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

            <form class="form-horizontal" id="pointRule-form" role="form"
                  action="backend.php?r=pointRule/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointRule_rule_name">积分规则名称</label>

                    <div class="col-sm-7"><input type="text" id="PointRule_rule_name" name="PointRule[rule_name]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.rule_name}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointRule_rule_name_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointRule_rule_action">积分动作</label>

                    <div class="col-sm-7"><input type="text" id="PointRule_rule_action" name="PointRule[rule_action]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.rule_action}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointRule_rule_action_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointRule_rule_point">积分分值</label>

                    <div class="col-sm-7"><input type="text" id="PointRule_rule_point" name="PointRule[rule_point]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.rule_point}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointRule_rule_point_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="PointRule_rule_contribution">贡献分值</label>

                    <div class="col-sm-7"><input type="text" id="PointRule_rule_contribution"
                                                 name="PointRule[rule_contribution]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.rule_contribution}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="PointRule_rule_contribution_em_">  </span></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="PointRule_status">状态</label>

                    <div class="col-sm-7"><select class="form-control" id="PointRule_status" name="PointRule[status]"
                                                  style="width:120px;">
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="PointRule_status_em_">  </span></div>
                </div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn btn-info" type="submit"><i class="ace-icon fa fa-check bigger-110"></i> 提交
                        </button>
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