<?php

/**
 * 引入UCenter资源
 */
Yii::import('application.ucentermob.config.*.php');
//require_once("apiConfig.php");

/**
 * 会员中心公开出去的接口类
 */
class UCenterStatic extends CController{

        /**
         * process parameter to integer for security
         * 
         * @param  string           $str
         * @return integer|null     
         */
        public static function getInt($str) {
                if (!isset($str)) {
                        return null;
                } else {
                        return intval($str);
                }
        }

        /**
         * process parameter to string for security
         * 
         * @param  string $str 
         * @return string
         */
        public static function getString($str) {
                $str = trim($str);
                return addslashes($str);
        }

        /**
         * 将Yii模型对象转为数组(多维)
         * 
         * @param  object $models          [description]
         * @param  array $filterAttributes [description]
         * @return array                   [description]
         *
         * @todo 格式化
         */
        public static function convertModelToArray($models, array $filterAttributes = null) {
                return OBJTool::convertModelToArray($models, $filterAttributes);
        }

        /** ********************** business logic *********************** */

        /**
         * 根据会员ID获取会员信息
         * 
         * @param  integer $member_id 会员ID
         * @return array              会员基本数据
         */
        public static function getUserProfile($member_id = 0) {
                $member_id = self::getInt($member_id);

                $strSqlParams = 'member_id';
                // 获取用户信息
                $objUserProfile = UcMember::model()->findByPk($member_id);
                $arrUserProfile = !empty($objUserProfile) ? $objUserProfile->attributes : array();

                $userAvatar = !empty($arrUserProfile['member_avatar']) ? AresUtil::generateImageUrl($arrUserProfile['member_avatar']) : '';
                //  date:2015-03-18 11:15  bug:#3648    Author:zhaoting
                $welcomeName = empty($arrUserProfile['member_nickname'])? substr_replace(Yii::app()->loginUser->getUserName(), '****', 3, 4) : $arrUserProfile['member_nickname'];
                // 获取用户数据
                $objMemberTotal = MemberTotalModel::model()->find('member_id=' . $member_id);
                $arrMemberTotal = !empty($objMemberTotal) ? $objMemberTotal->attributes : array();

                // 会员总额
                $totalContribute = !empty($arrMemberTotal['total_contribute']) ? round($arrMemberTotal['total_contribute']) : 0; //贡献值
                $totalPoint = !empty($arrMemberTotal['total_point']) ? $arrMemberTotal['total_point'] : 0; //总积分
                $totalReward = !empty($arrMemberTotal['total_reward']) ? $arrMemberTotal['total_reward'] : 0; //总佣金
                // 会员等级
                //$memberGradePercent = $totalContribute >= 50000 ? 100 : $totalContribute / 50000 * 100;
                if ($totalContribute <= 5000) {
						$memberGradelevel = 1;
                        $memberGradeName = '普通会员';
						$memberGradePercent = $totalContribute / 5000 * 100;
                } elseif ($totalContribute > 5000 && $totalContribute <= 10000) {
						$memberGradelevel = 2;
                        $memberGradeName = '水晶会员';
						$memberGradePercent = $totalContribute / 10000 * 100;
                } elseif ($totalContribute > 10000 && $totalContribute <= 25000) {
						$memberGradelevel = 3;
                        $memberGradeName = '彩金会员';
						$memberGradePercent = $totalContribute / 25000 * 100;
                } elseif ($totalContribute > 25000 && $totalContribute <= 49999) {
						$memberGradelevel = 4;
                        $memberGradeName = '铂金会员';
						$memberGradePercent = $totalContribute / 49999 * 100;
                } elseif ($totalContribute >= 50000) {
						$memberGradelevel = 5;
                        $memberGradeName = '钻石会员';
						$memberGradePercent = 100;
                } 

                $formatedResult = array(
                    'userProfile' => $arrUserProfile,
                    'userAvatar' => $userAvatar,
                    'welcomeName' => $welcomeName,
                    'memberGradelevel' => $memberGradelevel,
					'memberGradeName' => $memberGradeName,
                    'memberGradePercent' => $memberGradePercent,
                    'totalContribute' => $totalContribute,
                    'totalPoint' => $totalPoint,
                    'totalReward' => $totalReward,
                );

                return $formatedResult;
        }

