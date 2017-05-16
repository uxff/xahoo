<?php 
/**
 * alipay notify url
 * 
 * 将参数转发给yii对应的Controller和Action处理
 */

/** debug
$_POST['discount']='0.00';
$_POST['payment_type']='1';
$_POST['subject']='test1';
$_POST['trade_no']='2015051400001000910050549850';
$_POST['buyer_email']='xhlm06@126.com';
$_POST['gmt_create']='2015-05-14 11:53:21';
$_POST['notify_type']='trade_status_sync';
$_POST['quantity']='1';
$_POST['out_trade_no']='1111111';
$_POST['seller_id']='2088911587769191';
$_POST['notify_time']='2015-05-14 11:54:08';
$_POST['body']='test1test1';
$_POST['trade_status']='TRADE_SUCCESS';
$_POST['is_total_fee_adjust']='N';
$_POST['total_fee']='0.01';
$_POST['gmt_payment']='2015-05-14 11:54:08';
$_POST['seller_email']='2749655298@qq.com';
$_POST['price']='0.01';
$_POST['buyer_id']='2088502137190910';
$_POST['notify_id']='1db7cc6e94a4ea6ac9abd5f2ea0dc83572';
$_POST['use_coupon']='N';
$_POST['sign_type']='MD5';
$_POST['sign']='cc2b2b63516f37f004b14871521777c0';
*/

if (empty($_POST)) {
    echo 'Illegal Access!';
    die();
}

// 获取对应的Yii处理地址
if (!empty($_POST['extra_common_param'])) {
    $app_billing_process_url = getHostInfo(). '/' .$_POST['extra_common_param'].'.php';
} else {
    $app_billing_process_url = getHostInfo(). '/xqsjzcpc.php';
}
$app_billing_process_url .= '?r=billing/processNotify';

// 参数转发给对应的Controoler/Action处理
$restResult = doRestPost($app_billing_process_url, $_POST);
if(!empty($restResult)) {
    if ($restResult['isVerified'] && $restResult['isProcessed']) {
        echo 'success';
    } else {
        echo 'fail';
    }
} else {
    echo 'fail';
}

/***********************  functions ***********************/

/**
 * 发起一个post请求到指定接口
 * 
 * @param string   $url       请求的接口
 * @param array    $params    post参数
 * @param array    $headers   http头新新
 * @param integer  $timeout   超时时间
 * @return string  请求结果
 */
function doRestPost($url, $params = array()) {
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        'Accept: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // 以返回的形式接收信息
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 设置为POST方式
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
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
 * 获取主机名
 * @param  string $schema [description]
 * @return [type]         [description]
 */
function getHostInfo() {
    if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on' || $_SERVER['HTTPS']==1)
        || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https') {
        $http = 'https';
    } else {
        $http = 'http';
    }

    if (isset($_SERVER['HTTP_HOST'])) {
        $hostInfo = $http.'://'.$_SERVER['HTTP_HOST'];
    } else {
        $hostInfo = $http.'://'.$_SERVER['SERVER_NAME'];
    }

    return $hostInfo;
}