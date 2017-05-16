<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:03:09
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/layouts/user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1033629874591b30cda961d4-37740801%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72f1b359cc1dba6dfece6f2da0068b7493f26cb0' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/layouts/user.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1033629874591b30cda961d4-37740801',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'NACHO_JS_TPL_FILE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30cdab1490_72596405',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30cdab1490_72596405')) {function content_591b30cdab1490_72596405($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <?php echo $_smarty_tpl->getSubTemplate ("../common/html_head_index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <body>
        <!-- #section:basics/content.page_header -->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/header_v2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_header -->

        <!-- #section:basics/content.page_content_area -->
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['NACHO_PAGE_TPL_FILE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_content_area -->

        <!-- #section:basics/content.page_footer 底部不一样，暂时先不统一成一个文件-->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/footer_v2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_footer -->


        <?php if (!empty($_smarty_tpl->tpl_vars['NACHO_JS_TPL_FILE']->value)) {?>
            <!--NACHO_JS_TPL_FILE here not need to show -->
            
        <?php }?>

        <!-- #section:basics/footer.tracking_js -->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/footer_tracking.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- #section:basics/footer.tracking_js -->
    </body>
</html><?php }} ?>
