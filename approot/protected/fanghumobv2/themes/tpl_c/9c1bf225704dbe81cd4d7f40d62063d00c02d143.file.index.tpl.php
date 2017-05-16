<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:02:59
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/points/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2126828133591b30c3b6e870-67809451%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c1bf225704dbe81cd4d7f40d62063d00c02d143' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/points/index.tpl',
      1 => 1468759040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2126828133591b30c3b6e870-67809451',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'totalInfo' => 0,
    'pointsHistory' => 0,
    'item' => 0,
    'actPicsModel' => 0,
    'picObj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30c3b7ab05_38189319',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30c3b7ab05_38189319')) {function content_591b30c3b7ab05_38189319($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?>		<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/integral.css" />
		<div class="container">		
			<section class="task-list">
				<div class="integral_top">
					<div class="integral_now">
						<div class="integral_now_title">当前积分</div>
						<div class="integral_now_info"><?php echo $_smarty_tpl->tpl_vars['totalInfo']->value['points_total'];?>
</div>
					</div>
					<a href="<?php echo smarty_function_yii_createurl(array('c'=>'myPoints','a'=>'pointsrule'),$_smarty_tpl);?>
" class="integral_get">如何获取积分</a>
				</div>
				<div class="integral_con">
					<div class="integral_tl">积分明细<a href="<?php echo smarty_function_yii_createurl(array('c'=>'myPoints','a'=>'pointshistory'),$_smarty_tpl);?>
" class="integral_more">查看全部<span class="iconfont r_bot">&#xe600;</span></a></div>
					<?php if (!empty($_smarty_tpl->tpl_vars['pointsHistory']->value)) {?>
						<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pointsHistory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
							<a href="javasrcipt:;" class="integral_item">
								<div class="fl">
									<p class="ig_tl"><?php echo $_smarty_tpl->tpl_vars['item']->value['remark'];?>
</p>
									<p class="ig_time"><?php echo $_smarty_tpl->tpl_vars['item']->value['last_modified'];?>
</p>
								</div>
								<div class="fr"><span class="<?php echo $_smarty_tpl->tpl_vars['item']->value['class'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['points'];?>
</span></div>
							</a>
						<?php } ?>
					<?php }?>
					
				</div>
				<?php if (!empty($_smarty_tpl->tpl_vars['actPicsModel']->value)) {?>
				<h3 class="exchange_tl">积分活动</h3>
				<div class="sm_banner">
					<div class="sm-swiper-container">
					    <div class="swiper-wrapper sm-swiper-wrapper">
							<?php  $_smarty_tpl->tpl_vars['picObj'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['picObj']->_loop = false;
 $_smarty_tpl->tpl_vars['picsId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['actPicsModel']->value['pics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['picObj']->key => $_smarty_tpl->tpl_vars['picObj']->value) {
$_smarty_tpl->tpl_vars['picObj']->_loop = true;
 $_smarty_tpl->tpl_vars['picsId']->value = $_smarty_tpl->tpl_vars['picObj']->key;
?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['picObj']->value['link_url'];?>
"class="swiper-slide">
								<img src="<?php echo $_smarty_tpl->tpl_vars['picObj']->value['file_path'];?>
" alt="" coolieignore/>
								</a>
							<?php } ?>
					    </div>
					    <!-- 如果需要分页器 -->
					    <div class="sm-pagination"></div>
                        <input type="hidden" id="art_pic_circle_sec" value="<?php echo $_smarty_tpl->tpl_vars['actPicsModel']->value['circle_sec']*1000;?>
">
					</div>
				</div>
				<?php }?>
			</section>
		</div>
		<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
			data-config="../../conf/coolie-config.js"
			data-main="../main/index_main.js"></script>
		<?php }} ?>
