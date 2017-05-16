<div class="page-content-area">
    <div class="page-header">
        <h1> <a href="fanghuadmin.php?r=picset">图库管理</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看详情 </small> </h1>
    </div>
    <!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12"> 
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <div id="content">
                        <!--
                        <h1>View PicSetModel #{$objModel.id}</h1>
                        -->
                        <table id="idTable" class="table table-striped table-bordered table-hover">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{$objModel.id}</td>
                            </tr>
                            <tr>
                                <td>图片标题</td>
                                <td>{$objModel.title}</td>
                            </tr>
                            <tr>
                                <td>图片用途</td>
                                <td>
                                    {if isset($arrUsedType[$objModel.used_type])}
                                        {$arrUsedType[$objModel.used_type]}
                                    {else}
                                        -
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>图片类型</td>
                                <td>
                                    {if isset($arrType[$objModel.type])}
                                        {$arrType[$objModel.type]}
                                    {else}
                                        -
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>轮播间隔</td>
                                <td>{$objModel.circle_sec} s</td>
                            </tr>
                            <tr>
                                <td>创建人</td>
                                <td>{$objModel.author_name}</td>
                            </tr>
                            <tr>
                                <td>创建时间</td>
                                <td>{$objModel.create_time}</td>
                            </tr>
                            <tr>
                                <td>最后修改时间</td>
                                <td>{$objModel.last_modified}</td>
                            </tr>
                        </tbody>
                        </table>
                        <!--图片信息-->
                        <table id="idTable2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>序号</td>
                                <td>图片</td>
                                <td>URL</td>
                                <td>权重</td>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$objModel.pics key=kId item=picObj}
                            <tr>
                                <td>{$kId+1}</td>
                                <td><img src="{$picObj.file_path}" style="width:250px;height:173px"/></td>
                                <td>{$picObj.link_url}</td>
                                <td>{$picObj.weight}</td>
                            </tr>
                            {/foreach}
                        </tbody>
                        </table>
                    </div>
                </div><!-- /.col-xs-12 -->
            </div><!-- /.row -->
        </div><!-- /.ol-xs-12 -->
    </div><!-- /.row -->
</div>
<!-- /.page-content-area -->