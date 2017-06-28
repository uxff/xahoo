<?php

class GradeController extends Controller {

        public function actionIndex() {
				$return_url = $this->checkReturnUrl();
				$this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();
				$objMemberTotal = UcMemberTotal::model()->find('member_id='.$member_id);
				$arrMemberTotal = !empty($objMemberTotal) ? $objMemberTotal->attributes : array();
				$totalContribute = round($arrMemberTotal['total_contribute']); 
				// 会员等级
                $memberGradePercent = $totalContribute > 10000 ? 100 : $totalContribute / 10000 * 100;
                if ($totalContribute <= 2500) {
                    $memberGradeName = '水晶会员';
					$memberGradelevel = 1;
                } elseif ($totalContribute > 2500 && $totalContribute <= 5000) {
                    $memberGradeName = '彩金会员';
					$memberGradelevel = 2;
                } elseif ($totalContribute > 5000 && $totalContribute <= 10000) {
                    $memberGradeName = '铂金会员';
					$memberGradelevel = 3;
                } elseif ($totalContribute > 10000) {
                    $memberGradeName = '钻石会员';
					$memberGradelevel = 4;
                } else {
                    $memberGradeName = '水晶会员';
					$memberGradelevel = 1;
                }                
                $arrRender = array(
                    'gShowHeader' => true,
                    'headerTitle' => '我的等级',
					'memberGradeName' => $memberGradeName,
					'memberGradelevel' => $memberGradelevel,
					'totalContribute' => $totalContribute,
                    'memberGradePercent' => $memberGradePercent,
                    'return_url' => $return_url,
					'RuleUrl' => $this->createAbsoluteUrl('grade/rule'),//如何获取经验
                );
                $this->smartyRender('grade/index.tpl', $arrRender);
        }

        /**
         * 查看经验规则
         */
        public function actionRule() {
				$this->checkLogin();
                $arrRender = array(
                    'gShowHeader' => true,
					//'ProfileUrl' => $this->createAbsoluteUrl('profile/index'),//在新奇世界个人中心赚积分
					//'XqsjZCServerUrl' => $this->createXqsjZCServerUrl(''),//在众筹网赚积分
					//'XqsjFQServerUrl' => $this->createXqsjFQServerUrl(''),//在分权频道赚积分
					//'FanghuUrl' => $this->createFanghuUrl(''),//在fh网赚积分
                    'return_url' => $this->createAbsoluteUrl('grade/index'),
                    'headerTitle' => '贡献值规则',
                );
                $this->smartyRender('grade/rule.tpl', $arrRender);
        }

}
