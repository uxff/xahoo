<?php
/**
 * 百度地图API
 * 方法类
 *
 * @author liutao@fangfull.com
 * @date 2014/11/11 09:53:50
 */

class AresBaiduMapApiUtil {

    //API控制台申请得到的ak（此处ak值仅供验证参考使用）
    const BD_MAP_API_AK = 'nVxoro8aoNXBZLqbfmGRHIlc';
     
    //应用类型为for server, 请求校验方式为sn校验方式时，系统会自动生成sk，可以在应用配置-设置中选择Security Key显示进行查看（此处sk值仅供验证参考使用）
    const BD_MAP_API_SK = 'eoIGxEk9yccFhUeaEydP60LiOMksG7zV';
     
    //百度地图API服务器
    const BD_MAP_API_ENDPOINT = 'http://api.map.baidu.com';

    //坐标转换服务
    const BD_MAP_API_GEOCONV_URI = '/geoconv/v1/';
     
    //Geocoding地址/逆地址转换服务
    const BD_MAP_API_GEOCODER_URI = '/geocoder/v2/';

    //Place Suggestion服务
    const BD_MAP_API_PLACE_SUGGESTION_URI = '/place/v2/suggestion';   
   
    //IP定位服务
    const BD_MAP_API_LOCATION_IP_URI = '/location/ip';  

    //地理编码的请求output参数
    const BD_MAP_API_OUTPUT_JSON = 'json';


    /**
     *  计算两点距离
     * @param  float $fP1Lat   点1纬度
     * @param  float $fP1Lng   点1经度
     * @param  float $fP2Lat   点2纬度
     * @param  float $fP2Lng   点1经度
     * @return float           距离，单位m
     */
    public static function calculateDistance($fP1Lat, $fP1Lng, $fP2Lat, $fP2Lng) {
        $fEARTH_RADIUS = 6378137;
        //角度换算成弧度
        $fRadLng1 = deg2rad($fP1Lng);
        $fRadLng2 = deg2rad($fP2Lng);
        $fRadLat1 = deg2rad($fP1Lat);
        $fRadLat2 = deg2rad($fP2Lat);
        //计算经纬度的差值
        $fD1 = abs($fRadLat1 - $fRadLat2);
        $fD2 = abs($fRadLng1 - $fRadLng2);
        //距离计算
        $fP = pow(sin($fD1/2), 2) +
              cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
        return floatval($fEARTH_RADIUS * 2 * asin(sqrt($fP)));
    }

    /**
     * GPS坐标转换为百度坐标
     * 
     * @param  float $lng  经度(GPS)
     * @param  float $lat  纬度(GPS)
     * @return array       百度坐标
     */
    public static function connvertToBaiduLngLat($lng, $lat) {
        $result = array();

        if (!empty($lat) && !empty($lng)) {

            // 构造请求URL格式
            $urlFormat = self::BD_MAP_API_ENDPOINT;
            $urlFormat .= self::BD_MAP_API_GEOCONV_URI;
            $urlFormat .= "?coords=%s&from=1&to=5&output=%s&ak=%s&sn=%s";
            
            // 构造请求串数组
            $querystring_arrays = array (
                'coords' => $lng.','.$lat,
                'from' => 1,
                'to' => 5,
                'output' => self::BD_MAP_API_OUTPUT_JSON,
                'ak' => self::BD_MAP_API_AK,
            );
             
            // 调用sn计算函数，默认get请求
            $sn = self::_caculateAKSN(self::BD_MAP_API_AK, self::BD_MAP_API_SK, self::BD_MAP_API_GEOCONV_URI, $querystring_arrays);
             
            // 请求参数中有中文、特殊字符等需要进行urlencode，确保请求串与sn对应
            $url = sprintf($urlFormat, urlencode($lng.','.$lat), self::BD_MAP_API_OUTPUT_JSON, self::BD_MAP_API_AK, $sn);

            // 发起REST请求
            $restRes = self::_doRestGet($url);

            // 解析response
            if ($restRes['status'] == 0 && !empty($restRes['result'][0])) {
                $result['lng'] = $restRes['result'][0]['x'];
                $result['lat'] = $restRes['result'][0]['y'];
            } else {
                $result['lng'] = 0;
                $result['lat'] = 0;
            }

        }

        return $result;
    }

