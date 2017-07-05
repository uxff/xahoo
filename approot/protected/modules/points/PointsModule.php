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
            'application.xahoomodels.*',
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

        if ($ruleInfo->flag == PointsRuleModel::FLAG_DYNAMIC || $points > 0) {
            $ruleInfo->points = $points;
        }

        if ($ruleInfo->points == 0) {
            //throw new CException('unknown rule_id: '.$rule_id);
            Yii::log('points is zero, none to do. '.$keyType.': '.$rule_id, 'warning', __METHOD__);
            return false;
        }
        // begin transaction
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $totalModel = $this->getMemberTotalInfo($member_id);
            if (!$totalModel) {
                throw new CException('member total info cannot be created! mid='.$member_id);
            }

            $history_id = $this->execRuleForTransaction($totalModel, $ruleInfo, $remark);

            $transaction->commit();
        } catch (CException $e) {
            $transaction->rollback();
            Yii::log(''.$e->getMessage(), 'error', __METHOD__);
            return false;
        }

        Yii::log('done: mid='.$member_id.' rule_id='.$rule_id.' rule_key='.$ruleInfo->rule_key.' points='.$ruleInfo->points.'('.$points.')'.' flag='.$ruleInfo->flag, 'warning', __METHOD__);

        $this->tryToLevelUp($totalModel);

        return $history_id;
    }
    /*
        执行积分
        提供给事务使用 会抛错
    */
    public function execRuleForTransaction(MemberTotalModel $totalModel, PointsRuleModel $ruleModel, $remark = '') {

        $totalModel->points_total += $ruleModel->points;
        if ($ruleModel->points >= 0) {
            $totalModel->points_gain  += $ruleModel->points;
        } else {
            $totalModel->points_consume  += $ruleModel->points;
        }

        $ret = $totalModel->save();
        if (!$ret) {
            Yii::log('cannot save totalModel for member_id('.$totalModel->member_id.'): '.$totalModel->lastError(), 'error', __METHOD__);
            throw new CException($totalModel->lastError());
        }

        return $history_id = $this->logRuleHistory($totalModel->member_id, $ruleModel, $remark);
    }
    
    /*
        记录积分规则操作日志
        @param $member_id
        @param $rule_id
    */
    protected function logRuleHistory($member_id, $ruleModel, $remark = '') {
        $nowTimeStr = date('Y-m-d H:i:s', time());
        $pointsHistory = new MemberPointsHistoryModel;
        $pointsHistory->member_id = $member_id;
        $pointsHistory->points = $ruleModel->points;
        $pointsHistory->type = $ruleModel->points > 0 ? 1 : 2;
        $pointsHistory->rule_id = $ruleModel->rule_id;
        $pointsHistory->create_time = $nowTimeStr;
        $pointsHistory->remark = $remark ? $remark : $ruleModel->rule_name;
        $ret = $pointsHistory->insert();
        if (!$ret) {
            throw new CException($pointsHistory->lastError());
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
                //throw new CException($memberInfo->lastError());
                Yii::log('cannot add member_total for mid='.$member_id.': '.$memberInfo->lastError(), 'error', __METHOD__);
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
        return $this->getMemberTotalInfo($member_id, $accounts_id);
    }
    /*
        升级
            此函数风险比较高
        @param $member_id
        @param $level_to_up default:0 0表示自然1级 >0表示升级到多少级
    */
    public function levelUp($member_id, $level_to_up = 0) {
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
            Yii::log(''.$memberInfo->lastError().' mid='.$member_id.' level_to_up='.$level_to_up, 'error', __METHOD__);
        }
        return $ret;
    }
    /*
        尝试升级
        // 积分余额和等级对应关系，由积分模块维护，其他模块不应干涉
        @param $totalModel
    */
    public function tryToLevelUp(MemberTotalModel $totalModel) {
        if (!($totalModel instanceof MemberTotalModel)) {
            return false;
        }
        $originLevel = $totalModel->level;

        $levelOfPoints = $this->calcLevelByPoints($totalModel->points_total);
        try {
            // 如果{member_total 记录的等级}比{按积分余额计算出的等级}低，则执行升级
            while ($totalModel->level < $levelOfPoints) {
                $totalModel->level = $totalModel->level+1;
                $ret = $totalModel->save();
                if (!$ret) {
                    Yii::log(''.$totalModel->lastError().' mid='.$totalModel->member_id.' level='.$totalModel->level, 'error', __METHOD__);
                }

                // 执行升级奖励
                $this->execRuleByRuleKey($totalModel->member_id, PointsRuleModel::RULE_KEY_LEVEL_UP);

                Yii::log('aotu level up:'.' mid='.$totalModel->member_id.' level='.$totalModel->level, 'warning', __METHOD__);
                $levelOfPoints = $this->calcLevelByPoints($totalModel->points_total);
            }
        } catch (CException $e) {
            Yii::log(''.$e->getMessage().' mid='.$totalModel->member_id.' origin level='.$originLevel.' levelOfPoints='.$levelOfPoints.' level now='.$totalModel->level, 'error', __METHOD__);
        }

        return true;
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
        @param $member_id
        @param $startTime 'Y-m-d H:i:s'
    */
    public function getCheckInLog($member_id, $startTime = '') {
        $ruleKey = PointsRuleModel::RULE_KEY_CHECKIN;
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
    public function getCheckInNdayLog($member_id, $startTime = '') {
        $ruleKey = PointsRuleModel::RULE_KEY_CHECK_IN_NDAY;
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
    public function checkIn($member_id) {
        // 检查当天内是否已经获得该经验 
        $checkInLog = $this->getCheckInLog($member_id);
        if ($checkInLog) {
            Yii::log('he('.$member_id.') has already got checkInLog today!', 'warning', __METHOD__);
            return false;
        }

        if ($this->execRuleByRuleKey($member_id, PointsRuleModel::RULE_KEY_CHECKIN)) {
            $this->tryToCheckInNday($member_id);
            return true;
        }

        return false;
    }
    /*
        获取连续签到记录
        @param int $member_id
        @param int $nday = 7 默认7天签到
    */
    public function tryToCheckInNday($member_id, $nday = 7) {
        // 检查7天内是否已经获得该经验 
        $startTime = date('Y-m-d 00:00:00', time()-86400*($nday-1));
        $checkInNdayLog = $this->getCheckInNdayLog($member_id, $startTime);
        if ($checkInNdayLog) {
            Yii::log('he('.$member_id.') has already got checkInNdayLog today!', 'warning', __METHOD__);
            return false;
        }

        // 检查7天内签到次数是否满足
        $checkInLog = $this->getCheckInLog($member_id, $startTime);
        if (count($checkInLog) >= $nday) {
            if ($this->execRuleByRuleKey($member_id, PointsRuleModel::RULE_KEY_CHECK_IN_NDAY)) {
                return true;
            }
        }

        return false;
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
