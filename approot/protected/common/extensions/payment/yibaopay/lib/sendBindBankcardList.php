<?php

// 绑卡查询
include 'config.php';

$identityid = trim($_POST['identityid']);
$identitytype = intval($_POST['identitytype']);

$data = $yeepay->bankcardList($identityid, $identitytype);
dump($data);
?>