    /**
     * 根据地址获取经纬度
     * 
     * @param  string $address 地址信息
     * @param  string $city    城市名
     * @return array           经纬度数组
     */
    public static function getLngLatFromAddress($address, $city='') {
        $result = array();

        if (!empty($address)) {

            // 构造请求URL格式
            $urlFormat = self::BD_MAP_API_ENDPOINT;
            $urlFormat .= self::BD_MAP_API_GEOCODER_URI;
            $urlFormat .= "?address=%s&output=%s&ak=%s&sn=%s";
            
            // 构造请求串数组
            $querystring_arrays = array (
                'address' => $address,
                'output' => self::BD_MAP_API_OUTPUT_JSON,
                'ak' => self::BD_MAP_API_AK,
            );
             
            // 调用sn计算函数，默认get请求
            $sn = self::_caculateAKSN(self::BD_MAP_API_AK, self::BD_MAP_API_SK, self::BD_MAP_API_GEOCODER_URI, $querystring_arrays);
             
            // 请求参数中有中文、特殊字符等需要进行urlencode，确保请求串与sn对应
            $url = sprintf($urlFormat, urlencode($address), self::BD_MAP_API_OUTPUT_JSON, self::BD_MAP_API_AK, $sn);

            // 发起REST请求
            $restRes = self::_doRestGet($url);

            // 解析response
            if ($restRes['status'] == 0 && !empty($restRes['result']['location'])) {
                $result['lng'] = $restRes['result']['location']['lng'];
                $result['lat'] = $restRes['result']['location']['lat'];
            } else {
                $result['lng'] = 0;
                $result['lat'] = 0;
            }

        }

        return $result;
    }

    /**
     * 根据经纬度获取地址
     *
     * @param  float  $lat 纬度坐标
     * @param  float  $lng 经度坐标
     * @return array       地址数据
     */
    public static function getAddressFromLatLng($lat, $lng) {
        $result = array();

        if (!empty($lat) && !empty($lng)) {

            // 构造请求URL格式
            $urlFormat = self::BD_MAP_API_ENDPOINT;
            $urlFormat .= self::BD_MAP_API_GEOCODER_URI;
            $urlFormat .= "?location=%s&output=%s&ak=%s&sn=%s";
            
            // 构造请求串数组
            $querystring_arrays = array (
                'location' => $lat.','.$lng,
                'output' => self::BD_MAP_API_OUTPUT_JSON,
                'ak' => self::BD_MAP_API_AK,
            );
             
            // 调用sn计算函数，默认get请求
            $sn = self::_caculateAKSN(self::BD_MAP_API_AK, self::BD_MAP_API_SK, self::BD_MAP_API_GEOCODER_URI, $querystring_arrays);
             
            // 请求参数中有中文、特殊字符等需要进行urlencode，确保请求串与sn对应
            $url = sprintf($urlFormat, urlencode($lat.','.$lng), self::BD_MAP_API_OUTPUT_JSON, self::BD_MAP_API_AK, $sn);

            // 发起REST请求
            $restRes = self::_doRestGet($url);
            // 解析response
            if ($restRes['status'] == 0 && !empty($restRes['result'])) {
                $result = $restRes['result'];
            } else {
                $result = array();
            }
            
        }

        return $result;
    }

