<?php
//https://itest.xqshijie.com/xqsjadmin.php?r=virtualCurrency/default

Yii::import("application.common.service.SmsManager");
Yii::import("application.common.extensions.AresUtil");
Yii::import("application.common.extensions.AresLogManager");

class BaseSendSMS extends MobileModule
{
    const ERROR_LOG_KEY = '[third_service_error][send_sms]';
    
    /*************************购卡流程短信发送模板开始****************************/

/**预购开始  */ 
    /**预购全款  */
    const SMS_TPL_FQORDER_YUGOU_QUANKUAN_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已预定购买新奇世界- %(project_name)s逸乐通卡，由于您指定的项目暂未开放预售，目前您无法进行余款支付，待开放预售后，我们会以短信方式告知您，请保持电话畅通， 如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任！[中弘控股-新奇世界]';//逸乐通频道  预购  全款  支付首付款
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php
    
    /**预购借贷  */
    //const SMS_TPL_FQORDER_YUGOU_JIEDAI_REMAIN_TWODAYS='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，订单即将过期，为确保您的权益，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//预购  借贷 到期前两天，短信提醒
    const SMS_TPL_FQORDER_YUGOU_JIEDAI_FIRSTPAYOK='尊敬的%(user_name)s先生/女士，您已预订购买新奇世界-%(project_name)s逸乐通卡，并申请贷款方式支付余款，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道 预购 借贷 支付首付款
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php
    
    const SMS_TPL_FQORDER_YUGOU_JIEDAI_DATASUBMITOK='尊敬的%(user_name)s先生/女士，您已成功提交借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡），我们将以短信方式告知您审核结果，请耐心等待。 [仟金所]';//预购借贷审核资料提交成功 和预售是一样的
    //调用页面： /xqsjfqpc/controllers/CustomerController.php,/xqsjfqmob/controllers/CustomerController.php
/**预购结束  */
    
    
/**预售开始   */  
    /** 预售全款  */
    const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已成功预定新奇世界-%(project_name)s逸乐通卡，请于7个工作日内支付余款，逾期订单将自动取消，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道  预售  全款  支付首付款
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php

    const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，订单即将过期，为确保您的权益，请尽快完成余款支付，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//预售  全款 到期前两天，短信提醒
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php

    const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_PAYOK='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，现已成功支付，请尽快登陆个人中心“我的订单"下载、签署合同，并按照页面提示寄发。逸乐通卡会员尊享：超值回报，一卡游遍中国，全国自由换住，乐享新奇世界十五大超炫业态，更多权益详情请登陆新奇世界官网www.xqshijie.com或拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//预售全款 购卡成功
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php
    
    const SMS_TPL_FQORDER_YUSHOU_QUANKUAN_HETONGOK='尊敬的%(user_name)s先生/女士，恭喜您成功购买新奇世界-%(project_name)s逸乐通卡，成为新奇世界逸乐通卡会员。您签署的新奇世界-%(project_name)s逸乐通卡相关合同已经寄出，请留意查收，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//销售中心合同管理员更改合同状态为“已签署”
    //合同管理审核通过 调用页面 /xqsjadmin/controllers/OrderContractController.php
    