        /**
         * 根据会员标识获取会员信息
         * 
         * @param  integer $signage   会员标识
         * @return array              会员基本数据
         */
        public static function getUserInfo($signage) {
                $signage = self::getString($signage);
                $objUserInfo = UcMember::model()->find('signage="' . $signage . '"');
                $arrUserInfo = !empty($objUserInfo) ? $objUserInfo->attributes : array();
                return $arrUserInfo;
        }

        /**
         * 根据会员电话获取会员信息
         * 
         * @param  integer $member_mobile 会员ID
         * @return array              会员基本数据
         */
        public static function getUserInfoByTel($tel) {
                $tel = self::getString($tel);
                $objUserInfo = UcMember::model()->find('member_mobile="' . $tel . '"');
                $arrUserInfo = !empty($objUserInfo) ? $objUserInfo->attributes : array();
                return $arrUserInfo;
        }

        /**
         * 判断是否收藏
         *
         * @param  integer $member_id		会员ID
         * @param  integer $task_type		任务类型
         * @param  integer $task_id			任务ID
         * @param  string  $task_source		任务来源
         * @return 					
         */
        public static function CheckFavorite($member_id, $task_type, $task_id, $task_source) {
                $member_id = self::getInt($member_id);
                $task_type = self::getInt($task_type);
                $task_id = self::getInt($task_id);
                $task_source = self::getString($task_source);

                $strCondition = 'member_id = ' . $member_id;
                $strCondition .= ' AND task_type = ' . $task_type;
                $strCondition .= ' AND task_id = ' . $task_id;
                $strCondition .= ' AND status = 1';
                $strCondition .= ' AND task_source = "' . $task_source . '"';

                $total = UcMemberFavorite::model()->count($strCondition);
                if ($total > 0) {
                        return 'success';
                } else {
                        return 'fail';
                }
        }

        /**
         * 获取收藏信息
         *
         * @param  integer $member_id		会员ID
         * @param  integer $task_type		任务类型
         * @param  integer $task_id			任务ID
         * @param  string  $task_source		任务来源
         * @return 					
         */
        public static function getFavorite($member_id, $task_type, $task_source, $offset = 0, $limit = 0) {
                $member_id = self::getInt($member_id);
                $task_type = self::getInt($task_type);
                $task_source = self::getString($task_source);

                if ($limit == 0) {
                        $SqlParams = array(
                            'condition' => 'member_id=' . $member_id . ' and status=1 and task_type=' . $task_type . ' and task_source="' . $task_source . '"',
                            'order' => 'task_id desc',
                            'offset' => $offset,
                        );
                } else {
                        $SqlParams = array(
                            'condition' => 'member_id=' . $member_id . ' and status=1 and task_type=' . $task_type . ' and task_source="' . $task_source . '"',
                            'order' => 'task_id desc',
                            'limit' => $limit,
                            'offset' => $offset,
                        );
                }

                $objMemberFavorite = UcMemberFavorite::model()->findAll($SqlParams);
                $arrMemberFavorite = OBJTool::convertModelToArray($objMemberFavorite);
                if (!empty($arrMemberFavorite)) {
                        return $arrMemberFavorite;
                } else {
                        return array();
                }
        }

