<style type="text/css">
    #idTable,#idTable th,#idTable td{ text-align: center; }
    #idTable th,#idTable td{ padding: 8px;  }
    .btn-group{  width: 100%; }
    .btn-group a{  float: left; margin: 0 8px!important; display: block; }
</style>

<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 用户海报 <small> <i class="ace-icon fa fa-angle-double-right"></i> 海报管理 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br />
          <div id="searchContainer">
                <form class="form-horizontal"  id="project-form" role="form" action="{yii_createurl c=Poster a=Index}" method="POST">
                <!--     start  --> 

               <div class="col-xs-12">
                    <br><br>
                    <div class="form-group col-xs-3">
                        <label for="advert_title" class="col-sm-4 control-label no-padding-right">所属项目</label>
                        <div class="col-sm-7"> 
                        <select class="form-control" id="poster_project"  name="poster[project]" style="height:30px">
                                <option value="" >请选择</option>
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group col-xs-3">
                        <label for="advert_title" class="col-sm-4 control-label no-padding-right">所属公众号</label>
                        <div class="col-sm-7"> 
                        <select class="form-control" id="accounts_id"  name="poster[accounts_id]" style="height:30px">
                                <option value="" >请选择</option>
                                {foreach from=$accountsData key=i item=accItem}
                                    <option value="{$accItem['id']}" {if $accounts_id == $accItem['id']} selected="selected"{/if}>{$accItem['accounts_name']}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-xs-3">
                        <label for="advert_using" class="col-xs-4 control-label no-padding-right">海报状态</label>
                        <div class="col-xs-7">
                         <select class="form-control" id="poster_status"  name="poster[status]" style="height:30px">
                                <option value="" >请选择</option>
                                <option value="1" {if $status == 1} selected="selected"{/if}>无效</option>
                                <option value="2" {if $status == 2} selected="selected"{/if}>有效</option>
                            </select>
                        </div>
                    </div>
                                           
                    <div class="form-group col-xs-1" >
                        <div class="col-md-offset-5 col-md-3">
                                <button class="btn btn-info" id="search" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 查询 </button>
                        </div>
                    </div>  
                </div>

                </div><!--  end -->
                <div class="clearfix form-actions"></div>
            </form>
        </div>
        <div class="">
                共 {$pages.totalCount} 条查询结果：
                <span class="pull-right">
                        <a href="backend.php?r=Poster/Create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增海报 </a>
                </span>
        </div>
    <form id="project-form" class="form-horizontal" method="POST" action="" role="form" style="">
        <div class="table-responsive">
                <table id="idTable" class="table table-striped table-bordered table-hover">
                        <thead>
                                <tr>
                                    <th style="width: 70px;">序号</th>
                                    <th style="width: 160px;">所属项目</th>
                                    <th style="width: 160px;">所属公众号</th>
                                    <th style="width: 80px;">首次关注奖励</th>
                                    <th style="width: 80px;">直接粉丝奖励</th>
                                    <th style="width: 80px;">间接粉丝奖励</th>
                                    <th style="width: 80px;">项目奖金上限</th>
                                    <th style="width: 80px;">项目粉丝上限</th>
                                    <th style="width: 80px;">最低提现金额</th>
                                    <th style="width: 80px;">最高提现金额</th>
                                    <th style="width: 60px;">已获粉丝</th>
                                    <th style="width: 60px;">已派金额</th>
                                    <th style="width: 60px;">海报状态</th>
                                    <th style="width: 200px;">海报有效期</th>
                                    <th>操作</th>
                                </tr>
                        </thead>

                        <tbody>
                                {foreach from=$listData key=i item=objModel}
                                <tr>
                                        <td>{($pages.curPage-1)*$pages.pageSize+1+$i}</td>                                                                 
                                        <td>{$objModel['project'][0]['project_name']}</td>                                                           
                                        <td>{$objModel['accounts'][0]['accounts_name']}</td>
                                        <td>{$objModel['subscribe_rewards']}</td>      
                                        <td>{$objModel['direct_fans_rewards']}</td>   
                                        <td>{$objModel['indirect_fans_rewards']}</td>                                   
                                        <td>
                                        {if $objModel['project_bonus_ceiling'] >0}
                                            {$objModel['project_bonus_ceiling']}
                                        {else}
                                            -   
                                        {/if}
                                        </td>                                  
                                        <td>
                                        {if $objModel['project_fans_ceiling'] > 0}
                                            {$objModel['project_fans_ceiling']}
                                        {else}
                                            -
                                        {/if}
                                        </td>                                       
                                        <td>{$objModel['lowest_withdraw_sum']}</td>                              
                                        <td>{$objModel['highest_withdraw_sum']}</td>     
                                        <td title="直接粉丝数：{$objModel['direct_fans_num']} 间接粉丝数：{$objModel['indirect_fans_num']}">{$objModel['direct_fans_num']+$objModel['indirect_fans_num']}</td>                              
                                        <td>{$objModel['all_rewarded']}</td>                              
                                        {if $objModel['poster_status'] == 1}
                                            <td>无效</td>
                                        {else if $objModel['poster_status'] == 2}
                                            <td>有效</td>                                                                            
                                        {else}<td>-</td>
                                        {/if}                            
                                        <td>
                                        {if $objModel['valid_begintime'] != '0000-00-00' && $objModel['valid_endtime'] != '0000-00-00'}
                                        {$objModel['valid_begintime']}&nbsp;至&nbsp;{$objModel['valid_endtime']}
                                        {else}
                                            永久
                                        {/if}
                                        </td>                                                                         
                                        <td>
                                        <div class="hidden-sm hidden-xs btn-group">
                                            {if ($objModel['valid_begintime'] lte $time && $objModel['valid_endtime'] gte $time && $objModel['poster_status'] != 2) || ($objModel['valid_begintime'] == '0000-00-00' && $objModel['valid_endtime'] == '0000-00-00' && $objModel['poster_status'] != 2)}
                                                <a href="javascript:;" onclick="return setStatus({$objModel['id']});" class="btn btn-xs btn-success" > 
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>设为有效 </a>
                                            {else if $objModel['poster_status'] == 2}
                                                <a href="javascript:;" onclick="return setStatusTwo({$objModel['id']});" class="btn btn-xs btn-success" > 
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>设为无效 </a>
                                            {else}
                                                <a href="javascript:;" class="btn btn-xs "  disabled="disabled">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>设为有效 </a>
                                            {/if}
                                            {if $objModel['poster_status'] == 2}
                                            <a href="" class="btn btn-xs btn-success" disabled="disabled"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                            {else}
                                            <a href="backend.php?r=Poster/Edit&id={$objModel['id']}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                            {/if}
                                            <a href="backend.php?r=Poster/View&id={$objModel['id']}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                                        </div>
                                        </td>
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