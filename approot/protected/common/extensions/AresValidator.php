<?php

/**
 * 常用校验类
 *
 * @author liutao@fangfull.com
 * @date 2014/12/18 09:53:50
 */
class AresValidator {

    /**
     * 验证是否为中国大陆地区手机号
     * 
     * @param  string  $value [description]
     * @return boolean        [description]
     */
    public static function isValidChineseMobile($value) {
        $result = false;
        if (!empty($value)) {
            //$result = (bool) preg_match('/^((13[0-9])|(15[0-9])|(170)|(18[0-9])|(178))\d{8}$/', $value);
            $result = (bool) preg_match('/^1\d{10}$/', $value);
        }

        return $result;
    }

    /**
     * 验证是否有正确的邮箱格式
     * 
     * @param  string  $value [description]
     * @return boolean        [description]
     */
    public static function isValidEmail($value) {
        $result = false;
        if (!empty($value)) {
            $result = (bool) preg_match('/(\,|^)([\w+._]+@\w+\.(\w+\.){0,3}\w{2,4})/i', $value);
        }

        return $result;
    }
    
    
    /**
     * 验证是否有正确的身份证号
     * 
     * @param  string  $idCard [description]
     * @return boolean        [description]
     */
    public static function isValidateIdCard($idCard) {
        //15位和18位身份证号码的正则表达式
        $regIdCard = '/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/';
        //回调信息
        $msg = '';
        $result = false;
        //如果通过该验证，说明身份证格式正确，但准确性还需计算
        if (preg_match($regIdCard, $idCard)) {
            if (strlen($idCard) == 18) {
                $idCardWi = Array('7', '9', '10', '5', '8', '4', '2', '1', '6', '3', '7', '9', '10', '5', '8', '4', '2'); //将前17位加权因子保存在数组里
                $idCardY = Array('1', '0', '10', '9', '8', '7', '6', '5', '4', '3', '2'); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
                $idCardWiSum = 0; //用来保存前17位各自乖以加权因子后的总和
                for ($i = 0; $i < 17; $i++) {
                    $idCardWiSum += substr($idCard, $i, 1) * $idCardWi[$i];
                }
                
                $idCardMod = $idCardWiSum % 11; //计算出校验码所在数组的位置
                $idCardLast = substr($idCard, 17, 1); //得到最后一位身份证号码
                
                //如果等于2，则说明校验码是10，身份证号码最后一位应该是X
                if ($idCardMod == 2) {
                    if ($idCardLast == "X" || $idCardLast == "x") {
                        $result = true;
                    }
                } else {
                    //用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
                    if ($idCardLast == $idCardY[$idCardMod]) {
                        $result = true;
                    } 
                }
            }
        }
        
        return $result;
    }

}
