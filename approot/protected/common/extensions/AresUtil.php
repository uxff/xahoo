<?php
/**
 * 常用公共方法类
 *
 * @author liutao@fangfull.com
 * @date 2014/11/11 09:53:50
 */

class AresUtil {


    /**
     * 由plain生成密文密码
     * 
     * @param  string  $plain  明文密码
     * @param  boolean $hasMd5 明文是否MD5过, 主要考虑API回传密码为加密串
     * @return string          加密密文
     */
    public static function encryptPassword($plain, $hasMd5=false) {
        $seed = '';
        for ($i=0; $i < 10; $i++) {
            $seed .= self::generateRandNum();
        }

        $salt = substr(md5($seed), 0, 3);

        if ($hasMd5) {
            $encryptedPassword = md5($salt . $plain) . ':' . $salt;
        } else {
            $encryptedPassword = md5($salt . md5($plain)) . ':' . $salt;
        }

        return $encryptedPassword;
    }


    /**
     * 验证密码是否正确
     * 
     * @param  string  $plain     明文密码
     * @param  string  $encrypted 加密密文
     * @param  boolean $hasMd5    明文是否MD5过, 主要考虑API回传密码为加密串
     * @return boolean            true|false
     */
    public static function validatePassword($plain, $encrypted, $hasMd5=false) {
        $result = false;

        if (!empty($plain) && !empty($encrypted)) {
            // split encypted password into hash and salt
            $stack = explode(':', $encrypted);

            if ($hasMd5) {
                $result = ( md5($stack[1] . $plain) == $stack[0] ) ? true : false;
            } else {
                $result = ( md5($stack[1] . md5($plain)) == $stack[0] ) ? true : false;
            }
        }

        return $result;
    }


    /**
     * generate token string with salt and str by md5
     *
     * @param string $str
     * @param string $salt
     *
     * @return string  用salt加密后的字符串
     */
    public static function generateToken($str, $salt='ares-api') {
        //对key做加密处理
        if (empty($salt)) {
            $token_str = md5($str);
        } else {
            $token_str = md5($str.$salt);
        }
        //将md5后的字符串字母转为大写
        $token = strtoupper($token_str);

        return $token; 
    }

    /**
     * generate token string with salt and str by md5
     *
     * @param string $str
     * @param string $salt
     *
     * @return string  用salt加密后的字符串
     */
    public static function validateToken($source, $dest, $salt='ares-api') {
        
        $encrypted = self::generateToken($source, $salt);

        $result = ($encrypted === $dest) ? true : false;

        return $result;
    }

    /**
     * generate token string by base64
     * 
     * @param  string $str       [description]
     * @param  string $salt      [description]
     * @param  string $separator [description]
     * @return string            base64加密过的字符串
     */
    public static function generateBase64Token($str, $salt='ares-api', $separator=',') {

        // 参与加密的值
        $arrPlain[] = 'MTQxOTQxOTA';
        $arrPlain[] = $str;

        //对key做加密处理 
        if (empty($salt)) {
            $token = base64_encode(implode($separator, $arrPlain));
        } else {
            $arrPlain[] = $salt;
            $token = base64_encode(implode($separator, $arrPlain));
        }

        return $token;
    }

    /**
     * restore str from token by base64
     * 
     * @param  string $token     [description]
     * @param  string $salt      [description]
     * @param  string $separator [description]
     * @return string            base64解密后的原文
     */
    public static function restoreFromBase64Token($token, $salt='ares-api', $separator=',') {
        
        // 解密
        $decodedToken = base64_decode($token);
        
        // toArray
        $arrToken = explode($separator, $decodedToken);
        
        $plain = '';
        if (!empty($arrToken[1])) {
            $plain = intval($arrToken[1]);
        }

        return $plain;
    }

    /**
     * generate token string with salt and str
     *
     * @param string $str
     * @param string $salt
     *
     * @return string  用salt加密后的字符串
     */
    public static function generateAccessToken($str, $salt='ares-api') {
        //对key做加密处理
        if (empty($salt)) {
            $token_str = md5($str);
        } else {
            $token_str = md5($str.$salt);
        }
        //将md5后的字符串字母转为大写
        $token = strtoupper($token_str);

        return $token; 
    }


