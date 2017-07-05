<div class="page-content-area">
        <div class="page-header">
                <h1> <a href="backend.php?r=taskBuilding">TaskBuilding</a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 查看详情 </small> </h1>
        </div>
        <!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                                <div class="col-xs-12">

                                        <div id="content">
                                                <h1>View TaskBuilding #{$objModel.task_id}</h1>
                                                <table id="idTable" class="table table-striped table-bordered table-hover" style="width:100%; table-layout : fixed">
                                                        <thead>
                                                        </thead>
                                                        <tbody>
                                                                {foreach from=$attributeLabels key=attrId item=labelName}
                                                                <tr>
                                                                    {if $labelName == '任务配图'}
                                                                        <td>任务配图</td>
                                                                        <td><img src="{$objModel[$attrId]}" alt="{$labelName}"/></td>
																	{elseif $labelName == '楼盘详情'}
																		<td>{$labelName}</td>
																		<td style="overflow: hidden">{$objModel[$attrId]}</td>
                                                                    {else}
                                                                        <td>{$labelName}</td>
                                                                        <td>{$objModel[$attrId]}</td>
                                                                    {/if}
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