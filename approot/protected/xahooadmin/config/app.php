<?php

$config['name'] = 'xahoo管理后台';
$config['language'] = 'zh_cn';
$config['preload'][] = 'log';
$config['defaultController'] = 'site';

/*
 * import
*/
$config['import'][] = 'application.common.vendor.Smarty.sysplugins.*';
$config['import'][] = 'application.common.extensions.*';
$config['import'][] = 'application.common.components.*';
$config['import'][] = 'application.xahoomodels.*';
$config['import'][] = 'application.xahooadmin.models.*';
$config['import'][] = 'application.xahooadmin.components.*';
$config['import'][] = 'application.xahooadmin.controllers.*';
$config['import'][] = 'application.common.extensions.wechatlib.*';
$config['import'][] = 'application.common.extensions.util.*';
/*
 * loginUser component
 * autoloading model and component classes
*/
$config['components']['memberadmin']['class'] = 'application.xahooadmin.components.MemberAdminUser';
$config['components']['memberadmin']['stateKeyPrefix'] = 'memberadmin';
$config['components']['memberadmin']['guestName'] = 'Guest';
$config['components']['memberadmin']['allowAutoLogin'] = true;
/*
 * rbac component
 * autoloading model and component classes
*/
$config['components']['rbac']['class'] = 'application.xahooadmin.components.RBAC';

$config['components']['smarty']['class'] = 'application.common.extensions.CSmarty';
$config['components']['errorHandler']['errorAction'] = 'site/error';

/*
 * log component
 * autoloading model and component classes
*/
$config['components']['log']['class'] = 'CLogRouter';
$config['components']['log']['routes'][0]['class'] = 'CFileLogRoute';
$config['components']['log']['routes'][0]['levels'] = 'error, warning';
/*
 * MODULES of gii
*/
$gii = [];
$gii['class'] = 'system.gii.GiiModule';
$gii['password'] = '123456';
$gii['ipFilters'] = ['127.0.0.1', '::1', '192.168.*.*'];
$config['modules']['gii'] = $gii;

/*
 * MODULES
 * modules to include
*/
$config['modules'][] = 'event';
$config['modules'][] = 'points';
$config['modules'][] = 'friend';
$config['modules'][] = 'mtask';
$config['modules'][] = 'api';
$config['modules'][] = 'phpExcel';


/*
 * params
*/
$config['params']['adminEmail'] = 'webmaster@example.com';
$config['params']['resourcePath'] = 'resource/thirdvendor/aceadmin1.3.1';
$config['params']['resourceBasePath'] = '/resource/thirdvendor';
$config['params']['tplPath'] = '/xahooadmin';
$config['params']['uploadPic']['basePath'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload';
$config['params']['uploadPic']['webPath'] = '/upload/';
$config['params']['LOG_PATH'] = 'logs';
$config['params']['LOG_NAME'] = 'backend.log';
$config['params']['LOG_LEVEL'] = '2';
$config['params']['LOG_MAIL'] = 'monitor@none.com';
$config['params']['giiPath']['model'] = 'application.xahooadmin.models';
// page size
$config['params']['pageSize'] = 10;

/*
* fh微信公众号配置
*/
$config['params']['fh_wechat_appid']        = 'wx829d7b12c00c4a97';
$config['params']['fh_wechat_appsecret']    = 'd0eb0ee77de35361ee51fc41df85da60';
