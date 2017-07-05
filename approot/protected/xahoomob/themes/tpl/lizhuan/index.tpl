<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/xahoo3.0/css/list.css" />
<!--/coolie-->
	<section class="task-list" style="padding-top:0;">
		<div class="tab">
	    	<a href="javascript:;" class="on">最新任务</a>
	        <a href="javascript:;" class="off">已完成任务</a>
	    </div>
	    <div class="content">
	    	<ul>
	        	<li class="list-tab" name="new-tasks" style="display:block;">
					<ul>
                        {foreach from=$taskTplList key=k item=taskTplObj}
						<li>
							<a href="{yii_createurl c=lizhuan a=joinTask taskTplId=$taskTplObj.task_id accounts_id=$accounts_id}">
								<div class="task_img">
									<img data-original="{$taskTplObj.surface_url}" coolieignore src="../../../../../resource/xahoo3.0/images/integral/bg.png"/>
								</div>
								<div class="fl task-info">
									<h3>{$taskTplObj.task_name}</h3>
									<p class="active"><i class="iconfont icon-money"></i>{$taskTplObj._reward_desc}&nbsp;&nbsp;{$taskTplObj._reward_desc2}</p>
								</div>
							</a>
							<div class="fr task-btnbox">
								<a class="sm-btn" href="{yii_createurl c=lizhuan a=joinTask taskTplId=$taskTplObj.task_id accounts_id=$accounts_id}">我要参与</a>
							</div>
						</li>
                        {/foreach}
					</ul>
	        	</li>
	            <li class="list-tab" name="completed-tasks">
	            	<ul>
                        <!--已完成任务-->
                        {if $isGuest}
                        <li>
                        	请登录后查看我的已完成任务
                        </li>
                        {elseif empty($myTaskListFinished['list'])}
                        <li>
                        	您还没有已完成任务
                        </li>
                        {else}
                            {foreach from=$myTaskListFinished['list'] key=k item=taskInstObj}
                            {if empty($taskInstObj.task_tpl)}{continue}{/if}
						<li>
							<a href="{$taskInstObj.task_tpl.task_url}&task_id={$taskTplObj.task_id}&share_code={$shareCode}">
								<div class="task_img">
									<img data-original="{$taskInstObj.task_tpl.surface_url}" coolieignore src="../../../../../resource/xahoo3.0/images/integral/bg.png"/>
								</div>
								<div class="fl task-info task-over">
									<h3>{$taskInstObj.task_tpl.task_name}</h3>
									<p class="active">
										<i class="iconfont icon-money"></i>
										{$taskInstObj._reward_desc}
										<span>点击：{$taskInstObj.view_count*1}次</span>
									</p>
								</div>
							</a>
						</li>
                            {/foreach}
                        {/if}
					</ul>
				</li>
	        </ul>
	    </div>
	</section>

<script coolie src="../../../../../resource/xahoo3.0/js/lib/coolie/coolie.min.js" data-config="../../conf/coolie-config.js" data-main="../main/list_main.js"></script>
<script>
	var url = '{yii_createurl c=lizhuan a=AjaxGetTaskTplList accounts_id=$accounts_id}';
</script>