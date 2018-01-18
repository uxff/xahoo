<?php

class SiteController extends BaseController {

    public function actionIndex() {
        //$this->saveSignage();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();

        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $welcomeName = Yii::app()->loginUser->guestName;
            $member_id = 0;
            $signage = '';
        } else {
            $welcomeName = Yii::app()->loginUser->name;
            $member_id = Yii::app()->loginUser->getUserId();
            $arrMember = UCenterStatic::getUserProfile($member_id);
            $signage = $arrMember['userProfile']['signage'];
        }

        // 首页banner图
        $bannerModel = PicSetModel::model()->orderBy('weight ASC, t.id desc')->with('pics')->find('t.used_type='.PicSetModel::USED_TYPE_BANNER);
        // 首页轮播图
        $actPicsModel = PicSetModel::model()->orderBy('weight ASC, t.id desc')->with('pics')->find('t.used_type='.PicSetModel::USED_TYPE_ACTIVITY);
        
        // 热推
        $hotArtModels = ArticleModel::model()->orderBy('t.create_time desc')->findAll(array('condition'=>'status=2','limit'=>50));

        foreach ($hotArtModels as &$model) {
            if (empty($model->visit_url)) {
                $model->visit_url = $this->createAbsoluteUrl('article/show', [
                    'id' => $model->id,
                    'sign' => $model->makeSign($model->id),
                ]);

            }
        }


