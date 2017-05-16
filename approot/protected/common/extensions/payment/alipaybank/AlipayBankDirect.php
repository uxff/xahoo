<?php
/* *
 * 功能：纯网关接口接入页
 * 版本：3.3
 * 修改日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */


require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

/**************************请求参数**************************/
class AlipayBankDirect {
/**
 * 获取支付宝基本配置信息
 *
 * @return array
 */
    public function getAlipayBaseConfig() {
        
        //合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']		= '2088021297585566';
        
        //收款支付宝账号，一般情况下收款账号就是签约账号
        $alipay_config['seller_email']	= 'admin@xqshijie.com';
        
        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key']			= 'z8r5z9uy6hw7m6bb8y4y3wwh7m31a98n';
        
        
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        
        
        //签名方式 不需修改
        $alipay_config['sign_type']    = strtoupper('MD5');
        
        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']= strtolower('utf-8');
        
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'https';
        
        //支付类型
        $alipay_config['payment_type'] = "1";
        //必填，不能修改
        
        //服务器异步通知页面路径
        $alipay_config['notify_url'] = "http://商户网关地址/create_direct_pay_by_user-PHP-UTF-8/notify_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $alipay_config['return_url'] = "http://商户网关地址/create_direct_pay_by_user-PHP-UTF-8/return_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
        $alipay_config['out_trade_no'] = $_POST['WIDout_trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $alipay_config['subject'] = $_POST['WIDsubject'];
        //必填
        //付款金额
        $alipay_config['total_fee'] = $_POST['WIDtotal_fee'];
        //必填
        //订单描述
        $alipay_config['body'] = $_POST['WIDbody'];
        //默认支付方式
        $alipay_config['paymethod'] = "bankPay";
        //必填
        //默认网银
        $alipay_config['defaultbank'] = $_POST['WIDdefaultbank'];
        //必填，银行简码请参考接口技术文档
        //商品展示地址
        $alipay_config['show_url'] = $_POST['WIDshow_url'];
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //防钓鱼时间戳
        $alipay_config['anti_phishing_key'] = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        //客户端的IP地址
        $alipay_config['exter_invoke_ip'] = "";
        //非局域网的外网IP地址，如：221.0.0.1
        
        return $alipay_config;
    }

/************************************************************/


    public function getAlipayUrl($params) {
        
        // 获取支付宝基本配置信息
        $alipay_config = $this->getAlipayBaseConfig();
        
        //页面跳转同步通知页面路径
        $return_url = trim($params['return_url']);
        if (empty($return_url)) {
            $return_url = Yii::app()->getRequest()->getHostInfo('https') . '/ipn/alipay_return.php';
        }
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        
        //服务器异步通知页面路径
        $notify_url = trim($params['notify_url']);
        if (empty($notify_url)) {
            $notify_url = Yii::app()->getRequest()->getHostInfo('https') . '/ipn/alipay_notify.php';
        }
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        
        //商品展示地址
        $show_url = trim($params['show_url']);
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        
        
        $total_fee=trim($params['order_total']);
        
        //构造要请求的参数数组，无需改动
        $parameter = array(
        		"service" => "create_direct_pay_by_user",
        		"partner" => $alipay_config['partner'],
        		"seller_email" => $alipay_config['seller_email'],
        		"payment_type"	=> $alipay_config['payment_type'],
        		"notify_url"	=> $notify_url,
        		"return_url"	=> $return_url,
        		"out_trade_no"	=> trim($params['display_order_id']),
        		"subject"	=> trim($params['display_payment_subject']),
        		"total_fee"	=> trim($params['order_total']),
        		"body"	=> trim($params['display_payment_body']),
        		"paymethod"	=> $alipay_config['paymethod'],
        		"defaultbank"	=> $alipay_config['defaultbank'],
        		"show_url"	=> trim($params['show_url']),
        		"anti_phishing_key"	=> $alipay_config['anti_phishing_key'],
        		"exter_invoke_ip"	=> $alipay_config['exter_invoke_ip'],
        		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );
        
        // 商户自定义公用变量
        if (!empty($params['extra_common_param'])) {
            $parameter['extra_common_param'] = trim($params['extra_common_param']);
        }

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        return $html_text;
    }
    
    /**
     * 检验支付宝同步回调return数据是否正常
     * 主要验证签名sign
     *
     * @param  array $getParams  GET请求参数
     * @return boolan
     */
    public function verifyReturn($getParams) {
        // 获取支付宝基本配置信息
        $alipay_config = $this->getAlipayBaseConfig();
    
        require_once("lib/alipay_notify.class.php");
        //
        $objAlipayNotify = new AlipayNotify($alipay_config);
    
        //
        $isVerified = $objAlipayNotify->verifyReturn($getParams);
    
        return $isVerified;
    }
    
    /**
     * 检验支付宝同步回调notify数据是否正常,
     * 主要验证签名sign
     *
     * @param  array $postParams  POST请求参数
     * @return boolean
     */
    public function verifyNotify($postParams) {
        // 获取支付宝基本配置信息
        $alipay_config = $this->getAlipayBaseConfig();
    
        require_once("lib/alipay_notify.class.php");
        //
        $objAlipayNotify = new AlipayNotify($alipay_config);
    
        //
        $isVerified = $objAlipayNotify->verifyNotify($postParams);
    
        return $isVerified;
    }
}
?>