
<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="fanghuadmin.php?r=adminUser">系统用户</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="adminUser-form" role="form" action="fanghuadmin.php?r=adminUser/create" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_account">用户账号</label>
                    <div class="col-sm-7"><input type="text" id="SysAdminUser_account" name="SysAdminUser[account]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.account}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_account_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_password">用户密码</label>
                    <div class="col-sm-7"><input type="password" id="SysAdminUser_password" name="SysAdminUser[password]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.password}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_password_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_name">用户姓名</label>
                    <div class="col-sm-7"><input type="text" id="SysAdminUser_name" name="SysAdminUser[name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_name_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_email">Email</label>
                    <div class="col-sm-7"><input type="text" id="SysAdminUser_email" name="SysAdminUser[email]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.email}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_email_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_status">状态</label>
                    <div class="col-sm-7"><select class="form-control" id="SysAdminUser_status" name="SysAdminUser[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>   <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_status_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysAdminUser_telephone">电话</label>
                    <div class="col-sm-7"><input type="text" id="SysAdminUser_telephone" name="SysAdminUser[telephone]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.telephone}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysAdminUser_telephone_em_">  </span> </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysRoleUser_role_id">角色</label>
                    <div class="col-sm-7">
						<select class="form-control" id="SysRoleUser_role_id" name="SysRoleUser[role_id]" style="width:120px;"> 
                                {foreach from=$role item=item}
                                        <option value="{$item.id}">{$item.name}</option>
                                {/foreach}  
                        </select>
                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysRoleUser_role_id_em_">  </span> </div>
                </div>                               <!--
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
                                        <div class="text-center">
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