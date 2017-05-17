<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 22:50:30
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/footer_tracking.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1235331429591c63361c6876-25141065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a2a00982555bad5ab19d609d003df27cd33bb62' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/common/footer_tracking.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1235331429591c63361c6876-25141065',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baiduTrackingKey' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591c63361c7bd0_91112429',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591c63361c7bd0_91112429')) {function content_591c63361c7bd0_91112429($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['baiduTrackingKey']->value) {?>
<!-- bdstat -->

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?30d22a8f86efc69cfad3e4eb6b9174a7";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

<?php }?>

<!--seo -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?80a5c87f0e9542d2e5696f22048e730f";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>
<?php }} ?>
