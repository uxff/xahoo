<?php

/**
 * 用户中心对外提供接口
 */
class ApiController extends ApiBaseController {

	/**
	 * 提供会员收货地址列表接口
	 * @param  integer	$member_id		会员ID
	 * @param  integer	$page_no		页码
	 * @param  integer	$page_size		每页显示条数
	 */
	public function actionGetAddressList($member_id, $page = 1, $page_size = 30) {
		// 用户ID
		$member_id = $this->getInt($member_id);
		// 查询数据
		$formatedArr = array();
		if ($member_id != 0) {
			Yii::app()->params['pageSize'] = isset($_GET['page_size']) ? $this->getInt($_GET['page_size']) : 10;
			$addressObj = UcMemberAddress::model()->orderBy('t.is_default DESC,t.id DESC')->with('province', 'city', 'county')->pagination($page, $page_size)->findAllByAttributes(array('member_id' => $member_id));
			$formatedArr = $this->convertModelToArray($addressObj);
		}
		// formate
		$this->sendResult($formatedArr);
	}

	/**
	 * 提供添加会员地址接口
	 * @param  integer	$member_id		会员ID
	 */
	public function actionAddAddress() {
		$response = array();
		if (!empty($_POST)) {
			$address = new UcMemberAddress();
			$address->province_id = $this->getInt($_POST['province_id']);
			$address->city_id = $this->getInt($_POST['city_id']);
			$address->county_id = $this->getInt($_POST['county_id']);
			$address->consignee_name = $this->getString($_POST['consignee_name']);
			$address->consignee_mobile = $this->getString($_POST['consignee_mobile']);
			$address->address = $this->getString($_POST['address']);
			$address->member_id = $this->getInt($_POST['member_id']);
			if ($address->insert()) {
				$response['status'] = 'success';
				$addressObj = UcMemberAddress::model()->with('province', 'city', 'county')->findByPk($address->id);
				(array) $addressArr = $this->convertModelToArray($addressObj);
				$response['new_address'] = $addressArr;
			} else {
				$response['status'] = 'fail';
			}
		} else {
			$response['status'] = 'fail';
		}
		$this->sendResult($response);
	}

	/**
	 * 会员身份验证接口  mob
	 * post 传递
	 * @param  integer  $member_id      会员ID
	 * @param  string      $member_fullname   会员真实姓名
	 * @param  string      $member_id_number   会员真实身份征号
	 */
	public function actionMobBindId() {
		$response = array();
		$member_fullname = '';
		$member_id_number = '';
		if (!empty($_POST)) {
			$member_id = $this->getString($_POST['member_id']);
			if (isset($_POST['member_fullname']) && !empty($_POST['member_fullname'])) {
				$member_fullname = $this->getString($_POST['member_fullname']);
			}
			//待加入身份证验证功能
			if (isset($_POST['member_id_number']) && !empty($_POST['member_id_number'])) {
				$member_id_number = $this->getString($_POST['member_id_number']);
			}

			$objMember = UcMember::model()->findByPk($member_id);
			if (!empty($objMember)) {
				$objMember->member_id_number = $member_id_number;
				if ($objMember->member_fullname == '') {
					$objMember->member_fullname = $member_fullname;
				}
				$objMember->is_idnumber_actived = 1;
				if ($objMember->save()) {
					$response['status'] = 'success';
				} else {
					$response['status'] = 'fail';
				}
			} else {
				$response['status'] = 'fail';
			}
		} else {
			$response['status'] = 'fail';
		}


		$this->sendResult($response);
	}

	/**
	 * 更新会员地址接口
	 * @param  integer	$member_id		会员ID
	 */
	public function actionUpdateAddress() {
		$response = array();
		if (!empty($_POST)) {
			$member_id = $this->getInt($_POST['member_id']);
			$id = $this->getInt($_POST['id']);
			$address = UcMemberAddress::model()->findByAttributes(array('member_id' => $member_id, 'id' => $id));
			if (!empty($address)) {
				$address->consignee_name = $this->getString($_POST['consignee_name']);
				$address->consignee_mobile = $this->getString($_POST['consignee_mobile']);
				if ($address->update()) {
					$response['status'] = 'success';
				} else {
					$response['status'] = 'fail';
				}
			} else {
				$response['status'] = 'fail';
			}
		} else {
			$response['status'] = 'fail';
		}

		$this->sendResult($response);
	}

	/**
	 * 会员基础资料修改接口
	 * post 传递会员信息
	 * $_POST['member_id']
	 * $_POST['member_mobile']
	 * $_POST['member_id_number']
	 * $_POST['member_fullname']
	 */
	public function actionUpdateUserInfo() {
		$response = array();

		$member_id = $this->getInt($_POST['member_id']);

		$member = UcMember::model()->findByPk($member_id);
		if (!$member) {
			//判断会员是否存在
			$response['status'] = 'fail';
		} else {
			if (isset($_POST['member_mobile']) && !empty($_POST['member_mobile']) && AresValidator::isValidChineseMobile($this->getString($_POST['member_mobile']))) {
				$member->member_mobile = $this->getString($_POST['member_mobile']);
			}
			if (isset($_POST['member_fullname']) && !empty($_POST['member_fullname'])) {
				$member->member_fullname = $this->getString($_POST['member_fullname']);
			}
			if (isset($_POST['member_id_number']) && !empty($_POST['member_id_number'])) {
				$member->member_id_number = $this->getString($_POST['member_id_number']);
			}
			if (isset($_POST['deal_password']) && !empty($_POST['deal_password'])) {
				$member->deal_password = $this->getString($_POST['deal_password']);
			}

			if ($member->save()) {
				$response['status'] = 'success';
			} else {
				$response['status'] = 'fail';
			}
		}
		$this->sendResult($response);
	}

