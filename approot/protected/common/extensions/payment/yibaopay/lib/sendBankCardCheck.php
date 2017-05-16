<?php
// 银行卡信息查询
include 'config.php';
$cardno = trim($_POST['cardno']);
$data = $yeepay->bankcardCheck($cardno);
dump($data);
?>
