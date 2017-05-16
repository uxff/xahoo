<?php
// 支付清算文件
include 'config.php';

$startdate = trim($_POST['startdate']);
$enddate = trim($_POST['enddate']);

$data = $yeepay->payClearData($startdate, $enddate);
dump($data);
?>
