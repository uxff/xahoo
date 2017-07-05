<?php
/**
 * 数据服务层，主要负责模块化数据处理，第三方服务访问
 * 
 * @author liutao@fangfull.com
 * @date 2014/11/09 10:53:50
 */
class EmailDataService extends BaseDataService {

    const MAIL_WEBSITE_SHORT_NAME = 'Xahoo';
    const MAIL_WEBSITE_FULL_NAME = 'Xahoo';

    /**
     * 使用AresMailer发送邮件
     * 
     * @param  string $mailTo        收件人
     * @param  string $mailSubject   邮件主题
     * @param  string $mailTpl       邮件模板
     * @param  array  $mailTplParams 邮件内容动态数据
     * @return array                 邮件发送结果
     */
    public static function sendTemplateEmail($mailTo, $mailSubject, $mailTpl, $mailTplParams=array()) {

        // init mailer
        $objMailer = new AresMailer($mailTpl, $mailTplParams);
        
        // set smtp server
        // Note: smtp has configured in mail.php
        //$objMailer->setSmtp('smtp.qq.com', 25, '', true, '', 'sys-mailer@fangfull.com', 'Password');
        
        // set properties
        $objMailer->setTo($mailTo);
        $objMailer->setSubject($mailSubject);

        // send
        if ($objMailer->send()) {
            $result['status'] = true;
            $result['errmsg'] = '';
        } else {
            $result['status'] = false;
            $result['errmsg'] = $objMailer->getError();
        }

        // add log
        $parameters = array(
            'mail_to' => $mailTo,
            'mail_subject' => $mailSubject,
            'mail_template' => $mailTpl,
            'mail_parameters' => $mailTplParams,
        );
        AresLogManager::log_bi(array('logKey' => '[API]['.__METHOD__.']', 'desc' => 'send email', 'parameters' => $parameters, 'response' => $result));

        //unset
        $objMailer = null;

        return $result;
    }
 
    /*************** send email template functions ***************/

    /**
     * 发送忘记密码邮件
     * 
     * @param  string $mail_to   收件人
     * @param  array  $mail_data 邮件动态数据
     * @return array
     */
    public static function sendForgetPassword($mail_to, $mail_data) {
        // mail setting
        $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 找回密码';
        $mail_parameters = array(
            'EMAIL_TXT_WELCOME_NAME' => $mail_data['welcome_name'],
            'EMAIL_TXT_NEW_PASSWORD' => $mail_data['new_password'],
            'EMAIL_LINK_LOGIN' => self::createUrl('site/login'),
            'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
            'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
        );
        $mail_template = 'email_template_password_forgotten';

        // send email
        $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

        return $sendResult;
    }

    /**
     * 发送注册邮件
     * 
     * @param  string $mail_to   收件人
     * @param  array  $mail_data 邮件动态数据
     * @return array
     */
    public static function sendRegisterWelcome($mail_to, $mail_data) {
        // mail setting
        $mail_subject = '感谢您注册成为'. self::MAIL_WEBSITE_FULL_NAME . '会员';
        $mail_parameters = array(
            'EMAIL_TXT_WELCOME_NAME' => $mail_data['welcome_name'],
            'EMAIL_LINK_VERIFY' => self::createUrl('member/verifyEmail', array('verify'=>$mail_data['verify_code'])),
            'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
            'EMAIL_TXT_WEBSITE_FULL_NAME' => self::MAIL_WEBSITE_FULL_NAME,
            'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
        );
        $mail_template = 'email_template_register_confirm';

        // send email
        $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

        return $sendResult;
    }


    /**
     * 发送注册邮箱时的验证码
     * 
     * @param  string $email   收件人
     * @param  array  $verify_code 验证码
     * @return array
     */
    public static function sendRegisterVerifyCode($email, $verify_code) {
        // mail setting
        $mail_subject = self::MAIL_WEBSITE_FULL_NAME .'邮箱验证码';
        $mail_parameters = array(
            'EMAIL_TXT_WELCOME_NAME' => $email,
            'EMAIL_VERIFY_CODE' => $verify_code,
            'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
            'EMAIL_TXT_WEBSITE_FULL_NAME' => self::MAIL_WEBSITE_FULL_NAME,
            'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
        );
        $mail_template = 'email_template_register_verifycode';

        // send email
        $sendResult = self::sendTemplateEmail($email, $mail_subject, $mail_template, $mail_parameters);

        return $sendResult;
    }


    /**
     * 发送验证码邮件
     * 包含激活，邮箱修改
     * 
     * @param  string $mail_to   收件人
     * @param  array  $mail_data 邮件动态数据
     * @return array
     */
    public static function sendVerifyCode($mail_to, $mail_data, $isEmailChangeMode=true) {
        // mail setting
        if ($isEmailChangeMode) {
            $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 邮箱修改激活邮件';
            $mail_content = '您在'. date('Y-m-d H:i',  time()) .'分在'. self::MAIL_WEBSITE_FULL_NAME .'发起的邮箱修改需求已经处理完成。';
        } else {
            $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 邮箱激活邮件';
            $mail_content = '您在'. date('Y-m-d H:i',  time()) .'分在'. self::MAIL_WEBSITE_FULL_NAME .'发起的邮箱激活需求已经处理完成。';
        }
        $mail_parameters = array(
            'EMAIL_TXT_WELCOME_NAME' => $mail_data['welcome_name'],
            'EMAIL_TXT_VERIFY_CONTENT' => $mail_content,
            'EMAIL_LINK_VERIFY' => self::createUrl('member/verifyEmail', array('verify'=>$mail_data['verify_code'])),
            'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
            'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
        );

        $mail_template = 'email_template_email_verify';

        // send email
        $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

        return $sendResult;
    }

}