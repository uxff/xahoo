<?php
/**
* 房否相关自动脚本
* dengran@qianjins.com
* 2015-11-03
*/
class FforderCommand  extends CConsoleCommand 
{
    
    
    /**
    * 同步订单队列 
    * 
    * @param mixed $args
    */
    public function actionQueue($args)
    {   
       
       $loginfo = array();
       $loginfo['action']   = __METHOD__;    
           
       $apiModule = Yii::app()->getModule('api');
       $result = $apiModule->FangfullApi(array())->queue();
       $this->log($loginfo,$result);
    }
    
    
    /**
    * 重试504等http错误订单
    * 
    * @param mixed $args
    */
    public function actionRetryOrder($args)
    {   
        $loginfo = array();
        $loginfo['action']   = __METHOD__;
                       
        $apiModule = Yii::app()->getModule('api');
        $result = $apiModule->FangfullApi(array())->retryOrder();
        $this->log($loginfo,$result);
    }
    
    
    
    /**
    * 自动取消定金支付超时订单
    * 
    * @param mixed $args
    */
    public function actionPayTimeOut($args){
       
        $loginfo = array();
        $loginfo['action']   = __METHOD__;
        
        $apiModule   = Yii::app()->getModule('api');
       // $OredrModule = Yii::app()->getModule('order');

        //当前执行脚本时候的时间
        $currentTime = time();
        //订单支付超时时间
        $overTime = 3600 * 1;// 1小时
        //进行比较的时间
        $compareTime = $currentTime - $overTime;
       // $models = array('FqFenquanOrder','zcOrder','lcOrder');
        $models = array('FqFenquanOrder');
        $i = 0;
        foreach ($models as $model) {
            $array = array(
                'condition'=>' UNIX_TIMESTAMP(create_time)<'.$compareTime.' AND order_status=1 AND status=1 ',
                'limit'=>6,
            );
            $Orders = FqFenquanOrder::model()->findAll($array); 
            if(empty($Orders)){
               continue; 
            } 
            foreach($Orders as $order){
                $order->order_status = 101;
                if(!$order->save()){
                    conitune;
                }
                
                $arrParmas = array(
                    'order_id' => $order->order_id,
                    'status' => 5,
                );
                $result = $apiModule->FangfullApi($arrParmas)->synOrder();
                if($result){
                    $i ++;
                }
           }
        }
        
        //@todo补库存
        
        
        $this->log($loginfo,$i);
        
    }
    
    /**
    * 自动取消订单
    * 7天未提交个人审核资料
    * 
    * @param mixed $args
    */
    public function actionVerifyTimeOut($args){
        $loginfo = array();
        $loginfo['action']   = __METHOD__;
        
        $apiModule   = Yii::app()->getModule('api');
      //  $OredrModule = Yii::app()->getModule('order');
        
        //当前执行脚本时候的时间
        $currentTime = time();
        //订单支付超时时间
        $overTime = 86400 * 7;
        //进行比较的时间
        //$compareTime = $currentTime - $overTime;

        $days = Tools::getWeekdays(date('Y-m-d'), -7);
        $compareTime = $days[count($days)-1]. ' 23:59:59';
                  
        
        
        $i = 0;
   /*     $criteria = new CDbCriteria();
        $criteria->select = 't.order_id, J.*,J.last_modified,C.last_modified,C.* ';
        $criteria->addCondition('UNIX_TIMESTAMP(t.last_modified)< '.$compareTime);
        $criteria->addSearchCondition('t.order_type',1);
        $criteria->addSearchCondition('t.status',1);
        $criteria->addSearchCondition('t.order_status',4);
        $criteria->join    = 'LEFT JOIN jd_member_data as J ON t.customer_id=J.member_id LEFT JOIN jd_company_data as C ON t.customer_id=C.member_id ';
        $criteria->group   = 't.order_id';
        $Orders = FqFenquanOrder::model()->with('jd_member','jd_company')->findAll($criteria); 
   */     
        $sql = "
                select t.*,C.id AS cid ,M.id as mid ,C.last_modified as ctime,M.last_modified as mtime
                FROM fq_fenquan_order t
                LEFT JOIN jd_member_data as M ON t.customer_id=M.member_id 
                LEFT JOIN jd_company_data as C ON t.customer_id=C.member_id
                WHERE (t.last_modified)< '$compareTime'
                AND  t.order_type=1
                AND  t.status=1
                AND  t.order_status=4
                GROUP by t.order_id
        ";
        
        
        $Orders = Yii::app()->db->createCommand($sql)->query();

        if(empty($Orders)){
           $this->log($loginfo,$i);
           exit; 
        } 
        
        foreach($Orders as $order){
            if( isset($order['cid'] ) && ( time() - strtotime($order['ctime']) <=86400 )   ){ 
                continue;
            }
            
            if( isset($order['mid'] ) && ( time() - strtotime($order['mtime']) <=86400 )   ){ 
                continue;
            }
            
            $orderObj = FqFenquanOrder::model()->findByPk($order['order_id']);
            if(empty($orderObj)){
                continue;
            }
            $orderObj->order_status = 101;
            if(!$orderObj->save()){
                conitune;
            }
             
            $arrParmas = array(
                'order_id' => $order['order_id'],
                'status' => 5,
            );
            $result = $apiModule->FangfullApi($arrParmas)->synOrder();
            if($result){
                $i ++;
            }
       }
       
       $this->log($loginfo,$i);
    }
    
    
    /**
    * 自动取消订单
    * 7天未付尾款
    * 
    * @param mixed $args
    */
    public function actionDepositTimeOut($args){
        $loginfo = array();
        $loginfo['action']   = __METHOD__;
        
        $apiModule   = Yii::app()->getModule('api');
       // $OredrModule = Yii::app()->getModule('order');
        
        //当前执行脚本时候的时间
        $currentTime = time();
        //订单支付超时时间
        $overTime = 86400 * 7;
        //进行比较的时间
        $compareTime = $currentTime - $overTime;
        
        $days = Tools::getWeekdays(date('Y-m-d'), -7);
        $compareTime = $days[count($days)-1]. ' 23:59:59';
        
        $i = 0;
       
        $Orders = FqFenquanOrder::model()->findAll('(create_time)<"'.$compareTime.'" AND order_status=4 AND status=1 AND order_type=1'); 
        if(empty($Orders)){
           $this->log($loginfo,$i);
           exit; 
        } 
        foreach($Orders as $order){
            $order->order_status = 101;
            if(!$order->save()){
                conitune;
            }
         
            $arrParmas = array(
                'order_id' => $order->order_id,
                'status' => 5,
            );
            $result = $apiModule->FangfullApi($arrParmas)->synOrder();
            if($result){
                $i ++;
            }
       }
       
       $this->log($loginfo,$i);
    }
    
