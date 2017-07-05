<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=memberAppointment">MemberAppointment</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="memberAppointment-form" role="form" action="backend.php?r=memberAppointment/update&id={$model[$primaryKey]}" method="POST">
                              <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_member_id">会员编号</label>
                    <div class="col-sm-7"><input type="text" id="MemberAppointment_member_id" name="MemberAppointment[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_member_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_appointment_date">预约时间</label>
                    <div class="col-sm-7"><input type="text" id="MemberAppointment_appointment_date" name="MemberAppointment[appointment_date]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.appointment_date}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_appointment_date_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_house_url">预约房源链接</label>
                    <div class="col-sm-7"><input type="text" id="MemberAppointment_house_url" name="MemberAppointment[house_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.house_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_house_url_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_remark">预约备注</label>
                    <div class="col-sm-7">
                        <textarea name="MemberAppointment[remark]" id="MemberAppointment_remark" cols="43" rows="5">{$dataObj.remark}</textarea>
                    </div>

                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_remark_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_status">预约状态</label>
                    <div class="col-sm-7"><select class="form-control" id="MemberAppointment_status" name="MemberAppointment[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>预约</option>   <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>履约</option>   <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>爽约</option>   <option value="4"{if $dataObj.status eq "4"} selected="selected"{/if}>取消</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_status_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_dealed">是否处理</label>
                    <div class="col-sm-7">
                        {*<input type="text" id="MemberAppointment_dealed" name="MemberAppointment[dealed]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.dealed}" />*}

                            <select class="form-control" id="MemberAppointment_status" name="MemberAppointment[dealed]" style="width:120px;">
                                <option value="1"{if $dataObj.dealed eq "1"} selected="selected"{/if}>已处理</option>
                                <option value="0"{if $dataObj.dealed eq "0"} selected="selected"{/if}>未处理</option>
                            </select>


                    </div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_dealed_em_">  </span> </div>
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