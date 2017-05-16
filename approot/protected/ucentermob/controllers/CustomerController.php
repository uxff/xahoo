<?php

/**
 * 个人中心
 */
class CustomerController extends BaseController {

    /**
     * 首页
     * return @void
     */
    public function actionIndex() {
        // check login
        $this->checkLogin();

        // 已登录获取个人信息，展示目前项目个人首页
        $userId = Yii::app()->loginUser->getUserId();
        $arrUserProfile = UCenterStatic::getUserProfile($userId);

        // UCenter回调地址
        $ucenterUrlParams = array(
            'return_url' => $this->createAbsoluteUrl('customer/index'),
        );
        $arrSqlParams = array(
            'condition' => 't.member_id='.$userId.' and description = "签到" and create_time > "'.date('Y-m-d', time()).' 00:00:00"',
        );
        $member_integral = UcMemberPointLog::model()->find($arrSqlParams);

        // render
        $arrRender = array(
            'sign_status' => $member_integral,
            'userProfile' => $arrUserProfile,
            //ucenter url
            'ucenterMyProfileUrl' => $this->createUCenterUrl('profile', $ucenterUrlParams),
            'ucenterMyPointUrl' => $this->createUCenterUrl('point', $ucenterUrlParams),
            'ucenterMyFavoriteUrl' => $this->createUCenterUrl('favorite', $ucenterUrlParams),
            'ucenterMyRewardUrl' => $this->createUCenterUrl('reward', $ucenterUrlParams),
            'ucenterMyTaskUrl' => $this->createUCenterUrl('task', $ucenterUrlParams),
            'ucenterMyHouseUrl' => $this->createUCenterUrl('house', $ucenterUrlParams),
            'ucenterMyBuddyUrl' => $this->createUCenterUrl('buddy', $ucenterUrlParams),
            'ucenterCheckinUrl' => $this->createUCenterUrl('checkin', $ucenterUrlParams),
            'ucenterContactUsUrl' => $this->createUCenterUrl('contactus', $ucenterUrlParams),
            'ucenterShopMallUrl' => $this->createUCenterUrl('shop', $ucenterUrlParams),
        	'ucenterGradeUrl' => $this->createUCenterUrl('grade', $ucenterUrlParams),
            'ucenterMyCapitalUrl' => $this->createUCenterUrl('cash', $ucenterUrlParams),
            //xinqishijie url
            'fqOrderListUrl' => $this->createOtherAppUrl('XqsjmobServerName', 'customer/orderList'),
            'fqCardListUrl' => $this->createOtherAppUrl('XqsjmobServerName', 'customer/cardList'),
            'zcOrderListUrl' => $this->createOtherAppUrl('XqsjZCServerName', 'customer/orderList'),
            'zcRevenueListUrl' => $this->createOtherAppUrl('XqsjZCServerName', 'revenue/list'),
        );

        $this->smartyRender('customer/index.tpl', $arrRender);
    }

    /**
     * 登陆入口页面
     * @return void
     */
    public function actionLogin() {

        $isGuest = Yii::app()->loginUser->getIsGuest();

        // 已登录则跳转到个人中心首页
        if (!$isGuest) {
            $this->redirect($this->createAbsoluteUrl('customer/index'));
        }

        // 未登录跳转到UCenter
        $params = array(
            'return_url' => $_SERVER['HTTP_REFERER'],
        );
        $ucenterLoginUrl = $this->createUCenterUrl('user/login', $params);

        $this->redirect($ucenterLoginUrl);
    }

    /**
     * 跳转到UCenter注册页面
     * @return void
     */
    public function actionRegister() {
        $_mz_utm_source = false;
        if(isset($_GET['_mz_utm_source'])){
            $_mz_utm_source = $this->getInt($_GET['_mz_utm_source']);
        }
        $params = array(
            'return_url' => $_SERVER['HTTP_REFERER'],
            'btnSource' => 50000,
            '_mz_utm_source' => $_mz_utm_source,
        );
        
        $ucenterRegisterUrl = $this->createUCenterUrl('user/register', $params);

        $this->redirect($ucenterRegisterUrl);
    }

