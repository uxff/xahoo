<?php

class LotController extends BaseController {

    const POINTS_PER_BET    = 200;  // 投注的积分成本
    const TIMES_PER_DAY     = 3;    // 每日投注次数
    
    const RULE_KEY_BET          = 'lot_bet';
    const RULE_KEY_PRIZE_50     = 'lot_prize_50';
    const RULE_KEY_PRIZE_100    = 'lot_prize_100';
    const RULE_KEY_PRIZE_500    = 'lot_prize_500';

    const ERR_OK                = 1;
    const ERR_DB                = 2;   // 数据库错误
    const ERR_NO_ENOUGH_POITNS  = 10;   // 没有足够多的积分
    const ERR_DAY_TIMES_EXCEED  = 11;   // 每日投注次数超限
    

    protected $pointsModule;
    private   $errCode = self::ERR_OK;
    private   $winListCacheKey = 'fh_lot_win_list';

    private   $myRemainBetTimes     = 0;    // 当日剩余次数
    private   $myPoints             = 0;    // 我的积分

    public function init() {
        parent::init();
        $this->pointsModule = Yii::app()->getModule('points');
    }
    public function actionIndex() {
        $member_id = Yii::app()->loginUser->getUserId();

        // token
        $webToken = new WebToken;
        $token = $webToken->makeToken();

        // 我的积分
        if ($member_id) {
            $totalInfo = $this->pointsModule->getMemberTotalModel($member_id);
        }

        // 抽奖次数
        if ($member_id) {
            $this->myRemainBetTimes = self::TIMES_PER_DAY - $this->getBetTimesTodayNum($member_id);
        } else {
            $this->myRemainBetTimes = self::TIMES_PER_DAY;
        }
        // 奖品列表
        $productList = FhLotProductModel::model()->findAll('status=1');
        // 中奖名单
        $allWinList = $this->getWinList();
        // 我的奖品
        $myWinList = $this->getMyWinList($member_id);
        
        $arrRender = array(
            //'gShowFooter' => true,
            'member_id'         => $member_id,
            'logout_return_url' => $this->createAbsoluteUrl("lot/index"),
            'totalInfo'         => $totalInfo,
            'pageTitle'         => '积分抽奖',
            'token'             => $token,
            'productList'       => $productList,
            'myWinList'         => $myWinList,
            'listSum'           => count($myWinList),
            'allWinList'        => $allWinList,
            'myBetTimes'        => $this->myRemainBetTimes,
        );
		$this->layout = "layouts/lot.tpl";
        $this->smartyRender('lot/index.tpl',$arrRender);
    }
    public function actionAjaxBet() {
        //判断来源IP与时间是否重复
        session_start(); 
        // check token
        $webToken = new WebToken;
        $member_id = Yii::app()->loginUser->getUserId();
        if(empty($_SESSION[$member_id])){
            $_SESSION[$member_id]['REMOTE_ADDR']    = $_SERVER['REMOTE_ADDR'];
            $_SESSION[$member_id]['REQUEST_TIME']   = $_SERVER['REQUEST_TIME'];
        }else{
            if($_SESSION[$member_id]['REMOTE_ADDR'] == $_SERVER['REMOTE_ADDR'] && $_SESSION[$member_id]['REQUEST_TIME'] == $_SERVER['REQUEST_TIME']){
                $this->jsonError('服务器忙，请刷新后再试。', ['status'=>2, 'token'=>'']);
            }else{
                $_SESSION[$member_id]['REMOTE_ADDR']    = $_SERVER['REMOTE_ADDR'];
                $_SESSION[$member_id]['REQUEST_TIME']   = $_SERVER['REQUEST_TIME'];                
            }
        }
        
        
        $token = $_POST['token'];

        if (!$webToken->checkToken($token)) {
            //除了验证token失败不下发token,其他情况更新token
            $this->jsonError('服务器忙，请刷新后再试。', ['status'=>2, 'token'=>'']);
        }

        if (!$member_id) {
            $selfUrl = $this->createAbsoluteUrl('Lot/index');
            $this->jsonError('<p>您还没有登录，登录后才能抽奖哦！</p>', ['status'=>1, 'token'=>$webToken->getToken(), 'redirect_url'=>$this->createAbsoluteUrl('user/login', ['return_url'=>$selfUrl])]);
        }

        // 交钱
        if (!$this->payBet($member_id, self::POINTS_PER_BET)) {
            $errMsg = $this->getErrorStr($this->errCode);
            // 重新下发token 前端要求更新token
            $newToken = $webToken->getToken();
            $this->jsonError($errMsg, ['status'=>0, 'token'=>$newToken]);
        }

        // 模拟抽奖
        $item = $this->bet($member_id);
        if ($item['id']) {
            $msg = '<p>本次抽奖消耗 <span class="jf"> 积分'.self::POINTS_PER_BET.' </span> </p><br><div class="winning"><p class="big">您抽中了<span class="jf">'.$item['name'].' </span>！</p></div>';
        } else {
            $msg = '<p>本次抽奖消耗 <span class="jf"> 积分'.self::POINTS_PER_BET.' </span> </p><p class="big">您未中奖,谢谢参与！</p>';
        }
        //获取用户最新积分
        $totalInfo = $this->pointsModule->getMemberTotalModel($member_id);
        $data = [
            'item_id'       => $item['id'],
            'item_name'     => $item['name'],
            'token'         => $webToken->getToken(),
            'remain_times'  => $this->myRemainBetTimes,
            'ponts_total'   => $totalInfo->points_total,
        ];

        $this->jsonSuccess($msg, $data);
    }
    /*
        扣积分
        @return int MemberPointsHistoryModel->id 成功返回积分记录id,失败返回false
    */
    public function payBet($member_id, $payPoints, $remark='积分抽奖') {
        // 1 开启事务
        $ret = false;
        $trans = Yii::app()->db->beginTransaction();
        try {
            // 查看今日抽奖机会
            $this->myRemainBetTimes = self::TIMES_PER_DAY - $this->getBetTimesTodayNum($member_id);
            if ($this->myRemainBetTimes<=0) {
                $this->errCode = self::ERR_DAY_TIMES_EXCEED;
                throw new CException('bet times per day exceed: max='.self::TIMES_PER_DAY);
            }
            $this->myRemainBetTimes -= 1;

            // 2 检查积分余额
            //$sql = 'select member_total from fh_member_total where member_id='.$member_id;
            //$memberTotal = Yii::app()->db->createCommand($sql)->queryAll();
            $totalInfo = $this->pointsModule->getMemberTotalModel($member_id);
            if ($totalInfo->points_total<$payPoints) {
                $this->errCode = self::ERR_NO_ENOUGH_POITNS;
                throw new CException('no enough points: now='.$totalInfo->points_total.' need='.$payPoints);
            }
            $this->myPoints = $totalInfo->points_total;

            //$totalInfo->detachBehavior('CTimestampBehavior');

            // 3 扣除积分
            //$totalInfo->points_total = new CDbExpression('points_total-'.self::POINTS_PER_BET);
            $update = MemberTotalModel::model()->updateByPk($totalInfo->id,array(
                'points_total' => new CDbExpression('points_total-'.$payPoints),
                'points_consume' => new CDbExpression('points_consume+'.$payPoints),
            ));
            if (!$update) {
                $this->errCode = self::ERR_DB;
                throw new CException('save total info failed:'.$totalInfo->lastError());
            }
            
            // 4 增加余额记录
            $his = new MemberPointsHistoryModel;
            $his->member_id     = $member_id;
            $his->points        = - $payPoints;
            $his->type          = MemberPointsHistoryModel::TYPE_CONSUME;
            $his->remark        = $remark;
            $his->create_time   = date('Y-m-d H:i:s', time());
            $his->rule_id       = $this->getRuleIdByRuleKey(self::RULE_KEY_BET);
            if (!$his->save()) {
                $this->errCode = self::ERR_DB;
                throw new CException('save points his failed:'.$his->lastError());
            }
            $this->myPoints -= $payPoints;

            // 5 事务结束
            $trans->commit();
            $ret = $his->id;
            Yii::log('pay bet success!'.' ', 'warning', __METHOD__);
        } catch (CException $e) {
            $trans->rollback();
            $ret = false;
            Yii::log('pay bet failed:'.$e->getMessage().' ', 'error', __METHOD__);
        }

        return $ret;
    }
    /*
        获取今日中奖次数
    */
    public function getBetTimesToday($member_id) {
        $startTime = date('Y-m-d 00:00:00', time());
        $ret = Yii::app()->db->createCommand()
            ->select('count(id) cnt')
            ->from('fh_activity_lottery_log')
            ->where('member_id=:mid and create_time>:startTime', [':mid'=>$member_id, ':startTime'=>$startTime])
            ->queryAll();
        return $ret[0]['cnt'];
    }
    //获取今日积分消费记录
    public function getBetTimesTodayNum($member_id) {
        $startTime = date('Y-m-d 00:00:00', time());
        $ret = Yii::app()->db->createCommand()
            ->select('count(id) cnt')
            ->from('fh_member_points_history')
            ->where('member_id=:mid and rule_id=:rule_id and create_time>:startTime', [':mid'=>$member_id, ':rule_id'=>$this->getRuleIdByRuleKey(self::RULE_KEY_BET), ':startTime'=>$startTime])
            ->queryAll();
        return $ret[0]['cnt'];
    }
    public function getRuleIdByRuleKey($ruleKey) {
        static $arrId = [];
        if (isset($arrId[$ruleKey])) {
            return $arrId[$ruleKey];
        }

        $ret = Yii::app()->db->createCommand()
            ->select('rule_id')
            ->from('fh_points_rule')
            ->where('rule_key=:key', [':key'=>$ruleKey])
            ->queryAll();
        return $ret[0]['rule_id'];
    }
    /*
        根据奖品抽奖
        @return $item = ['id'=>奖品id, 'name'='奖品名称']
    */
    public function bet($member_id) {
        // 默认中谢谢参与
        $item = [
            'id'    => 0,
            'name'  => '谢谢参与',
        ];
        // memberInfo
        $memberInfo = UcMember::model()->findByPk($member_id);

        $trans = Yii::app()->db->beginTransaction();

        try {
            //取出奖品 不包含谢谢参与
            $prize_arr = FhLotProductModel::model()->orderBy('rate')->findAll('status = 1');
            $prize_arr = $this->convertModelToArray($prize_arr);

            //中奖概率基数 
            foreach($prize_arr as $key=>$val){
                $num += $val['rate'];
            }
            // +谢谢参与的几率是20% 投点范围增加为包含谢谢参与
            $num = (int)($num/0.8);

            $hitItem = null;
            // 只投一次点 投多次不公平
            //获取一个1到当前基数范围的随机数
            $rand = mt_rand(1, $num);
            //$prizeDotStart = 1;
            //$prizeDotEnd   = 0;
            //Yii::log('rand='.$rand.' num='.$num.' ', 'warning', __METHOD__);
            foreach($prize_arr as $k=>$v){
                //$prizeDotEnd   = $prizeDotStart + $v['rate'];
                //Yii::log('in select rand='.$rand.' v.id='.$v['id'].' v.rate='.$v['rate'].' prize.s='.$prizeDotStart.' prize.e='.$prizeDotEnd.' ', 'warning', __METHOD__);
                //$prizeDotStart += $v['rate'];

                if($rand <= $v['rate']){
                    if ($v['stock']>0) {
                        // 中奖
                        $hitItem = $v;
                        $item['id'] = $v['id'];
                        $item['name'] = $v['name'];
                    } else {
                        Yii::log('no stock then thanks: product_id='.$v['id'].' ', 'warning', __METHOD__);
                    }
                    break;
                }else{
                    // 未中
                    $rand -= $v['rate'];
                }
            }
            //Yii::log('after rand='.$rand.' v.id='.$v['id'].' v.rate='.$v['rate'].' ', 'warning', __METHOD__);

            $hitStatus = FhActivityLotteryModel::STATUS_HIT_NONE;

            if ($hitItem) {
                $hitStatus = FhActivityLotteryModel::STATUS_HIT_YES;
                //中奖后更新库存
                $update = FhLotProductModel::model()->updateByPk($hitItem['id'],array(
                    'stock' => new CDbExpression('stock-1'),
                    'history_stock'=> new CDbExpression('history_stock+1'),
                ));

                // 如果是积分 则派发积分
                $extraInfo = @json_decode($v['extra'], true);
                if (!empty($extraInfo) && $extraInfo['rule_key']) {
                    //$ruleId = $this->getRuleIdByRuleKey($extraInfo['rule_key']);
                    $ruleInfo = PointsRuleModel::model()->find('rule_key=:key', [':key'=>$extraInfo['rule_key']]);
                    if (empty($ruleInfo)) {
                        $this->errCode = self::ERR_DB;
                        throw new CException('rule key not exist:'.$extraInfo['rule_key']);
                    }
                    $totalModel = $this->pointsModule->getMemberTotalModel($member_id);
                    if ($this->pointsModule->execRuleForTransaction($totalModel, $ruleInfo)) {
                        // 标记为已派奖 // 暂不标记
                        //$hitStatus =  FhActivityLotteryModel::STATUS_DISPATCHED;
                    }
                }
            }

            //插入日志
            $lotHis = new FhActivityLotteryModel;
            $data2['member_id'] = $member_id;
            $data2['member_mobile'] = $memberInfo->member_mobile;//Yii::app()->loginUser->getUserName();//'1888888888';
            $data2['member_name'] = $memberInfo->member_fullname;//Yii::app()->loginUser->getUserNick();//'aaaa';
            $data2['prize'] = $item['name'];
            $data2['product_id'] = $item['id'];
            $data2['points'] = self::POINTS_PER_BET;
            $data2['status'] = $hitStatus;
            $data2['create_time'] = date("Y-m-d H:i:s");
            $data2['last_modified'] = date("Y-m-d H:i:s");
            $lotHis->attributes = $data2;
            if (!$lotHis->save()) {
                $this->errCode = self::ERR_DB;
                throw new CException($lotHis->lastError());
            }
            

            $trans->commit();
            Yii::log('bet success! mid='.$member_id.' status='.$hitStatus.' prize='.$item['name'].' rand='.$rand.' ', 'warning', __METHOD__);
        } catch (CException $e) {
            $trans->rollback();
            Yii::log('bet failed(mid='.$member_id.'):'.$e->getMessage().' ', 'error', __METHOD__);
        }
        return $item;
    }
    /*
        获取最近中间名单
    */
    public function actionAjaxGetWinList() {
        $data = $this->getWinList();
        $this->jsonSuccess('ok', $data);
    }
    /*
        获取最近中奖名单
    */
    public function getWinList() {
        // 先取缓存 再取数据库
        $arr = $this->getWinListCache();
        if (!empty($arr)) {
            //Yii::log('got in cache'.' ', 'warning', __METHOD__);
            return $arr;
        }
        //Yii::log('got NONE in cache'.' ', 'warning', __METHOD__);

        $fakeList = [
            ['member_mobile'=>'15011111155', 'prize'=>'iPhone6S'],
            ['member_mobile'=>'13581963847', 'prize'=>'小米48英寸液晶电视'],
            ['member_mobile'=>'15313144345', 'prize'=>'小米48英寸液晶电视'],
            ['member_mobile'=>'18611867007', 'prize'=>'iPhone6S'],
            ['member_mobile'=>'18611177719', 'prize'=>'小米48英寸液晶电视'],
            ['member_mobile'=>'18729328538', 'prize'=>'iPhone6S'],
            ['member_mobile'=>'15241254321', 'prize'=>'小米48英寸液晶电视'],
            ['member_mobile'=>'13500498591', 'prize'=>'iPhone6S'],
            //['mobile'=>'15313144345', 'prize'=>'小米48英寸液晶电视'],
            //['mobile'=>'15313144345', 'prize'=>'iPhone6S'],
        ];
        //$recentList = FhActivityLotteryModel::model()->orderBy('t.id desc')->findAll('');
        $sql = 'select member_mobile, prize ';
        $recentList = Yii::app()->db->createCommand()
            ->select('member_mobile, prize')
            ->from('fh_activity_lottery_log')
            ->where('status=2')
            ->order('id desc')
            ->limit(49)
            ->queryAll();
        $fakeOne = $fakeList[mt_rand(0, count($fakeList)-1)];
        array_push($recentList, $fakeOne);
        $arr = $recentList;
        //print_r($arr);exit;
        shuffle($arr);
        foreach ($arr as $k=>&$v) {
            $arr[$k]['member_mobile'] = Tools::miscMobile($arr[$k]['member_mobile']);
        }
        // 不足50 复制拼够50
        while (count($arr) && count($arr)<50) {
            $arr = array_merge($arr, $arr);
        }
        $arr = array_slice($arr, 0, 50);
        $this->setWinListCache($arr);
        return $arr;
    }
    protected function getWinListCache() {
        $cacheKey = $this->winListCacheKey;
        if (Yii::app()->cache) {
            $ret = Yii::app()->cache->get($cacheKey);
        }
        return $ret;
    }
    protected function setWinListCache($value, $expire=100) {
        $cacheKey = $this->winListCacheKey;
        if (Yii::app()->cache) {
            $ret = Yii::app()->cache->set($cacheKey, $value, $expire);
        }
        return $ret;
        
    }
    /*
        获取个人的中奖奖品列表
    */
    public function getMyWinList($member_id, $limit = 5) {
        $winList = Yii::app()->db->createCommand()
            ->select('a.product_id, a.prize, a.create_time, p.pic_url')
            ->from('fh_activity_lottery_log a')
            ->leftJoin('fh_lot_product p', 'p.id=a.product_id')
            ->where('a.status=2 and a.member_id=:mid', [':mid'=>$member_id])
            ->order('a.id desc')
            ->limit($limit)
            ->queryAll();

        foreach ($winList as $k=>&$v) {
            $winList[$k]['create_time'] = date('Y年m月d日 H:i:s', strtotime($v['create_time']));
        }
        return $winList;
    }
    /*
        错误描述
    */
    public function getErrorStr($errCode) {
        $arrErrorCode = [
            self::ERR_OK                => '成功',
            self::ERR_DB                => '服务器忙，请稍后后再试。(db error)',
            self::ERR_NO_ENOUGH_POITNS  => '<p>您的积分不足 <span class="jf"> '.self::POINTS_PER_BET.' </span>不能参与抽奖 </p><p class="big">快去做任务赚积分吧！</p>',
            self::ERR_DAY_TIMES_EXCEED  => '<p>您今天已经抽过'.self::TIMES_PER_DAY.'次奖了！明天再来吧！</p>',
        ];
        $str = '服务器忙，请稍后再试';
        if (isset($arrErrorCode[$errCode])) {
            $str = $arrErrorCode[$errCode];
        }
        return $str;
    }
}
