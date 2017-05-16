<div class="page-content-area">
<div class="page-header">
    <h1> <?php echo $this->modelClass; ?> <small> <i class="ace-icon fa fa-angle-double-right"></i> 列表 </small> </h1>
</div>
<!-- /.page-header -->

<div class="row">
    <div class="col-xs-12"> 
    <!-- PAGE CONTENT BEGINS -->
    <!--
        <a href="#" onclick="$('#searchContainer').toggle();return false">检索条件</a><br />
    -->
        <div id="searchContainer" style="display: block; {if $searchForm}block;{else}none;{/if}">                                      
        <form class="form-horizontal"  id="<?php echo $this->controllerID; ?>-form" role="form" action="#" method="GET">
            <input type="hidden" name="r" value="{$route}" />
            <div class="col-xs-12">
                <br/>
                <?php
                foreach ($this->tableSchema->columns as $k=>$column) {
                    if (($k)%4==3) {
                        echo '
            </div>
            <div class="col-xs-12">
';
                    }
                    echo $this->generateActiveField($this->modelClass, $column);
                }
                ?>

                <!--补齐空格位置-->
                <div class="form-group col-xs-3">
                    &nbsp;
                </div>
                <div class="form-group col-xs-3">
                    <div class="col-xs-offset-2 col-xs-11" style="display:inline-block; white-space:nowrap;">
		    	<!--如果只有查询，使用： style="float:right;width:120px;"-->
                        <button style="float:left;width:120px;" class="btn btn-info col-xs-12" type="submit"> 查询 </button>
                        <button style="float:right;width:120px;" class="btn btn-info col-xs-12" type="submit" name="export" value="export"> 导出 </button>
                    </div>
                </div>
            </div>

            <div class="clearfix form-actions">
            <!-- 居中查询按钮 暂时隐藏
                <div class="col-md-offset-5 col-md-9">
                    <button class="btn btn-info" type="submit"> <i class="ace-icon fa fa-check bigger-110"></i> 查询 </button>
                    &nbsp;
                    <button class="btn btn-info" type="submit" name="export" value="export"> <i class="ace-icon fa fa-check bigger-110"></i> 导出 </button>
                </div>
            -->
            </div>
        </form>
        </div>
        <div class="table-header">
            {if $pages.totalCount>$pages.curPage*$pages.pageSize}
            第 {($pages.curPage-1)*$pages.pageSize+1} 到 {$pages.curPage*$pages.pageSize} 条 共 {$pages.totalCount} 条
            {else}
            第 {($pages.curPage-1)*$pages.pageSize+1} 到 {$pages.totalCount} 条 共 {$pages.totalCount} 条
            {/if}
            &nbsp; 第 {$pages.curPage}/{$pages.totalPage} 页
            <span class="pull-right">
                <a href="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/create" class="btn btn-xs btn-success"><i class="ace-icon fa fa-plus bigger-120"></i>新增 </a>
            </span>
        </div>
        <div class="table-responsive">
            <table id="idTable" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</td>
                    <?php
                    foreach ($this->tableSchema->columns as $k=>$column) {
                        echo '<th>'.$column->comment.'</th>
                    ';
                    }
                    ?>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$arrData key=i item=objModel}
                <tr>
                    <td>{($pages.curPage-1)*$pages.pageSize+1 + $i}</td>
                    <?php
                    foreach ($this->tableSchema->columns as $k=>$column) {
                        echo '<td>{$objModel.'.$column->name.'}</td>
                    ';
                    }
                    ?>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                        <a href="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/view&id={$objModel.$modelId}" class="btn btn-xs btn-info"> <i class="ace-icon fa fa-search-plus bigger-120"></i>查看 </a>
                        <a href="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/update&id={$objModel.$modelId}" class="btn btn-xs btn-success"> <i class="ace-icon fa fa-pencil bigger-120"></i>编辑 </a>
                        <button onclick="delConfirm('<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/delete&amp;id={$objModel.$modelId}');" data-url="" class="btn btn-xs btn-danger"> <i class="ace-icon fa fa-trash-o bigger-120"></i>删除 </button>
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div class="inline position-relative">
                                <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto"> <i class="ace-icon fa fa-cog icon-only bigger-110"></i> </button>
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li> <a href="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/view&id={$objModel.$modelId}" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="ace-icon fa fa-search-plus bigger-120"></i> </span> </a> </li>
                                    <li> <a href="<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/update&id={$objModel.$modelId}" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="ace-icon fa fa-pencil-square-o bigger-120"></i> </span> </a> </li>
                                    <li> <button onclick="delConfirm('<?php echo str_replace("/", '', Yii::app()->homeUrl); ?>?r=<?php echo $this->controllerID; ?>/delete&amp;id={$objModel.$modelId}');" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="ace-icon fa fa-trash-o bigger-120"></i> </span> </button> </li>
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