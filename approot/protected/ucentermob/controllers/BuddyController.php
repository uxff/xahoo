<?php

class BuddyController extends Controller {

        public function actionIndex() {

				$return_url = $this->checkReturnUrl();
                $this->checkLogin();
				$member_id = Yii::app()->loginUser->getUserId();
				$buddy_id = $member_id;
                if (!empty($_GET['id'])) {
                        $buddy_id = $this->getString($_GET['id']);
                        //判断是否是当前登陆会员的小伙伴
                        $MemberRelation = UcMemberRelation::model()->find("member_id={$buddy_id}");
                        if (!empty($MemberRelation)) {
                                $parent_tree = $MemberRelation->parent_tree;
                                $parent_arr = explode(',', $parent_tree);
                                if (!in_array($member_id, $parent_arr)) {
										$this->redirect($this->createAbsoluteUrl('site/error'));
                                        exit;
                                }
                        } else {
                                $this->redirect($this->createAbsoluteUrl('site/error'));
                                exit;
                        }
                }
				$objMember = UcMember::model()->find("member_id={$buddy_id}");

                $MemberRelation = UcMemberRelation::model()->find("member_id={$buddy_id}");
                $memberRelationLogin = UcMemberRelation::model()->find("member_id={$member_id}"); //当前登陆者的小伙伴深度
				$parent_depth = $MemberRelation->parent_depth - $memberRelationLogin->parent_depth;

                $objMemberParent = (object) array();
                if ($objMember->parent_id != 0) {
                        $objMemberParent = UcMember::model()->find("member_id={$objMember->parent_id}");
                        //$return_url = $this->createAbsoluteUrl('buddy/index', array('id' => $MemberRelation->parent_id));
						$return_url = $this->createAbsoluteUrl('buddy/index');
                }
                if ($objMember->parent_id == 0) {
                        $return_url = $this->createFanghuUrl('member/index');
                }
                if ($objMember->parent_id == $member_id) {
                        $return_url = $this->createAbsoluteUrl('buddy/index');
                }
				if ($buddy_id == $member_id) {
						$return_url = $this->createFanghuUrl('member/index');
				}

                if ($parent_depth >= 2) {
                        if (!empty($objMember->member_mobile)) {
                                $objMember->member_mobile = substr($objMember->member_mobile, 0, 3) . '*****' . substr($objMember->member_mobile, 8);
                        } else {
                                $objMember->member_mobile = '手机号未设置';
                        }
                        if (!empty($objMember->member_fullname)) {
                                $len = mb_strlen($objMember->member_fullname);
                                $objMember->member_fullname = mb_substr($objMember->member_fullname, 0, 1) . str_repeat('*', $len - 1);
                        } else {
                                $objMember->member_fullname = '姓名未设置';
                        }
                }
                if ($parent_depth >= 3) {
                        if (!empty($objMemberParent->member_fullname)) {
                                $len = mb_strlen($objMemberParent->member_fullname);
                                $objMemberParent->member_fullname = mb_substr($objMemberParent->member_fullname, 0, 1) . str_repeat('*', $len - 1);
                        } else {
                                $objMemberParent->member_fullname = '姓名未设置';
                        }
                }
				if($parent_depth<2){
						$objMember->member_mobile = !empty($objMember->member_mobile) ? $objMember->member_mobile : '手机号未设置';
						$objMember->member_fullname = !empty($objMember->member_fullname) ? $objMember->member_fullname : '姓名未设置';
				}
				

                $buddy_list = $this->selectMemberRelationMap($buddy_id,0,10); //调用函数

				$fanghuUrl= $this->createFanghuUrl('Api/GetAppointmentList');
				$time_sign = time();
				$project_appkey = 'test';
			    $project_appsecret = '123456';
				$token = strtoupper(md5($project_appkey.$project_appsecret.$time_sign));

				$fh_params = array(
					'time_sign' => $time_sign,
					'source' => 'fangfull',
					'member_id' => $buddy_id,
					'token' => $token,
					'page_no' => 0,
					'page_size' => 10,
				);
				$fh_data = $this->doPost($fanghuUrl, $fh_params);
 
				$fq_params = array(
					'time_sign' => $time_sign,
					'source' => 'fenquan',
					'member_id' => $buddy_id,
					'token' => $token,
					'page_no' => 0,
					'page_size' => 10,
				);
				$fq_data = $this->doPost($fanghuUrl, $fq_params);

				$zc_params = array(
					'time_sign' => $time_sign,
					'source' => 'zhongchou',
					'member_id' => $buddy_id,
					'token' => $token,
					'page_no' => 0,
					'page_size' => 10,
				);
				$zc_data = $this->doPost($fanghuUrl, $zc_params);
                $arrRender = array(
                    'gShowHeader' => true,
                    'headerTitle' => '小伙伴详情',
                    'childrenlist' => $buddy_list['list'],
					'buddy_total' => $buddy_list['total'],
                    'member' => $objMember,
                    'memberParent' => $objMemberParent,
                    'parent_depth' => $parent_depth,
                    'return_url' => $return_url,
					'friendinvite_url' => $this->createFanghuUrl('member/friendinvite'),
					'recommend_url' => $this->createFanghuUrl('member/recommendbuilding',array('buddy_id'=>$buddy_id)),
					'fh_data' => $fh_data['data']['list'],
					'fh_total' => empty($fh_data['data']['total']) ? 0 : $fh_data['data']['total'],
					'fq_data' => $fq_data['data']['list'],
					'fq_total' => empty($fq_data['data']['total']) ? 0 : $fq_data['data']['total'],
					'zc_data' => $zc_data['data']['list'],
					'zc_total' => empty($zc_data['data']['total']) ? 0 : $zc_data['data']['total'],
					'buddy_id' => $buddy_id,
                );
				$this->smartyRender('buddy/index.tpl', $arrRender);
        }
}
