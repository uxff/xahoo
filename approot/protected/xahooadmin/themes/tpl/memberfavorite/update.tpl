<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=memberFavorite">MemberFavorite</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="memberFavorite-form" role="form" action="backend.php?r=memberFavorite/update&id={$model[$primaryKey]}" method="POST">
                              <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberFavorite_task_id">收藏的任务编号</label>
                    <div class="col-sm-7"><input type="text" id="MemberFavorite_task_id" name="MemberFavorite[task_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.task_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberFavorite_task_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberFavorite_member_id">会员编号</label>
                    <div class="col-sm-7"><input type="text" id="MemberFavorite_member_id" name="MemberFavorite[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberFavorite_member_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberFavorite_status">状态</label>
                    <div class="col-sm-7"><select class="form-control" id="MemberFavorite_status" name="MemberFavorite[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>   <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberFavorite_status_em_">  </span> </div>
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