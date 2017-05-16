<?php

// 确认支付
include 'config.php';

$payment = intval($_GET('payment'));
$orderid = trim($_GET['orderid']);
$validatecode = trim($_GET['validatecode']);
if ($payment == 1) {
	// 不需要验证码
	$data = $yeepay->confirmPayment($orderid);
	dump($data);
} else {
	// 需要验证码
	if ($validatecode) {
		$data = $yeepay->confirmPayment($orderid, $validatecode);
		dump($data);
	} else {
		echo '<form name="confirmPayment" method="GET" action="confirmPayment.php">请输入验证码:<input type="hidden" name="payment" value="' . $payment . '" /><input type="hidden" name="orderid" value="' . $orderid . '" /><input type="text" name="validatecode" value="" /><br /><input type="submit" /></form>';
	}
}
?>
