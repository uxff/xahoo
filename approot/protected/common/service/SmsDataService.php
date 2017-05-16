<?php

class SmsDataService extends BaseDataService{
	const SMS_SERVICE_APP_KEY = '5d9d7634a198'; // 新奇世界AppKey
	const SMS_SERVICE_ENDPOINT = 'https://120.132.154.117:8443'; // SMS服务器地址
	const SMS_API_CHECK_STATUS = '/check/status'; // 服务器装填监测接口
    const SMS_API_SEND_MSG = '/sms/sendmsg'; // 发送验证码接口
    const SMS_API_CHECK_CODE = '/sms/checkcode'; // 验证验证码接口
    // 错误码
    const SMS_ERROR_CODE_OK = '200'; //操作成功
    const SMS_ERROR_CODE_REJECT = '512'; //服务器拒绝访问，或者拒绝操作
    const SMS_ERROR_CODE_UNAUTHORIZED = '513'; //Appkey不存在或被禁用
    const SMS_ERROR_CODE_NO_PERMISSION = '514'; //权限不足
    const SMS_ERROR_CODE_INTERNAL_ERROR = '515'; //服务器内部错误 
    const SMS_ERROR_CODE_MISSING_PARAMETERS = '517'; //缺少必要的请求参数
    const SMS_ERROR_CODE_INVALID_MOBILE = '518'; //请求中用户的手机号格式不正确（包括手机的区号）
    const SMS_ERROR_CODE_OVER_LIMITED = '519'; //请求发送验证码次数超出限制
    const SMS_ERROR_CODE_INVALID_VERIFYCODE = '520'; //无效验证码
    const SMS_ERROR_CODE_BALANCE_NOT_ENOUGH = '526'; //余额不足

    //传参数
    
    const SMS_COUNT_ZHUCE = '【新奇世界/房乎网】 %s（新奇世界通行证注册验证码，请完成注册），如非本人操作，请忽略本短信。';//注册 ---- 验证码
    const SMS_COUNT_ZHUCEOK = '恭喜！您已成为新奇世界/房乎会员，用户名 %s 。您的信任我们深感荣幸。更多精彩请见指尖上的新奇世界xqshijie.com【新奇世界/房乎网】';//模块, 注册 ---- 验证码
    const SMS_COUNT_ACCOUNT = '【新奇世界/房乎网】 %s（新奇世界通行证手机动态码，请完成验证），如非本人操作，请忽略本短信。';//模块 个人资料/账户与安全信息修改
    const SMS_COUNT_REMIND = '【新奇世界】您在新奇世界关注的众筹项目【 %s 】已经开始众筹，请您及时登录网站查看购买，项目不多先来先得哦~众筹项目详情http:// 客服电话4009000979';//众筹频道  提醒(项目为收藏项目且状态从展示中转为众筹中----点击-众筹开始发送提醒按钮)
    const SMS_COUNT_ORDER ='【新奇世界】 %s，您在新奇世界购买的【 %s 】购买份数： %s ，还有十分钟订单就自动取消了，请您尽快登录支付。认筹订单详情http:// 客服电话4009000979';//众筹频道 订单系统 生成新订单-未支付----自动取消前10分钟 
    const SMS_COUNT_ORDEROK = '【新奇世界】 %s，您已在新奇世界成功购买【 %s 】购买份数： %s ，将于购买后第二日起产生收益，届时可登陆新奇世界个人中心-众筹收益模块中进行查看。认筹订单详情http:// 客服电话4009000979';//众筹频道 订单系统 支付完成新订单
    const SMS_COUNT_FQREMIND = '【新奇世界】您在新奇世界关注的分权项目【 %s 】已经开始认购了，请您及时登录网站查看购买，项目不多先来先得哦~分权项目详情http:// 客服电话4009000979';//分权频道 提醒  项目为收藏项目且状态从展示中转为认购中
    const SMS_COUNT_FQORDER = '【新奇世界】 %s，您在新奇世界购买的【 %s 】购买份数： %s ，还有十分钟订单就自动取消了，请您尽快登录支付。认筹订单详情http:// 客服电话4009000979';//分权频道 订单系统 生成新订单-未支付----自动取消前10分钟
    const SMS_COUNT_FQDINGJIN = '【新奇世界】 %s，您已在新奇世界成功提交2000元定金，预定项目为【 %s 】购买份数： %s 。为了避免不必要损失，请于10天内完成付款，尽快完成登录支付。认筹订单详情http:// 客服电话4009000979';//分权频道 订单系统 生成新订单-已支付2000元定金
    const SMS_COUNT_FQORDEROK = '【新奇世界】 %s，您已在新奇世界成功购买【 %s 】购买份数： %s ，可登陆新奇世界个人中心进行查看。认筹订单详情http:// 客服电话4009000979';//分权频道 订单系统 支付完成新订单
    const SMS_COUNT_FHRECOMMEND = '亲爱的 %s，您是否正在考虑置业？您的小伙伴"%s"给您推荐了一个很棒的房源：中弘西岸首府，点击链接查看详情：http://m.fanghu.com/f/021212.html，注册加入，购房还可以有折扣哦！【房乎】';//房乎网 推荐小伙伴   ---用户于项目页下方，输入小伙伴手机号及姓名并提交，并判断该用户是否存在，如果不存在库中，则发送短信


