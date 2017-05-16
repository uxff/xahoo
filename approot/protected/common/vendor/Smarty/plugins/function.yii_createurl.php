<?php
/**
 * Smarty Yii plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {yii_createurl} function plugin
 *
 * Type:     function<br>
 * Name:     yii_createurl<br>
 * Date:     Jun 26, 2015
 * Purpose:  automate create url by liutao@fangfull.com.<br>
 * Params:
 * <pre>
 * - c    		- (required) - Yii Controller Id
 * - a       	- (optional) - Yii Action Id
 * - extra      - (optional) - extra tags for the href link
 * - ...
 * </pre>
 * Examples:
 * <pre>
 * {yii_createurl c="ControllerId"}
 * {yii_createurl c="ControllerId" a="ActionId"}
 * {yii_createurl c="ControllerId" a="ActionId" var1="value1" ...}
 * {yii_createurl c="ControllerId" a="ActionId" ssl=true}
 * </pre>
 *
 * @link http://www.smarty.net/manual/en/language.function.yii_createurl.php {yii_createurl}
 *          (Smarty online manual)
 * @version 1.0
 * @author Liutao liutao@fangfull.com
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string
 */
function smarty_function_yii_createurl($params, $template)
{


	$controllerId = trim($params['c']);
	$actionId = trim($params['a']);
	
	//$enableSSL = isset($params['ssl']) ? trim($params['ssl']) : false;
	//
	//// schema
	//if ((bool)$enableSSL) {
	//	$schema = 'https';
	//} else {
	//	$schema = 'http';
	//}

	// 自动判断协议
    //$schema = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
    $schema = Yii::app()->request->getIsSecureConnection() ? 'https' : 'http';

	$route = '';
	// Controller
	if (!empty($controllerId)) {
		$route .= $controllerId;
	}

	// Action
	if (!empty($actionId)) {
		$route .= '/'.$actionId;
	}

	// Get extra GET parameters
	unset($params['c']);
	unset($params['a']);
	unset($params['ssl']);


	// url
	$url = Yii::app()->createUrl($route, $params);

	// mode
	$enableAbsoluteUrl = true;
	if ($enableAbsoluteUrl) {
		return Yii::app()->getRequest()->getHostInfo($schema) . $url;
	} else {
		return $url;
	}

}