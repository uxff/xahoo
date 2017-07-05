<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=role">角色管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="role-form" role="form" action="backend.php?r=role/update&id={$model[$primaryKey]}" method="POST">
                              <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysRole_name">角色名</label>
                    <div class="col-sm-7"><input type="text" id="SysRole_name" name="SysRole[name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysRole_name_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysRole_status">状态</label>
                    <div class="col-sm-7"><input type="text" id="SysRole_status" name="SysRole[status]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.status}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysRole_status_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysRole_remark">角色描述</label>
                    <div class="col-sm-7"><input type="text" id="SysRole_remark" name="SysRole[remark]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.remark}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysRole_remark_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="SysRole_access_status">0,表示不可删除</label>
                    <div class="col-sm-7"><input type="text" id="SysRole_access_status" name="SysRole[access_status]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.access_status}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="SysRole_access_status_em_">  </span> </div>
                </div>                                <div class="clearfix form-actions">
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