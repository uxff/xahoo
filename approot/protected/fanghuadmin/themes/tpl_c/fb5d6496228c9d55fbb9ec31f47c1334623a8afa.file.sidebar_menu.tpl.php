<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:26:48
         compiled from "/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/common/sidebar_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1185957748591b3658efe8a2-26065554%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb5d6496228c9d55fbb9ec31f47c1334623a8afa' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/common/sidebar_menu.tpl',
      1 => 1468759014,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1185957748591b3658efe8a2-26065554',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menus' => 0,
    'item' => 0,
    'submenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b3658f0c164_76603791',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b3658f0c164_76603791')) {function content_591b3658f0c164_76603791($_smarty_tpl) {?><div id="sidebar" class="sidebar responsive">
        
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'fixed')
                } catch (e) {
                }
            </script>
         

        <ul class="nav nav-list">
                <!--
                <li class="">
                        <a href="#">
                                <i class="menu-icon fa fa-tachometer"></i>
                                <span class="menu-text"> 管理菜单 </span>
                        </a>

                        <b class="arrow"></b>
                </li>
                -->
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                    <li class="<?php echo $_smarty_tpl->tpl_vars['item']->value['active'];?>
">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['submenu'])) {?>class="dropdown-toggle"<?php }?>>
                                    <i class="menu-icon fa <?php echo $_smarty_tpl->tpl_vars['item']->value['menu_icon'];?>
"></i>
                                    <span class="menu-text"> <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
 </span>

                                    <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['submenu'])) {?><b class="arrow fa fa-angle-down"></b><?php }?>
                            </a>

                            <b class="arrow"></b>
                            <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['submenu'])) {?>
                                <ul class="submenu">
                                        <?php  $_smarty_tpl->tpl_vars['submenu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['submenu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['submenu']->key => $_smarty_tpl->tpl_vars['submenu']->value) {
$_smarty_tpl->tpl_vars['submenu']->_loop = true;
?>
                                            <li class="<?php echo $_smarty_tpl->tpl_vars['submenu']->value['active'];?>
">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['submenu']->value['url'];?>
">
                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                            <?php echo $_smarty_tpl->tpl_vars['submenu']->value['name'];?>

                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        <?php } ?>

                                </ul>
                            <?php }?>
                    </li>
                    <!--
                    <li class="">
                            <a href="widgets.html">
                                    <i class="menu-icon fa fa-list-alt"></i>
                                    <span class="menu-text"> Widgets </span>
                            </a>

                            <b class="arrow"></b>
                    </li>
                    -->
                <?php } ?>
        </ul><!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
        
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'collapsed')
                } catch (e) {
                }
            </script>
         
</div><?php }} ?>
