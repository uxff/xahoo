<?php
/**
 * points 模块
 * xuduorui@qq.com
 */
class PointsModule extends CWebModule
{
	const MEMBER_POINTS_HISTORY = 'fh_member_points_history';
	
	public function init()
	{
		$this->setImport(array(
            'application.common.extensions.*',
            'application.ucentermob.api.*',
            'application.ucentermodels.*',
            'application.fanghumodels.*',
            'points.libirarys.*',
			'points.controllers.*',
			'points.models.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action)){
			return true;
		}
		
		return false;
	}
    
	public function welcome() 
	{
		echo "welcome to ".__CLASS__."\n";
		return false;
	}
    
    /**
    * 计算积分对应的等级
    *   // 此数据最好缓存起来
    * @param $pointsCount
    */
    public function calcLevelByPoints($pointsCount) {
        $levelId = 1;
        $pointsCount = (int)$pointsCount;
        // 此处写死配置 为减少数据库压力
        if (0 <= $pointsCount && $pointsCount <= 4000) {
            $levelId = 1;
        }
        elseif (4001 <= $pointsCount && $pointsCount <= 8000) {
            $levelId = 2;
        }
        elseif (8001 <= $pointsCount && $pointsCount <= 20000) {
            $levelId = 3;
        }
        elseif (20001 <= $pointsCount && $pointsCount <= 50000) {
            $levelId = 4;
        }
        elseif (50001 <= $pointsCount) {
            $levelId = 5;
        }
        
        return $levelId;
        
        $levelModel = PointsLevelModel::model()->find('min_points<=:points and :points<=man_points');
        if ($levelModel) {
            $levelId = $levelModel->level_id;
        }
        return $levelId;
    }
    
    /**
    * 获取等级信息
    * 
    * @param $levelId
    */
    public function getLevelInfo($levelId){
        $levelModel = PointsLevelModel::model()->findByPk($levelId);
        return $levelModel;
    }

    /*
        执行积分规则
        @param $member_id
        @param $rule_id
    */
    public function execRuleByRuleId($member_id, $rule_id, $points = 0, $remark = ''){
        return $this->execRule($member_id, $rule_id, 'rule_id', $points, $remark);
    }

    /*
        执行积分规则
        @param $member_id
        @param $rule_id
    */
    public function execRuleByRuleKey($member_id, $rule_key, $points = 0, $remark = ''){
        return $this->execRule($member_id, $rule_key, 'rule_key', $points, $remark);
    }

    /*
        【核心功能】执行积分规则
        @param $member_id
        @param $rule_id
        @param $points 如果自定义规则，需要传$points
    */
    public function execRule($member_id, $rule_id, $keyType='rule_id', $points = 0, $remark = '') {
        if (empty($keyType)) {
            $keyType = 'rule_id';
        }
        $ruleInfo = PointsRuleModel::model()->find($keyType.'=:rid', array(':rid'=>$rule_id));
        if (!$ruleInfo) {
            //throw new CException('unknown rule_id: '.$rule_id);
            Yii::log('unknown '.$keyType.': '.$rule_id, 'error', __METHOD__);
            return false;
        }

        if ($ruleInfo->flag == PointsRuleModel::FLAG_DYNAMIC) {
            $ruleInfo->points = $points;
        }

        if ($ruleInfo->points==0) {
            //throw new CException('unknown rule_id: '.$rule_id);
            Yii::log('points is zero, none to do. '.$keyType.': '.$rule_id, 'warning', __METHOD__);
            return false;
        }
        // begin transaction
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $history_id = $this->execRuleForTransaction($member_id, $ruleInfo, $remark);

            $transaction->commit();
        } catch (CException $e) {
            $transaction->rollback();
            Yii::log(''.$e->getMessage(), 'error', __METHOD__);
            return false;
        }
        
        Yii::log('done: mid='.$member_id.' rule_id='.$rule_id.' rule_key='.$ruleInfo->rule_key.' points='.$ruleInfo->points.'('.$points.')'.' flag='.$ruleInfo->flag, 'warning', __METHOD__);
        return $history_id;
    }
    /*
        执行积分
        提供给事务使用 会抛错
    */
    public function execRuleForTransaction($member_id, PointsRuleModel $ruleInfo, $remark = '') {
        
        // 积分操作
        $totalModel = MemberTotalModel::model()->find('member_id=:member_id and accounts_id=1', array(':member_id'=>$member_id));
        // 如果没有积分记录，创建积分记录
        if (!$totalModel) {
            $totalModel = new MemberTotalModel;
            $totalModel->member_id      = $member_id;
            $totalModel->accounts_id    = 1;// 公众号下的member_total
            $totalModel->points_total   = 0;
            $totalModel->points_gain    = 0;
            //$ret = $totalModel->insert();
            //if (!$ret) {
            //    //echo __METHOD__ .' error:';print_r( $totalModel->getErrors());
            //    throw new CException($totalModel->lastError());
            //}
        }
    
        $totalModel->points_total += $ruleInfo->points;
        $totalModel->points_gain  += $ruleInfo->points;
        $ret = $totalModel->save();
        if (!$ret) {
            Yii::log('cannot save totalModel for member_id('.$member_id.'): '.$totalModel->lastError(), 'error', __METHOD__);
            throw new CException($totalModel->lastError());
        }

        return $history_id = $this->logRuleHistory($member_id, $ruleInfo, $remark);
    }
    
