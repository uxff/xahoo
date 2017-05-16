<?php

// 提交绑定银行卡
include 'config.php';

$requestid = trim($_POST['requestid']);
$identitytype = intval($_POST['identitytype']);
$identityid = trim($_POST['identityid']);
$cardno = trim($_POST['cardno']);
$idcardno = trim($_POST['idcardno']);
$username = trim($_POST['username']);
$phone = trim($_POST['phone']);
$registerphone = trim($_POST['registerphone']);
$registerdate = trim($_POST['registerdate']);
$registerip = trim($_POST['registerip']);
$registeridcardno = trim($_POST['registeridcardno']);
$registercontact = trim($_POST['registercontact']);
$os = trim($_POST['os']);
$imei = trim($_POST['imei']);
$userip = trim($_POST['userip']);
$ua = trim($_POST['ua']);

$data = $yeepay->bindBankcard($identityid, $identitytype, $requestid, $cardno, $idcardno, $username, $phone, $registerphone, $registerdate, $registerip, $registeridcardno, $registercontact, $os, $imei, $userip, $ua);
dump($data);
?>