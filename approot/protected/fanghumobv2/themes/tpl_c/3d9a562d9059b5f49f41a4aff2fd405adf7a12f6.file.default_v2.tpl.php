<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:02:59
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/layouts/default_v2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:892387079591b30c3b475a6-87341057%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d9a562d9059b5f49f41a4aff2fd405adf7a12f6' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/layouts/default_v2.tpl',
      1 => 1471058762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '892387079591b30c3b475a6-87341057',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'NACHO_JS_TPL_FILE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30c3b65632_66288718',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30c3b65632_66288718')) {function content_591b30c3b65632_66288718($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <?php echo $_smarty_tpl->getSubTemplate ("../common/html_head_index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <body>
        <!-- #section:basics/content.page_header -->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/header_v2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_header -->
                <!-- page specific plugin scripts -->
                <!--
                <script type="text/javascript">
                    var _baseUrl = "<?php echo smarty_function_yii_createurl(array('c'=>'"+controllerId+"','a'=>'"+actionId+"'),$_smarty_tpl);?>
";
                </script>
                
                <script type="text/javascript">
                        function gYiiCreateUrl(controllerId, actionId, paramsStr) {
                                
                                if (_baseUrl.indexOf("?") != -1) {
                                        returnUrl = (paramsStr == "" || paramsStr == undefined) ? _baseUrl : _baseUrl + "&" + paramsStr;
                                } else {
                                        returnUrl = (paramsStr == "" || paramsStr == undefined) ? _baseUrl : _baseUrl + "?" + paramsStr;
                                }
                                return returnUrl;
                        }
                </script>
                
                -->
        <!-- #section:basics/content.page_content_area -->
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['NACHO_PAGE_TPL_FILE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_content_area -->

        <!-- #section:basics/content.page_footer 底部不一样，暂时先不统一成一个文件-->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/footer_v2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/content.page_footer -->


        <?php if (!empty($_smarty_tpl->tpl_vars['NACHO_JS_TPL_FILE']->value)) {?>
            <!--NACHO_JS_TPL_FILE here not need to show -->
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['NACHO_JS_TPL_FILE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php }?>

        <!-- #section:basics/footer.tracking_js -->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/footer_tracking.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- #section:basics/footer.tracking_js -->
    </body>
</html><?php }} ?>
