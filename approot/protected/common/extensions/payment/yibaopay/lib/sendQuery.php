<?php

// 交易记录查询
include 'config.php';

$orderid = trim($_POST['orderid']);
$yborderid = trim($_POST['yborderid']);

$data = $yeepay->paymentQuery($orderid, $yborderid);
dump($data);
?>