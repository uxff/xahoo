<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:03:09
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/header_v2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2056680378591b30cdab79f5-52500585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd2cf820cf32853abe2c1bb2310dcdd6f233d8b8' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/header_v2.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2056680378591b30cdab79f5-52500585',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gShowHeader' => 0,
    'pageTitle' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30cdaba5a4_53770892',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30cdaba5a4_53770892')) {function content_591b30cdaba5a4_53770892($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><?php if ($_smarty_tpl->tpl_vars['gShowHeader']->value) {?>
<div class="container">
    <header class="header">
		<a href="javascript:history.back(-1);" class="fl"><i class="iconfont">&#xe604;</i></a>
		<a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'index'),$_smarty_tpl);?>
" class="fr"><i class="iconfont icon-fx">&#xe602;</i></a> 
		<?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>

	</header>
<?php }?><?php }} ?>
