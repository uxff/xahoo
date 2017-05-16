<div class="page-content-area">
        <div class="page-header">
                                <h1> <a href="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>"><?php echo $this->modelClass; ?></a> <small> <i class="ace-icon fa fa-angle-double-right"></i> 编辑 </small> </h1><br />
                <h1> 提示信息： <small> 以下均为必选项 </small> </h1>
        </div>
        <!-- /.page-header -->



        <div class="row">
                <div class="col-xs-12"> 
                        <!-- PAGE CONTENT BEGINS -->
                        {if $errormsgs}
                            <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">
                                            <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    {$errormsgs}
                            </div>
                        {/if}

                        <form class="form-horizontal" id="<?php echo $this->controllerID; ?>-form" role="form" action="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/update&id={$model[$primaryKey]}" method="POST">
                              <?php
                            foreach ($this->tableSchema->columns as $column) {
                                    echo $this->generateActiveField($this->modelClass, $column);
                            }
                            ?>
                                <div class="clearfix form-actions">
                                        <div class="col-md-offset-5 col-md-9">
                                                <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 提交 </button>
                                        </div>
                                </div>
                        </form>
                </div>
                <!-- /.col --> 
        </div>
        <!-- /.row --> 
</div>
{if !empty($jsShell)}
    {$jsShell}
{/if}
<!-- /.page-content-area --> 