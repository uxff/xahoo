<?php 
/**
 * alipay return url
 * 
 * 将参数转发给yii对应的Controller和Action处理
 */
if (empty($_GET)) {
	echo 'Illegal Access!';
	die();
}

// 获取对应的Yii处理地址
if (!empty($_GET['extra_common_param'])) {
	$app_billing_process_url = getHostInfo(). '/' .$_GET['extra_common_param'].'.php';
} else {
	$app_billing_process_url = getHostInfo(). '/index.php';
}
$app_billing_process_url .= '?r=billing/processReturn';
$app_billing_process_url .= '&'.http_build_query($_GET);


// 转发至Controller和Action
header('location:'.$app_billing_process_url);

/***********************  functions ***********************/
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