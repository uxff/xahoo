<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:02:48
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/lizhuan_footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1498818163591b30b8e93f25-03788409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ebaf6ca1284c663275b10fe6b0147b986335223' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/lizhuan_footer.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1498818163591b30b8e93f25-03788409',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gShowFooter' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30b8e965b4_14266164',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30b8e965b4_14266164')) {function content_591b30b8e965b4_14266164($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><?php if ($_smarty_tpl->tpl_vars['gShowFooter']->value) {?>
		<footer class="index-footer">
			<nav class="footer-nav">
				<ul>
					<li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe602;</i>首页</a></li>
					<li class="active"><a href="<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe606;</i>立赚</a></li>
					<li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe610;</i>我的</a></li>
				</ul>
			</nav>
		</footer>
<?php }?><?php }} ?>
