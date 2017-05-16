<?php

class RewardController extends Controller {

        public function actionIndex() {
				$return_url = $this->checkReturnUrl();
				$this->checkLogin();
				$member_id = Yii::app()->loginUser->getUserId();
				$objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $member_id));
				$total_reward = $objMemberTotal->total_reward;//当前佣金
				
				//等待付款-进行中
                //$dueSqlParams = array(
                //    'condition' => 't.member_id=:member_id and t.status=:status',
                //    'params' => array(':member_id' => $member_id,':status' => 1),
                //    'order' => 'log_id desc',
				//	'limit' => 5,
                //);
				//$objRewardDue = UcMemberRewardLog::model()->with('member')->findAll($dueSqlParams);
				//$arrRewardDue = $this->convertModelToArray($objRewardDue);
				
				//全部
				$allSqlParams = array(
                    'condition' => 't.member_id=:member_id and source="fenquan"',// and t.status in(1,2)
                    'params' => array(':member_id' => $member_id),
					//'condition' => 't.member_id=:member_id and t.status=:status',
                    //'params' => array(':member_id' => $member_id,':status' => 2),
                    'order' => 'log_id desc',
					'limit' => 5,
                );
				$objRewardAll = UcMemberRewardLog::model()->with('member')->findAll($allSqlParams);
				$arrRewardAll = $this->convertModelToArray($objRewardAll);
                $arrRender = array(
                    'gShowHeader' => true,
                    'return_url' => $return_url,
                    'headerTitle' => '我的佣金',
					'total_reward' => $total_reward,
					//'arrRewardDue' => $arrRewardDue,//进行中
					'arrRewardAll' => $arrRewardAll,//全部
					'ListUrl' => $this->createAbsoluteUrl('reward/list',array('return_url' => $return_url)),//查看全部
					'RuleUrl' => $this->createAbsoluteUrl('reward/rule',array('return_url' => $return_url)),//如何获取佣金
					'CashUrl' => $this->createAbsoluteUrl('reward/cash',array('return_url' => $return_url)),//佣金提现
					'FanghuUrl' => $this->createFanghuUrl('task/index',array('type' => 2)),//立赚
                );
				$this->smartyRender('reward/index.tpl', $arrRender);
        }

        public function actionList() {
                $this->checkLogin();
                $return_url = $this->outPutString($_GET['return_url']);
                if(empty($return_url)) {
                    $return_url = $this->createAbsoluteUrl('user/index');
                }
				
				$member_id = Yii::app()->loginUser->getUserId();
			
                //$dueSqlParams = array(
                //    'condition' => 't.member_id=:member_id and t.status=:status',
                //    'params' => array(':member_id' => $member_id,':status' => 1),
                //    'order' => 'log_id desc',
				//	'limit' => 10,
                //);
				//$objRewardDue = UcMemberRewardLog::model()->with('member')->findAll($dueSqlParams);
				//$arrRewardDue = $this->convertModelToArray($objRewardDue);
				//$RewardDueTotal = UcMemberRewardLog::model()->count("member_id=:member_id and status=1", array(":member_id" => $member_id));

				$allSqlParams = array(
					'condition' => 't.member_id=:member_id and source="fenquan"',//and t.status in(1,2)
                    'params' => array(':member_id' => $member_id),
                    //'condition' => 't.member_id=:member_id and t.status=:status',
                    //'params' => array(':member_id' => $member_id,':status' => 2),
                    'order' => 'log_id desc',
					'limit' => 10,
                );
				$objRewardAll = UcMemberRewardLog::model()->with('member')->findAll($allSqlParams);
				$arrRewardAll = $this->convertModelToArray($objRewardAll);
				$RewardMadeTotal = UcMemberRewardLog::model()->count("member_id=:member_id and status in(1,2)", array(":member_id" => $member_id));

                $arrRender = array(
                    'gShowHeader' => true,
                    'return_url' => $this->createAbsoluteUrl('reward/index'),
                    'headerTitle' => '佣金明细',
					//'arrMember' => $arrMember,
					//'arrRewardDue' => $arrRewardDue,
					'arrRewardAll' => $arrRewardAll,
					//'RewardDueTotal' => $RewardDueTotal,
					'RewardMadeTotal' => $RewardMadeTotal,
					'FanghuUrl' => $this->createFanghuUrl('task/index',array('type' => 2)),//立赚
                );
				$this->smartyRender('reward/list.tpl', $arrRender);
        }

        /**
         * 佣金规则
         */
        public function actionRule() {
                $this->checkLogin();
                if(empty($return_url)) {
                    $return_url = $this->createAbsoluteUrl('user/index');
                }
				$return_url = $this->createAbsoluteUrl('reward/rule');
                $arrRender = array(
                    'gShowHeader' => true,
					'return_url' => $this->createAbsoluteUrl('reward/index'),
					'EarnUrl' => $this->createAbsoluteUrl('reward/earn'),//如何获取佣金
					'friendinviteUrl' => $this->createFanghuUrl('member/friendinvite',array('return_url'=>$return_url)),//推荐新伙伴
                    'headerTitle' => '佣金规则',
                );
                $this->smartyRender('reward/rule.tpl', $arrRender);
        }

        /**
         * 佣金提现
         */
        public function actionCash() {
                $this->checkLogin();
                if(empty($return_url)) {
                    $return_url = $this->createAbsoluteUrl('user/index');
                }
                $arrRender = array(
                    'gShowHeader' => true,
					'return_url' => $this->createAbsoluteUrl('reward/index'),
                    'headerTitle' => '佣金提现',
                );
                $this->smartyRender('reward/cash.tpl', $arrRender);
        }

        /**
         * 佣金规则-我能赚多少
         */
        public function actionEarn() {
                $this->checkLogin();
                if(empty($return_url)) {
                    $return_url = $this->createAbsoluteUrl('user/index');
                }
                $arrRender = array(
                    'gShowHeader' => true,
					'return_url' => $this->createAbsoluteUrl('reward/rule'),
                    'headerTitle' => '佣金规则',
                );
                $this->smartyRender('reward/earn.tpl', $arrRender);
        }

}
