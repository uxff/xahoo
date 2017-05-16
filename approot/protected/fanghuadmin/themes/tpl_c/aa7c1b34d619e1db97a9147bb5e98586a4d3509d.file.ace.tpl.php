<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:26:48
         compiled from "/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/layouts/ace.tpl" */ ?>
<?php /*%%SmartyHeaderCode:266836892591b3658ecbdd2-02498558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa7c1b34d619e1db97a9147bb5e98586a4d3509d' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghuadmin/themes/tpl/layouts/ace.tpl',
      1 => 1470461370,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '266836892591b3658ecbdd2-02498558',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'resourcePath' => 0,
    'NACHO_JS_TPL_FILE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b3658eed594_34913574',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b3658eed594_34913574')) {function content_591b3658eed594_34913574($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/html_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- basic scripts -->
<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/js/jquery.min.js'>" + "<" + "/script>");
</script>
<script type="text/javascript">
    var zhff = {
    "uploadImageUri" : "/fanghuadmin.php?r=upload/post",
    "uploadFileUri" : "/ucenterpc.php?r=account/postFile",
    }
</script>
<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<body class="no-skin">
    <!-- #section:basics/navbar.layout -->
    <?php echo $_smarty_tpl->getSubTemplate ("../common/header_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container">
         
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>
        

        <!-- #section:basics/sidebar -->
        <?php echo $_smarty_tpl->getSubTemplate ("../common/sidebar_menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <!-- /section:basics/sidebar -->

        <div class="main-content">
            <!-- #section:basics/content.breadcrumbs -->
            <?php echo $_smarty_tpl->getSubTemplate ("../common/breadcrumbs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">
                <!-- #section:settings.box -->
                <!-- /section:settings.box -->
                <!-- #section:basics/content.page_content_area -->
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['NACHO_PAGE_TPL_FILE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                <!-- /section:basics/content.page_content_area -->
            </div>
        </div>

        <div class="footer">
            <!-- #section:basics/footer -->
            <?php echo $_smarty_tpl->getSubTemplate ("../common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /section:basics/footer -->
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>

    </div>

    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) {
            document.write("<script src='<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        }
    </script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/js/bootstrap.min.js"></script>

    <!-- ace scripts -->
    <script src="<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/js/ace-elements.min.js"></script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['resourcePath']->value;?>
/js/ace.min.js"></script>

    <!-- page specific plugin scripts -->
    <?php if (!empty($_smarty_tpl->tpl_vars['NACHO_JS_TPL_FILE']->value)) {?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['NACHO_JS_TPL_FILE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php }?>
</body>
</html>
<?php }} ?>
