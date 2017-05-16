<?php
include "wechat.class.php";
$options = array(
    'token'=>'fanghu', //填写你设定的key
    'encodingaeskey'=>'k1fkSbcCjeucm7AEFfL4NczHSBTWayTqgoH8oGQfqA5', //填写加密用的EncodingAESKey，如接口为明文模式可忽略
    'appid' => 'wx829d7b12c00c4a97',
    'appsecret' => 'd0eb0ee77de35361ee51fc41df85da60',
    );
$weObj = new Wechat($options);
$weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败
$type = $weObj->getRev()->getRevType();
file_put_contents('/tmp/fanghu_wechat_debug',var_export($weObj->getRevID(),true)."\n",FILE_APPEND);
file_put_contents('/tmp/fanghu_wechat_debug',var_export($weObj->getRevFrom(),true)."\n",FILE_APPEND);
switch($type) {
    case Wechat::MSGTYPE_TEXT:
        //$weObj->text("你的海报正在生成: to ".$weObj->getRevFrom())->reply();
        echo "";
$size=ob_get_length();
header("Content-Length: $size");
header("Connection: Close");
ob_flush();
flush();

        //$weObj->text("sorry, 您没有注册，请<a href=\"http://testfanghu.xqshijie.com/index.php?r=user/register\">注册</a>")->reply();
        $msg = ["touser"=>$weObj->getRevFrom(), "msgtype"=>'text', "text"=>["content"=>"sorry, 您没有注册，请<a href=\"http://testfanghu.xqshijie.com/index.php?r=user/register&from=wechat&openid=".$weObj->getRevFrom()."\">注册</a>"]];
        $weObj->sendCustomMessage($msg);
        sleep(3);
        $msg = ["touser"=>$weObj->getRevFrom(), "msgtype"=>'text', "text"=>["content"=>"您的海报已生成：这里看"]];
        $weObj->sendCustomMessage($msg);
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
