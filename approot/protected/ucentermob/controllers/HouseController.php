<?php

/**
 * house
 */
class HouseController extends BaseController {

    /**
     * 房源列表
     * return @void
     */
    public function actionList() {

        $arrHouse = $this->_getHouseList(1, Yii::app()->params['pageSize']);

        //总数
        $total = $arrHouse['total'];
        $formatedArr = $this->_getHouseDetailByIds($arrHouse['allHouseList']);

        if (!empty($formatedArr)) {
            foreach ($formatedArr as $key => &$value) {
                $value['house_avg_price'] = AresUtil::formatChinesePrice($value['house_avg_price'], 2);
            }
        }

        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'total' => $total,
            'pageSize' => Yii::app()->params['pageSize'],
            'list' => $formatedArr,
        );

        $this->smartyRender('house/list.tpl', $arrRender);
    }

    /**
     * 房源详情
     * return @void
     */
    public function actionDetail() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        $customer_id = Yii::app()->loginUser->getIsGuest() ? 0 : Yii::app()->loginUser->getUserId();

        // 获取房源信息
        $arrHouseList = $this->_getHouseDetailByIds(array($house_id), $customer_id);
        $houseDetail = $arrHouseList[0];

        //判断房源是否存在
        if (empty($houseDetail)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }
        //格式化房源价格
        $houseDetail['house_avg_price'] = AresUtil::formatChinesePrice($houseDetail['house_avg_price'], 2);
        $houseDetail['price_total'] = AresApiUtil::formatChinesePrice($houseDetail['price_total']);

        //获取房源属性
        $houseAttributes = $this->_getHouseAttributes($house_id);

        //获取开发商信息
        if (!empty($houseDetail['estate_agent_id'])) {
            $queryResultEstateAgent = FqEstateAgent::model()->published()->findByPk($houseDetail['estate_agent_id']);
            $estateAgent = $this->convertModelToArray($queryResultEstateAgent);
        }

        //获取资产管理方
        if (!empty($houseDetail['company_id'])) {
            $queryResultAssetCompany = FqFenquanCompany::model()->published()->findByPk($houseDetail['company_id']);
            $assetCompany = $this->convertModelToArray($queryResultAssetCompany);
        }

        //获取收藏信息
        $isFavorite = UCenterStatic::CheckFavorite($customer_id, 2, $houseDetail['house_id'], 'fenquan');
   
        //获取销售代理公司
        $arrSqlParams = array(
            'condition' => 't.house_id='.$house_id,
        );
        $totalCompany = FqHouseToBrokerToCompany::model()->published()->count($arrSqlParams);
        
        //处理返回跳转url，presell返回首页，list返回列表页
        $urlReferrer=Yii::app()->request->urlReferrer;
        $urlReferrerArr=parse_url($urlReferrer);
        if($urlReferrerArr['query']=="r=house/list"){$urlReferrer="list";} elseif($urlReferrerArr['query']==""){$urlReferrer="index";} else {$urlReferrer="preSell";}

        //处理购买状态按钮显示
        if($houseDetail['card_type']=="4" && $ast<=$nowtime && $aet>=$nowtime ){
            $sellstatus=1;//显示“立即抢购”和“我要预约”按钮
        } elseif($houseDetail['card_type']=="4" && $ast>$nowtime){
            $sellstatus=2;//显示“即将开放”按钮
        } elseif($houseDetail['card_type']=="4" && $aet<$nowtime){
            $sellstatus=3;//显示“认购结束”按钮
        } elseif($houseDetail['card_type']!="4" && $st<=$nowtime && $et>=$nowtime){
            $sellstatus=1;//显示“立即抢购”和“我要预约”按钮
        } elseif($houseDetail['card_type']!="4" && $st>$nowtime ){
            $sellstatus=2;//显示“即将开放”按钮
        } elseif($houseDetail['card_type']!="4" && $et<$nowtime){
            $sellstatus=3;//显示“认购结束”按钮
        } else {
            $sellstatus=3;//默认认购结束
        }
        
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'houseDetail' => $houseDetail,
            'sellstatus'=>$sellstatus,//预购按钮状态
            'attributes' => $houseAttributes,
            'assetCompany' => $assetCompany,
            'estateAgent' => $estateAgent,
            'isFavorite' => $isFavorite,
            'hasSaleCompany' => ($totalCompany > 0) ? true : false,
            'customer_id' => $customer_id,
            'urlReferrer'=>$urlReferrer
        );
        
        $this->smartyRender('house/detail.tpl', $arrRender);
    }

    /**
     * 房源相册
     * return @void
     */
    public function actionPhotos() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        // 获取房源信息
        $arrHouseList = $this->_getHouseDetailByIds(array($house_id));
        $houseDetail = $arrHouseList[0];

        //判断房源是否存在
        if (empty($houseDetail)) {
            $this->redirect($this->createAbsoluteUrl('site/index'));
        }

        //判断相册是否有图片
        if (empty($houseDetail['pictures'])) {
            $this->redirect($this->createAbsoluteUrl('house/detail', array('house_id' => $house_id)));
        }

        $arrPhotos = array();
        foreach ($houseDetail['pictures'] as $key => $item) {
            $arrPhotos[] = array(
                'width' => '320',
                'height' => '410',
                'content' => $item['picture_url'],
            );
        }

        $arrPhotos = json_encode($arrPhotos);

        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => false,
            'arrPhotos' => $arrPhotos,
        );

        $this->smartyRender('house/photos.tpl', $arrRender);
    }

    /**
     * 房源简介
     * return @void
     */
    public function actionIntroduction() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        // 获取房源信息
        $arrHouseList = $this->_getHouseDetailByIds(array($house_id));
        $houseDetail = $arrHouseList[0];

        //判断房源是否存在
        if (empty($houseDetail)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }
        //格式化房源价格
        $houseDetail['house_avg_price'] = floatval(AresUtil::formatChinesePrice($houseDetail['house_avg_price'], 2));
        $houseDetail['price_total'] = floatval(AresApiUtil::formatChinesePrice($houseDetail['price_total']));

        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'houseDetail' => $houseDetail,
        );

        $this->smartyRender('house/introduction.tpl', $arrRender);
    }

    /**
     * 资产管理方
     * return @void
     */
    public function actionAssetCompany() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        // 获取房源信息
        $arrHouseList = $this->_getHouseDetailByIds(array($house_id));
        $houseDetail = $arrHouseList[0];

        //判断房源是否存在
        if (empty($houseDetail)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        $houseDetail['house_avg_price'] = floatval(AresUtil::formatChinesePrice($houseDetail['house_avg_price'], 2));
        $houseDetail['price_total'] = floatval(AresApiUtil::formatChinesePrice($houseDetail['price_total']));

        //获取资产管理方
        $Company = array();
        if (!empty($houseDetail)) {
            $queryResultAssetCompany = FqFenquanCompany::model()->published()->findByPk($houseDetail['company_id']);
            $assetCompany = $this->convertModelToArray($queryResultAssetCompany);
        }

        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'houseDetail' => $houseDetail,
            'assetCompany' => $assetCompany,
        );

        $this->smartyRender('house/assetcompany.tpl', $arrRender);
    }

    /**
     * 认购权益信息
     * return @void
     */
    public function actionPurchaseRights() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        //NOTE: 目前尚未根据房源区逸乐通益，因而写死为0
        $arrSqlParams = array(
            'condition' => 't.house_id=0',
        );
        //获取认购权益
        $queryResultInterests = FqFenquanInterests::model()->published()->findAll($arrSqlParams);
        $arrPurchaseRights = $this->convertModelToArray($queryResultInterests);
        $purchaseRights = $arrPurchaseRights[0];

        // UCenter回调地址
        $ucenterUrlParams = array(
            'return_url' => $this->createAbsoluteUrl('customer/index'),
        );
        $ucenterShopMallUrl = $this->createUCenterUrl('shop', $ucenterUrlParams);
        
        $purchaseRights['revenue_desc'] = str_replace('http://{$ucenterShopMallUrl}', $ucenterShopMallUrl, $purchaseRights['revenue_desc']);
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'purchaseRights' => $purchaseRights,
        );

        $this->smartyRender('house/purchaserights.tpl', $arrRender);
    }

    /**
     * 合同公示列表
     * return @void
     */
    public function actionContractList() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        //获取合同公示
        $arrSqlParams = array(
            'condition' => 't.house_id=' . $house_id,
        );
        $queryResultContract = FqFenquanContract::model()->published()->findAll($arrSqlParams);
        $arrResultContract = $this->convertModelToArray($queryResultContract);

        //定义公示类型
        $type = array('1' => '认购合同', '2' => '委托协议', '3' => '服务协议', '4' => '转让协议');
        $arrContract = array();
        if (!empty($arrResultContract)) {
            foreach ($arrResultContract as $key => $value) {
                $arrContract[] = array(
                    'contract_id' => $value['contract_id'],
                    'type_name' => $type[$value['type']],
                );
            }
        }

        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'arrContract' => $arrContract,
        );


        //NOTE: 合同不足，跳转到认购合同中
        $this->redirect($this->createAbsoluteUrl('house/contractDetail', array('house_id' => $house_id, 'contract_id' => '9999999')));
        //$this->smartyRender('house/contractlist.tpl', $arrRender);
    }

    /**
     * 合同公示详情
     * return @void
     */
    public function actionContractDetail() {

        //获取参数
        $contract_id = $this->getInt($_GET['contract_id']);
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id) || empty($contract_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        //获取合同公示
        $arrSqlParams = array(
            'condition' => 't.house_id=0 and t.contract_id =1',
        );
        
        $queryResultContract = FqFenquanContract::model()->published()->findAll($arrSqlParams);
        
        if (!empty($queryResultContract)) {
            $arrContract = $this->convertModelToArray($queryResultContract);
            $contractDetail = $arrContract[0];
        } else {
            $contractDetail = array();
        }


        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'contractDetail' => $contractDetail,
        );

        $this->smartyRender('house/contractdetail.tpl', $arrRender);
    }

    /**
     * 认购记录
     * return @void
     */
    public function actionOrderList() {
        //获取参数
        $house_id = $this->getInt($_GET['house_id']);

        //判断是否为空
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        // 获取房源信息
        $arrHouseList = $this->_getHouseDetailByIds(array($house_id));
        $houseDetail = $arrHouseList[0];

        //判断房源是否存在
        if (empty($houseDetail)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }
        //格式化房源价格
        $houseDetail['house_avg_price'] = floatval(AresUtil::formatChinesePrice($houseDetail['house_avg_price'], 2));
        $houseDetail['price_total'] = AresApiUtil::formatChinesePrice($houseDetail['price_total']);
        
        //查询认购记录
        $arrSqlParams = array(
            'condition' => 't.item_id=' . $house_id . ' AND  order_status=2',
        );
        //逸乐通订单
        $queryResult = FqFenquanOrder::model()->orderBy()->findAll($arrSqlParams);
        $arrOrderList = !empty($queryResult) ? $this->convertModelToArray($queryResult) : array();

        //虚拟订单
        $fakeOrderObj = FqFenquanFakeOrder::model()->findAllByAttributes(array('item_id' => $houseDetail['house_id']));
        $fakeOrderArr = !empty($fakeOrderObj) ? $this->convertModelToArray($fakeOrderObj) : array();
        

        // 认购结束后执行是否生成虚拟订单
        if ($houseDetail['is_sell'] == 2 && empty($fakeOrderArr)) {
            // 总份数
            $house_total_num = $houseDetail['house_total_num'];
            // 实际订单份数
            $tmpOrderResult = $this->_getOrderInfoByIds(array($houseDetail['house_id']));
            $order_item_total = intval($tmpOrderResult[$houseDetail['house_id']]['item_total']);
            // 实际剩余份数
            $fake_order_count = ($house_total_num > $order_item_total) ? ($house_total_num - $order_item_total) : 0;

            if ($fake_order_count > 0) {
                // 找出最后一次下单的时间
                $start_time = !empty($arrOrderList) ? $arrOrderList[0]['create_time'] : $houseDetail['start_time'] . ' 00:00:00';
                $end_time = $houseDetail['end_time'] . ' 00:00:00';
                $price = $houseDetail['house_price'] / $houseDetail['total_fenquan'];
                // 生成虚拟订单
                $fakeOrderArr = $this->_generateFakeOrders($start_time, $end_time, $fake_order_count, $houseDetail['house_id'], $price);
            }
        }

        $arrOrderList = array_merge($arrOrderList, $fakeOrderArr);

        uasort($arrOrderList, create_function('$a, $b', 'return $a["create_time"]<$b["create_time"];'));

        $arrOrderList = array_values($arrOrderList);

        if (!empty($arrOrderList)) {
            foreach ($arrOrderList as $key => &$value) {
                $value['order_total'] = floatval($value['order_total']);
                // 格式化姓名
                $value['cusomter_name'] = AresUtil::formatChineseName($value['cusomter_name']);
            }
        }

        // render
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            'house_id' => $house_id,
            'houseDetail' => $houseDetail,
            'orderList' => $arrOrderList,
        );

        $this->smartyRender('house/orderlist.tpl', $arrRender);
    }

    /**
     * 
     * 下单页面
     * return @void
     */
    public function actionPlaceOrder() {
        //获取参数
        $house_id = $this->getString($_GET['house_id']);


        /**
         * 验证参数有效性
         */
        // 判断该房源是否存在
        if (empty($house_id)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        // 获取房源详情
        $arrHouseList = $this->_getHouseDetailByIds(array($house_id));
        $houseDetail = $arrHouseList[0];


        // 判断房源是否存在
        if (empty($houseDetail)) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }
        //格式化价格
        $houseDetail['house_price'] = AresUtil::formatLocalPrice($houseDetail['house_price']);
        $houseDetail['house_local_price'] = AresUtil::formatLocalPrice($houseDetail['house_avg_price']);

        /**
         * check login，
         */
        // 未登录跳转到UCenter，通过回调跳回页面
        $return_url = $this->createAbsoluteUrl('house/placeOrder', array('house_id' => $house_id));
        $this->checkLogin($return_url);

        // 查找用户信息
        $customer_id = Yii::app()->loginUser->getUserId();
        $params = array(
            'member_id' => $customer_id,
        );
        //地址信息
        $curl = new AresRESTClient();
        $data = $curl->doPost($this->createUCenterUrl('api/getAddressList', $params));
        $arrAddress = json_decode($data, true);

        $addressDetail = $arrAddress['data'];

        $customerProfile = UCenterStatic::getUserProfile($customer_id);

        // 2015-03-21 12:31   author:zhaoting 判断是否添加过订单  使用前面下单的默认 姓名和身份证
        $disabled = '';
        if (empty($customerProfile['userProfile']['member_fullname']) || empty($customerProfile['userProfile']['member_id_number'])) {
            //$frontedOrder = "";
            $queryFqOrder = FqFenquanOrder::model()->published()->orderBy()->recently(1)->find("customer_id=:customer_id", array('customer_id' => $customer_id));
            if (!empty($queryFqOrder)) {
                $frontedOrder = $queryFqOrder;
            } else {
                $queryZcOrder = ZcOrder::model()->published()->orderBy()->recently(1)->find("customer_id=:customer_id", array('customer_id' => $customer_id));
                if (!empty($queryZcOrder)) {
                    $frontedOrder = $queryZcOrder;
                }
            }
            if (!empty($frontedOrder)) {
                $disabled = 'readonly';
                //优先使用个人资料中的信息
                if (!empty($customerProfile['userProfile']['member_fullname'])) {
                    $frontedOrder->cusomter_name = $customerProfile['userProfile']['member_fullname'];
                }

                if (!empty($customerProfile['userProfile']['member_id_number'])) {
                    $frontedOrder->cusomter_identity_id = $customerProfile['userProfile']['member_id_number'];
                }
            }
        }

        //判断房源的认购时间
        $startTime = strtotime($houseDetail['start_time']);
        $endTime = strtotime($houseDetail['end_time']);
        $nowTime = time();
        if ($nowTime < $startTime || $nowTime > $endTime) {
            $this->redirect($this->createAbsoluteUrl('house/list'));
        }

        //查询房源持有期限
        $holdingPeriodId = Yii::app()->params['houseAttrId']['holding_period_id'];
        $queryHoldingPeriod = FqHouseToAttributes::model()->findAll("house_id=:house_id AND attribute_id=:attribute_id", array('house_id' => $houseDetail['house_id'], 'attribute_id' => $holdingPeriodId));
        $arrHoldingPeriod = $this->convertModelToArray($queryHoldingPeriod);

        $houseDetail['holding_period'] = $arrHoldingPeriod['0']['attribute_value'];

        //查找城市信息
        $queryProvince = SysRegion::model()->published()->findAll('parent_id=:parent_id', array('parent_id' => '0'));
        $arrProvince = $this->convertModelToArray($queryProvince);

        //预留时间长度
        $orderOvertimeHours = !empty(Yii::app()->params['OrderOvertimeHours']) ? Yii::app()->params['OrderOvertimeHours'] : 1;
        $arrTimeMsg = $this->_getSurplusActiveTime($orderOvertimeHours);
        
        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => false,
            'house_id' => $house_id,
            'customer_id' => $customer_id,
            'houseDetail' => $houseDetail,
            'addressDetail' => $addressDetail,
            'customerProfile' => $customerProfile,
            'arrProvince' => $arrProvince,
            'arrHoldingPeriod' => $arrHoldingPeriod,
            'frontedOrder' => $frontedOrder,
            'error'=>Yii::app()->loginUser->getFlash('error'),
            'error_code'=>Yii::app()->loginUser->getFlash('error_code'),
            'disabled' => $disabled,
            'arrTimeMsg'=>$arrTimeMsg,
            'orderOvertimeHours'=>$orderOvertimeHours,
        );

        $this->smartyRender('house/placeorder.tpl', $arrRender);
    }

}
