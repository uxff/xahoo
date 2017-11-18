<?php

Yii::import('application.common.extensions.weibolib.*');

/**
 */
class WeiboController extends BaseController
{
    const WB_AKEY = '2213721265';
    const WB_SKEY = '2c472f8aadcdceb22095d97e0a30d688';
    public $WB_CALLBACK_URL;
    public $o;
    public $wb_url;

    public function init() {
        parent::init();
        $scheme = 'http';
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on' || $_SERVER['HTTPS']==1)
         || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https') {
            $scheme = 'https';
        }
        $this->WB_CALLBACK_URL = $scheme.'://'.$_SERVER['HTTP_HOST'].'/oauthcallback.php';
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->o = new WeiboOAuthV2(self::WB_AKEY, self::WB_SKEY);
        $this->wb_url = $this->o->getAuthorizeURL( $this->WB_CALLBACK_URL, 'code', 'wb');
        return $this->render('index', [
            'wb_url' => $this->wb_url,
            'info' => $msg,
        ]);
    }

    /**
     * 
     * @param string $code
     * @return mixed
     */
    public function actionCodetotoken($code)
    {
        $keys = array();
        $keys['code'] = $code;
        $keys['redirect_uri'] = $this->WB_CALLBACK_URL;
        try {
            $this->o = new WeiboOAuthV2(self::WB_AKEY, self::WB_SKEY);
            $token = $this->o->getAccessToken('code', $keys);
        } catch (Exception $e) {
            // 授权失败
            $msg = $e->getMessage();
            Yii::error('auth failed:'.$e->getMessage().' code='.$code);
            return $this->render('codetotoken', [
                'wb_url' => $this->wb_url,
                'info' => $token,
                'msg' => $msg,
            ]);
        }
        Yii::warning('code='.$code.' token='.json_encode($token));
        // 授权成功 成功后需要把授权信息存放在数据库
        try {
            $sql = 'select wid from wbauth where wid='.$token['uid'];
            $ret = Yii::$app->db->createCommand($sql)->queryAll();
            if (empty($ret)) {
                // insert
                $arr = [
                    'wid' => $token['uid'],
                    'token' => $token['access_token'],
                    'expires_in' => $token['expires_in'],
                    'create_time' => date('Y-m-d H:i:s'),
                ];
                $insertRet = Yii::$app->db->createCommand()->insert('wbauth', $arr)->execute();
                if (!$insertRet) {
                     Yii::error('insert wbauth error:');
                }
            } else {
                // update 
                $arr = [
                    //'wid' => $token['uid'],
                    'token' => $token['access_token'],
                    'expires_in' => $token['expires_in'],
                ];
                $updateRet = Yii::$app->db->createCommand()->update('wbauth', $arr, ['wid'=>$token['uid']])->execute();
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
            Yii::error('save wbauth error:'.$e->getMessage());
            return $this->render('codetotoken', [
                'wb_url' => $this->wb_url,
                'info' => $token,
                'msg' => $msg,
            ]);
        }
        return $this->redirect(['site/index', 'from'=>'oauth']);
        //return $this->render('codetotoken', [
        //    'wb_url' => $this->wb_url,
        //    'info' => $token,
        //    'msg' => $msg,
        //]);
    }

    public function actionHello()
    {
        /* 建表
CREATE TABLE `wbauth` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `wid` bigint(20) NOT NULL,
  `token` varchar(40) NOT NULL DEFAULT '',
  `expires_in` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间(认证时间)',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `mark` int(10) unsigned NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `verify` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `wid` (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        */
        //print_r($_SERVER);
        echo 'hello';
        return false;
        $arr = [
            'wid' => 1,
            'token' => 'ssss',
            'expires_in' => 1212,
        ];
        try {
            $insertRet = Yii::$app->db->createCommand()->insert('wbauth', $arr)->execute();
            if (!$inserRet) {
                echo 'ret is false:';
            }
            print_r($inserRet);exit;
        } catch (Exception $e) {
            echo 'exception:';echo $e->getMessage();exit;
        }
    }
}
