<?php
class FhMoneyWithdrawModel extends FhMoneyWithdrawModelBase
{

    const STATUS_AUDITING   = 1;    // 待审核   // 已提交
    const STATUS_REJECTED   = 2;    // 不通过
    const STATUS_PAYING     = 3;    // 待打款
    const STATUS_PAID       = 4;    // 签署
    static $ARR_STATUS = array(
        self::STATUS_AUDITING => '待审核',
        self::STATUS_REJECTED => '审核不通过',
        self::STATUS_PAYING => '已审核',
        self::STATUS_PAID => '已打款',
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
                    'haibao' => array(self::HAS_ONE, 'FhMemberHaibaoModel', '', 'on' => 'haibao.member_id  = t.member_id'),
                    'project' => array(self::HAS_ONE, 'Project', '', 'on' => 'project.project_id  = t.project_id'),
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
        public function mySearch2($condition=[])
        {
               // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                $criteria->with = ['project','haibao'];
                $criteria->order = 't.id desc';
                //为$criteria新增设置
                if (!empty($condition)) {
                    //$ssql = 't.id >0 '.$sql;
                    //$criteria->addCondition($ssql);
                    if($condition['nickname'] != ''){
                        $criteria->addCondition(" haibao.wx_nickname like "."'%".trim($condition['nickname'])."%'");
                    }
                    if($condition['member_mobile'] != ''){
                        $criteria->addCondition(" haibao.member_mobile like "."'%".$condition['member_mobile']."%'");
                    }
                    if($condition['project'] != ''){
                        $criteria->addCondition(" haibao.project_id = ".(int)$condition['project']);
                    }
                    if($condition['is_jjr'] != ''){
                        $criteria->addCondition(" haibao.is_jjr = ".(int)$condition['is_jjr']);
                    }
                    if($condition['status'] != ''){
                        $criteria->addCondition(" t.status = ".(int)$condition['status']);
                    }
                }
                $criteria->addCondition(" haibao.member_id is not null");
                //$criteria = new CDbCriteria();
                //$criteria->join = 'LEFT JOIN fh_member_haibao as haibao on haibao.member_id  = t.member_id';       
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                //$pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
                $pager->pageSize = 100;
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
         * @return FhMoneyWithdrawModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
}
