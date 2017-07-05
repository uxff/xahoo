<?php

/**
 * 默认控制器，处理首页/错误页
 */
class OAuthController extends Controller {

        public function actionIndex() {
                echo 'index';
        }

        public function actionTest() {
                header('Content-Type: text/html; charset=UTF-8');
                require_once( 'oauth/weixin/WeichatAuth.php');
                require_once( 'oauth/weibo/config.php' );
                require_once( 'oauth/weibo/saetv2.ex.class.php' );


                $o = new WeichatAuth();
                $weichat_url = $o->get_authorize_url('http://spf.xqsj.com/ucenter.php?r=oauth/login&ft=weichat');
                $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);

                $sina_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
                ?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>新浪微博PHP SDK V2版 Demo - Powered by Sina App Engine</title>
                        </head>

                        <body>
                                <!-- 授权按钮 -->
                                <p><a href="<?= $sina_url ?>">点击进入微博授权页面</a></p>
                                <p><a href="<?= $weichat_url ?>">点击进入微信授权页面</a></p>
                        </body>
                </html>
                <?php
                }

                /**
                 * 登陆入口页面
                 */
                public function actionLogin() {
                session_start();
                require_once( 'oauth/weibo/config.php' );
                require_once( 'oauth/weibo/saetv2.ex.class.php' );

                $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
                if (isset($_REQUEST['code'])) {
                $keys = array();
                        $keys['code'] = $_REQUEST['code'];
                        $keys[ 'redirect_uri'] = WB_CALLBACK_URL;
                        try {
                            $token = $o->getAccessToken('code', $keys);
                        } catch(OAuthException $e) {

                        }

                }
                $member = new SaeTClientV2(WB_AKEY, WB_SKEY, $token['access_token']);
                $member_info = $member -> show_user_by_id($token['uid']);

                if ($token) {
                        $_SESSION['token'] = $token;
                        $_SESSION['third_info'] = $member_info;
                        setcookie('weibojs_' . $o->client_id, http_build_query($token));
                        $this->redirect('ucenter.php?r=User/thirdPart&from=sina');
                        } else {
                            echo '授权失败。';
                        }
                }

                                public function actionList() {
                        session_start();

                $c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
                        $ms = $c->home_timeline(); // done
                        $uid_get = $c->get_uid();
                $uid = $uid_get['uid'];
                          $user_message = $c->show_user_by_id($uid); //根据ID获取用户等基本信息
                print_r($user_message);
                }


       /**
        * qq第三方验证登录
        */
        public function actionQqLogin() {
            session_start();
//            var_dump($_SESSION['state']);die;
            require_once('oauth/qq/Qq.php');
            //var_dump($_REQUEST);
            $qq = new Qq();
            $access_token = $qq->qq_callback();
//            var_dump($_SESSION);die;
            $_SESSION['token']['access_token'] = $access_token;
            $uid = $qq->get_openid($access_token);
            $_SESSION['token']['uid'] = $uid;
            //var_dump($qq->$access_token);
            $user_info = $qq->getUserInfo();
            $_SESSION['third_info'] = json_decode($user_info);
            $this->redirect('ucenter.php?r=User/thirdPart&from=qq');
        }

        /**
         * 微信第三方登录回调地址
         */
        public function actionWeixinLogin() {
            session_start();
            require_once( 'oauth/weixin/WeichatAuth.php');
            $weixin = new WeichatAuth();
            if(isset($_GET['code'])) {
                //获取code码
                $code = $this->getString($_GET['code']);
                $Tokens = $weixin->get_access_token($code);
                $access_token = $Tokens['access_token'];
                $_SESSION['token']['access_token'] = $access_token;
                $openId = $Tokens['openid'];
                $UserInfo = $weixin->get_user_info($access_token, $openId);
                $_SESSION['token']['user_info'] = $UserInfo;
                $_SESSION['token']['uid'] = $UserInfo['openid'];
                $this->redirect('ucenter.php?r=User/thirdPart&from=weixin');
            } else {


            }
        }

}