    /** 预售借贷  */
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_FIRSTPAYOK = '尊敬的%(user_name)s先生/女士，您已预定购买新奇世界-%(project_name)s逸乐通卡，并申请贷款方式支付余款，请尽快登陆个人中心“我的订单“下载、签署合同，并按照页面提示寄发，同时请于7个工作日内提交借贷审核资料，逾期订单将自动取消，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//逸乐通频道 预售 借贷 支付首付款
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，订单即将过期，为确保您的权益，请尽快提交借贷审核资料，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';
    //调用页面： /xqsjfqpc/controllers/BillingController.php,/xqsjfqmob/controllers/BillingController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATASUBMITOK='尊敬的%(user_name)s先生/女士，您已成功提交借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡），我们将以短信方式告知您审核结果，请耐心等待。 [仟金所]';//借贷审核资料提交成功
    //调用页面： /xqsjfqpc/controllers/CustomerController.php,/xqsjfqmob/controllers/CustomerController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAOK='尊敬的%(user_name)s先生/女士，您提交的借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡）已通过审核，请按合同约定按时还款，非常感谢您的理解与信任。[仟金所]';//资料审核通过 借贷购卡成功且仟金所满标
    //调用页面： /ucenteradmin/controllers/MemberInfoController.php,/ucenteradmin/controllers/CompanyInfoController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAFAIL_QIANJINS='尊敬的%(user_name)s先生/女士，您提交的借贷审核资料（购买新奇世界-%(project_name)s逸乐通卡）未通过审核，您可在7个工作日内补充借贷审核资料。[仟金所]';//借贷审核未通过 仟金所名义发送短信
    //调用页面： /ucenteradmin/controllers/MemberInfoController.php,/ucenteradmin/controllers/CompanyInfoController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAFAIL_XQSHIJIE='尊敬的%(user_name)s先生/女士，您为购买新奇世界-%(project_name)s逸乐通卡所提交的借贷审核资料未通过审核方审核，您可在7个工作日内登陆新奇世界官方网站选择全款购买。如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//借贷审核未通过 新奇世界名义发短信
    //调用页面： /ucenteradmin/controllers/MemberInfoController.php,/ucenteradmin/controllers/CompanyInfoController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED='尊敬的%(user_name)s先生/女士，您预定的新奇世界-%(project_name)s逸乐通卡，由于未在7个工作日内申请全款购买或补充借贷审核资料，该订单现已过期，请登陆新奇世界官网进行退款申请，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任，我们由衷地期待与您的合作！[中弘控股-新奇世界]';//7日订单失败
    //调用页面： /ucenteradmin/controllers/MemberInfoController.php,/ucenteradmin/controllers/CompanyInfoController.php
    
    const SMS_TPL_FQORDER_YUSHOU_JIEDAI_HETONGOK='尊敬的%(user_name)s先生/女士，恭喜您成功购买新奇世界-%(project_name)s逸乐通卡，成为新奇世界逸乐通卡会员。您签署的新奇世界-%(project_name)s逸乐通卡相关合同已经寄出，请留意查收，如有疑问请拨打客服热线400-900-0979，非常感谢您的理解与信任。[中弘控股-新奇世界]';//合同已签署
    //合同管理审核通过 调用页面 /xqsjadmin/controllers/OrderContractController.php 与全款合同一致
    /*************************购卡流程短信发送模板结束****************************/

    //生成短信内容
    function getContent($smstpl='',$params){
        $smstplinfo=constant( self.'::'.$smstpl);
        $content = AresUtil::sprintfWithArray($smstplinfo,$params);
        return $content;
    }
    
    
    /**
     * 发送短信通用接口 
     * @param unknown $phone 手机号
     * @param unknown $params 短信参数
     * @param string $smstpl 发送短信的模板变量名称
     * @param timestamp $sendtime 2016-01-01 00:00:01
     * @param string $zoneCode
     * @return Ambigous <multitype:string , multitype:string returnstatus >
     */
    public static  function addSmsQueue($phone, $content,$order_id='',$smstpl,$sendtime='', $zoneCode = '86'){
        !$sendtime && $sendtime=date("Y-m-d H:i:s",time());
        $objFqOrderSms = new FqOrderSms;
        $objFqOrderSms->order_id=$order_id;
        $objFqOrderSms->sms_mobile=$phone;
        $objFqOrderSms->sms_message=$content;
        $objFqOrderSms->smstpl=$smstpl;
        $objFqOrderSms->pre_send_time=$sendtime;
        if($objFqOrderSms->save()){
            return true;
        } else {
            return false;
        }
    }
    
    //获取短信队列记录信息
    function getSmsData($sms_id){
        $smsinfo=FqOrderSms::model()->findByPk($sms_id);
        return $smsinfo;
    }
    
    //获取订单信息
    function getOrderData($order_id){
        $orderObj=FqFenquanOrder::model()->findByPk($order_id);
        return $orderObj;
    }
    
    //获取用户表信息
    function getUcMemberData($customer_id){
        return UcMember::model()->findByPk($orderObj['customer_id']);
    }
    
