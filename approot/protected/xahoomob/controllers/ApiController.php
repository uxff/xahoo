<?php

/**
 * ApiController class file
 */
class ApiController extends ApiBaseController {

    public function actionInvite() {
        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']);
        $invite_tel = !isset($_REQUEST['invite_tel']) ? '' : $this->getString($_REQUEST['invite_tel']);
        $invite_id = !isset($_REQUEST['invite_id']) ? '' : $this->getString($_REQUEST['invite_id']);

        MemberInvite::model()->updateAll(array('invite_id' => $invite_id), 'member_id=:member_id and invite_tel=:invite_tel', array(':member_id' => $member_id, ':invite_tel' => $invite_tel));
    }

    public function actionGetAppointmentList() {


        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']);
        $source = !isset($_REQUEST['source']) ? '' : $this->getString($_REQUEST['source']);
        $page_no = !isset($_REQUEST['page_no']) ? 0 : $this->getInt($_REQUEST['page_no']);
        $page_size = !isset($_REQUEST['page_size']) ? 0 : $this->getInt($_REQUEST['page_size']);
        $arrSqlParams = array();

        if ($member_id == 0 && $source != '') {
            $arrSqlParams = array(
                'condition' => 't.source="' . $source . '"',
                'order' => 'id desc',
            );
        }
        if ($member_id != 0 && $source != '') {
            $arrSqlParams = array(
                'condition' => 't.member_id=' . $member_id,
                'order' => 'id desc',
            );
        }
        if ($source != '' && $member_id != 0) {
            $arrSqlParams = array(
                'condition' => 't.member_id=' . $member_id . ' and t.source="' . $source . '"',
                'order' => 'id desc',
            );
        }

        $total = MemberAppointment::model()->count($arrSqlParams);
        if ($page_no == 0 && $page_size == 0) {
            $queryResult = MemberAppointment::model()->with('task_building')->findAll($arrSqlParams);
        } else {
            $queryResult = MemberAppointment::model()->with('task_building')->pagination($page_no, $page_size)->findAll($arrSqlParams);
        }
        $formatedData = $this->convertModelToArray($queryResult);

        $result = array(
            'list' => $formatedData,
            'total' => $total,
        );
        $this->sendResult($result);
    }

    //供我的小伙伴页面调用
    public function actionGetAppointmentInfo() {
        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']);

        $arrSqlParams = array(
            'condition' => 'member_id=' . $member_id,
            'order' => 'id desc',
            'limit' => 1,
        );
        $queryResult = MemberAppointment::model()->find($arrSqlParams);
        if ($queryResult) {
            $formatedData = $this->convertModelToArray($queryResult);
        } else {
            $formatedData = array();
        }
        $this->sendResult($formatedData);
    }

    /*
     * *	分权下单时调用
     * *
     */

    public function actionPlaceOrderByfq() {
        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']);
        $order_id = !isset($_REQUEST['order_id']) ? '' : $this->getInt($_REQUEST['order_id']);
        $order_numberid = !isset($_REQUEST['order_numberid']) ? '' : $this->getString($_REQUEST['order_numberid']);
        $deal_amount = !isset($_REQUEST['deal_amount']) ? 0 : $this->getString($_REQUEST['deal_amount']);
        $item_id = !isset($_REQUEST['item_id']) ? 0 : $this->getInt($_REQUEST['item_id']);
        $item_name = !isset($_REQUEST['item_name']) ? 0 : $this->getString($_REQUEST['item_name']);
        $item_quantity = !isset($_REQUEST['item_quantity']) ? 0 : $this->getInt($_REQUEST['item_quantity']);

        $taskBuilding = TaskBuilding::model()->find('building_id=:item_id and project=3', array('item_id' => $item_id));

        if (!empty($taskBuilding)) {
            //file_put_contents('sli.log', $item_id);
            $memberAppointment = new MemberAppointment();
            $memberAppointment->member_id = $member_id;
            $memberAppointment->task_building_id = $taskBuilding->task_id;
            $memberAppointment->source = 'fenquan';
            $memberAppointment->status = 3;
            $memberAppointment->deal_amount = $deal_amount;
            $memberAppointment->order_id = $order_id;
            $memberAppointment->order_numberid = $order_numberid;
            $memberAppointment->item_id = $item_id;
            $memberAppointment->item_name = $item_name;
            $memberAppointment->item_quantity = $item_quantity;
            $memberAppointment->statusdate3 = date('Y-m-d', time());
            $memberAppointment->create_time = date('Y-m-d H:i:s', time());
            $memberAppointment->last_modified = date('Y-m-d H:i:s', time());
            if ($memberAppointment->save()) {
                $status = 'success';
                $message = '下单成功';
            } else {
                $status = 'fail';
                $message = '下单失败';
            }
        } else {

            $status = 'fail';
            $message = '不是推广房源';
        }

        $result = array(
            'status' => $status,
            'message' => $message,
        );
        $this->sendResult($result);
    }

