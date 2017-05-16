{include file="tpl.header.html"}


<div class="span-19">
    <div id="content">
        <h1>List News</h1>

        <div id="yw0" class="list-view">
            <div class="summary">Displaying 1-{$dataCount} of {$dataCount} result.</div>
            <div class="items">
                {if $data}
                {foreach from=$data key=i item=objNew}
                <div class="view">
                    <b>编号:</b>
                    <a href="index.php?r=newsSmarty/view&id={$objNew.new_id}">{$objNew.new_id}</a><br>

                    <b>新闻标题:</b>
                    {$objNew.new_title}    <br>

                    <b>新闻内容:</b>
                    {$objNew.new_content} <br>

                    <b>新闻类型:</b>
                    {$objNew.new_type} <br>

                    <b>排序类型:</b>
                    {$objNew.sort_order} <br>

                    <b>状态:</b>
                    {$objNew.status} <br>

                    <b>创建时间:</b>
                    {$objNew.last_modified} <br>
                </div>
                {/foreach}
                {/if}
            </div>
            <div class="keys" style="display:none" title="index.php?r=newsSmarty/index"></div>
        </div>
    </div><!-- content -->
</div>

{include file="tpl.sidebar.html"}

</div><!-- page -->

{include file="tpl.footer.html"}