<?php
/*
    @author: xdr
*/
class SmsHelper {
    
    /*
        判断手机号发送短信次数
    */
    static public function isCheatMobile($mobile, $max = 3) {
        $key = 'sms_times_'.$mobile;
        //$max = 3;
        $val = (int)Yii::app()->cache->get($key);
        $val = $val == 0 ? 1 : $val;
        $ret = false;
        // 超出次数
        if ($val>$max) {
            $ret = true;
        }
        $limit = 3600*24;//Yii::app()->params['reg_sms_limit_time']; 
        // 正常次数
        Yii::app()->cache->set($key, $val*1+1, $limit);

        return $ret;
    }
    /*
        判断ip发送短信次数
    */
    static public function isCheatIp($ip, $max = 5) {
        $key = 'sms_times_ip_'.$ip;
        //$max = 5;
        $val = (int)Yii::app()->cache->get($key);
        $val = $val == 0 ? 1 : $val;
        $ret = false;
        // 超出次数
        if ($val>$max) {
            $ret = true;
        }
        $limit = 3600*24;//Yii::app()->params['reg_sms_limit_time']; 
        // 正常次数
        Yii::app()->cache->set($key, $val*1+1, $limit);

        return $ret;
    }
    // for test
    /*
        @param $arr = ['ip'=>'1.3.54.5', 'mobile'=>'150xxxxxxxx']
    */
    public function clearCheats($arr) {
        $mobile = $arr['mobile'];
        $ip = $arr['ip'];
        if (!empty($mobile)) {
            $key = 'sms_times_'.$mobile;
            echo 'key('.$key.')='. Yii::app()->cache->get($key);
            echo ' ';
            Yii::app()->cache->set($key, 0, 0);
        }
        if (!empty($ip)) {
            $key = 'sms_times_ip_'.$ip;
            echo 'key('.$key.')='. Yii::app()->cache->get($key);
            echo ' ';
            Yii::app()->cache->set($key, 0, 0);
        }
        echo "done";
    }
}