    /*
     * *	分权修改订单时调用
     * *
     */

    public function actionUpdateOrderByfq() {
        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']);
        $order_id = !isset($_REQUEST['order_id']) ? '' : $this->getInt($_REQUEST['order_id']);
        $item_id = !isset($_REQUEST['item_id']) ? 0 : $this->getInt($_REQUEST['item_id']);
        $deal_amount = !isset($_REQUEST['deal_amount']) ? 0 : $this->getString($_REQUEST['deal_amount']);
        $item_quantity = !isset($_REQUEST['item_quantity']) ? 0 : $this->getInt($_REQUEST['item_quantity']);

        $taskBuilding = TaskBuilding::model()->find('building_id=:item_id and project=3', array('item_id' => $item_id));

        if (!empty($taskBuilding)) {
            //file_put_contents('sli.log', $item_id);
            $memberAppointment = MemberAppointment::model()->find('member_id=:member_id and order_id=:order_id and item_id=:item_id and source="fenquan"', array('member_id' => $member_id, 'order_id' => $order_id, 'item_id' => $item_id));
            $memberAppointment->deal_amount = $deal_amount;
            $memberAppointment->item_quantity = $item_quantity;
            $memberAppointment->statusdate3 = date('Y-m-d', time());
            $memberAppointment->last_modified = date('Y-m-d H:i:s', time());
            if ($memberAppointment->save()) {
                $status = 'success';
                $message = '修改订单成功';
            } else {
                $status = 'fail';
                $message = '修改订单失败';
            }
        } else {

            $status = 'fail';
            $message = '不是推广房源';
        }

        $result = array(
            'status' => $status,
            'message' => $message,
        );
        $this->sendResult($result);
    }

    /*
     * *	分权支付时调用
     * *
     */

    public function actionOrderPaymentByfq() {
        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']); //会员id
        $item_id = !isset($_REQUEST['item_id']) ? 0 : $this->getInt($_REQUEST['item_id']); //项目id
        $item_name = !isset($_REQUEST['item_name']) ? 0 : $this->getString($_REQUEST['item_name']); //项目名称
        $order_id = !isset($_REQUEST['order_id']) ? '' : $this->getString($_REQUEST['order_id']); //订单id
        $order_numberid = !isset($_REQUEST['order_numberid']) ? '' : $this->getString($_REQUEST['order_numberid']); //订单编号
        $deal_amount = !isset($_REQUEST['deal_amount']) ? '' : $this->getString($_REQUEST['deal_amount']); //成交金额
        //给自己添加积分和贡献
        UCenterStatic::addPointByfq($member_id, $deal_amount, $order_id, $order_numberid, $item_id, $item_name);

        $taskBuilding = TaskBuilding::model()->find('building_id=:item_id and project=3', array('item_id' => $item_id));
        if (!empty($taskBuilding)) {
            $objMemberAppointment = MemberAppointment::model()->find("member_id=:member_id and order_id=:order_id and source='fenquan'", array('member_id' => $member_id, 'order_id' => $order_id));
            if (!empty($objMemberAppointment)) {
                $objMemberAppointment->status = 4;
                $objMemberAppointment->statusdate4 = date('Y-m-d', time());
                $objMemberAppointment->last_modified = date('Y-m-d H:i:s', time());
                if ($objMemberAppointment->save()) {
                    //$task_id = $objMemberAppointment->task_building_id;
                    //给小伙伴添加佣金和贡献
                    //file_put_contents('sli.log', $task_id);
                    UCenterStatic::addRewardByfq($member_id, $item_id, $item_name, $order_id, $order_numberid, $deal_amount);
                    $status = 'success';
                    $message = '更改成功';
                } else {
                    $status = 'fail';
                    $message = '更改失败';
                }
            }
        } else {
            $status = 'fail';
            $message = '不是推广房源';
        }
        $result = array(
            'status' => $status,
            'message' => $message,
        );
        $this->sendResult($result);
    }

