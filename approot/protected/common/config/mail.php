<?php
/**
 * 邮件配置服务
 */

return array(
    'viewPath' => 'application.common.views.mail',
    'layoutPath' => 'application.common.views.layouts',
    'baseDirPath' => 'webroot.images.mail', //note: 'webroot' alias in console apps may not be the same as in web apps
    'savePath' => 'webroot.assets.mail',
    'testMode' => false,
    'layout' => 'mail',
    'CharSet' => 'UTF-8',
    'AltBody' => Yii::t('AresMailer', 'You need an HTML capable viewer to read this message.'),
    'language' => array(
        'authenticate' => Yii::t('AresMailer', 'SMTP Error: Could not authenticate.'),
        'connect_host' => Yii::t('AresMailer', 'SMTP Error: Could not connect to SMTP host.'),
        'data_not_accepted' => Yii::t('AresMailer', 'SMTP Error: Data not accepted.'),
        'empty_message' => Yii::t('AresMailer', 'Message body empty'),
        'encoding' => Yii::t('AresMailer', 'Unknown encoding: '),
        'execute' => Yii::t('AresMailer', 'Could not execute: '),
        'file_access' => Yii::t('AresMailer', 'Could not access file: '),
        'file_open' => Yii::t('AresMailer', 'File Error: Could not open file: '),
        'from_failed' => Yii::t('AresMailer', 'The following From address failed: '),
        'instantiate' => Yii::t('AresMailer', 'Could not instantiate mail function.'),
        'invalid_address' => Yii::t('AresMailer', 'Invalid address'),
        'mailer_not_supported' => Yii::t('AresMailer', ' mailer is not supported.'),
        'provide_address' => Yii::t('AresMailer', 'You must provide at least one recipient email address.'),
        'recipients_failed' => Yii::t('AresMailer', 'SMTP Error: The following recipients failed: '),
        'signing' => Yii::t('AresMailer', 'Signing Error: '),
        'smtp_connect_failed' => Yii::t('AresMailer', 'SMTP Connect() failed.'),
        'smtp_error' => Yii::t('AresMailer', 'SMTP server error: '),
        'variable_set' => Yii::t('AresMailer', 'Cannot set or reset variable: ')
    ),
    
    // if you want to use SMTP, uncomment and configure lines below to your needs
    'Mailer' => 'smtp',
    'Host' => 'smtp.qq.com',
    'Port' => 25,
    'SMTPSecure' => '',
    'SMTPAuth' => true,
    'Username' => 'sys-mailer@fangfull.com',
    'Password' => 'sys_ff_125a',
);