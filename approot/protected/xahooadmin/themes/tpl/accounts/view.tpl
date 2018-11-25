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
                                        <br />
                                        <div class="">
                                                操作记录
                                        </div>
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
            <a class="btn btn-info" href="backend.php?r=mpaccounts"><i class="ace-icon fa fa-check bigger-110"></i>返回</a>
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
