<?php

/**
 * 畅卓短信平台models
 * 
 * @author guguanghai
 * @date 2015/08/10
 *
 */
class SmsDataService{

    const SMS_VENDOR = 'chanzor';
        /**
         * 发送验证码
         * 
         * @param  string $phone     手机号
         * @param  string $zoneCode  地区编号
         * @return boolean           发送成功或是失败
         */
        public static function sendVerifyCode($phone, $zoneCode = '86') {
            // 验证码
            $verify_code = SmsManagerFactory::generateVerifyCode($phone);
    
            // 拼装模板
            $content = "新奇世界注册验证码{$verify_code}，请完成注册，如非本人操作，请忽略本短信。";

            $objSmsManager = new SmsManagerFactory(self::SMS_VENDOR);
            
            $res = $objSmsManager->sendSMS( $phone, $content );
            
            if($res['returnstatus']=='Success'){
                return true;
            }else{
                return fasle;
            }
        }

        /**
         * 校验验证码是否有效
         * 
         * @param  string $phone      手机号
         * @param  string $verifyCode 用户获取的验证码
         * @param  string $zoneCode   地区编号
         * @return array              验证成功或失败
         */
        public static function verify($phone, $verifyCode, $zoneCode = '86') {
        // 校验验证码
            $check_result = SmsManagerFactory::checkVerifyCode($phone, $verifyCode);
    
            // 根据状态
            if ($check_result) {
                $result['code'] = '200';
                $result['msg'] = '验证成功';
            } else {
                $result['code'] = '520';
                $result['msg'] = '验证码无效';
            }
            
            return $result;
        }
        
        //注册发默认密码
        public static function sendPassword($mobile,$pwd){
            
            $content = "您已经是新奇世界的会员，默认密码为{$pwd},请及时登录修改密码";
            $objSmsManager = new SmsManagerFactory(self::SMS_VENDOR);

            $res = $objSmsManager->sendSMS($mobile, $content);
            
        }

}
