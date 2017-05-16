<?php
class JdBorrow extends JdBorrowBase
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
         * @return JdBorrow the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
    static public function getStatusDesc($status) {
        // 0|无效,1|待提审,2|待审核,3|已审核,4|预热中,5|投标中,6|已满标,7|还款中,8|还款结束,9|审核未通过,99|删除
        $desc = '无效';
        switch ($status) {
            case 0:
                $desc = '无效';
                break;
            case 1:
                $desc = '待提审';
                break;
            case 2:
                $desc = '待审核';
                break;
            case 3:
                $desc = '已审核';
                break;
            case 4:
                $desc = '预热中';
                break;
            case 5:
                $desc = '投标中';
                break;
            case 6:
                $desc = '已满标';
                break;
            case 7:
                $desc = '还款中';
                break;
            case 8:
                $desc = '还款结束';
                break;
            case 9:
                $desc = '审核未通过';
                break;
        }
        return $desc;
    }
    static public function getRepaymentTypeDesc($repaymentType) {
        $desc = '未知还款类型';
        switch ($repaymentType) {
            case 1:
                $desc = '等额本息';
                break;
            case 2:
                $desc = '等额本金';
                break;
            case 3:
                $desc = '先息后本';
                break;
            default:
                breka;
        }
        return $desc;
    }
}
