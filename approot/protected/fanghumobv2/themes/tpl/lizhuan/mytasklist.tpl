<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/list.css" />
<!--/coolie-->
	<section class="task-list" style="padding-top:0;">
		<div class="tab">
	    	<a href="javascript:;" class="off">最新任务</a>
	        <a href="javascript:;" class="on">已完成任务</a>
	    </div>
	    <div class="content">
	    	<ul>
	            <li>
	            	<ul>
                        {foreach from=$taskInstList key=k item=taskInstObj}
						<li>
							<a href="{$taskInstObj.task_tpl.task_url}">
								<img data-original="{$taskInstObj.task_tpl.surface_url}" coolieignore/>
								<div class="fl task-info task-over">
									<h3>{$taskInstObj.task_tpl.task_name}</h3>
									<p class="active"><i class="iconfont icon-money"></i>{$taskInstObj._reward_desc}<span>点击：10次</span></p>
								</div>
							</a>
						</li>
                        {/foreach}
					</ul>
				</li>
	        </ul>
	    </div>
	</section>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js" data-config="../../conf/coolie-config.js" data-main="../main/list_main.js"></script>
