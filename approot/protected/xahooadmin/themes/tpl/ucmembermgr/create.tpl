
<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="xqsjadmin.php?r=ucMemberMgr">UcMember</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="ucMemberMgr-form" role="form" action="xqsjadmin.php?r=ucMemberMgr/create" method="POST">
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
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_qq">会员qq号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_qq" name="UcMember[member_qq]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_qq}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_qq_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_id_number">会员身份证号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_id_number" name="UcMember[member_id_number]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id_number}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_id_number_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_gender">性别</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_member_gender" name="UcMember[member_gender]" style="width:120px;">   <option value="1"{if $dataObj.member_gender eq "1"} selected="selected"{/if}>男</option>   <option value="2"{if $dataObj.member_gender eq "2"} selected="selected"{/if}>女</option>   <option value="0"{if $dataObj.member_gender eq "0"} selected="selected"{/if}>未知</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_gender_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_marriage_status">婚恋状态</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_member_marriage_status" name="UcMember[member_marriage_status]" style="width:120px;">   <option value="1"{if $dataObj.member_marriage_status eq "1"} selected="selected"{/if}>未婚</option>   <option value="2"{if $dataObj.member_marriage_status eq "2"} selected="selected"{/if}>已婚</option>   <option value="3"{if $dataObj.member_marriage_status eq "3"} selected="selected"{/if}>离异</option>   <option value="0"{if $dataObj.member_marriage_status eq "0"} selected="selected"{/if}>未设置</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_marriage_status_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_age">年龄</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_age" name="UcMember[member_age]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_age}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_age_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_mail_code">用户邮编</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_mail_code" name="UcMember[member_mail_code]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_mail_code}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_mail_code_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_province">会员省份编号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_province" name="UcMember[member_province]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_province}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_province_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_city">会员城市编号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_city" name="UcMember[member_city]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_city}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_city_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_district">会员区编号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_district" name="UcMember[member_district]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_district}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_district_em_">  </span> </div>
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
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_deal_password">交易密码</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_deal_password" name="UcMember[deal_password]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.deal_password}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_deal_password_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_dealpwd_lock_time">交易密码锁定时间</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_dealpwd_lock_time" name="UcMember[dealpwd_lock_time]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.dealpwd_lock_time}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_dealpwd_lock_time_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_mod_dealpwd_num">交易密码修改次数</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_mod_dealpwd_num" name="UcMember[mod_dealpwd_num]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.mod_dealpwd_num}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_mod_dealpwd_num_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_signage">会员标识</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_signage" name="UcMember[signage]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.signage}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_signage_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_has_children">是否有小伙伴</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_has_children" name="UcMember[has_children]" style="width:120px;">   <option value="0"{if $dataObj.has_children eq "0"} selected="selected"{/if}>没有</option>   <option value="1"{if $dataObj.has_children eq "1"} selected="selected"{/if}>有</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_has_children_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_parent_id">会员上级编号</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_parent_id" name="UcMember[parent_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.parent_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_parent_id_em_">  </span> </div>
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
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_idnumber_actived">是否通过身份验证</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_is_idnumber_actived" name="UcMember[is_idnumber_actived]" style="width:120px;">   <option value="0"{if $dataObj.is_idnumber_actived eq "0"} selected="selected"{/if}></option>   <option value="未通过"{if $dataObj.is_idnumber_actived eq "未通过"} selected="selected"{/if}>1</option>   <option value="已通过"{if $dataObj.is_idnumber_actived eq "已通过"} selected="selected"{/if}></option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_idnumber_actived_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_actived">是否激活</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_is_actived" name="UcMember[is_actived]" style="width:120px;">   <option value="1"{if $dataObj.is_actived eq "1"} selected="selected"{/if}>激活</option>   <option value="0"{if $dataObj.is_actived eq "0"} selected="selected"{/if}>未激活</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_actived_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_status">状态</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_status" name="UcMember[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>   <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option>   <option value="99"{if $dataObj.status eq "99"} selected="selected"{/if}>删除</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_status_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_send">是否给用户发短信,1发送,0未发送</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_is_send" name="UcMember[is_send]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.is_send}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_send_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_admin_id">添加会员客服id</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_admin_id" name="UcMember[admin_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.admin_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_admin_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_from">会员来源</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_member_from" name="UcMember[member_from]" style="width:120px;">   <option value="1"{if $dataObj.member_from eq "1"} selected="selected"{/if}>后台添加</option>   <option value="2"{if $dataObj.member_from eq "2"} selected="selected"{/if}>注册</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_from_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_finance">是否是理财用户</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_is_finance" name="UcMember[is_finance]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.is_finance}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_finance_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_name">姓名</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_name" name="UcMember[member_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_name_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_work_province">工作省份</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_work_province" name="UcMember[member_work_province]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_work_province}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_work_province_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_work_city">工作城市</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_work_city" name="UcMember[member_work_city]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_work_city}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_work_city_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_work_county">工作县</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_work_county" name="UcMember[member_work_county]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_work_county}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_work_county_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_company">公司名称</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_company" name="UcMember[member_company]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_company}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_company_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_company_industry">所属行业</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_company_industry" name="UcMember[member_company_industry]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_company_industry}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_company_industry_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_company_scale">公司规模</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_company_scale" name="UcMember[member_company_scale]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_company_scale}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_company_scale_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_company_address">公司地址</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_company_address" name="UcMember[member_company_address]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_company_address}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_company_address_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_work_time">工作时间</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_work_time" name="UcMember[member_work_time]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_work_time}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_work_time_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_work_salary">税后月薪</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_work_salary" name="UcMember[member_work_salary]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_work_salary}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_work_salary_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_updatefinance">是否补充完升级金融用户所需资料</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_updatefinance" name="UcMember[member_updatefinance]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_updatefinance}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_updatefinance_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_finance_level">信用等级</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_finance_level" name="UcMember[member_finance_level]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_finance_level}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_finance_level_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_finance_check">是否信用审核</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_is_finance_check" name="UcMember[is_finance_check]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.is_finance_check}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_finance_check_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_debt_ability">偿还能力</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_debt_ability" name="UcMember[debt_ability]" style="width:120px;">   <option value="A"{if $dataObj.debt_ability eq "A"} selected="selected"{/if}>B</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_debt_ability_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_audit_status">资料审核状态 0|审核未通过 1|审核通过</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_audit_status" name="UcMember[audit_status]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.audit_status}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_audit_status_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_residence_time">居住时间</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_residence_time" name="UcMember[member_residence_time]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_residence_time}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_residence_time_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_corporation">法人代表</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_corporation" name="UcMember[member_corporation]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_corporation}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_corporation_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_company_type">公司类型</label>
                    <div class="col-sm-7"><select class="form-control" id="UcMember_member_company_type" name="UcMember[member_company_type]" style="width:120px;">   <option value="0"{if $dataObj.member_company_type eq "0"} selected="selected"{/if}></option>   <option value="未选择"{if $dataObj.member_company_type eq "未选择"} selected="selected"{/if}>1</option>   <option value="工作信息"{if $dataObj.member_company_type eq "工作信息"} selected="selected"{/if}>2</option>   <option value="企业信息"{if $dataObj.member_company_type eq "企业信息"} selected="selected"{/if}></option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_company_type_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_private_province">私营省份</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_private_province" name="UcMember[member_private_province]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_private_province}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_private_province_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_private_city">私营城市</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_private_city" name="UcMember[member_private_city]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_private_city}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_private_city_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_private_county">私营县</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_private_county" name="UcMember[member_private_county]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_private_county}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_private_county_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_is_agree_trade_privacy">是否同意交易协议书</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_is_agree_trade_privacy" name="UcMember[is_agree_trade_privacy]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.is_agree_trade_privacy}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_is_agree_trade_privacy_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_business">企业名称</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_business" name="UcMember[member_business]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_business}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_business_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_business_address">企业地址</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_business_address" name="UcMember[member_business_address]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_business_address}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_business_address_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_business_industry">企业所属行业</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_business_industry" name="UcMember[member_business_industry]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_business_industry}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_business_industry_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_business_scale">企业规模</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_business_scale" name="UcMember[member_business_scale]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_business_scale}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_business_scale_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_business_salary">企业月收入</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_business_salary" name="UcMember[member_business_salary]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_business_salary}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_business_salary_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="UcMember_member_business_time">企业成立年限</label>
                    <div class="col-sm-7"><input type="text" id="UcMember_member_business_time" name="UcMember[member_business_time]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_business_time}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="UcMember_member_business_time_em_">  </span> </div>
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