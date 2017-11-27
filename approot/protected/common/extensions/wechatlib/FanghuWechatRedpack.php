<?php
/*
*/

class FanghuWechatRedpack extends WechatRedpack {

    public $billno_prefix       = 'fhhb';//订单前缀
    
    public function init() {
        parent::init();

        $this->appid            = 'wx7345a7e7764a9f88';
        $this->merid            = '1241495602';
        $this->nick_name        = '品牌名称';
        $this->send_name        = '海报';
        $this->client_ip        = '192.168.1.1';
        $this->apiclient_cert   = dirname(__FILE__).'/cert/apiclient_cert.pem';
        $this->apiclient_key    = dirname(__FILE__).'/cert/apiclient_key.pem';
        $this->cafile           = dirname(__FILE__).'/cert/rootca.pem';

    }

}