    /**
     * 生成随机整数
     * 
     * @param  mixed  $min  最小值
     * @param  mixed  $max  最大值
     * @return mixed        随机数
     */
    public static function generateRandNum($min=null, $max=null) {
        static $seeded;
        if (!isset($seeded)) {
            mt_srand((double)microtime() * 1000000);
            $seeded = true;
        }
        if (isset($min) && isset($max)) {
            if ($min >= $max) {
                return $min;
            } else {
                return mt_rand($min, $max);
            }
        } else {
            return mt_rand();
        }
    }


    /**
     * 
     * @param  string  $app_id [description]
     * @param  integer $length [description]
     * @return [type]          [description]
     */
    public static function generateRandomStr($length=32) {
        $random_str = '';
        
        // 随机字母数字串
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKMNOPQRSTUVWXYZ0123456789';
        $max = strlen($chars) - 1;
        // 播下一个更好的随机数发生器种子   
        mt_srand((double)microtime() * 1000000);
        
        // 随机生成
        for($i = 0; $i < $length; $i++) {
            $random_str .= $chars[mt_rand(0, $max)];
        }

        return $random_str;
    }

    /**
     * 根据参数中指定的fields，返回相应的result
     * 
     * @param array   $arrData
     * @param string  $fields
     * @param boolean $isSingleObject 是否单一对象，真返回单一json对象；否则返回json数字
     */
    public static function getSelectedResultByFields($arrData, $fields, $isSingleObject=false) {
        if (empty($arrData)) {
            $result = $arrData;
        }

        //取出指定的结果
        if (!empty($fields)) {
            foreach ($arrData as $key => $item) {
                $arrFields = array_fill_keys(explode(',', $fields), '');
                //returns an array containing all the entries of first argument which have keys that are present in second arguments
                $result[$key] = array_intersect_key($item, $arrFields);
            }
        } else {
            $result = $arrData;
        }

        //单一对象fields过滤，返回json对象而不是json数组
        if ($isSingleObject) {
            $result = $result[0];
        }

        return $result;
    }


    /**
     * 去除HTML标签
     * @param  string $str  
     * @return string
     */
    public static function stripTags($str) {
        $result = '';

        if (!empty($str)) {
            $result = str_replace('&nbsp;', ' ', $str);
            $result = htmlspecialchars_decode($result);
            $result = strip_tags($result);
        }

        return $result;
    }

    /**
     * 获取子串
     * @param  string   $str      [description]
     * @param  integer  $start    [description]
     * @param  integer  $length   [description]
     * @param  string   $encoding [description]
     * @return string           [description]
     */
    public static function mbSubStr($str, $start, $length, $encoding='utf-8') {
        $result = '';

        if (!empty($str)) {
            $result = mb_substr($str, $start, $length, $encoding);
        }

        // 增加省略号
        $realStrLength = mb_strlen($str, $encoding);
        if ($realStrLength > $length) {
            $result .= ' ...';
        }

        return $result;
    }

    /**
     * 获取绝对URL
     * NOTE：
     * 业务逻辑完全同CController->createAbsoluteUrl
     * 这里只是方便调用
     * 
     * @param  string $route     路由
     * @param  array  $params    参数列表
     * @param  string $schema    http/https
     * @param  string $ampersand 分隔符
     * @return string            绝对URL
     */
    public static function generateAbsoluteUrl($route, $params = array(), $schema = 'http', $ampersand = '&') {
        
        // 相对路径
        $url = Yii::app()->createUrl($route, $params, $ampersand);
        
        // 自动判断协议
        $schema = Yii::app()->getRequest()->getIsSecureConnection() ? 'https' : 'http';

        if (strpos($url, 'http') === 0) {
            return $url;
        }  else {
            return Yii::app()->getRequest()->getHostInfo($schema) . $url;
        }    
    }

