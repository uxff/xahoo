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

require_once("lib/alipay_submit_wap.class.php");
require_once('lib/alipay_notify.class.php');

/**
 * 支付宝手机网站支付类
 */
class AlipayWap {


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
     *       'merchant_url' => '',
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

        //操作中断返回地址
        $merchant_url = trim($params['merchant_url']);
        if (empty($merchant_url)) {
            $merchant_url = Yii::app()->getRequest()->getHostInfo('http');
        }
        //用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数


        /********** 调用请求接口alipay.wap.trade.create.direct获取授权token ************/

        // 构造请求业务参数XML结构
        $req_data = '<direct_trade_create_req>';
        $req_data .= '<seller_account_name>' . trim($alipay_config['seller_email']) . '</seller_account_name>';
        $req_data .= '<out_trade_no>' . trim($params['display_order_id']) . '</out_trade_no>';
        $req_data .= '<subject>' . trim($params['display_payment_subject']) . '</subject>';
        $req_data .= '<total_fee>' . floatval($params['order_total']) . '</total_fee>';
        $req_data .= '<notify_url>' . $notify_url . '</notify_url>';
        $req_data .= '<call_back_url>' . $return_url . '</call_back_url>';
        $req_data .= '<merchant_url>' . $merchant_url . '</merchant_url>';
        $req_data .= '</direct_trade_create_req>';

        // 构造API请求参数数组
        $token_parameters = array(
            'service'           => 'alipay.wap.trade.create.direct',
            'partner'           => trim($alipay_config['partner']),
            'sec_id'            => trim($alipay_config['sign_type']),
            '_input_charset'    => trim(strtolower($alipay_config['input_charset'])),
            'format'            => 'xml', //返回格式
            'v'                 => '2.0', //版本号
            'req_id'            => date('Ymdhis'), //请求号,须保证每次请求都是唯一,必填
            'req_data'          => $req_data,
        );

        // 建立请求
        $objAlipaySubmitWap = new AlipaySubmitWap($alipay_config);
        $html_text = $objAlipaySubmitWap->buildRequestHttp($token_parameters);

        // URLDECODE返回的信息
        $html_text = urldecode($html_text);
        // 解析远程模拟提交后返回的信息
        $param_html_text = $objAlipaySubmitWap->parseResponse($html_text);

        // 获取request_token
        $request_token = $param_html_text['request_token'];

        // TODO request_toke error
        if (empty($request_toke)) {
            $arr_res_error = $this->xmlToArray($param_html_text['res_error']);
            //var_dump($arr_res_error);
        }

        /********** 根据授权码token调用交易接口alipay.wap.auth.authAndExecute ************/

        // 构造请求业务参数XML结构
        $req_data = '<auth_and_execute_req>';
        $req_data .= '<request_token>' . $request_token . '</request_token>';
        $req_data .= '</auth_and_execute_req>';

        // 构造API请求参数数组
        $parameter = array(
            'service'           => 'alipay.wap.auth.authAndExecute',
            'partner'           => trim($alipay_config['partner']),
            'sec_id'            => trim($alipay_config['sign_type']),
            '_input_charset'    => trim(strtolower($alipay_config['input_charset'])),
            'format'            => 'xml', //返回格式
            'v'                 => '2.0', //版本号
            'req_id'            => date('Ymdhis'), //请求号,须保证每次请求都是唯一,必填
            'req_data'          => $req_data,
        );

        // 建立请求
        $objAlipaySubmitWap = new AlipaySubmitWap($alipay_config);

        // 生成支付宝请求url
        $alipay_url = $objAlipaySubmitWap->buildPageUrl($parameter);
        
        //
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
        $isVerified = $objAlipayNotify->verifyReturn($getParams, true);

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
        $isVerified = $objAlipayNotify->verifyNotify($postParams, true);

        return $isVerified;
    }


    /**
     * simpleXML对象转成数组
     * notify_data -> notify
     * 
     * @param string $xml
     * @return array
     */
    public function xmlToArray($xml) {
        $objXml = simplexml_load_string($xml, 'SimpleXMLIterator');
        $arr = array();
        $objXml->rewind(); //指针指向第一个元素
        while (1) {
            if (!is_object($objXml->current())) {
                break;
            }
            $arr[$objXml->key()] = $objXml->current()->__toString();
            $objXml->next(); //指向下一个元素
        }

        return $arr;
    }

}