<?php
class StasticArticleModel extends StasticArticleModelBase
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
         * @return StasticArticleModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        /*
            按起始时间列出文章
            @param string $startDay = '2016-04-01'
            @param string $endDay   = '2016-04-02'
        */
        static public function listArticle($startDay, $endDay, $page=1, $pageSize=10, $condition=[]) {
            $limitPos = ($page-1) * $pageSize;
            $whereClouse = ['1'];
            $whereParams = [];

            if ($startDay) {
                $whereClouse []= 'date>=:start_day';
                $whereParams [':start_day']   = $startDay;
            }
            if ($endDay) {
                $whereClouse []= 'date<=:end_day';
                $whereParams [':end_day']     = $endDay;
            }
            if (isset($condition['title']) && !empty($condition['title'])) {
                $whereClouse []= 'title like :title';
                $whereParams [':title']       = '%'.$condition['title'].'%';
            }

            $list = Yii::app()->db->createCommand()
                ->select('article_id, title, sum(pv) pv, sum(uv) uv, sum(share_count) share_count')
                ->from('fh_stastic_article')
                ->where(implode(' and ', $whereClouse), $whereParams)
                ->group('article_id')
                ->order('article_id desc')
                ->limit($pageSize, $limitPos) // 参数位置 与sql中的limit刚好相反
                ->queryAll();

            $countSql = 'SELECT count(DISTINCT article_id) cnt FROM `fh_stastic_article` ';//.$countWhereClouse.' ';
            // 'select count(*) cnt from (SELECT article_id,title FROM `fh_stastic_article` '.$countWhereClouse.' group by article_id ) g;'

            $count = Yii::app()->db->createCommand()
                ->select('count(DISTINCT article_id) cnt')
                ->from('fh_stastic_article')
                ->where(implode(' and ', $whereClouse), $whereParams)
                ->queryAll();

            $count = $count[0]['cnt'];
            $pages = array(
                'curPage' => $page,
                'totalPage' => ceil($count/$pageSize),
                'pageSize' => $pageSize,
                'totalCount'=>$count,
                'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
            );
            return array('pages' => $pages, 'list' => $list);
            //return $list;
        }
        /*
            按起始时间统计数据
            @param string $day = '2016-04-01'
        */
        static public function stasticVisit($day) {
            $ret = Yii::app()->db->createCommand()
                ->select('sum(pv) pv, sum(uv) uv, sum(share_count) share_count')
                ->from('fh_stastic_article')
                ->where('`date`=:day', [
                    ':day' => $day,
                ])
                ->queryAll();
            return $ret;
        }
        /*
            统计注册数据
            @param string $startTime = '2016-04-01 00:00:00'
            @param string $endTime   = '2016-04-02 00:00:00'
        */
        static public function stasticRegCount($startTime, $endTime) {
            $ret = Yii::app()->UCenterDb->createCommand()
                ->select('count(member_id) reg_count')
                ->from('uc_member')
                ->where('create_time>=:start_time and create_time<=:end_time and member_from in ("11", "12")', [
                    ':start_time'   => $startTime,
                    ':end_time'     => $endTime,
                ])
                ->queryAll();
            return $ret;
        }
        /*
            统计新奇世界访问数据
            @param string $startTime = '2016-04-01 00:00:00'
            @param string $endTime   = '2016-04-02 00:00:00'
            // 线上不可跨库查
        */
        static public function stasticXqsjVisit($startTime, $endTime) {

            $ret = Yii::app()->UCenterDb->createCommand()
                ->select('count(member_id) pv, count(member_id) uv')
                ->from('uc_member')
                ->where('last_login>=:start_time and last_login<=:end_time and member_from in ("2", "3")', [
                    ':start_time'   => $startTime,
                    ':end_time'     => $endTime,
                ])
                ->queryAll();
            return $ret;
        }
        /*
            @param $artObj ArticleModel
        */
        static public function addStastic($artObj, $day) {
            
            $stasticModel = StasticArticleModel::model()->find('article_id=:aid and date=:day', [':day'=>$day, ':aid'=>$artObj->id]);
            if (empty($stasticModel)) {
                $stasticModel = new StasticArticleModel;
            } else {
                return true;
            }

            // 入库
            //$stasticModel = new StasticArticleModel;
            $arrAttr = [
                'article_id'    => $artObj->id,
                'title'         => $artObj->title,
                'date'          => $day,
                'pv'            => 0,//$stasticVisitInfo[0]['pv'] * 1,
                'uv'            => 0,//$stasticVisitInfo[0]['uv'] * 1,
                'share_count'   => 0,//$stasticShareInfo[0]['share_count'] * 1,
            ];
            $stasticModel->attributes = $arrAttr;

            if (!$stasticModel->save()) {
                Yii::log('save faild: '.$stasticModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                //print_r($stasticModel->lastError());
                return false;
            }
            return true;
        }
}
