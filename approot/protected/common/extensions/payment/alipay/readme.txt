//授权接口请求参数
        $sum = 0.01; //测试用金额
        $req_data = '<direct_trade_create_req><subject>充值</subject>';
        $req_data .= '<out_trade_no>'.$orderNo.'</out_trade_no>';
        $req_data .= '<total_fee>'.$sum.'</total_fee>';
        $req_data .= '<call_back_url>'.Url::toRoute(['payment/return'], true).'</call_back_url>';
        $req_data .= '<notify_url>'.Url::toRoute(['payment/notify'], true).'</notify_url>';
        $req_data .= '<seller_account_name>'.Yii::$app->params['alipay']['seller_email'].'</seller_account_name>';
        $req_data .= '</direct_trade_create_req>';
        $params = [
            'service' => 'alipay.wap.trade.create.direct',
            'format' => 'xml',
            'v' => '2.0',
            'partner' => Yii::$app->params['alipay']['partner'], //合作者省份ID
            'req_id' => date('Ymdhis'),
            'sec_id' => Yii::$app->params['alipay']['sign_type'],
            'req_data' => $req_data,
        ];
         
        $alipay = new Alipay();
        $alipay->key = Yii::$app->params['alipay']['key'];
        $alipay->alipay_config = $params;
        $url = $alipay->buildPageUrl();
        $this->redirect($url);


http://wappaygw.alipay.com/service/rest.htm?service=alipay.wap.trade.create.direct&partner=2088201962473581&sec_id=MD5&format=xml&v=2.0&req_id=20150311055413&req_data=<direct_trade_create_req><subject>充值</subject><out_trade_no></out_trade_no><total_fee>0.01</total_fee><call_back_url></call_back_url><notify_url></notify_url><merchant_url></merchant_url><seller_account_name>XXXX</seller_account_name></direct_trade_create_req>&_input_charset=utf-8&sign=a4518d7842859d16c1a41fbc73b48c0c

https://mclient.alipay.com/service/rest.htm?partner=2088201962473581&req_id=20150311052445&sec_id=MD5&_input_charset=utf-8&v=2.0&format=xml&req_data=%3Cauth_and_execute_req%3E%3Crequest_token%3E%3C%2Frequest_token%3E%3C%2Fauth_and_execute_req%3E&sign=6c8a3f127f14a15e2c0ee1ec83218f2c&service=alipay.wap.auth.authAndExecute



//支付宝相关配置
    'alipay' => [
        'key' => 'XXXXX',  //交易安全校验码,用于签名的32位密钥
        'transport' => 'https',         //消息验证地址使用访问方式
        'seller_email' => 'XXXX', //卖家支付宝账号，即收款账户
        'service' => 'create_direct_pay_by_user', //接口名称
        'partner' => 'XXXX', //合作者省份ID
        '_input_charset' => 'utf-8', //参数编码字符集
        'sign_type' => 'MD5', //签名方式，不参加签名,目前只能是MD5
        //以下两个参数没用
        'notify_url' => '', //服务器异步通知页面路径
        'return_url' => '', //页面跳转通知页面路径
    ],