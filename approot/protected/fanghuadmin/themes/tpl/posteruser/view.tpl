<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 用户管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看  </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br /><div id="infomation" class="table-header"><strong>基本信息</strong></div><br />
                                        <div class=" project_baseinfo clearfix">
                                          <div class="col-xs-12">
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">用户ID</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$listData['member_id']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">用户姓名</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$objModel['jjr_name']|default:'-'}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">手机号码</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$listData['member_mobile']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">会员类型</label>
                                              <div class="col-sm-6">
                                              {if $listData['is_jjr'] == 1}
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="普通会员" />              
                                              {elseif $listData['is_jjr'] == 2}
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="经纪人" />              
                                              {/if}
                                              </div>
                                            </div>
                                            </div>
                                            
                                            
                                            <div class = "col-xs-12">
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">奖励金额</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$listData['reward_money']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">提现金额</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$listData['withdraw_money']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">直接粉丝</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="18" maxlength="20" readonly="true" value="{$listData['fans_first']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">间接粉丝</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="18" maxlength="20" readonly="true" value="{$listData['fans_second']}" />
                                              </div>
                                            </div>
                                            
                                            
                                            
                                          </div>
                                        </div>                                        
                                        
        <div class="clearfix form-actions">
          <div class="col-md-offset-5 col-md-6">
            <a class="btn btn-info" href="backend.php?r=PosterUser"><i class="ace-icon fa fa-check bigger-110"></i>返回</a>
          </div>
        </div>  
                                        <div class="dataTables_paginate">
                                                <!-- #section:widgets/pagination -->
                                                {include file="../widgets/pagination.tpl"}
                                                <!-- /section:widgets/pagination -->
                                        </div>
                                </div><!-- /.col-xs-12 -->
                        </div><!-- /.row -->
                </div><!-- /.ol-xs-12 -->
        </div><!-- /.row -->
</div>
{if !empty($jsShell)}
{$jsShell}
{/if} 
<!-- /.page-content-area --> 