<?php

/**
 * 数据服务层，主要负责模块化数据处理，第三方服务访问
 * 
 * @author liutao@fangfull.com
 * @date 2014/11/09 10:53:50
 */
class EmailDataService extends BaseDataService {

        const MAIL_WEBSITE_SHORT_NAME = '新奇世界';
        const MAIL_WEBSITE_FULL_NAME = '新奇世界网';

        /**
         * 使用AresMailer发送邮件
         * 
         * @param  string $mailTo        收件人
         * @param  string $mailSubject   邮件主题
         * @param  string $mailTpl       邮件模板
         * @param  array  $mailTplParams 邮件内容动态数据
         * @return array                 邮件发送结果
         */
        public static function sendTemplateEmail($mailTo, $mailSubject, $mailTpl, $mailTplParams = array()) {

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
                AresLogManager::log_bi(array('logKey' => '[API][' . __METHOD__ . ']', 'desc' => 'send email', 'parameters' => $parameters, 'response' => $result));

                //unset
                $objMailer = null;

                return $result;
        }

        /*         * ************* send email template functions ************** */

        /**
         * 发送忘记密码邮件
         * 
         * @param  string $mail_to   收件人
         * @param  array  $mail_data 邮件动态数据
         * @return array
         */
        public static function sendForgetPassword($mail_to, $mail_data) {
                // mail setting
//                $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 找回密码';
                $mail_subject = '新奇世界会员通行证' . ' 重设密码';
                $mail_content = '您在' . date('Y-m-d H:i', time()) . '申请在新奇世界重设密码';
                $mail_parameters = array(
//                    'EMAIL_TXT_WELCOME_NAME' => $mail_data['welcome_name'],
//                    'EMAIL_TXT_NEW_PASSWORD' => $mail_data['password'],
                    'EMAIL_TXT_VERIFY_CONTENT' => $mail_content,
                    'EMAIL_LINK_LOGIN' => $mail_data['url'],
                    'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
                    'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
                );
                $mail_template = 'ucenter_email_template_forgot_password';

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
                $mail_subject = '感谢您注册成为' . self::MAIL_WEBSITE_FULL_NAME . '会员';
                $mail_content = '亲爱的会员您好<br />';
                $mail_content .= '欢迎您成为'.self::MAIL_WEBSITE_FULL_NAME.'的一员！<br />';
                $mail_content .= '在这里，我们将用贴心的服务为您带来更多的价值，成为您值得信赖的好伙伴。<br />';
                $mail_parameters = array(
//                    'EMAIL_TXT_WELCOME_NAME' => $mail_data['welcome_name'],
                    'EMAIL_TXT_VERIFY_CONTENT' => $mail_content,
                    'EMAIL_LINK_VERIFY' => $mail_data['url'],
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
                $mail_subject = self::MAIL_WEBSITE_FULL_NAME . '邮箱验证码';
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
        public static function sendVerifyCode($mail_to, $mail_data, $isEmailChangeMode = true) {
                // mail setting
                if ($isEmailChangeMode) {
                        $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 邮箱修改激活邮件';
                        $mail_content = '您在' . date('Y-m-d H:i', time()) . '分在' .self::MAIL_WEBSITE_FULL_NAME. '发起邮箱修改的需求';
                } else {
                        $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 邮箱激活邮件';
                        $mail_content = '您在' . date('Y-m-d H:i', time()) . '分在' . self::MAIL_WEBSITE_FULL_NAME. '发起邮箱修改的需求。';
                }
                $mail_parameters = array(
//                    'EMAIL_TXT_WELCOME_NAME' => $mail_data['welcome_name'],
                    'EMAIL_TXT_VERIFY_CONTENT' => $mail_content,
//                    'EMAIL_LINK_VERIFY' => self::createUrl('user/registerSuccess', array('signage' => $mail_data['signage'], 'verify' => $mail_data['verify_code'])),
                    'EMAIL_LINK_VERIFY' => $mail_data['url'],
                    'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
                    'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
                );

                $mail_template = 'email_template_email_verify';

                // send email
                $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

                return $sendResult;
        }

        /**
         * 发送重置密保问题链接
         *
         *  @param  string $mail_to   收件人
         * @param  array  $mail_data 邮件动态数据
         * @return array
         */
        public static function sendResetQuesUrl($mail_to, $mail_data, $url,  $isEmailChangeMode = true) {
            // mail setting

            $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 重置密保问题';
            $mail_content = '您在' . date('Y-m-d H:i', time()) . '分在' . self::MAIL_WEBSITE_FULL_NAME . '请求重置密保问题。'.'请点击或复制以链接至密保问题重置页面<br />'.$url;

            $mail_parameters = array(
                'EMAIL_TXT_WELCOME_NAME' => '新奇世界重置密保问题',
                'EMAIL_TXT_VERIFY_CONTENT' => $mail_content,
                'EMAIL_LINK_VERIFY' => $mail_content,
//                'EMAIL_LINK_VERIFY' => self::createUrl('member/verifyEmail', array('verify' => $mail_data['verify_code'])),
                'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
                'URL' => $url,
                'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
            );

            $mail_template = 'email_template_reset_security_question';

            // send email
            $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

            return $sendResult;
        }


        /**
         * 邮箱绑定邮件发送
         */
        public static function sendBindEmail($mail_to, $url) {
            $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 绑定邮箱';
            $mail_content = '您在' . date('Y-m-d H:i', time()) . '分在' . self::MAIL_WEBSITE_FULL_NAME . '发起邮箱绑定的需求<br />';

            $mail_parameters = array(
                'EMAIL_TXT_WELCOME_NAME' => '亲爱的会员',
                'EMAIL_TXT_BIND_CONTENT' => $mail_content,
                'EMAIL_LINK_VERIFY' => $url,
                'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
                'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
            );

            $mail_template = 'email_template_bind_email';

            // send email
            $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

            return $sendResult;
        }

        /**
         * 邮箱激活邮件发送
         */
        public static function sendActiveEmail($mail_to, $mail_data, $isEmailChangeMode=true) {
            // mail setting
            if ($isEmailChangeMode) {
                $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 邮箱修改激活邮件';
                $mail_content = '您在' . date('Y-m-d H:i', time()) . '分在' . self::MAIL_WEBSITE_FULL_NAME . '发起的邮箱修改需求已经处理完成。';
            } else {
                $mail_subject = self::MAIL_WEBSITE_FULL_NAME . ' 邮箱激活邮件';
                $mail_content = '您在' . date('Y-m-d H:i', time()) . '分在' . self::MAIL_WEBSITE_FULL_NAME . '发起的邮箱激活需求已经处理完成。';
            }
            $mail_parameters = array(
                'EMAIL_TXT_WELCOME_NAME' => '新奇世界绑定邮箱',
                'EMAIL_TXT_VERIFY_CONTENT' => $mail_content,
                'EMAIL_LINK_VERIFY' => self::createUrl('account/activeEmail', array('signage' => $mail_data['signage'], 'verify' => $mail_data['verify_code'], 'active' => 'active')),
                'EMAIL_TXT_WEBSITE_SHORT_NAME' => self::MAIL_WEBSITE_SHORT_NAME,
                'EMAIL_LINK_WEBSITE' => self::createUrl('site/index'),
            );

            $mail_template = 'email_template_email_verify';

            // send email
            $sendResult = self::sendTemplateEmail($mail_to, $mail_subject, $mail_template, $mail_parameters);

            return $sendResult;
        }

}
