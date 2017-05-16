<?php
class HotArticleModel extends HotArticleModelBase
{
    const TYPE_ACTIVITY         = 1;
    const TYPE_PROJECT          = 2;
    const TYPE_ENTERPRISE_NEWS  = 3;
    const TYPE_OTHER            = 4;
    static $ARR_TYPE = array(
        self::TYPE_ACTIVITY => '活动分享',
        self::TYPE_PROJECT => '项目分享',
        self::TYPE_ENTERPRISE_NEWS => '企业资讯',
        self::TYPE_OTHER => '其他',
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
                    //'actcms' => array(self::HAS_ONE, 'ArticleModel', '', 'on' => 'artcms.id = t.art_id'),
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
        public function orderBy($order = 't.weight ASC,t.last_modified DESC') {

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
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return HotArticleModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
}
