<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="fanghuadmin.php?r=memberBrokerageLog">MemberBrokerageLog</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="memberBrokerageLog-form" role="form" action="fanghuadmin.php?r=memberBrokerageLog/update&id={$model[$primaryKey]}" method="POST">
                              <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberBrokerageLog_member_id">会员id</label>
                    <div class="col-sm-7"><input type="text" id="MemberBrokerageLog_member_id" name="MemberBrokerageLog[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberBrokerageLog_member_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberBrokerageLog_brokerage_before">之前佣金</label>
                    <div class="col-sm-7"><input type="text" id="MemberBrokerageLog_brokerage_before" name="MemberBrokerageLog[brokerage_before]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.brokerage_before}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberBrokerageLog_brokerage_before_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberBrokerageLog_brokerage_after">之后佣金</label>
                    <div class="col-sm-7"><input type="text" id="MemberBrokerageLog_brokerage_after" name="MemberBrokerageLog[brokerage_after]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.brokerage_after}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberBrokerageLog_brokerage_after_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberBrokerageLog_brokerage_time">创建时间</label>
                    <div class="col-sm-7"><input type="text" id="MemberBrokerageLog_brokerage_time" name="MemberBrokerageLog[brokerage_time]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.brokerage_time}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberBrokerageLog_brokerage_time_em_">  </span> </div>
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