    //获取最后一次修改的时间
    function getLastModifyTime($member_company_type,$borrow_id,$order_id){
        if(!in_array($member_company_type,array(1,2))){
            return "";
        }
        $sql="SELECT max(last_modified) as modifiytime FROM `{$table_name}` where borrow_id='".$borrow_id."' and member_id='".$order_id."'";
        $lasttime=Yii::app()->db->createCommand($sql)->query();
        return $lasttime;
    }
    
    //记录转移到已发送表 is_send>1|短信发送成功，2|系统跳过短信发送
    function saveSended($smsinfo,$is_Send='1'){
        $sended = new FqOrderSmsSended;
        $sended->sms_id=$smsinfo->sms_id;
        $sended->sms_mobile=$smsinfo->sms_mobile;
        $sended->sms_message=$smsinfo->sms_message;
        $sended->smstpl=$smsinfo->smstpl;
        $sended->pre_send_time=$smsinfo->pre_send_time;
        
        $sended->is_send=$is_Send;//状态直接跳过
        $sended->send_time=date("Y-m-d H:i:s",time());
        
        $sended->send_error_times=$smsinfo->send_error_times;
        $sended->order_id=$smsinfo->order_id;
        $sended->create_time=$smsinfo->create_time;
        $sended->last_modified=$smsinfo->last_modified;
        return $sended->save();
    }
    
    //转移短信
    function moveSMS($sms_id,$is_Send){
        $smsinfo=$this->getSmsData($sms_id);
        $res=$this->saveSended($smsinfo,$is_Send);
        if($res){
            $smsinfo->delete();
            return true;
        } else {
            return false;
        }
    }
    
    //启用错误次数发送邮件用于调试
    function setErrorTimes($sms_id){
        $smsinfo=$this->getSmsData($sms_id);
        $smsinfo->send_error_times=$smsinfo->send_error_times+1;
       
        if($smsinfo->save()){
            if($smsinfo->send_error_times==3){
                $this->sendEmail($smsinfo->smstpl,$sended->sms_message);
            }
            return true;
        } else {
            return false;
        }
        
    }
    
    //发送错误通知邮件用于调试
    function sendEmail($subject='',$body=''){
        //发送邮件通知
        $objMailer = new AresMailer();
        $objMailer->clearLayout(); //不使用layout
        $objMailer->setTo( "devxqsj@qianjins.com" );
        //$objMailer->setTo( "coderdyc@qianjins.com" );//用于测试
        $objMailer->setSubject( $subject );
        $objMailer->setBody($body);
        $sendemailresult=$objMailer->send();
    }
    
    
    function SaveLog($desc='',$info){
        AresLogManager::log_error(array('logKey' => self::ERROR_LOG_KEY, 'desc' => $desc, 'parameters' => $_REQUEST,'info'=>(array)$info));
        
    }
    
