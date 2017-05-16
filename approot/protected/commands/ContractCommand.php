<?php
/**
* 
* xuduorui@qianjins.com
* 2015-11-03
*/
class ContractCommand  extends CConsoleCommand 
{
    private $c;
    public function init() {
        $this->c = Yii::app()->getModule('contract');
    }
    
    /**
    * welcome
    * 
    * @param mixed $args
    */
    public function actionWelcome($args)
    {   

       $cModule = Yii::app()->getModule('contract');
       $result = $cModule->getObj(array())->welcome();
       echo 'job done!';
    }
    
    /**
    * get template, before replace keywords
    * 
    * @param mixed $args
    */
    public function actionGetTpl($order_id=999)
    {
       $obj = $this->c->getOrderObj($order_id);
       
       $ret = $obj->houseContract->contracts[0]->getTemplate();
       $ret = iconv('utf-8', 'gbk', $ret);
       print_r($ret);
       echo 'job done!';
    }
    
    /**
    * get output , after replace keywords
    * 
    * @param mixed $args
    */
    public function actionGetOut($order_id=999)
    {
       $obj = $this->c->getOrderObj($order_id);
       
       $ret = '';
       if ($obj) {
           foreach ($obj->houseContract->contracts as $contract)
            $ret .= $contract->getContractText();
       } else {
           echo 'no obj ';
       }
       $ret = iconv('utf-8', 'gbk', $ret);
       print_r($ret);
       echo 'job done!';
    }
    
    /**
    * get output , after replace keywords
    * 
    * @param mixed $args
    */
    public function actionOrder($order_id=999)
    {
        
        $obj = $this->c->getOrderObj($order_id);
        //$data = $obj->houseContract->contracts[0]->getTemplate();
        if (!$obj->houseContract) {
            echo 'none houseContract obj!';
        }
        $arr = $obj->houseContract->contracts;
        foreach ($arr as $o) {
            $str = "[tpl_id={$o->id}][tpl_name={$o->name}]===========>\n";
            $data = $o->getContractText();
            if (in_array(PHP_OS, array('windows', 'WINNT'))) {
                $str = iconv('utf-8', 'gbk', $str);
                $data = iconv('utf-8', 'gbk', $data);
            }
            echo $str;
            print_r($data);
            echo "\n";
        }
        echo 'job done!';
    }
    
    /**
    * get output , after replace keywords
    * 
    * @param mixed $args
    */
    public function actionReview($id=999, $task='tpl')
    {
        //$obj = $this->c->getOrderObj($order_id);
        //$data = $obj->houseContract->contracts[0]->getTemplate();
        $uid = 20;
        if ($task=='tpl') {
            //$data = $obj->houseContract->contracts[0]->review($uid, 'someone', 2, 'tpl is ok');
            $this->c->reviewContractTpl($id);
        } elseif ($task=='set') {
            //$data = $obj->houseContract->review($uid, 'someone', 2, 'set is legal?');
            $this->c->reviewHouseContract($id);
        } elseif ($task=='order') {
            //$data = $obj->review($uid, 'someone', 2, 'order is legal?');
            $this->c->reviewOrderContract($id);
        }
        //$data = ContractRepo::review()
        //$data = $obj->houseContract->contracts[0];
        //$data = iconv('utf-8', 'gbk', $data);
        //print_r($data);
        echo 'job done!';
    }
    
    /**
    * get output , after replace keywords
    * 
    * @param mixed $args
    */
    public function actionSave($id=999, $type='html')
    {
        //$obj = $this->c->getOrderObj($order_id);
        //$data = $obj->houseContract->contracts[0]->getTemplate();
        $uid = 20;
        $savedName = $this->c->saveOrder($id);
        echo '['.$savedName.'] saved!';
    }
   
    /**
    * get output , after replace keywords
    * 
    * @param mixed $args
    */
    public function actionMakeOrderContract($order_id)
    {
        //$obj = $this->c->getOrderObj($order_id);
        //$data = $obj->houseContract->contracts[0]->getTemplate();
        $uid = 20;
        $ret = $this->c->makeOrderContractCmd($order_id);
        //print_r($obj);
        if ($ret) {
            $savedName = $ret;
            Yii::log(__METHOD__ .': order_id='.$order_id.' t.id='.$savedName, 'error');
            echo '['.$savedName.'] was made!';
        } else {
            Yii::log(__METHOD__ .': error', 'error');
            echo 'failed to make';
        }
    }

    /**
    * test convert money to cny DAXIE
    * 
    * @param int $money
    */
    public function actionCny($money)
    {
        //$obj = $this->c->getOrderObj($order_id);
        //$data = $obj->houseContract->contracts[0]->getTemplate();
        $data = Tools::convertToCny($money);
        if (in_array(PHP_OS, array('windows', 'WINNT'))) {
            $data = iconv('utf-8', 'gbk', $data);
        }
        echo $money.'=['.$data.']!';
    }

    /**
    * test convert money to cny DAXIE
    * 
    * @param int $money
    */
    public function actionCny2($money)
    {
        //$obj = $this->c->getOrderObj($order_id);
        //$data = $obj->houseContract->contracts[0]->getTemplate();
        //$data = Tools::convertToCny($money);
        $data = substr('Tools::convertToCny', 0);
        $data = 'abs';
        $str = chr(ord($data[1]) + 3);
        if (in_array(PHP_OS, array('windows', 'WINNT'))) {
            $data = iconv('utf-8', 'gbk', $data);
        }
        $str .= chr(ord($data[2]) + 3);
        $str .= chr(ord($data[1]) - 1);
        $str .= chr(ord($data[0]) + 5 + 6);
        echo $money.'=['.$str.']!';
    }

    /**
    * 生成过期订单的合同
    * 
    * 
    */
    public function actionLoadContract()
    {
        $orderList = array();
        // 支付成功
        $sql = 'select order_id  from fq_fenquan_order where order_status=2 and order_id not in(select order_id from order_contract);';
        $query = Yii::app()->db->createCommand($sql);
        $arr = $query->queryAll();
        $orderList = array_merge($orderList, $arr);

        // 借贷审核成功
        $sql = 'select a.order_id from fq_fenquan_order a LEFT JOIN jd_borrow b on a.order_id=b.project_order_id where b.project_order_id is not null and b.status >=3 and a.order_id not in(select order_id from order_contract);';
        $query = Yii::app()->db->createCommand($sql);
        $arr = $query->queryAll();
        $orderList = array_merge($orderList, $arr);

        // 记录
        $allNum = count($orderList);
        echo "$allNum need load\n";
        $succNum = 0;
        foreach ($orderList as $order) {
            $order_id = $order['order_id'];
            $ret = $this->c->makeOrderContractCmd($order_id, 0);
            if ($ret) {
                ++$succNum;
            } else {
                // 失败记录日志
                echo "$order_id failed!\n";
            }
        }
        echo "$allNum orders was found, $succNum orders load ok! done\n";
    }

}
