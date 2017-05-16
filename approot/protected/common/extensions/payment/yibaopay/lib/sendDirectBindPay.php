<?php

// 支付请求
include 'config.php';

$orderid = trim($_POST['orderid']);
$transtime = intval($_POST['transtime']);
$amount = intval($_POST['amount']);
$productname = trim($_POST['productname']);
$productdesc = trim($_POST['productdesc']);
$identityid = trim($_POST['identityid']);
$identitytype = trim($_POST['identitytype']);
$card_top = trim($_POST['card_top']);
$card_last = trim($_POST['card_last']);
$orderexpdate = intval($_POST['orderexpdate']);
$callbackurl = trim($_POST['callbackurl']);
$imei = trim($_POST['imei']);
$userip = trim($_POST['userip']);
$ua = trim($_POST['ua']);

$data = $yeepay->directPayment($orderid, $transtime, $amount, $productname, $productdesc, $identityid, $identitytype, $card_top, $card_last, $orderexpdate, $callbackurl, $imei, $userip, $ua);
dump($data);
if ($data['smsconfirm'] == 0) {
	echo '不需要发送验证码<br />';
	echo '<a href="confirmPayment.php?payment=1&orderid=' . $orderid . '&validatecode=">点击支付</a>';
	// 直接调用支付接口
	//$validatecode = '';
	//$yeepay->confirmPayment($orderid);
} else {
	echo '需要验证码<br />';
	echo '下一步,<a href="confirmPayment.php?payment=2&orderid='. $orderid .'&validatecode=">请输入短信验证码</a>';
	//echo '<form name="confirmPayment" method="POST" action="sendDirectBindPay">请输入验证码:<input type="text" name="validatecode" value="" /><br /><input type="submit" /></form>';
	//$yeepay->confirmPayment($orderid, $validatecode);
}
?>