    /**
     * 短信发送队列
     */
    /*
    function actionSmsSend(){
        $objFqOrderSms = FqOrderSms::model()->findAll("is_send=0 and pre_send_time<=now()");
        $i = 0;
        if(empty($objFqOrderSms)){
            echo '完成了：'.$i.'个任务';exit;
        }
        foreach($objFqOrderSms as $sms){
            //到期前2天的短信 如果不需要发送则转储至已发送表(预售全款，预售借贷)
            if(in_array($sms['smstpl'],array('SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS','SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS'))){
                $orderObj=FqFenquanOrder::model()->findByPk($sms['order_id']);
                if($orderObj->order_status!=4){
                    //直接转储到已发送表
                    $smsinfo=FqOrderSms::model()->findByPk($sms->sms_id);
                    $sended = new FqOrderSmsSended;
                    $sended->sms_id=$smsinfo->sms_id;
                    $sended->sms_mobile=$smsinfo->sms_mobile;
                    $sended->sms_message=$smsinfo->sms_message;
                    $sended->smstpl=$smsinfo->smstpl;
                    $sended->pre_send_time=$smsinfo->pre_send_time;
    
                    $sended->is_send=2;//状态直接跳过
                    $sended->send_time=date("Y-m-d H:i:s",time());
    
                    $sended->send_error_times=$smsinfo->send_error_times;
                    $sended->order_id=$smsinfo->order_id;
                    $sended->create_time=$smsinfo->create_time;
                    $sended->last_modified=$smsinfo->last_modified;
                    $sended->save();
                    continue;
                }
            } elseif(in_array($sms['smstpl'],array('SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED'))){
                $orderObj=FqFenquanOrder::model()->findByPk($sms['order_id']);
                $userInfo=UcMember::model()->findByPk($orderObj['customer_id']);
                if($userInfo['member_company_type']==1){
                    $sql="SELECT max(last_modified) as modifiytime FROM `jd_member_data` where borrow_id='".$orderObj['borrow_id']."' and member_id='".$orderObj['customer_id']."'";
                    $lasttime=Yii::app()->db->createCommand($sql)->query();
    
                } elseif($userInfo['member_company_type']==2){
                    $sql="SELECT max(last_modified) as modifiytime FROM `jd_company_data` where borrow_id='".$orderObj['borrow_id']."' and member_id='".$orderObj['customer_id']."'";
                    $lasttime=Yii::app()->db->createCommand($sql)->query();
                }
                $days = Tools::getWeekdays($lasttime['modifiytime'], +7,"Y-m-d H:i:s");
                $beforedays=strtotime($days[6]);
                //7天后没有操作，且订单没有全款付款
                if($orderObj['order_status']==2 || time() < $beforedays) {
                    $smsinfo=FqOrderSms::model()->findByPk($sms->sms_id);
                    $sended = new FqOrderSmsSended;
                    $sended->sms_id=$smsinfo->sms_id;
                    $sended->sms_mobile=$smsinfo->sms_mobile;
                    $sended->sms_message=$smsinfo->sms_message;
                    $sended->smstpl=$smsinfo->smstpl;
                    $sended->pre_send_time=$smsinfo->pre_send_time;
    
                    $sended->is_send=2;//状态直接跳过
                    $sended->send_time=date("Y-m-d H:i:s",time());
    
                    $sended->send_error_times=$smsinfo->send_error_times;
                    $sended->order_id=$smsinfo->order_id;
                    $sended->create_time=$smsinfo->create_time;
                    $sended->last_modified=$smsinfo->last_modified;
                    $sended->save();
                    continue;
                    //转移短信
                }
    
            }
    
    
            $sendresult=SmsService::sendSMS($sms->sms_mobile, $sms->sms_message, 'send '.$sms->smstpl.' code');
            if($sendresult['returnstatus']['Success']){
                //更新订单短信发送状态
                $smsinfo=FqOrderSms::model()->findByPk($sms->sms_id);
                //$smsinfo->is_send=1;
                //$smsinfo->send_time=date("Y-m-d H:i:s",time());
                $sended = new FqOrderSmsSended;
    
                $sended->sms_id=$smsinfo->sms_id;
                $sended->sms_mobile=$smsinfo->sms_mobile;
                $sended->sms_message=$smsinfo->sms_message;
                $sended->smstpl=$smsinfo->smstpl;
                $sended->pre_send_time=$smsinfo->pre_send_time;
    
                $sended->is_send=1;
                $sended->send_time=date("Y-m-d H:i:s",time());
    
                $sended->send_error_times=$smsinfo->send_error_times;
                $sended->order_id=$smsinfo->order_id;
                $sended->create_time=$smsinfo->create_time;
                $sended->last_modified=$smsinfo->last_modified;
                $sended->save();
                $i++;
            } else {
                //邮件发送失败
                $smsinfo=FqOrderSms::model()->findByPk($sms->sms_id);
                $smsinfo->send_error_times=$smsinfo->send_error_times+1;
                $res=$smsinfo->save();
    
                if($smsinfo->send_error_times==3){
                    //发送邮件通知
                    $objMailer = new AresMailer();
                    $objMailer->clearLayout(); //不使用layout
                    $objMailer->setTo( "coderdyc@qianjins.com" );
                    $objMailer->setSubject( 'send '.$smsinfo->smstpl.' code' );
                    $objMailer->setBody( $smsinfo->sms_message );
                    $sendemailresult=$objMailer->send();
                }
            }
        }
        echo '完成了：'.$i.'个任务';exit;
    }
    */

}