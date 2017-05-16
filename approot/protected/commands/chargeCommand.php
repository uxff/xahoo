<?php
/**
* 房否相关自动脚本
* dingyucong@qianjins.com
* 2015-12-23
*/
class chargeCommand  extends CConsoleCommand 
{
     


    /**
     * 订单支付7个工作日到期前2天自动发送短信 未加crontab处理
     */
    /*
    public function actionPayAllTimeOut(){
        //借贷的短信发送
        
        //当前执行脚本时候的时间
        $currentTime = time();
        $currentFormatTime=date("Y-m-d H:i:s",$currentTime);
        
        $i = 0;

        //$criteria = new CDbCriteria() ;
        //$criteria->select = 't.order_type,t.create_time,t.cusomter_phone,t.cusomter_name,t.customer_id,smsstatus.yugou_quankuan_firstpayok,smsstatus.id';
        //$criteria->join = "LEFT JOIN fq_order_sms_status as smsstatus On t.order_id=smsstatus.order_id";
        //$criteria -> condition = 't.order_status=4 and smsstatus.order_id = 371';
        //$result = FqFenquanOrder::model()->findAll($criteria);
        //var_dump($result);exit;
        
        //$Orders = FqFenquanOrder::model()->with('house','smsstatus')->findAll('t.order_status=4');
        
        $sql="select t.order_id,t.order_type,t.create_time,t.cusomter_phone,t.cusomter_name,t.customer_id,house.advance_start_time,house.advance_end_time,house.start_time,house.end_time from Fq_fenquan_order as t 
            LEFT JOIN fq_order_sms_status as smsstatus On t.order_id=smsstatus.order_id 
            LEFT JOIN fq_house as house On t.item_id=house.house_id
            where t.order_status=4 and (smsstatus.yugou_jiedai_remain_twodays=0 || smsstatus.yushou_quankuan_remain_twodays=0 ||smsstatus.yushou_jiedai_remain_twodays=0)";// 
        $Orders = Yii::app()->db->createCommand($sql)->query();//queryRow();获取一行的字段 queryAll();获取所有行
        if(empty($Orders)){
            echo '完成了：'.$i.'个任务';
            exit;
        }

        foreach($Orders as $order){
            $sendSmsResult="";
            $smstpl="";
            $ordertime=strtotime($order['create_time']);
            if(strtotime($order['advance_start_time'])<$ordertime && $ordertime < strtotime($order['advance_end_time'])){
                //借贷无预售证下的订单
                $certificate=1;
                if($order['order_type']==1){
                    //全款无预售证的订单 不用发送短信
                } elseif($order['order_type']==2){
                    $smstpl='SMS_TPL_FQORDER_YUGOU_JIEDAI_REMAIN_TWODAYS';//借贷无预售证下的订单
                }
                
            } elseif(strtotime($order['start_time'])<$currentTime && $currentTime < strtotime($order['end_time'])){
                //借贷有预售证下的订单
                $certificate=2;
                if($order['order_type']==1){
                    $smstpl='SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS';//全款有预售证下的订单
                } elseif($order['order_type']==2){
                    $smstpl='SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS';//借贷有预售证下的订单
                }
            }

            if($smstpl){
                $days = Tools::getWeekdays($order['create_time'], +7,"Y-m-d H:i:s");
                $beforedays=strtotime($days[6])-86400*2;//到期5天前
                if($order['order_type']==2 && $currentTime>strtotime($days[6])){
                    $smstpl='SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED';
                }elseif($currentTime>$beforedays){
                    if(!$order['cusomter_phone']){
                        $customerProfile = UCenterStatic::getUserProfile($order['customer_id']);
                        $order['cusomter_phone']=$customerProfile['userProfile']['member_mobile'];
                        //
                    }
                    if(!$order['cusomter_name']){
                        !$customerProfile && $customerProfile = UCenterStatic::getUserProfile($order['customer_id']);
                        $order['cusomter_name']=$customerProfile['userProfile']['member_fullname'];
                    }
    
                    //发送短信，记录短信记录
                    
                    $smsParams = array(
                        'user_name' => $order['cusomter_name'],
                        'project_name' => $order['item_name'],
                    );
                    
                    $sendSmsResult = SmsService::sendFqOrderSMSCode($order['cusomter_phone'],$smsParams,$smstpl);
                    //全款订单借贷
                    
                    if($sendSmsResult['returnstatus']=='success'){
                        $i ++;
                    }
                }

            }
        }
        echo '完成了：'.$i.'个任务';
    }
    */
    