    /**
     * 获取地址建议雷彪
     * 
     * @param  string  $query 输入关键字
     * @return array          建议地点列表
     */
    public static function getPlaceSuggestion($query, $region='') {
        $result = array();

        if (!empty($query)) {

            // 构造请求URL格式
            $urlFormat = self::BD_MAP_API_ENDPOINT;
            $urlFormat .= self::BD_MAP_API_PLACE_SUGGESTION_URI;
            $urlFormat .= "?query=%s&region=%s&output=%s&ak=%s&timestamp=%s&sn=%s";
            
            $timestamp = time();

            // 构造请求串数组
            $querystring_arrays = array (
                'query' => $query,
                'region' => $region,
                'output' => self::BD_MAP_API_OUTPUT_JSON,
                'ak' => self::BD_MAP_API_AK,
                'timestamp' => $timestamp,
            );
             
            // 调用sn计算函数，默认get请求
            $sn = self::_caculateAKSN(self::BD_MAP_API_AK, self::BD_MAP_API_SK, self::BD_MAP_API_PLACE_SUGGESTION_URI, $querystring_arrays);
             
            // 请求参数中有中文、特殊字符等需要进行urlencode，确保请求串与sn对应
            $url = sprintf($urlFormat, urlencode($query), urlencode($region), self::BD_MAP_API_OUTPUT_JSON, self::BD_MAP_API_AK, $timestamp, $sn);

            // 发起REST请求
            $restRes = self::_doRestGet($url);

            // 解析response
            if ($restRes['status'] == 0 && !empty($restRes['result'])) {
                $result = $restRes['result'];
            } else {
                $result = array();
            }
            
        }

        return $result;
    }


