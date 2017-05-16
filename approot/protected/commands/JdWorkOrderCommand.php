<?php
/**
* 
* xuduorui@xqshijie.cn
* 2016-01-26
*/
class JdWorkOrderCommand  extends CConsoleCommand 
{
    public function init() {
        Yii::import('application.ucentermodels.*');
        Yii::import('application.xqsjadmin.components.*');
    }
    
    /**
    * search jd_borrow, make work order for jd_borrow where jd_borrow.work_order_id==0
    * @param int $limit limit count to make
    */
    public function actionGiveWorkOrder($limit = 0) {
        $arrJdModel = JdBorrow::model()->findAll("work_order_id=0");
        if (!$arrJdModel) {
            echo "no jd_borrow need make work order.\n";
            return false;
        }
        $nAll = count($arrJdModel);
        echo $nAll." jd_borrow need dispatch work order!\n";
        $nSuccess = 0;
        foreach ($arrJdModel as &$jdBorrowModel) {
            $ret = $this->makeWorkOrder($jdBorrowModel);
            $nSuccess += $ret ? 1 : 0;
            if ($nSuccess && ($nSuccess % 20 == 0)) {
                echo "$nSuccess (all=$nAll) work order have been made, go on...\n";
            }
            if ($limit && $nSuccess >= $limit) {
                break;
            }
        }
        echo $nSuccess." work order have been made!\n";
    }
    
    public function makeWorkOrder(&$jdBorrowModel) {
        if (!$jdBorrowModel) {
            return false;
        }
        $customer_id = $jdBorrowModel->borrow_uid;
        $workOrder = JdDataWorkOrder::getNowWorkOrder($customer_id);
        if (!$workOrder) {
            echo "cannot make work order for borrow_id={$jdBorrowModel->borrow_id}, maybe member_id=$customer_id illegal\n";
            return false;
        }
        //$jdBorrowModel->work_order_id = $workOrder->id;
        //if ($jdBorrowModel->status == 1) {
        //    // 如果借贷资料待审核 工单也变成待审核
        //    if ($workOrder->audit_status != JdDataWorkOrder::AUDIT_STATUS_AUDITOK) {
        //        $workOrder->audit_status = JdDataWorkOrder::AUDIT_STATUS_WAITING;
        //    }
        //} else if ($jdBorrowModel->status == 2) {
        //    // 如果是资料审核通过，待借贷审核
        //    $workOrder->audit_status = JdDataWorkOrder::AUDIT_STATUS_AUDITOK;
        //    
        //} else if ($jdBorrowModel->status >= 3 && $jdBorrowModel->status <=8) {
        //    // 如果借贷审核通过 工单也审核通过
        //    $workOrder->audit_status = JdDataWorkOrder::AUDIT_STATUS_AUDITOK;
        //}
        // 分配工单编号
        if (empty($workOrder->sn) && $workOrder->member_company_type) {
            $workOrder->makeSn($workOrder->member_company_type);
            if (!$workOrder->save()) {
                echo "cannot sync work order status: work_order_id=".$workOrder->id." status=".$workOrder->status." borrow_id=".$jdBorrowModel->borrow_id."\n";
            }
        }
        if ($workOrder->member_company_type) {
            // 更新上传的资料，将工单挂在用户资料上
            if ($workOrder->member_company_type==1) {
                $sql = 'update jd_member_data set work_order_id='.$workOrder->id.' where member_id='.$customer_id.' and work_order_id=0';
                $ret = Yii::app()->db->createCommand($sql)->execute();
            }
            else if ($workOrder->member_company_type==2) {
                $sql = 'update jd_company_data set work_order_id='.$workOrder->id.' where member_id='.$customer_id.' and work_order_id=0';
                $ret = Yii::app()->db->createCommand($sql)->execute();
            }
        }
        // 更新借贷表，将工单挂在借贷表上
        $sql = 'update jd_borrow set work_order_id='.$workOrder->id.' where borrow_id='.$jdBorrowModel->borrow_id;
        $query = Yii::app()->db->createCommand($sql);
        $ret = $query->execute();
        if (!$ret) {
            echo "cannot save work order for borrow_id={$jdBorrowModel->borrow_id}, already has work_order_id={$workOrder->id}\n";
            return false;
        }
        return 1;
    }
    
    public function actionCleanWorkOrder() {
        $sql = 'update `jd_borrow` set work_order_id=0';
        $ret = Yii::app()->db->createCommand($sql)->execute();
        if (!$ret) {
            echo $sql.": failed!\n";
        }
        $sql = 'delete from jd_data_work_order';
        $ret = Yii::app()->db->createCommand($sql)->execute();
        if (!$ret) {
            echo $sql.": failed!\n";
        }
    }
}