    /**
     * 跳转到UCenter登出页面
     * @return void
     */
    public function actionLogout() {

        Yii::app()->loginUser->logoutAndClearStates();

        $this->redirect($this->createAbsoluteUrl('site/index'));
    }

    /**
     * 订单列表
     * @return void
     */
    public function actionOrderList() {
        //check login
        $this->checkLogin();

        //获取参数
        $order_type = $this->getInt($_GET['type']);

        $order_type = !empty($order_type) ? $order_type : 0;

        //取出个人ID
        $customer_id = Yii::app()->loginUser->getUserId();

        switch ($order_type) {
            case 0 :
                $sql = '';
                break;
            case 1 :
                $sql = ' AND t.order_status = 1';
                break;
            case 2 :
                $sql = ' AND t.order_status = 2';
                break;
            case 3 :
                $sql = ' AND ( t.order_status = 100 OR t.order_status = 101 ) ';
                break;
            default :
                $sql = '';
                break;
        }

        $arrSqlParams = array(
            'condition' => 't.customer_id = ' . $customer_id . $sql,
        );

        //全部订单数量
        $queryResult = FqFenquanOrder::model()->published()->count($arrSqlParams);

        //订单列表
        $orderList = $this->_getOrderList($customer_id, $order_type, 1, Yii::app()->params['pageSize']);
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'type' => $order_type,
            'orderList' => $orderList,
            'total' => $queryResult,
            'pageSize' => Yii::app()->params['pageSize'],
        );

