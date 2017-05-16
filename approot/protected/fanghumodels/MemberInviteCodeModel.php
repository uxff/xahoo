<?php
class MemberInviteCodeModel extends MemberInviteCodeModelBase
{
    const STATUS_VALID = 1;
	
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
                    'who_use_me' => array(self::HAS_MANY, 'MemberInviteLogModel', '', 'on' => 'who_use_me.inviter = t.member_id'),
                    'i_use_whom' => array(self::HAS_ONE, 'MemberInviteLogModel', '', 'on' => 'i_use_whom.invitee = t.member_id'),
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
         * @return MemberInviteCodeModel the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
    /*
        生产邀请码 数字和大写字母组合
            生产后将其中的1转为I 0转为O 就是不包含1和0
        @param $len  邀请码长度 最长16
        @param $seed 种子
    */
    static public function genInviteCode($len=6, $seed=0) {
        static $arrEnum = array();
        if (empty($arrEnum)) {
            // 数字 不需要1和0
            for ($i=2; $i<10; ++$i) {
                $arrEnum[] = $i;
            }
            // 大写字母 小写字母
            for ($i=65; $i<65+26; ++$i) {
                $arrEnum[] = chr($i);
                //$arrEnum[] = chr($i+32);
            }
        }
        $enumCount = count($arrEnum);
        mt_srand((time()%10009)+(int)$seed);
        $inviteCode = '';
        for ($i=0; $i<$len && $i<16; ++$i) {
            $seedNum = mt_rand(0, $enumCount-1);
            $codeOne = $arrEnum[$seedNum];
            $inviteCode .= $codeOne;
        }
        return $inviteCode;
    }
    /*
        查找邀请码
        @param $inviteCode
    */
    static public function findInviteCode($inviteCode) {
        $model = MemberInviteCodeModel::model()->find('invite_code=:code', array(':code'=>$inviteCode));
        return $model;
    }
    /*
        纠正输入的邀请码
            将其中的1转为I 0转为O 就是不包含1和0
        @param $inviteCode
    */
    static public function correctInviteCode($inviteCode) {
        return str_replace(array('0', '1'), array('O', 'I'), strtoupper($inviteCode));
    }
}
