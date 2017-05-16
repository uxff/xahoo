<?php
/**
 * 支付宝手机网页支付
 * 
 * @example
 *     创建支付请求
 *     $params = []; //支付宝文档中所需的全部参数
 *     $alipay = new Alipay();
 *     $alipay->key = ''; //交易安全校验码
 *     $this->alipay->alipay_config = $params;
 *     $alipay->buildRequest();
 *     
 *     验证异步通知
 *     $this->alipay->key = ''; //交易安全校验码
 *     $this->alipay->alipay_config = $data; //支付宝异步通知参数
 *     $this->alipay->verifyNotify();
 * 
 * @package Alipay
 * @author Liutao
 * @since Version 0.2
 */
class Alipay {
    /**
     * 交易安全校验码
     * 
     * @access public
     * @var string
     */
    public $key;
     
    /**
     * 请求参数配置，支付宝接口文档中所需的参数
     *
     * @access public
     * @var array
     */
    public $alipay_config=[];
     
    /**
     * HTTPS证书，用于cURL
     * 默认和本类文件同级目录的cacert.pem文件
     *
     * @access public
     * @var string
     */
    public $credential;
     
    public $notify_data = null;
     
    /**
     * 支付宝即时到账网关地址
     */
    const ALIPAY_GATEWAY = 'https://mapi.alipay.com/gateway.do?';
     
    /**
     * HTTPS形式消息验证地址
     */
    const HTTPS_VERIFY_URL = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
     
    /**
     * HTTP形式消息验证地址
     */
    const HTTP_VERIFY_URL = 'http://notify.alipay.com/trade/notify_query.do?';
     
    /**
     * 移动网页支付网关
     * @var string
     */
    const ALIPAY_PAGE_GATEWAY = 'http://wappaygw.alipay.com/service/rest.htm?';
     
     
    /**
     * 创建支付包即时到账请求url
     * 
     * @access public
     * @return void
     */
    public function buildRequest() {
        $this->alipay_config['sign'] = $this->signData();
        return self::ALIPAY_GATEWAY . $this->createQueryString('', true);        
    }
     
    /**
     * 创建支付宝手机网页支付链接
     * @return string
     */
    public function buildPageUrl()
    {
        $this->alipay_config['sign'] = $this->signData();
        $url = self::ALIPAY_PAGE_GATEWAY. $this->createQueryString('');
        $response = $this->getHttpResponseGET($url);
        $res = $this->parseResponse(trim($response));
        //重新组合支付请求参数
        $this->alipay_config['service'] = 'alipay.wap.auth.authAndExecute';
        $this->alipay_config['req_data'] = '<auth_and_execute_req><request_token>'.$res['request_token'].'</request_token></auth_and_execute_req>';
         
        $this->alipay_config['sign'] = $this->signData();
        return self::ALIPAY_PAGE_GATEWAY. $this->createQueryString('', true);
    }
     
    /**
     * 验证支付宝异步通知参数合法性
     * 
     * @access public
     * @return boolean
     */
    public function verifyNotify() {
        $param_tmp = $this->filter(); //过滤待签名数据
        if(!isset($this->alipay_config['notify_data'])) {
            return false;
        }
        $this->notify_data = $this->xmlToArray($this->alipay_config['notify_data']);
        $this->alipay_config['notify_id'] = $this->notify_data['notify_id'];
        $responseTxt = 'true';
        if( !empty( $this->alipay_config['notify_id'] ) ) {
            $responseTxt = $this->getResponse();
        }
        unset($this->alipay_config['notify_id']);
        $txt = 'service=';
        $txt .= $this->alipay_config['service'];
        $txt .= '&v='.$this->alipay_config['v'];
        $txt .= '&sec_id='.$this->alipay_config['sec_id'];
        $txt .= '&notify_data='.$this->alipay_config['notify_data'];
        $txt .= $this->key;
        $sign = md5($txt);
 
        if ( preg_match("/true$/i",$responseTxt) && ($sign == $this->alipay_config['sign']) ) {
            return true;
        } else {
            return false;
        }
    }
     
    /**
     * 解析授权接口返回
     * @param string $content 授权接口返回的文本数据
     * @throws \Exception
     * @return array
     */
    private function parseResponse($content) {
        parse_str($content, $arr);
        $data = isset($arr['res_data']) ? $arr['res_data'] : $arr['res_error'];
        $res_data = simplexml_load_string($data);
        if(strlen($res_data->request_token) == 0 || strlen($res_data->msg) > 0) {
            throw new \Exception('code:'.$res_data->code.','.$res_data->msg);
        }
        $arr['request_token'] = $res_data->request_token->__toString();
        return $arr;
    }
     
    /**
     * simpleXML对象转成数组
     * @param string $xml
     * @return multitype:NULL
     */
    private function xmlToArray($xml)
    {
        $xml_obj = simplexml_load_string($xml, 'SimpleXMLIterator');
        $arr = [];
        $xml_obj->rewind(); //指针指向第一个元素
        while (1) {
            if( ! is_object($xml_obj->current()) )
            {
                break;
            }
            $arr[$xml_obj->key()] = $xml_obj->current()->__toString();
            $xml_obj->next(); //指向下一个元素
        }
        return $arr;
    }
     
