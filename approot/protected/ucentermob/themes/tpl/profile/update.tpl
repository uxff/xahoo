<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="index.php?r=profile">UcMember</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="profile-form" role="form" action="index.php?r=profile/update&id={$model[$primaryKey]}" method="POST">
                                <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_fullname">全名</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_fullname" name="UcMember[member_fullname]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_fullname}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_fullname_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_email">邮箱</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_email" name="UcMember[member_email]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_email}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_email_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_mobile">手机</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_mobile" name="UcMember[member_mobile]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_mobile}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_mobile_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_gender">性别</label>
                                        <div class="col-sm-7"><select class="form-control" id="UcMember_member_gender" name="UcMember[member_gender]" style="width:120px;">   <option value="1"{if $dataObj.member_gender eq "1"} selected="selected"{/if}>男</option>   <option value="2"{if $dataObj.member_gender eq "2"} selected="selected"{/if}>女</option>   <option value="0"{if $dataObj.member_gender eq "0"} selected="selected"{/if}>未知</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_gender_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_age">年龄</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_age" name="UcMember[member_age]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_age}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_age_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_birthday">生日</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_birthday" name="UcMember[member_birthday]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_birthday}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_birthday_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_address">地址</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_address" name="UcMember[member_address]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_address}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_address_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_avatar">头像地址</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_avatar" name="UcMember[member_avatar]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_avatar}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_avatar_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_nickname">昵称</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_nickname" name="UcMember[member_nickname]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_nickname}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_nickname_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_password">密码</label>
                                        <div class="col-sm-7"><input type="text" id="UcMember_member_password" name="UcMember[member_password]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_password}" /></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_password_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_newsletter">是否订阅newsletter</label>
                                        <div class="col-sm-7"><select class="form-control" id="UcMember_is_newsletter" name="UcMember[is_newsletter]" style="width:120px;">   <option value="1"{if $dataObj.is_newsletter eq "1"} selected="selected"{/if}>是</option>   <option value="0"{if $dataObj.is_newsletter eq "0"} selected="selected"{/if}>否</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_newsletter_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_email_actived">邮箱是否激活</label>
                                        <div class="col-sm-7"><select class="form-control" id="UcMember_is_email_actived" name="UcMember[is_email_actived]" style="width:120px;">   <option value="1"{if $dataObj.is_email_actived eq "1"} selected="selected"{/if}>激活</option>   <option value="0"{if $dataObj.is_email_actived eq "0"} selected="selected"{/if}>未激活</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_email_actived_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_mobile_actived">手机是否激活</label>
                                        <div class="col-sm-7"><select class="form-control" id="UcMember_is_mobile_actived" name="UcMember[is_mobile_actived]" style="width:120px;">   <option value="1"{if $dataObj.is_mobile_actived eq "1"} selected="selected"{/if}>激活</option>   <option value="0"{if $dataObj.is_mobile_actived eq "0"} selected="selected"{/if}>未激活</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_mobile_actived_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_actived">是否激活</label>
                                        <div class="col-sm-7"><select class="form-control" id="UcMember_is_actived" name="UcMember[is_actived]" style="width:120px;">   <option value="1"{if $dataObj.is_actived eq "1"} selected="selected"{/if}>激活</option>   <option value="0"{if $dataObj.is_actived eq "0"} selected="selected"{/if}>未激活</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_actived_em_">  </span> </div>
                                </div><div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="UcMember_status">状态</label>
                                        <div class="col-sm-7"><select class="form-control" id="UcMember_status" name="UcMember[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>   <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>   <option value="99"{if $dataObj.status eq "99"} selected="selected"{/if}>删除</option></select></div>
                                        <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_status_em_">  </span> </div>
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