    /**
     * 转换百度地图城市ID为Ares系统城市ID
     *
     * @param integer $bd_city_id  百度
     * 
     * @return [type] [description]
     */
    public static function convertBaiduCityIdToAresCityId($bd_city_id) {
        $mapping = array(
            '100' => '26001' , //拉萨市
            '101' => '26005' , //那曲地区
            '102' => '26004' , // 日喀则地区
            '103' => '26006' , // 阿里地区
            '104' => '25001' , // 昆明市
            '105' => '25009' , // 楚雄彝族自治州
            '106' => '25003' , // 玉溪市
            '107' => '25010' , // 红河哈尼族彝族自治州
            '108' => '25007' , // 普洱市
            '109' => '25012' , // 西双版纳傣族自治州
            '110' => '25008' , // 临沧市
            '111' => '25013' , // 大理白族自治州
            '112' => '25004' , // 保山市
            '113' => '25015' , // 怒江傈僳族自治州
            '114' => '25006' , // 丽江市
            '115' => '25016' , // 迪庆藏族自治州
            '116' => '25014' , // 德宏傣族景颇族自治州
            '117' => '28007' , // 张掖市
            '118' => '28006' , // 武威市
            '119' => '19017' , // 东莞市
            '120' => '19005', // 东沙群岛.汕头
            '121' => '21002', // 三亚市
            '122' => '17006', // 鄂州市
            '123' => '5003', // 乌海市
            '124' => '15012', // 莱芜市
            '125' => '21001', // 海口市
            '126' => '12003', // 蚌埠市
            '1277' => '16008', // 济源市
            '127' => '12001', // 合肥市
            '128' => '12011', // 阜阳市
            '129' => '12002', // 芜湖市
            '130' => '12008', // 安庆市
            '131' => '1', // 北京市
            '132' => '22', // 重庆市
            '133' => '13007', // 南平市
            '134' => '13005', // 泉州市
            '135' => '28010', // 庆阳市
            '136' => '28011', // 定西市
            '137' => '19002', // 韶关市
            '138' => '19006', // 佛山市
            '139' => '19009', // 茂名市
            '140' => '19004', // 珠海市
            '141' => '19012', // 梅州市
            '142' => '20003', // 桂林市
            '143' => '20012', // 河池市
            '144' => '20014', // 崇左市
            '145' => '20007', // 钦州市
            '146' => '24001', // 贵阳市
            '147' => '24002', // 六盘水市
            '148' => '3003', // 秦皇岛市
            '149' => '3009', // 沧州市
            '150' => '3001', // 石家庄市
            '151' => '3004', // 邯郸市
            '152' => '16007', // 新乡市
            '153' => '16003', // 洛阳市
            '154' => '16014', // 商丘市
            '155' => '16010', // 许昌市
            '156' => '17005', // 襄樊市
            '157' => '17009', // 荆州市
            '158' => '18001', // 长沙市
            '159' => '18004', // 衡阳市
            '160' => '10011', // 镇江市
            '161' => '10006', // 南通市
            '162' => '10008', // 淮安市
            '163' => '14001', // 南昌市
            '164' => '14005', // 新余市
            '165' => '7005', // 通化市
            '166' => '6007', // 锦州市
            '167' => '6002', // 大连市
            '168' => '5009', // 乌兰察布市
            '169' => '5008', // 巴彦淖尔市
            '170' => '27005', // 渭南市
            '171' => '27003', // 宝鸡市
            '172' => '15004', // 枣庄市
            '173' => '15011', // 日照市
            '174' => '15005', // 东营市
            '175' => '15010', // 威海市
            '176' => '4001', // 太原市
            '177' => '25011', // 文山壮族苗族自治州
            '178' => '11003', // 温州市
            '179' => '11001', // 杭州市
            '180' => '11002', // 宁波市
            '181' => '30005', // 中卫市
            '182' => '28013', // 临夏回族自治州
            '183' => '7004', // 辽源市
            '184' => '6004', // 抚顺市
            '185' => '23019', // 阿坝藏族羌族自治州
            '186' => '23013', // 宜宾市
            '187' => '19018', // 中山市
            '188' => '12015', // 亳州市
            '189' => '12010', // 滁州市
            '190' => '12017', // 宣城市
            '191' => '3010', // 廊坊市
            '192' => '13009', // 宁德市
            '193' => '13008', // 龙岩市
            '194' => '13002', // 厦门市
            '195' => '13003', // 莆田市
            '196' => '28005', // 天水市
            '197' => '19016', // 清远市
            '198' => '19008', // 湛江市
            '199' => '19015', // 阳江市
            '200' => '19014', // 河源市
            '201' => '19019', // 潮州市
            '202' => '20013', // 来宾市
            '203' => '20010', // 百色市
            '204' => '20006', // 防城港市
            '205' => '24005', // 铜仁地区
            '206' => '24007', // 毕节地区
            '207' => '3008', // 承德市
            '208' => '3011', // 衡水市
            '209' => '16009', // 濮阳市
            '210' => '16002', // 开封市
            '211' => '16008', // 焦作市
            '212' => '16012', // 三门峡市
            '213' => '16004', // 平顶山市
            '214' => '16015', // 信阳市
            '215' => '16006', // 鹤壁市
            '216' => '17003', // 十堰市
            '217' => '17007', // 荆门市
            '218' => '17001', // 武汉市
            '219' => '18007', // 常德市
            '220' => '18006', // 岳阳市
            '221' => '18013', // 娄底市
            '222' => '18002', // 株洲市
            '223' => '10009', // 盐城市
            '224' => '10005', // 苏州市
            '225' => '14002', // 景德镇市
            '226' => '14010', // 抚州市
            '227' => '6005', // 本溪市
            '228' => '6011', // 盘锦市
            '229' => '5002', // 包头市
            '230' => '5012', // 阿拉善盟
            '231' => '27008', // 榆林市
            '232' => '27002', // 铜川市
            '233' => '27001', // 西安市
            '234' => '15013', // 临沂市
            '235' => '15016', // 滨州市
            '236' => '15002', // 青岛市
            '237' => '4006', // 朔州市
            '238' => '4007', // 晋中市
            '239' => '23017', // 巴中市
            '240' => '23006', // 绵阳市
            '241' => '23014', // 广安市
            '242' => '23018', // 资阳市
            '243' => '11008', // 衢州市
            '244' => '11010', // 台州市
            '245' => '11009', // 舟山市
            '246' => '30004', // 固原市
            '247' => '28014', // 甘南藏族自治州
            '248' => '23009', // 内江市
            '249' => '25002', // 曲靖市
            '250' => '12004', // 淮南市
            '251' => '12013', // 巢湖市
            '252' => '12009', // 黄山市
            '253' => '12006', // 淮北市
            '254' => '13004', // 三明市
            '255' => '13006', // 漳州市
            '256' => '28012', // 陇南市
            '257' => '19001', // 广州市
            '258' => '19021', // 云浮市
            '259' => '19020', // 揭阳市
            '260' => '20011', // 贺州市
            '261' => '20001', // 南宁市
            '262' => '24003', // 遵义市
            '263' => '24004', // 安顺市
            '264' => '3007', // 张家口市
            '265' => '3002', // 唐山市
            '266' => '3005', // 邢台市
            '267' => '16005', // 安阳市
            '268' => '16001', // 郑州市
            '269' => '16017', // 驻马店市
            '270' => '17004', // 宜昌市
            '271' => '17010', // 黄冈市
            '272' => '18009', // 益阳市
            '273' => '18005', // 邵阳市
            '274' => '18014', // 湘西土家族苗族自治州
            '275' => '18010', // 郴州市
            '276' => '10012', // 泰州市
            '277' => '10013', // 宿迁市
            '278' => '14009', // 宜春市
            '279' => '14006', // 鹰潭市
            '280' => '6013', // 朝阳市
            '281' => '6008', // 营口市
            '282' => '6006', // 丹东市
            '283' => '5006', // 鄂尔多斯市
            '284' => '27006', // 延安市
            '285' => '27010', // 商洛市
            '286' => '15008', // 济宁市
            '287' => '15007', // 潍坊市
            '288' => '15001', // 济南市
            '289' => '9', // 上海市
            '290' => '4005', // 晋城市
            '2911' => '34', // 澳门特别行政区
            '2912' => '33', // 香港特别行政区
            '291' => '23011', // 南充市
            '292' => '11011', // 丽水市
            '293' => '11006', // 绍兴市
            '294' => '11005', // 湖州市
            '295' => '20005', // 北海市
            '296' => '21001', // 海南省直辖县级行政单位
            '297' => '5004', // 赤峰市
            '298' => '12014', // 六安市
            '299' => '12016', // 池州市
            '300' => '13001', // 福州市
            '301' => '19011', // 惠州市
            '302' => '19007', // 江门市
            '303' => '19005', // 汕头市
            '304' => '20004', // 梧州市
            '305' => '20002', // 柳州市
            '306' => '24009', // 黔南布依族苗族自治州
            '307' => '3006', // 保定市
            '308' => '16016', // 周口市
            '309' => '16013', // 南阳市
            '310' => '17008', // 孝感市
            '311' => '17002', // 黄石市
            '312' => '18008', // 张家界市
            '313' => '18003', // 湘潭市
            '314' => '18011', // 永州市
            '315' => '10001', // 南京市
            '316' => '10003', // 徐州市
            '317' => '10002', // 无锡市
            '318' => '14008', // 吉安市
            '319' => '6014', // 葫芦岛市
            '320' => '6003', // 鞍山市
            '321' => '5001', // 呼和浩特市
            '322' => '30003', // 吴忠市
            '323' => '27004', // 咸阳市
            '324' => '27009', // 安康市
            '325' => '15009', // 泰安市
            '326' => '15006', // 烟台市
            '327' => '4011', // 吕梁市
            '328' => '4008', // 运城市
            '329' => '23007', // 广元市
            '330' => '23008', // 遂宁市
            '331' => '23004', // 泸州市
            '332' => '2', // 天津市
            '333' => '11007', // 金华市
            '334' => '11004', // 嘉兴市
            '335' => '30002', // 石嘴山市
            '336' => '25005', // 昭通市
            '337' => '12007', // 铜陵市
            '338' => '19010', // 肇庆市
            '339' => '19013', // 汕尾市
            '33' => '28002', // 嘉峪关市
            '340' => '19003', // 深圳市
            '341' => '20008', // 贵港市
            '342' => '24008', // 黔东南苗族侗族自治州
            '343' => '24006', // 黔西南布依族苗族自治州
            '344' => '16011', // 漯河市
            '345' => '17001', // 湖北省直辖县级行政单位
            '346' => '10010', // 扬州市
            '347' => '10007', // 连云港市
            '348' => '10004', // 常州市
            '349' => '14004', // 九江市
            '34' => '28003', // 金昌市
            '350' => '14003', // 萍乡市
            '351' => '6010', // 辽阳市
            '352' => '27007', // 汉中市
            '353' => '15017', // 菏泽市
            '354' => '15003', // 淄博市
            '355' => '4002', // 大同市
            '356' => '4004', // 长治市
            '357' => '4003', // 阳泉市
            '358' => '12005', // 马鞍山市
            '359' => '28008', // 平凉市
            '35' => '28004', // 白银市
            '360' => '30001', // 银川市
            '361' => '20009', // 玉林市
            '362' => '17011', // 咸宁市
            '363' => '18012', // 怀化市
            '364' => '14011', // 上饶市
            '365' => '14007', // 赣州市
            '366' => '15015', // 聊城市
            '367' => '4009', // 忻州市
            '368' => '4010', // 临汾市
            '369' => '23015', // 达州市
            '36' => '28001', // 兰州市
            '370' => '12012', // 宿州市
            '371' => '17012', // 随州市
            '372' => '15014', // 德州市
            '373' => '17013', // 恩施土家族苗族自治州
            '37' => '28009', // 酒泉市
            '38' => '8013', // 大兴安岭地区
            '39' => '8011', // 黑河市
            '40' => '8007', // 伊春市
            '41' => '8002', // 齐齐哈尔市
            '42' => '8008', // 佳木斯市
            '43' => '8004', // 鹤岗市
            '44' => '8012', // 绥化市
            '45' => '8005', // 双鸭山市
            '46' => '8003', // 鸡西市
            '47' => '8009', // 七台河市
            '48' => '8001', // 哈尔滨市
            '49' => '8010', // 牡丹江市
            '50' => '8006', // 大庆市
            '51' => '7008', // 白城市
            '52' => '7007', // 松原市
            '53' => '7001', // 长春市
            '54' => '7009', // 延边朝鲜族自治州
            '55' => '7002', // 吉林市
            '56' => '7003', // 四平市
            '57' => '7006', // 白山市
            '58' => '6001', // 沈阳市
            '59' => '6009', // 阜新市
            '60' => '6012', // 铁岭市
            '61' => '5007', // 呼伦贝尔市
            '62' => '5010', // 兴安盟
            '63' => '5011', // 锡林郭勒盟
            '64' => '5005', // 通辽市
            '65' => '29008', // 海西蒙古族藏族自治州
            '66' => '29001', // 西宁市
            '67' => '29003', // 海北藏族自治州
            '68' => '29005', // 海南藏族自治州
            '69' => '29002', // 海东地区
            '70' => '29004', // 黄南藏族自治州
            '71' => '29007', // 玉树藏族自治州
            '72' => '29006', // 果洛藏族自治州
            '73' => '23020', // 甘孜藏族自治州
            '74' => '23005', // 德阳市
            '75' => '23001', // 成都市
            '76' => '23016', // 雅安市
            '77' => '23012', // 眉山市
            '78' => '23002', // 自贡市
            '79' => '23010', // 乐山市
            '80' => '23021', // 凉山彝族自治州
            '81' => '23003', // 攀枝花市
            '82' => '31011', // 和田地区
            '83' => '31010', // 喀什地区
            '84' => '31009', // 克孜勒苏柯尔克孜自治州
            '85' => '31008', // 阿克苏地区
            '86' => '31007', // 巴音郭楞蒙古自治州
            '87' => '31001', // 新疆直辖县级行政单位
            '88' => '31006', // 博尔塔拉蒙古自治州
            '89' => '31003', // 吐鲁番地区
            '90' => '31012', // 伊犁哈萨克自治州
            '91' => '31004', // 哈密地区
            '92' => '31001', // 乌鲁木齐市
            '93' => '31005', // 昌吉回族自治州
            '94' => '31013', // 塔城地区
            '95' => '31002', // 克拉玛依市
            '96' => '31014', // 阿勒泰地区
            '97' => '26003', // 山南地区
            '98' => '26007', // 林芝地区
            '99' => '26002', // 昌都地区
        );
        
        return !empty($bd_city_id) ? intval($mapping[$bd_city_id]) : 0;
    }

