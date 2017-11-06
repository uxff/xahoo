<?php
date_default_timezone_set('Asia/Shanghai');

define('YII_ENABLE_ERROR_HANDLER',false);
define('YII_ENABLE_EXCEPTION_HANDLER',false);

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',1);


$yiic = dirname(__FILE__).'/../../../framework/yii.php';
require_once($yiic); 

$configFile = dirname(__FILE__).'/config/consoleConfig.php';

Yii::createConsoleApplication($configFile)->run();
