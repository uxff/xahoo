<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 抽奖报表 <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br />
          <div id="searchContainer">
                <form class="form-horizontal"  id="project-form" role="form" action="#" method="GET">
                <input type="hidden" name="r" value="{$route}" />
                <!--     start  -->   
                    <label class="col-xs-1 control-label no-padding-right" for="lottery_time">统计时间</label>
                        <div class="col-xs-2">
                            <div class="input-group lablediv1" style="width:380px;" style="float:right;">
                                <input type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd H:i:s"
                                       id="time_start" name="lottery[valid_begintime]" size="80" maxlength="200"
                                       class="col-xs-10 col-sm-5" value="{$condition['valid_begintime']}"/>
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd H:i:s"
                                       id="time_end" name="lottery[valid_endtime]" size="80" maxlength="200"
                                       class="col-xs-10 col-sm-5" value="{$condition['valid_endtime']}"/>
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            </div>
                        </div>  
                    <label class="col-xs-3 control-label no-padding-right" for="lottery_phone">手机号</label>
                        <div class="col-xs-2">
                            <input type="text" name="lottery[phone]" id="lottery_phone" value="{$condition['phone']}"/>
                        </div>
                    
                    
                    <label class="col-xs-1 control-label no-padding-right" for="lottery_status">中奖情况</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="lottery_status"  name="lottery[status]" style="height:30px;">
                                <option value="" >全部</option>
                                <option value="1" {if $condition['status'] == 1} selected="selected"{/if}>未中奖</option>
                                <option value="2" {if $condition['status'] == 2} selected="selected"{/if}>已中奖</option>
                            </select>
                        </div>
                    
                    <div class="form-group col-xs-6" style="float:right">
                        <div class="col-xs-offset-6 col-xs-4" style="display:inline-block; white-space:nowrap;">
                                <button style="float:left;width:80px;" class="btn btn-info" id="search" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 查询 </button>
                                <button style="float:right;width:80px;" class="btn btn-info col-xs-12" id="btn_export" type="submit" name="export" value="export"> 导出 </button>
                        </div>
                    </div><!--  end -->
                <div class="clearfix form-actions"></div>
            </form>
        </div>
                                        <div class="">
                                                共 {$pages.totalCount} 条查询结果：
                                        </div>
                                    <form id="project-form" class="form-horizontal" method="POST" action="" role="form" style="">
                                        <div class="table-responsive">
                                                <table id="idTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                                <tr>
                                                                    <th>序号</th>
                                                                    <th>抽奖时间</th>
                                                                    <th>会员昵称</th>
                                                                    <th>手机号码</th>
                                                                    <th>奖品</th>
                                                                    <th>消耗积分</th>
                                                                    <th>中奖情况</th>
                                                                </tr>
                                                        </thead>

                                                        <tbody>
                                                                {foreach from=$listData key=i item=objModel}
                                                                <tr>
                                                                        <td>{($pages.curPage-1)*$pages.pageSize+1+$i}</td>   
                                                                        <td>{$objModel['create_time']}</td>                                                                    
                                                                        <td>{$objModel['member_name']}</td>                                                                   
                                                                        <td>{$objModel['member_mobile']}</td>                                                                   
                                                                        <td>{$objModel['prize']}</td>                          
                                                                        <td>{$objModel['points']}</td>   
                                                                        {if $objModel['status'] == 1}       
                                                                            <td>未中奖</td>                                                                          
                                                                        {else if $objModel['status']  == 2}
                                                                            <td>已中奖</td>                                                                          
                                                                        {else}
                                                                            <td></td>
                                                                        {/if}                                      
                                                                </tr>
                                                                {/foreach}
                                                        </tbody>
                                                </table>
                                        </div>
                                    </form>
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