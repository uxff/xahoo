<?php
class TaskTplModel extends TaskTplModelBase
{
    const TASK_TYPE_SHARE       = 1;
    const TASK_TYPE_FILLAVATAR  = 2;
    const TASK_TYPE_INVITE      = 3;
    static $ARR_TASK_TYPE = array(
        self::TASK_TYPE_SHARE => '分享任务',
        self::TASK_TYPE_FILLAVATAR => '完善信息',
        self::TASK_TYPE_INVITE => '邀请注册',
    );
	
    const ACT_TYPE_ACTIVITY         = 1;
    const ACT_TYPE_PROJECT          = 2;
    const ACT_TYPE_ENTERPRISENEWS   = 3;
    const ACT_TYPE_OTHER            = 3;
    static $ARR_ACT_TYPE = array(
        self::ACT_TYPE_ACTIVITY => '活动分享',
        self::ACT_TYPE_PROJECT => '项目分享',
        self::ACT_TYPE_ENTERPRISENEWS => '企业资讯',
        self::ACT_TYPE_OTHER => '其他',
    );
    
    const STATUS_UNPUBLISHED    = 1;
    const STATUS_PUBLISHED      = 2;
    const STATUS_CANSELED       = 3;
    static $ARR_STATUS = array(
        self::STATUS_UNPUBLISHED => '未发布',
        self::STATUS_PUBLISHED => '已发布',
        self::STATUS_CANSELED => '已撤销',
    );
	
        /**
         * @return array validation rules for model attributes.
         */
        public function rules() {
                //新增的在这里面加，如果修改 需要修改父类中的Rules
                $curRules = array(
                );
                return array_merge(parent::rules(), $curRules);
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                $curRelations = array(
                    'rule_id' => array(self::HAS_ONE, 'PointsRuleModel', '', 'on' => 'rule_id.rule_id = t.rule_id'),
                );
                return array_merge(parent::relations(), $curRelations);
        }

        /**
         * custom defined scope
         * @param  integer $pageNo   页码
         * @param  integer $pageSize 每页大小
         * @return object
         */
        public function pagination($pageNo = 1, $pageSize = 20) {

            $offset = ($pageNo > 1) ? ($pageNo - 1) * $pageSize : 0;
            $limit = ($pageSize > 0) ? $pageSize : 20;

            $this->getDbCriteria()->mergeWith(array('limit' => $limit, 'offset' => $offset));

            return $this;
        }

        /**
         * custom defined scope
         * @param  integer $limit 数量
         * @return object
         */
        public function recently($limit = 5) {

            $this->getDbCriteria()->mergeWith(array('order' => 't.last_modified DESC', 'limit' => $limit));

            return $this;
        }

        /**
         * custom defined scope
         * @param  string $order 排序条件
         * @return object
         */
        public function orderBy($order = 't.weight ASC ,t.last_modified DESC') {

            if (!empty($order)) {
                $this->getDbCriteria()->mergeWith(array('order' => $order));
            }

            return $this;
        }

        /**
         * 与Smarrty中的文本提示相对应，可以修改成中文提示
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                $curLables = array(
                );
                return array_merge(parent::attributeLabels(), $curLables);
        }
        

        public function mySearch($condition = [])
        //public function mySearch()
        {

           // @todo Please modify the following code to remove attributes that should not be searched.
            $criteria = $this->getBaseCDbCriteria();

            if(isset($condition['create_time_start']) && !empty($condition['create_time_start'])) {
                $sql=" create_time >= '".date('Y-m-d 00:00:00', strtotime($condition['create_time_start']))."'";
                $criteria->addCondition($sql);
            }
            if(isset($condition['create_time_end']) && !empty($condition['create_time_end'])) {
                $sql="create_time <= '".date('Y-m-d 23:59:59', strtotime($condition['create_time_end']))."'";
                $criteria->addCondition($sql);
            }
            //为$criteria新增设置
            $count = $this->count($criteria);
            $pager = new CPagination($count);
            $pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
            $pager->pageVar = 'page'; //修改分页参数，默认为page
            $pager->params = array('type' => 'msg'); //分页中添加其他参数
            $pager->applyLimit($criteria);
            $list = $this->orderBy()->findAll($criteria);
            $pages = array(
                'curPage' => $pager->currentPage+1,
                'totalPage' => ceil($pager->itemCount/$pager->pageSize),
                'pageSize' => $pager->pageSize,
                'totalCount'=>$pager->itemCount,
                'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
            );
            return array('pages' => $pages, 'list' => $list);
        }


        
		
		/**
         * 查询当前用户最新任务，并且不包含用户已完成的任务
         */
        public static function getMemberNewTaskTplList($member_id,$page ,$pageSize)
        {
            // @todo Please modify the following code to remove attributes that should not be searched.
            $criteria = TaskTplModel::model()->getBaseCDbCriteria();
			
			//过滤用户已完成的最新任务
			$sql = "  t.status = 2 and t.task_id not in( select m.task_id from fh_member_task as m where member_id='$member_id' and m.status=2 )";
			$criteria->addCondition($sql);
			
            //为$criteria新增设置
            $total 		= TaskTplModel::model()->count($criteria);
			$page  		= $page ? $page : 1;
            $pageSize 	= $pageSize ? $pageSize : Yii::app()->params['pageSize'];
            $list 		= TaskTplModel::model()->orderBy()->pagination($page, $pageSize)->findAll($criteria);
            
            //
            foreach ($list as $k=>&$v) {
                $list[$k] = $v->toArray();
                if($v['reward_type']==1 && $v['reward_points'] > 0){
                    $list[$k]['_reward_desc'] = $v['reward_points'].'积分';
                }
                if($v['reward_type_money']==2 && $v['reward_money'] > 0){
                    $list[$k]['_reward_desc2'] = '￥'.$v['reward_money'];
                }
            }
            
            $arrRet 	= array(
				'page' 		=> $page,
				'pageSize' 	=> $pageSize,
				'total' 	=> $total,
				'list' 		=> $list,
            );
            return $arrRet;
        }
		
		/**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return TaskTplModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
}
