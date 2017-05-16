<?php /* Smarty version Smarty-3.1.17, created on 2017-05-16 23:02:19
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/my/task.tpl" */ ?>
<?php /*%%SmartyHeaderCode:307418339591b147b446c29-86014046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f19fe68707bf58bbfb9c3d7262daddab70313cb' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/my/task.tpl',
      1 => 1471058762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '307418339591b147b446c29-86014046',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'myTaskListAll' => 0,
    'taskInstObj' => 0,
    'shareCode' => 0,
    'myTaskListAchieved' => 0,
    'myTaskListFinished' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b147b45edf9_79601043',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b147b45edf9_79601043')) {function content_591b147b45edf9_79601043($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/list.css" />
    <section class="task-list">
        <?php if (!empty($_smarty_tpl->tpl_vars['myTaskListAll']->value['list'])) {?>
        <div class="tab my-list-tab">
            <a href="javascript:;" class="on">全部</a>
            <a href="javascript:;" class="off center">进行中</a>
            <a href="javascript:;" class="off">已完成</a>
        </div>
        <?php }?>
        <div class="content">
            <?php if (empty($_smarty_tpl->tpl_vars['myTaskListAll']->value['list'])) {?>
            <ul style="display:none">
            <?php } else { ?>
            <ul>
            <?php }?>
                <li class="list-tab" name="all-tasks" style="display:block;">
                    <ul>
                    <?php if (empty($_smarty_tpl->tpl_vars['myTaskListAll']->value['list'])) {?>
                        <li>
                            <div class="no_task">
                                <h3>您还没有任务</h3>
                                <p>完成任务可以赚得积分哟~~</p>
                                <a href="javascript:;" class="btn">马上去领任务</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <?php  $_smarty_tpl->tpl_vars['taskInstObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['taskInstObj']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['myTaskListAll']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['taskInstObj']->key => $_smarty_tpl->tpl_vars['taskInstObj']->value) {
$_smarty_tpl->tpl_vars['taskInstObj']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['taskInstObj']->key;
?>
                        <?php if (empty($_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl'])) {?><?php continue 1?><?php }?>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_url'];?>
&task_id=<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_id'];?>
&share_code=<?php echo $_smarty_tpl->tpl_vars['shareCode']->value;?>
">
                                <div class="task_img">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['surface_url'];?>
" coolieignore/>
                                </div>
                                <div class="fl task-info">
                                    <h3><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_name'];?>
</h3>
                                    <p><i class="iconfont icon-money"></i><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['_reward_desc'];?>
</p>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    <?php }?>
                    </ul>
                </li>
                <!--进行中任务-->
                <li class="list-tab" name="pending-tasks">
                    <ul>
                    <?php if (empty($_smarty_tpl->tpl_vars['myTaskListAchieved']->value['list'])) {?>
                        <li>
                            您还没有进行中任务
                        </li>
                    <?php } else { ?>
                        <?php  $_smarty_tpl->tpl_vars['taskInstObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['taskInstObj']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['myTaskListAchieved']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['taskInstObj']->key => $_smarty_tpl->tpl_vars['taskInstObj']->value) {
$_smarty_tpl->tpl_vars['taskInstObj']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['taskInstObj']->key;
?>
                        <?php if (empty($_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl'])) {?><?php continue 1?><?php }?>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_url'];?>
&task_id=<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_id'];?>
&share_code=<?php echo $_smarty_tpl->tpl_vars['shareCode']->value;?>
">
                                <div class="task_img">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['surface_url'];?>
" coolieignore/>
                                </div>
                                <div class="fl task-info">
                                    <h3><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_name'];?>
</h3>
                                    <p class="active"><i class="iconfont icon-money"></i><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['_reward_desc'];?>
<span>点击：<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['view_count']*1;?>
次</span></p>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    <?php }?>
                    </ul>
                </li>
                <!--已完成任务-->
                <li class="list-tab" name="completed-tasks">
                    <ul>
                    <?php if (empty($_smarty_tpl->tpl_vars['myTaskListFinished']->value['list'])) {?>
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
&task_id=<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_id'];?>
&share_code=<?php echo $_smarty_tpl->tpl_vars['shareCode']->value;?>
">
                                <div class="task_img">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['surface_url'];?>
" coolieignore/>
                                </div>
                                <div class="fl task-info task-over">
                                    <h3><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['task_tpl']['task_name'];?>
</h3>
                                    <p class="active"><i class="iconfont icon-money"></i><?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['_reward_desc'];?>
<span>点击：<?php echo $_smarty_tpl->tpl_vars['taskInstObj']->value['view_count']*1;?>
次</span></p>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    <?php }?>
                    </ul>
                </li>
            </ul>
            <?php if (empty($_smarty_tpl->tpl_vars['myTaskListAll']->value['list'])) {?>
            <div class="no_task">
                <h3>您还没有任务</h3>
                <p>完成任务可以赚得积分哟~~</p>
                <a href="<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'index'),$_smarty_tpl);?>
" class="btn">马上去领任务</a>
            </div>
            <?php }?>
        </div>
    </section>
    <script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
        data-config="../../conf/coolie-config.js"
        data-main="../main/list_main.js"></script>
<script>
var url = '<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'ajaxTask'),$_smarty_tpl);?>
';
</script><?php }} ?>
