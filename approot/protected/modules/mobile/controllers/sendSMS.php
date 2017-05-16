<?php
//https://itest.xqshijie.com/xqsjadmin.php?r=virtualCurrency/default

Yii::import("application.common.service.SmsManager");
Yii::import("application.common.extensions.AresUtil");
Yii::import("application.common.extensions.AresLogManager");
Yii::import("application.common.service.SmsService");
class sendSMS extends BaseSendSMS
{
    public function __construct(){
        //echo "test";exit;
    }
    /**
     * 发送短信通用接口 支付预购全款首付款
     * @param unknown $phone 手机号
     * @param array $params 短信参数
     * @param unknown $smstpl 发送短信的模板变量名称
     * @param string $zoneCode
     * @return Ambigous <multitype:string , multitype:string returnstatus >
     */
    public function sendFqOrderSMSCode($phone, $params,$smstpl,$sendtime='', $zoneCode = '86'){
        //订单过期问题 跳过部分发送短信的接口
        $notSendArr=array(
            'SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS',
            'SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS',
            'SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED'
        );
        if(in_array($smstpl,$notSendArr)){
            return true;
        }
        
        $content=$this->getContent($smstpl,$params);//生成短信内容
        $result=$this->addSmsQueue($phone, $content,$params['order_id'],$smstpl,$sendtime, $zoneCode);
        if(!$result){
            $this->saveLog('addSmsQueue error',array($phone, $content,$params['order_id'],$smstpl,$sendtime, $zoneCode));
            //记录日志
        }
        return $result;
    }
    
    /******************************短信发送函数***********************************/
    
    
    /**
     * 短信发送队列
     */
    public function sendTask(){
        $objFqOrderSms = FqOrderSms::model()->findAll("is_send=0 and pre_send_time<=now()");
        $i = 0;
        if(empty($objFqOrderSms)){
            echo '完成了：'.$i.'个任务';exit;
        }
        foreach($objFqOrderSms as $sms){
            //到期前2天的短信 如果不需要发送则转储至已发送表(预售全款，预售借贷)
            if(in_array($sms['smstpl'],array('SMS_TPL_FQORDER_YUSHOU_QUANKUAN_REMAIN_TWODAYS','SMS_TPL_FQORDER_YUSHOU_JIEDAI_REMAIN_TWODAYS'))){
                
                $orderObj=$this->getOrderData($sms['order_id']);//获取订单信息
                if($orderObj->order_status!=4){
                    //直接转储到已发送表
                    $result=$this->moveSMS($sms->sms_id,2);
                    if(!$result){
                        $this->saveLog('sendSMS move error',$sms);
                        //转移失败记录日志
                    }
                    continue;
                }
            } elseif(in_array($sms['smstpl'],array('SMS_TPL_FQORDER_YUSHOU_JIEDAI_SEVENDAYS_FAILED'))){
                //预售借贷7天未有任何操作 期间有操作时的处理
                $orderObj=$this->getOrderData($sms['order_id']);//获取订单信息
                $userInfo=$this->getUcMemberData($orderObj['customer_id']);//获取用户信息                
                $lasttime=$this->getLastModifyTime($userInfo['member_company_type'],$orderObj['borrow_id'],$orderObj['customer_id']);
                $days = Tools::getWeekdays($lasttime['modifiytime'], +7,"Y-m-d H:i:s");
                $beforedays=strtotime($days[6]);
                //7天内已操作或者订单已经完成，则跳过发送短信
                if($orderObj['order_status']==2 || time() < $beforedays) {
                    $result=$this->moveSMS($sms->sms_id,2);
                    if(!$result){
                        $this->saveLog('sendSMS move error',$sms);
                        //转移失败记录日志
                    }
                    continue;
                }
            }
    
            //开始发送短信
            $sendresult=SmsService::sendSMS($sms->sms_mobile, $sms->sms_message, 'send '.$sms->smstpl.' code');
            if($sendresult['returnstatus']=='Success'){
                //更新订单短信发送状态
                $result=$this->moveSMS($sms->sms_id,1);
                if(!$result){
                    $this->saveLog('sendSMS move error',$sms);
                    //转移失败记录日志
                }
                $i++;
            } else {
                $this->saveLog('sendSMS error',$sendresult);
                //记录错误日志
                
                /*
                 * 测试用
                $res=$this->setErrorTimes($sms->sms_id);//超过3次则自动发送邮件
                */
            }
        }
        echo '完成了：'.$i.'个任务';exit;
    }

}