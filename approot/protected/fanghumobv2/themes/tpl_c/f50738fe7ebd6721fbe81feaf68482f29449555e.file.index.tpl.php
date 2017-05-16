<?php /* Smarty version Smarty-3.1.17, created on 2017-05-17 01:02:58
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/my/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:397731892591b30c222c1d2-81264238%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f50738fe7ebd6721fbe81feaf68482f29449555e' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/my/index.tpl',
      1 => 1471058762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '397731892591b30c222c1d2-81264238',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageTitle' => 0,
    'memberInfo' => 0,
    'member_nickname' => 0,
    'totalInfo' => 0,
    'levelList' => 0,
    'percentLevelUp' => 0,
    'checkBtnText' => 0,
    'invite_code' => 0,
    'logout_return_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b30c2237ef6_98913725',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b30c2237ef6_98913725')) {function content_591b30c2237ef6_98913725($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><!--/coolie-->
<link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/mine.css" />
<!--/coolie-->
<header class="list-header"><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</header>
<section class="task-list">
    <div class="mine_top">
        <img src="../../../../../resource/fanghu2.0/images/integral/mine_bg.jpg" alt="">
        <div class="mine_top_con">
            <div class="fl">
                <div class="mine_icon">
                    <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'editprofile'),$_smarty_tpl);?>
">
                    <?php if (!empty($_smarty_tpl->tpl_vars['memberInfo']->value['member_avatar'])) {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['memberInfo']->value['member_avatar'];?>
" alt="" coolieignore>
                    <?php } else { ?>
                        <img src="../../../../../resource/fanghu2.0/images/integral/friend_icon.png" alt="">
                    <?php }?>
                    </a>
                </div>
                <div class="mine_info">
                    <p class="mine_name"><?php echo $_smarty_tpl->tpl_vars['member_nickname']->value;?>
</p>
                    <p class="mine_rank"><?php echo $_smarty_tpl->tpl_vars['levelList']->value[$_smarty_tpl->tpl_vars['totalInfo']->value['level']]['title'];?>
</p>
                    <div class="rank_bar">
                        <div class="bar" style="width: <?php echo $_smarty_tpl->tpl_vars['percentLevelUp']->value;?>
%"></div>
                        <span class="rank_num">LV<?php echo $_smarty_tpl->tpl_vars['totalInfo']->value['level']*1;?>
</span>
                    </div>
                </div>
            </div>
            <div class="check_in">
                <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'checkin'),$_smarty_tpl);?>
" class="sm-btn"><?php echo $_smarty_tpl->tpl_vars['checkBtnText']->value;?>
</a>
            </div>
        </div>
    </div>
    <div class="mine_cont">
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'myPoints','a'=>'index'),$_smarty_tpl);?>
" class="mine_item">
            <span class="iconfont left_icon">&#xe611;</span>我的积分(<?php echo $_smarty_tpl->tpl_vars['totalInfo']->value['points_total'];?>
)
            <span class="right_icon iconfont">&#xe600;</span>
        </a>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'myHaibao','a'=>'myreward'),$_smarty_tpl);?>
" class="mine_item">
            <span class="iconfont left_icon">&#xe616;</span>我的奖励(<?php echo $_smarty_tpl->tpl_vars['totalInfo']->value['money_total'];?>
元)
            <span class="right_icon iconfont">&#xe600;</span>
        </a>        
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'task'),$_smarty_tpl);?>
" class="mine_item">
            <span class="iconfont left_icon">&#xe60e;</span>我的任务
            <span class="right_icon iconfont">&#xe600;</span>
        </a>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'myfriend'),$_smarty_tpl);?>
" class="mine_item">
            <span class="iconfont left_icon">&#xe607;</span>我的好友
            <span class="right_icon iconfont">&#xe600;</span>
        </a>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'invite','invite_code'=>$_smarty_tpl->tpl_vars['invite_code']->value),$_smarty_tpl);?>
" class="mine_item">
            <span class="iconfont left_icon">&#xe60f;</span>邀请好友
            <span class="right_icon iconfont">&#xe600;</span><i class="icon_info">邀请好友享更多优惠</i>
        </a>
        <a href="javasrcipt:;" class="mine_item">
            <span class="iconfont left_icon">&#xe60d;</span>积分商城
            <span class="wait">敬请期待</span>
        </a>
    </div>
    <div class="mine_cont">
        <a href="tel:400-900-0979" class="mine_item"><span class="iconfont left_icon">&#xe60a;</span>联系我们<span class="right_icon iconfont">&#xe600;</span></a>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'aboutus'),$_smarty_tpl);?>
" class="mine_item"><span class="iconfont left_icon">&#xe60c;</span>关于我们<span class="right_icon iconfont">&#xe600;</span></a>
    </div>
    <div class="btn-link">
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'my','a'=>'logout','logout_return_url'=>$_smarty_tpl->tpl_vars['logout_return_url']->value),$_smarty_tpl);?>
" class="btn lot-btn" type="button">退出登录</a>
    </div>
</section>
<footer class="index-footer">
    <nav class="footer-nav">
        <ul>
            <li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'site','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe602;</i>首页</a></li>
            <li><a href="<?php echo smarty_function_yii_createurl(array('c'=>'lizhuan','a'=>'index'),$_smarty_tpl);?>
"><i class="iconfont index-iconfont">&#xe606;</i>立赚</a></li>
            <li class="active"><a href="javasrcipt:;"><i class="iconfont index-iconfont">&#xe610;</i>我的</a></li>
        </ul>
    </nav>
</footer>
<?php }} ?>
