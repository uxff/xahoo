<?php


class Tools  {
    
    static protected $_holidays  = array(
                            '2015-01-01',
                            '2016-01-01',
                        );
    static protected $_weekends = array(0, 6);
   
    static public function getWeekdays($date,$pos=7,$fmt='Y-m-d') { 
        if( !$date ){
            return false;
        }
        
        date_default_timezone_set('Asia/Shanghai');
        $all = abs($pos);
        $out = array();
        for($i=1;$i<=$all;$i++){
          $nextDay = $pos>0 ? strtotime($date) + 86400*$i : strtotime($date) - 86400*$i ;
          if( in_array(date('w',$nextDay),self::$_weekends) || in_array($date,self::$_holidays)){
              $all++;
              continue;
          }
          $out[] = date($fmt,$nextDay);  
        }
        
        return $out;
        
    }
    
    static public function workDayDiff($start_datetime, $end_datetime) {
        $second_diff = strtotime($end_datetime) - strtotime($start_datetime);
        $start_date = date('Y-m-d', strtotime($start_datetime));
        $end_date = date('Y-m-d', strtotime($end_datetime));
        $cur_date = $start_date;
        
        while ($cur_date <= $end_date) {
            if (!self::isWorkday($cur_date)) {
                if ($cur_date == $start_date) {
                    $second_diff -= strtotime(self::nextDate($start_date, '+1 day', 'Y-m-d 00:00:00')) - strtotime($start_datetime);
                } else if ($cur_date == $end_date) {
                    $second_diff -= strtotime($end_datetime) - strtotime($end_date.' 00:00:00');
                } else {
                    $second_diff -= 3600 * 24;
                }
            }
            
            $cur_date = self::nextDate($cur_date, '+1 day');
        }

        return $second_diff;
    }
    
    static public function isWorkday($date) {
        return !self::isHoliday($date) && !self::isWeekend($date);
    }
    
    static public function isHoliday($date) {
        return in_array(date('Y-m-d', strtotime($date)), self::$_holidays);
    }
    
    static public function isWeekend($date) {
        return in_array(date('w', strtotime($date)), self::$_weekends);
    }
    
    static public function nextDate($date, $interval, $format = 'Y-m-d') {
        $result = date($format, strtotime($interval, strtotime($date)));
        return $result;
    }

    // 隐藏手机号中间4位
    static public function miscMobile($mobile) {
        if (!empty($mobile) && strlen($mobile)>=11) {
            $mobile = substr($mobile, 0, 3).'****'.substr($mobile, -4);
        }
        return $mobile;
    }
    // 隐藏身份证号中间的几位
    static public function miscCivilId($str) {
        if (!empty($str) && strlen($str)>=11) {
            $str = substr($str, 0, 5).'*******'.substr($str, -4);
        }
        return $str;
    }

