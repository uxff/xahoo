<?php
include "wechat.class.php";
$options = array(
		'token'=>'fanghu', //填写你设定的key
        'encodingaeskey'=>'k1fkSbcCjeucm7AEFfL4NczHSBTWayTqgoH8oGQfqA5' //填写加密用的EncodingAESKey，如接口为明文模式可忽略
	);
$weObj = new Wechat($options);
$weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败
$type = $weObj->getRev()->getRevType();
file_put_contents('/tmp/fanghu_wechat_debug',var_export($weObj->getRevID(),true)."\n",FILE_APPEND);
file_put_contents('/tmp/fanghu_wechat_debug',var_export($weObj->getRevFrom(),true)."\n",FILE_APPEND);
switch($type) {
	case Wechat::MSGTYPE_TEXT:
			$weObj->text("你的海报正在生成")->reply();
			$weObj->text("sorry, 您没有注册，请<a href=\"http://testfanghu.xqshijie.com/index.php?r=user/register\">注册</a>")->reply();
			//$weObj->sendRedPack(array());
			exit;
			break;
	case Wechat::MSGTYPE_EVENT:
			break;
	case Wechat::EVENT_SUBSCRIBE:
			//$weObj->sendRedPack(array());
			exit;
			break;
	case Wechat::MSGTYPE_IMAGE:
			break;
	default:
			$weObj->text("help info")->reply();
}
