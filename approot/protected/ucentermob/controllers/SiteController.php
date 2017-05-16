<?php

class SiteController extends Controller {

    public function actionIndex() {
        $return_url = $this->checkReturnUrl();
        $this->redirect($return_url);
    }

    public function actionError() {
        $return_url = $this->checkReturnUrl();
        $arrRender = array(
            'gShowHeader' => true,
            'headerTitle' => '访问错误',
            'indexUrl' => $return_url,
        );
        $this->smartyRender('errorview/404.tpl', $arrRender);
    }

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

    /**
     * 使用密保问题找回密码方法
     */
    public function actionFindPasswordByQuestion() {
        //获取该帐号的密保问题
        if (isset($_POST['member_id']) && $_POST['member_id'] != '') {
            $security_questions = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $this->getString($_POST['member_id'])));
        }

        $error = '';
        if (isset($_POST['SecurityQuestion']) && $_POST['SecurityQuestion'] != '') {
            $security_questions = UcMemberToSecurityQuestion::model()->findByAttributes(array('member_id' => $this->getString($_POST['SecurityQuestion']['member_id'])));
            //如果密保问题不匹配则提示

            for ($i = 1; $i <= 3; $i++) {
                $answer = 'answer_';
                $answer .= $i;
                if ($_POST['SecurityQuestion']['answer_' . $i] != $security_questions->$answer) {
                    $error = '密保答案不正确';
                }
            }

            if ($error == '') {
                //跳转到设置新密码页面
                $this->redirect('ucenter.php?r=site/resetpwd&return_url=' . $this->outPutString($_GET['return_url']));
            }
        }
        $arrRender = array(
            'arrData' => $security_questions,
            'gShowHeader' => true,
            'error' => $error,
            'headerTitle' => '确认安全问题',
            'return_url' => $this->outPutString($_GET['return_url']),
        );
        $this->smartyRender('site/confirmques.tpl', $arrRender);
    }

    /**
     * reset new password
     */
    public function actionResetPwd() {
        $error = '';
        if (isset($_POST['confirm_password']) && $_POST['confirm_password'] != '') {
            if ($this->getString($_POST['new_password']) != $this->getString($_POST['confirm_password'])) {
                $error = '两次密码输入不同';
            } else {
                session_start();
                $member = UcMember::model()->findByPk($_SESSION['tmp_member_id']);
                $member->member_password = AresUtil::encryptPassword($this->getString($_POST['new_password']));
                if ($member->save()) {
                    unset($_SESSION['tmp_member_id']);
                    $this->redirect('ucenter.php?r=user/login&return_url=' . $this->outPutString($_GET['return_url']) . '&resetpwd=1');
                }
            }
        }
        $arrRender = array(
            'error' => $error,
            'gShowHeader' => true,
            'return_url' => $this->outPutString($_GET['return_url']),
            'headerTitle' => '修改密码',
            'message' => '',
        );
        $this->smartyRender('site/modpwd.tpl', $arrRender);
    }

}
