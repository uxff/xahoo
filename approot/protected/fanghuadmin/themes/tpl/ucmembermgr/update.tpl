<div class="page-content-area">
        <div class="page-header">
            <h1> <a href="backend.php?r=ucMemberMgr">会员列表</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="ucMemberMgr-form" role="form" action="backend.php?r=ucMemberMgr/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_fullname">会员姓名</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_fullname" name="UcMember[member_fullname]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_fullname}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_fullname_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_mobile">会员手机号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_mobile" name="" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_mobile}" readonly/></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_mobile_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_nickname">会员昵称</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_nickname" name="UcMember[member_nickname]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_nickname}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_nickname_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_email">邮箱地址</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_email" name="UcMember[member_email]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_email}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_email_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_id_number">会员身份证号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_id_number" name="UcMember[member_id_number]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id_number}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_id_number_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_status">状态</label>
                    <div class="col-sm-7">
                        <select class="form-control" id="UcMember_status" name="UcMember[status]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                        <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>无效</option>
                        </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_status_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_address">邮寄地址</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_address" name="UcMember[member_address]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_address}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_address_em_">  </span> </div>
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