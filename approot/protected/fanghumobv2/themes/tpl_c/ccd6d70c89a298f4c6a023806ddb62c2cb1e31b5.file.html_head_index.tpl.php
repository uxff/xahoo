<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 22:50:30
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/html_head_index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1765685037591c63361b17e4-18310170%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ccd6d70c89a298f4c6a023806ddb62c2cb1e31b5' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/html_head_index.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1765685037591c63361b17e4-18310170',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageTitle' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591c63361b3fc0_26850488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591c63361b3fc0_26850488')) {function content_591c63361b3fc0_26850488($_smarty_tpl) {?><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<meta name="format-detection" content="telephone=no" />
    <title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
 - 房乎</title>
    <!--coolie-->
    <link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/base.css" />
    <!--/coolie-->
    
    <script>
    (function (doc, win) {
        var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth>750){
                    	clientWidth = 750;
                    }
                    docEl.style.fontSize = 24 * (clientWidth / 640) + 'px';
                };

        // Abort if browser does not support addEventListener
        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
    </script>
    
</head>
<?php }} ?>
