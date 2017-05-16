<?php
/*
*/

class WechatRedpack {
    
    // 单发红包
    const SEND_REDPACK_URL      = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
    // 群发红包
    const SEND_GROUPREDPACK_URL = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
    
    const ERR_OK            = 1;
    const ERR_CURL_FAIL     = 10;
    
    const MAX_AMOUNT        = 20000;//最大金额，分
    const MIN_AMOUNT        = 100;  //最小金额，分

    public $billno_prefix   = 'wxhb';//订单前缀
    
    public $errCode;
    public $errMsg;
    
    protected $postData;
    protected $resData;
    
    protected $appid;
    protected $merid;
    protected $noncestr;
    protected $send_name;
    protected $act_name;
    protected $nick_name;
    protected $wishing;
    protected $remark;
    protected $client_ip = '192.168.1.1';
    protected $apiclient_cert;// = dirname(__FILE__).'/cert/apiclient_cert.pem';
    protected $apiclient_key;//  = dirname(__FILE__).'/cert/apiclient_key.pem';
    protected $cafile;//         = dirname(__FILE__).'/cert/rootca.pem';

    public function __construct($options = []) {
        $this->appid        = isset($options['appid']) ? $options['appid'] : $this->appid;
        $this->merid        = isset($options['merid']) ? $options['merid'] : $this->merid;
        $this->send_name    = isset($options['send_name']) ? $options['send_name'] : $this->send_name;
        $this->act_name     = isset($options['act_name']) ? $options['act_name'] : $this->act_name;
        $this->nick_name    = isset($options['nick_name']) ? $options['nick_name'] : $this->nick_name;
        $this->wishing      = isset($options['wishing']) ? $options['wishing'] : $this->wishing;
        $this->remark       = isset($options['remark']) ? $options['remark'] : $this->remark;
        $this->client_ip    = isset($options['client_ip']) ? $options['client_ip'] : $this->client_ip;
        $this->billno       = isset($options['billno']) ? $options['billno'] : $this->billno;
        $this->cafile       = isset($options['cafile']) ? $options['cafile'] : $this->cafile;
        $this->apiclient_key = isset($options['apiclient_key']) ? $options['apiclient_key'] : $this->apiclient_key;
        $this->apiclient_cert = isset($options['apiclient_cert']) ? $options['apiclient_cert'] : $this->apiclient_cert;

        $this->init();
    }
    public function init() {
    }

