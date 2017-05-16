{include file="tpl.header.html"}


    <div class="span-19">
        
        <div id="content">
        
            <h1>View <?php echo $this->modelClass; ?> #{$objNew.new_id}</h1>

            <table class="detail-view" id="yw0">
            <tbody>
                <tr class="odd"><th>编号</th><td>{$objNew.new_id}</td></tr>
                <tr class="even"><th>新闻标题</th><td>{$objNew.new_title}</td></tr>
                <tr class="odd"><th>新闻内容</th><td>{$objNew.new_content}</td></tr>
                <tr class="even"><th>新闻类型</th><td>{$objNew.new_type}</td></tr>
                <tr class="odd"><th>排序类型</th><td>{$objNew.sort_order}</td></tr>
                <tr class="even"><th>状态</th><td>{$objNew.status}</td></tr>
                <tr class="odd"><th>创建时间</th><td>{$objNew.create_time}</td></tr>
                <tr class="even"><th>最后修改时间</th><td>{$objNew.last_modified}</td></tr>
            </tbody>
            </table>    
        </div>

    </div>

    <div class="span-5 last">
        <div id="sidebar">
            <div class="portlet" id="yw0">
                <div class="portlet-decoration">
                    <div class="portlet-title">Operations</div>
                </div>
                <div class="portlet-content">
                    <ul class="operations" id="yw1">
                        <li><a href="index.php?r=<?php echo $this->controllerClass;?>/index">List <?php echo $this->modelClass; ?></a></li>
                        <li><a href="index.php?r=<?php echo $this->controllerClass;?>/create">Create <?php echo $this->modelClass; ?></a></li>
                        <li><a href="index.php?r=<?php echo $this->controllerClass;?>/update&id={$objNew.new_id}">Update <?php echo $this->modelClass; ?></a></li>
                        <li><a href="index.php?r=<?php echo $this->controllerClass;?>/delete&id={$objNew.new_id}">Delete <?php echo $this->modelClass; ?></a></li>
                        <li><a href="index.php?r=<?php echo $this->controllerClass;?>/admin">Manage News</a></li>
                    </ul>
                </div>
            </div>      
        </div><!-- sidebar -->
    </div>

</div><!-- page -->

{include file="tpl.footer.html"}