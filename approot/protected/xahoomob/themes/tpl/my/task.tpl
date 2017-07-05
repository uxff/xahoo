<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/list.css" />
    <section class="task-list">
        {if !empty($myTaskListAll['list'])}
        <div class="tab my-list-tab">
            <a href="javascript:;" class="on">全部</a>
            <a href="javascript:;" class="off center">进行中</a>
            <a href="javascript:;" class="off">已完成</a>
        </div>
        {/if}
        <div class="content">
            {if empty($myTaskListAll['list'])}
            <ul style="display:none">
            {else}
            <ul>
            {/if}
                <li class="list-tab" name="all-tasks" style="display:block;">
                    <ul>
                    {if empty($myTaskListAll['list'])}
                        <li>
                            <div class="no_task">
                                <h3>您还没有任务</h3>
                                <p>完成任务可以赚得积分哟~~</p>
                                <a href="javascript:;" class="btn">马上去领任务</a>
                            </div>
                        </li>
                    {else}
                        {foreach from=$myTaskListAll['list'] key=k item=taskInstObj}
                        {if empty($taskInstObj.task_tpl)}{continue}{/if}
                        <li>
                            <a href="{$taskInstObj.task_tpl.task_url}&task_id={$taskInstObj.task_tpl.task_id}&share_code={$shareCode}">
                                <div class="task_img">
                                    <img src="{$taskInstObj.task_tpl.surface_url}" coolieignore/>
                                </div>
                                <div class="fl task-info">
                                    <h3>{$taskInstObj.task_tpl.task_name}</h3>
                                    <p><i class="iconfont icon-money"></i>{$taskInstObj._reward_desc}</p>
                                </div>
                            </a>
                        </li>
                        {/foreach}
                    {/if}
                    </ul>
                </li>
                <!--进行中任务-->
                <li class="list-tab" name="pending-tasks">
                    <ul>
                    {if empty($myTaskListAchieved['list'])}
                        <li>
                            您还没有进行中任务
                        </li>
                    {else}
                        {foreach from=$myTaskListAchieved['list'] key=k item=taskInstObj}
                        {if empty($taskInstObj.task_tpl)}{continue}{/if}
                        <li>
                            <a href="{$taskInstObj.task_tpl.task_url}&task_id={$taskInstObj.task_tpl.task_id}&share_code={$shareCode}">
                                <div class="task_img">
                                    <img src="{$taskInstObj.task_tpl.surface_url}" coolieignore/>
                                </div>
                                <div class="fl task-info">
                                    <h3>{$taskInstObj.task_tpl.task_name}</h3>
                                    <p class="active"><i class="iconfont icon-money"></i>{$taskInstObj._reward_desc}<span>点击：{$taskInstObj.view_count*1}次</span></p>
                                </div>
                            </a>
                        </li>
                        {/foreach}
                    {/if}
                    </ul>
                </li>
                <!--已完成任务-->
                <li class="list-tab" name="completed-tasks">
                    <ul>
                    {if empty($myTaskListFinished['list'])}
                        <li>
                            您还没有已完成任务
                        </li>
                    {else}
                        {foreach from=$myTaskListFinished['list'] key=k item=taskInstObj}
                        {if empty($taskInstObj.task_tpl)}{continue}{/if}
                        <li>
                            <a href="{$taskInstObj.task_tpl.task_url}&task_id={$taskInstObj.task_tpl.task_id}&share_code={$shareCode}">
                                <div class="task_img">
                                    <img src="{$taskInstObj.task_tpl.surface_url}" coolieignore/>
                                </div>
                                <div class="fl task-info task-over">
                                    <h3>{$taskInstObj.task_tpl.task_name}</h3>
                                    <p class="active"><i class="iconfont icon-money"></i>{$taskInstObj._reward_desc}<span>点击：{$taskInstObj.view_count*1}次</span></p>
                                </div>
                            </a>
                        </li>
                        {/foreach}
                    {/if}
                    </ul>
                </li>
            </ul>
            {if empty($myTaskListAll['list'])}
            <div class="no_task">
                <h3>您还没有任务</h3>
                <p>完成任务可以赚得积分哟~~</p>
                <a href="{yii_createurl c=lizhuan a=index}" class="btn">马上去领任务</a>
            </div>
            {/if}
        </div>
    </section>
    <script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
        data-config="../../conf/coolie-config.js"
        data-main="../main/list_main.js"></script>
<script>
var url = '{yii_createurl c=my a=ajaxTask}';
</script>