<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:26:48
         compiled from "/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/common/header_nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:145429112591b3658ef7aa8-98700284%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9058333f90a1c58fe63836b076ca94a8db349503' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/common/header_nav.tpl',
      1 => 1474163338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145429112591b3658ef7aa8-98700284',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'resourcePath' => 0,
    'loginUser' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b3658efd603_53077422',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b3658efd603_53077422')) {function content_591b3658efd603_53077422($_smarty_tpl) {?><div id="navbar" class="navbar navbar-default">
         
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>
         

        <div class="navbar-container" id="navbar-container">
                <!-- #section:basics/sidebar.mobile.toggle -->
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                        <span class="sr-only">Toggle sidebar</span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>
                </button>

                <!-- /section:basics/sidebar.mobile.toggle -->
                <div class="navbar-header pull-left">
                        <!-- #section:basics/navbar.layout.brand -->
                        <a href="#" class="navbar-brand">
                                <small>
                                        <i class="fa fa-leaf"></i>
                                        房乎<span class="hidden-xs">管理后台</span>
                                </small>
                        </a>

                        <!-- /section:basics/navbar.layout.brand -->

                        <!-- #section:basics/navbar.toggle -->

                        <!-- /section:basics/navbar.toggle -->
                </div>

                <!-- #section:basics/navbar.dropdown -->
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                        <ul class="nav ace-nav">
                                <li class="light-blue">
                                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                                <img class="nav-user-photo" src="<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/avatars/user.jpg" alt="Jason's Photo" />
                                                <span class="user-info">
                                                        <small>欢迎,</small>
                                                        <?php echo $_smarty_tpl->tpl_vars['loginUser']->value;?>

                                                </span>

                                                <i class="ace-icon fa fa-caret-down"></i>
                                        </a>

                                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                                <!--  
                                                <li>
                                                    <a href="#">
                                                        <i class="ace-icon fa fa-cog"></i>
                                                        Settings
                                                    </a>
                                                </li>
                
                                                <li>
                                                    <a href="#">
                                                        <i class="ace-icon fa fa-user"></i>
                                                        Profile
                                                    </a>
                                                </li>
                                                
                                                <li class="divider"></li>
                                                -->
                                                <?php if ($_smarty_tpl->tpl_vars['loginUser']->value=='Guest') {?>
                                                    <li>
                                                            <a href="fanghuadmin.php?r=site/login">
                                                                    <i class="ace-icon fa fa-power-off"></i>
                                                                    登录系统
                                                            </a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li>
                                                            <a href="fanghuadmin.php?r=AdminUser/UpdatePassword">
                                                                    <i class="ace-icon fa fa-user"></i>
                                                                    修改密码
                                                            </a>
                                                    </li>
                                                    <li>
                                                            <a href="fanghuadmin.php?r=site/logout">
                                                                    <i class="ace-icon fa fa-power-off"></i>
                                                                    退出登录
                                                            </a>
                                                    </li>
                                                <?php }?>
                                        </ul>
                                </li>

                                <!-- /section:basics/navbar.user_menu -->
                        </ul>
                </div>

                <!-- /section:basics/navbar.dropdown -->
        </div><!-- /.navbar-container -->
</div><?php }} ?>
