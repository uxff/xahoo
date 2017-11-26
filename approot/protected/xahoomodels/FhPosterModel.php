<?php
class FhPosterModel extends FhPosterModelBase
{
    const POSTER_STATUS_TOBESTARTED = 1;
    const POSTER_STATUS_STARTED = 2;
    static $ARR_POSTER_STATUS = [
        self::POSTER_STATUS_TOBESTARTED => '未开始',
        self::POSTER_STATUS_STARTED => '进行中',
    ];
	
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
                    //'project' => array(self::HAS_MANY, 'Project', '', 'on' => 'project.project_id  = t.project_id'),
                    'accounts' => array(self::HAS_MANY, 'FhPosterAccountsModel', '', 'on' => 'accounts.id  = t.accounts_id'),
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
        public function mySearch2($sql)
        {
               // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                //为$criteria新增设置                
                $ssql = ' t.id > 0'.$sql;
                $criteria = new CDbCriteria();
                $criteria->order = 't.create_time DESC';
                $criteria->addCondition($ssql);      //根据条件查询
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->with('accounts')->findAll($criteria);
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
         * @return FhPosterModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        public static function GetStartedModel($mpid = 1) {
            return self::model()->find('t.accounts_id = :mpid and t.poster_status='.self::POSTER_STATUS_STARTED, [':mpid'=>$mpid]);
        }
        
        /**
            
         * [GetPosterByAddr description] 地域海报
         * @param string $location_address [description]
         */
        public function GetPosterByAddr($location_address, $mpid){
            $criteria = $this->getBaseCDbCriteria(); 
            $where = 't.accounts_id = :mpid AND t.poster_status = '.self::POSTER_STATUS_STARTED;
            $data = self::model()->find($where, [':mpid' => $mpid]);
            if($data){
                $validArr = array();
                if($location_address != ''){
                    $validArr = explode(',',$data->valid_area);
                    if($validArr != ''){
                        foreach ($validArr as $k=> $v) {
                            if($location_address == $v){
                            // if(strstr($location_address,$validArr[$k])){
                                return true;
                            }else{
                                //return false;
                            }
                        }
                    }
                }             
            }else{
                return false;
            }
        }
}
