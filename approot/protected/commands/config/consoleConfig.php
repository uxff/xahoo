<?php

return array (
    'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '../../',
    //'basePath' => $protectedPath,
    'name' => 'consoles',
    'preload' => ['log'],
    'import' => array (
        'application.xqsjmodels.*', 
        'application.common.components.*',  
        'application.common.extensions.*',  
     ),
    'components' => array ( 
        'db' => array(
            'class' => 'application.common.components.DbConnectionManager',//扩展路径
            //'connectionString' => 'mysql:host=rdst5k07c121z1c2j41d.mysql.rds.aliyuncs.com;dbname=xqsj_db',//主数据库 写
            //'connectionString' => 'mysql:host=112.126.73.37;dbname=fanghu_db',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=xahoo',
            'emulatePrepare' => true,
            //'username' => 'xqsj_db_user',
            //'password' => 'mhxzkhl0304xqsjdb',
            //'username' => 'test',
            //'password' => 'mhxzkhl',
            'username' => 'www',
            'password' => '123x456',
            'charset' => 'utf8',
            'enableSlave' => false, //从数据库启用
            'slavesWrite' => false, //紧急情况 主数据库无法连接 启用从数据库 写功能
            'masterRead' => false, //紧急情况 从数据库无法连接 启用主数据库 读功能
            //'slaves' => array(
            //    array( // slave1
            //    'connectionString'=>'mysql:host=rdsk2x8579vq5d8qja7z.mysql.rds.aliyuncs.com;dbname=xqsj_db',
            //    'emulatePrepare' => true,
            //    'username' => 'xqsj_db_ro_user',
            //    'password' => 'mhxzkhl0802xqsjdb',
            //    'charset' => 'utf8',
            //    ),
            //    array( // slave2
            //    'connectionString'=>'mysql:host=rds3mn1oqc86345qysvf.mysql.rds.aliyuncs.com;dbname=xqsj_db',
            //    'emulatePrepare' => true,
            //    'username' => 'xqsj_db_ro_user',
            //    'password' => 'mhxzkhl0802xqsjdb',
            //    'charset' => 'utf8',
            //    ),
            //),
        ),
        'UCenterDb' => array(
            'class' => 'application.common.components.DbConnectionManager',//扩展路径
            'connectionString' => 'mysql:host=127.0.0.1;dbname=xahoo',//主数据库 写
            'emulatePrepare' => true,
            'username' => 'www',
            'password' => '123x456',
            'charset' => 'utf8',
            'enableSlave' => false, //从数据库启用
            'slavesWrite' => false, //紧急情况 主数据库无法连接 启用从数据库 写功能
            'masterRead' => false, //紧急情况 从数据库无法连接 启用主数据库 读功能
            /*
            'slaves' => array(
                array( // slave1
                    'connectionString'=>'mysql:host=112.126.73.37;dbname=xqsj_db',
                    'emulatePrepare' => true,
                    'username' => 'test',
                    'password' => 'mhxzkhl',
                    'charset' => 'utf8',
                ),
                array( // slave2
                    'connectionString'=>'mysql:host=112.126.73.37;dbname=xqsj_db',
                    'emulatePrepare' => true,
                    'username' => 'test',
                    'password' => 'mhxzkhl',
                    'charset' => 'utf8',
                ),
            ),
             */
        ),

        'log' => array (
            'class' => 'CLogRouter',
            'routes' => array (
                array (
                    'class' =>'CFileLogRoute',
                    'levels' => 'error, warning'
                )
            )
        )
    ),
    'modules'=>array(
       'api', 
       'order', 
   ),
   'params'=>array(
       'LOG_PATH' => 'logs/',
       'LOG_NAME' => 'console.log',
       'LOG_LEVEL' => 2,
   ),
);
