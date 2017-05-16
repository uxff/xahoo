<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:25:39
         compiled from "/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/site/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1284466920591b3613119677-87624942%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ffd18092609f279d85b1a47a6f02766cad412cfd' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/site/login.tpl',
      1 => 1470455978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1284466920591b3613119677-87624942',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'resourcePath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b361311c616_36908836',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b361311c616_36908836')) {function content_591b361311c616_36908836($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登录</title>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/css/login/fh_login.css" />
</head>
<body class="login-layout light-login">
    <!--new div start-->
    <div class="login_box">
        <div class="login_top">
            <a href="javascript:;"><img src="<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/images/login/login_logo_fh.png" alt=""></a>
            <div class="login_title">后台管理系统</div>
        </div>
        <div class="login_cont" style="background:url(<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/images/login/login_bg_fh.jpg) no-repeat center">
            <div class="main">
                <div class="login_form">
                    <form id="login-form" action="fanghuadmin.php?r=site/login" method="post">
                        <h3>用户登录</h3>
                        <div>
                            <input type="text" name="LoginForm[username]" id="LoginForm_username" placeholder="用户名" tabindex="1"/>
                        </div>
                        <div>
                            <input type="password" name="LoginForm[password]" id="LoginForm_password"  placeholder="密码" tabindex="2"/>
                        </div>
                        <div>
                            <input type="submit" value="登 录" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="login_bottom">
            <p>Copyright ©2016xqshijie.com. All Rights Reserved. 天津活力营销顾问有限公司 版权所有 津ICP备16004915号-3</p>
        </div>
    </div>	
</body>
</html>
<?php }} ?>
