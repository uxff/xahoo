
<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="backend.php?r=memberAppointment">MemberAppointment</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 新增 </small> </h1><br />
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

                        <form class="form-horizontal"  id="memberAppointment-form" role="form" action="backend.php?r=memberAppointment/create" method="POST">
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
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_status">预约状态</label>
                    <div class="col-sm-7"><select class="form-control" id="MemberAppointment_status" name="MemberAppointment[status]" style="width:120px;">   <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>预约</option>   <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>履约</option>   <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>爽约</option>   <option value="4"{if $dataObj.status eq "4"} selected="selected"{/if}>取消</option></select></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_status_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAppointment_dealed">是否处理</label>
                    <div class="col-sm-7"><input type="text" id="MemberAppointment_dealed" name="MemberAppointment[dealed]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.dealed}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAppointment_dealed_em_">  </span> </div>
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