<?php

class PosterUserMoneyController extends Controller
{

    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $model = new FhMoneyWithdrawModel;
        $mySearch = FhMoneyWithdrawModel::model()->mySearch2($_POST['poster']);
        //print_r($mySearch);exit;
        $listData =  $this->convertModelToArray($mySearch['list']);
        //$projectData = Project::model()->findAll();
        //$projectDatas= $this->convertModelToArray($projectData);
        $total = 0;
        $shNum = 0;
        $dkNum = 0;
        $num = 0;
        $money = 0;
        foreach($listData as $key=>$val){
            if($val['status'] == '1'){
                $shNum += 1;
            }
            if($val['status'] == '3'){
                $dkNum += 1;
            }
            if($val['status'] == '4'){
                $num += 1;
                $money += $val['withdraw_money'];
            }
            //$listData[$key]['haibao'] = array_unique($val['haibao']);
            $listData[$key]['_color'] = '';
            if ($val['withdraw_money']<$val['haibao']['withdraw_min'] || $val['withdraw_money']>$val['haibao']['withdraw_max']) {
                $listData[$key]['_color'] = '#E62';
            }
        }
        //print_r($listData);exit;
        $pages = $mySearch['pages'];
        $webToken = new WebToken;
        
        $arrRender = array(
            'pages' => $pages,
            'money' =>$money,
            'num' =>$num,
            'listData'=>$listData,
            'total' => $total,
            //'projectDatas' => $projectDatas,
            'time' => date("Y-m-d"),
            'project_id' => $_POST['poster']['project'],
            'status' => $_POST['poster']['status'],
            'is_jjr' => $_POST['poster']['is_jjr'],
            'project_id' => $_POST['poster']['project'],
            'member_mobile' => $_POST['poster']['member_mobile'],
            'nickname' => $_POST['poster']['nickname'],
            'shNum' => $shNum,
            'dkNum' => $dkNum,
            'j' => 1,
            'token' => $webToken->makeToken(),
        );
        $this->smartyRender('posterusermoney/index.tpl', $arrRender);
    }
    public function actionEditStatus(){//单条审核
        $token = $_GET['token'];
        $webToken = new WebToken;
        if (!$webToken->checkToken($token)) {
            $this->jsonError('服务器忙，请刷新后重试。');
        }

        //sleep(10);
        $flag = 0;
        $withdraw_id = isset($_GET['id'])?$_GET['id']:'';
        $haibao_id = isset($_GET['pid'])?$_GET['pid']:'';
        $money = isset($_GET['money'])?$_GET['money']:'';
        $member_id = isset($_GET['member_id'])?$_GET['member_id']:'';
        $status = isset($_GET['status'])?$_GET['status']:'';
        if($withdraw_id){
            //$updata = FhMoneyWithdrawModel::model()->updateByPk($withdraw_id,array('status'=>$status));
                if($status == '2'){
                    $desc = '提现状态变成  "审核不通过"';
                }elseif($status == '3'){
                    $desc = '提现状态变成  "已审核"';                    
                }elseif($status == '4'){
                    $desc = '提现状态变成  "已打款"';                    
                }
                $desc = '提现状态变成  "'.FhMoneyWithdrawModel::$ARR_STATUS[$status].'"';
                $ret = $this->InsertLog($withdraw_id,$haibao_id,$desc,$status,$money,$member_id);
                //$flag = 1;
            $this->jsonSuccess('提交'.$ret['allNum'].'个，'.FhMoneyWithdrawModel::$ARR_STATUS[$status].'成功'.$ret['successNum'].'个。');
        } else {
            $this->jsonError('提交失败，请稍后再试');
        }
        //echo json_encode($flag);
    }
    public function actionMoreEditStatus(){//批量审核、批量付款
        $token = $_POST['token'];
        $webToken = new WebToken;
        if (!$webToken->checkToken($token)) {
            $this->jsonError('服务器忙，请刷新后重试。');
        }
        //sleep(10);
        
        $flag = 0;//失败
        $withdraw_id = isset($_POST['id'])?$_POST['id']:'';
        $haibao_id = isset($_POST['pid'])?$_POST['pid']:'';
        $money = isset($_POST['money'])?$_POST['money']:'';
        $member_id = isset($_POST['member_id'])?$_POST['member_id']:'';
        $status = isset($_POST['status'])?$_POST['status']:'';
        if($withdraw_id){
            //$updata = FhMoneyWithdrawModel::model()->updateAll(array('status'=>$status),'id in('.$withdraw_id.')');
            if($status == '2'){
                $desc = '提现状态变成  "审核不通过"';
            }elseif($status == '3'){
                $desc = '提现状态变成  "已审核"';                    
            }elseif($status == '4'){
                $desc = '提现状态变成  "已打款"';                  
            }
            $desc = '提现状态变成  "'.FhMoneyWithdrawModel::$ARR_STATUS[$status].'"';
            $ret = $this->InsertLog($withdraw_id,$haibao_id,$desc,$status,$money,$member_id);
            //$flag = 1;//成功
            //echo json_encode($flag);
            $this->jsonSuccess('提交'.$ret['allNum'].'个，'.FhMoneyWithdrawModel::$ARR_STATUS[$status].'成功'.$ret['successNum'].'个。');
        } else {
            $this->jsonError('提交失败，请稍后再试');
        }
    }
    
    public function actionView($pageNo=1, $pageSize=10){
        $id = isset($_GET['id'])?$_GET['id']:'';
        $withdrawid = isset($_GET['withdrawid'])?$_GET['withdrawid']:'';
        $attributesArr = array();
        if($withdrawid != ''){   
            $haibaodata = FhMemberHaibaoModel::model()->findByPk($id);
            $haibaodatas= $this->convertModelToArray($haibaodata);
            $sql = ' AND withdraw_id = '.$withdrawid;
            $model = new FhPosterMoneyLogModel;
            $mySearch = $model->mySearch($sql);
            $listData =  $this->convertModelToArray($mySearch['list']);
            $pages = $mySearch['pages'];
            $model->attributes = $attributesArr;
            $arrRender = array(
                'listData'=>$listData,
                'pages' => $pages,
                'haibaodatas' => $haibaodatas,
            );
            $this->smartyRender('posterusermoney/view.tpl',$arrRender);
        }
    }
    /*
        
    */
    public function InsertLog($withdraw_id,$haibao_id,$desc,$status,$money,$member_id){
         //审核
        Yii::app()->getModule('points');
        $withdrawidarr = explode(',',$withdraw_id);
        $haibaoidarr = explode(',',$haibao_id);
        $moneyarr = explode(',',$money);
        $member_idarr = explode(',',$member_id);
        $successNum = 0;
        $allNum = count($withdrawidarr);
        foreach($withdrawidarr as $k=>$v){
            $data2 = array();
            $posterLog = new FhPosterMoneyLogModel;
            $data2['pid'] = (int)$haibaoidarr[$k];
            $data2['withdraw_id'] = (int)$v;
            $data2['username'] = $_SESSION['memberadmin__adminUser']['name'];
            $data2['userid'] = (int)$_SESSION['memberadmin__adminUser']['id'];
            $role = SysAdminUser::model()->with('role')->findByPk($data2['userid']);     
            $roles= $this->convertModelToArray($role);
            $data2['userflag'] = $roles['role'][0]['name'];
            $data2['desc'] = $desc;
            $data2['create_time'] = date("Y-m-d H:i:s");
            $data2['last_modified'] = date("Y-m-d H:i:s");
            $posterLog->attributes = $data2;            

            $key = $k;
            $val = $moneyarr[$key];
            if($status == '4'){//打款
                //foreach($moneyarr as $key=>$val){
                    $data3 = array();
                    $memberMoneyLog = new FhMemberMoneyHistoryModel;
                    $data3['eid'] = (int)$withdrawidarr[$key];
                    $data3['member_id'] = (int)$member_idarr[$key];
                    $data3['money'] = (double)$val;
                    $data3['type'] = 2;
                    $data3['remark'] = '提现';
                    $data3['create_time'] = date('Y-m-d H:i:s');
                    $data3['last_modified'] = date('Y-m-d H:i:s');
                    $memberMoneyLog->attributes = $data3;
                    //更新已提现金额
                    $trans = Yii::app()->db->beginTransaction();
                    try {
                        
                        $memberTotal = MemberTotalModel::model()->find('member_id=:mid', [':mid'=>$data3['member_id']]);
                        if ($memberTotal->money_total < $val*1.0) {
                            throw new CException('no enough money_total to withdraw: total='.$memberTotal->money_total.' withdraw_money='.$val);
                        }
                        
                        $withdrawModel = FhMoneyWithdrawModel::model()->findByPk($data2['withdraw_id']);
                        if ($withdrawModel->status == $status) {
                            throw new CException('withdraw already be '.$status);
                        }
                        FhMoneyWithdrawModel::model()->updateByPk($data2['withdraw_id'],array('status'=>$status,'remit_time'=>date('Y-m-d H:i:s')));
                        
                        $posterLog->save();
                        $memberMoneyLog->save();
                        // 微信支付 先更改本地数据库 再打款 
                        // 如果先打款 再更改本地数据库 那回滚的时候 已经打款的记录无法在微信服务器回滚
                        $update_data = FhMemberHaibaoModel::model()->updateByPk($haibaoidarr[$key],array(
                            'withdraw_money'=> new CDbExpression('withdraw_money+'.$val),
                        ));
                        $update_total= MemberTotalModel::model()->updateAll(array('money_withdraw'=> new CDbExpression('money_withdraw+'.$val),'money_total'=> new CDbExpression('money_total-'.$val)),'member_id='.$member_idarr[$key]);

                        // 暂时屏蔽打款
                        $this->sendRedPack($data3['member_id'], $val, ['eid'=>$data3['eid']]);
                        

                        $trans->commit();
                        Yii::log('withdraw pay money ok! mid='.$member_id.' money='.$val.' '.' '.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                        $ret = true;
                        $successNum++;
                    } catch (CException $e) {
                        $trans->rollback();
                        Yii::log('withdraw pay money error(mid='.$member_id.',money='.$val.'):'.$e->getMessage().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                    }
                //}
            } else {
                try {
                    
                    FhMoneyWithdrawModel::model()->updateByPk($data2['withdraw_id'],array('status'=>$status));
                    $ret = $posterLog->save();
                    $successNum++;
                } catch (CException $e) {
                    Yii::log('update withdraw error(mid='.$member_id.',money='.$val.'):'.$e->getMessage().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                }
            }
        }
        return ['successNum'=>$successNum, 'allNum'=>$allNum];
    }
    
    /*
        微信打款
        @param $member_id   用户id
        $param $money       金额,元
    */
    public function sendRedPack($member_id, $money, $options=[]) {
        $haibao = FhMemberHaibaoModel::model()->find('member_id=:mid', [':mid'=>$member_id]);
        if (empty($haibao)) {
            throw new CException('cannot find haibao! mid='.$member_id);
        }
        
        if ($money*100 < FanghuWechatRedpack::MIN_AMOUNT) {
            throw new CException('money too small:'.$money);
        }
        
        if ($money*100 > FanghuWechatRedpack::MAX_AMOUNT) {
            throw new CException('money too large:'.$money);
        }
        
        // 一个用户一天只能收一次红包
        $todayStart = date('Y-m-d 00:00:00', time());
        $redPackLog = FhRedpackLog::model()->find('member_id=:mid and create_time>=:todayStart', [':mid'=>$member_id, ':todayStart'=>$todayStart]);
        if (!empty($redPackLog)) {
            throw new CException('today already got redpack, cannot redo: mid='.$member_id);
        }
        
        //$options = [];
        $options['act_name'] = '吉林·鹿港小镇';
        $options['send_name'] = '吉林·鹿港小镇';
        $options['remwark'] = '逸乐通卡 4.6万（限时特惠）=全国度假+高收益。';
        $options['wishing'] = '逸乐通卡 4.6万（限时特惠）=全国度假+高收益。';
        $fhRedpack = new FanghuWechatRedpack($options);
        $billno = $fhRedpack->billno();
        //$openid = 'o2CgkuPI-QMsUSkWiNzbEirQt4RM';//
        $openid = $haibao->openid;
        Yii::log('prepare pay redpack:mid='.$member_id.' openid='.$openid.' money='.$money.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
        $ret = $fhRedpack->sendRedPack($openid, $money*100);
        //$ret = ['result_code'=>'SUCCESS','mch_id'=>1241495602];

        if ($ret['result_code'] == 'SUCCESS' && $fhRedpack->errCode == FanghuWechatRedpack::ERR_OK) {
            $redPackLog = new FhRedpackLog;
            $redPackLog->member_id      = $member_id;
            $redPackLog->openid         = $haibao->openid;
            $redPackLog->money          = $money;
            $redPackLog->oper_type      = FhRedpackLog::OPER_TYPE_WITHDRAW;
            $redPackLog->oper_id        = $options['eid'];
            $redPackLog->status         = 1;
            $redPackLog->merid          = $ret['mch_id'];
            $redPackLog->wx_billno      = $billno;
            $redPackLog->remark         = $options['remark'];
            $redPackLog->wx_res         = addslashes($fhRedpack->getResData());
            $redPackLog->post_data      = addslashes($fhRedpack->getPostData());
            $redPackLog->operator_id    = (int)$_SESSION['memberadmin__adminUser']['id'];
            $redPackLog->operator_name  = $_SESSION['memberadmin__adminUser']['name'];
            $redPackLog->create_time    = $redPackLog->last_modified = date('Y-m-d H:i:s');
            if (!$redPackLog->save()) {
                Yii::log('withdraw pay success but log error(mid='.$member_id.'):'.$redPackLog->lastError().' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                //throw new CException($redPackLog->lastError());
            }
        } else {
            throw new CException($fhRedpack->errMsg);
        }
        Yii::log('pay redpack SUCCESS:mid='.$member_id.' openid='.$openid.' money='.$money.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
        return $ret;
    }
}
