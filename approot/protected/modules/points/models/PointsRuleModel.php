<?php
class PointsRuleModel extends PointsRuleModelBase
{
        const FLAG_STATIC  = 1; //普通静态规则
        const FLAG_DYNAMIC = 2; //动态规则

        const RULE_ID_FOR_TASK = 10; //任务的rule_id

        const RULE_KEY_CHECKIN              = 'check_in';
        const RULE_KEY_CHECK_IN_NDAY        = 'check_in_nday';
        const RULE_KEY_FILL_AVATAR          = 'fill_avatar';
        const RULE_KEY_FINISH_INVITE_FRIEND = 'finish_invite_friend';
        const RULE_KEY_LEVEL_UP             = 'level_up';
        const RULE_KEY_REGISTER_BY_INVITE   = 'register_by_invite';
        const RULE_KEY_REGISTER             = 'register';
        const RULE_KEY_SHARE_CLICKED        = 'share_clicked';
        const RULE_KEY_SHARE                = 'share';
        const RULE_KEY_FINISH_TASK          = 'finish_task';

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
                    'task_tpl' => array(self::HAS_ONE, 'TaskTplModel', '', 'on' => 'task_tpl.rule_id = t.rule_id'),
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
                $criteria->addCondition('flag=1');
                //为$criteria新增设置
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = 50;//!empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
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
         * @return PointsRuleModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
}
