<?php

/*
    geo 经纬度转换器
    依赖于Http
    使用百度接口 
    说明：http://lbsyun.baidu.com/index.php?title=webapi/guide/webservice-geocoding
    接口实例：
    http://api.map.baidu.com/geocoder/v2/?ak=E328e1bdf8aaa049d425b31894dffff4&location=39.983424,116.322987&output=json&pois=1
    
    
*/

class GeoConvertor {
   
    const URI_GEOCODER = '/geocoder/v2/';
    const API_HOST = 'http://api.map.baidu.com';
    const DEFAULT_OUTPUT = 'json';
    
    // 将经纬度转换为地址 使用百度api
    static public function LocationToAddr($lat, $long) {
        //$apiUrl = 'http://api.map.baidu.com/geocoder/v2/?ak=E328e1bdf8aaa049d425b31894dffff4&location='.$lat.','.$long.'&output=json&pois=1';
        //$apiUrl = self::API_HOST.URI_GEOCODER;
        //$ret = Http::http_get($apiUrl);
        //return @json_decode($ret, true);

        // use config
        $ak = Yii::app()->params['bdlbs']['ak'];//self::API_AK;
        $sk = Yii::app()->params['bdlbs']['sk'];//self::API_SK;

        // use ak+sn request
        $url = self::API_HOST.self::URI_GEOCODER.'?location=%s&output=%s&ak=%s&sn=%s';

        $params = [
            'location' => $lat.','.$long,
            'output' => self::DEFAULT_OUTPUT,
            'ak' => $ak,
        ];

        $sn = self::caculateAKSN($ak, $sk, self::URI_GEOCODER, $params);
        $targetUrl = sprintf($url, urlencode($lat.','.$long), self::DEFAULT_OUTPUT, $ak, $sn);

        Yii::log('target url='.$targetUrl, 'warning', __METHOD__);

        $ret = Http::http_get($targetUrl);
        return @json_decode($ret, true);
    }


    /**
     * [GetAddress description] 处理地址精确到
     * @param string $str [description]
     */
    static public function GetAddress($str = ''){
        if($str == ''){
            return;
        }
        $province_str = '';
        $provinces = array('河北','山西','辽宁','吉林','黑龙江','江苏','浙江','安徽','福建','江西','山东','河南','湖北','湖南','广东','海南','四川','贵州','云南','陕西','甘肃','青海','台湾','北京','天津','上海','重庆','内蒙古自治区','广西壮族自治区','宁夏回族自治区','新疆维吾尔自治区','西藏自治区','香港特别行政区','澳门特别行政区');
        foreach ($provinces as $k => $v) {
            if(strstr($str,$provinces[$k])){
               $province_str = $provinces[$k];
               return $province_str;
            }
        }
    }

    // api use sn
    static function caculateAKSN($ak, $sk, $url, $querystring_arrays, $method = 'GET')     {  
        if ($method === 'POST'){  
            ksort($querystring_arrays);  
        }  
        $querystring = http_build_query($querystring_arrays);  
        return md5(urlencode($url.'?'.$querystring.$sk));  
    }
}
