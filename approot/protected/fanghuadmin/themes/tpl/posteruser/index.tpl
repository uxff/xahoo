<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
                <h1> 用户海报 <small> <i class="ace-icon fa fa-angle-double-right"></i> 用户管理 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <br />
          <div id="searchContainer">
                <form class="form-horizontal"  id="project-form" role="form" action="{yii_createurl c=PosterUser a=Index}" method="POST">
                <!--     start  -->       
                   
                    <div class="col-xs-12">
                    <br>
                    <div class="form-group col-xs-3">
                        <label for="advert_title" class="col-sm-4 control-label no-padding-right">会员昵称</label>
                        <div class="col-sm-7">  <input type="text" name="poster[name]" value="{$name}"/></div>
                    </div>
                    <div class="form-group col-xs-3">
                        <label for="advert_using" class="col-xs-4 control-label no-padding-right">手机号码</label>
                        <div class="col-xs-7">
                        <input type="text" name="poster[phone]" value="{$phone}"/>
                        </div>
                    </div>
                                           
                    <div class="form-group col-xs-3">
                        <label for="advert_last_modified" class="col-xs-4 control-label no-padding-right">所属项目</label>
                        <div class="col-xs-7">
                            <select class="form-control" id="poster_project"  name="poster[project]" style="height:30px">
                                <option value="" >请选择</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-xs-3">
                        <label for="advert_last_modified" class="col-xs-4 control-label no-padding-right">会员类型</label>
                        <div class="col-xs-7">
                               <select class="form-control" id="poster_type"  name="poster[type]" style="height:30px">
                                <option value="" >请选择</option>
                                <option value="2"  {if $type == 2} selected="selected"{/if}>经纪人</option>
                                <option value="1"  {if $type == 1} selected="selected"{/if}>普通会员</option>
                                <option value="3"  {if $type == 3} selected="selected"{/if}>其他</option>
                            </select>
                        </div>
                    </div>   
                </div>


                
                    <div class="form-group col-xs-10">
                    <div class="form-group col-xs-1" style="float:right">
                        <div class="col-md-offset-5 col-md-3">
                                <button class="btn btn-info" id="search" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 查询 </button>
                        </div>
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
                                                                    <th>操作</th>
                                                                </tr>
                                                        </thead>

                                                        <tbody>
                                                                {foreach from=$listData key=i item=objModel}
                                                                <tr>
                                                                        <td>{($pages.curPage-1)*$pages.pageSize+1+$i}</td>   
                                                                        <td title="openid: {$objModel.openid}">{$objModel['member_mobile']}</td>                                                                    
                                                                        <td>{$objModel['project']}</td>
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
                                                                        <td>
                                                                                <div class="hidden-sm hidden-xs btn-group">
                                                                                    <a href="fanghuadmin.php?r=PosterUser/View&id={$objModel['id']}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
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