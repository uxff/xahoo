<?php

// 确认绑卡
include 'config.php';
if ($_POST) {
	$requestid = trim($_POST['requestid']);
	$validatecode = trim($_POST['validatecode']);
	$data = $yeepay->bindBankcardConfirm($requestid, $validatecode);
	dump($data);
}
?>