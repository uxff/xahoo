<?php

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
		$return_url = $this->outPutString($_GET['return_url']);
		if (empty($return_url)) {
			$return_url = $this->createAbsoluteUrl('customer/index');
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
                'return_url' => $return_url,
                'headerTitle' => '登录',
                'arrMsgStack' => $arrMsgStack,
                'sina_url' => $code_url,
                'qq_url' => $qq_url,
                'weixin_url' => $weixin_url,
			);
			$this->smartyRender('user/login.tpl', $arrRender);
		} else {
			echo '您已经登录';
			$this->redirect($return_url);
		}
	}

	/**
	 * 登陆
	 */
	public function actionLoginForm() {
		// preprocess parameters
		$username = strtolower($this->getString($_POST['username']));
		$password = $this->getString($_POST['password']);
		$return_url = $this->getString($_POST['return_url']);

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
				$errMsg = '该账号尚未注册，请先注册';
			} elseif (AresValidator::isValidEmail($username) && ($objMember->is_email_actived == 0)) {
				//当前用户未激活 则返回错误信
				$errMsg = '邮箱尚未激活，请先去邮箱激活';
			} elseif (AresValidator::isValidChineseMobile($username) && ($objMember->is_mobile_actived == 0)) {
				//当前用户未激活 则返回错误信
				$errMsg = '手机号尚未验证，请先验证';
			}

			// 后台表单验证错误信息提示
			if (!empty($errMsg)) {
				Yii::app()->loginUser->setFlash('error', $errMsg);
				$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
				exit;
			}

			// 授权验证该用户
			$objUserIdentity = new UserIdentity($username, $password);
			$objUserIdentity->authenticate();

			if (!$objUserIdentity->getIsAuthenticated()) {
				// 授权失败，给出错误信息提示
				Yii::app()->loginUser->setFlash('error', '用户名或密码错误!');
				$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
			} else {
				// 授权成功，登录并保存会话信息
				Yii::app()->loginUser->loginAndSaveStates($objUserIdentity);
				$this->redirect($return_url);
			}
		} else { // 已登录
			$this->redirect($return_url);
		}
	}

	/**
	 * 手机注册入口页面
	 */
	public function actionRegister() {
		//$return_url = $this->outPutString($_GET['return_url']);
		$return_url = $this->checkReturnUrl();
		//if(empty($return_url)) {
		//    $return_url = $this->createAbsoluteUrl('site/index');
		//}

		$signage = '';
		if (!empty($_GET['signage'])) {
			$signage = $this->getString($_GET['signage']);
		}else{
			$signage = Yii::app()->request->cookies['signage'];
		}

		$go_url = $this->createAbsoluteUrl('user/register');
		$arrMsgStack = Yii::app()->loginUser->getFlashes();
		$arrRender = array(
            'gShowHeader' => true,
            'return_url' => $return_url,
            'headerTitle' => '手机注册',
            'signage' => $signage,
            'arrMsgStack' => $arrMsgStack,
            'sbd_url' => $this->createAbsoluteUrl('site/Unacceptverifycode', array('return_url' => $go_url)),
		);
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

		$signage = $this->getString($_POST['signage']);
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


		//判断 是否该账号已经注册
		$arrSqlParams = array(
            'condition' => 'member_mobile="' . $username . '"',
		);
		$checkObj = UcMember::model()->find($arrSqlParams);
		$checkArr = is_object($checkObj) ? $this->convertModelToArray($checkObj) : array();

		if (!empty($checkArr)) {
			$errMsg = '该账号已经注册过了';
		}
		if (empty($errMsg)) {
			$member = new UcMember();
			//登录名
			if (AresValidator::isValidChineseMobile($username)) {

				$register_verification = Yii::app()->params['register_verification'];
				if(!isset($register_verification) || $register_verification ){

					//判断验证码是否有效
					$sendResult = SmsDataService::verify($username, $this->getString($_POST['vetify_code']));
					//验证失败则跳转

					if ($sendResult['code'] != '200') {
						$errMsg = $sendResult['msg'];
						Yii::app()->loginUser->setFlash('error', $errMsg);
						$this->redirect($this->createAbsoluteUrl('user/register'));
						exit;
					}
				}
				$member->member_mobile = $username;
				$member->is_mobile_actived = 1;
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
			$member->signage = md5($username.microtime());
			$member->create_time = date('Y-m-d H:i:s', time());
			$member->last_modified = date('Y-m-d H:i:s', time());
			if ($member->insert()) {
				$member_id = $member->member_id;
				//更新推荐小伙伴的房源
				if ($is_invite == 1) {
					$fanghuUrl = $this->createFanghuUrl('Api/Invite');
					$time_sign = time();
					$project_appkey = 'test';
					$project_appsecret = '123456';
					$token = strtoupper(md5($project_appkey . $project_appsecret . $time_sign));

					$fh_params = array(
                        'time_sign' => $time_sign,
                        'source' => 'fangfull',
                        'member_id' => $member->parent_id,
                        'invite_tel' => $username,
                        'invite_id' => $member_id,
                        'token' => $token,
					);
					$fh_data = $this->doPost($fanghuUrl, $fh_params);
				}
				$this->MemberRegisterInit($member_id, $parent_id);
				$this->addPoint($member_id, 'bind_phone'); //手机绑定加积分
				
				// 调用房否接口同步客户信息
				$arrParmas = array(
				    'member_mobile'        => $username,
				    'member_fullname'      => '',
				    'member_gender'        => '',
				    'member_id_number'     => '',
				    'province'             => '',
				    'city'             => '',
				    'county'   => '',
				    'address'   => '',
				    'customer_from'   => 8,
				    'add_time'   => date('Y-m-d H:i:s'),
				);
				$apiModule = Yii::app()->getModule('api');
				$apiModule->FangfullApi($arrParmas)->synCustmer();
				
				//房否入数据
				//$this->fangfullRegister($username,$parent_mobile);

				$errMsg = '注册成功，请登录';
				Yii::app()->loginUser->setFlash('error', $errMsg);
				$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
				exit;
			} else {
				$errMsg = '注册失败，请重新注册';
			}
		}



		// 后台表单验证错误信息提示
		if (!empty($errMsg)) {
			Yii::app()->loginUser->setFlash('error', $errMsg);

			if (AresValidator::isValidEmail($username)) {
				$this->redirect($this->createAbsoluteUrl('user/registeremail', array('return_url' => $return_url)));
			} else {
				$this->redirect($this->createAbsoluteUrl('user/register', array('return_url' => $return_url)));
			}
		}
	}

	public function fangfullRegister($mobile,$mobile_about) {

		//房否入数据
		$fangfullUrl = $this->createFangFullApiUrl("api/insertCustomer","");

		$time_sign = time();
		$project_appkey = 'test';
		$project_appsecret = '123456';
		$token = strtoupper(md5($project_appkey . $project_appsecret . $time_sign));

		$fh_params = array(
                'test' => 1,
                'token' => $token,
                'mobile' => $mobile,
                'mobileAbout' => $mobile_about,
		);
		$fh_data = $this->doPost($fangfullUrl, $fh_params);


	}

	/**
	 * 邮箱注册 手机版不需要
	 */
	/*
	 public function actionRegisterEmailForm() {
	 //post数据
	 $email = strtolower($this->getString($_POST['email']));
	 $password = $this->getString($_POST['password']);
	 $return_url = $this->getString($_POST['return_url']);

	 // 后台表单验证
	 $errMsg = '';
	 if (empty($email) || empty($password)) {
	 $errMsg = '邮箱或密码不能为空';
	 } elseif (!empty($email)) {
	 if (!AresValidator::isValidEmail($email)) {
	 $errMsg = '请输入正确的邮箱';
	 }
	 } elseif (!empty($password) && (strlen($password) < 6)) {
	 $errMsg = '密码至少为6位字母数字组合';
	 }


	 //判断 是否该账号已经注册
	 $arrSqlParams = array(
	 'condition' => 'member_email="' . $email . '"',
	 );
	 $checkObj = UcMember::model()->find($arrSqlParams);
	 $checkArr = is_object($checkObj) ? $this->convertModelToArray($checkObj) : array();

	 if (!empty($checkArr)) {
	 $errMsg = '该账号已经注册过了';
	 }
	 if (empty($errMsg)) {
	 $member = new UcMember();
	 //登录名
	 if (AresValidator::isValidEmail($email)) {
	 //判断验证码是否有效
	 $vetify_code = $this->getString($_POST['vetify_code']);
	 if (Yii::app()->session['email_verify_code'] != $vetify_code) {
	 $errMsg = '验证码不正确';
	 Yii::app()->loginUser->setFlash('error', $errMsg);
	 $this->redirect($this->createAbsoluteUrl('user/registeremail'));
	 exit;
	 }
	 $member->member_email = $email;
	 }
	 $parent_id = 0;
	 $cookie = Yii::app()->request->getCookies();
	 if (!empty($cookie['signage']->value)) {
	 $signage = $cookie['signage']->value;
	 $objMember = UcMember::model()->find("signage=:signage", array(":signage" => $signage));
	 if (!empty($objMember)) {
	 //$member->member_from = 2; //来源邀请
	 $member->parent_id = $objMember->member_id; //会员上级编号
	 $parent_id = $objMember->member_id;
	 }
	 }

	 $member->member_password = AresUtil::encryptPassword($password);
	 $member->member_nickname = AresUtil::generateRandomStr(16);
	 $member->is_email_actived = 1;
	 $member->signage = AresUtil::generateRandomStr(16);
	 $member->create_time = date('Y-m-d H:i:s', time());
	 $member->last_modified = date('Y-m-d H:i:s', time());
	 if ($member->insert()) {
	 $member_id = $member->member_id;
	 $this->MemberRegisterInit($member_id,$parent_id);
	 $errMsg = '注册成功，请登录';
	 Yii::app()->loginUser->setFlash('error', $errMsg);
	 unset(Yii::app()->session['email']);
	 unset(Yii::app()->session['email_verify_code']);
	 $this->redirect($this->createAbsoluteUrl('user/login',array('return_url' => $return_url)));
	 exit;
	 } else {
	 $errMsg = '注册失败，请重新注册';
	 }
	 }

	 // 后台表单验证错误信息提示
	 if (!empty($errMsg)) {
	 Yii::app()->loginUser->setFlash('error', $errMsg);
	 $this->redirect($this->createAbsoluteUrl('user/registeremail',array('return_url' => $return_url)));
	 }
	 }
	 */
	/**
	 * 邮箱注册入口页面 手机版不需要
	 */
	/*
	 public function actionRegisterEmail() {
	 $return_url = $this->outPutString($_GET['return_url']);

	 if(empty($return_url)) {
	 $return_url = $this->createAbsoluteUrl('site/index');
	 }
	 $arrMsgStack = Yii::app()->loginUser->getFlashes();
	 $arrRender = array(
	 'gShowHeader' => true,
	 'return_url' => $return_url,
	 'headerTitle' => '邮箱注册',
	 'arrMsgStack' => $arrMsgStack,
	 );
	 $this->smartyRender('user/registeremail.tpl', $arrRender);
	 }
	 */

	/**
	 * 忘记密码：手机找回页面
	 */
	public function actionforgetMobile() {
		$return_url = $this->checkReturnUrl();
		//$return_url = $this->outPutString($_GET['return_url']);
		//if(empty($return_url)) {
		//    $return_url = $this->createAbsoluteUrl('site/index');
		//}

		$go_url = $this->createAbsoluteUrl('user/forgetmobile');
		$arrMsgStack = Yii::app()->loginUser->getFlashes();
		$arrRender = array(
            'gShowHeader' => true,
            'return_url' => $return_url,
            'headerTitle' => '忘记密码',
            'arrMsgStack' => $arrMsgStack,
            'sbd_url' => $this->createAbsoluteUrl('site/Unacceptverifycode', array('return_url' => $go_url)),
		);
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
				if ($sendResult['code'] != '200') {
					$errMsg = $sendResult['msg'];
					Yii::app()->loginUser->setFlash('error', $errMsg);
					$this->redirect($this->createAbsoluteUrl('user/forgetmobile', array('return_url' => $return_url)));
				}

				$objMember->member_password = AresUtil::encryptPassword($password);

				// 更新为新密码
				if ($objMember->update()) {
					$errMsg = '密码修改成功，请登录...';
				} else {
					$errMsg = '更新密码失败，请重新修改';
				}
			}
		}


		//跳转到登陆页
		Yii::app()->loginUser->setFlash('error', $errMsg);
		$this->redirect($this->createAbsoluteUrl('user/login', array('return_url' => $return_url)));
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
			$this->redirect('index.php?r=site/login');
		} else {
			//没有绑定则跳转到手机、邮箱录入页面
			$this->redirect('ucenter.php?r=user/thirdPartLoginMobile&from=' . $from);
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
			$member->is_mobile_actived = 1;
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
			$this->redirect('index.php?r=site/login');
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

}
