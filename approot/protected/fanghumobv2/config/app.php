<?php

$config['language'] = 'zh_cn';
$config['name'] = 'Xahoo';
$config['preload'][] = 'log';
$config['defaultController'] = 'site';

/*
 * import
*/
$config['import'][] = 'application.common.vendor.Smarty.sysplugins.*';
$config['import'][] = 'application.common.extensions.*';
$config['import'][] = 'application.ucentermob.api.*';
$config['import'][] = 'application.ucentermodels.*';
$config['import'][] = 'application.fanghumodels.*';
$config['import'][] = 'application.fanghumobv2.models.*';
$config['import'][] = 'application.fanghumobv2.components.*';
$config['import'][] = 'application.fanghumobv2.controllers.BaseController';
$config['import'][] = 'application.common.extensions.wxshare.*';
$config['import'][] = 'application.common.components.*';
$config['import'][] = 'application.common.extensions.sms.*';
$config['import'][] = 'application.common.components.JSSDK';
$config['import'][] = 'application.common.extensions.wechatlib.*';
$config['import'][] = 'application.common.extensions.util.*';

/*
 * loginUser component
 * autoloading model and component classes
*/
$config['components']['loginUser']['class'] = 'application.common.components.LoginUser';
$config['components']['loginUser']['stateKeyPrefix'] = '';
$config['components']['loginUser']['guestName'] = 'Guest';
$config['components']['loginUser']['allowAutoLogin'] = true;

$config['components']['smarty']['class'] = 'application.common.extensions.CSmarty';
$config['components']['errorHandler']['errorAction'] = 'site/error';

$config['components']['log']['class'] = 'CLogRouter';
$config['components']['log']['routes'][0]['class'] = 'CFileLogRoute';
$config['components']['log']['routes'][0]['levels'] = 'error, warning';

/*
 * MODULES
 * modules to include
*/
$config['modules'][] = 'event';
$config['modules'][] = 'points';
$config['modules'][] = 'friend';
$config['modules'][] = 'rule';
$config['modules'][] = 'mtask';
$config['modules'][] = 'api';
$config['modules'][] = 'fhmoney';
$config['modules'][] = 'sns';

/*
* params
*/
        // 每个手机号限制次数
$config['params']['reg_sms_limit_mobile']  = 3;
        // 每个ip限制次数
$config['params']['reg_sms_limit_ip']      = 5;
        // 每次限制时间 秒为单位
$config['params']['reg_sms_limit_time']    = 3600 * 24;

/*
* fh微信公众号配置
*/
$config['params']['fh_wechat_appid']        = 'wx829d7b12c00c4a97';
$config['params']['fh_wechat_appsecret']    = 'd0eb0ee77de35361ee51fc41df85da60';

$config['params']['third_login_sess_name']  = 'thirdauth';
