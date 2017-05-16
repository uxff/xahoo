<?php
/* *
 * 类名：AlipayNotify
 * 功能：支付宝通知处理类
 * 详细：处理支付宝各接口通知返回
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考

 *************************注意*************************
 * 调试通知返回时，可查看或改写log日志的写入TXT里的数据，来检查通知返回是否正常
 */

require_once("alipay_core.function.php");
require_once("alipay_rsa.function.php");
require_once("alipay_md5.function.php");

class AlipayNotify {
    
    /**
     * HTTPS形式消息验证地址
     */
    var $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    
    /**
     * HTTP形式消息验证地址
     */
    var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    
    /**
     * 
     * @var [type]
     */
    var $alipay_config;

    /**
     * [__construct description]
     * @param [type] $alipay_config [description]
     */
    function __construct($alipay_config){
        $this->alipay_config = $alipay_config;
    }
    function AlipayNotify($alipay_config) {
        $this->__construct($alipay_config);
    }
    
    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     *
     * @param array     $postParams  POST参数
     * @param boolean   $isWap       是否手机网站支付验证
     * 
     * @return boolean 验证结果
     */
    public function verifyNotify($postParams, $isWap=false) {
        if(empty($postParams)) {//判断POST来的数组是否为空
            return false;
        }
        else {

            // RSA解密notify data
            if ($this->alipay_config['sign_type'] == 'RSA') {
                $postParams['notify_data'] = rsaDecrypt($postParams['notify_data'], $this->alipay_config['private_key_path']);
            }

            //notify_id从POST中解析出来
            $notify_id = '';
            if ($isWap) {
                // WapDirect返回的POST数据存储在notify_data XML结构中
                if (!empty($postParams['notify_data'])) {
                    $doc = new DOMDocument();
                    $doc->loadXML($postParams['notify_data']);
                    $notify_id = $doc->getElementsByTagName( "notify_id" )->item(0)->nodeValue;
                }
            } else {
                // Direct返回的POST中已经包含notify_id的内容
                $notify_id = $postParams['notify_id'];
            }


            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $responseTxt = 'true';
            if (!empty($notify_id)) {
                $responseTxt = $this->getResponse($notify_id);
            }
            
            //生成签名结果
            if ($isWap) {
                $isSign = $this->getSignVerify($postParams, $postParams["sign"], false);
            } else {
                $isSign = $this->getSignVerify($postParams, $postParams["sign"], true);
            }
            
            //写日志记录
            //if ($isSign) {
            //    $isSignStr = 'true';
            //}
            //else {
            //    $isSignStr = 'false';
            //}
            //$log_text = "responseTxt=".$responseTxt."\n notify_url_log:isSign=".$isSignStr.",";
            //$log_text = $log_text.createLinkString($_POST);
            //logResult($log_text);
            
            //验证
            //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            //if (preg_match("/true$/i",$responseTxt) && $isSign) {
            if ($isSign) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     *
     * @param array     $getParams  GET参数
     * @param boolean   $isWap       是否手机网站支付验证
     * 
     * @return boolean 验证结果
     */
    public function verifyReturn($getParams, $isWap=false) {
        if(empty($getParams)) {//判断GET来的数组是否为空
            return false;
        }
        else {
            //生成签名结果
            $isSign = $this->getSignVerify($getParams, $getParams["sign"],true);
            
            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $responseTxt = 'true';
            if (!empty($getParams["notify_id"])) {
                $responseTxt = $this->getResponse($getParams["notify_id"]);
            }

            //写日志记录
            //if ($isSign) {
            //    $isSignStr = 'true';
            //}
            //else {
            //    $isSignStr = 'false';
            //}
            //$log_text = "return_url_log:isSign=".$isSignStr.",";
            //$log_text = $log_text.createLinkString($_GET);
            //logResult($log_text);
            
            //验证
            //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            //if (preg_match("/true$/i",$responseTxt) && $isSign) {
            if ($isSign) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * 解密
     * @param $input_para 要解密数据
     * @return 解密后结果
     */
    function decrypt($prestr) {
        return rsaDecrypt($prestr, trim($this->alipay_config['private_key_path']));
    }
    
    /**
     * 异步通知时，对参数做固定排序
     * @param $para 排序前的参数组
     * @return 排序后的参数组
     */
    function sortNotifyPara($para) {
        $para_sort['service'] = $para['service'];
        $para_sort['v'] = $para['v'];
        $para_sort['sec_id'] = $para['sec_id'];
        $para_sort['notify_data'] = $para['notify_data'];
        return $para_sort;
    }
    
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @param $isSort 是否对待签名数组排序
     * @return 签名验证结果
     */
    function getSignVerify($para_temp, $sign, $isSort) {
        //除去待签名参数数组中的空值和签名参数
        $para = paraFilter($para_temp);
        
        //对待签名参数数组排序
        if($isSort) {
            $para = argSort($para);
        } else {
            $para = $this->sortNotifyPara($para);
        }
        
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para);
        
        $isSgin = false;
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
            case "MD5" :
                $isSgin = md5Verify($prestr, $sign, $this->alipay_config['key']);
                break;
            case "RSA" :
                $isSgin = rsaVerify($prestr, trim($this->alipay_config['ali_public_key_path']), $sign);
                break;
            case "0001" :
                $isSgin = rsaVerify($prestr, trim($this->alipay_config['ali_public_key_path']), $sign);
                break;
            default :
                $isSgin = false;
        }
        
        return $isSgin;
    }

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空 
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    function getResponse($notify_id) {
        $transport = strtolower(trim($this->alipay_config['transport']));
        $partner = trim($this->alipay_config['partner']);
        $verify_url = '';
        if($transport == 'https') {
            $verify_url = $this->https_verify_url;
        }
        else {
            $verify_url = $this->http_verify_url;
        }
        $verify_url = $verify_url."partner=" . $partner . "&notify_id=" . $notify_id;
        $responseTxt = getHttpResponseGET($verify_url, $this->alipay_config['cacert']);
        
        return $responseTxt;
    }
}
?>
