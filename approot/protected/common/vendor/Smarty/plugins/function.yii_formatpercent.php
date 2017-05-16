<?php
/**
 * Smarty Yii plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {yii_formatpercent} function plugin
 *
 * Type:     function<br>
 * Name:     yii_formatpercent<br>
 * Date:     Jun 10, 2015
 * Purpose:  automate create url by liutao@fangfull.com.<br>
 * Params:
 * <pre>
 * - c          - (required) - Yii Controller Id
 * - a          - (optional) - Yii Action Id
 * - extra      - (optional) - extra tags for the href link
 * - ...
 * </pre>
 * Examples:
 * <pre>
 * {yii_formatpercent c="ControllerId"}
 * {yii_createurl c="ControllerId" a="ActionId"}
 * {yii_createurl c="ControllerId" a="ActionId" var1="value1" ...}
 * {yii_createurl c="ControllerId" a="ActionId" ssl=true}
 * </pre>
 *
 * @link http://www.smarty.net/manual/en/language.function.yii_formatpercent.php {yii_formatpercent}
 *          (Smarty online manual)
 * @version 1.0
 * @author Liutao liutao@fangfull.com
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string
 */
function smarty_function_yii_formatpercent($params, $template) 
{   
    //百分比
    $percent = floatval($params['percent']);
    //精度
    $decimals = isset($params['decimals']) ? intval($params['decimals']) : 0; 

    $formatedPercent = '0';
    if (!empty($percent)) {
        //小数部分
        $decimalPart = ($percent - intval($percent)) * pow(10, intval($decimals));
       
        //小数部分不为零
        if ($decimalPart > 0) {
            $formatedPercent = number_format($percent, intval($decimals));
        } else {
            $formatedPercent = intval($percent);
        }
    }

    return $formatedPercent;
}