    /**
     * 签名数据
     * 签名规则:
     *     sign和sign_type不参加签名，需要去掉
     *     对参数数组依据键名按照字母顺序升序排序
     *     排序完成之后键值对用&字符连接，组成URL的查询字符串形式待签名字符串，待签名数据不需用url encoding
     *     MD5签名：私钥拼接到待签名字符串的后面，然后用md5对字符串运算，得到32位签名结果
     *     
     * @return string 已签名数据
     */
    private function signData() {
        $param_tmp = $this->getSignString(); //待签名字符串
         
        if( !isset($this->key) ) {
            return FALSE;
        }
         
        $sign = '';
         
        //签名数据
        switch ($this->alipay_config['sec_id']) {
            case '001': //rsa
                $sign = $this->rsaSign($param_tmp);
                break;
            case 'DES':
                break;
            default:
                $sign = $this->md5Sign($param_tmp);
        }
         
        return $sign;
    }
     
    /**
     * MD5加密字符串
     * 
     * @access private
     * @param string $data 待加密字符串
     * @return string
     */
    private function md5Sign( $data ) {
        return md5($data . $this->key);
    }
     
    /**
     * RSA 加密字符串
     * 
     * @param string $data 待加密字符串
     * @return string
     */
    private function rsaSign( $data ) {
        return false;
    }
     
    /**
     * 获得待签名数据
     * 
     * @access private
     * @return string
     */
    private function getSignString() {
        $param_tmp = $this->filter(); //过滤待签名数据
         
        //排序
        ksort($param_tmp);
        reset($param_tmp);
         
        //创建查询字符串形式的待签名数据
        return $this->createQueryString($param_tmp);
    }
     
    /**
     * 过滤待签名数据，去掉sing、sing_type及空值
     * 
     * @access private
     * @return array
     */
    private function filter() {
        $para_filter = array();
        foreach($this->alipay_config as $key => $value){
            if($key == "sign" || $key == "sign_type" || empty($value)) continue;
            else $para_filter[$key] = $value;
        }
        return $para_filter;
    }
     
    /**
     * 用&拼接字符串,形成URL查询字符串
     * 
     * @access private
     * @param array $data
     * @param boolean $is_encode 是否对值做urlencode
     * @return string
     */
    private function createQueryString($data=NULL, $is_encode=false ) {
        $arr = empty($data) ? $this->alipay_config : $data;
        $arg = '';
        foreach( $arr as $key => $value ) {
            if($is_encode) {
                $key = urlencode($key);
                $value = urlencode($value);
            }
            $arg .= $key . '=' . $value . '&';
        }
        $arg = substr($arg, 0, strlen($arg)-1); //去掉最后一个&
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()) {$arg = stripslashes($arg);}
         
        return $arg;
    }
     
    /**
     * 获取远程服务器ATN结果,验证返回URL
     * 
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     * 
     * @access private
     * @return 服务器ATN结果
     */
    private function getResponse() {
        //载入支付配置
        $config = Yii::$app->params['alipay'];
         
        $transport = strtolower(trim($config['transport']));
        $partner = trim($config['partner']);
        $veryfy_url = '';
        if($transport == 'https') {
            $veryfy_url = self::HTTPS_VERIFY_URL;
        }
        else {
            $veryfy_url = self::HTTP_VERIFY_URL;
        }
        $veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $this->alipay_config['notify_id'];
        $responseTxt = $this->getHttpResponseGET($veryfy_url);
     
        return $responseTxt;
    }
     
    /**
     * 取证书，用于cURL的请求
     * 
     * @access private
     * @return string 证书路径
     */
    private function getCr() {
        if( ! empty($this->credential) ) {
            return $this->credential;
        }
        return __DIR__ . DIRECTORY_SEPARATOR .'cacert.pem';
    }
     
    /**
     * 远程获取数据，POST模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * 
     * @param $url 指定URL完整路径地址
     * @param $cacert_url 指定当前工作目录绝对路径
     * @param $para 请求的数据
     * @param $input_charset 编码格式。默认值：空值
     * return 远程输出的数据
     */
    private function getHttpResponsePOST($url, $para, $input_charset = '') {
     
        if (trim($input_charset) != '') {
            $url = $url."_input_charset=".$input_charset;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        curl_setopt($curl, CURLOPT_CAINFO,$this->getCr());//证书地址
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_POST,true); // post传输数据
        curl_setopt($curl, CURLOPT_POSTFIELDS,$para);// post传输数据
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);
     
        return $responseText;
    }
     
    /**
     * 远程获取数据，GET模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * 
     * @param $url 指定URL完整路径地址
     * @param $cacert_url 指定当前工作目录绝对路径
     * return 远程输出的数据
     */
    private function getHttpResponseGET($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        curl_setopt($curl, CURLOPT_CAINFO,$this->getCr());//证书地址
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );exit;//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);
     
        return $responseText;
    }
}