    /**
     * 获取图片绝对URL
     * 
     * @param  string· $imgPath 图片相对路径
     * @return string           图片绝对路径
     */
    public static function generateImageUrl($imgPath) {
        $imgUrl = '';
        if (!empty($imgPath)) {
            $imgUrl = Yii::app()->getRequest()->getHostInfo('http') . $imgPath;
        }
        return $imgUrl;
    }

    /**
     * 获取webview绝对URL
     * 
     * @param  string·   $mainPage  页面类型
     * @param  array     $params    页面参数列表
     * @return string               webview绝对路径
     */
    public static function generateWebviewUrl($mainPage, $params=array()) {
        $webviewUrl = '';

        $route = '';
        $urlParams = array();
        if (!empty($mainPage)) {
            $route = 'webView/'.$mainPage;
        }
        if (!empty($params)) {
            $urlParams = $params;
        }

        // 生成URL
        if (!empty($route)) {
            $webviewUrl = Yii::app()->getRequest()->getHostInfo('http');
            $webviewUrl .= Yii::app()->createUrl($route, $urlParams);
        }
         

        //$webviewUrl = 'http://test.fangfull.com/site/inforcontent/id/83';
        return $webviewUrl;
    }

    /**
     * 获取分享绝对URL
     * NOTE： 使用配置文件中shareServerName，没有设置则使用当前host
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public static function generateShareUrl($route, $params=array()) {
        // 路由参数设置
        $urlRoute = '';
        $urlParams = array();
        if (!empty($route)) {
            $urlRoute = $route;
        }
        if (!empty($params)) {
            $urlParams = $params;
        }

        // 生成url
        $shareUrl = Yii::app()->params['shareServerName'];
        if (empty($shareUrl)) {
            $shareUrl = Yii::app()->getRequest()->getHostInfo('http');
            $shareUrl .= Yii::app()->createUrl($urlRoute, $urlParams);
        } else {
            //trim script url
            $shareUrl .= ltrim(Yii::app()->createUrl($urlRoute, $urlParams), Yii::app()->getRequest()->getScriptUrl());
        }

        return $shareUrl;
    }


    /**
     * 格式化货币，按照千分位符号分割
     * @param  float $price 价格
     * @param  integer $decimals 小数位数 
     * @return string
     * @todo   改为DB配置
     */
    public static function formatLocalPrice($price, $decimals=0) {
        $formatedPrice = '0';

        if (!empty($price)) {
            //print_r($price);
            $formatedPrice = number_format(floatval($price), intval($decimals), '.', ',');
        }

        return $formatedPrice;
    }
    

    /**
     * 格式化货币，按照万来格式化，最小为万
     * 
     * @param  float   $price    价格
     * @param  integer $decimals 小数位数 
     * @return string
     * @todo   改为DB配置
     */
    public static function formatChinesePrice($price, $decimals=0) {
        $formatedPrice = '0';

        if (!empty($price)) {
            $formatedPrice = number_format(round($price)/10000, intval($decimals), '.', ',');
            //$formatedPrice = number_format(round($price)/10000, 1, '.', '');
        }

        return $formatedPrice;
    }

    /**
     * 隐藏手机号中间四位
     * 
     * @param  string $phone 手机号
     * @return string        处理过的手机号
     */
    public static function formatChineseMobile($phone) {
        $formatedChineseMobile = '';

        if (!empty($phone)) {
            $formatedChineseMobile = substr_replace($phone, '****', 3, 4);
        }

        return $formatedChineseMobile;
    }

    /**
     * 生成验证码
     * 
     * @param  string  $str       原文
     * @param  string  $email     邮箱
     * @param  integer $timestamp 时间戳数值
     * @param  string  $salt      盐
     * @param  string  $separator 分隔符
     * @return string             验证码
     */
    public static function generateVerifyCode($str, $email, $timestamp=0, $salt='ares', $separator=',') {
        $verifyCode = '';
        if (!empty($str)) {
            $arrPlain[] = $str;
            $arrPlain[] = $email;
            $arrPlain[] = $timestamp;
            $arrPlain[] = $salt;
            
            $plain = implode($separator, $arrPlain);
            // base64编码
            $verifyCode = base64_encode($plain);
        }

        return $verifyCode;
    }

