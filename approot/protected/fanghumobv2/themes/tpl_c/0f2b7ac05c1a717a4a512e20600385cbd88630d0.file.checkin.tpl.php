<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:02:54
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/my/checkin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:757837040591b30be23feb9-71337744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f2b7ac05c1a717a4a512e20600385cbd88630d0' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/my/checkin.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '757837040591b30be23feb9-71337744',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'totalInfo' => 0,
    'csrfToken' => 0,
    'isCheckedToday' => 0,
    'theContinuedNum' => 0,
    'arrFutrueDays' => 0,
    'checkOnce' => 0,
    'hotArtModels' => 0,
    'hotArtModel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30be8c94b2_71454712',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30be8c94b2_71454712')) {function content_591b30be8c94b2_71454712($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?>
<!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/edit.css" />
<!--/coolie-->
<section class="task-list">
    <div class="check">
        <div class="check_jf">我的积分<br/><span><?php echo $_smarty_tpl->tpl_vars['totalInfo']->value['points_total']*1;?>
</span></div>
        <div class="check_box">
            <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'submitcheckin','token'=>$_smarty_tpl->tpl_vars['csrfToken']->value),$_smarty_tpl);?>
">
            <span class="check_tl"><?php if ($_smarty_tpl->tpl_vars['isCheckedToday']->value) {?>已签到<?php } else { ?>签 到<?php }?></span><br/><span class="hr"></span>
            </a>
            <br/>
            <span class="check_des">连续<?php echo $_smarty_tpl->tpl_vars['theContinuedNum']->value*1;?>
天</span>
        </div>
        <div class="day_list">
            <?php  $_smarty_tpl->tpl_vars['checkOnce'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['checkOnce']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arrFutrueDays']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['checkOnce']->key => $_smarty_tpl->tpl_vars['checkOnce']->value) {
$_smarty_tpl->tpl_vars['checkOnce']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['checkOnce']->key;
?>
            <div class="day_item <?php echo $_smarty_tpl->tpl_vars['checkOnce']->value['css'];?>
">
                <span class="day_bot"></span><i class="day_time"><?php echo $_smarty_tpl->tpl_vars['checkOnce']->value['dayShort'];?>
</i>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="index-list">
        <h2>热门推荐</h2>
        <ul>
            <?php  $_smarty_tpl->tpl_vars['hotArtModel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotArtModel']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hotArtModels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hotArtModel']->key => $_smarty_tpl->tpl_vars['hotArtModel']->value) {
$_smarty_tpl->tpl_vars['hotArtModel']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['hotArtModel']->key;
?>
            <li>
                <a href="<?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['url'];?>
" target="_blank">
                <img src="<?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['surface_url'];?>
" coolieignore/>
                </a>
                <p class="fl"><?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['title'];?>
</p>
                <span class="fr"><font><?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['tips'];?>
</font></span>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php }} ?>
