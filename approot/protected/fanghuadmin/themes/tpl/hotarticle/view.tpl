<div class="page-content-area">
    <div class="page-header">
        <h1> <a href="backend.php?r=hotArticle">热门推荐</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看详情 </small> </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12"> 
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">

                    <div id="content">
                        <table id="idTable" class="table table-striped table-bordered table-hover">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>推荐ID</td>
                                    <td>{$objModel.id}</td>
                                </tr>
                                <tr>
                                    <td>推荐名称</td>
                                    <td>{$objModel.title}</td>
                                </tr>
                                <tr>
                                    <td>标签</td>
                                    <td>{$objModel.tips}</td>
                                </tr>
                                <tr>
                                    <td>推荐状态</td>
                                    <td>
                                        {if isset($arrStatus[$objModel.status])}
                                            {$arrStatus[$objModel.status]}
                                        {else}
                                            <span title="未知状态：{$objModel.status}">其他</span>
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>活动分类</td>
                                    <td>
                                        {if isset($arrType[$objModel.act_type])}
                                            {$arrType[$objModel.act_type]}
                                        {else}
                                            <span title="未知分类：{$objModel.act_type}">其他</span>
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>添加人</td>
                                    <td>{$objModel.admin_name}</td>
                                </tr>
                                <tr>
                                    <td>添加事件</td>
                                    <td>{$objModel.create_time}</td>
                                </tr>
                                <tr>
                                    <td>最后更新时间</td>
                                    <td>{$objModel.last_modified}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="idTable2" class="table table-striped table-bordered table-hover">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>序号</td>
                                    <td>图片</td>
                                    <td>URL</td>
                                    <td>权重</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <img src="{$objModel.surface_url}" style="width:250px;height:173px"/>
                                    </td>
                                    <td><a href="{$objModel.url}" target="_blank">{$objModel.url}</a></td>
                                    <td>{$objModel.weight}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!-- /.col-xs-12 -->
            </div><!-- /.row -->
        </div><!-- /.ol-xs-12 -->
    </div><!-- /.row -->
</div>
<!-- /.page-content-area -->