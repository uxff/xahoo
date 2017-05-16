<?php

class CheckinController extends Controller {

        public function actionIndex() {
                $this->checkLogin();
                $return_url = $this->outPutString($_GET['return_url']);
                if (empty($return_url)) {
                        $return_url = $this->createAbsoluteUrl('user/index');
                }
                $member_id = Yii::app()->loginUser->getUserId();

                $objpointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => 'signin'));
                if (!empty($objpointRule)) {
                        $time = date('Y-m-d', time());
						$totime = date("Y-m-d",strtotime("+1 day"));
                        $rule_id = $objpointRule->rule_id;
                        $total = UcMemberPointLog::model()->count("member_id={$member_id} and rule_id={$rule_id} and create_time>='{$time}' and create_time<'{$totime}'");
                        if ($total <= 0) {
                                $status = 'success';
                                $this->addPoint($member_id, 'signin');
                                $point = $objpointRule->rule_point;
                        } else {
                                $status = 'fail';
                                $point = 0;
                        }
                } else {
                        $status = 'fail';
                        $point = 0;
                }

                $arrRender = array(
                    'gShowHeader' => true,
                    //'gShowFooter' => true,
                    'return_url' => $return_url,
                    'headerTitle' => '签到',
                    'status' => $status,
                    'point' => $point,
                    'PointRuleUrl' => $this->createAbsoluteUrl('point/pointrule', array('return_url' => $return_url)), //如何获取积分
                );
                $this->smartyRender('checkin/index.tpl', $arrRender);
        }

}
