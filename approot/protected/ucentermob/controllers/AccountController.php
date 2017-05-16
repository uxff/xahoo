<?php

class AccountController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * 账号与安全首页
     */
    public function actionIndex() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $arrMember = $this->convertModelToArray($objMember);
        $arrMember['member_mobile'] = substr_replace($arrMember['member_mobile'], '****', 3, 4);
        $arrMember['member_id_number'] = empty($arrMember['member_id_number']) ? $arrMember['member_id_number'] : substr_replace($arrMember['member_id_number'], '********', 3, 8);

        $is_dealpwd_lock = 0;
        $lock_time = date('Y-m-d', strtotime($arrMember['dealpwd_lock_time']));
        $now_time = date('Y-m-d', time());
        if ($lock_time == $now_time) {
            $is_dealpwd_lock = 1;
        } else {
            $objMember->mod_dealpwd_num = 0;
            $objMember->dealpwd_lock_time = 0;
            $objMember->update();
        }

        $is_set = 0;
        $is_set_questions = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));

        if ($is_set_questions && $is_set_questions->status == 1) {
            $is_set = 1;
        }
        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '账号与安全',
            'arrMember' => $arrMember,
            'arrMsgStack' => $arrMsgStack,
            'return_url' => $this->createAbsoluteUrl('Profile/index'),
            'isSetQuestions' => $is_set,
            'is_dealpwd_lock' => $is_dealpwd_lock,
        );
        $this->smartyRender("account/index.tpl", $arrRender);
    }


    //支付平台管理
    public function actionTradingPlatform() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $paramsSql = array(
            'select'=>array('distinct platform_account'),
            'condition' => 'member_id='.$member_id,
        );
        $bindedTradingPlatform = UcTradingPlatform::model()->findAll($paramsSql);
        $arrBindedTradingPlatform = OBJTool::convertModelToArray($bindedTradingPlatform);
        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '支付平台管理',
            'list' => $arrBindedTradingPlatform,
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender("account/tradingPlatform.tpl", $arrRender);
    }

    //添加支付平台
    public function actionAddTradingPlatform() {
        $member_id = Yii::app()->loginUser->getUserId();
        $objMember = UcMember::model()->findByPk($member_id);
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $arrRender = array(
            'objMember' => $objMember,
            'gShowHeader' => true,
            'headerTitle' => '添加支付平台',
            'arrMsgStack' => $arrMsgStack,
            'return_url' => $this->createAbsoluteUrl('account/tradingPlatform'),
        );
        $this->smartyRender("account/addtradingplatform.tpl", $arrRender);
    }

    //添加支付平台表单接收
    public function actionAddTradingPlatformForm() {
            $this->checkLogin();
            $member_id = Yii::app()->loginUser->getUserId();
            $params = array();
            $objMember = UcMember::model()->findByPk($member_id);
            $code = $this->getString($_POST['BindPlatform']['code']);
            $sendResult = SmsDataService::verify($objMember->member_mobile, $code);
            if ($sendResult['code'] != '200') {
                $message = $sendResult['msg'];
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/addTradingPlatform'));
            }

            $paramsSql = array(
                    'condition' => "member_id={$member_id} and platform_account='{$this->getString($_POST['BindPlatform']['platform_account'])}' and platform_type={$this->getString($_POST['BindPlatform']['platform_type'])}",
            );
            $is_repeat_binded = UcTradingPlatform::model()->find($paramsSql['condition']);
            if($is_repeat_binded) {
                Yii::app()->loginUser->setFlash('error', '该帐号已绑定');
                $this->redirect($this->createAbsoluteUrl('account/addTradingPlatform'));
            } else {
                $trading_platform = new UcTradingPlatform();
                $trading_platform->member_id = $member_id;
                $trading_platform->real_name = $objMember->member_fullname;
                $trading_platform->platform_type = $this->getString($_POST['BindPlatform']['platform_type']);
                $trading_platform->platform_account = $this->getString($_POST['BindPlatform']['platform_account']);
                $trading_platform->member_mobile = $objMember->member_mobile;
                $trading_platform->create_time = date('Y-m-d');
                if($trading_platform->insert()) {
                    $params['message'] = '恭喜您，支付平台绑定成功！';
                } else {
                    $params['message'] = '很遗憾，支付平台绑定失败！';
                }

            }

        $params['return_url'] = $this->createAbsoluteUrl('account/addTradingPlatform');
        $params['title'] = '绑定支付平台';
        $params['btn'] = '返回';
        $this->redirect($this->createAbsoluteUrl('account/tradingPlatform',  $params) );
    }

    //绑定支付平台页面输入交易密码
    public function actionBindTradingPlatform() {
        $this->checkLogin();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $arrRender = array(
            'gShowHeader' => true,
            'arrMsgStack' => $arrMsgStack,
            'headerTitle' => '绑定支付平台',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender("account/bindtradingplatform.tpl", $arrRender);
    }

    //绑定支付平台接收交易密码
    public function actionBindTradingPlatformForm() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $objMember = UcMember::model()->findByPk($member_id);
        if(isset($_POST['deal_password']) && $_POST['deal_password'] !='') {
            if(!AresUtil::validatePassword($this->getString($_POST['deal_password']), $objMember->deal_password)) {
                //密码不正确跳转到交易密码输入页面并提示
                $message = '交易密码不正确';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/bindTradingPlatform'));
            } else {
                //跳转到支付平台管理页面
                $this->redirect($this->createAbsoluteUrl('account/tradingPlatform'));
            }
        }
    }

    /**
     * 验证手机修改
     */
    public function actionModtel() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();

        if (isset($_POST['new_mobile'])) {
            //新手机号
            $new_mobile = $this->getString($_POST['new_mobile']);
            //验证码
            $verify_code = $this->getString($_POST['verify_code']);
            //密码
            $password = $this->getString($_POST['password']);
            //判断手机号格式
            if (!AresValidator::isValidChineseMobile($new_mobile)) {
                $status = 'fail';
                $message = '手机号格式错误';
            } else {

                $memberObj = UcMember::model()->findByPk($member_id);
                $member_password = $memberObj->member_password;
                if (!AresUtil::validatePassword($password, $member_password)) {
                    Yii::app()->loginUser->setFlash('error', '密码不对');
                    $this->redirect($this->createAbsoluteUrl('account/modtel'));
                    exit;
                }

                //判断验证码是否有效
                $sendResult = SmsDataService::verify($new_mobile, $verify_code);

                //验证失败则跳转
                if ($sendResult['code'] != '200') {
                    $errMsg = $sendResult['msg'];
                    Yii::app()->loginUser->setFlash('error', $errMsg);
                    $this->redirect($this->createAbsoluteUrl('account/modtel'));
                    exit;
                }

                //判断手机号是否已经注册
                $arrSqlParams = array(
                    'condition' => 'member_mobile=' . $new_mobile,
                );
                $total = UcMember::model()->count($arrSqlParams);

                if ($total > 0) {
                    $status = 'fail';
                    $message = '该手机号已存在';
                    Yii::app()->loginUser->setFlash('error', $message);
                    $this->redirect($this->createAbsoluteUrl('account/modtel'));
                    exit;
                } else {

                    $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                    $objMember->member_mobile = $new_mobile;
                    $objMember->is_mobile_actived = 1; //客户端已经smsSDK校验过
                    $is_mobile_actived = $objMember->is_mobile_actived;
                    if ($objMember->update()) {
                        if ($is_mobile_actived == 0 && $this->checkPointLog($member_id, 'mobile')) {
                            $this->addPoint($member_id, 'mobile');
                        }
                        $status = 'success'; //成功
                        $message = '手机号修改成功';
                    } else {
                        $status = 'fail'; //失败
                        $message = '手机号修改失败，请重新操作';
                    }
                }
            }
            $result = array(
                'status' => $status,
                'message' => $message,
            );

            $this->redirect($this->createAbsoluteUrl('account/index'));
        } else {
            $memberInfo = UcMember::model()->findByPk(array('member_id' => $member_id));
            $memberInfo->member_mobile = empty($memberInfo->member_mobile) ? '' : substr_replace($memberInfo->member_mobile, '****', 3, 4);

            $arrMsgStack = Yii::app()->loginUser->getFlashes();

            // result
            $arrRender = array(
                'gShowHeader' => true,
                'return_url' => $this->createAbsoluteUrl('account/index'),
                'headerTitle' => '验证手机修改',
                'arrMsgStack' => $arrMsgStack,
                'mobile' => $memberInfo->member_mobile,
            );
            $this->smartyRender('account/modtel.tpl', $arrRender);
        }
    }

    /**
     * 身份验证
     */
    public function actionModid() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        if (!empty($_POST['member_fullname']) && !empty($_POST['member_id_number'])) {
            $member_fullname = $this->getString($_POST['member_fullname']);
            $member_id_number = $this->getString($_POST['member_id_number']);

            $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
            $objMember->member_fullname = $member_fullname;
            $objMember->member_id_number = $member_id_number;
            $is_idnumber_actived = $objMember->is_idnumber_actived;
            $objMember->is_idnumber_actived = 1;
            if ($objMember->update()) {
                if ($is_idnumber_actived == 0 && $this->checkPointLog($member_id, 'identity_verificatio')) {
                    $this->addPoint($member_id, 'identity_verificatio');
                }
            }
            $this->redirect($this->createAbsoluteUrl('account/index'));
            exit;
        }
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $arrMember = $this->convertModelToArray($objMember);
        $arrMember['member_fullname'] = empty($arrMember['member_fullname']) ? '' : mb_substr($arrMember['member_fullname'], 0, 1) . str_repeat('*', mb_strlen($arrMember['member_fullname']) - 1);
        $arrMember['member_id_number'] = empty($arrMember['member_id_number']) ? $arrMember['member_id_number'] : substr_replace($arrMember['member_id_number'], '********', 3, 8);
        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '身份验证',
            'arrMember' => $arrMember,
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/modid.tpl', $arrRender);
    }

    /**
     * 邮箱绑定修改
     */
    public function actionModEmail() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $is_email_actived = $objMember->is_email_actived;
        if ($is_email_actived == 0) {
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邮箱绑定',
                'arrMsgStack' => $arrMsgStack,
                'return_url' => $this->createAbsoluteUrl('account/index'),
            );
            $this->smartyRender('account/bindingemail.tpl', $arrRender);
        } else {
            $member_mobile = empty($objMember->member_mobile) ? '' : substr_replace($objMember->member_mobile, '****', 3, 4);
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邮箱修改',
                'arrMsgStack' => $arrMsgStack,
                'email' => $objMember->member_email,
                'mobile' => $member_mobile,
                'return_url' => $this->createAbsoluteUrl('account/index'),
            );
            $this->smartyRender('account/modemail.tpl', $arrRender);
        }
    }

    /**
     * 验证邮箱是否为真实邮箱,并激活
     * 通过邮件中验证链接点击回来
     *
     * @return void
     */
    public function actionActiveEmail() {
        // preprocess parameters
        $verify = $this->getString($_GET['verify']);

        // 没有参数
        if (empty($verify)) {
            $this->redirect($this->createFanghuUrl('site/index'));
        }

        // 解析激活码
        $arrVerify = AresUtil::parseVerifyCode($verify);
        //用户ID
        $verifycode_uid = intval($arrVerify[0]);

        //邮箱
        $verifycode_email = $arrVerify[1];

        //时间戳     注册时间       默认有效时间为24小时
        $verifycode_create_time = intval($arrVerify[2]);

        // 根据email查找ID
        $member_id = $verifycode_uid;
        $memberInfo = UcMember::model()->findByPk($member_id);

        if (!AresValidator::isValidEmail($verifycode_email) && empty($memberInfo)) {
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邮箱激活失败',
                'username' => $verifycode_email,
                'return_url' => $this->createFanghuUrl('site/index'),
            );
            $this->smartyRender('site/activefail.tpl', $arrRender);
            exit;
        }

        if ($memberInfo->member_email != $verifycode_email) {
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邮箱激活失败',
                'username' => $verifycode_email,
                'return_url' => $this->createFanghuUrl('site/index'),
            );
            $this->smartyRender('site/activefail.tpl', $arrRender);
            exit;
        }

        //更新用户表字段is_email_verified
        $memberInfo->is_email_actived = 1;
        if ($memberInfo->update()) {
            if ($is_email_actived == 0 && $this->checkPointLog($member_id, 'bind_email')) {
                $this->addPoint($member_id, 'bind_email');
            }
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邮箱激活成功',
                'username' => $verifycode_email,
                'return_url' => $this->createAbsoluteUrl('account/index'),
            );
            $this->smartyRender('site/activesuccess.tpl', $arrRender);
            exit;
        } else {
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邮箱激活失败',
                'username' => $verifycode_email,
                'return_url' => $this->createFanghuUrl('site/index'),
            );
            $this->smartyRender('site/activefail.tpl', $arrRender);
            exit;
        }
    }

    /**
     * 设置交易密码
     */
    public function actionDealpassword() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $member_mobile = empty($objMember->member_mobile) ? '' : substr_replace($objMember->member_mobile, '****', 3, 4);

        if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $new_password = $this->getString($_POST['new_password']);
            $confirm_password = $this->getString($_POST['confirm_password']);

            $verify_code = $this->getString($_POST['verify_code']);
            $sendResult = SmsDataService::verify($objMember->member_mobile, $verify_code);
            //验证失败则跳转
            if ($sendResult['code'] != '200') {
                $message = $sendResult['msg'];
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/dealpassword'));
                exit;
            }

            if ($new_password != $confirm_password) {
                $message = '两次交易密码输入不一致';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/dealpassword'));
                exit;
            }

            $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
            $objMember->deal_password = AresUtil::encryptPassword($new_password);
            if ($objMember->update()) {
                if ($this->checkPointLog($member_id, 'deal_password')) {
                    $this->addPoint($member_id, 'deal_password');
                }
                $status = 'success'; //成功
                $message = '交易密码设置成功';

                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/index'));
                exit;
            } else {
                $status = 'fail'; //失败
                $message = '交易密码设置失败，请重新操作';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/dealpassword'));
                exit;
            }
        }

        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '设置交易密码',
            'arrMsgStack' => $arrMsgStack,
            'mobile' => $member_mobile,
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/dealpassword.tpl', $arrRender);
    }

    /**
     * 修改交易密码
     */
    public function actionModdealpwd() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        $member_mobile = empty($objMember->member_mobile) ? '' : substr_replace($objMember->member_mobile, '****', 3, 4);

        $lock_time = date('Y-m-d', strtotime($objMember->dealpwd_lock_time));
        $now_time = date('Y-m-d', time());
        if ($lock_time == $now_time) {
            $this->redirect($this->createAbsoluteUrl('account/index'));
            exit;
        }

        if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $old_password = $this->getString($_POST['old_password']);
            $new_password = $this->getString($_POST['new_password']);
            $confirm_password = $this->getString($_POST['confirm_password']);

            $verify_code = $this->getString($_POST['verify_code']);
            $sendResult = SmsDataService::verify($objMember->member_mobile, $verify_code);
            //验证失败则跳转
            if ($sendResult['code'] != '200') {
                $message = $sendResult['msg'];
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/moddealpwd'));
                exit;
            }

            if ($new_password != $confirm_password) {
                $message = '两次交易密码输入不一致';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/moddealpwd'));
                exit;
            }

            if (!AresUtil::validatePassword($old_password, $objMember->deal_password)) {
                // send error
                $message = '请您输入正确的原密码';
                Yii::app()->loginUser->setFlash('error', $message);
                $objMember->mod_dealpwd_num += 1;
                $objMember->dealpwd_lock_time = $objMember->mod_dealpwd_num >= 3 ? date('Y-m-d H:i:s', time()) : '';
                $objMember->save();
                $this->redirect($this->createAbsoluteUrl('account/moddealpwd'));
                exit;
            }

            //$objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
            $objMember->deal_password = AresUtil::encryptPassword($new_password);
            $objMember->mod_dealpwd_num = 0;
            if ($objMember->update()) {
                $status = 'success'; //成功
                $message = '交易密码修改成功';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/index'));
                exit;
            } else {
                $status = 'fail'; //失败
                $message = '交易密码修改失败，请重新操作';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/moddealpwd'));
                exit;
            }
        }

        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '修改交易密码',
            'arrMsgStack' => $arrMsgStack,
            'mobile' => $member_mobile,
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/moddealpwd.tpl', $arrRender);
    }

    /**
     * 忘记交易密码 
     */
    public function actionForgetdealpwd() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));

        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (!empty($member_to_security)) {
            $arrRender = array(
                'question' => $member_to_security->question_1,
                'gShowHeader' => true,
                'arrMsgStack' => $arrMsgStack,
                'headerTitle' => '忘记交易密码',
                'return_url' => $this->createAbsoluteUrl('account/index'),
            );
            $this->smartyRender('account/forgetdealpwd.tpl', $arrRender);
        } else {
            $arrRender = array(
                'gShowHeader' => true,
                'arrMsgStack' => $arrMsgStack,
                'headerTitle' => '忘记交易密码',
                'answer' => '',
                'return_url' => $this->createAbsoluteUrl('account/index'),
            );
            $this->smartyRender('account/forgetdealpwdtwo.tpl', $arrRender);
        }
    }

    /**
     * 忘记交易密码 第二步
     */
    public function actionForgetdealpwdtwo() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();

        $answer = '';
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (!empty($member_to_security)) {
            if (!isset($_POST['answer'])) {
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }

            $answer = $this->getString($_POST['answer']);
            $old_answer = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
            if ($answer != $old_answer->answer_1) {
                $message = '密保答案不对';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
        }

        $arrRender = array(
            'gShowHeader' => true,
            'arrMsgStack' => $arrMsgStack,
            'headerTitle' => '忘记交易密码',
            'answer' => $answer,
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/forgetdealpwdtwo.tpl', $arrRender);
    }

    /**
     * 忘记交易密码 第三步
     */
    public function actionForgetdealpwdthree() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();

        $answer = '';
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (!empty($member_to_security)) {
            if (!isset($_POST['answer'])) {
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
            $answer = $this->getString($_POST['answer']);
            $old_answer = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
            if ($answer != $old_answer->answer_1) {

                $message = '密保答案不对';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
        }

        $member_id_number = $this->getString($_POST['member_id_number']);

        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        if ($member_id_number != $objMember->member_id_number) {
            $message = '身份证号不对';
            Yii::app()->loginUser->setFlash('error', $message);
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }

        $arrRender = array(
            'gShowHeader' => true,
            'arrMsgStack' => $arrMsgStack,
            'answer' => $answer,
            'member_id_number' => $member_id_number,
            'headerTitle' => '忘记交易密码',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/forgetdealpwdthree.tpl', $arrRender);
    }

    /**
     * 忘记交易密码 第四步
     */
    public function actionForgetdealpwdfour() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();

        $answer = '';
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (!empty($member_to_security)) {
            if (!isset($_POST['answer'])) {
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
            $answer = $this->getString($_POST['answer']);
            $old_answer = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
            if ($answer != $old_answer->answer_1) {
                $message = '密保答案不对';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
        }

        if (!isset($_POST['member_id_number'])) {
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }



        $member_id_number = $this->getString($_POST['member_id_number']);
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        if ($member_id_number != $objMember->member_id_number) {
            $message = '身份证号不对';
            Yii::app()->loginUser->setFlash('error', $message);
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }

        if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $new_password = $this->getString($_POST['new_password']);
            $confirm_password = $this->getString($_POST['confirm_password']);
            if ($new_password != $confirm_password) {
                $message = '两次交易密码输入不一致';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
        }

        $member_mobile = empty($objMember->member_mobile) ? '' : substr_replace($objMember->member_mobile, '****', 3, 4);
        $arrRender = array(
            'gShowHeader' => true,
            'arrMsgStack' => $arrMsgStack,
            'answer' => $answer,
            'member_id_number' => $member_id_number,
            'new_password' => $new_password,
            'mobile' => $member_mobile,
            'headerTitle' => '忘记交易密码',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/forgetdealpwdfour.tpl', $arrRender);
    }

    /**
     * 忘记交易密码 第五步
     */
    public function actionForgetdealpwdfive() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();


        $answer = '';
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (!empty($member_to_security)) {
            if (!isset($_POST['answer'])) {
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
            $answer = $this->getString($_POST['answer']);
            $old_answer = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
            if ($answer != $old_answer->answer_1) {
                $message = '密保答案不对';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
                exit;
            }
        }


        if (!isset($_POST['member_id_number']) || !isset($_POST['new_password'])) {
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }

        $member_id_number = $this->getString($_POST['member_id_number']);
        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
        if ($member_id_number != $objMember->member_id_number) {
            $message = '身份证号不对';
            Yii::app()->loginUser->setFlash('error', $message);
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }

        $new_password = $this->getString($_POST['new_password']);

        $verify_code = $this->getString($_POST['verify_code']);
        $sendResult = SmsDataService::verify($objMember->member_mobile, $verify_code);
        if ($sendResult['code'] != '200') {
            $message = $sendResult['msg'];
            Yii::app()->loginUser->setFlash('error', $message);
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }
        $objMember->deal_password = AresUtil::encryptPassword($new_password);
        $objMember->mod_dealpwd_num = 0;
        $objMember->dealpwd_lock_time = 0;
        if ($objMember->update()) {
            $message = '交易密码修改成功';
            Yii::app()->loginUser->setFlash('error', $message);
            $this->redirect($this->createAbsoluteUrl('account/index'));
        } else {
            $message = '交易密码修改失败，请重新操作';
            Yii::app()->loginUser->setFlash('error', $message);
            $this->redirect($this->createAbsoluteUrl('account/forgetdealpwd'));
            exit;
        }
    }

    /**
     * 修改密码
     */
    public function actionModPwd() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $arrMsgStack = Yii::app()->loginUser->getFlashes();
        $objMember = UcMember::model()->findByPk($member_id);
        $member_mobile = empty($objMember->member_mobile) ? '' : substr_replace($objMember->member_mobile, '****', 3, 4);

        if (isset($_POST['new_password']) && isset($_POST['old_password'])) {
            $old_password = $this->getString($_POST['old_password']);
            $new_password = $this->getString($_POST['new_password']);
            $confirm_password = $this->getString($_POST['confirm_password']);


            $verify_code = $this->getString($_POST['verify_code']);
            $sendResult = SmsDataService::verify($objMember->member_mobile, $verify_code);
            //验证失败则跳转
            if ($sendResult['code'] != '200') {
                $message = $sendResult['msg'];
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/modpwd'));
                exit;
            }

            //$objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
            if (!AresUtil::validatePassword($old_password, $objMember->member_password)) {
                // send error
                $message = '请您输入正确的原密码';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/modpwd'));
                exit;
            }



            //验证数据
            if ($old_password == $new_password) {
                // send error
                $message = '新密码不能与旧密码一致';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/modpwd'));
                exit;
            }
            if ($new_password != $confirm_password) {
                // send error
                $message = '两次密码输入不一致';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/modpwd'));
                exit;
            }

            //更新为新密码
            $objMember->member_password = AresUtil::encryptPassword($new_password);
            if ($objMember->update()) {
                $return_url = $this->checkReturnUrl();
                $status = 'success';
                $message = '修改密码成功，请重新登录';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('user/logout', array('return_url' => $return_url)));
                //$this->redirect($this->createAbsoluteUrl('user/login',array('return_url'=>$return_url)));
                //exit;
                //$this->redirect($this->createAbsoluteUrl('user/user',array('return_url'=>$return_url)));
            } else {
                $status = 'fail';
                $message = '修改密码失败';
                Yii::app()->loginUser->setFlash('error', $message);
                $this->redirect($this->createAbsoluteUrl('account/modpwd'));
                exit;
                /*
                  $arrRender = array(
                  'message' => $message,
                  'mobile' => $member_mobile,
                  'return_url' => $this->createAbsoluteUrl('account/index'),
                  );
                  $this->smartyRender('account/modpwd.tpl', $arrRender);
                 */
            }
        } else {
            $arrRender = array(
                'gShowHeader' => true,
                'mobile' => $member_mobile,
                'return_url' => $this->createAbsoluteUrl('account/index'),
                'headerTitle' => '修改密码',
                'arrMsgStack' => $arrMsgStack,
            );
            $this->smartyRender('account/modpwd.tpl', $arrRender);
        }
    }

    /**
     * security questions of member
     */
    public function actionSecurityQuestions() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        if (isset($_GET['state']) && isset($_GET['signage']) && $_GET['state'] != '' && $_GET['signage'] != '') {
            if ($_SESSION['__loginUser']['signage'] != $this->getString($_GET['signage'])) {
                $this->redirect('ucenter.php?r=site/error');
            }
        }
        //查询密保问题
        $security_questions = UcSecurityQuestion::model()->findAll();
//                var_dump($security_questions);die;
        $arrRender = array(
            'member_id' => $member_id,
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('account/index'),
            'headerTitle' => '设置安全问题',
            'questions' => $security_questions,
        );
        $this->smartyRender('account/setques_one.tpl', $arrRender);         //三个密保问题模板setques.tpl
    }

    /**
     * set security questions of member
     */
    public function actionSetQuestions() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $member_security_question = UcMemberToSecurityQuestion::model()->findByAttributes(array('membe_id' => $member_id));
        if (!$member_security_question) {
            $member_security_question = new UcMemberToSecurityQuestion();
        }

        if (isset($_POST['change']) && $_POST['change'] != '') {
            $member_security_question = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
            $member_security_question->attributes = $_POST['change'];
            //$_POST['SecurityQuestion']['status'] == 0;
        }
        $member_security_question->attributes = $_POST['SecurityQuestion'];
        if ($member_security_question->save()) {
            $this->redirect('ucenter.php?r=account/confirmQuestions&action=update');
        }
    }

    /**
     * find password by security questions
     */
    public function actionAnswerQuestion() {
        $member_id = Yii::app()->loginUser->getUserId();
        $member_security_question = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        $arrRender = array(
            'arrData' => $member_security_question,
        );
        $this->smartyRender('account/showques.tpl', $arrRender);
    }

    /**
     * matching the security questions and answers of member
     */
    public function actionMatchQuestions() {
        $member_to_questions = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $this->getInt($_POST['SecurityQuestion']['member_id'])));
        $interect = array_intersect($_POST['SecurityQuestion'], $member_to_questions->attributes);
        if ($interect == $_POST['SecurityQuestion']) {
            echo '密保问题正确';
        } else {
            echo '密保问题不正确';
        }
    }

    /**
     * confirm answers of the security questions of member
     */
    public function actionConfirmQuestions() {
        $this->checkLogin();
        //当前会员编号
        $member_id = Yii::app()->loginUser->getUserId();
        //查询当前会员对应的密保问题信息
        $security_questions = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        $error = '';

        if (isset($_POST['SecurityQuestion']) && $_POST['SecurityQuestion'] != '') {

            //如果密保问题不匹配则提示

            for ($i = 1; $i <= 3; $i++) {
                $answer = 'answer_';
                $answer .= $i;
                if ($_POST['SecurityQuestion']['answer_' . $i] != $security_questions->$answer) {
                    $error = '密保答案不正确';
                }
            }

            //更改会员与密保问题关联信息状态
            $security_questions->status = 1;
            if ($error == '' && $security_questions->save()) {
                if ($this->checkPointLog($member_id, 'question')) {
                    $this->addPoint($member_id, 'question');
                }
                //跳转至密保设置成功页面
                $this->redirect('ucenter.php?r=account/questionDone');
            }
        }



        $arrRender = array(
            'arrData' => $security_questions,
            'gShowHeader' => true,
            'error' => $error,
            'headerTitle' => '确认安全问题',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/confirmques.tpl', $arrRender);
    }

    /**
     * change the security questions of member
     */
    public function actionSetNewQuestion() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $member = UcMember::model()->findByPk($member_id);
        $questions = UcSecurityQuestion::model()->findAll();
        $error = '';
        //查询当前会员的密保问题信息，判断会员是否已设置密保问题
        $arrRender = array(
            'questions' => $questions,
            'member' => $member,
            'email' => substr_replace($member->member_email, '****', 2, 4),
            'member_mobile' => substr_replace($member->member_mobile, '****', 3, 4),
            'member_id' => $member_id,
            'gShowHeader' => true,
            'error' => $error,
            'headerTitle' => '修改安全问题',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/changeques.tpl', $arrRender);
    }

    /**
     * 密保问题设置成功
     */
    public function actionQuestionDone() {
        $this->checkLogin();

        $arrRender = array(
            'gShowHeader' => true,
            'action' => 'set',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/questiondone.tpl', $arrRender);
    }

    /**
     * set single security question
     */
    public function actionSetQuestion() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (!$member_to_security) {
            $member_to_security = new UcMemberToSecurityQuestion();
        }
        $member_to_security->member_id = $member_id;
        $member_to_security->security_question_id_1 = $this->getString($_POST['SecurityQuestion']['question']);
        $member_to_security->answer_1 = $this->getString($_POST['SecurityQuestion']['answer']);
        $member_to_security->status = 1;
        if ($member_to_security->save()) {
            if ($this->checkPointLog($member_id, 'set_question')) {
                $this->addPoint($member_id, 'set_question');
            }
            $this->redirect('ucenter.php?r=account/QuestionDone');
        }
    }

    /**
     * confirm single security question
     */
    public function actionConfirm() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $error = '';
        //查找会员密保问题关联id
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        if (isset($_POST['SecurityQuestion']['answer']) && $_POST['SecurityQuestion']['answer']) {
            if ($member_to_security->answer_1 != $this->getString($_POST['SecurityQuestion']['answer'])) {
                $error = '密保答案不正确';
            } else {
                $member_to_security->status = 1;
                $member_to_security->save();
                $this->redirect('ucenter.php?r=account/questionDone');
            }
        }
        //查找会员密保问题
        $member_question = UcSecurityQuestion::model()->findByPk($member_to_security->security_question_id_1);
        $arrRender = array(
            'error' => $error,
            'member_id' => $member_id,
            'gShowHeader' => true,
            'return_url' => $this->createAbsoluteUrl('account/index'),
            'headerTitle' => '确认安全问题',
            'question' => $member_question->question_text,
        );
        $this->smartyRender('account/confirm_one.tpl', $arrRender);
    }

    /**
     * match single security question
     */
    public function actionMatchQuestion() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        //查找密保问题答案
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
        echo $member_to_security->answer_1;
        //密保问题答案匹配
        if ($member_to_security->answer_1 != $this->getString($_POST['SecurityQuestion']['answer'])) {
            $error = '';
        }
    }

    /**
     * change single security question
     */
    public function actionChangeQuestion() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
        $error = '';
        //查询所有密保问题
        $questions = UcSecurityQuestion::model()->findAll();
        //查询当前会员设置的密保问题
        $member_to_security = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $member_id));
//            var_dump($member_to_security->question_1);die;
        $arrRender = array(
            'questions' => $questions,
            'question' => $member_to_security->question_1,
            'member_id' => $member_id,
            'gShowHeader' => true,
            'error' => $error,
            'headerTitle' => '修改安全问题',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/changequestion.tpl', $arrRender);
    }

    /**
     * reset security question
     */
    public function actionResetQuestion() {

        $member_id = Yii::app()->loginUser->getUserId();
        $member = UcMember::model()->findByPk($member_id);
        $error = '';
        $arrRender = array(
            'email' => substr_replace($member->member_email, '****', 2, 4),
            'member_mobile' => substr_replace($member->member_mobile, '****', 3, 4),
            'mobile' => $member->member_mobile,
            'or_email' => $member->member_email,
//                'questions' => $questions,
//                'question' => $member_to_security->question_1,
            'member_id' => $member_id,
            'gShowHeader' => true,
            'error' => $error,
            'headerTitle' => '重置安全问题',
            'return_url' => $this->createAbsoluteUrl('account/index'),
        );
        $this->smartyRender('account/changeque_2.tpl', $arrRender);
    }


}
