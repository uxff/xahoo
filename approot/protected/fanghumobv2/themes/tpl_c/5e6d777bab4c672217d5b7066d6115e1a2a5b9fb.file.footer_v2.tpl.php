<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:03:09
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/footer_v2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1617686181591b30cdac08b5-93936377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e6d777bab4c672217d5b7066d6115e1a2a5b9fb' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/footer_v2.tpl',
      1 => 1470455980,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1617686181591b30cdac08b5-93936377',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gShowFooter' => 0,
    'gIsGuest' => 0,
    'member_nickname' => 0,
    'logout_return_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30cdac9740_46938822',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30cdac9740_46938822')) {function content_591b30cdac9740_46938822($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
if (!is_callable('smarty_modifier_date_format')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/modifier.date_format.php';
?><?php if ($_smarty_tpl->tpl_vars['gShowFooter']->value) {?>
		<footer class="footer">
            <?php if ($_smarty_tpl->tpl_vars['gIsGuest']->value) {?>
			<ul>
				<li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'login'),$_smarty_tpl);?>
">登录</a></li>
				<li><a class="active" href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'register'),$_smarty_tpl);?>
">注册</a></li>
				<li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'aboutus'),$_smarty_tpl);?>
">关于我们</a></li>
			</ul>
            <?php } else { ?>
			<ul>
				<li><span style="color:#333333;"><a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'index'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['member_nickname']->value;?>
</a></span></li> 
				<li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'logout','logout_return_url'=>$_smarty_tpl->tpl_vars['logout_return_url']->value),$_smarty_tpl);?>
">退出登录</a></li>
				<li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'aboutus'),$_smarty_tpl);?>
">关于我们</a></li>
			</ul>
            <?php }?>
			<p>copyright@2014-<?php echo smarty_modifier_date_format(time(),'%Y');?>
 津ICP备16004915号-3</p>
		</footer>
</div>
<?php }?><?php }} ?>
