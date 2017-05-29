<div class="page-content-area">
<div class="page-header">
        <h1> <a href="backend.php?r=memberMgr">会员列表</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表</small> </h1>
</div>
<!-- /.page-header -->

<div class="row">
    <div class="col-xs-12"> 
        <!-- PAGE CONTENT BEGINS -->
        <div id="searchContainer">                                      
        <form class="form-horizontal"  id="memberMgr-form" role="form" action="#" method="GET">
            <input type="hidden" name="r" value="{$route}" />
            
            <div class="col-xs-12">
                <br/>
                <div class="form-group  col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="Member_member_name">姓名</label>
                    <div class="col-xs-8"><input type="text" id="Member_member_name" name="Member[member_name]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.member_name}" /></div>
                </div>
                <div class="form-group  col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="Member_member_mobile">手机号码</label>
                    <div class="col-xs-8"><input type="text" id="Member_member_mobile" name="Member[member_mobile]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.member_mobile}" /></div>
                </div>
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="Member_member_email">邮箱地址</label>
                    <div class="col-xs-8"><input type="text" id="Member_member_email" name="Member[member_email]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.member_email}" /></div>
                </div>
                
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="create_time">注册时间</label>
                    <div class="col-xs-8">
                        <div class="input-group lablediv1" style="width:270px;" style="float:right;">
                            <input type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd"
                                   id="create_time_start" name="Member[create_time_start]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$create_time_start}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            <input type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd"
                                   id="create_time_end" name="Member[create_time_end]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$create_time_end}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                        </div>
                    </div>
                </div>	
            </div>	

            <div class="col-xs-12">
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="Member_member_level_id">会员等级</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="Member_member_level_id" name="Member[member_level_id]" style="width:120px;">   
                            <option value="" selected="selected">请选择</option> 
                            {foreach from=$levelList key=key item=item}
                            <option value="{$item.level_id}" {if $dataObj.member_level_id eq $item.level_id} selected="selected"{/if}>{$item.title}</option>   
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="Member_status">状态</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="Member_status" name="Member[status]" style="width:120px;">   
                            <option value="" selected="selected">请选择</option> 
                            <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>有效</option>   
                            <option value="0"{if $dataObj.status eq "0"} selected="selected"{/if}>无效</option> 
                        </select>
                    </div>
                </div>
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="Member_member_from">注册来源</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="Member_member_from" name="Member[member_from]" style="width:120px;">   
                            <option value="" selected="selected">请选择</option> 
                            {foreach from=$arrMemberFrom key=key item=item}
                            <option value="{$key}" {if $dataObj.member_from eq $key} selected="selected"{/if}>{$item}</option>   
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>
                
            
            <div class="clearfix form-actions">
                <div class="col-md-offset-5 col-md-9">
                        <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
                </div>
            </div>
            </form>
        </div>

        
        <div class="table-header">
            {if $pages.totalCount>$pages.pageSize}
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.curPage*$pages.pageSize} of {$pages.totalCount} results
            {else}
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.totalCount} of {$pages.totalCount} results
            {/if}
        </div>
        
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>手机号码</th>
                    <th>邮箱地址</th>
                    <th>会员等级</th>
                    <th>状态</th>
                    <th>注册来源</th>
                    <th>注册时间</th>
                    <th>最后登录时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td>{$i+($pages.curPage-1)*$pages.pageSize+1}</td>
                    <td>{$objModel.member_name}</td>
                    <td>{$objModel.member_mobile}</td>
                    <td>{$objModel.member_email}</td>
                    <td>
                        {if isset($levelList[$objModel.member_level_id])}
                            {$levelList[$objModel.member_level_id]['title']} (LV{$objModel.member_level_id})
                        {else}
                            LV{$objModel.member_level_id}
                        {/if}
                    </td>
                    <td>{if $objModel.status==1}正常{else}禁用{/if}</td>
                    <td>
                        {if isset($arrMemberFrom[$objModel.member_from])}
                            {$arrMemberFrom[$objModel.member_from]}
                        {else}
                            普通注册
                        {/if}
                    </td>
                    <td>{$objModel.create_time}</td>
                    <td>{$objModel.last_login}</td>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                            <a href="backend.php?r=memberMgr/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                            <a href="backend.php?r=memberMgr/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                            <!--
                            <button onclick="delConfirm('backend.php?r=memberMgr/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                            -->
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div class="inline position-relative">
                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li> <a href="backend.php?r=memberMgr/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                    <li> <a href="backend.php?r=memberMgr/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                    <li> <button onclick="delConfirm('backend.php?r=memberMgr/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                {/foreach}
            </tbody>
            </table>
        </div>
        
        <div class="dataTables_paginate">
                <!-- #section:widgets/pagination -->
                {include file="../widgets/pagination.tpl"}
                <!-- /section:widgets/pagination -->
        </div>
    </div><!-- /.row -->
</div>
</div><!-- /.col-xs-12 -->
<!-- /.page-content-area --> 