<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:03:09
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/user/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:691094363591b30cdabbb58-56515966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5a33a9b0a3e51ca5b0b6dbec67061e0d4ace380' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/user/login.tpl',
      1 => 1474163342,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '691094363591b30cdabbb58-56515966',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'return_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30cdabf0d1_72623278',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30cdabf0d1_72623278')) {function content_591b30cdabf0d1_72623278($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/reg.css" />
<!--/coolie-->
<section class="tab">
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'login','return_url'=>$_smarty_tpl->tpl_vars['return_url']->value),$_smarty_tpl);?>
" class="on active">登录</a>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'register','return_url'=>$_smarty_tpl->tpl_vars['return_url']->value),$_smarty_tpl);?>
" class="off">注册</a>
</section>
<input type="hidden" name="return_url" value="<?php echo $_smarty_tpl->tpl_vars['return_url']->value;?>
" id="return_url" />
<section class="form-box reg-box">
        <ul>
                <li>
                        <span>手机号码</span>
                        <input type="tel" name="username" class="form-input" placeholder="请输入手机号码" id="phone" />
                </li>
                <li>
                        <span>登录密码</span>
                        <input type="password" name="password" class="form-input" placeholder="请输入密码" id="password" />
                </li>
        </ul>
        <input type="hidden" id="postUri" value="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'loginForm'),$_smarty_tpl);?>
"></input>
</section>
<section class="btn-link">
        <button class="btn lot-btn">登录</button>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'forgetMobile','return_url'=>$_smarty_tpl->tpl_vars['return_url']->value),$_smarty_tpl);?>
">忘记密码？</a>
</section>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
    data-config="../../conf/coolie-config.js"
    data-main="../main/login_main.js"></script>
<?php }} ?>
