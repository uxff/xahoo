<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 海报报表 <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br />
          <div id="searchContainer">
                <form class="form-horizontal"  id="project-form" role="form" action="{yii_createurl c=PosterReport a=Index}" method="POST">
                <!--     start  -->     
                    <label class="col-xs-1 control-label no-padding-right" for="poster_project">排序规则</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="poster_project"  name="poster[type]">
                                <option value="" >请选择</option>
                                <option value="1"  {if $type == 1} selected="selected"{/if}>奖励金额由大到小</option>
                                <option value="2"  {if $type == 2} selected="selected"{/if}>直接粉丝数由大到小</option>
                                <option value="3"  {if $type == 3} selected="selected"{/if}>间接粉丝数由大到小</option>
                            </select>
                        </div>
                    <label class="col-xs-1 control-label no-padding-right" for="poster_project">生成海报时间</label>
                        <div class="col-xs-2">
                            <div class="input-group lablediv1" style="width:380px;" style="float:right;">
                                <input type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd H:i:s"
                                       id="time_start" name="poster[valid_begintime]" size="80" maxlength="200"
                                       class="col-xs-10 col-sm-5" value="{$condition['valid_begintime']}"/>
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                <input type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd H:i:s"
                                       id="time_end" name="poster[valid_endtime]" size="80" maxlength="200"
                                       class="col-xs-10 col-sm-5" value="{$condition['valid_endtime']}"/>
                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            </div>
                        </div>
                    
                    <div class="form-group col-xs-6" style="float:right">
                    <div class="col-xs-offset-4 col-xs-4" style="display:inline-block; white-space:nowrap;">
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
                                                                    <th>手机号码</th>
                                                                    <th>所属项目</th>
                                                                    <th>会员姓名</th>
                                                                    <th>会员昵称</th>
                                                                    <th>会员类型</th>
                                                                    <th>奖励金额</th>
                                                                    <th>直接粉丝</th>
                                                                    <th>间接粉丝</th>
                                                                    <th>扫码时间</th>
                                                                </tr>
                                                        </thead>

                                                        <tbody>
                                                                {foreach from=$listData key=i item=objModel}
                                                                <tr>
                                                                        <td>{($pages.curPage-1)*$pages.pageSize+1+$i}</td>   
                                                                        <td>{$objModel['member_mobile']}</td>                                                                    
                                                                        <td>{$objModel['project'][0]['project_name']}</td>
                                                                        <td>{$objModel['jjr_name']|default:'-'}</td>                                   
                                                                        <td>{$objModel['wx_nickname']}</td>   
                                                                        {if $objModel['is_jjr'] == 1}       
                                                                            <td>普通会员</td>                                                                          
                                                                        {else if $objModel['is_jjr']  == 2}
                                                                            <td>经纪人</td>                                                                          
                                                                        {else}
                                                                            <td></td>
                                                                        {/if}                                                             
                                                                        <td>{$objModel['reward_money']}</td>                              
                                                                        <td>{$objModel['fans_first']}</td>                               
                                                                        <td>{$objModel['fans_second']}</td>                          
                                                                        <td>{$objModel['create_time']}</td>     
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