    //记录库存修改日志
    public function log($data,$i) {
        $data['time']   = date('Y-m-d H:i:s');
        $data['result'] = '完成了 '.$i.' 个任务';
        AresLogManager::log(json_encode($data),3,'commands.log',1);
        echo $data['result'];
    }
    
    
    /**
    *  重复101状态订单
    * 
    * @param mixed $args
    */
    public function actionRetry101($args){
       
        $loginfo = array();
        $loginfo['action']   = __METHOD__;
        
        $i = 0;
        
        $ids = array(157,159,162,164,175,176,177,179,181,186,187,190,192,207,208,209,210,212,213,214,215,217,219,220,221,227,229,230,231,235,236,237,238,239,240,241,242,243,245,248,249,251,253,254,255,258,259,262,264,266,268,271,272,274,275,279,280,281,282,283,284,286,139,145,146,158,160,161,163,165,166,167,172,173,178,183,185,189,194,196,211,216,223,288,127,128,129,131,132,134,292,290,295,296,297,304,311,312,319,326,327,328,329,330,331,332,333,335,338,342,347,353,357,358,361,362,367,368,369,371,373,374);
        
     /*   $ids = implode(',',$ids);
        
        $sql = "select * from fq_fenquan_order where order_id in ($ids)";
       
        $datas = Yii::app()->db->createCommand($sql)->query();
      */ 
      
        foreach($ids as $order_id){ 
            $arrParmas = array(
                'order_id' => $order_id,
                'status' => 5,
            );
            $apiModule   = Yii::app()->getModule('api');
            $result = $apiModule->FangfullApi($arrParmas)->synOrder();
            
            if($result){
                $i ++;
            }
       }
       $this->log($loginfo,$i);
    }
    
    
    


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
    

    
    public function actionCharge(){
    
        $chargeObj=UcMemberVirtualcurrencyChargelist::model()->with('order')->findAll("audit_status=2 and charge_status=0 and now()>=charge_time");
        //(array)$chargeObj = $this->convertModelToArray($chargeObj);

        $i = 0;
        if(empty($chargeObj)){
            echo '完成了：'.$i.'个任务';exit;
        }
        $charge_time=date("Y-m-d H:i:s",time());
        foreach($chargeObj as $item){
            $Module = Yii::app()->getModule('virtualCurrency');
            $arr=array(
                "customer_id"=>$item['customer_id'],
                "acount_type"=>"1",//业主新奇币
                "chargelist_id"=>$item['id'],
                "order_id"=>$item['order_id'],
                "project_name"=>$item['order']['item_name'],
                "change_reason"=>"1",//业主新奇币充值
                "money"=>$item['charge_money'],
                "remarks"=>date("Y年m月",strtotime($item['proceeds_date']))."固定收益"
            );
            
            extract($arr);
            $result = $Module->chargeHistory()->store($customer_id,$acount_type,$chargelist_id,$order_id,$project_name,$change_reason,$money,$remarks);
            
            if($result){
                $arr['charge_time']=$charge_time;
                $arr['proceeds_date']=$item['proceeds_date'];
                $Module->charge()->chargeStatusUpdate($arr);
                $i++;
            } else {
                AresLogManager::log_error(array('logKey' => '[charge][charge]', 'desc' => 'charge error', 'parameters' => $_REQUEST,'info'=>$arr));
            }
        }
        echo '完成了：'.$i.'个任务';exit;
    }
    
    
    
    
}