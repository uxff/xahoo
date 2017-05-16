<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:02:48
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/lizhuan/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:404730808591b30b8e83937-34773864%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91641aa2b0b536a80084dfe23655f78bb71329e9' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/lizhuan/index.tpl',
      1 => 1477228506,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '404730808591b30b8e83937-34773864',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'taskTplList' => 0,
    'taskTplObj' => 0,
    'accounts_id' => 0,
    'isGuest' => 0,
    'myTaskListFinished' => 0,
    'taskInstObj' => 0,
    'shareCode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30b8e920b0_36834295',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30b8e920b0_36834295')) {function content_591b30b8e920b0_36834295($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/list.css" />
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
                        <?php  $_smarty_tpl->tpl_vars['taskTplObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['taskTplObj']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['taskTplList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['taskTplObj']->key => $_smarty_tpl->tpl_vars['taskTplObj']->value) {
$_smarty_tpl->tpl_vars['taskTplObj']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['taskTplObj']->key;
?>
						<li>
							<a href="<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'joinTask','taskTplId'=>$_smarty_tpl->tpl_vars['taskTplObj']->value['task_id'],'accounts_id'=>$_smarty_tpl->tpl_vars['accounts_id']->value),$_smarty_tpl);?>
">
								<div class="task_img">
									<img data-original="<?php echo $_smarty_tpl->tpl_vars['taskTplObj']->value['surface_url'];?>
" coolieignore src="../../../../../resource/fanghu2.0/images/integral/bg.png"/>
								</div>
								<div class="fl task-info">
									<h3><?php echo $_smarty_tpl->tpl_vars['taskTplObj']->value['task_name'];?>
</h3>
									<p class="active"><i class="iconfont icon-money"></i><?php echo $_smarty_tpl->tpl_vars['taskTplObj']->value['_reward_desc'];?>
&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['taskTplObj']->value['_reward_desc2'];?>
</p>
								</div>
							</a>
							<div class="fr task-btnbox">
								<a class="sm-btn" href="<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'joinTask','taskTplId'=>$_smarty_tpl->tpl_vars['taskTplObj']->value['task_id'],'accounts_id'=>$_smarty_tpl->tpl_vars['accounts_id']->value),$_smarty_tpl);?>
">我要参与</a>
							</div>
						</li>
                        <?php } ?>
					</ul>
	        	</li>
	            <li class="list-tab" name="completed-tasks">
	            	<ul>
                        <!--已完成任务-->
                        <?php if ($_smarty_tpl->tpl_vars['isGuest']->value) {?>
                        <li>
                        	请登录后查看我的已完成任务
                        </li>
                        <?php } elseif (empty($_smarty_tpl->tpl_vars['myTaskListFinished']->value['list'])) {?>
                        <li>
                        	您还没有已完成任务
                        </li>
                        <?php } else { ?>
                            <?php  $_smarty_tpl->tpl_vars['taskInstObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['taskInstObj']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['myTaskListFinished']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['taskInstObj']->key => $_smarty_tpl->tpl_vars['taskInstObj']->value) {
$_smarty_tpl->tpl_vars['taskInstObj']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['taskInstObj']->key;
?>
                            <?php if (empty($_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl'])) {?><?php continue 1?><?php }?>
						<li>
							<a href="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_url'];?>
&task_id=<?php echo $_smarty_tpl->tpl_vars['taskTplObj']->value['task_id'];?>
&share_code=<?php echo $_smarty_tpl->tpl_vars['shareCode']->value;?>
">
								<div class="task_img">
									<img data-original="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['surface_url'];?>
" coolieignore src="../../../../../resource/fanghu2.0/images/integral/bg.png"/>
								</div>
								<div class="fl task-info task-over">
									<h3><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_name'];?>
</h3>
									<p class="active">
										<i class="iconfont icon-money"></i>
										<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['_reward_desc'];?>

										<span>点击：<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['view_count']*1;?>
次</span>
									</p>
								</div>
							</a>
						</li>
                            <?php } ?>
                        <?php }?>
					</ul>
				</li>
	        </ul>
	    </div>
	</section>

<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js" data-config="../../conf/coolie-config.js" data-main="../main/list_main.js"></script>
<script>
	var url = '<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'AjaxGetTaskTplList','accounts_id'=>$_smarty_tpl->tpl_vars['accounts_id']->value),$_smarty_tpl);?>
';
</script><?php }} ?>
