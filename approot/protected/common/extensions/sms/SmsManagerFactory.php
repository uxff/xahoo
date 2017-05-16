<?php
//加载类库
Yii::import("application.common.extensions.AresUtil");
Yii::import("application.common.extensions.AresLogManager");

/**
 * 短信发送
 */
class SmsManagerFactory {

    // 获取短信对象
    private $_objSmsManager = null;

    /**
     * 获取对象实例
     * @param  string $vendor 服务商
     * @param  array  $params 参数
     * @return object
     */
    public function __construct($vendor, $params) {
        $vendor = strtolower($vendor);
        $params = (array)$params;

        switch ($vendor) {
            case '33e9':
                Yii::import("application.common.extensions.sms.33e9.SmsManager");
                $this->_objSmsManager = new SmsManager($params);
                break;
            case 'chanzor':
                Yii::import("application.common.extensions.sms.chanzor.lib.SmsManager");
                $this->_objSmsManager = new SmsManager();
                break;
            case 'mob':
                Yii::import("application.common.extensions.sms.mob.SmsManager");
                $this->_objSmsManager = new SmsManager($params);
                break;            
            default:
                $this->_objSmsManager = null;
                break;
        }

    }


    /**
     * 发送短信
     * @param  [type] $phone   [description]
     * @param  [type] $content [description]
     * @param  [type] $params  [description]
     * @return [type]          [description]
     */
    public function sendSMS($phone, $content, $params=array()) {
        
        // 根据对象
        $result = $this->_objSmsManager->sendSMS($phone, $content);
        //
        return $result;
    }


    /**
     * 生成验证码
     * 
     * @param  string $phone     手机号
     * @param  string $zoneCode  地区编号
     * @return boolean           发送成功或是失败
     */
    public static function generateVerifyCode($phone, $zoneCode = '86') {
        // 生成随机码
        $verify_code = AresUtil::generateRandNum(1111, 9999);
        // 生成验证码验证key
        $verify_code_key = $phone.'_'.$verify_code.'_'.strtotime('+ 10 min', time());
        // 写入session
        Yii::app()->session['verify_code_key'] = $verify_code_key;
        
        return $verify_code;
    }

    /**
     * 校验验证码
     * 
     * @param  string $phone      手机号
     * @param  string $verifyCode 验证码
     * @param  string $zoneCode   地区编号
     * @return boolean
     */
    public static function checkVerifyCode($phone, $verifyCode, $zoneCode = '86') {
        // session中获取验证码key
        $verify_code_key = Yii::app()->session['verify_code_key'];
        $phone_code = $verify_code = $expire_time = null;
        if (!empty($verify_code_key)) {
            list($phone_code, $verify_code, $expire_time) = explode('_', $verify_code_key);
        }
        // 
        $isValidCode = false;
        if ($phone_code == $phone && $verify_code == $verifyCode && time() < $expire_time ) {
            $isValidCode = true;
        }

        return $isValidCode;
    }


}
?>