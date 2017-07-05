<div class="page-content-area">
    <div class="page-header">
        <h1><a href="backend.php?r=securityQuestion">SecurityQuestion</a>
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

            <form class="form-horizontal" id="securityQuestion-form" role="form"
                  action="backend.php?r=securityQuestion/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="SecurityQuestion_question_text">密保问题内容</label>

                    <div class="col-sm-7"><input type="text" id="SecurityQuestion_question_text"
                                                 name="SecurityQuestion[question_text]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.question_text}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="SecurityQuestion_question_text_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="SecurityQuestion_answer_rule">答案规则</label>

                    <div class="col-sm-7"><input type="text" id="SecurityQuestion_answer_rule"
                                                 name="SecurityQuestion[answer_rule]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.answer_rule}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="SecurityQuestion_answer_rule_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SecurityQuestion_status">密保问题状态</label>

                    <div class="col-sm-7">
                        <select class="form-control" id="SecurityQuestion_status" name="SecurityQuestion[status]"
                                style="width:120px;">
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><span class="help-inline middle" id="SecurityQuestion_status_em_">  </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SecurityQuestion_status">密保答案类型</label>

                    <div class="col-sm-7">
                        <select class="form-control" id="SecurityQuestion_status" name="SecurityQuestion[answer_type]"
                                style="width:120px;">
                            <option value="1"{if $dataObj.answer_type eq "1"} selected="selected"{/if}>姓名</option>
                            <option value="2"{if $dataObj.answer_type eq "2"} selected="selected"{/if}>日期</option>
                            <option value="3"{if $dataObj.answer_type eq "3"} selected="selected"{/if}>数字</option>
                        </select>
                    </div>
                    <div class="col-sm-2"><span class="help-inline middle" id="SecurityQuestion_status_em_">  </span>
                    </div>
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