        $this->smartyRender('customer/orderlist.tpl', $arrRender);
    }

    /**
     * 产权列表
     * @return void
     */
    public function actionCardList() {
        //check login
        $this->checkLogin();

        //获取参数
        $card_type = empty($_GET['type']) ? 0 : $this->getInt($_GET['type']);
        //取出个人ID
        $customer_id = Yii::app()->loginUser->getUserId();

        //查找关联信息
        $queryCard = FqCard::model()->orderBy('t.card_id DESC')->findAll('customer_id=:customer_id', array('customer_id' => $customer_id));
        $arrCard = !empty($queryCard) ? $this->convertModelToArray($queryCard) : $queryCardToOrder;

        //获取所有卡号ID
        $cardIds = array();
        if (!empty($arrCard)) {
            foreach ($arrCard as $key => $value) {
                $cardIds[] = $value['card_id'];
            }
        }

        $type = array('0', '1', '2', '3');
        if (!in_array($card_type, $type)) {
            $card_type = 0;
        }
        //获取卡片详情
        $arrCardList = $this->_getCardDetails($cardIds, $card_type, 1, Yii::app()->params['pageSize']);

        $total = $arrCardList['total'];
        $arrCard = $arrCardList['cardList'];
        $houseIds = array();
        if (!empty($arrCard)) {
            foreach ($arrCard as $key => $item) {
                $houseIds[] = $item['house_id'];
            }
        }

         //查询房源详情
        $houseIds = array_unique($houseIds);
        (array)$arrHouse = $this->_getHouseDetailByIds($houseIds);

        if (!empty($arrHouse)) {
            foreach ($arrCard as $key => $value) {
                foreach ($arrHouse as $k => $item) {
                    if ($item['house_id'] == $value['house_id']) {
                        $arrCard[$key]['house'] = $item;
                        $arrCard[$key]['house']['house_avg_pricemillion'] = floatval(AresUtil::formatChinesePrice($item['house_avg_price']));
                        $arrCard[$key]['house']['house_area'] = floatval($item['house_area']);
                    }
                }
            }
        }

        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'total' => $total,
            'type' => $card_type,
            'pageSize' => Yii::app()->params['pageSize'],
            'arrCardToHouse' => $arrCard,
        );

        $this->smartyRender('customer/card_list.tpl', $arrRender);
    }

    /**
     * 产权详情
     * @return void
     */
    public function actionCardDetail() {
        //check login
        $this->checkLogin();

        //获取参数
        $card_id = $this->getInt($_GET['card_id']);

        //获取用户ID
        $customer_id = Yii::app()->loginUser->getUserId();

        //判断$card_id是否为空
        if (empty($card_id)) {
            $this->redirect($this->createAbsoluteUrl('site/index'));
        }

        //获取卡信息
        $queryCard = FqCard::model()->findByPk($card_id);
        $cardDetail = !empty($queryCard) ? $this->convertModelToArray($queryCard) : $queryCard;

        //判断$cardDetail是否为空
        if (empty($cardDetail)) {
            $this->redirect($this->createAbsoluteUrl('site/index'));
        }

        //判断卡当前的状态
        if ($cardDetail['card_status'] == 2) {
            $cardDetail['card_status_chinese'] = "已取消";
            $cardDetail['type'] = 2;
        } else {
            if (time() >= strtotime($cardDetail['start_time']) && time() <= strtotime($cardDetail['end_time'])) {
                $cardDetail['card_status_chinese'] = $cardDetail['card_source'] == 1 ? '原始持有' : '交易持有';
                $cardDetail['type'] = 1;
            } else {
                $cardDetail['card_status_chinese'] = "已取消";
                $cardDetail['type'] = 0;
            }
        }

        //认购金额、认购时间
        $cardDetail['order_total'] = AresUtil::formatLocalPrice($cardDetail['card_amount']);

        //获取房源信息
        $arrHouse = $this->_getHouseDetailByIds(array($cardDetail['house_id']));
        $houseDetail = $arrHouse['0'];
        
        $ucenterUrlParams = array(
            'return_url' => $this->createAbsoluteUrl('customer/index'),
		);

        //render
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'cardDetail' => $cardDetail,
            'houseDetail' => $houseDetail,
             'ucenterShopMallUrl' => $this->createUCenterUrl('shop', $ucenterUrlParams),
        );

        $this->smartyRender('customer/card_detail.tpl', $arrRender);
    }

    /**
     * 逸乐通收藏列表
     * @return void
     */
    public function actionMyFavorite() {
        //check login
        $this->checkLogin($this->createAbsoluteUrl('customer/favorite'));

        //取出个人ID
        $customer_id = Yii::app()->loginUser->getUserId();
        //查询所有逸乐通房源信息
        $favorite = UCenterStatic::getFavorite($customer_id, 2, 'fenquan');
        //总数
        $total = count($favorite);
        //收藏列表
        $favoriteList = UCenterStatic::getFavorite($customer_id, 2, 'fenquan', 0, Yii::app()->params['pageSize']);

        $houseList = array();
        if (!empty($favoriteList)) {
            $ids = array();
            foreach ($favoriteList as $key => $item) {
                $ids[] = $item['task_id'];
            }
            $houseList = $this->_getHouseDetailByIds($ids);
        }
        
        //处理价格
        if(!empty($houseList)){
            foreach ($houseList as $key=>&$item){
                $item['house_num_price'] = floatval($item['house_num_price']);
                $item['house_avg_price'] = floatval(AresUtil::formatChinesePrice($item['house_avg_price'],2));
            }
        }

        $return_url  = $this->outPutString($_GET['return_url']);
        $return_url  = !empty($return_url)?$return_url:$this->createUCenterUrl('customer/index');;
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'houseList' => $houseList,
        	'returnUrl' => $return_url,
            'total' => $total,
            'pageSize' => Yii::app()->params['pageSize'],
        );

        $this->smartyRender('customer/myfavorite.tpl', $arrRender);
    }
    
    	/**************************** 易宝绑卡 ****************************/

	public function actionRenZheng(){

		//check login
		$this->checkLogin( $this->createAbsoluteUrl('customer/orderList', array()) );
		//		exit();

		//取出个人ID
		$customer_id = Yii::app()->loginUser->getUserId();
		
		$userbaseinfo = Yii::app()->loginUser->getUserInfo();
		$step = $_REQUEST['step'] == "" ?1:$_REQUEST['step'];


		//检查是否设置了交易密码
		if($step == 1){
			$arrParmas = array('memberIds'=>$customer_id);

			$mmzApi = $this->createUCenterUrl('api/GetUserInfo');

			$mmzResult = $this->doPost($mmzApi, $arrParmas);
				

			$password = $mmzResult['data'][$customer_id]['userinfo']['deal_password'];

			//如果交易密码不为空则转跳到银行卡绑定页面
			if(!empty($password)){
				$this->redirect($this->createAbsoluteUrl('customer/renzheng',array('order_id'=>$_GET['order_id'],'step'=>2)));
				exit();
			}
		}


		$data = array();

		//记录认证前欲购买的项目
		if($_REQUEST['order_id']!=""){
			$_SESSION['order_id'] = $_REQUEST['order_id'];
		}


		//获取银行列表
		$yeepay = new YeepayBase();
		$bank_list = $yeepay->getBankList();


		if( isset($_POST['act'])&&$_POST['act'] == 'do_save'){


			//保存交易密码
			if($step == 2){

				$objMember = UcMember::model()->findByPk(array('member_id' => $customer_id));
AresLogManager::log_bi(array('logKey' => 'test', 'desc' => ' ++++++ renzheng', 'parameters' => $objMember, 'response' => ''));
				$deal_pwd = $this->getString($_POST['pwd']);
					
				//验证原交易与登录密码的一致性，要求交易密码不能等于登录密码
				if (!AresUtil::validatePassword($deal_pwd, $objMember->member_password)) {

					// 调用用户中心API更新用户信息
					$objRestClient = new AresRESTClient();
					$postParams = array(
		            'member_id' => $customer_id,
		            'deal_password' =>AresUtil::encryptPassword(trim($_POST['pwd'])),
					);

                                        AresLogManager::log_bi(array('logKey' => 'test', 'desc' => ' ++++++ client', 'parameters' => $objRestClient, 'response' => ''));
					$restResponse = $objRestClient->doPost($this->createUCenterUrl('api/updateUserInfo'),$postParams);
AresLogManager::log_bi(array('logKey' => 'test', 'desc' => ' ++++++ clientresponse', 'parameters' => $restResponse, 'response' => ''));
						


					$name = $_SESSION['member_fullname'];

					// 判断用户名是否为空
					if (!empty($name)) {
						$maskname = str_repeat('*',mb_strlen($name)-1).mb_substr($name,mb_strlen($name)-1,1);
					} else {
						$maskname = '';
					}
					
					$data['member_fullname'] = $maskname;

					//查询用户历史记录
					$arrSqlConditon = array(
							'condition' => 't.member_id="'.intval($customer_id).' and bind_status=1 "',
					);
					$result = UcTradingPlatform::model()->with('member')->find( $arrSqlConditon );
					$platinfo = OBJTool::convertModelToArray($result);


				}else{

					Yii::app()->loginUser->setFlash('error','为您的账户安全起见，交易密码不能和登录一致');
					$this->redirect($this->createAbsoluteUrl('customer/renzheng',array('order_id'=>$_GET['order_id'],'step'=>1)));
				}

			}

		}

		$arrRender = array(
            'step' => $step,
		    'bank_list'=>$bank_list,
		    'data' => $data,
		    'where'=>$_REQUEST,
		 	'error'=>Yii::app()->loginUser->getFlash('error'),
		    'platinfo'=>$platinfo,
		    'userbaseinfo'=>$userbaseinfo
		);

		$this->smartyRender('customer/renzheng.tpl', $arrRender);

	}

	//确认绑卡
	public function actionBind(){

		//check login
		$this->checkLogin( $this->createAbsoluteUrl('customer/orderList', array()) );
		//		exit();

		//取出个人ID
		$customer_id = Yii::app()->loginUser->getUserId();

		$yeepay = new YeepayBase($customer_id);

		$user = $yeepay->getPlatInfo();


		$maskphone = substr($user['member_mobile'],0,3).'******'.substr($user['member_mobile'],8,3);


		//计算重发短信剩余时间
		$lasttime = Yii::app()->session['yeepay_bind_time'];
		$waittime = 50;
		if($lasttime !=""){

			if(time()-$lasttime<$waittime){
				$lasttime = $waittime - (time()-$lasttime);

			}else{
				$lasttime = 0 ;
			}

		}else{
			Yii::app()->session['yeepay_bind_time'] = time();
			$lasttime = $waittime ;
		}



		$arrRender = array(
            'maskphone' => $maskphone,
		    'where'=>$_REQUEST,
		    'requestid'=>$_REQUEST['requestid'],
		    'lasttime'=>$lasttime,
		    'waittime'=>$waittime
		);

		$this->smartyRender('customer/bind.tpl', $arrRender);

	}
	
}
