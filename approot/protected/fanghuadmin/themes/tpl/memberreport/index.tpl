<div class="page-content-area">
<div class="page-header">
    <h1> 会员报表 <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
</div>
<!-- /.page-header -->

<div class="row">
    <div class="col-xs-12"> 
    <!-- PAGE CONTENT BEGINS -->
        <div id="searchContainer" style="display: block; {if $searchForm}block;{else}none;{/if}">                                      
        <form class="form-horizontal"  id="memberReport-form" role="form" action="#" method="GET">
            <input type="hidden" name="r" value="{$route}" />
            <div class="col-xs-12">
                <br/>
                <!--
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="MemberTotalModel_create_time">注册时间</label>
                    <div class="col-xs-8">
                    <div class="input-group lablediv1" style="width:250px;" style="float:right;">
                                    <input type="text" class="form-control year-picker xdr_time_start" data-date-format="yyyy-mm-dd"
                                           id="create_time_start" name="condition[create_time_start]" size="50" maxlength="20"
                                           value="{$condition.create_time_start}"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    <input type="text" class="form-control year-picker xdr_time_end" data-date-format="yyyy-mm-dd"
                                           id="create_time_end" name="condition[create_time_end]" size="50" maxlength="20"
                                           value="{$condition.create_time_end}"/>
                                    <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                </div>
                    </div>
                </div>
                -->
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="MemberTotalModel_level">排序规则</label>
                    <div class="col-xs-8">
                        <select id="MemberTotalModel_level" name="condition[order_by]"  class="col-xs-12">
                            <option value="t.points_total desc,u.member_id" {if $condition.order_by=='t.points_total desc,u.member_id'}selected{/if}>按积分余额由大到小</option>
                            <option value="t.level desc,u.member_id" {if $condition.order_by=='t.level desc,u.member_id'}selected{/if}>按等级由高到低</option>
                        </select>
                        <!--
                        <input type="text" id=""size="60" maxlength="200" value="{$dataObj.member_total.level}" />
                        -->
                    </div>
                </div>
                <!--补齐空格位置-->
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <!--
                -->
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                    <div class="col-xs-offset-2 col-xs-11" style="display:inline-block; white-space:nowrap;">
		    	<!--如果只有查询，使用： style="float:right;width:120px;"-->
                        <button style="float:left;width:100px;" class="btn btn-info col-xs-12" type="submit"> 查询 </button>
                        <button style="float:right;width:100px;" class="btn btn-info col-xs-12" type="submit" name="export" value="export"> 导出 </button>
                    </div>
                </div>
            </div>

            <div class="clearfix form-actions">
            <!-- 居中查询按钮 暂时隐藏
                <div class="col-md-offset-5 col-md-9">
                    <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 查询 </button>
                    &nbsp;
                    <button class="btn btn-info" type="submit" name="export" value="export"> <i class="ace-icon fa fa-check bigger-110"></i> 导出 </button>
                </div>
            -->
            </div>
        </form>
        </div>
        <div class="table-header">
            {if $pages.totalCount>$pages.curPage*$pages.pageSize}
            第 {($pages.curPage-1)*$pages.pageSize+1} 到 {$pages.curPage*$pages.pageSize} 条 共 {$pages.totalCount} 条 
            {else}
            第 {($pages.curPage-1)*$pages.pageSize+1} 到 {$pages.totalCount} 条 共 {$pages.totalCount} 条
            {/if}
            &nbsp; 第 {$pages.curPage}/{$pages.totalPage} 页
            &nbsp; 总计：
            积分余额={$totalInfo.points_total} 积分获得={$totalInfo.points_gain} 积分消费={$totalInfo.points_consume}
            金额余额={$totalInfo.money_total} 金额获得={$totalInfo.money_gain} 金额提现={$totalInfo.money_withdraw}
            <!--
            <span class="pull-right">
                <a href="fanghuadmin.php?r=memberReport/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
            </span>
            -->
        </div>
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>手机号码</th>
                    <th>积分余额</th>
                    <th>积分获得</th>
                    <th>积分消费</th>
                    <th>会员等级</th>
                    <th>金额余额</th>
                    <th>金额获得</th>
                    <th>金额提现</th>
                    <th>状态</th>
                    <th>注册来源</th>
                    <th>注册时间</th>
                    <th>最后登录时间</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td member_id={$objModel.member_id}>{($pages.curPage-1)*$pages.pageSize+1 + $i}</td>
                    <td>{$objModel.member_fullname}</td>
                    <td>{$objModel.member_mobile}</td>
                    <td>{$objModel.points_total}</td>
                    <td>{$objModel.points_gain}</td>
                    <td>{$objModel.points_consume}</td>
                    <td>{$arrLevel[$objModel.level].title}({$arrLevel[$objModel.level].name})</td>
                    <td>{$objModel.money_total}</td>
                    <td>{$objModel.money_gain}</td>
                    <td>{$objModel.money_withdraw}</td>
                    <td title="status={$objModel.status}">
                        {if isset($arrStatus[$objModel.status])}
                            {$arrStatus[$objModel.status]}
                        {else}
                            无效
                        {/if}
                    </td>
                    <td>
                        {if isset($arrMemberFrom[$objModel.member_from])}
                            {$arrMemberFrom[$objModel.member_from]}
                        {else}
                            -
                        {/if}
                    </td>
                    <td>{$objModel.create_time}</td>
                    <td>{$objModel.last_login}</td>
                    <!--
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                        <a href="fanghuadmin.php?r=memberReport/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                        </div>
                    </td>
                    -->
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
    </div><!-- /.col-xs-12 -->
</div><!-- /.row -->
</div>
<!-- /.page-content-area --> 