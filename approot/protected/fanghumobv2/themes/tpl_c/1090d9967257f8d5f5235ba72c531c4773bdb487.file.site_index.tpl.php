<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 22:50:30
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/layouts/site_index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1091287637591c633617c855-57578126%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1090d9967257f8d5f5235ba72c531c4773bdb487' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/layouts/site_index.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1091287637591c633617c855-57578126',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'NACHO_JS_TPL_FILE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591c63361aea40_94757981',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591c63361aea40_94757981')) {function content_591c63361aea40_94757981($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <?php echo $_smarty_tpl->getSubTemplate ("../common/html_head_index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <body>
        <!-- #section:basics/content.page_header -->
        
        <!-- /section:basics/content.page_header -->

        <!-- #section:basics/content.page_content_area -->
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['NACHO_PAGE_TPL_FILE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_content_area -->

        <!-- #section:basics/content.page_footer 底部不一样，暂时先不统一成一个文件-->
        
        <!-- /section:basics/content.page_footer -->


        <?php if (!empty($_smarty_tpl->tpl_vars['NACHO_JS_TPL_FILE']->value)) {?>
            <!--NACHO_JS_TPL_FILE here not need to show -->
            
        <?php }?>

        <!-- #section:basics/footer.tracking_js -->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/footer_tracking.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- #section:basics/footer.tracking_js -->
    </body>
</html><?php }} ?>
