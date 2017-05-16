<?php
// 提现查询
include 'config.php';

$requestid = trim($_POST['requestid']);
$ybdrawflowid = trim($_POST['ybdrawflowid']);
$data = $yeepay->withdrawQuery($requestid,$ybdrawflowid);
dump($data);
?>