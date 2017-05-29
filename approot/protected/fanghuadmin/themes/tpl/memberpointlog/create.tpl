
<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=memberPointLog">MemberPointLog</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="memberPointLog-form" role="form" action="backend.php?r=memberPointLog/create" method="POST">
                            <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_member_id">会员id</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_member_id" name="MemberPointLog[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_member_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_rule_id">积分规则id</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_rule_id" name="MemberPointLog[rule_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_rule_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_rule_point">积分分值</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_rule_point" name="MemberPointLog[rule_point]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_point}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_rule_point_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_operate_type">操作类型</label>
                    <div class="col-sm-7"><select class="form-control" id="MemberPointLog_operate_type" name="MemberPointLog[operate_type]" style="width:120px;">     <option value="1"{if $dataObj.operate_type eq "1"} selected="selected"{/if}>加</option>   <option value="2"{if $dataObj.operate_type eq "2"} selected="selected"{/if}>减</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_operate_type_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_description">描述</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_description" name="MemberPointLog[description]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.description}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_description_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_point_before">之前积分数量</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_point_before" name="MemberPointLog[point_before]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.point_before}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_point_before_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberPointLog_point_after">之后积分数量</label>
                    <div class="col-sm-7"><input type="text" id="MemberPointLog_point_after" name="MemberPointLog[point_after]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.point_after}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberPointLog_point_after_em_">  </span> </div>
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