    // 将金额转成大写 $ns= 1111.22
    static public function cny($ns) { 
        static $cnums=array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖'), 
            $cnyunits=array('圆','角','分'), 
            $grees=array('拾','佰','仟','万','拾','佰','仟','亿'); 
        list($ns1,$ns2)=explode('.',$ns,2); 
        $ns2=array_filter(array($ns2[1],$ns2[0])); 
        $ret=array_merge($ns2,array(implode('',self::_cny_map_unit(str_split($ns1),$grees)),'')); 
        $ret=implode('',array_reverse(self::_cny_map_unit($ret,$cnyunits))); 
        return str_replace(array_keys($cnums),$cnums,$ret); 
    }
    static protected function _cny_map_unit($list,$units) { 
        $ul=count($units); 
        $xs=array(); 
        foreach (array_reverse($list) as $x) { 
            $l=count($xs); 
            if ($x!='0' || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]); 
            else $n=is_numeric($xs[0][0])?$x:''; 
            array_unshift($xs,$n); 
        } 
        return $xs; 
    }
    /** 
    *数字金额转换成中文大写金额的函数 
    *String Int  $num  要转换的小写数字或小写字符串 
    *return 大写字母 
    *小数位为两位 
    **/  
    static public function convertToCny($num){  
        $c1 = "零壹贰叁肆伍陆柒捌玖";  
        $c2 = "分角元拾佰仟万拾佰仟亿";  
        $num = round($num, 2);  
        $num = $num * 100;  
        if (strlen($num) > 12) {  
            return "数据太长，没有这么大的钱吧，检查下";  
        }   
        $i = 0;  
        $c = "";  
        while (1) {  
            if ($i == 0) {  
                $n = substr($num, strlen($num)-1, 1);  
            } else {  
                $n = $num % 10;  
            }   
            $p1 = substr($c1, 3 * $n, 3);  
            $p2 = substr($c2, 3 * $i, 3);  
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {  
                $c = $p1 . $p2 . $c;  
            } else {  
                $c = $p1 . $c;  
            }   
            $i = $i + 1;  
            $num = $num / 10;  
            $num = (int)$num;  
            if ($num == 0) {  
                break;  
            }   
        }  
        $j = 0;  
        $slen = strlen($c);  
        while ($j < $slen) {  
            $m = substr($c, $j, 6);  
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {  
                $left = substr($c, 0, $j);  
                $right = substr($c, $j + 3);  
                $c = $left . $right;  
                $j = $j-3;  
                $slen = $slen-3;  
            }   
            $j = $j + 3;  
        }   
  
        if (substr($c, strlen($c)-3, 3) == '零') {  
            $c = substr($c, 0, strlen($c)-3);  
        }  
        if (empty($c)) {  
            return "零元整";  
        }else{  
            return $c . "整";  
        }  
    }
    /*
    检查手机号码前三位是否属于合法运营商
    @return 0=不合法号码 1=中国移动 2=中国联通 3=中国电信 4=其他
    */
    static public function checkPhoneNumber($phoneNumber) {
        $numberPrefix = substr($phoneNumber, 0, 3);
        if (empty($numberPrefix)) {
            return false;
        }
        $telType = 0;
        //$isChinaMobile   = '/^134[0-8]\d{7}$|^(?:13[5-9]|147|15[0-27-9]|178|18[2-478])\d{8}$/'; //移动方面最新答复
        //$isChinaUnion    = '/^(?:13[0-2]|145|15[56]|176|18[56])\d{8}$/'; //向联通微博确认并未回复
        //$isChinaTelcom   = '/^(?:133|153|177|18[019])\d{8}$/'; //1349号段 电信方面没给出答复，视作不存在
        //$isOtherTelphone = '/^170([059])\d{7}$/';//其他运营商
        //if (preg_match($isChinaMobile, $numberPrefix)) {
        //    $telType = 1;
        //} else if (preg_match($isChinaUnion, $numberPrefix)) {
        //    $telType = 2;
        //} else if (preg_match($isChinaTelcom, $numberPrefix)) {
        //    $telType = 3;
        //}
        static $arr = array(
            1 => array(134,135,136,137,138,139,150,151,152,158,159,157,187,188,147,178,170),
            2 => array(130,131,132,155,156,185,186,145,176,185,170),
            3 => array(133,153,180,181,189,177,170),
        );
        foreach ($arr as $telTypeEnum=>$arrPrefix) {
            if (in_array($numberPrefix, $arrPrefix)) {
                $telType = $telTypeEnum;
                break;
            }
        }
        return $telType;
    }
    /*
        获取客户端ip
            不可再iis下工作
    */
    static public function getUserHostAddress() {
        switch (true) {
            case isset($_SERVER["HTTP_X_FORWARDED_FOR"]):
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                break;
            case isset($_SERVER["HTTP_CLIENT_IP"]):
                $ip = $_SERVER["HTTP_CLIENT_IP"];
                break;
            default:
                $ip = $_SERVER["REMOTE_ADDR"] ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';
        }
        if (strpos($ip, ', ') > 0) {
            $ips = explode(', ', $ip);
            $ip = $ips[0];
        }
        return $ip;
    }
	
	/**
     * 用 mb_strimwidth 来截取字符，使中英尽量对齐。
     *
     * @param string $str
     * @param int $start
     * @param int $width
     * @param string $trimmarker
     * @return string
     */
    public static function wsubstr($str, $start, $width, $trimmarker = '...') {
        $_encoding = mb_detect_encoding($str, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        $_encoding = $_encoding ? $_encoding : 'UTF-8';
        return mb_strimwidth($str, $start, $width, $trimmarker, $_encoding);
    }
}


