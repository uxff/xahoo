<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="fanghuadmin.php?r=pointTask">PointTask</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 任务详情 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">

                                        <div id="content">
                                                <h1>View PointTask #</h1>
                                                <table id="idTable" class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        </thead>
                                                        <tbody>
                                                                {foreach from=$attributeLabels key=attrId item=labelName}
                                                                <tr>
                                                                        <td>{$labelName}</td>
                                                                        <td>{if $attrId == 'task_img'}
                                                                                <img src="{$objModel[$attrId]}" alt="任务配图"/>
                                                                            {elseif $attrId == 'task_category' && $objModel[$attrId] == 1}
                                                                                资讯
                                                                            {elseif $attrId == 'task_category' && $objModel[$attrId] == 2}
                                                                                房源
                                                                            {elseif $attrId == 'status' && $objModel[$attrId] == 1}
                                                                                有效
                                                                            {elseif $attrId == 'status' && $objModel[$attrId] == 2}
                                                                                无效
                                                                            {else}
                                                                                {$objModel[$attrId]}
                                                                            {/if}
                                                                        </td>

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