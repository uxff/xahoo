<div class="page-content-area">
<div class="page-header">
    <h1> 运营报表 <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
</div>
<!-- /.page-header -->

<div class="row">
    <div class="col-xs-12"> 
    <!-- PAGE CONTENT BEGINS -->
        <!--
        <a href="#" onclick="$('#searchContainer').toggle();return false">检索条件</a><br />
        -->
        <div id="searchContainer" style="display: block; {if $searchForm}block;{else}none;{/if}">                                      
        <form class="form-horizontal"  id="stasticByDay-form" role="form" action="#" method="GET">
            <input type="hidden" name="r" value="{$route}" />
            <div class="col-xs-12">
                <br/>
                <!--
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_date">日期</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_date" name="StasticByDayModel[date]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.date}" /></div>
                </div>
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_pv">PV</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_pv" name="StasticByDayModel[pv]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.pv}" /></div>
                </div>
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_uv">UV</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_uv" name="StasticByDayModel[uv]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.uv}" /></div>
                </div>
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_share_count">转发量</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_share_count" name="StasticByDayModel[share_count]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.share_count}" /></div>
                </div>
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_reg_count">新增用户</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_reg_count" name="StasticByDayModel[reg_count]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.reg_count}" /></div>
                </div>
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_xqsj_pv">新奇访问用户</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_xqsj_pv" name="StasticByDayModel[xqsj_pv]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.xqsj_pv}" /></div>
                </div>
                <div class="form-group col-xs-3" maker="xdr">
                    <label class="col-xs-3 control-label no-padding-right" for="StasticByDayModel_xqsj_uv">新奇访问uv</label>
                    <div class="col-xs-8"><input type="text" id="StasticByDayModel_xqsj_uv" name="StasticByDayModel[xqsj_uv]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.xqsj_uv}" /></div>
                </div>
                -->
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="create_time">统计时间</label>
                    <div class="col-xs-8">
                        <div class="input-group lablediv1" style="width:270px;" style="float:right;">
                            <input type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd"
                                   id="time_start" name="condition[time_start]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$condition['time_start']}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            <input type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd"
                                   id="time_end" name="condition[time_end]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$condition['time_end']}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                   
                        <button style="float:left;width:120px;" class="btn btn-info col-xs-12" type="submit"> 查询 </button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button style="float:right;width:120px;" class="btn btn-info col-xs-12" type="submit" name="export" value="export"> 导出 </button>
                   
                </div>
            </div>

            <div class="clearfix form-actions">
            </div>
        </form>
        </div>
        <div class="table-header">
            {if $pages.totalCount>$pages.curPage*$pages.pageSize}
            第 {($pages.curPage-1)*$pages.pageSize+1} 到 {$pages.curPage*$pages.pageSize} 条 共 {$pages.totalCount} 条
            {else}
            第 {($pages.curPage-1)*$pages.pageSize+1} 到 {$pages.totalCount} 条 共 {$pages.totalCount} 条
            {/if}
        </div>
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>日期</th>
                    <th>PV(活动累计)</th>
                    <th>UV(活动累计)</th>
                    <th>转发量</th>
                    <th>新增用户</th>
                    <th>新奇访问用户</th>
                    <th>积分单日增量</th>
                    <th>积分单日消耗</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td>{($pages.curPage-1)*$pages.pageSize+1 + $i}</td>
                    <td>{$objModel.date}</td>
                    <td>{$objModel.pv}</td>
                    <td>{$objModel.uv}</td>
                    <td>{$objModel.share_count}</td>
                    <td>{$objModel.reg_count}</td>
                    <td>{$objModel.xqsj_uv}</td>
                    <td>{$objModel.points_add}</td>
                    <td>{$objModel.points_consume}</td>
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