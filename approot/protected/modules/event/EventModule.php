<?php
/**
 * event 模块
 * xuduorui@qq.com
 */
class EventModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
            'application.common.extensions.*',
            'application.ucentermob.api.*',
            'application.ucentermodels.*',
            'application.fanghumodels.*',
            'event.libirarys.*',
			'event.controllers.*',
			'event.models.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action)){
			return true;
		}
		
		return false;
	}
    
	public function welcome() 
	{
		echo "welcome\n";
		return false;
	}
    
    /**
    * 加入事件
    *  
    * @param $member_id 用户id
    * @param $event_key
    * @param $event_param 
    */
    public function pushEvent($member_id, $event_key, $event_param = array()) {
        // 查询事件id
        $eventTpl = EventTplModel::model()->find('event_key=:event_key', array(':event_key'=>$event_key));
        if (empty($eventTpl)) {
            // 报错
            Yii::log(' unknown event_key:'.$event_key.'!'.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        if (is_array($event_param)) {
            $pre_event_id = $event_param['pre_event_id'];
            $pre_event_key = $event_param['pre_event_key'];
            $event_param_json = @json_encode($event_param);
        } else {
        }
        // 加入事件队列
        $eventQueueObj = new EventQueueModel;
        $eventQueueObj->sender_mid = $member_id;
        $eventQueueObj->event_key = $event_key;
        $eventQueueObj->event_id = $eventTpl->event_id;
        $eventQueueObj->params = $event_param_json;
        $eventQueueObj->create_time = date('Y-m-d H:i:s');
        $eventQueueObj->pre_event_id = $pre_event_id;
        $eventQueueObj->pre_event_key = $pre_event_key;
        //$ret = $eventQueueObj->insert();
        //if (!$ret) {
        //    Yii::log("error when save eventQueueObj:('$event_key'):".$eventQueueObj->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        //    //print_r($eventQueueObj->getErrors());
        //    return false;
        //}
        Yii::log("done: mid=".$member_id.' event_key='.$event_key.' pre_event_key='.$pre_event_key.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
        
        // 异步执行
        //$this->processEvent();

        //// 同步执行
        if ($this->processEventOne($eventQueueObj)) {
            //Yii::log(__METHOD__ .": process event done", 'error', __CLASS__);
        }
    }
    
    /**
    * 事件处理 事件队列出列 可异步调用 消费所有
    */
    public function processEvent() {
        // 从队列中取出一个
        $queueObjs = EventQueueModel::model()->orderBy('t.id ')->with('event_tpl')->findAll();
        foreach ($queueObjs as $queueObj) {
            $this->processEventOne($queueObj);
        }
    }
    
    /**
    * 消费一个
    */
    protected function processEventOne(&$queueObj) {
        static $eventTmp = array();
        
        if (!$queueObj) {
            Yii::log('no obj in event queue need process!'.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            return false;
        }
        // 记录日志
        $event_log_id = $this->logQueue($queueObj);
        // 删除记录 同步执行 必须先删除，必然有堆积影响
        if (!$queueObj->getIsNewRecord()) {
            $ret = EventQueueModel::model()->deleteByPk($queueObj->id);
            if (!$ret) {
                Yii::log("when delete queueObj({$queueObj->id}): ".$queueObj->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            }
        }

        $eventTplModel = EventTplModel::model()->findByPk($queueObj->event_id);
        if (!$eventTplModel) {
            Yii::log('no tpl obj of queue:'.$queueObj->event_id.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        // 类工厂派发事件
        $eventObj = EventFactory::createEvent($queueObj->event_key, $eventTplModel->event_class);

        $eventTmp[] = $queueObj->toArray();
        // 组织params交给派发的类
        $params = $queueObj->params ? @json_decode($queueObj->params, true) : array();
        $params['_event_tpl'] = $eventTplModel->toArray();
        $params['_event_queue'] = $queueObj->toArray();
        //$params['points_rule_key'] = $eventTplModel->use_rule_key;
        unset($params['_event_queue']['params']);
        unset($params['_event_queue']['event_tpl']);
        
        //Yii::log(__METHOD__ .': start process: mid='.$queueObj->sender_mid.' event_key='.$queueObj->event_key, 'warning', __CLASS__);
        //$params['event_next'] = $eventTplModel->event_next;
        // 具体事件对象 操作逻辑
        $ret = $eventObj->process($queueObj->sender_mid, $params);
        // 操作完成后 根据结果 继续添加事件 // 在process中完成

        //$ret = EventQueueModel::model()->deleteByPk($event_qid);
        //$queueObj->status = 0;
        //Yii::log(__METHOD__ .': done: mid='.$queueObj->sender_mid.' event_key='.$queueObj->event_key, 'warning', __CLASS__);
        return true;
    }
    
    /**
    * 获取事件日志
    * 
    * @param mixed $params
    */
    public function getEventLog($member_id, $event_key, $page=1, $page_size=10){
        $condition = array();
        if ($member_id) {
            $condition['sender_mid'] = $member_id;
        }
        if ($event_key) {
            $condition['event_key'] = $event_key;
        }
        $ret = EventLogModel::model()->mySearch($condition, $page, $page_size);
        return $ret;
    }
    /*
        记录EventQueue对象
        @param EventQueueModel $queueObj
    */
    public function logQueue($queueObj) {
        $dump = $queueObj->toArray();
        unset($dump['id']);
        $logModel = new EventLogModel;
        $logModel->attributes = $dump;
        // Yii::log();
        $ret = $logModel->save();
        if (!$ret) {
            Yii::log("when save queue log ".$queueObj->id.":".$logModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        }
        //Yii::log(__METHOD__ .": done: ".$queueObj->id.' mid='.$queueObj->sender_mid.' event_key='.$queueObj->event_key, 'warning', __CLASS__);
        return $logModel->id;
    }
}
