<div class="page-content-area">
    <div class="page-header">
        <h1> <a href="backend.php?r=actcms">文章管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看详情 </small> </h1>
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
                                    <td>文章ID</td>
                                    <td>{$objModel.id}</td>
                                </tr>
                                <tr>
                                    <td>文章名称</td>
                                    <td>
                                    {if $objModel.visit_url}
                                    <a href="{$objModel.visit_url}" target="_blank">{$objModel.title}</a>
                                    {else if $objModel.outer_url}
                                    <a href="{$objModel.outer_url}" target="_blank">{$objModel.title}</a>
                                    {else}
                                    {$objModel.title}
                                    {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>文章分类</td>
                                    <td>
                                        {if isset($arrType[$objModel.type])}
                                            {$arrType[$objModel.type]}
                                        {else}
                                            其他类型
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>文章状态</td>
                                    <td>
                                        {if isset($arrStatus[$objModel.status])}
                                            {$arrStatus[$objModel.status]}
                                        {else}
                                            -
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>URL</td>
                                    <td>{$objModel.visit_url}</td>
                                </tr>
                                <tr>
                                    <td>创建人</td>
                                    <td>{$objModel.admin_name}</td>
                                </tr>
                                <tr>
                                    <td>创建时间</td>
                                    <td>{$objModel.create_time}</td>
                                </tr>
                                <tr>
                                    <td>最后更新时间</td>
                                    <td>{$objModel.last_modified}</td>
                                </tr>
                                <tr>
                                    <td>使用的连接</td>
                                    <td>{$objModel.outer_url}</td>
                                </tr>
                                <tr>
                                    <td>文章详情</td>
                                    <td>{$objModel.content}</td>
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
