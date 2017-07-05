<?php
/**
 * friend 模块
 * xuduorui@qq.com
 */
class FriendModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
            'application.common.extensions.*',
            'application.ucentermob.api.*',
            'application.ucentermodels.*',
            'application.xahoomodels.*',
            'friend.libirarys.*',
			'friend.controllers.*',
			'friend.models.*',
		));
	}

	public function welcome() 
	{
		echo "welcome to ".__CLASS__."\n";
		return false;
	}
    
    /**
    * 获取好友列表
    *   // 此数据最好缓存起来
    * @param $member_id
    */
    public function getFriendList($member_id, $page=1, $pageSize=8) {

        $connection=Yii::app()->db;
        $startPos = ($page-1)*$pageSize;
        $totalSql = "SELECT count(friend_id) as total FROM fh_member_friend where member_id='$member_id'";
        $totalRet = $connection->createCommand($totalSql)->queryAll();

        $sql="SELECT friend_id FROM fh_member_friend where member_id='$member_id' limit $startPos,$pageSize;";
        $users=$connection->createCommand($sql)->queryAll();
//print_r($users);exit;
        $arr = array(
            'total' => $totalRet[0]['total'],
            'page' => $page,
            'pageSize' => $pageSize,
            'list' => $users,
        );
        return $arr;
    }
    
    /**
    * 添加好友 单向
    * @param $member_id
    * @param $friend_id
    */
    public function addFriend($member_id, $friend_id, $from=MemberFriendModel::FROM_INVITE) {
        $friendModel = new MemberFriendModel;
        $friendModel->member_id = $member_id;
        $friendModel->friend_id = $friend_id;
        $friendModel->from = $from;
        $friendModel->create_time = date('Y-m-d H:i:s', time());
        $ret = $friendModel->insert();
        if (!$ret) {
            Yii::log(__METHOD__ .': '.$friendModel->getError().' mid='.$member_id.' fid='.$friend_id, 'error', 'FriendModule');
        }
        return $ret;
    }

    /*
        建立好友关系 双向添加好友
        @param $member_id
        @param $friend_id
    */
    public function makeFriendShip($member_id, $friend_id, $from=1){
        $this->makeOneSideFriendShip($member_id, $friend_id, $from);
        $this->makeOneSideFriendShip($friend_id, $member_id, $from);
        return true;
    }

    /*
        建立好友关系 单向添加好友
        @param $member_id
        @param $friend_id
    */
    public function makeOneSideFriendShip($member_id, $friend_id, $from=1){
        $friendShip = new MemberFriendModel;
        $friendShip->member_id = $member_id;
        $friendShip->friend_id = $friend_id;
        $friendShip->from = $from;
        if (!$friendShip->save()) {
            Yii::log(':'.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        }
        return true;
    }

    /*
        制造不重复邀请码
        @param $member_id
    */
    public function makeInviteCode($member_id) {
        $len = 6;
        $tryTimes = 100;
        $inviteCode = '';
        for ($i=0; $i<$tryTimes; ++$i) {
            $inviteCode = MemberInviteCodeModel::genInviteCode($len+(int)($i/$len), $member_id);
            $inviteCodeModel = MemberInviteCodeModel::model()->find('invite_code=:code', array(':code'=>$inviteCode));
            if (!$inviteCodeModel) {
                // 如果不存在 跳出
                break;
            }
            // 存在 继续尝试
            $inviteCode = '';
        }
        $inviteCodeModel = new MemberInviteCodeModel;
        $inviteCodeModel->member_id = $member_id;
        $inviteCodeModel->invite_code = $inviteCode;
        if (!$inviteCodeModel->insert()) {
            Yii::log(__METHOD__ .': cannot create invite code for mid='.$member_id.' :'.$inviteCodeModel->getError(), 'error', 'FriendModule');
            return false;
        }
        return $inviteCodeModel;
    }

    /*
        获取邀请码
        @param $member_id
    */
    public function getInviteCodeModel($member_id) {
        $inviteCodeModel = MemberInviteCodeModel::model()->find('member_id=:mid', array(':mid'=>$member_id));
        if (!$inviteCodeModel) {
            $inviteCodeModel = $this->makeInviteCode($member_id);
        }
        if (!$inviteCodeModel) {
            Yii::log(__METHOD__ .': cannot get invite code for mid='.$member_id.'! ', 'error', 'FriendModule');
        }
        return $inviteCodeModel;
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
    public function getMemberTotalInfo($member_id) {
        // 先查询
        $memberInfo = MemberTotalModel::model()->find('member_id=:member_id', array(':member_id'=>$member_id));
        if (!$memberInfo) {
            Yii::log(__METHOD__ .': no member_total record for mid='.$member_id.', try to add', 'warning', 'PointsModule');
            // 不存在 尝试创建
            $memberInfo = new MemberTotalModel;
            $memberInfo->member_id = $member_id;
            $ret = $memberInfo->insert();
            if (!$ret) {
                //throw new CException($memberInfo->getError());
                Yii::log(__METHOD__.': cannot add member_total for mid='.$member_id.': '.$e->getMessage(), 'error', 'PointsModule');
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
            Yii::log(__METHOD__ .': param error: level_to_up='.$level_to_up.' mid='.$member_id, 'warning', 'PointsModule');
        }
        $ret = $memberInfo->save();
        if (!$ret) {
            Yii::log(__METHOD__ .': '.$memberInfo->getError().' mid='.$member_id.' level_to_up='.$level_to_up, 'error', 'PointsModule');
        }
        return $ret;
    }
}
