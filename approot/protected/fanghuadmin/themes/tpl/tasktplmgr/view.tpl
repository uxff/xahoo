<style>
.title {
    height:38px;
    padding-left:10px;
    font-size:18px;
    background:#e3e3e3;
    line-height:38px;
    border-radius:5px;
    font-family:"微软雅黑";
}
.tille_order {
    font-family:"微软雅黑";
    font-size:16px;
}
.tpl_table td:nth-child(odd){
    width:10%;
    background:#f2f2f2 !important;
}
.tpl_table td:nth-child(even){
    width:15%;
}
.table_img td {
    text-align:center;
}
.tpl_btn {
    width: 100px;
    border-radius: 5px;
}
</style>
<div class="page-content-area">
    <div class="page-header">
        <h1>
            <a href="backend.php?r=taskTplMgr">任务管理</a>
            <small> <i class="ace-icon fa fa-angle-double-right"></i>
                查看详情
            </small>
        </h1>
    </div>
    <!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div id="content">
                        <h3 class="title">基本信息</h3>
                        <table id="idTable" class="table table-striped table-bordered table-hover tpl_table">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>任务ID</td>
                                    <td>{$objModel.task_id}</td>
                                    <td>任务名称</td>
                                    <td>{$objModel.task_name}</td>
                                    <td>积分</td>
                                    <td>+{$objModel.reward_points}</td>
                                    <td>金额</td>
                                    <td>￥{$objModel.reward_money}</td>
                                </tr>
                                <tr>
                                    <td>任务状态</td>                                    
                                    <td>
                                        {if isset($arrStatus[$objModel.status])}
                                        {$arrStatus[$objModel.status]}
                                    {else}
                                        -
                                    {/if}
                                    </td>
                                    <td>任务分类</td>
                                    <td>
                                        {if isset($arrActType[$objModel.act_type])}
                                        {$arrActType[$objModel.act_type]}
                                    {else}
                                        -
                                    {/if}
                                    </td>
                                    <td>点击次数</td>
                                    <td>这里是点击次数</td>
                                    <td>目标分类</td>
                                    <td>
                                        {if isset($arrTaskType[$objModel.task_type])}
                                        {$arrTaskType[$objModel.task_type]}
                                    {else}
                                        -
                                    {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>目标数量</td>
                                    <td>{$objModel.step_need_count}</td>
                                    <td>添加人</td>
                                    <td>{$objModel.admin_name}</td>
                                    <td>添加时间</td>
                                    <td>{$objModel.create_time}</td>
                                    <td>最后更新时间</td>
                                    <td>{$objModel.last_modified}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 class="title">图片信息</h3>
                        <table id="idTable2" class="table table-striped table-bordered table-hover table_img">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td>序号</td>
                                    <td>图片</td>
                                    <td>URL</td>
                                    <td>权重</td>
                                </tr>
                                <tr>
                                    <td width="4%">1</td>
                                    <td width="32%">
                                        <img src="{$objModel.surface_url}" style="width:250px;height:173px"/>
                                    </td>
                                    <td width="32%">
                                        <a href="{$objModel.task_url}" target="_blank">{$objModel.task_url}</a>
                                    </td>
                                    <td width="32%">{$objModel.weight}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-5 col-md-9">
                                <!--返回-->
                                <a href="backend.php?r=taskTplMgr"  class="btn btn-info tpl_btn">返 回</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-xs-12 --> </div>
            <!-- /.row --> </div>
        <!-- /.ol-xs-12 --> </div>
    <!-- /.row -->
</div>
<!-- /.page-content-area -->