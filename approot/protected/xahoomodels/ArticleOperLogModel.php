<?php
class ArticleOperLogModel extends ArticleOperLogModelBase
{
	
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
        public function orderBy($order = 't.last_modified DESC') {

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
        public function mySearch()
        {
               // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                //为$criteria新增设置
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->findAll($criteria);
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
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return ArticleOperLogModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }

        /*
            记录一次操作日志
        */
        static public function saveAnOper($aid, $oldStatus, $newStatus) {
            //
            $model = new ArticleOperLogModel;
            $model->admin_id  = Yii::app()->memberadmin->id;
            $model->admin_name = Yii::app()->memberadmin->name;
            $model->article_id = $aid;
            $model->old_status = $oldStatus;
            $model->new_status = $newStatus;
            $model->has_online_status = ($newStatus == ArticleModel::STATUS_PUBLISHED || $oldStatus == ArticleModel::STATUS_PUBLISHED) ? 1:0;
            $model->oper_time  = date('Y-m-d H:i:s', time());
            if (!$model->save()) {
                Yii::log('save faild: '.$model->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            }
        }
        /*
            查询某文章某天是否上线
        */
        static public function queryByDay($aid, $day) {
            $startTime  = date('Y-m-d 00:00:00', strtotime($day));
            $endTime    = date('Y-m-d 23:59:59', strtotime($day));

            $ret = Yii::app()->db->createCommand()
            ->select('article_id, has_online_status')
            ->from('fh_article_oper_log')
            ->where('article_id=:aid and oper_time>=:startTime and oper_time<=:endTime and has_online_status=1', [
                ':aid'          => $aid,
                ':startTime'    => $startTime,
                ':endTime'      => $endTime,
            ])
            ->limit(1)
            ->queryAll();
            
            //print_r($ret);
            return $ret;
        }
        /*
            查询某文章所有可用时间区间
            @return array [[$startDay, $endDay], [$startDay, $endDay]]
        */
        static public function queryRange($aid) {
            // 
            // select create_time where 
            ArticleOperLogModel::initOper($aid);
            $statusPublished = ArticleModel::STATUS_PUBLISHED;

            //$logList = ArticleOperLogModel::model()->findAll('article_id=:aid and has_online_status=1');
            $logList = Yii::app()->db->createCommand()
            ->select('article_id, old_status, new_status, oper_time')
            ->from('fh_article_oper_log')
            ->where('article_id=:aid and has_online_status=1', [
                ':aid'          => $aid,
            ])
            ->queryAll();

            // 整理出区间
            $lastOnlineDay = date('Y-m-d');
            $arrRange = [];
            $rangeFlag = 1;//1=left 2=right
            $rangeStep = 0;
            foreach ($logList as $logOne) {
                // 左右分头寻找
                switch ($rangeFlag) {
                    // 记录开始
                    case 1:
                        if ($logOne['new_status'] == $statusPublished) {
                            $rangeFlag = 2;
                            $arrRange[$rangeStep]['start'] = $logOne['oper_time'];
                        }
                        break;
                    // 记录结束
                    case 2:
                        if ($logOne['old_status'] == $statusPublished) {
                            $rangeFlag = 1;
                            $arrRange[$rangeStep]['end'] = $logOne['oper_time'];
                            ++$rangeStep;
                        }
                        break;
                }
            }

            return $arrRange;
        }
        /*
            为历史记录的文章创建起始操作记录
            @return array [[$startDay, $endDay], [$startDay, $endDay]]
        */
        static public function initOper($aid) {
            // 
            $artObj = ArticleModel::model()->findByPk($aid);
            if (!$artObj) {
                Yii::log('article_id not exist: '.$aid.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                return false;
            }
            $startTime  = substr($artObj->create_time, 0, 10).' 00:00:00';
            $endTime    = substr($artObj->create_time, 0, 10).' 23:59:59';

            // old_status=0 表示新建操作
            $logModel = ArticleOperLogModel::model()->find('article_id=:aid and oper_time>=:startTime and oper_time<=:endTime and old_status=0', [
                ':aid'          => $aid,
                ':startTime'    => $startTime,
                ':endTime'      => $endTime,
            ]);

            $oldStatus = 0;
            $newStatus = ArticleModel::STATUS_PUBLISHED;

            if (!$logModel) {
                $logModel = new ArticleOperLogModel;
                $logModel->admin_id  = 1;//Yii::app()->memberadmin->id;
                $logModel->admin_name = 'admin';//Yii::app()->memberadmin->name;
                $logModel->article_id = $aid;
                $logModel->old_status = 0;//$oldStatus;
                $logModel->new_status = $newStatus;
                $logModel->has_online_status = ($newStatus == ArticleModel::STATUS_PUBLISHED || $oldStatus == ArticleModel::STATUS_PUBLISHED) ? 1:0;
                // 起始时间必须是创建时间
                $logModel->oper_time = $artObj->create_time;
                if (!$logModel->save()) {
                    Yii::log('save faild: '.$logModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                }
            }
        }
}
