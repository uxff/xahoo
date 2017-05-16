<?php
//error report set 0 if development mode
error_reporting(0);
//error_reporting(E_ALL&~E_NOTICE);

// change the following paths if necessary
$yii = dirname(__FILE__).'/../framework/yii.php';

// load configuration file
$config = dirname(__FILE__).'/protected/image/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// show config file not found
if (!file_exists($config)) {
    die('-- config file: { '. $config .' } not found --');
}

// bootstrap app
require_once($yii);
Yii::createWebApplication($config)->run();