<?php
/* *
 * 功能：即时到账交易接口接入页
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

require_once('lib/alipay_submit_direct.class.php');
require_once('lib/alipay_notify.class.php');

/**
 * 支付宝即时到帐类
 */
class AlipayDirect {

    /**
     * 获取支付宝基本配置信息
     * 
     * @return array
     */
    public function getAlipayBaseConfig() {

        /**************************配置基本信息开始**************************/
        //合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']               = '2088911587769191';

        //合作卖家账号
        $alipay_config['seller_email']          = '2749655298@qq.com';

        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key']                   = 'ux4e9xyelr1sjifsx5yxjf5t4hfvth67';

        //商户的私钥（后缀是.pen）文件相对路径
        $alipay_config['private_key_path']      = 'key/rsa_private_key.pem';

        //支付宝公钥（后缀是.pen）文件相对路径
        $alipay_config['ali_public_key_path']   = 'key/alipay_public_key.pem';

        //签名方式 不需修改
        $alipay_config['sign_type']             = strtoupper('MD5');
        //$alipay_config['sign_type']           = strtoupper('RSA');

        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']         = strtolower('utf-8');

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']                = getcwd().'\\cacert.pem';

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']                = 'http';
        /**************************配置基本信息结束**************************/

        return $alipay_config;

    }

    /**
     * 获取支付宝链接
     *
     *  $params = array(
     *       'order_id' => '',
     *       'display_order_id' => '',
     *       'order_total' => '',
     *       'display_payment_subject' => '',
     *       'display_payment_body' => '',
     *       'return_url' => '',
     *       'notify_url' => '',
     *       'show_url' => '',
     *   );
     * 
     * @param  array  $params 支付信息
     * @return string         支付宝页面链接
     */
    public function getAlipayUrl($params) {

        // 获取支付宝基本配置信息
        $alipay_config = $this->getAlipayBaseConfig();


        //页面跳转同步通知页面路径
        $return_url = trim($params['return_url']);
        if (empty($return_url)) {
            $return_url = Yii::app()->getRequest()->getHostInfo('http') . '/ipn/alipay_return.php';
        }
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //服务器异步通知页面路径
        $notify_url = trim($params['notify_url']);
        if (empty($notify_url)) {
            $notify_url = Yii::app()->getRequest()->getHostInfo('http') . '/ipn/alipay_notify.php';
        }
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //商品展示地址
        $show_url = trim($params['show_url']);
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html


        $total_fee=trim($params['order_total']);

        // 构造要请求的参数数组
        $parameters = array(
                'service'             => 'create_direct_pay_by_user',
                'partner'             => trim($alipay_config['partner']),
                'seller_email'        => trim($alipay_config['seller_email']),
                'payment_type'        => '1',  //支付类型, 商品购买
                'paymethod'           => 'directPay', //默认支付方式
                'enable_paymethod'    => 'directPay^bankPay', //支付渠道
                //'anti_phishing_key'   => '', //防钓鱼时间戳, 若要使用请调用类文件submit中的query_timestamp函数
                //'exter_invoke_ip'     => '', //客户端的IP地址, 非局域网的外网IP地址，如：221.0.0.1
                '_input_charset'      => trim(strtolower($alipay_config['input_charset'])),
                'out_trade_no'        => trim($params['display_order_id']), //商户订单号（商户网站订单系统中唯一订单号），必填
                'subject'             => trim($params['display_payment_subject']), //订单名称,必填
                //'total_fee'           => floatval($params['order_total']), //付款金额,必填
                'total_fee'           => $total_fee, //付款金额,必填
                'body'                => trim($params['display_payment_body']), //订单描述
                'notify_url'          => $notify_url,
                'return_url'          => $return_url,
                'show_url'            => $show_url,
        );
        // 商户自定义公用变量
        if (!empty($params['extra_common_param'])) {
            $parameters['extra_common_param'] = trim($params['extra_common_param']);
        }
        // 
        $objAlipaySubmitDirect = new AlipaySubmitDirect($alipay_config);

        // 生成支付宝请求url
        $alipay_url = $objAlipaySubmitDirect->buildPageUrl($parameters);
        

        return $alipay_url;
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

        //
        $objAlipayNotify = new AlipayNotify($alipay_config);

        //
        $isVerified = $objAlipayNotify->verifyNotify($postParams);

        return $isVerified;
    }


}