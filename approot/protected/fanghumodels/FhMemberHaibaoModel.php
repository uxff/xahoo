<?php
class FhMemberHaibaoModel extends FhMemberHaibaoModelBase
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
                    'project' => array(self::HAS_MANY, 'Project', '', 'on' => 'project.project_id  = t.project_id'),
                    'total' => array(self::HAS_ONE, 'MemberTotalModel', '', 'on' => 'total.member_id  = t.member_id'),
                    'money' => array(self::HAS_MANY, 'FhMoneyWithdrawModel', '', 'on' => 'money.member_id  = t.member_id'),
                    'moneylog' => array(self::HAS_MANY, 'FhPosterMoneyLogModel', '', 'on' => 'moneylog.pid  = t.id'),
                    'poster' => array(self::HAS_ONE, 'FhPosterModel', '', 'on' => 'poster.id = t.poster_id'),
                    'log' => array(self::HAS_MANY, 'FhMemberHaibaoLogModel', '', 'on' => 'log.sns_bind_id=t.sns_bind_id'),
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
                $ssql = 't.id > 0'.$sql;
                $criteria = new CDbcriteria();
                $criteria->addCondition($ssql);
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->with('project','moneylog')->findAll($criteria);
                $pages = array(
                    'curPage' => $pager->currentPage+1,
                    'totalPage' => ceil($pager->itemCount/$pager->pageSize),
                    'pageSize' => $pager->pageSize,
                    'totalCount'=>$pager->itemCount,
                    'url'=>preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl())."&page=",
                );
                return array('pages' => $pages, 'list' => $list);
        }
        public function mySearch3($condition)
        {
               // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                //为$criteria新增设置
                $ssql = 't.id > 0'.$condition['sql'];
                $criteria = new CDbcriteria();
                //$criteria->with = ['lastlog'];
                
                if (isset($condition['valid_begintime']) && !empty($condition['valid_begintime'])) {
                    $criteria->addCondition('t.create_time >=:valid_begintime');
                    $criteria->params[':valid_begintime'] = $condition['valid_begintime'];
                }
                if (isset($condition['valid_endtime']) && !empty($condition['valid_endtime'])) {
                    $criteria->addCondition('t.create_time <=:valid_endtime');
                    $criteria->params[':valid_endtime'] = $condition['valid_endtime'];
                }
                
                $criteria->order = $condition['order'];
                $criteria->addCondition($ssql);
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize'])?Yii::app()->params['pageSize']:10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->with('project')->findAll($criteria);
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
         * @return FhMemberHaibaoModel the static model class
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
        static public function listArticle($startDay, $endDay, $order, $page=1, $pageSize=10, $condition=[]) {
            $limitPos = ($page-1) * $pageSize;
            $whereClouse = ['1'];
            $whereParams = [];

            if ($startDay) {
                $whereClouse []= 'create_time>=:start_day';
                $whereParams [':start_day']   = $startDay;
            }
            if ($endDay) {
                $whereClouse []= 'create_time<=:end_day';
                $whereParams [':end_day']     = $endDay;
            }

            $list = Yii::app()->db->createCommand()
                ->select('member_mobile, project_id, member_fullname, wx_nickname, is_jjr, reward_money, fans_first, fans_second, create_time')
                ->from('fh_member_haibao')
                ->where(implode(' and ', $whereClouse), $whereParams)
                //->group('article_id')
                ->order($order)
                ->limit($pageSize, $limitPos) // 参数位置 与sql中的limit刚好相反
                ->queryAll();


            $count = Yii::app()->db->createCommand()
                ->select('count(DISTINCT id) cnt')
                ->from('fh_member_haibao')
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
            更新用户海报的上下限
        */
        static public function updateWithdrawLimitByPoster($poster_id) {
            $posterModel = FhPosterModel::model()->findByPk($poster_id);
            if (!$posterModel) {
                return false;
            }
            
            if ($posterModel->poster_status==2) {
                //$ret = FhMemberHaibaoModel::model()->updateAll(['withdraw_min'=>$posterModel->lowest_withdraw_sum,'withdraw_max'=>$posterModel->highest_withdraw_sum]);
            }
            return $ret;

            $memberList = Yii::app()->db->createCommand()
                ->select('DISTINCT(member_id) member_id')
                ->from('fh_member_haibao_log')
                //->join('fh_member_')
                ->where('poster_id=:pid', [':pid'=>$poster_id])
                ->queryAll();
            //echo 'memberList=';print_r($memberList);

            foreach ($memberList as $member) {
                FhMemberHaibaoModel::updateWithdrawLimitByMember($member['member_id']);
            }
            return true;
        }
        static public function updateWithdrawLimitByMember($member_id) {
            $haibao = FhMemberHaibaoModel::model()->find('member_id=:mid', [':mid'=>$member_id]);
            if ($haibao) {
                $limitWithdraw = FhMemberHaibaoLogModel::countMax($haibao->sns_bind_id);
                //echo 'limitWithdraw=';print_r($limitWithdraw);
                $haibao->withdraw_max    = $limitWithdraw['themax']*1.0;
                $haibao->withdraw_min    = $limitWithdraw['themin']*1.0;
                if (!$haibao->save()) {
                    //echo 'error:'.$haibao->lastError();
                }
            }
            return true;
        }
        static public function updateWithdrawLimitByBindId($sns_bind_id) {
            $haibao = FhMemberHaibaoModel::model()->find('sns_bind_id=:mid', [':mid'=>$sns_bind_id]);
            if ($haibao) {
                $limitWithdraw = FhMemberHaibaoLogModel::countMax($sns_bind_id);
                //echo 'limitWithdraw=';print_r($limitWithdraw);
                $haibao->withdraw_max    = $limitWithdraw['themax']*1.0;
                $haibao->withdraw_min    = $limitWithdraw['themin']*1.0;
                if (!$haibao->save()) {
                    //echo 'error:'.$haibao->lastError();
                }
            }
            return true;
        }
        static public function updateWithdrawLimit() {
            
        }
        static public function updateFansCalcByMember($member_id) {
            try {
                $count = Yii::app()->db->createCommand()
                    ->select('count(DISTINCT openid) cnt')
                    ->from('fh_member_fans')
                    ->where('member_id=:mid', [':mid'=>$member_id])
                    ->queryAll();
                if ($count && $count[0] && $count[0]['cnt']) {
                    //FhMemberHaibaoModel::model()->updateByPk($member_id, [''])
                }
            } catch (CException $e) {
                Yii::log('error:'.$e->getMessage().' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            }
        }
        //static public function combineHaibao($master_id, $)
}
