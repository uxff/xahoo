<style type="text/css">
 #idTable th,#idTable td{ text-align: center; }
 .btn-group{ width: 100%; }
 .btn-group a{ margin: 0 10px!important; }
 .btn-success{ float: left!important; }
 .btn-info{ float: right!important; }
</style>

<div class="page-content-area" xmlns="http://www.w3.org/1999/html">
    <div class="page-header">
        <h1>
            用户海报
            <small> <i class="ace-icon fa fa-angle-double-right"></i>
                用户提现
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <br />
                    <div id="searchContainer">
                        <form class="form-horizontal"  id="project-form" role="form" action="{yii_createurl c=PosterUserMoney a=Index}" method="POST">
                            <!--     start  -->

                            <input type="hidden" id="token" value="{$token}">
                            <div class="col-xs-12">
                                <br>
                                <div class="form-group col-xs-3">
                                    <label for="advert_title" class="col-sm-4 control-label no-padding-right">会员昵称</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="poster[nickname]" value="{$nickname}"/>
                                    </div>
                                </div>
                                <div class="form-group col-xs-3">
                                    <label for="advert_using" class="col-xs-4 control-label no-padding-right">手机号码</label>
                                    <div class="col-xs-7">
                                        <input type="text" name="poster[member_mobile]" value="{$member_mobile}"/>
                                    </div>
                                </div>

                                <div class="form-group col-xs-3">
                                    <label for="advert_last_modified" class="col-xs-4 control-label no-padding-right">所属项目</label>
                                    <div class="col-xs-7">
                                        <select class="form-control" id="poster_project"  name="poster[project]" style="height:30px;">
                                            <option value="" >请选择</option>
                                            {foreach from=$projectDatas key=i item=project}
                                            <option value="{$project['project_id']}" {if $project_id == $project['project_id']} selected="selected"{/if}>{$project['project_name']}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xs-3">
                                    <label for="advert_last_modified" class="col-xs-4 control-label no-padding-right">会员类型</label>
                                    <div class="col-xs-7">
                                        <select class="form-control" id="poster_project"  name="poster[is_jjr]" style="height:30px;">
                                            <option value="" >请选择</option>
                                            <option value="1" {if $is_jjr == 1} selected="selected"{/if}>普通会员</option>
                                            <option value="2" {if $is_jjr == 2} selected="selected"{/if}>经纪人</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <br>
                                <div class="form-group col-xs-3">
                                    <label for="advert_title" class="col-sm-4 control-label no-padding-right">提现状态</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="poster_status"  name="poster[status]" style="height:30px;">
                                            <option value="" >请选择</option>
                                            <option value="1" {if $status == 1} selected="selected"{/if}>待审核</option>
                                            <option value="2" {if $status == 2} selected="selected"{/if}>审核不通过</option>
                                            <option value="3" {if $status == 3} selected="selected"{/if}>待打款</option>
                                            <option value="4" {if $status == 4} selected="selected"{/if}>已打款</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xs-3" style="margin-left:30px;">

                                    <div class="col-xs-7">
                                        <button class="btn btn-info" id="search" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i>
                                            查询
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="clearfix form-actions"></div>
                        </form>
                    </div>
                    <div class="">
                        共 {$pages.totalCount} 条提现记录，共有{$num}人提现，已付款金额{$money}元：
                        <span class="pull-right">
                            <a href="#" class="btn btn-xs   batchreview btndisable">
                                <i class="ace-icon fa fa-plus bigger-120"></i>
                                批量审核
                            </a>
                            <a href="#" class="btn btn-xs   bulkpayments btndisable">
                                <i class="ace-icon fa fa-plus bigger-120"></i>
                                批量付款
                            </a>
                        </span>
                    </div>
                    <form id="project-form" class="form-horizontal" method="POST" action="" role="form" style="">
                        <div class="table-responsive">
                            <table id="idTable" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">序号</th>
                                        <th style="width: 65px;">
                                            <input type="checkbox" name="check_all" class="check_all"/>
                                            全选
                                        </th>
                                        <th style="width: 140px;">手机号码</th>
                                        <th style="width: 90px;">提现金额</th>
                                        <th style="width: 180px;">提现时间</th>
                                        <th style="width: 100px;">会员姓名</th>
                                        <th style="width: 130px;">会员昵称</th>
                                        <th style="width: 110px;">会员类型</th>
                                        <th style="width: 130px;">提现状态</th>
                                        <th style="width: 180px;">付款时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {foreach from=$listData key=i item=objModel}
                                    <tr pid="{$objModel.haibao['id']}" id="{$objModel['id']}" member_id="{$objModel.haibao['member_id']}" money="{$objModel['withdraw_money']}" status="{$objModel['status']}" style="color:{$objModel._color}">
                                        <td>{($pages.curPage-1)*$pages.pageSize+1 + $i}</td>
                                        <td>
                                            <input type="checkbox" class="checklist"/>
                                        </td>
                                        <td title="openid: {$objModel.haibao['openid']}">{$objModel.haibao['member_mobile']}</td>
                                        <td>{$objModel['withdraw_money']}</td>
                                        <td>{$objModel['create_time']}</td>
                                        <td>{$objModel.haibao['jjr_name']|default:'-'}</td>
                                        <td>{$objModel.haibao['wx_nickname']}</td>
                                        {if $objModel.haibao['is_jjr'] == 1}
                                        <td>普通会员</td>
                                        {else if $objModel.haibao['is_jjr']  == 2}
                                        <td>经纪人</td>
                                        {else}
                                        <td></td>
                                        {/if}                                 
                                                                        {if $objModel['status'] == 1}
                                        <td>待审核</td>
                                        {else if $objModel['status'] == 2}
                                        <td>审核不通过</td>
                                        {else if $objModel['status'] == 3}
                                        <td>待打款</td>
                                        {else if $objModel['status'] == 4}
                                        <td>已打款</td>
                                        {else}
                                        <td></td>
                                        {/if}
                                        <td>{$objModel['remit_time']}</td>
                                        <td>
                                            <div class="hidden-sm hidden-xs btn-group">
                                                {if $objModel['status']  == 1}
                                                <a href="javascript:;" onclick="shenhe_confim({$objModel['id']},{$objModel.haibao['id']});" class="btn btn-xs btn-success">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                    审核
                                                </a>
                                                {else if $objModel['status'] == 3}
                                                <a href="javascript:;" onclick="pay_confim({$objModel['id']},{$objModel.haibao['id']},{$objModel['withdraw_money']},{$objModel.haibao['member_id']});" class="btn btn-xs btn-success">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                    打款
                                                </a>
                                                {/if}
                                                <a href="backend.php?r=PosterUserMoney/View&id={$objModel.haibao['id']}&withdrawid={$objModel['id']}" class="btn btn-xs btn-info">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                    查看
                                                </a>
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
                        <!-- /section:widgets/pagination --> </div>
                </div>
                <!-- /.col-xs-12 --> </div>
            <!-- /.row --> </div>
        <!-- /.ol-xs-12 --> </div>
    <!-- /.row -->
</div>
{if !empty($jsShell)}
{$jsShell}
{/if}
<!-- /.page-content-area -->