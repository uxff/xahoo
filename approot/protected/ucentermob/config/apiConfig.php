<?php
Yii::app()->setComponents(
        array(
    'UCenterDb' => array(
        'class' => 'CDbConnection',
        'connectionString' => 'mysql:host=rdst5k07c121z1c2j41d.mysql.rds.aliyuncs.com;dbname=xqsj_db',
        'emulatePrepare' => true,
        'username' => 'xqsj_db_user',
        'password' => 'mhxzkhl0304xqsjdb',
        'charset' => 'utf8',
    )), false);
Yii::import("application.ucentermodels.*");
Yii::import("application.ucentermob.components.*");
