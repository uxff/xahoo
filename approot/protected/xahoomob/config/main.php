<?php
// set ares alias
$currentAppPath = dirname(dirname(__FILE__));
$protectedPath = dirname($currentAppPath);

$config = [];

include_once __DIR__ . '/app.php'; 


$config['basePath'] = $protectedPath;
$config['controllerPath'] = $currentAppPath . '/controllers';


/*
 * session component
 * autoloading model and component classes
*/
$config['components']['session']['cookieParams']['path'] = '/';
$config['components']['session']['cookieParams']['domain'] = getenv('SERVER_NAME');
$config['components']['session']['cookieParams']['lifetime'] = 0;

/*
 * db component
 * autoloading model and component classes
*/
$config['components']['db']['class'] = 'application.common.components.DbConnectionManager';
$config['components']['db']['connectionString'] = 'mysql:host=127.0.0.1;dbname=xahoo';
$config['components']['db']['emulatePrepare'] = true;
$config['components']['db']['username'] = 'www';
$config['components']['db']['password'] = '123x456';
$config['components']['db']['charset'] = 'utf8';
$config['components']['db']['enableSlave'] = false; //从数据库启用
$config['components']['db']['slavesWrite'] = true; //紧急情况 主数据库无法连接 启用从数据库 写功能
$config['components']['db']['masterRead'] = true; //紧急情况 从数据库无法连接 启用主数据库 读功能
/*
$config['components']['db']['slaves'][0]['connectionString'] = 'mysql:host=103.10.86.28;dbname=fanghu_db';
$config['components']['db']['slaves'][0]['emulatePrepare'] = true;
$config['components']['db']['slaves'][0]['username'] = 'test';
$config['components']['db']['slaves'][0]['password'] = 'mhxzkhl';
$config['components']['db']['slaves'][0]['charset'] = 'utf8';
$config['components']['db']['slaves'][1]['connectionString'] = 'mysql:host=103.10.86.28;dbname=fanghu_db';
$config['components']['db']['slaves'][1]['emulatePrepare'] = true;
$config['components']['db']['slaves'][1]['username'] = 'test';
$config['components']['db']['slaves'][1]['password'] = 'mhxzkhl';
$config['components']['db']['slaves'][1]['charset'] = 'utf8';
*/
/*
 * UCenterDb component
 * autoloading model and component classes
*/
$config['components']['UCenterDb']['class'] = 'application.common.components.DbConnectionManager';
$config['components']['UCenterDb']['connectionString'] = 'mysql:host=127.0.0.1;dbname=xahoo';
$config['components']['UCenterDb']['emulatePrepare'] = true;
$config['components']['UCenterDb']['username'] = 'www';
$config['components']['UCenterDb']['password'] = '123x456';
$config['components']['UCenterDb']['charset'] = 'utf8';
$config['components']['UCenterDb']['enableSlave'] = false;
$config['components']['UCenterDb']['slavesWrite'] = true;
$config['components']['UCenterDb']['masterRead'] = true;
/*
$config['components']['UCenterDb']['slaves'][0]['connectionString'] = 'mysql:host=103.10.86.28;dbname=xqsj_db';
$config['components']['UCenterDb']['slaves'][0]['emulatePrepare'] = true;
$config['components']['UCenterDb']['slaves'][0]['username'] = 'test';
$config['components']['UCenterDb']['slaves'][0]['password'] = 'mhxzkhl';
$config['components']['UCenterDb']['slaves'][0]['charset'] = 'utf8';
$config['components']['UCenterDb']['slaves'][1]['connectionString'] = 'mysql:host=103.10.86.28;dbname=xqsj_db';
$config['components']['UCenterDb']['slaves'][1]['emulatePrepare'] = true;
$config['components']['UCenterDb']['slaves'][1]['username'] = 'test';
$config['components']['UCenterDb']['slaves'][1]['password'] = 'mhxzkhl';
$config['components']['UCenterDb']['slaves'][1]['charset'] = 'utf8';
*/
/*
 * cache component
 * autoloading model and component classes
*/
$config['components']['cache']['class'] = 'CMemCache';
$config['components']['cache']['useMemcached'] = true;
$config['components']['cache']['servers'][0]['host'] = '127.0.0.1';
$config['components']['cache']['servers'][0]['port'] = 11211;
$config['components']['cache']['servers'][0]['weight'] = 60;
$config['components']['cache']['keyPrefix'] = '';
$config['components']['cache']['hashKey'] = false;
$config['components']['cache']['serializer'] = false;

/*
 * params
*/
// this is used in contact page
$config['params']['adminEmail'] = 'webmaster@example.com';
$config['params']['resourcePath'] = '/resource/xahoo3.0';
$config['params']['resourceThirdVendorPath'] = '/resource/thirdvendor';
$config['params']['tplPath'] = '/xahoomob/dist';
$config['params']['uploadPic']['basePath'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload';
$config['params']['uploadPic']['webPath'] = '/upload/';
// 上传用户头像的子目录
$config['params']['UPLOAD_AVATAR_SUBDIR'] = 'avatar';
$config['params']['LOG_PATH'] = 'logs/';
$config['params']['LOG_NAME'] = 'frontend.log';
$config['params']['LOG_LEVEL'] = '2';
$config['params']['LOG_MAIL'] = 'monitor@none.com';
$config['params']['ImageServerName'] = ($_SERVER['SERVER_POST']=='443'?'https://':'http://').$_SERVER['HTTP_HOST'];
// Image Server
$config['params']['UCenterServerName'] = ($_SERVER['SERVER_POST']=='443'?'https://':'http://').$_SERVER['SERVER_NAME'].'/ucenter.php';
// UCenter Server
$config['params']['XqsjFQServerName'] = ($_SERVER['SERVER_POST']=='443'?'https://':'http://').$_SERVER['SERVER_NAME'].'/xqsjfq.php';
// FangHu Server
// Baidu Tracking
$config['params']['FanghuServerName'] = ($_SERVER['SERVER_POST']=='443'?'https://':'http://').$_SERVER['SERVER_NAME'].'/frontendmob.php';
$config['params']['baiduTrackingKey'] = '';
// page size
$config['params']['pageSize'] = 10;
// scroll page size
$config['params']['scrollPageSize'] = 10;
// protocol 协议，允许值: auto|http|https online=https test=http dev=auto
$config['params']['protocol'] = 'auto';

// 前端构建目录
// for online
//$config['params']['tplPath'] = '/xahoomob/dist';
// for dev
$config['params']['tplPath'] = '/xahoomob';

return $config;