    /**
     * 解析验证码
     * 
     * @param  string $verifyCode 验证码原文
     * @param  string $salt       盐
     * @param  string $separator  分隔符
     * @return array              分割数组
     */
    public static function parseVerifyCode($verifyCode, $salt='ares', $separator=','){
        $result = array();

        if (!empty($verifyCode)) {
            // base64解密
            $plain = base64_decode($verifyCode);

            if ($plain) {
                $result = explode($separator, $plain);
            }
        }

        return $result;
    }

    /**
     * 判断访问设备是否为手机
     * 
     * @param  string  $userAgent UA字符串
     * @return boolean            true|false
     */
    public static function isMobileDevice($userAgent='') {
        $isMobileDevice = false;

        // TODO 完善匹配词库
        $mobileUserAgentRegex = 'android|iPhone|ipod|symbian|iemobile|htc|opera mini|opera mobile|blackberry|dolphin|micromessenger';
        // Escape the special character which is the delimiter.
        $mobileUserAgentRegex = str_replace('/', '\/', $mobileUserAgentRegex);
        
        // check
        if (!empty($userAgent)) {
            $isMobileDevice = (bool)preg_match('/'.$mobileUserAgentRegex.'/is', $userAgent);
        }

        return $isMobileDevice;
    }


    /**
     * 时间比较
     * $dayInterval = AresUtil::datatimeDiff('d', '2015-01-01 00:00:00', '2015-02-31 00:00:00');
     * 
     * @param string $part
     * @param string $begin
     * @param string $end
     */
    public static function datetimeDiff($part, $begin, $end) {
        $diff = strtotime($end) - strtotime($begin);
        
        $part = strtolower($part);
        switch($part) {
            // case "y": $retval = bcdiv($diff, (60 * 60 * 24 * 365)); break;
            // case "m": $retval = bcdiv($diff, (60 * 60 * 24 * 30)); break;
            // case "w": $retval = bcdiv($diff, (60 * 60 * 24 * 7)); break;
            // case "d": $retval = bcdiv($diff, (60 * 60 * 24)); break;
            // case "h": $retval = bcdiv($diff, (60 * 60)); break;
            // case "i": $retval = bcdiv($diff, 60); break;
            // case "s": $retval = $diff; break;
            case "y": $retval = round($diff / (60 * 60 * 24 * 365)); break;
            case "m": $retval = round($diff / (60 * 60 * 24 * 30)); break;
            case "w": $retval = round($diff / (60 * 60 * 24 * 7)); break;
            case "d": $retval = round($diff / (60 * 60 * 24), 2); break;
            case "h": $retval = round($diff / (60 * 60)); break;
            case "i": $retval = round($diff / 60); break;
            case "s": $retval = $diff; break;
            default: $retval = 0; break;
        }

        return $retval;
    }

    /**
     * 格式化订单Id
     * 
     * @param  string $orderID       订单ID
     * @param  string $datePurchased 购买日期
     * @param  string $prefix        订单前缀
     * @param  string $padLength     补位长度
     * @return string                页面显示的订单号
     */
    public static function formatDisplayOrderId($orderID='', $datePurchased='', $prefix='', $padLength=6) {
        if (empty($datePurchased)) {
            return $orderID;
        }

        // 时间前缀
        $datetimePrefix = '';
        if (!empty($datePurchased)) {
            $datetimePrefix = date('ymdHis', strtotime($datePurchased));
        }

        // 订单号站位
        $longOrderId = str_pad($orderID, $padLength, '0', STR_PAD_LEFT);

        // 显示长订单号
        $displayOrderId = '';
        if (!empty($prefix)) {
            $displayOrderId .= $prefix;
        }
        if (!empty($datetimePrefix)) {
            $displayOrderId .= $datetimePrefix;
        }
        $displayOrderId .= $longOrderId;

        return $displayOrderId;
    }

