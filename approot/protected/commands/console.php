<?php
date_default_timezone_set('Asia/Shanghai');          
$yiic = dirname(__FILE__).'/../../../framework/yii.php';
require_once($yiic); 

$configFile = dirname(__FILE__).'/config/consoleConfig.php';

Yii::createConsoleApplication($configFile)->run();
