<?php
class TaskQueue{

	private $key ;//枷锁key;

	private $lock_time ;//自动解锁时间;

	private $task_name ;

	public $queue_key ;

	public $lock_type = '';

	private static  $logKey = '[ares_log][qjs_task_queue]';

	public function __construct($key = null,$lock_time = 30,$task_name = 'qjs'){

		$this->lock_time = $lock_time;
		$this->task_name = $task_name;
		$this->key = $key;
		$this->queue_key = rand(1,100000);


		if($this->key != null){
			$this->key = $this->task_name.'_'.$this->key;
		}else{
			$this->key = $this->task_name.'_'.md5($_SERVER['REQUEST_URI']);
		}

	}


	//锁定
	public function lock($return_type = 'json',$params = array()){





		$this->lock_type = 'monopoly';//独占

		if(Yii::app()->cache->getMemCache()->get($this->key)!==false){
			$arr = Yii::app()->cache->getMemCache()->get($this->key);
			$this->queue_key = count($arr);
			$arr[] = $this->queue_key;
		}else{
			$this->queue_key = 0;
			$arr =  array($this->queue_key);
		}

		$arr = Yii::app()->cache->getMemCache()->set($this->key,$arr,$this->lock_time);

		$parameters = array(
		'queue_key'=>$this->queue_key,
		'key'=>$this->key,
		'in_mem'=>Yii::app()->cache->getMemCache()->get($this->key)
		);



		AresLogManager::log_bi(array('logKey' => self::$logKey, 'desc' => ' ##### add lock #####', 'parameters' => $parameters, 'response' =>Yii::app()->cache->getMemCache()));


		if($this->inQueue()){

			if($return_type == 'json'){
				$back_data = empty($params)? array('code'=>'2','errMsg'=>'您的手太快了，请稍后再试'):$params;
				echo json_encode($back_data);

			}

			if($return_type == 'redirect'){
				Yii::app()->loginUser->setFlash('error',$params['error_msg']);

				$url = Yii::app()->createAbsoluteUrl(trim($params['url'], '/'),$params['params']);
				Yii::app()->getRequest()->redirect($url);
			}

			exit();

		}




	}


	//锁定
	public function queue_lock(){


		$this->lock_type = 'queue';// 队列

		if(Yii::app()->cache->getMemCache()->get($this->key)!==false){
			$arr = Yii::app()->cache->getMemCache()->get($this->key);
			$this->queue_key = count($arr);
			$arr[] = $this->queue_key;
		}else{
			$this->queue_key = 0;
			$arr =  array($this->queue_key);
		}

		$arr = Yii::app()->cache->getMemCache()->set($this->key,$arr,$this->lock_time);


		while(Yii::app()->cache->getMemCache()->get($this->key)!==false&&$this->inQueue()){

		}


	}

	//查看是否有队列
	private function inQueue(){

		$arr = Yii::app()->cache->getMemCache()->get($this->key);

		if($this->lock_type == 'queue'){

			return $arr!==false&&count($arr)>1&&array_search($this->queue_key,$arr)!==false?true:false;
		}

		if($this->lock_type == 'monopoly'){

			return $arr!==false&&count($arr)>1?true:false;
		}
	}

	public function getQueue(){

		return $arr = Yii::app()->cache->getMemCache()->get($this->key);

	}

	//解锁
	public function unlock($delay = 0 ){

		//延迟解锁
		sleep($delay);

		if($this->lock_type == 'queue'){

			$arr = Yii::app()->cache->getMemCache()->get($this->key);

			if($arr!==false&&count($arr)>0){

				//file_put_contents('111.txt','#####'.json_encode($arr).'******'.json_encode(array_search($this->queue_key,$arr)).'***'.$this->queue_key."\r\n", FILE_APPEND );

				if(is_array($arr)){

					array_shift($arr);

					Yii::app()->cache->getMemCache()->set($this->key,$arr,$this->lock_time);

				}
				//file_put_contents('111.txt','!!!!'.json_encode($arr).'******'.json_encode(array_search($this->queue_key,$arr)).'***'.$this->queue_key."\r\n", FILE_APPEND );


			}else{
				$arr = Yii::app()->cache->getMemCache()->delete($this->key);
			}
		}else if($this->lock_type == 'monopoly'){
			$arr = Yii::app()->cache->getMemCache()->delete($this->key);
		}
	}
}