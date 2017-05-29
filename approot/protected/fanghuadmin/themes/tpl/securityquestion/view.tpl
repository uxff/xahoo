<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="backend.php?r=securityQuestion">SecurityQuestion</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看详情 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">

                                        <div id="content">
                                                <h1>View SecurityQuestion #{$objModel.id}</h1>
                                                <table id="idTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        </thead>
                                                        <tbody>
                                                                {foreach from=$attributeLabels key=attrId item=labelName}
                                                                <tr>
                                                                        <td>{$labelName}</td>
                                                                        <td>{$objModel[$attrId]}</td>
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