    /**
     * 短信发送队列
     */
    function actionSmsSend($args){
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
                
                
                /*
                //短信模板对应数据库字段，中文说明看SmsService.php
                $tplarr=array(
                    'SMS_TPL_FQORDER_YUGOU_QUANKUAN_FIRSTPAYOK'=>'yugou_quankuan_firstpayok',
                
                    'SMS_TPL_FQORDER_YUGOU_JIEDAI_FIRSTPAYOK'=>'yugou_jiedai_firstpayok',
                    'SMS_TPL_FQORDER_YUGOU_JIEDAI_REMAIN_TWODAYS'=>'yugou_jiedai_remain_twodays',
                    'SMS_TPL_FQORDER_YUGOU_JIEDAI_DATAOK'=>'yugou_jiedai_dataok',
                
                    'SMS_TPL_FQORDER_YUSHOU_QUANKUAN_FIRSTPAYOK'=>'yushou_quankuan_firstpayok',
                    'SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS'=>'yushou_quankuan_remain_twodays',
                    'SMS_TPL_FQORDER_YUSHOU_QUANKUAN_PAYOK'=>'yushou_quankuan_payok',
                    'SMS_TPL_FQORDER_YUSHOU_QUANKUAN_HETONGOK'=>'yushou_quankuan_hetongok',
                
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_FIRSTPAYOK'=>'yushou_jiedai_firstpayok',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS'=>'yushou_jiedai_remain_twodays',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATASUBMITOK'=>'yushou_jiedai_datasubmitok',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAOK'=>'yushou_jiedai_dataok',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAFAIL_QIANJINS'=>'yushou_jiedai_datafail_qianjins',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_DATAFAIL_XQSHIJIE'=>'yushou_jiedai_datafail_xqshijie',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED'=>'yushou_jiedai_sevendays_failed',
                    'SMS_TPL_FQORDER_YUSHOU_JIEDAI_HETONGOK'=>'yushou_jiedai_hetongok'
                );
                //更新订单短信事件发送状态
                $objFqOrderSmsStatus=FqOrderSmsStatus::model()->find("order_id='".$smsinfo->order_id."'");
                if(empty($objFqOrderSmsStatus)){
                    $objFqOrderSmsStatus = new FqOrderSmsStatus();
                }
                $objFqOrderSmsStatus->order_id=$smsinfo->order_id;
                $objFqOrderSmsStatus->$tplarr[trim($smsinfo->smstpl)]=$smsinfo->sms_id;
                $objFqOrderSmsStatus->save();
                $smsinfo->delete();
                */
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
                    $objMailer->setTo( "dingyucong@qianjins.com" );
                    $objMailer->setSubject( 'send '.$smsinfo->smstpl.' code' );
                    $objMailer->setBody( $smsinfo->sms_message );
                    $sendemailresult=$objMailer->send();
                }
            }
        }
        echo '完成了：'.$i.'个任务';exit;
    }
    
    //D:\htdocs\xqshijie\main\protected\commands>D:\wamp\bin\php\php5.5.1\php console.php charge Charge
    public function actionCharge($args){
        $Module = Yii::app()->getModule('virtualCurrency');
        $Module->charge()->chargeTask();
    }
    
    
    
    
}