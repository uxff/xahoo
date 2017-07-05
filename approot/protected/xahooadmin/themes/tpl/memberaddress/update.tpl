<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="index.php?r=memberAddress">MemberAddress</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
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

                        <form class="form-horizontal" id="memberAddress-form" role="form" action="index.php?r=memberAddress/update&id={$model[$primaryKey]}" method="POST">
                              <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_province_id">省</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_province_id" name="MemberAddress[province_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.province_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_province_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_city_id">市</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_city_id" name="MemberAddress[city_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.city_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_city_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_county_id">区</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_county_id" name="MemberAddress[county_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.county_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_county_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_consignee_name">收货人姓名</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_consignee_name" name="MemberAddress[consignee_name]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.consignee_name}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_consignee_name_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_consignee_mobile">收货人手机号</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_consignee_mobile" name="MemberAddress[consignee_mobile]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.consignee_mobile}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_consignee_mobile_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_address">收货地址</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_address" name="MemberAddress[address]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.address}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_address_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_member_id">收货地址所属会员编号</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_member_id" name="MemberAddress[member_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.member_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_member_id_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_update_time">修改时间</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_update_time" name="MemberAddress[update_time]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.update_time}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_update_time_em_">  </span> </div>
                </div><div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="MemberAddress_is_default">是否是默认地址：0|不是,1|是</label>
                    <div class="col-sm-7"><input type="text" id="MemberAddress_is_default" name="MemberAddress[is_default]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.is_default}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="MemberAddress_is_default_em_">  </span> </div>
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