    /**
     * 根据IP获取当前位置信息
     * 
     * @param  string $ip IP地址
     * @return array
     */
    public static function locateByIP($ip='') {
        $result = array();

        // ip为空，获取当前IP
        if (empty($ip)) {
               // 获取当前IP
            if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        }

        // 是否为内网地址
        $is_intenal_ip = self::_isInternalIp($ip);

        if (!$is_intenal_ip) {
            // 构造请求URL格式
            $urlFormat = self::BD_MAP_API_ENDPOINT;
            $urlFormat .= self::BD_MAP_API_LOCATION_IP_URI;
            $urlFormat .= "?ip=%s&coor=bd09ll&ak=%s&sn=%s";

            // 构造请求串数组
            $querystring_arrays = array (
                'ip' => $ip,
                'coor' => 'bd09ll',
                'ak' => self::BD_MAP_API_AK,
            );
             
            // 调用sn计算函数，默认get请求
            $sn = self::_caculateAKSN(self::BD_MAP_API_AK, self::BD_MAP_API_SK, self::BD_MAP_API_LOCATION_IP_URI, $querystring_arrays);
             
            // 请求参数中有中文、特殊字符等需要进行urlencode，确保请求串与sn对应
            $url = sprintf($urlFormat, $ip, self::BD_MAP_API_AK, $sn);

            // 发起REST请求
            $restRes = self::_doRestGet($url);

            // 解析response
            if ($restRes['status'] == 0) {
                $result['address'] = $restRes['address'];
                $result['city'] = $restRes['content']['address_detail']['city'];
                $result['city_id'] = $restRes['content']['address_detail']['city_code'];
                $result['lng'] = $restRes['content']['point']['x'];
                $result['lat'] = $restRes['content']['point']['y'];
            } else {
                $result['address'] = '';
                $result['city'] = '';
                $result['city_id'] = 0;
                $result['lng'] = 0;
                $result['lat'] = 0;
            }
        }

        return $result;
    }



