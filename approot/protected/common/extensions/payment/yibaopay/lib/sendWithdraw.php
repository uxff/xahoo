<?php

// 提现
include 'config.php';

$requestid = trim($_POST['requestid']);
$identityid = trim($_POST['identityid']);
$identitytype = intval($_POST['identitytype']);
$card_top = trim($_POST['card_top']);
$card_last = trim($_POST['card_last']);
$amount = intval($_POST['amount']);
$imei = trim($_POST['imei']);
$userip = trim($_POST['userip']);
$ua = trim($_POST['ua']);

$data = $yeepay->withdraw($requestid, $identityid, $identitytype, $card_top, $card_last, $amount, $imei, $userip, $ua);
dump($data);
?>
