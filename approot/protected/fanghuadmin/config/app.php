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
$config['import'][] = 'application.fanghumodels.*';
$config['import'][] = 'application.fanghuadmin.models.*';
$config['import'][] = 'application.fanghuadmin.components.*';
$config['import'][] = 'application.fanghuadmin.controllers.*';
$config['import'][] = 'application.common.extensions.wechatlib.*';
$config['import'][] = 'application.common.extensions.util.*';
/*
 * loginUser component
 * autoloading model and component classes
*/
$config['components']['memberadmin']['class'] = 'application.fanghuadmin.components.MemberAdminUser';
$config['components']['memberadmin']['stateKeyPrefix'] = 'memberadmin';
$config['components']['memberadmin']['guestName'] = 'Guest';
$config['components']['memberadmin']['allowAutoLogin'] = true;
/*
 * rbac component
 * autoloading model and component classes
*/
$config['components']['rbac']['class'] = 'application.fanghuadmin.components.RBAC';

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
$gii['password'] = 'ares_gii_0910';
$gii['ipFilters'] = ['127.0.0.1', '::1'];
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
$config['params']['tplPath'] = '/fanghuadmin';
$config['params']['uploadPic']['basePath'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload';
$config['params']['uploadPic']['webPath'] = '/upload/';
$config['params']['LOG_PATH'] = 'logs';
$config['params']['LOG_NAME'] = 'backend.log';
$config['params']['LOG_LEVEL'] = '2';
$config['params']['LOG_MAIL'] = 'monitor@none.com';
$config['params']['giiPath']['model'] = 'application.fanghuadmin.models';
// page size
$config['params']['pageSize'] = 10;

/*
* 房乎微信公众号配置
*/
$config['params']['fh_wechat_appid']        = 'wx829d7b12c00c4a97';
$config['params']['fh_wechat_appsecret']    = 'd0eb0ee77de35361ee51fc41df85da60';