    public function sendRedPack($openid, $money, $billno='', $wishing='')
    {
        if ($billno) {
            $this->billno = $billno;
        }
        if ($wishing) {
            $this->wishing = $wishing;
        }
        /*
        $arrInfo = array(
                'nonce_str'=>'',//随机字符串,32位
                'mch_billno'=>'',// 商户订单号 28位
                'mch_id'=>'', // 商户号
                'sub_mch_id'=>'', //子商户号(选填)
                'wxappid'=>'', //商户appid
                'nick_name'=>'', //红包提供方名
                'send_name'=>'', //红包发送者名称
                're_openid'=>'', //接收红包的用户
                'total_amount'=>'', //付款金额
                'min_value'=>'', //最小红包金额
                'max_value'=>'', //最大红包金额
                'total_num'=>'', //红包发送总人数
                'wishing'=>'', //红包祝福语 128
                'client_ip'=>'', //调用接口的机器ip地址 15
                'act_name'=>'', //活动名称 32
                'remark'=>'', //备注 256
                'logo_imgurl'=>'', //商户logo 选填 128
                'share_content'=>'', //分享文案 选填 256
                'share_url'=>'', //分享链接 选填 128
                'share_imgurl'=>'', //分享图片url 选填 128
                'sign'=>'', //签名
                );
        */


        // 密钥  k1fkSbcCjeucm7AEFfL4NczHSBTWayTqgoH8oGQfqA5
        $privatekey = 'k1fkSbcCjeucm7AEFfL4NczHSBTWayTqgoH8oGQfqA5';
        $privatekey = '1111111111aaaaaaaaaaeeeeeeeeeeee';

        $nonce_str = $this->generateNonceStr();
        $arrInfo = array(
            'nonce_str'=>$nonce_str,//随机字符串,32位//'ljeUjFDR8QMRuuZe',//
            'mch_billno'=>$this->billno,//'fhhb'.date('YmdHis').sprintf('%03d', rand(0,999)),// 商户订单号 28位
            'mch_id'=>$this->merid, // 商户号
            //'sub_mch_id'=>'', //子商户号(选填)
            'wxappid'=>$this->appid, //公众号(服务号)appid
            'nick_name'=>$this->nick_name, //红包提供方名
            'send_name'=>$this->send_name, //红包发送者名称
            're_openid'=>$openid, //接收红包的用户
            'total_amount'=>$money, //付款金额,单位分
            'min_value'=>$money, //最小红包金额
            'max_value'=>$money, //最大红包金额
            'total_num'=>'1', //红包发送总人数
            'wishing'=>$this->wishing,//'房乎海报·中弘由山由谷项目', //红包祝福语 128
            'client_ip'=>$this->client_ip, //调用接口的机器ip地址 15
            'act_name'=>$this->act_name, //活动名称 32
            'remark'=>$this->remark, //备注 256
            //'logo_imgurl'=>'', //商户logo 选填 128
            //'share_content'=>'', //分享文案 选填 256
            //'share_url'=>'', //分享链接 选填 128
            //'share_imgurl'=>'', //分享图片url 选填 128
            //'sign'=>'', //签名,算出签名之后补全
        );

        /*
        签名的算法
        第一步，设所有发送或者接收到的数据为集合M，将集合M内非空参数值的参数按照参数名ASCII码从小到大排序（字典序），使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串stringA>。
        特别注意以下重要规则：
        　◆　参数名ASCII码从小到大排序（字典序）；
        　◆　如果参数的值为空不参与签名；
        　◆　参数名区分大小写；
        　◆　验证调用返回或微信主动通知签名时，传送的sign参数不参与签名，将生成的签名与该sign值作校验。
        　◆　微信接口可能增加字段，验证签名时必须支持增加的扩展字段
        第二步，在stringA最后拼接上key=(API密钥的值)得到stringSignTemp字符串，并对stringSignTemp>进行MD5运算，再将得到的字符串所有字符转换为大写，得到sign值signValue。
        */

        $stringA = $this->formatQueryParaMap($arrInfo);
        //file_put_contents('/tmp/fanghu_wechat_debug',var_export($stringA,true),FILE_APPEND);
        $stringA = $stringA."&key=".trim($privatekey);
        //file_put_contents('/tmp/fanghu_wechat_debug',var_export($stringA,true),FILE_APPEND);
        $sign = strtoupper(md5($stringA));
        $arrInfo['sign'] = $sign;
        //file_put_contents('/tmp/fanghu_wechat_debug',var_export($arrInfo,true),FILE_APPEND);

        $redPackUrl = self::SEND_REDPACK_URL;////'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $this->postData = $postXml = $this->arrayToXml($arrInfo);
        file_put_contents('/tmp/fanghu_wechat_debug',var_export($postXml,true),FILE_APPEND);

        $this->resData = $data = $this->post($redPackUrl,$postXml);
        $ret = (array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        Yii::log('SEND A REDPACK: postXml='.$postXml.' RES='.$data.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
        file_put_contents('/tmp/fanghu_wechat_debug',var_export($data,true),FILE_APPEND);

        if ($ret['result_code']=='SUCCESS') {
            $this->errCode = self::ERR_OK;
        } else {
            $this->errCode = $ret['result_code'];
        }
        $this->errMsg  = $ret['return_msg'];
        /*
        <xml>
            <sign></sign>
            <mch_billno></mch_billno>
            <mch_id></mch_id>
            <wxappid></wxappid>
            <nick_name></nick_name>
            <send_name></send_name>
            <re_openid></re_openid>
            <total_amount></total_amount>
            <min_value></min_value>
            <max_value></max_value>
            <total_num></total_num>
            <wishing></wishing>
            <client_ip></client_ip>
            <act_name></act_name>
            <act_id></act_id>
            <remark></remark>
            <logo_imgurl></logo_imgurl>
            <share_content></share_content>
            <share_url></share_url>
            <share_imgurl></share_imgurl>
            <nonce_str></nonce_str>
        </xml>
        */
        //$this->errCode = ERR_OK;
        return $ret;
    }

    function post($url, $postData, $second=30,$aHeader=array())
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        //cert 与 key 分别属于两个.pem文件
        curl_setopt($ch,CURLOPT_SSLCERT,    $this->apiclient_cert);
        curl_setopt($ch,CURLOPT_SSLKEY,     $this->apiclient_key);
        curl_setopt($ch,CURLOPT_CAINFO,     $this->cafile);


        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            curl_close($ch);
            $this->errCode = self::ERR_CURL_FAIL;
            $this->errMsg  = 'CURL ERROR: '.curl_error($ch);
            return false;
        }
    }

    function arrayToXml($arr)
    {
            $xml = "<xml>";
            foreach ($arr as $key=>$val)
            {
                     if (is_numeric($val))
                     {
                            $xml.="<".trim($key).">".trim($val)."</".$key.">";

                     }
                     else{
                            $xml.="<".trim($key)."><![CDATA[".trim($val)."]]></".$key.">";
                            //$xml.="<".$key.">".$val."</".$key.">";
                     }
            }
            $xml.="</xml>";
            return $xml;
    }
    function formatQueryParaMap($paraMap, $urlencode=false){
            $buff = "";
            ksort($paraMap);
            foreach ($paraMap as $k => $v){
                    if (!empty($v) && "sign" != $k) {
                        if($urlencode){
                               $v = urlencode(trim($v));
                            }
                            $buff .= trim($k) . "=" . trim($v) . "&";
                    }
            }
            $reqPar;
            if (strlen($buff) > 0) {
                    $reqPar = substr($buff, 0, strlen($buff)-1);
            }
            return $reqPar;
    }

	/**
	 * 生成随机字串
	 * @param number $length 长度，默认为16，最长为32字节
	 * @return string
	 */
	public function generateNonceStr($length=16){
		// 密码字符集，可任意添加你需要的字符
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i++)
		{
			$str .= $chars[mt_rand(0, strlen($chars) - 1)];
		}
		return $str;
	}

    public function genBillNo() {
        $prefix = $this->billno_prefix;
        $str = $prefix.date('YmdHis').sprintf('%03d', rand(0,999));
        return $str;
    }
    
    public function billno($billno = '') {
        if (!empty($billno)) {
            $this->billno = $billno;
        } else {
            $this->billno = $this->genBillNo();
        }
        return $this->billno;
    }
    public function getResData() {
        return $this->resData;
    }
    public function getPostData() {
        return $this->postData;
    }
}
