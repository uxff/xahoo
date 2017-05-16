<?php
/**
 * Smarty Yii plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {yii_imageurl} function plugin
 *
 * Type:     function<br>
 * Name:     yii_imageurl<br>
 * Date:     Jun 26, 2015
 * Purpose:  automate create url by liutao@fangfull.com.<br>
 * Params:
 * <pre>
 * - src    	- (required) - image original src
 * - size       - (optional) - scale resolution
 * </pre>
 * Examples:
 * <pre>
 * {yii_imageurl src="xxx/yyy.png"}
 * {yii_imageurl src="xxx/yyy.png" size="720x500"}
 * </pre>
 *
 * @link http://www.smarty.net/manual/en/language.function.yii_imageurl.php {yii_imageurl}
 *          (Smarty online manual)
 * @version 1.0
 * @author Liutao liutao@fangfull.com
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string
 */
function smarty_function_yii_imageurl($params, $template)
{
	$imageSrc = trim($params['src']);
	$imageSize = trim($params['size']);

	// Get extra GET parameters
	unset($params['src']);
	unset($params['size']);

	// server
	$imageServer = Yii::app()->params['ImageServerName'];
	if (empty($imageServer)) {
		$imageServer = Yii::app()->getRequest()->getHostInfo('http');
	}

	// path
	$imagePath = '';
	if (!empty($imageSrc)) {
		//remove upload dir
		$imageSrc = (stripos($imageSrc, '/upload/') === 0) ? substr_replace($imageSrc, '', 0, strlen('/upload/')) : $imageSrc;
		//
		list( $dirname, $basename, $extension, $filename ) = array_values( pathinfo($imageSrc) );
		//
		$arrDirnames = explode('/', $dirname);
		$saveDir = $arrDirnames[0];
		//$resolution = $arrDirnames[1];
		$imagePath = $saveDir .'/'. $basename;
	}

	// url
	$imageUrl = $imageServer;
	if (!empty($imageSize)) {
		$imageUrl .= '/images/'. $imageSize;
	} else {
		$imageUrl .= '/upload/';
	}

	// src
	if (!empty($imagePath)) {
		$imageUrl .= '/'.$imagePath;
	} else {
		$imageUrl = '';
	}

	return $imageUrl;
}