<div class="page-content-area">
<div class="page-header">
    <h1>任务管理<small> <i class="ace-icon fa fa-angle-double-right"></i>列表</small> </h1>
</div>
<!-- /.page-header -->
<div class="row">
    <div class="col-xs-12"> 
    <!-- PAGE CONTENT BEGINS -->
    <!--
    <a href="#" onclick="$('#searchContainer').toggle();return false">检索条件</a><br />
    <div id="searchContainer" style="display: {if $searchForm}block;{else}none;{/if}">
    -->
    <div id="searchContainer">
        <form class="form-horizontal"  id="taskTplMgr-form" role="form" action="backend.php?r=taskTplMgr/index" method="GET">
            <input type="hidden" name="r" value="{$route}" />
            <div class="col-xs-12">
                <br/>
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="TaskTplModel_task_name">任务名称</label>
                    <div class="col-xs-8"><input type="text" id="TaskTplModel_task_name" name="TaskTplModel[task_name]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.task_name}" /></div>
                </div>
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="TaskTplModel_task_type">模板分类</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="TaskTplModel_task_type" name="TaskTplModel[task_type]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.task_type eq "1"} selected="selected"{/if}>分享任务</option>
                        <option value="2"{if $dataObj.task_type eq "2"} selected="selected"{/if}>完善信息</option>
                        <option value="3"{if $dataObj.task_type eq "3"} selected="selected"{/if}>邀请注册</option>
                        </select>
                    </div>
                </div>
                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_task_desc">任务描述</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_task_desc" name="TaskTplModel[task_desc]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.task_desc}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_task_desc_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_task_url">任务url</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_task_url" name="TaskTplModel[task_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.task_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_task_url_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_surface_url">封面图</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_surface_url" name="TaskTplModel[surface_url]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.surface_url}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_surface_url_em_">  </span> </div>
                </div>
                -->
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="TaskTplModel_act_type">任务分类</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="TaskTplModel_act_type" name="TaskTplModel[act_type]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.act_type eq "1"} selected="selected"{/if}>活动分享</option>
                        <option value="2"{if $dataObj.act_type eq "2"} selected="selected"{/if}>项目分享</option>
                        <option value="3"{if $dataObj.act_type eq "3"} selected="selected"{/if}>企业资讯</option>
                        <option value="4"{if $dataObj.act_type eq "4"} selected="selected"{/if}>其他</option>
                        </select>
                    </div>
                </div>

                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_reward_points">积分分值</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_reward_points" name="TaskTplModel[reward_points]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.reward_points}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_reward_points_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_rule_id">积分规则id</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_rule_id" name="TaskTplModel[rule_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.rule_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_rule_id_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_step_need_count">任务需要的进度数(比如邀请数)</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_step_need_count" name="TaskTplModel[step_need_count]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.step_need_count}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_step_need_count_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_weight">权重:越小排序越前</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_weight" name="TaskTplModel[weight]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.weight}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_weight_em_">  </span> </div>
                </div>
                -->

                <!-- 添加的时间日期插件-->
                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="create_time">创建时间</label>
                    <div class="col-xs-8">
                        <div class="input-group lablediv1" style="width:270px;" style="float:right;">
                            <input type="text" class="form-control year-picker create_time_start" data-date-format="yyyy-mm-dd"
                                   id="create_time_start" name="condition[create_time_start]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$condition.create_time_start}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                            <input type="text" class="form-control year-picker create_time_end" data-date-format="yyyy-mm-dd"
                                   id="create_time_end" name="condition[create_time_end]" size="60" maxlength="200"
                                   class="col-xs-10 col-sm-5" value="{$condition.create_time_end}"/>
                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="form-group  col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="TaskTplModel_status">任务状态</label>
                    <div class="col-xs-8">
                        <select class="form-control" id="TaskTplModel_status" name="TaskTplModel[status]" style="width:120px;">
                        <option value="">请选择</option>
                        <option value="1"{if $dataObj.status eq "1"} selected="selected"{/if}>未发布</option>
                        <option value="2"{if $dataObj.status eq "2"} selected="selected"{/if}>已发布</option>
                        <option value="3"{if $dataObj.status eq "3"} selected="selected"{/if}>已撤销</option>
                        </select>
                    </div>
                </div>

                <!--
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_flag">标记：1=普通；2=热推</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_flag" name="TaskTplModel[flag]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.flag}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_flag_em_">  </span> </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="TaskTplModel_admin_id">创建人id</label>
                    <div class="col-sm-7"><input type="text" id="TaskTplModel_admin_id" name="TaskTplModel[admin_id]" size="60" maxlength="200" class="col-xs-10 col-sm-5" value="{$dataObj.admin_id}" /></div>
                    <div class="col-sm-2"> <span class="help-inline middle" id="TaskTplModel_admin_id_em_">  </span> </div>
                </div>
                -->

                <div class="form-group col-xs-3">
                    <label class="col-xs-3 control-label no-padding-right" for="TaskTplModel_admin_name">创建人</label>
                    <div class="col-xs-8"><input type="text" id="TaskTplModel_admin_name" name="TaskTplModel[admin_name]" size="60" maxlength="200" class="col-xs-12" value="{$dataObj.admin_name}" /></div>
                </div>
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                    <div class="col-xs-offset-2 col-xs-11" style="display:inline-block; white-space:nowrap;">
                        <button style="float:right;width:120px;" class="btn btn-info col-xs-12" type="submit"> 查询 </button>
                        <!--
                        <button style="float:right;width:120px;" class="btn btn-info col-xs-12" type="submit" name="export" value="export"> 导出 </button>
                        -->
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
            </div>
            </form>
        </div>
        <div class="table-header">
            {if $pages.totalCount>$pages.pageSize}
            <!--
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.curPage*$pages.pageSize} of {$pages.totalCount} results
            -->
                共{$pages.totalCount}条记录，当前为第{($pages.curPage-1)*$pages.pageSize+1}到{$pages.curPage*$pages.pageSize}条记录
            {else}
            <!--
            Showing {($pages.curPage-1)*$pages.pageSize+1} to {$pages.totalCount} of {$pages.totalCount} results
            -->
                共{$pages.totalCount}条记录，当前为第{($pages.curPage-1)*$pages.pageSize+1} 到{$pages.totalCount}条记录
            {/if}
            <span class="pull-right">
                <a href="backend.php?r=taskTplMgr/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
            </span>
        </div>
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <td>序号</td>
                        <td>任务名称</td>
                        <td>积分</td>
                        <td>积分上限</td>
                        <td>金额</td>
                        <td>金额上限</td>
                        <td>任务分类</td>
                        <td>任务状态</td>
                        <td>权重</td>
                        <td>添加人</td>
                        <td>添加时间</td>
                        <td>最后更新时间</td>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$arrData key=i item=objModel}
                    <tr>
                        <td>{$i+1}</td>
                        <td>{$objModel.task_name}</td>
                        <td data="{$objModel.reward_type}">{$objModel.reward_points * 1}分</td>
                        <td>{$objModel.integral_upper}分</td>
                        <td>￥{number_format($objModel.reward_money,2)}</td>
                        <td>￥{$objModel.money_upper}</td>
                        <td>
                            {if isset($arrActType[$objModel.act_type])}
                                {$arrActType[$objModel.act_type]}
                            {else}
                                -
                            {/if}
                        </td>
                        <td>
                            {if isset($arrStatus[$objModel.status])}
                                {$arrStatus[$objModel.status]}
                            {else}
                                -
                            {/if}
                        </td>
                        <td>{$objModel.weight}</td>
                        <td>{$objModel.admin_name}</td>
                        <td>{$objModel.create_time}</td>
                        <td>{$objModel.last_modified}</td>
                        <td>
                            <div class="hidden-sm hidden-xs btn-group">
                                <a href="backend.php?r=taskTplMgr/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                                <a href="backend.php?r=taskTplMgr/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                                <button onclick="delConfirm('backend.php?r=taskTplMgr/delete&amp;id={$objModel.$modelId}&token={$token}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                            </div>
                            <div class="hidden-md hidden-lg">
                                <div class="inline position-relative">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li> <a href="backend.php?r=taskTplMgr/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                        <li> <a href="backend.php?r=taskTplMgr/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                        <li> <button onclick="delConfirm('backend.php?r=taskTplMgr/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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
    </div><!-- /.col-xs-12 -->
    </div><!-- /.row -->
</div>
<!-- /.page-content-area --> 