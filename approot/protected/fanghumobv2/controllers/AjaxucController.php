<?php
Yii::import('application.ucenterpc.models.*');
Yii::import('application.ucenterpc.components.*');
Yii::import('application.ucentermob.api.*');
Yii::import('application.ucentermob.models.*');
Yii::import('application.ucentermob.components.*');
Yii::import('application.ucentermodels.*');
Yii::import('application.ucentermob.api.UCenterStatic');
Yii::import('application.ucenterpc.controllers.BaseController');
/*
    用户中心短信验证ajax
*/
class AjaxucController extends Controller {

        /**
         * 验证手机号
         */
        public function actionCheckMobile() {
                $mobile = $this->getString($_GET['mobile']);
                if (empty($mobile)) {
                        $code = 1;
                        $message = '请输入您的手机号';
                } else {
                        if (AresValidator::isValidChineseMobile($mobile)) {
                                $arrSqlParams = array(
                                    'condition' => 'member_mobile=' . $mobile,
                                );
                                $total = Member::model()->count($arrSqlParams);
                                if ($total > 0) {
                                        $code = 1;
                                        $message = '该手机号已存在';
                                } else {
                                        $code = 0;
                                        $message = '该手机号尚未使用';
                                }
                        } else {
                                $code = 1;
                                $message = '手机号格式不正确';
                        }
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         * 验证手机号 找回密码
         *
         */
        public function actionCheckOldMobile() {
                $mobile = trim($this->getString($_GET['mobile']));
                if (empty($mobile)) {
                        $code = 1;
                        $message = '请输入您的手机号';
                } else {
                        if (AresValidator::isValidChineseMobile($mobile)) {
                                $arrSqlParams = array(
                                    'condition' => 'member_mobile=' . $mobile,
                                );
                                $total = UcMember::model()->count($arrSqlParams);
                                if ($total > 0) {
                                        $code = 1;
                                        $message = '该手机号已注册过了';
                                } else {
                                        $code = 0;
                                        $message = '该手机号不存在';
                                }
                        } else {
                                $code = 1;
                                $message = '手机号格式不正确';
                        }
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         * 验证手机修改 个人中心
         */
        public function actionCheckModMobile() {
                $mobile = trim($this->getString($_GET['mobile']));
                if (empty($mobile)) {
                        $code = 1;
                        $message = '请输入您的手机号';
                } else {
                        if (AresValidator::isValidChineseMobile($mobile)) {
                                $arrSqlParams = array(
                                    'condition' => 'member_mobile=' . $mobile,
                                );
                                $total = UcMember::model()->count($arrSqlParams);
                                if ($total > 0) {
                                        $code = 1;
                                        $message = '该手机号已注册过了';
                                } else {
                                        $code = 0;
                                        $message = '该手机号不存在';
                                }
                        } else {
                                $code = 1;
                                $message = '手机号格式不正确';
                        }
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         * 发送手机验证码
         */
        public function actionSendCode() {
            session_start();
            $mobile = $this->getString($_POST['mobile']);
            $clientToken = $this->getString($_POST['token']);
            $serverToken = Yii::app()->request->csrfToken;
            $valicode = $this->getString($_POST['valicode']);
            $valicode = strtolower($valicode);

            // 配置
            $limitEachMobile = 3;//Yii::app()->params['reg_sms_limit_mobile']; 
            $limitEachIp     = 5;//Yii::app()->params['reg_sms_limit_ip']; 

            // 检查token
            if ($clientToken != Yii::app()->request->csrfToken){
                $code = 1;
                $message = '请求失败，请刷新后再试';
            }
            // 检查手机号格式
            elseif (!AresValidator::isValidChineseMobile($mobile)) {
                $code = 1;
                $message = '手机号格式不正确';
            }
            // 检查图形验证码
            elseif (!Yii::app()->session['checkCode'] || $valicode != Yii::app()->session['checkCode']){
                $code = 1;
                $message = '图形验证码输入错误';
            }
            // 检查手机号发送次数
            elseif (SmsHelper::isCheatMobile($mobile, $limitEachMobile)) {
                $code = 1;
                $message = '您的手机号操作过于频繁，请24小时后再试';
            }
            // 检查手机号发送次数
            elseif (SmsHelper::isCheatIp(Tools::getUserHostAddress(), $limitEachIp)) {
                $code = 1;
                $message = '您的操作过于频繁，请24小时后再试';
            } else {
                
            //$sendResult = SmsDataService::sendVerifyCode($mobile);
                if ($sendResult) {
                        $code = 0;
                        $message = '验证码发送成功.';
                        unset(Yii::app()->session['checkCode']);
                } else {
                        $code = 1;
                        $message = '验证码发送失败.(本环境为测试环境，不发送，不验证)';
                }
            }
            $result = array(
                'code' => $code,
                'msg' => $message,
            );
            echo json_encode($result);
        }

        /**
         * 发送手机验证码 (修改验证用)
         */
        public function actionSendMobileCode() {
                session_start();
				$member_id = Yii::app()->loginUser->getUserId();
				$memberObj = UcMember::model()->findByPk($member_id);
				$member_mobile = $memberObj->member_mobile;
                $sendResult = false;//SmsDataService::sendVerifyCode($member_mobile);
                if ($sendResult) {
                        $code = 0;
                        $message = '验证码发送成功';
                } else {
                        $code = 1;
                        $message = '验证码发送失败';
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         * 验证邮箱
         */
        public function actionCheckEmail() {
                $email = $this->getString($_GET['email']);
                //查找邮箱
                if (AresValidator::isValidEmail($email)) {
                        $arrSqlParams = array(
                            'condition' => 'member_email="' . $email . '"',
                        );
                        $total = UcMember::model()->count($arrSqlParams);
                        if ($total > 0) {
                                $code = 1;
                                $message = '该邮箱已存在';
                        } else {
                                $code = 0;
                                $message = '该邮箱尚未使用';
                        }
                } else {
                        $code = 1;
                        $message = '邮箱格式不正确';
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         *
         * 重置邮箱   Ajax
         *
         */
        public function actionResetEmail() {
                //是否已经登录
                $this->checkLogin();
                //preprocess parameters
                $email = $this->getString($_GET['email']);
                //查找邮箱
                if (AresValidator::isValidEmail($email)) {

                        $arrSqlParams = array(
                            'condition' => 'member_email="' . $email . '"',
                        );
                        $total = UcMember::model()->find($arrSqlParams);

                        if ($total > 0) {
                                $code = 1;
                                $message = '该邮箱已存在';
                        } else {
                                //取出个人ID
                                $member_id = Yii::app()->loginUser->getUserId();
                                $memberObj = UcMember::model()->findByPk($member_id);

								$is_email_actived = $memberObj->is_email_actived;
                                //更新邮箱
                                $memberObj->member_email = $email;
                                $memberObj->is_email_actived = 1;

                                if ($memberObj->save()) {
										if( $is_email_actived == 0 && $this->checkPointLog($member_id,'bind_email')){
												$this->addPoint($member_id,'bind_email');
										}
                                        unset(Yii::app()->session['email']);
                                        unset(Yii::app()->session['email_verify_code']);
                                        $code = 0;
                                        $message = '修改成功';
                                } else {
                                        $code = 1;
                                        $message = '修改失败';
                                }
                        }
                } else {
                        $code = 1;
                        $message = '邮箱格式不正确';
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );

                echo json_encode($result);
        }

        /**
         * 验证邮箱 找回密码
         */
        public function actionCheckOldEmail() {
                $email = trim($this->getString($_GET['email']));
                if (empty($email)) {
                        $code = 1;
                        $message = '请输入您的邮箱';
                } elseif (AresValidator::isValidEmail($email)) {
                        $arrSqlParams = array(
                            'condition' => "member_email='" . $email . "'",
                        );
                        $total = UcMember::model()->count($arrSqlParams);

                        if ($total <= 0) {
                                $code = 1;
                                $message = '该邮箱号尚未注册';
                        } else {
                                $code = 0;
                                $message = '该邮箱号已经注册';
                        }
                } else {
                        $code = 1;
                        $message = '邮箱格式不正确';
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         * 发送邮箱验证码
         */
        public function actionSendEmailCode() {
                session_start();
                $email = $this->getString($_GET['email']);
                $verify_code = AresUtil::generateRandomStr(6);
                $sendResult = EmailDataService::sendRegisterVerifyCode($email, $verify_code);
                if ($sendResult) {
                        $code = 0;
                        $message = '验证码发送成功';
                        Yii::app()->session['email_verify_code'] = $verify_code;
                        Yii::app()->session['email'] = $email;
                } else {
                        $code = 1;
                        $message = '验证码发送失败';
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }


	/**
	 *
	 *  发送邮箱激活链接
	 *
	 */
	public function actionSendEmailURL() {
		//是否已经登录
		$this->checkLogin();
		//preprocess parameters
		$email = $this->getString($_GET['email']);
		//查找邮箱
		if (AresValidator::isValidEmail($email)) {
			$arrSqlParams = array(
                'condition' => 'is_email_actived=1 and member_email="' . $email . '"',
			);
			$total = UcMember::model()->find($arrSqlParams);

			if ($total > 0) {
				$code = 1;
				$message = '该邮箱已存在';
			} else {
				//取出个人ID
				$member_id = Yii::app()->loginUser->userId;
				$memberObj = UcMember::model()->findByPk($member_id);
				
				//更新邮箱
				$memberObj->member_email = $email;

				//$memberObj->is_email_actived = '0';

				if ($memberObj->update()) {
					$mail_data = array(
                        'welcome_name' => $email,
                        'verify_code' => AresUtil::generateVerifyCode($member_id, $email, time()),
					);
					//发送修改邮箱邮件
					$sendResult = EmailDataService::sendActiveEmail($email, $mail_data);
					if ($sendResult['status']) {
						//Yii::app()->loginUser->logoutAndClearStates();
						$code = 0;
						$message = '验证邮件发送成功,请去邮箱激活';
					} else {
						$code = 1;
						$message = '验证邮件发送失败,请重新发送';
					}
				} else {
					$code = 1;
					$message = '验证邮件发送失败,请重新发送';
				}
			}
		} else {
			$code = 1;
			$message = '邮箱格式不正确';
		}
		$result = array(
            'code' => $code,
            'msg' => $message,
		);

		echo json_encode($result);
	}

        /**
         * 检查邮箱验证码 
         */
        public function actionCheckEmailCode() {
                $vetify_code = $this->getString($_GET['code']);
                $email = $this->getString($_GET['email']);
                if ((Yii::app()->session['email'] != $email) || (Yii::app()->session['email_verify_code'] != $vetify_code)) {
                        $code = 1;
                        $message = '邮箱验证码不正确';
                } else {
                        $code = 0;
                        $message = '邮箱验证码正确';
                }
                $result = array(
                    'code' => $code,
                    'msg' => $message,
                );
                echo json_encode($result);
        }

        /**
         * get security questions
         */
        public function actionGetQuestions() {
                //获取密保问题
                $securty = UcSecurityQuestion::model()->published()->findAll();
                //处理查询结果
                $response = array();
                if ($securty) {
                        $response['state'] = "success";
                }
                foreach ($securty as $k => $value) {
                        $response['data'][$k]['id'] = $value->id;
                        $response['data'][$k]['question'] = $value->question_text;
                        $response['data'][$k]['rule'] = $value->answer_rule;
                        $response['data'][$k]['answer_type'] = $value->answer_type;
                }
                echo json_encode($response);
        }

    /**
     * 第三方登录时发送手机验证码
     */
    public function actionThirdLoginSendCode() {
        $mobile = $this->getString($_GET['mobile']);

        //手机号验证通过后，发送短信
        $sendResult = false;//SmsDataService::sendVerifyCode($mobile);
        if ($sendResult) {
            $code = 0;
            $message = '验证码发送成功';
        } else {
            $code = 1;
            $message = '验证码发送失败';
        }
        $result = array(
            'code' => $code,
            'msg' => $message,
        );


        echo json_encode($result);
    }

    /**
     * 验证帐号是否绑定密保问题
     */
    public function actionCheckAccount() {
        $respons = array();
        //查询会员手机号吗
        $member = UcMember::model()->findByAttributes(array('member_mobile' => $this->getString($_POST['username'])));
        if(!$member) {
            $response['errorCode'] = '00';     //此手机尚未注册
        } else {
            $member_question = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member->member_id));
            if(!$member_question) {
                $response['errorCode'] = '01';    //此帐号没有设置密保问题
            } else {
                $response['errorCode'] = '11';
                $response['member_id'] = $member->member_id;
                session_start();
                $_SESSION['tmp_member_id'] = $member->member_id;
            }
        }

        echo json_encode($response);
    }

    /**
     * 修改密保问题时验证旧问题
     */
    public function actionCheckOldAnswer() {
        $member_id = Yii::app()->loginUser->getUserId();
        $old_answer = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id'=>$member_id));
        $response = array();
        //判断密保问题答案是否匹配
        if($_POST['old_answer'] != $old_answer->answer_1) {
            $response['errorCode'] = '00';
            $response['errorInfo'] = '密保问题不正确';
        } else {
            $response['errorCode'] = '11';
        }


        echo json_encode($response);
    }

    /**
     * 验证会员是否已经绑定邮箱
     */

    public function actionCheckEmailBinded() {
        $member_id = Yii::app()->loginUser->getUserId();
        $response = array();
        //查找会员邮箱
        $member = UcMember::model()->findByPk($member_id);
        //判断是否绑定邮箱
        if($member->member_email != '' && $member->is_email_actived == 1) {
            $response['errorCode'] = '11';
        } else {
            $response['errorCode'] = '00';
            $response['errorInfo'] = '请先绑定邮箱再设置密保问题';
        }

        echo json_encode($response);
    }

    /**
     * 重置密保问题发送邮件
     */
    public function actionSendEmail() {
        session_start();
        $member_id = Yii::app()->loginUser->getUserId();
        $member = UcMember::model()->findByPk($member_id);
        $email = $member->member_email;
        $verify_code = AresUtil::generateRandomStr(6);
        $param = array(
            'state' => $verify_code,
            'signage' => $member->signage,
        );
        $url = $this->createOtherAppUrl('UCenterServerName', 'account/securityQuestions',$param);
//        var_dump($url);die;
        $sendResult = EmailDataService::sendResetQuesUrl($email, $verify_code, $url);
        if ($sendResult) {
            $code = 0;
            $message = '邮件发送成功';
            Yii::app()->session['email_verify_code'] = $verify_code;
            Yii::app()->session['email'] = $email;
        } else {
            $code = 1;
            $message = '邮件码发送失败';
        }
        $result = array(
            'code' => $code,
            'msg' => $message,
        );
        echo json_encode($result);
    }

    /**
     * 验证手机验证码
     *
     */
    public function actionCheckVerifyCode() {
        session_start();
        $username = $this->getString($_GET['mobile']);
        $sendResult = SmsDataService::verify($username, $this->getString($_GET['code']));
        if ($sendResult['code'] == 200) {
            $code = 0;
            $message = '验证成功';
        } else {
            $code = 1;
            $message = '验证码不正确';
        }
        $result = array(
            'code' => $code,
            'msg' => $message,
        );
        echo json_encode($result);
    }

    /**
     * 验证手机验证码 (修改验证用)
     *
     */
    public function actionCheckVerifyMobileCode() {
        session_start();
        $member_id = Yii::app()->loginUser->getUserId();
		$memberObj = UcMember::model()->findByPk($member_id);
		$member_mobile = $memberObj->member_mobile;
        $sendResult = SmsDataService::verify($member_mobile, $this->getString($_GET['code']));
        if ($sendResult['code'] == 200) {
            $code = 0;
            $message = '手机验证成功';
        } else {
            $code = 1;
            $message = '手机验证码不正确';
        }
        $result = array(
            'code' => $code,
            'msg' => $message,
        );
        echo json_encode($result);
    }


        /**
         *
         * 小伙伴购买记录加载更多
         */
        public function actionListBuildingBuddy() {

				$buddy_id = $this->getInt($_GET['buddy_id']);
				$source = $this->getString($_GET['source']);
				$pageNo = isset($_GET['page']) ? $this->getInt($_GET['page']) : 2;
				$pageSize = 10;

				$fanghuUrl= $this->createFanghuUrl('Api/GetAppointmentList');
				$time_sign = time();
				$project_appkey = 'test';
			    $project_appsecret = '123456';
				$token = strtoupper(md5($project_appkey.$project_appsecret.$time_sign));

				$fh_params = array(
					'time_sign' => $time_sign,
					'source' => $source,
					'member_id' => $buddy_id,
					'token' => $token,
					'page_no' => $pageNo,
					'page_size' => $pageSize,
				);
				$fh_data = $this->doPost($fanghuUrl, $fh_params);
				echo json_encode($fh_data['data']['list']);
				
        }

        /**
         *
         * 小伙伴加载更多
         */
        public function actionListBuddy() {
				$buddy_id = $this->getInt($_GET['buddy_id']);
				$pageNo = isset($_GET['page']) ? $this->getInt($_GET['page']) : 2;
				$pageSize = 10;
				$buddy_list = $this->selectMemberRelationMap($buddy_id,$pageNo,$pageSize); //调用函数
				echo json_encode($buddy_list['list']);
				
        }

        /**
         *
         * 佣金记录加载更多
         */
		public function actionListReward(){

				$status = $this->getInt($_GET['status']);

				$pageNo = isset($_GET['page']) ? $this->getInt($_GET['page']) : 2;
				$pageSize = 10;
				$member_id = Yii::app()->loginUser->getUserId();
				if($status==0){
						$SqlParams = array(
							'condition' => 't.member_id=:member_id',
							'params' => array(':member_id' => $member_id),
							'order' => 'log_id desc',
							'limit' => $pageSize,
							'offset' => ($pageNo > 1) ? ($pageNo - 1) * $pageSize : 0,
						);
				}
				//if($status==1){
				//		$SqlParams = array(
				//			'condition' => 't.member_id=:member_id and t.status=:status',
				//			'params' => array(':member_id' => $member_id,':status' => $status),
				//			'order' => 'log_id desc',
				//			'limit' => $pageSize,
				//			'offset' => ($pageNo > 1) ? ($pageNo - 1) * $pageSize : 0,
				//		);				
				//}

				$objRewardDue = UcMemberRewardLog::model()->with('member')->findAll($SqlParams);
				$arrRewardDue = $this->convertModelToArray($objRewardDue);
				foreach($arrRewardDue as $key=>$value){
					$arrRewardDue[$key]['last_modified'] = date('Y-m-d',strtotime($arrRewardDue[$key]['last_modified']));
				}
				echo json_encode($arrRewardDue);
		}

        /**
         * 检验是否设置交易密码方法
         */
        public function actionIsSetDealPassword() {
            $member_id = Yii::app()->loginUser->getUserId();
            $member = UcMember::model()->findByPk($member_id);
            if($member->deal_password == '') {
                echo '00';
            } else {
                echo '11';
            }
        }

        /*
         * 图形验证码
         */
        public function actionValidationCode(){
        
            $width = $this->getInt($_GET['width']) > 60 ? $this->getInt($_GET['width']) : 60;
            $height = $this->getInt($_GET['height']) > 20 ? $this->getInt($_GET['height']) : 20;
        
            $code=new AresValidationCode($width, $height, 4);
            Yii::app()->session['checkCode']=strtolower($code->getCheckCode());     //将验证码的值存入session中以便在页面中调用验证
            $code->showImage();   //输出验证码
        }
}