    /*
        记录积分规则操作日志
        @param $member_id
        @param $rule_id
    */
    protected function logRuleHistory($member_id, $ruleInfo, $remark = '') {
        $nowTimeStr = date('Y-m-d H:i:s', time());
        $pointsHistory = new MemberPointsHistoryModel;
        $pointsHistory->member_id = $member_id;
        $pointsHistory->points = $ruleInfo->points;
        $pointsHistory->type = $ruleInfo->points > 0 ? 1 : 2;
        $pointsHistory->rule_id = $ruleInfo->rule_id;
        $pointsHistory->create_time = $nowTimeStr;
        $pointsHistory->remark = $remark ? $remark : $ruleInfo->rule_name;
        $ret = $pointsHistory->insert();
        if (!$ret) {
            throw new CException($pointsHistory->getError());
        }
        return $pointsHistory->id;
    }
    
    /*
        获取积分规则操作日志
        @param $member_id
    */
    public function getRuleLog($member_id, $page=1, $pageSize=10) {
    }
    
    /*
        获取积分规则操作日志
        @param $member_id
    */
    public function getMemberPointsLog($member_id, $page=1, $pageSize=10) {
        return $this->getRuleLog($member_id, $page, $pageSize);
    }
    
    /*
        获取用户信息
        @param $member_id
    */
    public function getMemberPoints($member_id) {
        $memberInfo = MemberTotalModel::model()->find('member_id=:member_id', array(':member_id'=>$member_id));
        if (!$memberInfo) {
            return false;
        }
        return $memberInfo->points_total;
    }
    /*
        获取用户信息
        @param $member_id
    */
    public function getMemberTotalInfo($member_id, $accounts_id = 1) {
        if ($member_id==0) {
            return null;
        }
        // 先查询
        $memberInfo = MemberTotalModel::model()->find('member_id=:member_id and accounts_id=:accounts_id', array(':member_id'=>$member_id, ':accounts_id'=>$accounts_id));
        if (!$memberInfo) {
            Yii::log('no member_total record for mid='.$member_id.', try to add', 'warning', __METHOD__);
            // 不存在 尝试创建
            $memberInfo = new MemberTotalModel;
            $memberInfo->member_id   = $member_id;
            $memberInfo->accounts_id = $accounts_id;
            $memberInfo->create_time = date('Y-m-d H:i:s');
            $ret = $memberInfo->insert();
            if (!$ret) {
                //throw new CException($memberInfo->getError());
                Yii::log('cannot add member_total for mid='.$member_id.': '.$memberInfo->getError(), 'error', __METHOD__);
            }
        }
        // 如果存在 缓存起来
        
        return $memberInfo;
    }
    /*
        获取用户等级信息
        @param $member_id
    */
    public function getMemberLevelInfo($member_id) {
        $memberInfo = $this->getMemberTotalInfo($member_id);
        $level = $memberInfo->level;
        $levelInfo = $this->getLevelInfo($level);
        return $levelInfo;
    }
    /*
        获取用户等级信息
        @param $member_id
    */
    public function getMemberTotalModel($member_id, $accounts_id = 1) {
        return $this->initMemberTotalInfo($member_id, $accounts_id);
    }
    public function initMemberTotalInfo($member_id, $accounts_id = 1) {
        if ($member_id==0) {
            return null;
        }
        // 先查询
        $memberInfo = MemberTotalModel::model()->find('member_id=:member_id and accounts_id=:accounts_id', array(':member_id'=>$member_id, ':accounts_id'=>$accounts_id));
        if (!$memberInfo) {
            // 不存在 尝试创建
            $memberInfo = new MemberTotalModel;
            $memberInfo->member_id   = $member_id;
            $memberInfo->accounts_id = $accounts_id;
            $memberInfo->create_time = date('Y-m-d H:i:s');
            $ret = $memberInfo->insert();
            if (!$ret) {
                //throw new CException($memberInfo->getError());
                Yii::log('cannot add member_total for mid='.$member_id.': '.$memberInfo->getError(), 'error', __METHOD__);
            } else {
                Yii::log('no member_total record for mid='.$member_id.', try to add, done', 'warning', __METHOD__);
            }
        }
        // 如果存在 缓存起来
        
        return $memberInfo;
    }
    /*
        升级
            此函数风险比较高
        @param $member_id
        @param $level_to_up default:0 0表示自然1级 >0表示升级到多少级
    */
    public function levelUp($member_id, $level_to_up) {
        $memberInfo = $this->getMemberTotalInfo($member_id);
        $level_to_up = (int)$level_to_up;
        if ($level_to_up == 0) {
            $memberInfo->level = $memberInfo->level+1;
        } elseif ($level_to_up > 0) {
            $memberInfo->level = $level_to_up;
        } else {
            Yii::log('param error: level_to_up='.$level_to_up.' mid='.$member_id, 'warning', __METHOD__);
        }
        $ret = $memberInfo->save();
        if (!$ret) {
            Yii::log(''.$memberInfo->getError().' mid='.$member_id.' level_to_up='.$level_to_up, 'error', __METHOD__);
        }
        return $ret;
    }
    /*
        获取等级信息
    */
    public function getLevelList() {
        $levelList = PointsLevelModel::model()->findAll();
        $arr = array();
        foreach ($levelList as $levelInfo) {
            $arr[$levelInfo->level_id] = $levelInfo->toArray();
        }
        return $arr;
    }
    /*
        获取当天签到记录
    */
    public function getCheckInList($member_id) {
        
        $checkInList = EventLogModel::model()->find('event_key="'.EventPointsChange::EVENT_KEY.'" and pre_event_key="'.$event_id.'" and sender_mid=:member_id and create_time>="'.date('Y-m-d 00:00:00', $now).'"', array(':member_id'=>$member_id));

    }
    /*
        获取当天签到记录
        @param $member_id
        @param $startTime 'Y-m-d H:i:s'
    */
    public function getCheckInLog($member_id, $startTime = "") {
        $ruleKey = 'check_in';
        $startTime || ($startTime = date('Y-m-d 00:00:00', time()));
        $pointsLog = MemberPointsHistoryModel::model()->orderBy('t.create_time desc')->with('rule')->findAll('member_id=:mid and rule.rule_key=:ruleKey and t.create_time>=:startTime', array(
            ':mid' => $member_id,
            ':ruleKey' => $ruleKey,
            ':startTime' => $startTime,
        ));

        return $pointsLog;
    }
    /*
        获取连续签到记录
        @param $member_id
        @param $startTime 'Y-m-d H:i:s'
    */
    public function getCheckInNdayLog($member_id, $startTime) {
        $ruleKey = 'check_in_nday';
        $startTime || ($startTime = date('Y-m-d 00:00:00', time()));
        $pointsLog = MemberPointsHistoryModel::model()->orderBy('t.create_time desc')->with('rule')->findAll('member_id=:mid and rule.rule_key=:ruleKey and t.create_time>=:startTime', array(
            ':mid' => $member_id,
            ':ruleKey' => $ruleKey,
            ':startTime' => $startTime,
        ));

        return $pointsLog;
    }
	/*
        获取用户积分明细记录
        @param $member_id
        @param $page 当前页数
        @param $pageSize 每页查询条数
    */
    public function getMemberPointsHistory($member_id, $page=1, $pageSize=10) {
		$arrSqlParam['select']			= 'id,points,type,remark,create_time,last_modified';
		$arrSqlParam['condition']		= 'member_id=:mid';
        $arrSqlParam['params'][':mid']	= $member_id;

        $total	= MemberPointsHistoryModel::model()->count($arrSqlParam);
        $list	= MemberPointsHistoryModel::model()->orderBy()->pagination($page, $pageSize)->findAll($arrSqlParam);
		$list	= OBJTool::convertModelToArray($list);
		
        $result = array(
            'total'		=> $total,
            'page'		=> $page,
            'pageSize'	=> $pageSize,
            'list'		=> $list,
        );
        return $result;
    }
}