        /**
         * 添加到收藏
         *
         * @param  integer $member_id		会员ID
         * @param  integer $task_type		任务类型
         * @param  integer $task_id			任务ID
         * @param  string  $task_source		任务来源
         * @return 
         */
        public static function addFavorite($member_id, $task_type, $task_id, $task_source) {
                $member_id = self::getInt($member_id);
                $task_type = self::getInt($task_type);
                $task_id = self::getInt($task_id);
                $task_source = self::getString($task_source);

                $strCondition = 'member_id=' . $member_id;
                $strCondition .= ' AND task_type=' . $task_type;
                $strCondition .= ' AND task_id=' . $task_id;
                $strCondition .= ' AND task_source="' . $task_source . '"';

                $objMyFavorite = UcMemberFavorite::model()->find($strCondition);
                // 查找不到初始化对象
                if (empty($objMyFavorite)) {
                        $objMyFavorite = new UcMemberFavorite();
                }

                // 复制属性
                $objMyFavorite->member_id = $member_id;
                $objMyFavorite->task_type = $task_type;
                $objMyFavorite->task_id = $task_id;
                $objMyFavorite->task_source = $task_source;
                $objMyFavorite->create_time = date('Y-m-d H:i:s', time());
                $objMyFavorite->last_modified = date('Y-m-d H:i:s', time());
                $objMyFavorite->status = 1;
                // insert or update
                if ($objMyFavorite->save()) {
                        return 'success';
                } else {
                        return 'fail';
                }
        }

        /**
         * 移除收藏
         *
         * @param  integer $member_id		会员ID
         * @param  integer $task_type		任务类型
         * @param  integer $task_id			任务ID
         * @param  string  $task_source		任务来源
         * @return 
         */
        public static function deleteFavorite($member_id, $task_type, $task_id, $task_source) {
                $member_id = self::getInt($member_id);
                $task_type = self::getInt($task_type);
                $task_id = self::getInt($task_id);
                $task_source = self::getString($task_source);

                $strCondition = 'member_id=' . $member_id;
                $strCondition .= ' AND task_type=' . $task_type;
                $strCondition .= ' AND task_id=' . $task_id;
                $strCondition .= ' AND task_source="' . $task_source . '"';

                $objMyFavorite = UcMemberFavorite::model()->find($strCondition);
                if ($objMyFavorite) {
                        $objMyFavorite->last_modified = date('Y-m-d H:i:s');
                        $objMyFavorite->status = 0;
                        if ($objMyFavorite->save()) {
                                return 'success';
                        } else {
                                return 'fail';
                        }
                } else {
                        return 'fail';
                }
        }

        /**
         * 获取订单返回多少积分
         *
         * @param  string	$action		    动作类型
         * @param  string	$source			功能模块
		 * @param  integer	$deal_amount	成交金额
         * @return array
         */
        public static function getOrderPoint($action, $source, $deal_amount=0) {
                $action = strtolower(self::getString($action));
                $source = strtolower(self::getString($source));
				$deal_amount = self::getString($deal_amount);
                $objPointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and project=:project and status=1', array('rule_action' => $action, 'project' => $source));
                $arrPointRule = !empty($objPointRule) ? $objPointRule->attributes : array();
				$rule_point = round($arrPointRule['rule_point']/1000 * $deal_amount);
				return $rule_point;
        }