    /**
     * 格式化订单Id
     * 
     * @param  string $orderID       订单ID
     * @param  string $datePurchased 购买日期
     * @param  string $prefix        订单前缀
     * @param  string $padLength     补位长度
     * @return string                页面显示的订单号
     */
    public static function getOrderIdFromDisplayOrderId($displayOrderId, $padLength=6) {
        if (empty($displayOrderId)) {
            return '';
        }
        // 订单号站位
        $orderId = substr($displayOrderId, 0-$padLength);
        $orderId = intval($orderId);

        return $orderId;
    }


    /**
     * 格式化百分比，小数部分都为零则舍弃掉
     * 
     * @param  float      $percent  百分比
     * @param  interval   $decimals 精度
     * @return string           格式化好的百分比
     */
    public static function formatPercent($percent=0.00, $decimals=0) {
        $formatedPercent = '0';
        
        $percent = floatval($percent);
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
    
    /**
     * 隐藏姓名除姓以后的汉字
     * 
     * @param  string $name  姓名
     * @return string        处理过的姓名
     * @author zhaoting 
     */
    public static function formatChineseName($name) {
        $formatedChineseName = '';
        // 替换的符号
		$sign = '*';
        if (!empty($name)) {
        	$nameLength = mb_strlen($name,'utf-8');
        	$firstName = mb_substr($name,0,1,'utf-8');
        	$secondName = mb_substr($name,1,$nameLength-1,'utf-8');
        	// 字符切割放入数组
        	$arr = str_split($secondName, 3);        	
			// 替换
			foreach ($arr as &$item){
				$item = $sign;
			}			
        	// 拼接
            $formatedChineseName = $firstName.implode($arr);
        }

        return $formatedChineseName;
    }

    /**
     * customer defined function for sprinf_array where named arguments are desired (php syntax)
     * 参考python的字典型字符串格式化
     *
     * with sprintf: sprintf('second: %2$s ; first: %1$s', '1st', '2nd');
     * 
     * with sprintf_array: sprintf_array('second: %(second)s ; first: %(first)04d', array(
     *  'first' => '42',
     *  'second'=> '2nd'
     * ));
     * 
     *
     * @param string $format sprintf format string, with any number of named arguments
     * @param array $args array of [ 'arg_name' => 'arg value', ... ] replacements to be made
     * @access private
     * @return string|false result of sprintf call, or bool false on error
     */
    public static function sprintfWithArray($string, $array) {
        $keys    = array_keys($array);
        $keysmap = array_flip($keys);
        $values  = array_values($array);
    
        while (preg_match('/%\(([a-zA-Z0-9_ -]+)\)/', $string, $m)) {    
            if (!isset($keysmap[$m[1]])) {
                echo "No key $m[1]\n";
                return false;
            }
        
            $string = str_replace($m[0], '%' . ($keysmap[$m[1]] + 1) . '$', $string);
        }
    
        array_unshift($values, $string);
        //var_dump($values);
        return call_user_func_array('sprintf', $values);
    }

    /**
     * 排序多维数组, 类似于array_multisort,不同之处在于按照field排序
     * Pass the array, followed by the column names and sort flags
     * 
     * Example: $sorted = arrayMultisort($data, 'volume', SORT_DESC, 'edition', SORT_ASC);
     * 
     * @return array 排序过的数组
     */
    public static function arrayMultisort() {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }


    /**
     * 返回数组中指定的一列
     * Note: php5.5已经内置array_column
     * 
     * @param  array  $arrInput   需要取出数组列的多维数组（或结果集）
     * @param  string $columnKey  需要返回值的列，它可以是索引数组的列索引，或者是关联数组的列的键。 也可以是NULL，此时将返回整个数组（配合index_key参数来重置数组键的时候，非常管用）
     * @param  string $indexKey   作为返回数组的索引/键的列，它可以是该列的整数索引，或者字符串键值。
     * @return array              从多维数组中返回单列数组
     */
    public static function arrayColumn($arrInput, $columnKey=null, $indexKey=null) {
        $newArr = array();
        if (!empty($arrInput)) {
            foreach($arrInput as &$v) {
                //value
                $value = array_key_exists($columnKey, $v) ? $v[$columnKey] : $v;
                //key
                if (array_key_exists($indexKey, $v)) {
                    $newArr[$v[$indexKey]] = $value;
                } else {
                    $newArr[] = $value;
                }
            }
        }

        return $newArr;
    }


    /**
     * 安全过滤函数
     *
     * @param $string
     * @return string
     */
    public static function safeReplace($string) {
        $string = str_replace('%20','',$string);
        $string = str_replace('%27','',$string);
        $string = str_replace('%2527','',$string);
        $string = str_replace('*','',$string);
        $string = str_replace('"','&quot;',$string);
        $string = str_replace("'",'',$string);
        $string = str_replace('"','',$string);
        $string = str_replace(';','',$string);
        $string = str_replace('<','&lt;',$string);
        $string = str_replace('>','&gt;',$string);
        $string = str_replace("{",'',$string);
        $string = str_replace('}','',$string);
        //$string = str_replace('\\','',$string);
        return $string;
    }


    /**
     * 新浪短链接生成
     * 
     * @param  string source   在新浪微博创建应用时生成的appkey
     * @param  string url_long  要生成短链接得长链接
     * @return array             从新浪服务端返回的json字符串中格式化出的数组
     */
    public static function sinaShortUrlService($url_long='') {

        if (!empty($url_long)) {
            // 引入AresRESTClient文件(一般配置文件中已经引入,此处起预防作用)
            Yii::import('application.common.extensions.AresRESTClient');
            $curlObj = new AresRESTClient();
            
            //json格式接口
            $jsonApi = 'http://api.t.sina.com.cn/short_url/shorten.json';

            //appkey
            $appkey = '1974945412';

            $params = array(
                'source' => $appkey,
                'url_long' => $url_long,
            );
            $data = $curlObj->doGet($jsonApi, $params);

            $dataFormate = json_decode($data, TRUE);

            if (isset($dataFormate['error_code']) && $dataFormate['error_code']) {
                return array('status'=>'fail','message'=>$dataFormate['error']);
            } else {
                return array('status'=>'success','message'=>$dataFormate['0']);
            }
        } else {
                return array('status'=>'fail','message'=>'params is empty');
        }
    }


    /**
     * 对url参数进行签名(md5)
     * 签名规则: 所有url参数按字典排序后key-value以,连接，最后加上签名密钥(app_secrect)，然后对生成的String进行md5加密；转为大写
     * 
     * @param array  $params         待签名参数
     * @param array  $excludeFields  不参与签名字段
     * @param string $secrect        签名密钥
     */
    public static function signURLParameters($params, $excludeFields=array('sign'), $secrect='f838905ddd031399ffdm8n3mymrrzomk') {        
        $params_string = '';
        
        //按key字典排序
        ksort($params);
        //以keyvalue的形式将参数拼成url参数字符串,keys不参与签名
        foreach ($params as $key => $value) {
            // 跳过不参与签名的key
            if (!empty($excludeFields) && in_array($key, $excludeFields)) {
                continue;
            }
            $params_string .= $key.$value;
        }
        //url参数字符串最后要加入appSecrect
        if (!empty($secrect)) {
            $params_string .= $secrect;
        }
        //将md5后的字符串字母转为大写
        $signed_params_string = strtoupper(md5($params_string));
        
        //echo '<BR>';
        //print_r( $params );
        //print_r($params_string.PHP_EOL);
        //print_r($secrect.PHP_EOL);
        //print_r($signed_params_string.PHP_EOL);
        //print_r($params['sign'].PHP_EOL);
        
        $result = array(
            'params_string' => $params_string,
            'app_secrect' => $secrect,
            'signed_params_string' => $signed_params_string,
        );
        // add log
        AresLogManager::log_bi(array('logKey' => '[API]['.__METHOD__.']', 'desc' => 'get signature', 'parameters' => $params, 'response' => $result));
        
        return $signed_params_string;
    }



}