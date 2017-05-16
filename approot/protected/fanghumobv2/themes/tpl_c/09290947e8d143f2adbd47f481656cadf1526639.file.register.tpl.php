<?php /* Smarty version Smarty-3.1.17, created on 2017-05-16 22:47:39
         compiled from "/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/user/register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:591542205591b110b45d835-58787779%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09290947e8d143f2adbd47f481656cadf1526639' => 
    array (
      0 => '/data/sharehd/xahoo/approot/protected/fanghumobv2/themes/tpl/user/register.tpl',
      1 => 1474163342,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '591542205591b110b45d835-58787779',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'return_url' => 0,
    'signage' => 0,
    'token' => 0,
    'invite_code' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_591b110b48aa49_40205695',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_591b110b48aa49_40205695')) {function content_591b110b48aa49_40205695($_smarty_tpl) {?><?php if (!is_callable('smarty_function_yii_createurl')) include '/data/sharehd/xahoo/approot/protected/common/vendor/Smarty/plugins/function.yii_createurl.php';
?><link rel="stylesheet" href="../../../../../resource/fanghu2.0/css/reg.css" />
	<section class="tab">
    	<a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'login','return_url'=>$_smarty_tpl->tpl_vars['return_url']->value),$_smarty_tpl);?>
" class="off active">登录</a>
        <a href="<?php echo smarty_function_yii_createurl(array('c'=>'user','a'=>'register','return_url'=>$_smarty_tpl->tpl_vars['return_url']->value),$_smarty_tpl);?>
" class="on">注册</a>
	</section>
    <form onsubmit="return false" id="form" method="post">
    	<input type="hidden" name="return_url" id="return_url" value="<?php echo $_smarty_tpl->tpl_vars['return_url']->value;?>
" />
    	<input type="hidden" name="signage"  id="signage" value="<?php echo $_smarty_tpl->tpl_vars['signage']->value;?>
" />
    	<input type="hidden" name="token"  id="token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" />
	    <section class="form-box reg-box">
	    	<ul>
			    <li>
				    <span>手机号码</span>
				    <input type="tel" class="form-input" id="username" name="username" placeholder="请输入真实手机号" />
			    </li>
                <li>
                    <span>图形码：</span>
                    <input type="text" name="valicode" id="valicode" class="form-input" placeholder="请输入图形验证码" maxlength="6"/>
                    <div  class="form_cord">
                    <img style="cursor:pointer" class="reloadCode" title="点击换一张" src="<?php echo smarty_function_yii_createurl(array('c'=>'ajaxuc','a'=>'ValidationCode','width'=>80,'height'=>30),$_smarty_tpl);?>
" id="reloadValicode" coolieignore/>
                    </div>
                </li>
			    <li>
				    <span>验证码</span>
				    <input type="tel" class="form-input" id="reg_yzm"  name="vetify_code" placeholder="请输入验证码" />
				    <input type="button" id="yzm_txt" class="btn-yzm" value="获取验证码" />
			    </li>
			    <li>
				    <span>登录密码</span>
				    <input type="password" name="password" id="reg_password" class="form-input" placeholder="请设置新密码，不少于6位" />
			    </li>
			    <li>
				    <span>确认密码</span>
				    <input type="password"   name="confirm_password" id="confirm_password" class="form-input" placeholder="请再次输入密码" />
			    </li>
                <?php if (empty($_smarty_tpl->tpl_vars['invite_code']->value)) {?>
			    <li id="invite-code" style="display: none;">
				    <span>邀请码</span>
				    <input type="text" class="form-input"   name="invite_code"  value="<?php echo $_smarty_tpl->tpl_vars['invite_code']->value;?>
"  placeholder="请输入好友邀请码" />
			    </li>
                <?php } else { ?>
			    <li id="invite-code">
				    <span>邀请码</span>
				    <input type="text" class="form-input"   name="invite_code"  value="<?php echo $_smarty_tpl->tpl_vars['invite_code']->value;?>
"  placeholder="请输入好友邀请码" />
			    </li>
                <?php }?>
		    </ul>
		    <a id="invite-code-toggler" href="javascript:;">我有邀请码<i class="iconfont icon-down"></i></a>
		</section>
	</form>
	<div class="reg_xy"><a href="javascript:;">用户服务协议</a></div>
	<section class="btn-link">
		<button class="btn lot-btn" type="button">注册</button>
	</section>
	<section class="xy_cont">
	    <header class="header">
			<a onclick="javascript:;" class="fl"><i class="iconfont">&#xe604;</i></a>
			用户服务协议
		</header>
		<div class="xy_info">
			<p>天津活力营销顾问有限公司（以下简称“平台方”）运营的房乎平台（房乎网站： fanghu.xqshijie.com）是一个全民分享推广平台。</p><br>
			<p>申请成为“房乎”用户，您需要同意本注册协议中的所有内容。请您仔细阅读并充分理解本协议各条款，审慎阅读并选择接受或不接受本协议。当您按照页面提示填写信息、阅读本协议并点击确认后，即视为您已完全同意并接受本协议，并愿受其约束，本协议即成立并生效。您承诺接受并遵守本协议的约定，届时您不应以未阅读本协议的内容主张本协议无效或要求撤销本协议。如有违反而导致任何法律后果的发生，您应以自己的名义独立承担所有法律责任。</p><br>
			<p>本协议内容包括本协议正文所载各条款及平台方已经发布的或将来可能发布的各类规则、公告或通知（以下简称“房乎业务规则”），所有该等规则均为本协议不可分割的一部分，与本协议正文具有同等法律效力。</p><br>

<h3>一、注册与账户</h3>
	<p>1、当您符合以下条件时方可申请注册“房乎”用户, 有权根据房乎业务规则，获得相应奖励。若因您不具备以下条件而导致的法律后果由您自行承担。</p>
<p>（1）持有中华人民共和国有效身份证件的18周岁以上且具有完全民事行为能力和民事权利能力的自然人可申请成为“房乎”注册用户。</p>
	<p>（2） 您作为房乎注册用户，应保证履行本合同不会与您从事的其它工作、业务活动或其它任何身份冲突。</p>
	<p>2、您申请注册房乎后，将获得一个房乎账号，您也可以用该帐号直接登录房乎网站和新奇世界官网（新奇世界网站：www.xqshijie.com）。该账户是您在房乎网站和新奇世界官网的身份识别代码，不得以任何方式买卖、转让、赠与或继承。若需变更账号及账号相关信息，须在房乎申请并经平台方同意。</p>
	<p>3、您申请注册房乎时，应按页面提示提供相关资料，包括但不限于真实姓名、手机号码等。若您提交的资料信息发生变更，请您于资料信息变更后二十四小时内及时申请变更，以确保您所提交的资料真实、完整、准确。因您违反本条款而引起的损失由您自行承担，包括但不限于信息被篡改、信息泄露、资金损失等。</p>
	<p>4、注册成功后，将产生用户名和密码等账户信息，您可以根据本站规定更改您的密码。您应谨慎合理地保存、使用用户名和密码。对利用该账号所进行的一切活动引起的任何损失或损害, 由您自行承担全部责任, 平台方不承担任何责任。您若发现任何非法使用用户账号或存在安全漏洞的情况，请立即通知平台方并向公安机关报案。因黑客行为或用户的保管疏忽导致账号非法使用, 平台方不承担任何责任。 </p>
<p>5、若平台方认为您的账户存在安全隐患，平台方有权对您的账号进行账户锁定或关闭而不事先通知。</p><br>

	<h3>二、积分细则</h3>
	<p>1、您应当遵守平台方发布的房乎业务规则。</p>
	<p>2、您的注册信息经平台方审核通过后您即成为房乎注册用户， 积分只在同一会员帐户内累计，不同帐户的积分不能合并；</p>
	<p>3、获得的积分不可买卖交易，不可用于兑换现金，仅限按照房乎网站指定的规则兑换物品以及参与抽奖等积分活动。</p>
	<p>4、经查明进行系统攻击或者恶意手段等非正常方式获得积分者，平台方有权扣减您所有积分。</p>
<p>5、其余积分规则详见房乎网站不时公布的各类规则、公告或通知。</p><br>

	<h3>三、违约责任</h3>
	<p>您同意并了解：</p>
	<p>1、您如果违反本协议的条款，产生任何法律后果的，您应以自己的名义独立承担所有的法律责任，并确保平台方免于因此产生任何损失或增加费用。</p>
	<p>2、经国家行政或司法机关的生效法律文书确认您存在违法或侵权行为，或者平台方根据自身的判断，认为您的行为涉嫌违反法律法规的规定或涉嫌违反本协议和/或规则的条款的，则平台方有权公示您的该等涉嫌违法或违约行为及平台方已对您采取的措施。</p>
<p>3、如您涉嫌违反有关法律或者本协议之规定，使平台方遭受任何损失，或受到任何第三方的索赔，或受到任何行政管理部门的处罚，您应当赔偿平台方因此造成的损失和/或发生的费用，包括合理的律师费用。</p><br>

	<h3>四、责任限制</h3>
	<p>不论在何种情况下，平台方均不对由于信息网络正常的设备维护，信息网络连接故障，电脑、通讯或其他系统的故障，电力故障，火灾，洪水，风暴，爆炸，战争，政府行为，司法行政机关的命令或第三方的不作为而造成的不能服务或延迟服务承担责任。</p><br>

	<h3>五、法律适用、管辖</h3>
	<p>1、本协议之效力、解释、变更、执行与争议解决均适用中华人民共和国大陆地区法律。</p>
	<p>2、因本协议而产生的一切争议平台方将与您通过友好协商解决。协商不成的，任何一方均有权向平台方所在地人民法院提起诉讼。</p>
		</div>
	</section>
<script coolie src="../../../../../resource/fanghu2.0/js/lib/coolie/coolie.min.js"  data-config="../../conf/coolie-config.js"  data-main="../main/reg_main.js"></script><?php }} ?>