    /*
     * *	众筹支付时调用
     * *
     */

    public function actionOrderPaymentByzc() {
        $member_id = !isset($_REQUEST['member_id']) ? 0 : $this->getInt($_REQUEST['member_id']); //会员id
        $item_id = !isset($_REQUEST['item_id']) ? 0 : $this->getInt($_REQUEST['item_id']); //项目id
        $item_name = !isset($_REQUEST['item_name']) ? 0 : $this->getString($_REQUEST['item_name']); //项目名称
        $order_id = !isset($_REQUEST['order_id']) ? '' : $this->getString($_REQUEST['order_id']); //订单id
        $order_numberid = !isset($_REQUEST['order_numberid']) ? '' : $this->getString($_REQUEST['order_numberid']); //订单编号
        $deal_amount = !isset($_REQUEST['deal_amount']) ? '' : $this->getString($_REQUEST['deal_amount']); //成交金额
        //给自己添加积分(冻结)和贡献
        UCenterStatic::addPointByzc($member_id, $deal_amount, $order_id, $order_numberid, $item_id, $item_name);

        $taskBuilding = TaskBuilding::model()->find('building_id=:item_id and project=2', array('item_id' => $item_id));
        if (!empty($taskBuilding)) {
            //如果支付金额大于五万才能给小伙伴分配佣金和贡献
            if ($deal_amount >= 50000) {
                $memberAppointment = new MemberAppointment();
                $memberAppointment->member_id = $member_id;
                $memberAppointment->task_building_id = $taskBuilding->task_id;
                $memberAppointment->source = 'zhongchou';
                $memberAppointment->status = 3;
                $memberAppointment->deal_amount = $deal_amount;
                $memberAppointment->order_id = $order_id;
                $memberAppointment->order_numberid = $order_numberid;
                $memberAppointment->item_id = $item_id;
                $memberAppointment->item_name = $item_name;
                $memberAppointment->statusdate3 = date('Y-m-d', time());
                $memberAppointment->create_time = date('Y-m-d H:i:s', time());
                $memberAppointment->last_modified = date('Y-m-d H:i:s', time());
                if ($memberAppointment->save()) {
                    //$task_id = $objMemberAppointment->task_building_id;
                    //给小伙伴添加佣金(等待结算)和贡献
                    //UCenterStatic::addRewardByzc($member_id, $item_id, $item_name, $order_id, $order_numberid, $deal_amount);
                    $status = 'success';
                    $message = '更改成功';
                } else {
                    $status = 'fail';
                    $message = '更改失败';
                }
            }
        } else {
            $status = 'fail';
            $message = '不是推广房源';
        }
        $result = array(
            'status' => $status,
            'message' => $message,
        );
        $this->sendResult($result);
    }

    /*
     * * 供房乎房否调用更改状态
     * @param  integer	$id				主键id
     * @param  integer	$order_id		订单ID（签约状态时需要）
     * @param  string	$deal_amount	成交总额（签约状态时需要）
     * @param  string	$statusdate		状态时间
     * @param  integer	$status			1|预约,2|到访,3|签约,4|成交
     * @param  string	$token			strtoupper(md5($appkey . $appsecret . $time_sign))
     * @param  string	$source			来源 房乎:fangfull 
     * @param  string	$time_sign		时间标识
     */

