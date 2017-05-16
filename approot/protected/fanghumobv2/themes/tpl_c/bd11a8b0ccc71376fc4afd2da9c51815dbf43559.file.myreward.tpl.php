<?php /* Smarty version Smarty-3.1.17, created on 2017-05-16 23:02:22
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/myhaibao/myreward.tpl" */ ?>
<?php /*%%SmartyHeaderCode:722912087591b147e41ccd0-08327503%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd11a8b0ccc71376fc4afd2da9c51815dbf43559' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/myhaibao/myreward.tpl',
      1 => 1474163342,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '722912087591b147e41ccd0-08327503',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'last_cash' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b147e426ac4_20058548',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b147e426ac4_20058548')) {function content_591b147e426ac4_20058548($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/myreward.css" />
<div class="myreward-money">
	<span class="ye">余额</span>
	<span class="money">
		￥<?php echo number_format($_smarty_tpl->tpl_vars['last_cash']->value,2);?>

	</span>
	<span class="name"><?php echo $_smarty_tpl->tpl_vars['data']->value['wx_nickname'];?>
</span>
	<ul class="nav">
		<li>
			<span class="num">
				<?php echo $_smarty_tpl->tpl_vars['data']->value['fans_total']*1;?>
人
			</span>
			<span class="gray">总粉丝</span></li>
			<li><a class="line"></a>
		</li>
		<li>
			<span class="num">
				<?php echo $_smarty_tpl->tpl_vars['data']->value['fans_first']*1;?>
人
			</span>
			<span class="gray">直接粉丝</span>
		</li>
		<li><a class="line"></a></li>
		<li>
			<span class="num">
				<?php echo $_smarty_tpl->tpl_vars['data']->value['fans_second']*1;?>
人
			</span>
			<span class="gray">间接粉丝</span>
		</li>
	</ul>
</div>
<ul class="myreward-list">
	<li>
		<a href="<?php echo smarty_function_yii_createurl(array('c'=>'MyHaibao','a'=>'rewardrecord'),$_smarty_tpl);?>
">
			<span class="fl">
				<i class="iconfont icon-zuanshi"></i>奖励记录
			</span> 
			<span class="fr">
				<?php echo number_format($_smarty_tpl->tpl_vars['data']->value['total']['money_gain'],2);?>
元
				<i class="iconfont icon-jiantou"></i>
			</span>
		</a>
	</li>
	<li>
		<a href="<?php echo smarty_function_yii_createurl(array('c'=>'WithdrawCash','a'=>'record'),$_smarty_tpl);?>
">
			<span class="fl">
				<i class="iconfont icon-qianbao"></i>提现记录
			</span> 
			<span class="fr">
				<?php echo number_format($_smarty_tpl->tpl_vars['data']->value['total']['money_withdraw'],2);?>
元
				<i class="iconfont icon-jiantou"></i>
				
			</span>
		</a>
	</li>
	<li>
		<a href="<?php echo smarty_function_yii_createurl(array('c'=>'MyHaibao','a'=>'activityrule'),$_smarty_tpl);?>
">
			<span class="fl">
				<i class="iconfont icon-fenlei"></i>活动规则
			</span> 
			<span class="fr">
				<i class="iconfont icon-jiantou"></i>
			</span>
		</a>
	</li>
</ul>
<div class="myreward-btn">
<input type="hidden" class="min-cash" name="" value="最低提现金额<?php echo $_smarty_tpl->tpl_vars['data']->value['withdraw_min'];?>
元">
<?php if ($_smarty_tpl->tpl_vars['last_cash']->value<=0||$_smarty_tpl->tpl_vars['last_cash']->value<$_smarty_tpl->tpl_vars['data']->value['withdraw_min']) {?>
<!--小于最低提现金额不能提现-->
<a href="javascript:;" class="btn lot-btn min-cashBtn">提现</a>
<?php } else { ?>
<a href="<?php echo smarty_function_yii_createurl(array('c'=>'WithdrawCash','a'=>'index'),$_smarty_tpl);?>
" class="btn lot-btn">提现</a>
<?php }?>
</div>
<section class="cash-pop"></section>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"
        data-config="../../conf/coolie-config.js"
        data-main="../main/myreward_main.js"></script><?php }} ?>
