<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:03:20
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/site/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2035355588591b30d8c64774-07877560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62c7a947b9030d12804593e40cafd8bb2bbaaef2' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/site/index.tpl',
      1 => 1470455980,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2035355588591b30d8c64774-07877560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bannerModel' => 0,
    'picObj' => 0,
    'actPicsModel' => 0,
    'hotArtModels' => 0,
    'hotArtModel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30d8c745d8_52761139',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30d8c745d8_52761139')) {function content_591b30d8c745d8_52761139($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><!--coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/index.css" />
<!--/coolie-->
<header class="index-header">
<!--首页header特殊-->
</header>
<section class="banner" >
    <div class="swiper-container">
        <div class="swiper-wrapper" id="big_swiper">
        <?php if ($_smarty_tpl->tpl_vars['bannerModel']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['picObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['picObj']->_loop = false;
 $_smarty_tpl->tpl_vars['picsId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bannerModel']->value['pics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['picObj']->key => $_smarty_tpl->tpl_vars['picObj']->value) {
$_smarty_tpl->tpl_vars['picObj']->_loop = true;
 $_smarty_tpl->tpl_vars['picsId']->value = $_smarty_tpl->tpl_vars['picObj']->key;
?>
            <div class="swiper-slide index-banner">
            	<a href="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['picObj']->value['link_url'])===null||$tmp==='' ? 'javascript:;' : $tmp);?>
">
            		<img src="<?php echo $_smarty_tpl->tpl_vars['picObj']->value['file_path'];?>
" coolieignore/>	
            	</a>
            </div>
        <?php } ?>
        <?php } else { ?>
            <div class="swiper-slide index-banner">
            	<a href="/">
            		<img src="../../../../../resource/fanghu2.0/images/index/index_banner.jpg"/>	
            	</a>
            </div>
        <?php }?>
        </div>
        <!-- 如果需要分页器 -->
        <?php if (count($_smarty_tpl->tpl_vars['bannerModel']->value['pics'])) {?>
        <div class="swiper-pagination"></div>
        <?php }?>
        <input type="hidden" id="banner_pic_circle_sec" value="<?php echo $_smarty_tpl->tpl_vars['bannerModel']->value['circle_sec']*1000;?>
">
    </div>
</section>
<section class="index-nav">
    <ul>
        <li>
            <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'checkin'),$_smarty_tpl);?>
">
                <p>天天领积分</p>
                <span>百万积分任你领</span>
            </a>
        </li>
        <li>
            <a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'memberrights'),$_smarty_tpl);?>
" class="nav-qy">
                <p>会员权益说明</p>
                <span>会员权益积分机制</span>
            </a>
        </li>
    </ul>
</section>
<section class="sm-banner" >
    <div class="sm-swiper-container">
        <div class="swiper-wrapper sm-swiper-wrapper">
            <?php  $_smarty_tpl->tpl_vars['picObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['picObj']->_loop = false;
 $_smarty_tpl->tpl_vars['picsId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['actPicsModel']->value['pics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['picObj']->key => $_smarty_tpl->tpl_vars['picObj']->value) {
$_smarty_tpl->tpl_vars['picObj']->_loop = true;
 $_smarty_tpl->tpl_vars['picsId']->value = $_smarty_tpl->tpl_vars['picObj']->key;
?>
            <div class="swiper-slide sm-index-banner">
                <a href="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['picObj']->value['link_url'])===null||$tmp==='' ? 'javascript:;' : $tmp);?>
">
                	<img src="<?php echo $_smarty_tpl->tpl_vars['picObj']->value['file_path'];?>
" alt="" coolieignore/>
                </a>
            </div>
            <?php } ?>
        </div>
        <!-- 如果需要分页器 -->
        <div class="sm-pagination swiper-pagination"></div>
        <input type="hidden" id="art_pic_circle_sec" value="<?php echo $_smarty_tpl->tpl_vars['actPicsModel']->value['circle_sec']*1000;?>
">
    </div>
</section>
<section class="index-list">
    <h2>热门推荐</h2>
    <ul>
        <?php  $_smarty_tpl->tpl_vars['hotArtModel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hotArtModel']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['hotArtModels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hotArtModel']->key => $_smarty_tpl->tpl_vars['hotArtModel']->value) {
$_smarty_tpl->tpl_vars['hotArtModel']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['hotArtModel']->key;
?>
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['url'];?>
">
            	<img data-original="<?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['surface_url'];?>
" coolieignore src="../../../../../resource/fanghu2.0/images/integral/bg_big.png" />
            </a>
            <p class="fl"><?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['title'];?>
</p>
            <span class="fr"><font><?php echo $_smarty_tpl->tpl_vars['hotArtModel']->value['tips'];?>
</font></span>
        </li>
        <?php } ?>
    </ul>
</section>
<footer class="index-footer">
    <nav class="footer-nav">
        <ul>
            <li class="active"><a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe602;</i>首页</a></li>
            <li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe606;</i>立赚</a></li>
            <li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe610;</i>我的</a></li>
        </ul>
    </nav>
</footer>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"  data-config="../../conf/coolie-config.js"  data-main="../main/index_main.js"></script>
<?php }} ?>
