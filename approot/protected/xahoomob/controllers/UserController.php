<?php
//Yii::import('application.ucentermob.config.*.php');
Yii::import('application.ucentermob.api.*');
Yii::import('application.ucentermob.models.*');
Yii::import('application.ucentermob.components.*');
Yii::import('application.ucentermodels.*');
Yii::import('application.ucentermob.api.UCenterStatic');
Yii::import('application.common.extensions.sms.*');

class UserController extends Controller {
	
	/**
	 * 我的首页
	 */
	public function actionIndex() {
		$this->checkLogin();
		$arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '用户中心1',
		);
		$this->smartyRender('user/index.tpl', $arrRender);
	}

	/**
	 * 退出
	 */
	public function actionLogout() {
		$cookie = Yii::app()->request->getCookies();
		$return_url = $cookie['return_url']->value;
		//if(empty($return_url)){
		//	$return_url = $this->outPutString($_GET['return_url']);
		//}
		$urlarr = parse_url($return_url);
		$url = $urlarr['scheme'] . '://' . $urlarr['host'] . $urlarr['path'];
		Yii::app()->loginUser->logoutAndClearStates();
		$this->redirect($url);
	}

	/**
	 * 登陆入口页面
	 */
	public function actionLogin() {
        session_start();

		$return_url = $this->outPutString($_GET['return_url']);
		if (empty($return_url)) {
			$return_url = $this->createAbsoluteUrl('my/index');
		}

		$arrMsgStack = Yii::app()->loginUser->getFlashes();
		$isGuest = Yii::app()->loginUser->getIsGuest();

		// 第三方登陆
		require_once( 'oauth/weibo/config.php' );
		require_once( 'oauth/weibo/saetv2.ex.class.php' );
		$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);

		$WB_CALLBACK_URL = $this->createAbsoluteUrl('oAuth/login', array('ft' => 'weibo'));
		$code_url = $o->getAuthorizeURL($WB_CALLBACK_URL);
		//$code_url = $o->getAuthorizeURL('http://muc.testhifang.fangfull.com/ucenter.php?r=oAuth/login&ft=weibo');
		//var_dump($code_url);die;

		require_once('oauth/qq/Qq.php');
		$qq = new Qq();
		$QQ_CALLBACK_URL = $this->createAbsoluteUrl('OAuth/qqLogin');
		$qq_url = $qq->getAuthUrl($QQ_CALLBACK_URL);
		//$qq_url = $qq->getAuthUrl('http://muc.testhifang.fangfull.com/OAuth/qqLogin');

		require_once('oauth/weixin/WeichatAuth.php');
		$WX_CALLBACK_URL = $this->createAbsoluteUrl('OAuth/weixinLogin');
		$weixin = new WeichatAuth();
		$weixin_url = $weixin->get_authorize_url($WX_CALLBACK_URL);

		// 登陆状态检测
		if ($isGuest) {
			$arrRender = array(
                'gShowHeader' => true,
                'gShowFooter' => true,
                'return_url' => $return_url,
                'pageTitle' => '登录',
                'arrMsgStack' => $arrMsgStack,
                'sina_url' => $code_url,
                'qq_url' => $qq_url,
                'weixin_url' => $weixin_url,
			);

			$this->layout = "layouts/user.tpl";
			$this->smartyRender('user/login.tpl', $arrRender);
		} else {
			//echo '您已经登录';
			$this->redirect($return_url);
		}
	}

	/**
	 * 登陆
	 */
	public function actionLoginForm() {
        session_start();

		// preprocess parameters
		$username = strtolower($this->getString($_POST['username']));
		$password = $this->getString($_POST['password']);
		$return_url = $this->getString($_POST['return_url']);
		if (empty($return_url)) {
			$return_url = $this->createAbsoluteUrl('site/index');
		}

		$isGuest = Yii::app()->loginUser->getIsGuest();
		if ($isGuest) { // 未登录
			// 后台表单验证
			$errMsg = '';

			if (empty($username) || empty($password)) {
				$errMsg = '用户名或密码不能为空';
			} elseif (!empty($username)) {
				if (!AresValidator::isValidEmail($username) && !AresValidator::isValidChineseMobile($username)) {
					$errMsg = '请输入正确的手机号或者邮箱';
				}
			} elseif (!empty($password) && (strlen($password) < 6)) {
				$errMsg = '密码至少为6位字母数字组合';
			}

			//判断是否存在当前的用户
			$arrSqlParams = array(
                'condition' => 'member_mobile="' . $username . '" OR member_email="' . $username . '"',
			);
			$objMember = UcMember::model()->find($arrSqlParams);

			if (empty($objMember)) {
				//不存在当前用户 则返回错误信
				$errMsg = '该用户尚未注册，请先注册';
			//} elseif (AresValidator::isValidEmail($username) && ($objMember->is_email_actived == 0)) {
			//	//当前用户未激活 则返回错误信
			//	$errMsg = '邮箱尚未激活，请先去邮箱激活';
			//} elseif (AresValidator::isValidChineseMobile($username) && ($objMember->is_mobile_actived == 0)) {
			//} elseif (AresValidator::isValidChineseMobile($username) && ($objMember->member_mobile_verified == 0)) {
				//当前用户未激活 则返回错误信
				//$errMsg = '手机号尚未验证，请先验证';
			}

			// 后台表单验证错误信息提示
			if (!empty($errMsg)) {
				Yii::app()->loginUser->setFlash('error', $errMsg);
				//$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
                $return_url = $this->createAbsoluteUrl('user/login', array('return_url' => $return_url));
                $this->jsonError('用户名或密码错误', $return_url);
			}

			// 授权验证该用户
			$objUserIdentity = new UserIdentity($username, $password);
            // cookie 中的用户id使用 xqsj.uc_member.member_id
            $objUserIdentity->authenticate();
            // cookie 中的用户id使用 fanghu.member.member_id 暂时废弃
			//$objUserIdentity->authenticateFanghu();

			if (!$objUserIdentity->getIsAuthenticated()) {
				// 授权失败，给出错误信息提示
				Yii::app()->loginUser->setFlash('error', '用户名或密码错误!');
				//$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
                $return_url = $this->createAbsoluteUrl('user/login', array('return_url' => $return_url));
                $this->jsonError('用户名或密码错误', $return_url);
			} else {
                // 如果有session显示openid则绑定openid
                $bindInfo = $this->checkAndBindThirdPart($objMember->member_id, $objMember->member_mobile);
                if ($bindInfo&&$bindInfo['code']!=1) {
                    $this->jsonError($bindInfo['msg'], $return_url);
                    return false;
                }
                //if ($bindInfo['return_url']) {
                //    $return_url = $bindInfo['return_url'];
                //}
                
				// 授权成功，登录并保存会话信息
				Yii::app()->loginUser->loginAndSaveStates($objUserIdentity);

                // 更新最后登录时间 
                $objMember->last_login = date('Y-m-d H:i:s', time());
                $objMember->last_login_ip = Tools::getUserHostAddress();
                $objMember->login_times += 1;
                if (!$objMember->save()) {
                    Yii::log(''.$objMember->lastError().' ', 'error', __METHOD__);
                }

				//$this->redirect($return_url);
                $this->jsonSuccess('登陆成功', $return_url);
			}
		} else { // 已登录
            //// 如果有cookie显示openid则绑定openid
            //$openidFromCookie = $this->getWechatCookie();
            //if ($openidFromCookie) {
            //    $this->bindFhOpenid($openidFromCookie, Yii::app()->loginUser->getUserId(), $username);
            //}

			//$this->redirect($return_url);
            $this->jsonSuccess('您已经登陆', $return_url);
		}
	}

	/**
	 * 手机注册入口页面
	 */
	public function actionRegister() {
        session_start();

		$return_url = $this->outPutString($_GET['return_url']);
		//$return_url = $this->checkReturnUrl();

		if(empty($return_url) || $return_url == '/') {
		    $return_url = $this->createAbsoluteUrl('site/index');
		}

		//$signage = '';
		//if (!empty($_GET['signage'])) {
		//	$signage = $this->getString($_GET['signage']);
		//}else{
		//	$signage = Yii::app()->request->cookies['signage'];
		//}

		$invite_code = '';
		if (!empty($_GET['invite_code'])) {
			$invite_code = $this->getString($_GET['invite_code']);
		}else{
			//$invite_code = Yii::app()->request->cookies['invite_code'];
            $cookie = Yii::app()->request->getCookies();
            $invite_code = $cookie['invite_code']->value;
		}

		$go_url = $this->createAbsoluteUrl('user/register');
		$arrMsgStack = Yii::app()->loginUser->getFlashes();
		$arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'return_url' => $return_url,
            'pageTitle' => '手机注册',
            //'signage' => $signage,
            'invite_code' => $invite_code,
            'arrMsgStack' => $arrMsgStack,
            'sbd_url' => $this->createAbsoluteUrl('site/Unacceptverifycode', array('return_url' => $go_url)),
            'token' => Yii::app()->request->csrfToken,
		);
		$this->layout = "layouts/user.tpl";
		$this->smartyRender('user/register.tpl', $arrRender);
	}

	/**
	 * 手机注册
	 */
	public function actionRegisterForm() {
        session_start();
		 
		//post数据
		$username = strtolower($this->getString($_POST['username']));
		$password = $this->getString($_POST['password']);
		$return_url = $this->getString($_POST['return_url']);
        if (empty($return_url) || $return_url == '/') {
            $return_url = $this->createAbsoluteUrl('site/index');
        }

		$signage = $this->getString($_POST['signage']);
		$invite_code = $this->getString($_POST['invite_code']);

        $arrRet = array(
            'code' => 2,
            'msg' => '注册失败',
            'value' => '',
            'return_url' => $return_url,
        );
		// 后台表单验证
		$errMsg = '';
		if (empty($username) || empty($password)) {
			$errMsg = '用户名或密码不能为空';
		} elseif (!empty($username)) {
			if (!AresValidator::isValidChineseMobile($username)) {
				$errMsg = '请输入正确的手机号';
			}
		} elseif (!empty($password) && (strlen($password) < 6)) {
			$errMsg = '密码至少为6位字母数字组合';
		}


        // 判断 邀请码是否存在
        if ($invite_code) {
            $invite_code = MemberInviteCodeModel::correctInviteCode($invite_code);
            $inviteCodeModel = MemberInviteCodeModel::findInviteCode($invite_code);
            if (!$inviteCodeModel) {
                Yii::log('invite code not exist:'.$invite_code.' ', 'error', __METHOD__);
                $errMsg = '邀请码不存在';
            }
        }
		if (empty($errMsg)) {
            //判断 是否该账号已经注册
            $arrSqlParams = array(
                'condition' => 'member_mobile="' . $username . '"',
            );
            $checkObj = UcMember::model()->find('member_mobile=:mob', [':mob'=>$username]);
            $checkArr = is_object($checkObj) ? $this->convertModelToArray($checkObj) : array();

            if ($checkObj) { 
                $errMsg = $username.'已注册';
            }
        }
        
        if (empty($errMsg)) {
			$member = new UcMember();
			//登录名
			if (AresValidator::isValidChineseMobile($username)) {

				$register_verification = Yii::app()->params['register_verification'];
				if(!isset($register_verification) || $register_verification ){

					//判断验证码是否有效
					//$sendResult = SmsDataService::verify($username, $this->getString($_POST['vetify_code']));
					
					//验证失败则跳转
					//if (intval($sendResult['code']) != 200) {
					//	$errMsg = $sendResult['msg'];
					//	Yii::app()->loginUser->setFlash('error', $errMsg);
					//	$this->jsonError($errMsg, $return_url);
					//	exit;
					//} 
				}
				$member->member_mobile = $username;
				//$member->is_mobile_actived = 1;
                // 注册来源 fh 注册
				$member->member_from = $inviteCodeModel ? UcMember::MEMBER_FROM_FANGHU_INVITE : UcMember::MEMBER_FROM_FANGHU_REG;
			}

			$parent_id = 0;
			$is_invite = 0;

			if (!empty($signage)) {
				$objMember = UcMember::model()->find("signage=:signage", array(":signage" => $signage));
				if (!empty($objMember)) {
					$is_invite = 1;
					//$member->member_from = 2; //来源邀请
					$member->parent_id = $objMember->member_id; //会员上级编号
					$parent_id = $objMember->member_id;
				}
			}


			$member->member_password = AresUtil::encryptPassword($password);
			//$member->member_nickname = AresUtil::generateRandomStr(16);
			// $member->signage = AresUtil::generateRandomStr(16);
			$member->signage = substr(md5($username.microtime()), 0, 10);
			$member->create_time = date('Y-m-d H:i:s', time());
			$member->last_modified = date('Y-m-d H:i:s', time());
            $member->last_login = $member->last_modified;
			if ($member->insert()) {
                Yii::log('new xqsj member created:'.$username.' ', 'warning', __METHOD__);
				$member_id = $member->member_id;



                // 添加注册事件
                if (!empty($inviteCodeModel)) {
                    // 来自邀请码注册
                    // 增加计数
                    $inviteCodeModel->used_count = $inviteCodeModel->used_count + 1;
                    if ($inviteCodeModel->save()) {
                        // 保存日志
                        $inviteLogModel = new MemberInviteLogModel;
                        $inviteLogModel->inviter = $inviteCodeModel->member_id;
                        $inviteLogModel->invitee = $member_id;
                        $inviteLogModel->invite_type = 1;//1=mobile 2=email
                        $inviteLogModel->invitee_acct = $username;
                        $inviteLogModel->invite_code = $inviteCodeModel->invite_code;
                        if (!$inviteLogModel->insert()) {
                            Yii::log('cannot add invite log:'.$inviteLogModel->lastError().' ', 'error', __METHOD__);
                        }
                    } else {
                        Yii::log('cannot update invite count:'.$inviteCodeModel->lastError().' ', 'error', __METHOD__);
                    }
                    // 添加邀请注册成功事件
                    Yii::app()->getModule('event')->pushEvent($member_id, 'register_by_invite', array('inviter'=>$inviteCodeModel->member_id, 'invite_code'=>$invite_code, 'member_mobile'=>$username));
                } else {
                    // 非邀请码注册 添加注册成功事件
                    Yii::app()->getModule('event')->pushEvent($member_id, 'register', array('member_mobile'=>$username));
                }

				
				//注册成功后，自动登录
				$objUserIdentity = new UserIdentity($username, $password);// 授权验证该用户
				$objUserIdentity->authenticate();
                
                // 如果有cookie显示openid则绑定openid
                $bindInfo = $this->checkAndBindThirdPart($member->member_id, $member->member_mobile);
                //if ($bindInfo['return_url']) {
                //    $return_url = $bindInfo['return_url'];
                //}

				if (!$objUserIdentity->getIsAuthenticated()) {
					$errMsg = "恭喜您，注册成功！";
					$this->jsonError($errMsg, $return_url);
				} else {
					// 授权成功，登录并保存会话信息
					Yii::app()->loginUser->loginAndSaveStates($objUserIdentity);
					$errMsg = "注册成功，正在自动登录。";
					$this->jsonSuccess($errMsg, $return_url);
				}
				exit;
			} else {
				$errMsg = '注册失败，请重新注册';
			}
		}

		// 后台表单验证错误信息提示
		if (!empty($errMsg)) {
			Yii::app()->loginUser->setFlash('error', $errMsg);

            $this->jsonError($errMsg, $return_url);
            exit;
            // 邮箱注册不启用
			if (AresValidator::isValidEmail($username)) {
				$this->redirect($this->createAbsoluteUrl('user/registeremail', array('return_url' => $return_url)));
			} else {
				$this->redirect($this->createAbsoluteUrl('user/register', array('return_url'=>$return_url)));
			}
		}
	}


	/**
	 * 忘记密码：手机找回页面
	 */
	public function actionforgetMobile() {
        session_start();
        $return_url = $this->outPutString($_GET['return_url']);
		//$return_url = $this->checkReturnUrl();
		if(empty($return_url) || $return_url == '/') {
		    $return_url = $this->createAbsoluteUrl('user/login');
		}

		$go_url = $this->createAbsoluteUrl('user/forgetmobile');
		$arrMsgStack = Yii::app()->loginUser->getFlashes();
		$arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'return_url' => $return_url,
            'pageTitle' => '忘记密码',
            'arrMsgStack' => $arrMsgStack,
            'sbd_url' => $this->createAbsoluteUrl('site/Unacceptverifycode', array('return_url' => $go_url)),
            'token' => Yii::app()->request->csrfToken,
		);
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('user/forgetmobile.tpl', $arrRender);
	}

	/**
	 * 忘记密码：邮箱找回页面 手机版不需要
	 */
	/*
	 public function actionforgetEmail() {
	 $return_url = $this->outPutString($_GET['return_url']);

	 if(empty($return_url)) {
	 $return_url = $this->createAbsoluteUrl('site/index');
	 }
	 $go_url = $this->createAbsoluteUrl('user/register');
	 $arrMsgStack = Yii::app()->loginUser->getFlashes();
	 $arrRender = array(
	 'gShowHeader' => true,
	 'return_url' => $return_url,
	 'headerTitle' => '忘记密码',
	 'arrMsgStack' => $arrMsgStack,
	 );
	 $this->smartyRender('user/forgetemail.tpl', $arrRender);
	 }
	 */

	/**
	 * 手机找回密码
	 */
	public function actionMobilePwd() {
		session_start();
		//preprocess parameters
		$username = $this->getString($_POST['username']);
		$verifyCode = $this->getString($_POST['vetify_code']);
		$password = $this->getString($_POST['password']);
		$return_url = $this->getString($_POST['return_url']);
		
        if (empty($return_url) || $return_url == '/') {
            $return_url = $this->createAbsoluteUrl('user/login');
        }
		
		// 后台表单验证
		$errMsg = '';
		if (empty($username) || empty($password) || empty($verifyCode)) {
			$errMsg = '所有项都不能为空';
		} else {
			//查找到对应的customer
			$objMember = UcMember::model()->find('member_mobile=:member_mobile', array('member_mobile' => $username));

			if (!AresValidator::isValidChineseMobile($username)) {
				$errMsg = '请输入正确的手机号';
			} elseif (!empty($password) && (strlen($password) < 6)) {
				$errMsg = '密码至少为6位字母数字组合';
			} else {
				//判断验证码是否有效
				$sendResult = SmsDataService::verify($username, $verifyCode);
				//验证失败则跳转
				if (intval($sendResult['code']) != 200) {
					$errMsg = $sendResult['msg'];
					Yii::app()->loginUser->setFlash('error', $errMsg);
					//$this->redirect($this->createAbsoluteUrl('user/forgetmobile', array('return_url' => $return_url)));
                    return $this->jsonError($errMsg, $return_url);
				}

				$objMember->member_password = AresUtil::encryptPassword($password);

				// 更新为新密码
				if ($objMember->update()) {
					$errMsg = '更新密码成功，请登录!';
                    return $this->jsonSuccess($errMsg, $return_url);
				} else {
					$errMsg = '更新密码失败，请重新修改';
					return $this->jsonError($errMsg, $return_url);
				}
			}
		}


		//跳转到登陆页
		Yii::app()->loginUser->setFlash('error', $errMsg);
		//$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
        return $this->jsonSuccess($errMsg, $return_url);
	}

	/**
	 * 邮箱找回密码 手机版不需
	 */
	/*
	 public function actionEmailPwd() {
	 session_start();
	 $email = $this->getString($_POST['email']);
	 $return_url = $this->getString($_POST['return_url']);

	 if (AresValidator::isValidEmail($email)) {
	 $member_email = strtolower($email);
	 $objMember = UcMember::model()->find('LOWER(member_email)=:member_email', array('member_email' => $member_email));
	 }

	 if (!empty($objMember)) {
	 $new_password = AresUtil::generateRandomStr(6); //新密码
	 $objMember->member_password = AresUtil::encryptPassword($new_password);
	 // 发送邮件
	 if (!empty($objMember->member_name)) {
	 $welcome_name = $objMember->member_name;
	 } else {
	 $welcome_name = $objMember->member_email;
	 }

	 // send setting
	 $mail_to = $objMember->member_email;
	 $mail_data = array(
	 'welcome_name' => $welcome_name,
	 'new_password' => $new_password,
	 );
	 // send email
	 if ($objMember->update()) {
	 $sendResult = EmailDataService::sendForgetPassword($mail_to, $mail_data);
	 if ($sendResult['status'] == true) {
	 $status = 'success';
	 $message = '新密码已经发送到您的邮箱，请及时修改密码！';
	 } else {
	 $status = 'fail';
	 $message = '重置密码邮件发送失败，请稍后重试';
	 }
	 } else {
	 $status = 'fail';
	 $message = '更新密码失败';
	 }
	 } else {
	 $status = 'fail';
	 $message = '无效的邮箱';
	 }

	 if ($status == 'success') {
	 $errMsg = $message;
	 } else {
	 $errMsg = $message;
	 }
	 //跳转到登陆页
	 Yii::app()->loginUser->setFlash('error', $errMsg);
	 $this->redirect($this->createAbsoluteUrl('user/login',array('return_url' => $return_url)));
	 }
	 */

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

		$this->smartyRender('user/bind.tpl', $arrRender);
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
		$this->smartyRender('user/fogotpassword.tpl', $arrRender);
	}

	/**
	 * 密保问题找回密码页面 手机版不需要
	 */
	/*
	 public function actionForgotQuestion() {
	 $arrMsgStack = Yii::app()->loginUser->getFlashes();
	 $arrRender = array(
	 'gShowHeader' => true,
	 'return_url' => $this->outPutString($_GET['return_url']),
	 'headerTitle' => '忘记密码',
	 'arrMsgStack' => $arrMsgStack,
	 );
	 $this->smartyRender('user/forgetquestion.tpl', $arrRender);
	 }
	 */

	public function actionThirdPart($from) {
		session_start();
		$member_id = '';
		$is_binded = $this->_isThirdPartBinded($_SESSION['token']['uid'], $from);
		if ($is_binded) {
			//如果已经绑定则直接登录
			$member_id = $is_binded;
			//保存登录信息
			$objUserIdentity = new UserIdentity('', '');
			$objUserIdentity->thirdPartLogin($member_id);
			Yii::app()->loginUser->loginAndSaveStates($objUserIdentity);
			$this->redirect('frontendmob.php?r=site/login');
		} else {
			//没有绑定则跳转到手机、邮箱录入页面
			$this->redirect('frontendmob.php?r=user/thirdPartLoginMobile&from=' . $from);
		}
	}

	/**
	 * 判断第三方帐号是否已经绑定
	 * @param $uid int 第三方帐号编号
	 * @param $from varchar 第三笔帐号来源
	 */
	private function _isThirdPartBinded($uid, $from = '') {
		$third_part_login = UcThirdPartLogin::model()->findByPk($uid);
		if (!$third_part_login) {
			return false;
		}
		return $third_part_login->member_id;
	}

	/**
	 * 第三方登录未绑定帐号手机、邮箱录入页面
	 */
	public function actionThirdPartLoginMobile($from) {
		$arrMsgStack = Yii::app()->loginUser->getFlashes();

		// result
		$arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'return_url' => $this->createAbsoluteUrl('site/index'),
            'headerTitle' => '验证手机号码',
            'arrMsgStack' => $arrMsgStack,
            'from' => $from,
		);
		$this->smartyRender('user/thirdpartloginmobile.tpl', $arrRender);
	}

	/**
	 * 为来自第三方登录的帐号创建本地平台帐号
	 */
	public function actionCreateAccount() {
		session_start();
		//判断用户手机是否已经注册过
		//查看手机号
		$result = $this->verifyMobile($this->getString($_POST['member_mobile']), '');
		$member_id = '';
		if (!$result) {    //用户手机号没有被注册的情况
			//为用户创建新帐号及帐号相关联信息
			$member = new UcMember();
			//判断当前用户是否通过邀请来到本平台
			$cookie = Yii::app()->request->getCookies();
			if (!empty($cookie['signage']->value)) {
				$signage = $cookie['signage']->value;
				$objMember = $this->selectMember($signage);
				if (!empty($objMember)) {
					$member->member_from = 2; //来源邀请
					$member->parent_id = $objMember->member_id; //会员上级编号
				}
			}
			$member->member_mobile = $this->getString($_POST['member_mobile']);     //用户手机号
			$member->member_email = $this->getString($_POST['member_email']);       //用户电子邮箱
			$member->signage = AresUtil::generateRandomStr(16);     //插入随机识别码
			$member->member_password = $this->_randomPassword();    //插入随机密码
			$member->member_nickname = $this->getString($_POST['member_mobile']);
			//$member->is_mobile_actived = 1;
			if (is_array($_SESSION['third_info'])) {
				$member->member_nickname = $_SESSION['third_info']['name'];
			} else {
				$member->member_nickname = $_SESSION['third_info']->nickname;    //插入用户昵称
			}


			if (isset($_SESSION['token']['user_info'])) {
				$member->member_nickname = $_SESSION['token']['user_info']['nickname'];
			}

			if ($member->insert()) {

				//                                $member_id = Yii::app()->db->getLastInsertId();      //新建会员的id
				$member_id = $member->member_id;      //新建会员的id
				//初始化会员信息
				$this->MemberRegisterInit($member_id);
				$this->addPoint($member_id, 'bind_phone'); //手机绑定加积分
			} else {
				$this->smartyRender('errorview/404.tpl');
			}
		} else {
			//查询已经存在会员信息
			$member_info = UcMember::model()->findByAttributes(array('member_mobile' => $this->getString($_POST['member_mobile'])));
			$member_id = $member_info->member_id;
		}

		//为用户新建帐号并与第三方帐号进行绑定
		$third_part_login = new UcThirdPartLogin();
		$third_part_login->attributes = $_SESSION['third_info'];
		if (isset($_SESSION['token']['user_info'])) {
			$third_part_login->attributes = $_SESSION['token']['user_info'];
		}
		$third_part_login->uid = $_SESSION['token']['uid'];
		$third_part_login->access_token = $_SESSION['token']['access_token'];
		$third_part_login->member_id = $member_id;
		$third_part_login->from = $this->getString($_GET['from']);
		if ($third_part_login->insert()) {
			unset($_SESSION['weixinrefer']);
			$objUserIdentity = new UserIdentity('', '');
			$objUserIdentity->thirdPartLogin($member_id);
			Yii::app()->loginUser->loginAndSaveStates($objUserIdentity);
			$this->redirect('frontendmob.php?r=site/login');
			//                        $this->redirect($this->createAbsoluteUrl('site/login'));
		} else {
			$this->smartyRender('errorview/404.tpl');
		}
	}

	/**
	 * 随机密码生成方法
	 */
	private function _randomPassword() {
		$units = range(0, 9, 1);
		$Arrpassword = array_rand($units, 6);
		$password = implode($Arrpassword, '');
		//对密码进行加密
		$response = AresUtil::encryptPassword($password);
		return $response;
	}

	/**
	 * 验证手机号码已经注册
	 */
	private function verifyMobile($mobile) {
		$member = UcMember::model()->findByAttributes(array('member_mobile' => $mobile));
		if ($member) {
			return true;
		} else {
			return false;
		}
	}

    /*
        返回固定格式的错误
    */
    public function jsonError($msg, $return_url='', $code=1) {
        $code = 1;
        $arr = array(
            'code' => $code,
            'msg' => $msg,
            'data' => ['return_url' => $return_url.'&_ajax=1'],
            'return_url' => $return_url,
        );
        return $this->showJson($arr);
    }
    /*
        返回固定格式的错误
    */
    public function jsonSuccess($msg, $return_url='') {
        $code = 0;
        $arr = array(
            'code' => $code,
            'msg' => $msg,
            'data' => ['return_url' => $return_url.'&_ajax=1'],
            'return_url' => $return_url,
        );
        return $this->showJson($arr);
    }
	
	/**
	 * 会员权益页面
	 */
	public function actionMemberRights() {
		//加载积分模块
        Yii::app()->getModule('points');
		
		$model = new PointsRuleModel();
        $model->unsetAttributes();  // clear any default values
        
        $mySearch 	= $model->mySearch();
        $arrData 	= $mySearch['list'];
		
		$arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
			'pointsRule'  => $arrData,//积分规则列表数据
            'pageTitle'	  => '会员权益',
		);
		
		$this->layout = "layouts/user.tpl";
		$this->smartyRender('user/memberrights.tpl', $arrRender);
	}

    /*
        获取wechatopenid从cookie中
    */
    public function checkAndBindThirdPart($member_id, $member_mobile, $member_fullname='') {
        $name = Yii::app()->params['third_login_sess_name'];
        if (!isset($_SESSION[$name])) {
            Yii::log('empty session: '.$name.' ', 'warning', __METHOD__);
            return false;
        }
        $authInfo = $_SESSION[$name];
        if ($_GET['DEBUG']==1) {
            echo 'authInfo=';print_r($authInfo);exit;
        }
        // format ['plat'=>'1','appid'=>'appid','sns_id'=>'sns_id']
        switch ($authInfo['plat']) {
            case UcMemberBindSns::SNS_SOURCE_WECHAT:
                //Yii::log('prepare bind wechat:'.' ', 'warning', __METHOD__);
                $ret = $this->bindOpenid($authInfo['sns_id'], $member_id, $member_mobile, $authInfo['appid']);
                //$authInfo['return_url'] = $this->createAbsoluteUrl('Wechat/autoclose');
                break;
            case UcMemberBindSns::SNS_SOURCE_WEIBO:
                break;
            default:
                break;
        }
        //Yii::log('bind success: mid='.$objMember->member_id.' authInfo='.json_encode($authInfo).' ', 'warning', __METHOD__);
        return $ret;
    }

    /*
        绑定openid和member
            必然有手机号和openid
    */
    public function bindOpenid($openid, $member_id, $member_mobile, $appid) {
        $ret = [
            'code'  => 1,
            'msg'   => '',
            'snsModel' => null,
        ];
        if (empty($openid) || empty($member_id) || empty($member_mobile)) {
            Yii::log('empty info : mid='.$member_id.' openid='.$openid.' mobile='.$member_mobile.' ', 'error', __METHOD__);
            return $ret;
        }

        // 检查member_id是否绑定过
        $memberSns = UcMemberBindSns::model()->find('member_id=:mid and sns_appid=:appid', [':mid'=>$member_id, ':appid'=>$appid]);
        if ($memberSns) {
            // 登陆的手机号绑定过
            Yii::log('mid('.$member_id.') already bind on(openid='.$memberSns->sns_id.' mobile='.$memberSns->member_mobile.'), expect bind on oid='.$openid.' mobile='.$member_mobile.' mid='.$memberSns->member_id.' ', 'error', __METHOD__);
            if ($memberSns->sns_id == $openid) {
                // 手机号绑定的是自己绑定过的微信
                $ret['msg'] = '本账号已绑定过，并绑定正常';
                return $ret;
            } else {
                // 手机号绑定的是别人绑定的微信
                //$miscMobile = Tools::miscMobile($memberSns->member_mobile);
                $ret['msg'] = '该手机号已经绑定过别的微信，请更换手机号登录。';
                $ret['code'] = 2;
                return $ret;
            }
        }
        
        // 绑定社交关系账号
        $ucMemberBindSns = UcMemberBindSns::model()->find(
            'sns_source=:source and sns_appid=:appid and sns_id=:oid', [
                ':oid'      =>$openid,
                //':mid'      =>$member_id,     // 这两个条件可能是空的
                //':mobile'   =>$member_mobile,
                ':appid'    =>$appid,
                ':source'   =>UcMemberBindSns::SNS_SOURCE_WECHAT,
            ]);

        $snsNeedSave = false;
        if ($ucMemberBindSns) {
            if (empty($ucMemberBindSns->member_id)) {
                // 有关系，属于临时账号，来自扫码，但是没有注册
                // 执行绑定
                Yii::log('fill: mid='.$member_id.' openid='.$openid.' mobile='.$member_mobile.' ', 'warning', __METHOD__);
                $ucMemberBindSns->member_id     = $member_id;
                $ucMemberBindSns->member_mobile = $member_mobile;
                $snsNeedSave = true;
            } elseif ($ucMemberBindSns->member_id == $member_id) {
                // 已经绑定 并已经正确绑定
                if (empty($ucMemberBindSns->member_mobile)) {
                    // 填写手机号
                    $ucMemberBindSns->member_mobile = $member_mobile;
                    $snsNeedSave = true;
                    Yii::log('already bind and fill mobile openid('.$openid.') on (mid='.$ucMemberBindSns->member_id.' mobile='.$ucMemberBindSns->member_mobile.'): mid='.$member_id.' mobile='.$member_mobile.' ', 'warning', __METHOD__);
                } else {
                    // 正确绑定
                    Yii::log('already bind ok openid('.$openid.') on (mid='.$ucMemberBindSns->member_id.' mobile='.$ucMemberBindSns->member_mobile.'): mid='.$member_id.' mobile='.$member_mobile.' ', 'warning', __METHOD__);
                    return $ret;
                }
            } elseif (empty($ucMemberBindSns->member_mobile)) {
                // 临时账号，需要绑定账号 并需要合并
                Yii::log('temp account: (mid='.$ucMemberBindSns->member_id.' openid='.$openid.') need bind on (mid='.$member_id.'mobile='.$member_mobile.')'.' ', 'warning', __METHOD__);
                $tmp_id = $ucMemberBindSns->member_id;

                $ucMemberBindSns->member_id = $member_id;
                $ucMemberBindSns->member_mobile = $member_mobile;
                $ucMemberBindSns->save();
                // 合并临时账号的记录到主账号
                $this->combineAccount($member_id, $tmp_id, $openid);

                //$snsNeedSave = true;
            } else {
                // 该微信被绑定到别的手机号码了
                Yii::log('already bind odd openid('.$openid.') on (mid='.$ucMemberBindSns->member_id.' mobile='.$ucMemberBindSns->member_mobile.'): login mid='.$member_id.' mobile='.$member_mobile.' ', 'warning', __METHOD__);
                $ret['code'] = 3;
                $miscMobile = Tools::miscMobile($ucMemberBindSns->member_mobile);
                $ret['msg']  = '该微信已绑定到手机号'.$miscMobile.'，请重新登录。';
                return $ret;
            }
            //return $ucMemberBindSns;
        } else {
            // 没有记录则新建关系
            $ucMemberBindSns = new UcMemberBindSns;
            $ucMemberBindSns->member_id         = $member_id;
            $ucMemberBindSns->member_mobile     = $member_mobile;
            $ucMemberBindSns->sns_source        = UcMemberBindSns::SNS_SOURCE_WECHAT;
            $ucMemberBindSns->sns_appid         = $appid;
            $ucMemberBindSns->sns_id            = $openid;
            $ucMemberBindSns->status            = 1;
            $ucMemberBindSns->create_time       = date('Y-m-d H:i:s');
            $snsNeedSave = true;
        }

        try {
            if ($snsNeedSave && !$ucMemberBindSns->save()) {
                Yii::log('save ucMemberBindSns error:'.$ucMemberBindSns->lastError().' ', 'error', __METHOD__);
            }

            //更新粉丝表的member_id 之前绑定的MemberFansModel中么有fans_id
            $fansModels = FhMemberFansModel::model()->findAll('fans_openid=:oid', [':oid'=>$openid]);
            foreach ($fansModels as $k=>$fansModel) {
                if ($fansModel->fans_id == 0) {
                    // 补上fans_id
                    $fansModel->fans_id = $member_id;
                    if (!$fansModel->save()) {
                        Yii::log('save FhMemberFansModel error:'.$fansModel->lastError().' ', 'error', __METHOD__);
                    }
                }
            }
            Yii::log('bind success: openid='.$openid.' mid='.$member_id.' mobile='.$member_mobile.' ', 'warning', __METHOD__);
        } catch (CException $e) {
            Yii::log('save ucMemberBindSns error:'.$e->getMessage().' ', 'error', __METHOD__);
        }
        $ret['snsModel'] = $ucMemberBindSns;

        return $ret;
    }
    /*
        公众号中OAuth登陆
            只有当session中设置了 fh 公众号的 所以只能从wechat/authlogin跳转至此
            只要已绑定的可以登录
    */
	public function actionWxautologin() {
        $this->wxautologin();
    }
	public function wxautologin() {
		session_start();
        if (isset($_GET['return_url']) && !empty($_GET['return_url'])) {
            $return_url = $_GET['return_url'];
        } else {
            $return_url = $this->createAbsoluteUrl('my/index', ['_willb'=>2]);
        }
		$member_id = '';
        $authInfo = $_SESSION[Yii::app()->params['third_login_sess_name']];
        if (!$authInfo) {
            Yii::log('auto login error: no session'.' ', 'error', __METHOD__);
            $this->redirect($this->createAbsoluteUrl('user/login'));
        }

		$snsBindModel = $this->_isSnsBind($authInfo['sns_id'], $authInfo['appid'], $authInfo['plat']);
		if ($snsBindModel && $snsBindModel->member_id) {
            if (!empty($snsBindModel->member_mobile)) {
                //如果已经绑定则直接登录
                $member_id = $snsBindModel->member_id;

                //保存登录信息
                $objUserIdentity = new UserIdentity('', '');
                $objUserIdentity->thirdPartLogin($member_id);
                Yii::app()->loginUser->loginAndSaveStates($objUserIdentity);

                $this->redirect($return_url);
            } else {
                // 无手机号，属于临时账号，需要绑定到现有账号上
                Yii::log('auto login error: sns bind but no mobile, go binding: sns_id='.$authInfo['sns_id'].' mid='.$snsBindModel->member_id.' ', 'warning', __METHOD__);
                // 清除登录状态，但是不清除第三方绑定信息
                Yii::app()->loginUser->logout(false);
                $this->redirect($this->createAbsoluteUrl('user/login', ['return_url'=>$return_url]));
                
            }
		} else {
            Yii::log('auto login error: sns no bind'.' ', 'warning', __METHOD__);
			//没有绑定则跳转到登陆页，登陆页会根据session，执行绑定
			//$this->redirect('frontendmob.php?r=user/thirdPartLoginMobile&from=' . $from);
            $this->redirect($this->createAbsoluteUrl('user/login', ['return_url'=>$return_url]));
		}
	}
    protected function _isSnsBind($openid, $appid, $plat=1) {
        
        // 绑定社交关系账号
        $ucMemberBindSns = UcMemberBindSns::model()->find(
            'sns_source=:source and sns_appid=:appid and sns_id=:oid', [
                ':oid'      =>$openid,
                ':appid'    =>$appid,
                ':source'   =>$plat,
            ]);
        return $ucMemberBindSns;
    }
    public function actionAutoclose() {
        session_start();

        $this->checkLogin(Yii::app()->request->hostInfo.Yii::app()->request->url);
        $member_id = Yii::app()->loginUser->getUserId();
        $objMember = UcMember::model()->findByPk($member_id);
        $ret = $this->checkAndBindThirdPart($member_id, $objMember->member_mobile);
        
        $arrRender=array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'return_url' => $return_url,
            'pageTitle' =>'登录成功',
        );

        $this->layout = "layouts/default_v2.tpl";
        $this->smartyRender('wechat/autoclose.tpl',$arrRender);
    }
    
    public function combineAccount($master_id, $tmp_id, $openid) {
        $snsModule = Yii::app()->getModule('sns');
        $snsModule->combineAccount($master_id, $tmp_id, $openid);
        $snsModule->combineFans($master_id, $tmp_id, $openid);
    }
    public function actionTestcombine() {
        $master_id = $_GET['master_id'] ? $_GET['master_id'] : 1005;
        $tmp_id = $_GET['tmp_id'] ? $_GET['tmp_id'] : 1260;
        $openid = $_GET['openid'] ? $_GET['openid'] : 'oDizAwl-h6sqpuUW5PI_9tsasnoA';
        $ret = $this->combineAccount($master_id, $tmp_id, $openid);
        echo 'combineAccount ret=';print_r($ret);
        $snsModule->combineFans($master_id, $tmp_id, $openid);
        echo 'combineFans ret=';print_r($ret);
    }

    public function actionDebugs() {
        echo 'session=';print_r($_SESSION);
    }
}
