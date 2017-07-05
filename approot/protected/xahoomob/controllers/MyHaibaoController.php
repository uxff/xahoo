<?php

class MyHaibaoController extends BaseController{
	 public function init() {
        parent::init();
        $this->checkLogin(Yii::app()->request->hostInfo.Yii::app()->request->url);
        Yii::app()->getModule('points');
    }
	/**
	 * [actionMyReward description] 我的奖励首页
	 * @return [type] [description]
	 */
	public function actionMyReward(){
	    $accounts_id= isset($_GET['accounts_id']) ? $_GET['accounts_id'] : 1;
        Yii::app()->params['accounts_id'] = isset($_GET['accounts_id']) ? $_GET['accounts_id'] : 1;
		$member_id 	= Yii::app()->loginUser->getUserId();
        $totalModel = $this->convertModelToArray(FhMemberHaibaoModel::model()->with('total')->find('t.member_id=:member_id and t.accounts_id=:accounts_id', [':member_id'=>$member_id,':accounts_id'=>$accounts_id]));

        $last_cash = $this->getRemainCash($member_id, $totalModel['total']['money_total'],$accounts_id);
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
    public function getRemainCash($member_id, $total,$accounts_id=1) {
        $withdraw_data = FhMoneyWithdrawModel::model()->findBySql("select sum(withdraw_money) as withdraw_money from fh_money_withdraw where member_id =".$member_id." and accounts_id =".$accounts_id." and status in(1,3)");
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
	    $accounts_id = Yii::app()->params['accounts_id'];
		// 获取当前有效海报背景图
		$member_id = Yii::app()->loginUser->getUserId();
        $posterModel =$this->convertModelToArray(FhMemberHaibaoModel::model()->with('poster')->find('member_id=:member_id and t.accounts_id=:accounts_id', [':member_id'=>$member_id,':accounts_id'=>$accounts_id]));
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
	    $accounts_id = Yii::app()->params['accounts_id'];
		$member_id = Yii::app()->loginUser->getUserId();
        $posterModel =$this->convertModelToArray(FhMemberHaibaoModel::model()->with('poster')->find('member_id=:member_id and t.accounts_id=:accounts_id', [':member_id'=>$member_id,':accounts_id'=>$accounts_id]));

        $accounts_data = FhPosterAccountsModel::model()->findByPk($accounts_id);

        $snsModel = UcMemberBindSns::model()->find('member_id=:mid and sns_appid=:appid', [':mid'=>$member_id, ':appid'=>$accounts_data->appid]);
        $snsInfo = $this->getWxObj()->getUserInfo($snsModel->sns_id);

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
    public function getWxObj() {
        static $weObj;
        if ($weObj) {
            return $weObj;
        }

        Yii::import('application.common.extensions.wechatlib.*');
        $options = array(
            'token'=>'fanghu', //填写你设定的key
            'encodingaeskey'=>'k1fkSbcCjeucm7AEFfL4NczHSBTWayTqgoH8oGQfqA5', //填写加密用的EncodingAESKey，如接口为明文模式可忽略
            'appid' => Yii::app()->params['fh_wechat_appid'], //'wx829d7b12c00c4a97',
            'appsecret' => Yii::app()->params['fh_wechat_appsecret'], //'d0eb0ee77de35361ee51fc41df85da60',
        );

        return $weObj = new Wechat($options);
    }

}