<?php
/**
 * 提现
 * dongjicheng@xqshijie.cn
 * //可提现剩余金额计算：累计最高提款金额（FhMemberHaibaoModel->withdraw_max） - 已提现金额 （FhMemberHaibaoModel->withdraw_money） - 已提申请的待审批、审批通过金额（FhMoneyWithdrawModel->withdraw_money）
 */
class WithdrawCashController extends BaseController {
    private $pointsModule;
	public function init() {
        parent::init();
        $this->checkLogin(Yii::app()->request->hostInfo.Yii::app()->request->url);
        $this->pointsModule = Yii::app()->getModule('points');
    }
    public function actionIndex(){     
        $fanghu_appid = 'wx829d7b12c00c4a97';
        $accounts_data= FhPosterAccountsModel::model()->find('appid=:appid',array(':appid'=>$fanghu_appid));
        $accounts_data= $this->convertModelToArray($accounts_data);
        Yii::app()->params['accounts_id'] = $accounts_data['id'];
        $member_id = Yii::app()->loginUser->getUserId();
        $posterData = FhMemberHaibaoModel::model()->findAll('member_id=:member_id and accounts_id=:accounts_id',array(':member_id'=>$member_id,':accounts_id'=>$accounts_data['id']));
        $memberTotal = $this->pointsModule->getMemberTotalModel($member_id);
        $posterDatas= $this->convertModelToArray($posterData);  
        //$poster_cash = $posterDatas[0]['withdraw_max'] - $posterDatas[0]['withdraw_money'];
        $withdraw_data = FhMoneyWithdrawModel::model()->findBySql("select sum(withdraw_money) as withdraw_money from fh_money_withdraw where member_id =".$member_id." and accounts_id =".$accounts_data['id']." and status in(1,3)");
        $withdraw_cash = $this->convertModelToArray($withdraw_data);
        //剩余提现金额
        $last_cash = $memberTotal->money_total - $withdraw_cash['withdraw_money'];

        $webToken = new WebToken;
        $token = $webToken->makeToken();
        
        $arrRender = array(
            'gShowFooter' => true,
            'logout_return_url' => $this->createAbsoluteUrl("withdrawcash/index"),
            'pageTitle' => '我的提现',
            'last_cash' => $last_cash,
            'project_id'=> $posterDatas[0]['project_id'],
            'withdraw_min' => $posterDatas[0]['withdraw_min'],
            'token' => $token,
        );
		$this->layout = "layouts/myhaibao_myreward.tpl";
        $this->smartyRender('withdrawcash/index.tpl',$arrRender);
    }
    
    public function actionGetCash(){
        $member_id = Yii::app()->loginUser->getUserId();
        $accounts_id = Yii::app()->params['accounts_id'];
        $token = $_GET['token'];
        $webToken = new WebToken;
        if (!$webToken->checkToken($token)) {
            $this->jsonError('服务器忙，请刷新页面后再试。');
        }
        
        $cash = isset($_GET['cash']) ?(double)$_GET['cash']:0;
        //$cash = $cash * 1.0 < 0 ? 0 : $cash;
        
        // 判断是不是临时用户
        $memberModel = UcMember::model()->findByPk($member_id);
        if (empty($memberModel->member_mobile)) {
            $this->jsonError('您没有绑定手机号，还不能提现，请退出重新登录。');
        }

        $memberHaibao = FhMemberHaibaoModel::model()->with('poster')->find('t.member_id=:member_id and t.accounts_id=:accounts_id',array(':member_id'=>$member_id,':accounts_id'=>$accounts_id));
        $memberTotal  = MemberTotalModel::model()->find('member_id=:member_id and accounts_id=:accounts_id',array(':member_id'=>$member_id,':accounts_id'=>$accounts_id));
        $flag = false;
        $project_id = isset($_GET['project_id']) ?(int)$_GET['project_id']:0;
        

        
        $remainCash = $this->getRemainCash($member_id, $memberTotal->money_total);
        if ($cash*1.0<=0) {
            $this->jsonError('最低提现额'.$memberHaibao->withdraw_min.'元', ['token'=>$webToken->getToken()]);
        }

        if ($remainCash < $cash) {
            $this->jsonError('最高金额是'.$remainCash.'元，请输入有效金额', ['token'=>$webToken->getToken()]);
        }
        if ($cash < $memberHaibao->withdraw_min) {
            $this->jsonError('最低提现额'.$memberHaibao->withdraw_min.'元', ['token'=>$webToken->getToken()]);
        }
        
        if ($memberHaibao->withdraw_min<1.0) {
            $this->jsonError('最低提现额1.0' .'元', ['token'=>$webToken->getToken()]);
        }
        
        $model = new FhMoneyWithdrawModel;
        $model->accounts_id = $accounts_id;
        $model->member_id = $member_id;
        $model->project_id= $memberHaibao->poster->project_id;
        $model->withdraw_money = $cash;
        $model->status = 1;
        $model->remit_time = '';
        $model->create_time = date('Y-m-d H:i:s');
        $model->last_modified = date('Y-m-d H:i:s');
        if($model->save()){
            $flag = true;
        }

        if ($flag) {
            $this->jsonSuccess('提现申请成功', ['last_cash'=>$remainCash,'token'=>$webToken->getToken()]);
        } else {
            $this->jsonError('服务器忙，请稍后再试。');
        }
        //echo json_encode($flag);
    }
    /*
        获取可提现金额
    */
    public function getRemainCash($member_id, $total) {
        $accounts_id = Yii::app()->params['accounts_id'] ? Yii::app()->params['accounts_id'] : 1;
        $withdraw_data = FhMoneyWithdrawModel::model()->findBySql("select sum(withdraw_money) as withdraw_money from fh_money_withdraw where member_id =".$member_id." and accounts_id =".$accounts_id." and status in(1,3)");
        $withdraw_cash = $this->convertModelToArray($withdraw_data);
        //剩余提现金额
        $last_cash = $total - $withdraw_cash['withdraw_money'];
        return $last_cash;
    }
    //提现记录
    public function actionRecord(){
        $accounts_id = Yii::app()->params['accounts_id'];
        $member_id = Yii::app()->loginUser->getUserId();
        $data = FhMoneyWithdrawModel::model()->findAll('member_id=:member_id and accounts_id=:accounts_id',array(':member_id'=>$member_id,':accounts_id'=>$accounts_id));
        $recordData = $this->convertModelToArray($data);
        foreach($recordData as $k=>$v){
            $recordData[$k]['last_modified'] = substr($v['last_modified'],0,16);
        }
        $arrRender = array(
            'pageTitle' => '提现记录',
            'datas' => $recordData,
            'pageTitle' => '提现记录',
        );
		$this->layout = "layouts/myhaibao_myreward.tpl";
        $this->smartyRender('withdrawcash/record.tpl',$arrRender);
    }
}
