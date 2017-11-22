<?php

class MyHaibaoController extends BaseController{
    protected $mpid;

	public function init() {
        parent::init();
        $this->checkLogin(Yii::app()->request->hostInfo.Yii::app()->request->url);
        Yii::app()->getModule('points');
        $this->mpid = $_SESSION[Yii::app()->params['third_login_sess_name']]['mpid'] ? : 1;
    }
	/**
	 * [actionMyReward description] 我的奖励首页
	 * @return [type] [description]
	 */
	public function actionMyReward(){
		$member_id 	= Yii::app()->loginUser->getUserId();
        $totalModel = $this->convertModelToArray(FhMemberHaibaoModel::model()->with('total')->find('t.member_id=:member_id and t.accounts_id=:accounts_id', [':member_id'=>$member_id,':accounts_id'=>$this->mpid]));

        $last_cash = $this->getRemainCash($member_id, $totalModel['total']['money_total'],$this->mpid);
        $renderData = array(
            'pageTitle' => '我的奖励',
        	'data' => $totalModel,
            'last_cash' => $last_cash < 0 ? 0 : $last_cash,
    	);
		$this->layout = "layouts/myhaibao_myreward.tpl";
		$this->smartyRender("myhaibao/myreward.tpl",$renderData);
	}
    /*
        获取可提现金额
    */
    public function getRemainCash($member_id, $total) {
        $withdraw_data = FhMoneyWithdrawModel::model()->findBySql("select sum(withdraw_money) as withdraw_money from fh_money_withdraw where member_id =".$member_id." and accounts_id =".$this->mpid." and status in(1,3)");
        $withdraw_cash = $this->convertModelToArray($withdraw_data);
        //剩余提现金额
        $last_cash = $total - $withdraw_cash['withdraw_money'];
        return $last_cash;
    }
	/**
	 * [actionRewardRecord description] 奖励记录
	 * @return [type] [description]
	 */
	public function actionRewardRecord(){
		$model 	= new FhMemberMoneyHistoryModel;
		$model->unsetAttributes(); 
		# 查询以会员ID和金额操作类型为条件查询 
		$condition['member_id']   = Yii::app()->loginUser->getUserId();
		$condition['accounts_id'] = Yii::app()->params['accounts_id'];
		$condition['type'] 		  = $model::TYPE_REWARD;
		# 在model文件中获取查询数据 
		$data 		= $model->mySearch2($condition);
		$list_data 	= $this->convertModelToArray($data['list']);
		# 时间处理 截取16位
		foreach ($list_data as $lk => $lv) {
			if(!empty($list_data[$lk]['create_time'])){
				$list_data[$lk]['create_time'] = substr($lv['create_time'],0,16);
			}
		}
		# 输出视图
		$renderData = array(
            'pageTitle' => '奖励记录',
			'listData' => $list_data
		);
		$this->layout = "layouts/myhaibao_myreward.tpl";
		$this->smartyRender("myhaibao/reward_record.tpl",$renderData);
	}
	/**
	 * [actionActivityRule description] 活动规则
	 * @return [type] [description]
	 */
	public function actionActivityRule(){
		// 获取当前有效海报背景图
		$member_id = Yii::app()->loginUser->getUserId();
        $posterModel =$this->convertModelToArray(FhMemberHaibaoModel::model()->with('poster')->find('member_id=:member_id and t.accounts_id=:accounts_id', [':member_id'=>$member_id,':accounts_id'=>$this->mpid]));
        $renderData = array(
            'pageTitle' => '活动规则',
			'posterModel' => $posterModel
		);
		$this->layout = "layouts/myhaibao_myreward.tpl";
		$this->smartyRender("myhaibao/activity_rule.tpl",$renderData);
	}
	/**
        个性海报
	 */
	public function actionDiyHaibao(){
		$member_id = Yii::app()->loginUser->getUserId();
        $posterModel =$this->convertModelToArray(FhMemberHaibaoModel::model()->with('poster')->find('member_id=:member_id and t.accounts_id=:accounts_id', [':member_id'=>$member_id,':accounts_id'=>$this->mpid]));

        $mpModel = FhPosterAccountsModel::model()->findByPk($this->mpid);

        $snsModel = UcMemberBindSns::model()->find('member_id=:mid and sns_appid=:appid', [':mid'=>$member_id, ':appid'=>$mpModel->appid]);
        $weObj = new Wechat($mpModel->toWechatOption());
        $snsInfo = $weObj->getUserInfo($snsModel->sns_id);

        $mobile = $snsModel->member_mobile;
        $renderData = array(
            'pageTitle'     => 'Xahoo',
			'posterModel'   => $posterModel,
            'mobile'        => $mobile,
            'snsInfo'       => $snsInfo,
		);
		$this->layout = "layouts/myhaibao_myreward.tpl";
		$this->smartyRender("myhaibao/diy_haibao.tpl",$renderData);
	}

}