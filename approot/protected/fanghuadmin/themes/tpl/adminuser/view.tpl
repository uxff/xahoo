<div class="page-content-area">
    <div class="page-header">
        <h1> <a href="fanghuadmin.php?r=adminUser">系统用户</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看详情 </small> </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12"> 
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">

                    <div id="content">
                        <h1>系统管理员详情 #{$objNew.id}</h1>
                        <div class="table-responsive">
                            <table id="idTable" class="table table-striped table-bordered table-hover">
                                <thead>
                                </thead>
                                <tbody>
                                    {foreach from=$attributeLabels key=attrId item=labelName}
                                        <tr>
                                            <td>{$labelName}</td>
                                            {if $attrId == 'status' && $objModel.status == 1}
                                                <td><span class="label label-sm label-success">有效</span></td>
                                            {elseif $attrId == 'status' && $objModel.status == 0}
                                                <td><span class="label label-sm label-warning">无效</span></td>
                                            {elseif $attrId == 'status' && $objModel.status == 99}
                                                <td><span class="label label-sm">删除</span></td>
                                            {else}
                                                <td>{$objModel.$attrId}</td>
                                            {/if}
                                        </tr>
                                    {/foreach}
                                    <tr>
                                        <td>角色</td>
                                        <td>{$role.0.name}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div><!-- /.col-xs-12 -->
            </div><!-- /.row -->
        </div><!-- /.ol-xs-12 -->
    </div><!-- /.row -->
</div>
<!-- /.page-content-area -->