        $arrRender = array(
            'gShowFooter' => true,
            'isGuest' => $isGuest,
            'welcomeName' => $welcomeName,
            'actPicsModel' => $actPicsModel,
            'bannerModel' => $bannerModel,
            'signage' => $signage,
            'logout_return_url' => $this->createAbsoluteUrl("site/index"),
            'isIndex' => TRUE,
            'pageTitle' => '首页',
            'hotArtModels' => $hotArtModels,
        );
		$this->layout = "layouts/site_index.tpl";
		$this->smartyRender('site/index.tpl', $arrRender);
        //$this->smartyRender('site/index.tpl', $arrRender);
    }

    /**
     *  关于我们
     */
    public function actionAboutUs() {
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            //'return_url' => 'javascript:history.go(-1);',
            'pageTitle' => '关于我们',
            'logout_return_url' => $this->createAbsoluteUrl("site/aboutus"),
        );
        $this->layout = "layouts/default_v2.tpl";
        $this->smartyRender('site/aboutus.tpl', $arrRender);
       // $this->smartyRender('site/aboutus.tpl', $arrRender);
    }

    /**
     *  联系我们
     */
    public function actionContactUs() {
        $arrRender = array(
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('member/index'),
            'headerTitle' => '联系我们',
        );
        $this->smartyRender('site/contactus.tpl', $arrRender);
    }

    /**
     * 登陆入口页面
     */
    public function actionLogin() {
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if (!empty($_GET['return_url'])) {
            $return_url = $this->outPutString($_GET['return_url']);
        } else {
            $return_url = $this->createAbsoluteUrl('site/index');
        }
        // 已登录则跳转到个人中心首页
        if (!$isGuest) {
            //$this->redirect($this->createAbsoluteUrl('member/index'));
            $this->redirect($return_url);
        }

        // 未登录跳转到UCenter
        $params = array(
            'return_url' => $return_url,
        );
        //$ucenterLoginUrl = $this->createUCenterUrl('user/login', $params);
        $ucenterLoginUrl = $this->createAbsoluteUrl('user/login', $params);
        $this->redirect($ucenterLoginUrl);
        /*
          $arrMsgStack = Yii::app()->loginUser->getFlashes();
          require_once( 'oauth/weibo/config.php' );
          require_once( 'oauth/weibo/saetv2.ex.class.php' );
          $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
          $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
          require_once('oauth/qq/Qq.php');
          $qq = new Qq();
          $qq_url = $qq->getAuthUrl();
          if ($isGuest) {
          $arrRender = array(
          'gShowHeader' => true,
          'return_url' => $this->createAbsoluteUrl('site/index'),
          'headerTitle' => '登录',
          'arrMsgStack' => $arrMsgStack,
          'sina_url' => $code_url,
          'qq_url' => $qq_url,
          );
          $this->smartyRender('site/login.tpl', $arrRender);
          } else {
          $this->redirect($this->createAbsoluteUrl('site/index'));
          }
         */
    }

    /**
     * 手机注册入口页面
     */
    public function actionRegister() {
        $_mz_utm_source = '';
        if(isset($_GET['_mz_utm_source'])){
            $_mz_utm_source = $this->getInt($_GET['_mz_utm_source']);
        }
        $params = array(
            'btnSource' => 50001,
            '_mz_utm_source' => $_mz_utm_source,
            'return_url' => $this->createAbsoluteUrl('site/index'),
        );
        //$ucenterRegisterUrl = $this->createUCenterUrl('user/register', $params);
        $ucenterRegisterUrl = $this->createAbsoluteUrl('user/register', $params);

        $this->redirect($ucenterRegisterUrl);
        /*
          $arrMsgStack = Yii::app()->loginUser->getFlashes();
          $from = '';
          if (isset($_GET['from']) && $_GET['from'] != '') {
          $from = $_GET['from'];
          }

          $arrRender = array(
          'gShowHeader' => true,
          'return_url' => $this->createAbsoluteUrl('site/index'),
          'headerTitle' => '手机注册',
          'arrMsgStack' => $arrMsgStack,
          'from' => $from,
          );
          $this->smartyRender('site/register.tpl', $arrRender);
         */
    }

    /**
     * 邮箱注册入口页面
     */
    public function actionRegisterEmail() {
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $from = '';
        if (isset($_GET['from']) && $_GET['from'] != '') {
            $from = $_GET['from'];
        }

        $arrRender = array(
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('site/index'),
            'headerTitle' => '邮箱注册',
            'arrMsgStack' => $arrMsgStack,
            'from' => $from,
        );
        $this->smartyRender('site/registeremail.tpl', $arrRender);
    }

    /**
     * 忘记密码手机找回
     */
    public function actionforgetMobile() {
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $arrRender = array(
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('site/index'),
            'headerTitle' => '忘记密码',
            'arrMsgStack' => $arrMsgStack,
        );
        $this->smartyRender('site/forgetmobile.tpl', $arrRender);
    }

    /**
     * 忘记密码邮箱找回
     */
    public function actionforgetEmail() {
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $arrRender = array(
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('site/index'),
            'headerTitle' => '忘记密码',
            'arrMsgStack' => $arrMsgStack,
        );
        $this->smartyRender('site/forgetemail.tpl', $arrRender);
    }

    /**
     * 非法访问页面
     * @return void
     */
    public function actionError() {
        //echo '404! Page Not Found';
        $arrRender = array(
            'showFooter' => false,
        );
        $this->smartyRender('errorview/404.tpl', $arrRender);
    }

    /**
     * 会员绑定第三方帐号页面
     */
    public function actionBind() {
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $from = '';
        if ($_GET['from'] != '') {
            $from = $_GET['from'];
        }
        $arrRender = array(
            'from' => $from,
            'arrMsgStack' => $arrMsgStack,
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('site/index'),
            'headerTitle' => '绑定',
        );

        $this->smartyRender('site/bind.tpl', $arrRender);
    }

    public function actionTest() {
        require_once('phpqrcode/QR.php');
        $qr = new QR();
        $qr->config = array('data' => 'http://www.baidu.com');
        $url = $qr->generatePng();

        echo "<img src='{$url}' />";
    }

    /**
     * Method of getting back password
     */
    public function actionFogotPassword() {
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $arrRender = array(
            'arrMsgStack' => $arrMsgStack,
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('site/login'),
            'headerTitle' => '忘记密码',
        );
        $this->smartyRender('site/fogotpassword.tpl', $arrRender);
    }

    /**
     * 密保问题找回密码页面
     */
    public function actionForgotQuestion() {
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $arrRender = array(
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('site/index'),
            'headerTitle' => '忘记密码',
            'arrMsgStack' => $arrMsgStack,
        );
        $this->smartyRender('site/forgetquestion.tpl', $arrRender);
    }

    /**
     * 使用密保问题找回密码方法
     */
    public function actionFindPasswordByQuestion() {
        //判断该帐号是否设置密保问题
        $security_question = MemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $this->getString($_POST['member_id'])));
        var_dump($security_question);
        if ($security_question) {
            //如果用户设置了密保问题
        } else {
            //用户没有设置密保问题
        }
    }

    /*
        迁移用户登录需要的代码 收不到验证码 页面
    */
    public function actionUnacceptverifycode() {
        //$return_url = $this->checkReturnUrl();
        $return_url = $this->outPutString($_GET['return_url']);
        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '收不到验证码',
            'return_url' => $return_url, //$this->createAbsoluteUrl('user/register'),//,array('return_url'=>$return_url)
        );
        $this->smartyRender('site/unacceptverifycode.tpl', $arrRender);
    }

    public function actionInvite() {
        $isGuest = Yii::app()->loginUser->getIsGuest();
        Yii::app()->getModule('points');
        // 从积分规则获取分值
        $pointsRuleRegByInvite = PointsRuleModel::model()->find('rule_key="'.PointsRuleModel::RULE_KEY_REGISTER_BY_INVITE.'"');
        $pointsRuleFinishInvite = PointsRuleModel::model()->find('rule_key="'.PointsRuleModel::RULE_KEY_FINISH_INVITE_FRIEND.'"');

        if ($isGuest) {
            // 未登录 别人点开
            $member_id = 0;
            $inviteCode = $_GET['invite_code'];
            $this->layout = 'layouts/default_v2.tpl';

            $arrRender = array(
                'gShowHeader' => false,
                'gShowFooter' => false,
                'pageTitle' => '一呼百应',
                'invite_code' => $inviteCode,
                //'return_url' => $return_url, //$this->createAbsoluteUrl('user/register'),//,array('return_url'=>$return_url)
                'points_reg_by_invite' => $pointsRuleRegByInvite->points,
            );
            $this->smartyRender('site/invite.tpl', $arrRender);
        } else {
            // 已登录，自己打开
            $member_id = Yii::app()->loginUser->getUserId();

            $inviteCode = $_GET['invite_code'];
            if (!$inviteCode) {
                $inviteCode = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;
            }
            //$invite_code = $invite_code_model->invite_code;

            $arrRender=array(
                'gShowHeader' => true,
                'gShowFooter' => true,
                'return_url' => $return_url,
                'pageTitle' =>'邀请好友',
                'invite_code' => $inviteCode,
                'points_reg_by_invite' => $pointsRuleRegByInvite->points,
                'points_finish_invite' => $pointsRuleFinishInvite->points,
            );

            $this->layout = "layouts/default_v2.tpl";
            $this->smartyRender('my/invitefriend.tpl',$arrRender);
        }
    }
}
