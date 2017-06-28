<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 海报管理 <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看  </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br /><div id="infomation" class="table-header"><strong>用户信息</strong></div><br />
                                        <div class=" project_baseinfo clearfix">
                                          <div class="col-xs-12">
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">用户ID</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$haibaodatas['member_id']}" />
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
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$haibaodatas['member_mobile']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">会员类型</label>
                                              <div class="col-sm-6">
                                              {if $haibaodatas['is_jjr'] == 1}
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="普通会员" />              
                                              {elseif $haibaodatas['is_jjr'] == 2}
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="经纪人" />              
                                              {/if}
                                              </div>
                                            </div>
                                            </div>
                                            
                                            
                                            <div class = "col-xs-12">
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">奖励总额</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$haibaodatas['reward_money']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">提现金额</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="16" maxlength="20" readonly="true" value="{$haibaodatas['withdraw_money']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">直接粉丝</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="18" maxlength="20" readonly="true" value="{$haibaodatas['fans_first']}" />
                                              </div>
                                            </div>
                                            <div class="form-group col-xs-3">
                                              <label class="col-sm-4 control-label no-padding-right" for="advert_title">间接粉丝</label>
                                              <div class="col-sm-6">
                                                <input type="text"  size="18" maxlength="20" readonly="true" value="{$haibaodatas['fans_second']}" />
                                              </div>
                                            </div>
                                            
                                            
                                            
                                          </div>
                                        </div>    
                                        
                                        <br /><div id="infomation" class="table-header"><strong>操作记录</strong></div><br />
                                        
                                        <form id="project-form" class="form-horizontal" method="POST" action="" role="form" style="">
                                        <div class="table-responsive">
                                                <table id="idTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                                <tr>
                                                                    <th>序号</th>
                                                                    <th>操作时间</th>
                                                                    <th>操作人</th>
                                                                    <th>角色</th>
                                                                    <th>详细操作说明</th>
                                                                </tr>
                                                        </thead>

                                                        <tbody>
                                                                {foreach from=$listData key=i item=objModel}
                                                                <tr>
                                                                        <td>{($pages.curPage-1)*$pages.pageSize+1+$i}</td>                                                                    
                                                                        <td>{$objModel['create_time']}</td>
                                                                        <td>{$objModel['username']}</td>   
                                                                        <td>{$objModel['userflag']}</td>                                   
                                                                        <td>{$objModel['desc']}</td>   
                                                                </tr>
                                                                {/foreach}
                                                        </tbody>
                                                </table>
                                        </div>
                                    </form>                                    
                                        
        <div class="clearfix form-actions">
          <div class="col-md-offset-5 col-md-6">
            <a class="btn btn-info" href="backend.php?r=PosterUserMoney"><i class="ace-icon fa fa-check bigger-110"></i>返回</a>
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