<div class="page-content-area">
    <div class="page-header">
        <h1><a href="backend.php?r=member">Member</a>
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

            <form class="form-horizontal" id="member-form" role="form"
                  action="backend.php?r=member/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_account">会员帐号</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_account" name="Member[member_account]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_account}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_account_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_password">会员密码</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_password" name="Member[member_password]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value=""/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_password_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_from">会员来源</label>

                    <div class="col-sm-7"><select class="form-control" id="Member_member_from"
                                                  name="Member[member_from]" style="width:120px;">
                            <option value="1"{if $dataObj.member_from eq "1"} selected="selected"{/if}>注册</option>
                            <option value="2"{if $dataObj.member_from eq "2"} selected="selected"{/if}>邀请</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_from_em_">  </span></div>
                </div>
                {*<div class="form-group">*}
                {*<label class="col-sm-2 control-label no-padding-right" for="Member_has_children">是否有小伙伴</label>*}

                {*<div class="col-sm-7"><select class="form-control" id="Member_has_children"*}
                {*name="Member[has_children]" style="width:120px;">*}
                {*<option value="0"{if $dataObj.has_children eq "0"} selected="selected"{/if}>没有</option>*}
                {*<option value="1"{if $dataObj.has_children eq "1"} selected="selected"{/if}>有</option>*}
                {*</select></div>*}
                {*<div class="col-sm-2"><span class="help-inline middle" id="Member_has_children_em_">  </span></div>*}
                {*</div>*}
                {*<div class="form-group">*}
                {*<label class="col-sm-2 control-label no-padding-right" for="Member_parent_id">会员上级编号</label>*}

                {*<div class="col-sm-7"><input type="text" id="Member_parent_id" name="Member[parent_id]" size="60"*}
                {*maxlength="200" class="col-xs-10 col-sm-5"*}
                {*value="{$dataObj.parent_id}"/></div>*}
                {*<div class="col-sm-2"><span class="help-inline middle" id="Member_parent_id_em_">  </span></div>*}
                {*</div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_level_id">会员等级ID</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_level_id" name="Member[member_level_id]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_level_id}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_level_id_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_name">会员姓名</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_name" name="Member[member_name]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_name}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_name_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_sex">性别</label>

                    <div class="col-sm-7"><select class="form-control" id="Member_member_sex" name="Member[member_sex]"
                                                  style="width:120px;">
                            <option value="1"{if $dataObj.member_sex eq "1"} selected="selected"{/if}>男</option>
                            <option value="2"{if $dataObj.member_sex eq "2"} selected="selected"{/if}>女</option>
                            <option value='0'{if $dataObj.member_sex eq "0"} selected="selected"{/if}>保密</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_sex_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_birthday">会员生日</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_birthday" name="Member[member_birthday]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_birthday}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_birthday_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_mobile">会员手机号</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_mobile" name="Member[member_mobile]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_mobile}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_mobile_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="Member_member_mobile_verified">会员手机号是否认证</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_mobile_verified"
                                                 name="Member[member_mobile_verified]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.member_mobile_verified}"/>
                    </div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="Member_member_mobile_verified_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_nickname">会员昵称</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_nickname" name="Member[member_nickname]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_nickname}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_nickname_em_">  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_email">会员电子邮箱</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_email" name="Member[member_email]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_email}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_email_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right"
                           for="Member_member_email_verified">会员电子邮箱是否认证</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_email_verified"
                                                 name="Member[member_email_verified]" size="60" maxlength="200"
                                                 class="col-xs-10 col-sm-5" value="{$dataObj.member_email_verified}"/>
                    </div>
                    <div class="col-sm-2"><span class="help-inline middle"
                                                id="Member_member_email_verified_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_avatar">会员头像</label>

                    <div class="col-sm-7"><input type="text" id="Member_member_avatar" name="Member[member_avatar]"
                                                 size="60" maxlength="200" class="col-xs-10 col-sm-5"
                                                 value="{$dataObj.member_avatar}"/></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_member_avatar_em_">  </span></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_status">状态</label>

                    <div class="col-sm-7"><select class="form-control" id="Member_status" name="Member[status]"
                                                  style="width:120px;">
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>
                            <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>锁定</option>
                        </select></div>
                    <div class="col-sm-2"><span class="help-inline middle" id="Member_status_em_">  </span></div>
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