        /**
         * 获取动作返回多少积分
         *
         * @param  string	$action		    动作类型
         * @return array
         */
        public static function getPoint($action) {
                $action = strtolower(self::getString($action));
                $objPointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => $action));
                $arrPointRule = !empty($objPointRule) ? $objPointRule->attributes : array();
				$rule_point = $arrPointRule['rule_point'];
				return $rule_point;
        }


        /**
         * 分权支付给自己添加积分和贡献
         *
         * @param  integer	$member_id		会员ID
         * @param  integer	$deal_amount	成交金额
         * @param  integer	$order_id		订单ID
		 * @param  string	$order_numberid 订单编号
		 * @param  integer	$item_id		项目ID
         * @param  string	$item_name		项目名称
         * @return
         */
        public static function addPointByfq($member_id, $deal_amount, $order_id, $order_numberid, $item_id, $item_name) {
                $member_id = self::getInt($member_id);
				$order_id = self::getInt($order_id);
				$deal_amount = self::getString($deal_amount);
				$order_numberid = self::getString($order_numberid);
                $item_id = self::getInt($item_id);
				$item_name = self::getString($item_name);

                $objPointRule = UcMemberPointRule::model()->find("rule_action='order' and project='fenquan' and status=1");
                $arrPointRule = !empty($objPointRule) ? $objPointRule->attributes : array();

                $objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $member_id));
                $point_before = $objMemberTotal->total_point;
                $contribute_before = $objMemberTotal->total_contribute;
				
                $rule_point = round($arrPointRule['rule_point']/1000 * $deal_amount);

                //更新会员总信息表(积分和贡献)

                $objMemberTotal->total_point += $rule_point;
                $objMemberTotal->total_contribute += $rule_point;
                $objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
                if ($objMemberTotal->update()) {

                    //写积分日志
                    $MemberPointLog = new UcMemberPointLog();
                    $MemberPointLog->member_id = $member_id;
                    $MemberPointLog->item_id = $item_id;
                    $MemberPointLog->item_name = $item_name;
                    $MemberPointLog->order_id = $order_id;
                    $MemberPointLog->order_numberid = $order_numberid;
                    $MemberPointLog->rule_id = $arrPointRule['rule_id'];
                    $MemberPointLog->rule_point = $rule_point;
                    $MemberPointLog->operate_type = 1;
                    $MemberPointLog->point_before = $point_before;
                    $MemberPointLog->point_after = $point_before + $rule_point;
                    $MemberPointLog->description = $arrPointRule['rule_name'];
                    $MemberPointLog->source = 'fenquan';
                    $MemberPointLog->create_time = date('Y-m-d H:i:s', time());
                    $MemberPointLog->insert();

                    //写贡献日志
                    $MemberContributeLog = new UcMemberContributeLog();
                    $MemberContributeLog->member_id = $member_id;
                    $MemberContributeLog->item_id = $item_id;
                    $MemberContributeLog->item_name = $item_name;
                    $MemberContributeLog->order_id = $order_id;
                    $MemberContributeLog->order_numberid = $order_numberid;
                    $MemberContributeLog->contribute_score = $rule_point;
                    $MemberContributeLog->contribute_before = $contribute_before;
                    $MemberContributeLog->contribute_after = $contribute_before + $rule_point;
                    $MemberContributeLog->status = 2;//已获取
                    $MemberContributeLog->source = 'fenquan';
                    $MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
                    $MemberContributeLog->last_modified = date('Y-m-d H:i:s', time());
                    $MemberContributeLog->insert();
                    return 'success';
                } else {
                    return 'fail';
                }

        }

		/*
		**	分权支付时给小伙伴添加佣金和贡献
		**
		*/
		public static function addRewardByfq($member_id, $item_id, $item_name, $order_id, $order_numberid, $deal_amount) {
                $member_id = self::getInt($member_id);
                //$task_id = self::getInt($task_id);
				$item_id = self::getInt($item_id);
                $item_name = self::getString($item_name);
                $order_id = self::getInt($order_id);
				$order_numberid = self::getString($order_numberid);
                $deal_amount = self::getString($deal_amount);
				$reward_rule = array('0.00003125','0.0000625','0.000125','0.00025','0.0005');
                $objMemberRelation = UcMemberRelation::model()->find('member_id=:member_id', array('member_id' => $member_id));
                $parent_tree = $objMemberRelation->parent_tree;
				$parent_depth = $objMemberRelation->parent_depth>6 ? 6 :$objMemberRelation->parent_depth;
				if(!empty($parent_tree)){
						$parent_arr = explode(',', $parent_tree);
						foreach ($parent_arr as $key => $value) {
								if($key<6){
										$parent_id = $value;

										$objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $parent_id));
										$contribute_before = $objMemberTotal->total_contribute; //当前贡献
										$reward_before = $objMemberTotal->total_reward; //当前佣金

										if($key==0){
											$reward_score = round(0.001 * $deal_amount,2) ;
										}else{
											$reward_score = round($reward_rule[$parent_depth-$key-1] * $deal_amount,2) ;
										}

                                        $objMemberTotal->total_reward = $reward_before + $reward_score;
                                        $objMemberTotal->total_contribute = $contribute_before + round($reward_score);
                                        $objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
                                        if($objMemberTotal->update()){
                                                //写佣金日志
                                                $MemberRewardLog = new UcMemberRewardLog();
                                                $MemberRewardLog->member_id = $parent_id;
                                                //$MemberRewardLog->task_id = $task_id;
                                                $MemberRewardLog->order_id = $order_id;
                                                $MemberRewardLog->item_id = $item_id;
                                                $MemberRewardLog->item_name = $item_name;
                                                $MemberRewardLog->order_numberid = $order_numberid;
                                                $MemberRewardLog->parent_id = $member_id;
                                                $MemberRewardLog->degree = $key+1;
                                                $MemberRewardLog->reward_score = $reward_score;
                                                $MemberRewardLog->operate_type = 1;
                                                $MemberRewardLog->reward_before = $reward_before;
                                                $MemberRewardLog->reward_after = $reward_before + $reward_score;
                                                $MemberRewardLog->source = 'fenquan';
                                                $MemberRewardLog->status = 2;
                                                $MemberRewardLog->create_time = date('Y-m-d H:i:s', time());
                                                $MemberRewardLog->last_modified = date('Y-m-d H:i:s', time());
                                                $MemberRewardLog->insert();
                                                        
                                                //写贡献日志
                                                $MemberContributeLog = new UcMemberContributeLog();
                                                $MemberContributeLog->member_id = $parent_id;
                                                //$MemberContributeLog->task_id = $task_id;
                                                $MemberContributeLog->order_id = $order_id;
                                                $MemberContributeLog->item_id = $item_id;
                                                $MemberContributeLog->item_name = $item_name;
                                                $MemberContributeLog->order_numberid = $order_numberid;
                                                $MemberContributeLog->contribute_score = round($reward_score);
                                                $MemberContributeLog->contribute_before = $contribute_before;
                                                $MemberContributeLog->contribute_after = $contribute_before + round($reward_score);
                                                $MemberContributeLog->source = 'fenquan';
                                                $MemberContributeLog->status = 2;
                                                $MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
                                                $MemberContributeLog->last_modified = date('Y-m-d H:i:s', time());
                                                $MemberContributeLog->insert(); 
                                        }      
								}
						}
				}
                return 'success';
		
		}
        

        /**
         * 众筹支付给自己添加积分和贡献
         *
         * @param  integer	$member_id		会员ID
         * @param  integer	$deal_amount	成交金额
         * @param  integer	$order_id		订单ID
		 * @param  string	$order_numberid 订单编号
		 * @param  integer	$item_id		项目ID
         * @param  string	$item_name		项目名称
         * @return
         */
        public static function addPointByzc($member_id, $deal_amount, $order_id, $order_numberid, $item_id, $item_name) {
                $member_id = self::getInt($member_id);
				$order_id = self::getInt($order_id);
				$deal_amount = self::getString($deal_amount);
				$order_numberid = self::getString($order_numberid);
                $item_id = self::getInt($item_id);
				$item_name = self::getString($item_name);

                $objPointRule = UcMemberPointRule::model()->find("rule_action='order' and project='zhongchou' and status=1");
                $arrPointRule = !empty($objPointRule) ? $objPointRule->attributes : array();

                $objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $member_id));
				$point_before = $objMemberTotal->total_point;
                $contribute_before = $objMemberTotal->total_contribute;

                $rule_point = round($arrPointRule['rule_point']/1000 * $deal_amount);
				
				
				//$objTotalPoint = UcMemberPointLog::model()->findAll('member_id=:member_id', array('member_id' => $member_id));
				//$arrTotalPoint = self::convertModelToArray($objTotalPoint);
				//foreach($arrTotalPoint as $item){
				//	$point_before += $item['rule_point'];
				//}

                //更新会员总信息表(积分和贡献)
				$objMemberTotal->total_point += $rule_point;
                $objMemberTotal->total_contribute += $rule_point;
                $objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
                if ($objMemberTotal->update()) {

                    //写积分日志
                    $MemberPointLog = new UcMemberPointLog();
                    $MemberPointLog->member_id = $member_id;
                    $MemberPointLog->item_id = $item_id;
                    $MemberPointLog->item_name = $item_name;
                    $MemberPointLog->order_id = $order_id;
                    $MemberPointLog->order_numberid = $order_numberid;
                    $MemberPointLog->rule_id = $arrPointRule['rule_id'];
                    $MemberPointLog->rule_point = $rule_point;
                    $MemberPointLog->operate_type = 1;
                    $MemberPointLog->point_before = $point_before;
                    $MemberPointLog->point_after = $point_before + $rule_point;
                    $MemberPointLog->description = $arrPointRule['rule_name'];
                    $MemberPointLog->source = 'zhongchou';
                    $MemberPointLog->create_time = date('Y-m-d H:i:s', time());
                    $MemberPointLog->insert();

                    //写贡献日志
                    $MemberContributeLog = new UcMemberContributeLog();
                    $MemberContributeLog->member_id = $member_id;
                    $MemberContributeLog->item_id = $item_id;
                    $MemberContributeLog->item_name = $item_name;
                    $MemberContributeLog->order_id = $order_id;
                    $MemberContributeLog->order_numberid = $order_numberid;
                    $MemberContributeLog->contribute_score = $rule_point;
                    $MemberContributeLog->contribute_before = $contribute_before;
                    $MemberContributeLog->contribute_after = $contribute_before + $rule_point;
                    $MemberContributeLog->status = 2;//已获取
                    $MemberContributeLog->source = 'zhongchou';
                    $MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
                    $MemberContributeLog->last_modified = date('Y-m-d H:i:s', time());
                    $MemberContributeLog->insert();
                    return 'success';
                } else {
                    return 'fail';
                }

        }


		/*
		**	众筹支付时给小伙伴添加佣金(等待结算)和贡献
		**
		*/
		public static function addRewardByzc($member_id, $item_id, $item_name, $order_id, $order_numberid, $deal_amount) {
                $member_id = self::getInt($member_id);
				$item_id = self::getInt($item_id);
                $item_name = self::getString($item_name);
                $order_id = self::getInt($order_id);
				$order_numberid = self::getString($order_numberid);
                $deal_amount = self::getString($deal_amount);
				$reward_rule = array('0.00003125','0.0000625','0.000125','0.00025','0.0005');
                $objMemberRelation = UcMemberRelation::model()->find('member_id=:member_id', array('member_id' => $member_id));
                $parent_tree = $objMemberRelation->parent_tree;
				$parent_depth = $objMemberRelation->parent_depth>6 ? 6 :$objMemberRelation->parent_depth;
				if(!empty($parent_tree)){
						$parent_arr = explode(',', $parent_tree);
						foreach ($parent_arr as $key => $value) {
								if($key<6){
										$parent_id = $value;

										$objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $parent_id));
										$contribute_before = $objMemberTotal->total_contribute; //当前贡献
										
										//当前佣金
										$reward_before = 0;
										$objTotalReward = UcMemberRewardLog::model()->findAll('member_id=:member_id', array('member_id' => $parent_id));
										$arrTotalReward = self::convertModelToArray($objTotalReward);
										foreach($arrTotalReward as $item){
											$reward_before += $item['reward_score'];
										}

										if($key==0){
											$reward_score = round(0.001 * $deal_amount,2) ;
										}else{
											$reward_score = round($reward_rule[$parent_depth-$key-1] * $deal_amount,2) ;
										}

                                        $objMemberTotal->total_contribute = $contribute_before + round($reward_score);
                                        $objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
                                        if($objMemberTotal->update()){
                                                //写佣金日志   
                                                $MemberRewardLog = new UcMemberRewardLog();
                                                $MemberRewardLog->member_id = $parent_id;
                                                //$MemberRewardLog->task_id = $task_id;
                                                $MemberRewardLog->order_id = $order_id;
                                                $MemberRewardLog->item_id = $item_id;
                                                $MemberRewardLog->item_name = $item_name;
                                                $MemberRewardLog->order_numberid = $order_numberid;
                                                $MemberRewardLog->parent_id = $member_id;
                                                $MemberRewardLog->degree = $key+1;
                                                $MemberRewardLog->reward_score = $reward_score;
                                                $MemberRewardLog->operate_type = 1;
                                                $MemberRewardLog->reward_before = $reward_before;
                                                $MemberRewardLog->reward_after = $reward_before + $reward_score;
                                                $MemberRewardLog->source = 'zhongchou';
                                                $MemberRewardLog->status = 1;
                                                $MemberRewardLog->create_time = date('Y-m-d H:i:s', time());
                                                $MemberRewardLog->last_modified = date('Y-m-d H:i:s', time());
                                                $MemberRewardLog->insert();
                  
                                                //写贡献日志
                                                $MemberContributeLog = new UcMemberContributeLog();
                                                $MemberContributeLog->member_id = $parent_id;
                                                //$MemberContributeLog->task_id = $task_id;
                                                $MemberContributeLog->order_id = $order_id;
                                                $MemberContributeLog->item_id = $item_id;
                                                $MemberContributeLog->item_name = $item_name;
                                                $MemberContributeLog->order_numberid = $order_numberid;
                                                $MemberContributeLog->contribute_score = round($reward_score);
                                                $MemberContributeLog->contribute_before = $contribute_before;
                                                $MemberContributeLog->contribute_after = $contribute_before + round($reward_score);
                                                $MemberContributeLog->source = 'zhongchou';
                                                $MemberContributeLog->status = 2;
                                                $MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
                                                $MemberContributeLog->last_modified = date('Y-m-d H:i:s', time());
                                                $MemberContributeLog->insert(); 
                                        }      
								}
						}
				}
                return 'success';
		
		}


        /**
         * 除订单以外的动作 添加积分和贡献
         *
         * @param  integer	$member_id		会员ID
         * @param  string	$action		    动作类型
		 * @param  string	$source			积分来源
         * @return
         */
        public static function setPoint($member_id, $action, $source) {
                $member_id = self::getInt($member_id);
				$action = strtolower(self::getString($action));
				$source = strtolower(self::getString($source));
                
 
                $objPointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => $action));
                $arrPointRule = !empty($objPointRule) ? $objPointRule->attributes : array();
 

                $objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $member_id));

                $point_before = $objMemberTotal->total_point;
                $contribute_before = $objMemberTotal->total_contribute;
				
 
				$rule_point = $arrPointRule['rule_point'];
                    
 
                //更新会员总信息表(积分和贡献)

                $objMemberTotal->total_point += $rule_point;
                $objMemberTotal->total_contribute += $rule_point;
                $objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
                if ($objMemberTotal->update()) {

                    //写积分日志
                    $MemberPointLog = new UcMemberPointLog();
                    $MemberPointLog->member_id = $member_id;
                    $MemberPointLog->rule_id = $arrPointRule['rule_id'];
                    $MemberPointLog->rule_point = $rule_point;
                    $MemberPointLog->operate_type = 1;
                    $MemberPointLog->point_before = $point_before;
                    $MemberPointLog->point_after = $point_before + $rule_point;
                    $MemberPointLog->description = $arrPointRule['rule_name'];
                    $MemberPointLog->source = $source;
                    $MemberPointLog->create_time = date('Y-m-d H:i:s', time());
                    $MemberPointLog->insert();

                    //写贡献日志
                    $MemberContributeLog = new UcMemberContributeLog();
                    $MemberContributeLog->member_id = $member_id;
                    $MemberContributeLog->contribute_score = $rule_point;
					$MemberContributeLog->operate_type = 1;
                    $MemberContributeLog->contribute_before = $contribute_before;
                    $MemberContributeLog->contribute_after = $contribute_before + $rule_point;
                    $MemberContributeLog->status = 2;
                    $MemberContributeLog->source = $source;
                    $MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
                    $MemberContributeLog->last_modified = date('Y-m-d H:i:s', time());
                    $MemberContributeLog->insert();
                    return 'success';
                } else {
                    return 'fail';
                }
 


        }

        /**
         * 添加佣金和贡献等待付款状态的日志 
         *
         * @param  integer	$member_id		会员ID
         * @param  integer	$task_id		任务ID
         * @param  integer	$order_id		订单ID
		 * @param  string	$order_numberid 订单编号
         * @param  string	$deal_amount	成交金额
         * @param  string	$source			来源
		 * @param  string	$item_id		项目id
         * @return 
         */
        public static function setReward($member_id, $item_name, $task_id, $order_id, $order_numberid, $deal_amount, $source, $item_id) {
                $member_id = self::getInt($member_id);
                $task_id = self::getInt($task_id);
				$item_id = self::getInt($item_id);
                $order_id = self::getInt($order_id);
				$order_numberid = self::getString($order_numberid);
                $deal_amount = self::getString($deal_amount);
                $source = self::getString($source);
                $item_name = self::getString($item_name);
				$reward_rule = array('0.00003125','0.0000625','0.000125','0.00025','0.0005');
                $objMemberRelation = UcMemberRelation::model()->find('member_id=:member_id', array('member_id' => $member_id));
                $parent_tree = $objMemberRelation->parent_tree;
				$parent_depth = $objMemberRelation->parent_depth>6 ? 6 :$objMemberRelation->parent_depth;
				if(!empty($parent_tree)){
						$parent_arr = explode(',', $parent_tree);
						foreach ($parent_arr as $key => $value) {
								if($key<6){
										$parent_id = $value;
										//$reward_score = pow(0.5, $key) * $deal_amount * 0.001 ;
										if($key==0){
											$reward_score = round(0.001 * $deal_amount,2) ;
										}else{
											$reward_score = round($reward_rule[$parent_depth-$key-1] * $deal_amount,2) ;
										}
										if( ($source=='zhongchou' && $deal_amount>=50000) || $source=='fenquan' ){
												//写佣金日志
												$MemberRewardLog = new UcMemberRewardLog();
												$MemberRewardLog->member_id = $parent_id;
												$MemberRewardLog->task_id = $task_id;
												$MemberRewardLog->order_id = $order_id;
												$MemberRewardLog->item_id = $item_id;
												$MemberRewardLog->order_numberid = $order_numberid;
												$MemberRewardLog->parent_id = $member_id;
												$MemberRewardLog->degree = $key+1;
												$MemberRewardLog->reward_score = $reward_score;
												$MemberRewardLog->operate_type = 1;
												$MemberRewardLog->reward_before = 0;
												$MemberRewardLog->reward_after = 0;
												$MemberRewardLog->source = $source;
												$MemberRewardLog->status = 1;
												$MemberRewardLog->create_time = date('Y-m-d H:i:s', time());
												$MemberRewardLog->last_modified = date('Y-m-d H:i:s', time());
												$MemberRewardLog->insert();
										}
										//写贡献日志
										$MemberContributeLog = new UcMemberContributeLog();
										$MemberContributeLog->member_id = $parent_id;
										$MemberContributeLog->task_id = $task_id;
										$MemberContributeLog->order_id = $order_id;
										$MemberContributeLog->item_id = $item_id;
										$MemberContributeLog->order_numberid = $order_numberid;
										$MemberContributeLog->contribute_score = round($reward_score);
										$MemberContributeLog->contribute_before = 0;
										$MemberContributeLog->contribute_after = 0;
										$MemberContributeLog->source = $source;
										$MemberContributeLog->status = 1;
										$MemberContributeLog->item_name = $item_name;
										$MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
										$MemberContributeLog->last_modified = date('Y-m-d H:i:s', time());
										$MemberContributeLog->insert();
								}
						}
				}
                return 'success';
        }

        /**
         * 退出登录接口
         */
        public static function actionLogout() {
            $return_url = isset($_GET['return_url']) ? self::getString($_GET['return_url']) : Yii::app()->params['UCenterServerName'].'?r=user/login';
            Yii::app()->loginUser->logoutAndClearStates();
            self::redirect($return_url);
        }



}