    // 致命错误码，记录错误日志，邮件提醒
    static $arrFatalErrorCode = array('512', '513', '514', '515', '526');
    // 短信服务错误日志key
    const ERROR_LOG_KEY = '[third_service_error][mob_sms]';
    /**
    * mob.com SMS服务状态检查
    * 
    * @return boolean
    */
    public static function checkSmsServiceStatus() {
            // api setting
            $url = self::SMS_SERVICE_ENDPOINT . self::SMS_API_CHECK_STATUS;

            $postParams = array();

            // request
            $response = self::doPost($url, $postParams);

            $result = false;
            if (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_OK)) {
                    $result = true;
            } else {
                    // error log
                    AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service is down!', 'parameters' => array(), 'response' => $response));
            }

            return $result;
    }

    /**
     * 发送验证码
     * 
     * @param  string $phone     手机号
     * @param  string $zoneCode  地区编号
     * @return boolean           发送成功或是失败
     */
    public static function sendVerifyCode($phone, $zoneCode = '86') {
            // sms service health check
            $isServiceOk = self::checkSmsServiceStatus();

            $result = false;
            if ($isServiceOk) {

                    // rest setting
                    $url = self::SMS_SERVICE_ENDPOINT . self::SMS_API_SEND_MSG;
                    
                    $postParams = array(
                        'appkey' => self::SMS_SERVICE_APP_KEY,
                        'phone' => $phone,
                        'zone' => $zoneCode,
                            //'tempCode' => '', //非必填项
                    );

                    // request
                    $response = self::doPost($url, $postParams);

                    // add log
                    $parameters = array_merge(array('url' => $url), $postParams);
                    AresLogManager::log_bi(array('logKey' => '[sms][' . __METHOD__ . ']', 'desc' => 'send verify code', 'parameters' => $parameters, 'response' => $response));

                    // response
                    if (!empty($response['status']) && ($response['status'] == self::SMS_ERROR_CODE_OK)) {
                            //
                            $result = true;
                    } elseif (!empty($response['status']) && in_array($response['status'], self::$arrFatalErrorCode)) {
                            //
                            AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => 'sms service error!', 'parameters' => $parameters, 'response' => $response));
                    }
            }

            return $result;
    }
    /*
    * 注册 验证码 返回一个是手机号、内容
    * @param params 数组形式
    * @param  code 验证码
    */
    public static  function sendZhuceCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $code = !empty($params['code']) ? $params['code'] : '';
            $content = sprintf(self::SMS_COUNT_ZHUCE,$code);
        }
        return self::sendSMS($phone, $content);
    }
    /*
    * 注册 注册成功
    * @param params 数组形式
    * @param  phone 手机号 
    */
    public static  function sendZhuceCodeOk($phone, $zoneCode = '86', $params){

        if(in_array($params) && !empty($params)){
            $content = sprintf(self::SMS_COUNT_ZHUCEOK,$phone);
        }
        return self::sendSMS($phone, $content);        
    }
    /*
    * 注册 个人资料/账户与安全信息修改 
    * @param params 数组形式
    * @param  code 验证码 
    */
    public static  function sendAccountCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $code = !empty($params['code']) ? $params['code'] : '' ;
            $content = sprintf(self::SMS_COUNT_ACCOUNT,$code);
        }
        return self::sendSMS($phone, $content);     
    }
    /*
    * 众筹频道   提醒  
    * @param params 数组形式
    * @param  title 商品名称 
    */
    public static  function sendRemindCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $title = !empty($params['title']) ? $params['title'] : '';
            $content = sprintf(self::SMS_COUNT_REMIND,$title);
        }
        return self::sendSMS($phone, $content);         
    }
    /*
    * 众筹频道   订单系统    生成新订单-未支付----自动取消前10分钟
    * @param params 数组形式,要有先后顺序
    * @param  username 用户名称
    * @param  title 商品名称
    * @param  num 商品数量  
    */
    public static  function sendOrderCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $username = !empty($params['username']) ? $params['username'] : '';
            $title = !empty($params['title']) ? $params['title'] : '';
            $num = !empty($params['num']) ? $params['num'] : '';
            $content = sprintf(self::SMS_COUNT_ORDER,$username,$title,$num);
        }
        return self::sendSMS($phone, $content); 
    }
    /*
    * 众筹频道   订单系统    支付完成新订单
    * @param  params 数组 
    * @param  username 用户名称
    * @param  title 商品名称
    * @param  num 商品数量    
    */
    public static  function sendOrderOkCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $username = !empty($params['username']) ? $params['username'] : '';
            $title = !empty($params['title']) ? $params['title'] : '';
            $num = !empty($params['num']) ? $params['num'] : '';
            $content = sprintf(self::SMS_COUNT_ORDEROK,$username,$title,$num);
        }
        return self::sendSMS($phone, $content); 
    }
    /*
    * 分权频道   提醒  
    * @param  params 数组 
    * @param  title 商品名称
    */
    public static  function sendFqRemindCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $title = !empty($params['title']) ? $params['title'] : '';
            $content = sprintf(self::SMS_COUNT_FQREMIND,$title);
        }
        return self::sendSMS($phone, $content); 
    }
    /*
    * 分权频道   订单系统  生成新订单-未支付----自动取消前10分钟
    * @param  params 数组  
    * @param  username 用户名称
    * @param  title 商品名称
    * @param  num 商品数量  
    */
    public static  function sendFqOrderCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $username = !empty($params['username']) ? $params['username'] : '';
            $title = !empty($params['title']) ? $params['title'] : '';
            $num = !empty($params['num']) ? $params['num'] : '';
            $content = sprintf(self::SMS_COUNT_FQORDER,$username,$title,$num);
        }
        return self::sendSMS($phone, $content);
    }
    /*
    * 分权频道   订单系统  生成新订单-已支付2000元定金 
    * @param  params 数组 
    * @param  username 用户名称
    * @param  title 商品名称
    * @param  num 商品数量  
    */
    public static  function sendFqDingjinCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $username = !empty($params['username']) ? $params['username'] : '';
            $title = !empty($params['title']) ? $params['title'] : '';
            $num = !empty($params['num']) ? $params['num'] : '';
            $content = sprintf(self::SMS_COUNT_FQDINGJIN,$username,$title,$num);
        }
        return self::sendSMS($phone, $content);
    }
    /*
    * 分权频道   订单系统  支付完成新订单
    * @param  params 数组 
    * @param  username 用户名称
    * @param  title 商品名称
    * @param  num 商品数量  
    */
    public static  function sendFqOrderokCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $username = !empty($params['username']) ? $params['username'] : '';
            $title = !empty($params['title']) ? $params['title'] : '';
            $num = !empty($params['num']) ? $params['num'] : '';
            $content = sprintf(self::SMS_COUNT_FQORDEROK,$title);
        }
        return self::sendSMS($phone, $content);
    }
    /*
    * 房乎网   推荐小伙伴 
    * @param  params 数组 
    * @param  username 用户名称
    * @param  haoyou 好友 
    */
    public static  function sendFhRecommendCode($phone, $zoneCode = '86', $params){
        if(in_array($params) && !empty($params)){
            $username = !empty($params['username']) ? $params['username'] : '';
            $haoyou = !empty($params['haoyou']) ? $params['haoyou'] : '';
            $content = sprintf(self::SMS_COUNT_FHRECOMMEND,$username,$haoyou);
        }
        return self::sendSMS($phone, $content);
    }

    public static function sendSMS($phone, $content) {
        //todo

        return true;
    }



}


?>