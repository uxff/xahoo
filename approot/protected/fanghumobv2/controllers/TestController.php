<?php

/**
 * 测试控制器，不参与业务
 */
class TestController extends Controller {
        /*         * ** test action, remove  *** */

        public function actionSmsSend() {
                $phone = $this->getString($_GET['phone']);

                $hidedMobile = AresUtil::formatChineseMobile($phone);
                print_r('you mobile is ' . $hidedMobile);
                echo '<BR />';
                echo '<BR />-----------RESPONSE-----------<BR />';
                if (!empty($phone) && AresValidator::isValidChineseMobile($phone)) {
                        $boolSendResult = false;//SmsDataService::sendVerifyCode($phone);
                        $message = $boolSendResult ? 'success' : 'fail';
                        print_r('== send sms verfiyCode result=' . $message);
                } elseif (!empty($phone)) {
                        print_r('== phone is invalid');
                } else {
                        print_r('== phone is null');
                }

                echo '<BR />+++++++++++++++ Warning ++++++++++++++++++++';
                echo '<div style="color:#FF0000">NOTE: 短信发送为付费服务，请谨慎测试</div>';
        }

        /**
         * [actionSmsVerify description]
         * @return [type] [description]
         */
        public function actionSmsVerify() {
                $phone = $this->getString($_GET['phone']);
                $verfiyCode = $this->getString($_GET['code']);

                $hidedMobile = AresUtil::formatChineseMobile($phone);
                print_r('you mobile is ' . $hidedMobile);
                echo '<BR />';
                print_r('you verfiyCode is ' . $verfiyCode);
                echo '<BR />';
                echo '<BR />-----------RESPONSE-----------<BR />';
                if (!empty($phone) && AresValidator::isValidChineseMobile($phone)) {
                        //
                        if (!empty($verfiyCode) && preg_match('/\d{4}/', $verfiyCode)) {
                                $arrSendResult = SmsDataService::verify($phone, $verfiyCode);
                                print_r('== send sms verfiyCode result=');
                                echo '<BR />';
                                print_r($arrSendResult);
                        } elseif (!empty($verfiyCode)) {
                                print_r('== verfiyCode is invalid');
                        } else {
                                print_r('== verfiyCode is null');
                        }
                } elseif (!empty($phone)) {
                        print_r('== phone is invalid');
                } else {
                        print_r('== phone is null');
                }

                echo '<BR />-----------';
        }

        /**
         * [actionEmailSend description]
         * @return [type] [description]
         */
        public function actionEmailSend() {
                $mailTo = $this->getString($_GET['email']);

                $mailData = array(
                    'welcome_name' => '强小强',
                    'new_password' => '123456',
                    'verify_code' => 'xYv3Bse',
                );


                if (empty($mailTo)) {
                        die('== email address is null');
                } elseif (!AresValidator::isValidEmail($mailTo)) {
                        die('== email address is invalid');
                }

                print_r('you email is ' . $mailTo);
                echo '<hr>';


                EmailDataService::sendForgetPassword($mailTo, $mailData);
                print_r('== send password forget email success ==');
                echo '<BR />';

                EmailDataService::sendRegisterWelcome($mailTo, $mailData);
                print_r('== send register welcome email success ==');
                echo '<BR />';

                EmailDataService::sendVerifyCode($mailTo, $mailData, true);
                print_r('== send email update email success ==');
                echo '<BR />';

                EmailDataService::sendVerifyCode($mailTo, $mailData, false);
                print_r('== send email active email success ==');
                echo '<BR />';
        }
        
    public function actionWeixin() {
        //$jssdk = new JSSDK('wxfa0715ef755604a4', '4e71b452f06a732416d2d3a522c6ebc3');

        $arrRender = array(
			'gShowHeader' => false,
			'gShowFooter' => true,
			'pageTitle' =>'我的房乎',
        );
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('test/weixin.tpl',$arrRender);
    }

    public function actionWeixinecho() {
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = 'FFFF';
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

    public function actionMc() {
        $key = $_GET['key'];
        $key = $key ? $key : 'key1';
        $mc = new Memcache;
        $ret = $mc->connect('127.0.0.1', 11211);
        echo 'connect()=['.$ret.']=[';print_r($ret);echo ']';

        $ret = $mc->set($key, time(), 0, 3600);
        echo 'set('.$key.')=['.$ret.']';

        $val = $mc->get($key);
        echo 'get('.$key.')=['.$val.'];';
        echo 'mc=';print_r($mc);

        $stats = $mc->getExtendedStats();
        echo 'stats=';print_r($stats);
        echo 'ver=';print_r($mc->getVersion());
    }
    public function actionCache() {
        $key = $_GET['key'];
        $key = $key ? $key : 'key3';
        $ret = Yii::app()->cache->set($key, time(), 3600);
        $val = Yii::app()->cache->get($key);
        print_r($val);
        
    }
    public function actionPhpinfo() {
        phpinfo();
    }
    public function actionLog() {
        $text = $_GET['text'];
        Yii::log('log content:'.$text.''.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
    }
    public function actionTestabrate() {
        $n = (int)$_GET['n'] ? (int)$_GET['n'] : 200000;
        $ret = [];
        $calcRet = [];
        $all = 0;
        for ($i=0; $i<$n; ++$i) {
            $g = mt_rand(1, 10000) % 2;
            $ret[$g] ++;
            $calcRet[$g] ++;
            if ($g==0) {
                if (mt_rand(1, 10000) % 2==1) {
                    $g = mt_rand(1, 10000) % 2;
                    $calcRet[$g] ++;
                    if ($g==0) {
                        if (mt_rand(1, 10000) % 3==1) {
                            $g = mt_rand(1, 10000) % 2;
                            $calcRet[$g] ++;
                        }
                    }
                }
            }
        }
        ksort($ret);
        ksort($calcRet);
        print_r($ret);
        print_r($calcRet);
        echo '0+='.($calcRet[0]-$ret[0]).' 1+='.($calcRet[1]-$ret[1]);
    }
}
