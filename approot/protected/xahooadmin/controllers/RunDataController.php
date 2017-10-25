<?php
/**
 * User: coderdjc@xqshijie.cn
 * Date: 2016-09-05
 */


class RunDataController extends Controller{

    public function actionIndex(){
        echo 'aaa';
    }
    
    public function actionUpdateStatus(){//批量审核、批量付款
        $flag = 'false';//失败
        
        $withdraw_id = '1383,1444,1453,1652,1954,1985,2012';
        $haibao_id = '277,403,1594,36224,53340,54050';
        $money = '3.95,3.85,5.3,16.1,3,10,6.5';
        $member_id = '66390,69710,8268,5426,7188,42355,42355';
        
        
        
        $status = isset($_GET['status'])?$_GET['status']:'';
        if($withdraw_id){
            $updata = FhMoneyWithdrawModel::model()->updateAll(array('status'=>$status),'id in('.$withdraw_id.')');
            if($updata){
                if($status == '3'){
                    $desc = '提现状态变成  "已审核"';                    
                }elseif($status == '4'){
                    $desc = '提现状态变成  "已打款"';                  
                }
                $Insert = $this->InsertLog($withdraw_id,$haibao_id,$desc,$status,$money,$member_id);
                $flag = 'true';//成功
            }
        }
        echo json_encode($flag);
    }
    public function InsertLog($withdraw_id,$haibao_id,$desc,$status,$money,$member_id){
         //审核
        $withdrawidarr = explode(',',$withdraw_id);
        $haibaoidarr = explode(',',$haibao_id);
        $moneyarr = explode(',',$money);
        $member_idarr = explode(',',$member_id);
        foreach($withdrawidarr as $k=>$v){
            $data2 = array();
            $modell = new FhPosterMoneyLogModel;
            $data2['pid'] = (int)$haibaoidarr[$k];
            $data2['withdraw_id'] = (int)$v;
            $data2['username'] = 'administrator';
            $data2['userid'] = 999999;
            $data2['userflag'] = 'administrator';
            $data2['desc'] = $desc;
            $data2['create_time'] = date("Y-m-d H:i:s");
            $data2['last_modified'] = date("Y-m-d H:i:s");
            $modell->attributes = $data2;            
            $modell->save();
        }  
        if($status == '4'){//打款
            foreach($moneyarr as $key=>$val){
                $data3 = array();
                $model = new FhMemberMoneyHistoryModel;
                $data3['eid'] = (int)$withdrawidarr[$key];
                $data3['member_id'] = (int)$member_idarr[$key];
                $data3['money'] = (double)$val;
                $data3['type'] = 2;
                $data3['remark'] = '提现';
                $data3['create_time'] = date('Y-m-d H:i:s');
                $data3['last_modified'] = date('Y-m-d H:i:s');
                $model->attributes = $data3;
                if($model->save()){
                    //更新已提现金额
                    $update_data = FhMemberHaibaoModel::model()->updateByPk($haibaoidarr[$key],array(
                        'withdraw_money'=> new CDbExpression('withdraw_money+'.$val),
                    ));
                    $total_model=  Yii::app()->getModule('points');
                    $update_total= MemberTotalModel::model()->updateAll(array('money_withdraw'=> new CDbExpression('money_withdraw+'.$val),'money_total'=> new CDbExpression('money_total-'.$val)),'member_id='.$member_idarr[$key]);
                }               
            }
        }
        
    }
} 