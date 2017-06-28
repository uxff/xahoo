<?php

class PointController extends Controller {

        public function actionIndex() {
                $return_url = $this->checkReturnUrl();
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();
                $ObjMemberTotal = UcMemberTotal::model()->find("member_id={$member_id}");
                if ($ObjMemberTotal) {
                        $ArrMemberTotal = $this->convertModelToArray($ObjMemberTotal);
                        $total_point = $ArrMemberTotal['total_point'];
                } else {
                        $total_point = 0;
                }
                $arrSqlParams = array(
                    'condition' => 'member_id=:member_id and operate_type !=0',
                    'params' => array(':member_id' => $member_id),
                    'order' => 'log_id desc',
                    'limit' => 5,
                );
                $ObjMemberPointLog = UcMemberPointLog::model()->findAll($arrSqlParams);
                $ArrMemberPointLog = $this->convertModelToArray($ObjMemberPointLog);

                $arrRender = array(
                    'gShowHeader' => true,
                    'total_point' => $total_point,
                    'memberpointlog' => $ArrMemberPointLog,
                    'return_url' => $return_url,
                    'headerTitle' => '我的积分',
                    'PointRuleUrl' => $this->createAbsoluteUrl('point/pointrule'), //如何获取积分
                    'PointListUrl' => $this->createAbsoluteUrl('point/pointlist'), //查看全部
                );
                $this->smartyRender('point/index.tpl', $arrRender);
        }

        /**
         * 查看积分规则
         */
        public function actionPointRule() {
			
                $this->checkLogin();
				$return_url = $this->checkReturnUrl();
				$urlParams = array(
					'return_url' => $return_url,//$this->createAbsoluteUrl('point/index',array('return_url'=>$return_url)),
				);
                $arrRender = array(
                    'gShowHeader' => true,
                    'ProfileUrl' => $this->createAbsoluteUrl('profile/index',$urlParams), //在新奇世界个人中心赚积分
                    'XqsjZCServerUrl' => $this->createXqsjZCServerUrl(''), //在众筹网赚积分
                    'XqsjFQServerUrl' => $this->createXqsjFQServerUrl(''), //在分权频道赚积分
                    'FanghuUrl' => $this->createFanghuUrl(''), //在fh网赚积分
                    'return_url' => $this->createAbsoluteUrl('point/index'),
                    'headerTitle' => '积分规则',
                );
                $this->smartyRender('point/pointrule.tpl', $arrRender);
        }

        /**
         * 积分明细
         */
        public function actionPointList() {
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();

                $arrSqlParams = array(
                    'condition' => 'member_id=:member_id and operate_type !=0',
                    'params' => array(':member_id' => $member_id),
                    'order' => 'log_id desc',
                    'limit' => 100,
                );
                $MemberPointLog = UcMemberPointLog::model()->findAll($arrSqlParams);
				if($MemberPointLog){
					$MemberPointLogData = $this->convertModelToArray($MemberPointLog);
					$curmontharr = array();
					$othermontharr = array();
					$curmonth = date('Y-m',time());
					foreach($MemberPointLogData as $key=>$value){
						if(date('Y-m',strtotime($MemberPointLogData[$key]['create_time'])) == $curmonth){
								$curmontharr[] = $MemberPointLogData[$key];
						}else{
								$othermontharr[$key] = $MemberPointLogData[$key];
								$othermontharr[$key]['date'] = date('Y-m',strtotime($MemberPointLogData[$key]['create_time']));
						}
					}
					$newothermontharr =   array();
					foreach($othermontharr as $k=>$v){
						$newothermontharr[$v['date']][]= $v;
					}
				
				}else{
					$curmontharr = array();
					$newothermontharr = array();
				}
					$arrRender = array(
						'gShowHeader' => true,
						'curmontharr' => $curmontharr,
						'newothermontharr' => $newothermontharr,
						'return_url' => $this->createAbsoluteUrl('point/index'),
						'headerTitle' => '积分明细',
						'memberpointlog' => $MemberPointLogData,
					);	
                $this->smartyRender('point/PointList.tpl', $arrRender);
        }

}
