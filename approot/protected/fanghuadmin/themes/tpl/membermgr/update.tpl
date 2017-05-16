<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="fanghuadmin.php?r=memberMgr">会员列表</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="memberMgr-form" role="form" action="fanghuadmin.php?r=memberMgr/update&id={$model[$primaryKey]}" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_name">会员姓名</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_name" name="Member[member_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_name_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_mobile">会员手机号</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_mobile" name="" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_mobile}" readonly/></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_mobile_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_nickname">会员昵称</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_nickname" name="Member[member_nickname]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_nickname}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_nickname_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_email">邮箱地址</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_email" name="Member[member_email]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_email}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_email_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_id_number">会员身份证号</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_id_number" name="Member[member_id_number]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id_number}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_id_number_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_status">状态</label>
                    <div class="col-sm-7">
                        <select class="form-control" id="Member_status" name="Member[status]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>
                        <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>无效</option>
                        </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_status_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_address">邮寄地址</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_address" name="Member[member_address]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_address}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_address_em_">  </span> </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_account">会员帐号</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_account" name="Member[member_account]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_account}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_account_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_from">会员来源</label>
                    <div class="col-sm-7">
                    <select class="form-control" id="Member_member_from" name="Member[member_from]" style="width:120px;">
                    <option value="1"{if $dataObj.member_from eq "1"} selected="selected"{/if}>注册</option>
                    <option value="2"{if $dataObj.member_from eq "2"} selected="selected"{/if}>邀请</option>
                    </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_from_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_level_id">会员等级ID</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_level_id" name="Member[member_level_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_level_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_level_id_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_sex">性别</label>
                    <div class="col-sm-7"><select class="form-control" id="Member_member_sex" name="Member[member_sex]" style="width:120px;">   <option value="1"{if $dataObj.member_sex eq "1"} selected="selected"{/if}></option>   <option value="男"{if $dataObj.member_sex eq "男"} selected="selected"{/if}>2</option>   <option value="女"{if $dataObj.member_sex eq "女"} selected="selected"{/if}>0</option>   <option value="未知"{if $dataObj.member_sex eq "未知"} selected="selected"{/if}></option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_sex_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_is_married">婚恋状态</label>
                    <div class="col-sm-7"><select class="form-control" id="Member_member_is_married" name="Member[member_is_married]" style="width:120px;">   <option value="0"{if $dataObj.member_is_married eq "0"} selected="selected"{/if}>未婚</option>   <option value="1"{if $dataObj.member_is_married eq "1"} selected="selected"{/if}>已婚</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_is_married_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_birthday">会员生日</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_birthday" name="Member[member_birthday]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_birthday}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_birthday_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_mobile_verified">会员手机号是否认证</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_mobile_verified" name="Member[member_mobile_verified]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_mobile_verified}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_mobile_verified_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_identify_verified">是否通过身份验证</label>
                    <div class="col-sm-7"><select class="form-control" id="Member_member_identify_verified" name="Member[member_identify_verified]" style="width:120px;">   <option value="0"{if $dataObj.member_identify_verified eq "0"} selected="selected"{/if}></option>   <option value="未通过"{if $dataObj.member_identify_verified eq "未通过"} selected="selected"{/if}>1</option>   <option value="已通过"{if $dataObj.member_identify_verified eq "已通过"} selected="selected"{/if}></option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_identify_verified_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_qq">会员qq号</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_qq" name="Member[member_qq]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_qq}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_qq_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_email_verified">会员电子邮箱是否认证</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_email_verified" name="Member[member_email_verified]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_email_verified}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_email_verified_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_member_avatar">会员头像</label>
                    <div class="col-sm-7"><input type="text" id="Member_member_avatar" name="Member[member_avatar]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_avatar}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_member_avatar_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_signage">会员标识</label>
                    <div class="col-sm-7"><input type="text" id="Member_signage" name="Member[signage]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.signage}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_signage_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_has_children">是否有小伙伴</label>
                    <div class="col-sm-7"><select class="form-control" id="Member_has_children" name="Member[has_children]" style="width:120px;">   <option value="0"{if $dataObj.has_children eq "0"} selected="selected"{/if}>没有</option>   <option value="1"{if $dataObj.has_children eq "1"} selected="selected"{/if}>有</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_has_children_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="Member_parent_id">会员上级编号</label>
                    <div class="col-sm-7"><input type="text" id="Member_parent_id" name="Member[parent_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.parent_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="Member_parent_id_em_">  </span> </div>
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