    public function actionChangeOrderStatus() {
        $id = !isset($_REQUEST['id']) ? 0 : $this->getString($_REQUEST['id']);
        $status = !isset($_REQUEST['status']) ? 0 : $this->getString($_REQUEST['status']);
        $statusdate = !isset($_REQUEST['statusdate']) ? 0 : $this->getString($_REQUEST['statusdate']);
        $deal_amount = !isset($_REQUEST['deal_amount']) ? 0 : $this->getString($_REQUEST['deal_amount']);
        $order_id = !isset($_REQUEST['order_id']) ? '' : $this->getString($_REQUEST['order_id']);
        $order_numberid = !isset($_REQUEST['order_numberid']) ? '' : $this->getString($_REQUEST['order_numberid']);
        $source = !isset($_REQUEST['source']) ? '' : $this->getString($_REQUEST['source']);
        $objMemberAppointment = MemberAppointment::model()->findByPk($id);
        $objMemberAppointment->status = $status;

        switch ($status) {
            case 1:
                $objMemberAppointment->statusdate1 = $statusdate;
                break;
            case 2:
                $objMemberAppointment->statusdate2 = $statusdate;
                break;
            case 3:
                $objMemberAppointment->order_id = $order_id;
                $objMemberAppointment->deal_amount = $deal_amount;
                $objMemberAppointment->statusdate3 = $statusdate;
                break;
            case 4:
                $objMemberAppointment->statusdate4 = $statusdate;
                break;
        }
        $objMemberAppointment->last_modified = date('Y-m-d H:i:s', time());
        if ($objMemberAppointment->save()) {
            $member_id = $objMemberAppointment->member_id;
            $task_id = $objMemberAppointment->task_building_id;
            $source = $objMemberAppointment->source;
            $order_id = $objMemberAppointment->order_id;
            if ($status == 3) {
                UCenterStatic::setReward($member_id, '', $task_id, $order_id, $order_numberid, $deal_amount, $source);
            }
            if ($status == 4) {
                //分配佣金
                UCenterStatic::addReward($member_id, $order_id, $source);

                //添加积分
                UCenterStatic::setPoint($member_id, 'order', $source, $objMemberAppointment->deal_amount, $order_id, $order_numberid);
            }
            $status = 'success';
            $message = '更改成功';
        } else {
            $status = 'fail';
            $message = '更改失败';
        }

        $result = array(
            'status' => $status,
            'message' => $message,
        );
        $this->sendResult($result);
    }

    /**
     * 根据根据项目IDs, 返回相关信息
     *
     * @param  string $ids 每页大小
     * @return array        热推项目
     */
    public function actionGetProjectDetailByIds($ids = '') {
        $ids = $this->getString($ids);
        // 获取项目ID数组
        $arrProjectIds = explode(',', $ids);
        // 获取信息
        if (!empty($arrProjectIds)) {
            $arrSqlParams = array(
                'condition' => 't.task_id IN (' . implode(',', $arrProjectIds) . ')',
                'order' => 'field(t.task_id, ' . implode(',', $arrProjectIds) . ')', //按照in子句中顺序来排列
            );
        }
        $queryResult = TaskBuilding::model()->findAll($arrSqlParams);
        $arrProject = $this->convertModelToArray($queryResult);

        $formatedResult = array(
            'list' => $arrProject,
            'total' => count($arrProject),
        );
        // sendResult
        $this->sendResult($formatedResult);
    }

    /**
     * 根据热推房乎项目
     *
     * @param  integer $num 每页大小
     * @return array        热推项目
     */
    public function actionGetHotProject($num = 4) {
        $num = $this->getInt($num);

        // 获取热推项目
        $arrSqlParamsHot = array(
            'condition' => 'flag =2',
            'limit' => $num
        );
        $queryResult = TaskBuilding::model()->published()->orderBy('t.task_id DESC')->pagination(1, $num)->findAll($arrSqlParamsHot);
        $arrTaskBuilding = $this->convertModelToArray($queryResult);

        // 项目房源id
        $arrTaskIds = array();
        if (!empty($arrTaskBuilding)) {
            foreach ($arrTaskBuilding as $key => $item) {
                $arrTaskIds[] = $item['task_id'];
            }
        }
        // 不足使用最新项目补充
        $arrLatestTask = array();
        if (count($arrTaskIds) < $num) {
            $arrSqlParamsLastest = array();
            if (count($arrTaskIds) > 0) {
                $arrSqlParamsLastest = array(
                    'condition' => 't.task_id NOT IN (' . implode(',', $arrTaskIds) . ')',
                );
            }
            $queryResultLastest = TaskBuilding::model()->published()->orderBy('t.task_id DESC')->pagination(1, intval($num - count($arrTaskIds)))->findAll($arrSqlParamsLastest);
            $arrLatestTask = $this->convertModelToArray($queryResultLastest);
        }

        // url填充
        $arrAllTask = array_merge($arrTaskBuilding, $arrLatestTask);
        // result
        $formatedResult = array(
            'list' => $arrAllTask,
            'total' => $num,
        );

        // sendResult
        $this->sendResult($formatedResult);
    }

}
