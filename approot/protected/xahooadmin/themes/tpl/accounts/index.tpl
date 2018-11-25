<style type="text/css">
    #idTable,#idTable th,#idTable td{ text-align: center; }
    #idTable th,#idTable td{ padding: 8px;  }
    .btn-group{  width: 100%; }
    .btn-group a{  float: left; margin: 0 8px!important; display: block; }
</style>

<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 用户海报 <small> <i class="ace-icon fa fa-angle-double-right"></i> 公众号管理 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br />
          <div id="searchContainer">
                <form class="form-horizontal"  id="project-form" role="form" action="{yii_createurl c=Accounts a=Index}" method="POST">
                <!--     start  --> 

               <div class="col-xs-12">
                    <br><br>
                    <div class="form-group col-xs-3">
                        <label for="advert_title" class="col-sm-4 control-label no-padding-right">公众号名称</label>
                        <div class="col-sm-7"> 
                        <select class="form-control" id="poster_accounts_name"  name="poster[accounts_name]" style="height:30px">
                                <option value="" >请选择</option>
                                {foreach from=$accountsData key=i item=project}
                                    <option value="{$project['id']}" {if $accounts_name == $project['id']} selected="selected"{/if}>{$project['accounts_name']}</option>
                                {/foreach}
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
                        <a href="backend.php?r=Accounts/Create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增公众号</a>
                </span>
        </div>
    <form id="project-form" class="form-horizontal" method="POST" action="" role="form" style="">
        <div class="table-responsive">
                <table id="idTable" class="table table-striped table-bordered table-hover">
                        <thead>
                                <tr>
                                    <th style="width: 70px;">id</th>
                                    <th style="width: 200px;">公众号名称</th>
                                    <th style="width: 200px;">APPID</th>
                                    <th style="width: 120px;">公众号token</th>
                                    <th style="width: 200px;">mp配置服务器地址</th>
                                    <th style="width: 100px;">更新时间</th>
                                    <th style="width: 100px;">状态</th>
                                    <th>操作</th>
                                </tr>
                        </thead>

                        <tbody>
                                {foreach from=$listData key=i item=objModel}
                                <tr>
                                        <td index="{($pages.curPage-1)*$pages.pageSize+1+$i}">{$objModel.id}</td>                                                                 
                                        <td>{$objModel['accounts_name']}</td>
                                        <td data-appid='{$objModel.appid}' data-appsecret='{$objModel.appsecret}' data-encoding-aes-key="{$objModel['EncodingAESKey']}">{$objModel['appid']}</td>
                                        <td>{$objModel['token']}</td>
                                        <!--td>{$objModel['EncodingAESKey']}</td-->
                                        <td>{$mpurlPrefix}&amp;mpid={$objModel.id}</td>   
                                        <td>{$objModel['last_modified']}</td>                                                                          
                                        <td>{$arrStatus[$objModel['status']]}</td>
                                        <td>
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <a href="backend.php?r=Accounts/Edit&id={$objModel['id']}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                            <a href="backend.php?r=Accounts/Editmenu&id={$objModel['id']}" class="btn btn-xs btn-warning"> <i class="ace-icon fa fa-pencil bigger-120"></i>菜单 </a>
                                            <a href="backend.php?r=Accounts/View&id={$objModel['id']}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
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