    /*********** PRIVATE FUNCTIONS ***********/
    
    /**
     * 计算SN
     * 
     * @param  [type] $ak                 [description]
     * @param  [type] $sk                 [description]
     * @param  [type] $uri                [description]
     * @param  [type] $querystring_arrays [description]
     * @param  string $method             [description]
     * @return [type]                     [description]
     */
    private static function _caculateAKSN($ak, $sk, $uri, $querystring_arrays, $method = 'GET') {  
        if ($method === 'POST') {
            ksort($querystring_arrays);  
        }  
        $querystring = http_build_query($querystring_arrays);  
        return md5(urlencode($uri.'?'.$querystring.$sk));  
    }

    /**
     * 发起一个post请求到指定接口
     * 
     * @param string   $url       请求的接口
     * @param array    $params    post参数
     * @param array    $headers   http头新新
     * @param integer  $timeout   超时时间
     * @return string  请求结果
     */
    private static function _doRestGet($url) {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // 以返回的形式接收信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 设置为GET方式
        curl_setopt($ch, CURLOPT_POST, 0);
        // 不验证https证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // 设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, '30');
        // 设置头信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // 发送数据
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl URL: ' . $url . ' with POST error:' . curl_error($ch);
            return false;
        }

        // 解析json为数组
        $arrResult = json_decode($response, true);

        // 不要忘记释放资源
        curl_close($ch);

        return $arrResult;
    }


    /** 
     * 判断内网IP
     *
     * @param $ip
     *
     * @returns
     */
    private static function _isInternalIp($ip) {
        $ip = ip2long($ip);
        $net_l = ip2long('127.0.0.1'); //localhost
        $net_a = ip2long('10.255.255.255') >> 24; //A类网预留ip的网络地址
        $net_b = ip2long('172.31.255.255') >> 20; //B类网预留ip的网络地址
        $net_c = ip2long('192.168.255.255') >> 16; //C类网预留ip的网络地址

        return $ip === $net_l || $ip >> 24 === $net_a || $ip >> 20 === $net_b || $ip >> 16 === $net_c;
    }

}