	//查询用户基本资料
	public function actionGetUserInfo() {
		$ids = !empty($_REQUEST['memberIds']) ? $this->getString($_REQUEST['memberIds']) : '';
		$response = array();
		if (!empty($ids)) {
			// 转换数组
			$arr = explode(',', $ids);
			// 过滤空值
			$arr = array_filter($arr);
			// 把数组元素值转化int
			foreach ($arr as $key => $value) {
				$arr[$key] = $this->getInt($value);
			}

			if (!empty($arr)) {
				$resultObj = UcMember::model()->findAllByPk($arr);
				$resultArr = OBJTool::convertModelToArray($resultObj);
				if ($resultArr) {
					foreach ($resultArr as $key => $item) {
						unset($item['member_password']);
						$item['db_member_mobile'] = $item['member_mobile'];
						$item['db_member_id_number'] = $item['member_id_number'];
						//
						$item['member_mobile'] = substr_replace($item['member_mobile'], '****', 3, 4);
						$item['member_id_number'] = substr_replace($item['member_id_number'], '********', 3, 8);
						if ($item['member_gender'] == 1) {
							$extName = '先生';
						} else if ($item['member_gender'] == 2) {
							$extName = '女士';
						} else {
							$extName = ' 先生/女士';
						}
						$item['display_member_fullname'] = mb_substr($item['member_fullname'],0,1,'utf-8').$extName;
						//
						$item['has_children'] = GlobalVars::model()->getBool($item['has_children']);
						$item['is_newsletter'] = GlobalVars::model()->getBool($item['is_newsletter']);
						$item['is_email_actived'] = GlobalVars::model()->getBool($item['is_email_actived']);
						$item['is_mobile_actived'] = GlobalVars::model()->getBool($item['is_mobile_actived']);
						$item['is_idnumber_actived'] = GlobalVars::model()->getBool($item['is_idnumber_actived']);
						$item['is_actived'] = GlobalVars::model()->getBool($item['is_actived']);
						$item['is_send'] = GlobalVars::model()->getBool($item['is_send']);
						$item['member_gender'] = GlobalVars::model()->memberGender($item['member_gender']);
						//
						$item['member_province'] = !empty($item['member_province']) ? GlobalVars::model()->getProvince($item['member_province']) : '';
						$item['member_city'] = !empty($item['member_city']) ? GlobalVars::model()->getCity($item['member_city']) : '';
						$item['member_district'] = !empty($item['member_district']) ? GlobalVars::model()->getCounty($item['member_district']) : '';
						$item['member_work_province'] = !empty($item['member_work_province']) ? GlobalVars::model()->getProvince($item['member_work_province']) : '';
						$item['member_work_city'] = !empty($item['member_work_city']) ? GlobalVars::model()->getCity($item['member_work_city']) : '';
						$item['member_work_county'] = !empty($item['member_work_county']) ? GlobalVars::model()->getCounty($item['member_work_county']) : '';
						$item['member_company_industry'] = GlobalVars::model()->companyIndustry($item['member_company_industry']);
						$item['member_company_scale'] = GlobalVars::model()->companyScale($item['member_company_scale']);
						$item['member_work_time'] = GlobalVars::model()->memberWorkTime($item['member_work_time']);
						$item['member_work_salary'] = GlobalVars::model()->memberIncome($item['member_work_salary']);
						$item['is_finance_check'] = GlobalVars::model()->getBool($item['is_finance_check']);
						$response[$item['member_id']]['userinfo'] = $item;
					}
				}
			}
		}

		// 获取用户的提现账号
		$queryResultTradingPlatform = UcTradingPlatform::model()->findAll( array('condition' => 't.platform_type=3 AND t.bind_status=1 AND t.member_id IN ('.implode(',', $arr).')') );

		if (!empty($queryResultTradingPlatform)) {
			$arrMemberPlatform = OBJTool::convertModelToArray($queryResultTradingPlatform);
			foreach ($arrMemberPlatform as $key => $item) {
				$platform_type = $item['platform_type'];
				$response[$item['member_id']]['withdrawAccount'][$platform_type][] = $item;
			}
		}
		$response['editUrl'] = $this->createAbsoluteUrl('account/borrowerProfile');

		$this->sendResult($response);
	}


	/**
	 * 会员支付渠道信息查询
	 * post 传递会员信息
	 * $_POST['member_id']
	 * $_POST['member_mobile']
	 */
	public function actionGetPlatInfo() {
		$response = array();
		$member_id = $this->getInt($_POST['member_id']);
		$status = $this->getInt($_POST['status']);

		$condition = array(
			'condition'=>"member_id='{$member_id}' and bind_status='{$status}'"
		);

		$member = UcMember::model()->find($condition);

		$this->sendResult($response);
	}

}
