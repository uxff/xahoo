<?php

//Yii::import('application.ucentermob.config.*.php');
Yii::import('application.ucentermob.api.*');
//Yii::import('application.ucentermob.models.*');
Yii::import('application.ucentermob.components.UCenterActiveRecord');
//Yii::import('application.ucentermodels.*');
//Yii::import('application.ucentermob.api.UCenterStatic');
//Yii::import('application.ucenterpc.controllers.BaseController');

class MyController extends BaseController
{
    public function init() {
        parent::init();
        Yii::app()->getModule('mtask');
        //Yii::app()->getModule('mfavor');
        Yii::app()->getModule('points');
    }

    /*
        我的首页
    */
    public function actionIndex() {
        $this->checkLogin();

        $member_id = Yii::app()->loginUser->getUserId();
        $totalInfo = Yii::app()->getModule('points')->getMemberTotalInfo($member_id);
        $memberInfo = Member::model()->findByPk($member_id);
        $levelList = Yii::app()->getModule('points')->getLevelList();
		$arrMsgStack = Yii::app()->loginUser->getFlashes();

        // 获取签到事件记录
        $checkInLog = Yii::app()->getModule('points')->getCheckInLog($member_id);
        // 计算经验比例
        $percentLevelUp = $totalInfo->points_gain * 1.0 / $levelList[$totalInfo->level]['max_points'] * 100.0;
        $percentLevelUp = $percentLevelUp > 100 ? 100 : $percentLevelUp;
        $percentLevelUp = $percentLevelUp <= 0 ? 2 : $percentLevelUp;
        //满级经验上不封顶 但是进度显示100%
        $percentLevelUp = $totalInfo->level==5 ? 100 : $percentLevelUp;

        $invite_code = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;

        $arrRender = array(
			'gShowHeader' => false,
			'gShowFooter' => false,
			'return_url' => $return_url,
			'pageTitle' =>'我的房乎',
			'invite_code' => $invite_code,
            'logout_return_url' => $this->createAbsoluteUrl('site/index'),
            'memberInfo' => $memberInfo,
            'totalInfo' => $totalInfo,
            'percentLevelUp' => $percentLevelUp,
            'levelList' => $levelList,
            'arrMsgStack' => $arrMsgStack,
            'checkBtnText' => ($checkInLog?'已签到':'签到'),
        );
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/index.tpl',$arrRender);
    }

	/*
	 *邀请好友 
	 */
	public function actionInviteFriend()
	{
		$this->checkLogin();

        $member_id = Yii::app()->loginUser->getUserId();

		$invite_code_model =Yii::app()->getModule('friend')->getInviteCodeModel($member_id);
		$invite_code = $invite_code_model->invite_code;


		$arrRender=array(
			'gShowHeader' => true,
			'gShowFooter' => true,
			'return_url' => $return_url,
			'pageTitle' =>'邀请好友',
			'invite_code' => $invite_code,
		);

		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/invitefriend.tpl',$arrRender);
	}

	

	/*
	 *我的好友
	 */
	public function actionMyFriend()
	{

		$this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();
		

		$friends = Yii::app()->getModule('friend')->getFriendList($member_id);
        // 获取好友的信息
        if (!empty($friends['list']))
        foreach ($friends['list'] as $key=>$friendObj) {
            //$friendObj['friend_id'];
            $ucMemberModel = UcMember::model()->findByPk($friendObj['friend_id']);
            $friends['list'][$key] = OBJTool::convertModelToArray($ucMemberModel);
        }

		$arrRender=array(
			'gShowHeader' => true,
			'gShowFooter' => true,
			'return_url' => $return_url,
			'pageTitle' => '我的好友',
			'friends' => $friends,
		);
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/myfriend.tpl',$arrRender);

	}
	
	/*
	 *我的好友AJAX翻页
	 */
	public function actionAjaxMyFriend()
	{
		$this->checkLogin();
		
		$page = $this->getInt($_GET['page']);
		$size = $this->getInt($_GET['size']);

        $member_id = Yii::app()->loginUser->getUserId();
		
		$friends = Yii::app()->getModule('friend')->getFriendList($member_id, $page, $size);

        // 获取好友的信息
        if (!empty($friends['list']))
        foreach ($friends['list'] as $key=>$friendObj) {
			$friend_attr = array();

            $ucMemberModel = UcMember::model()->findByPk($friendObj['friend_id']);
			
			$friend_attr = OBJTool::convertModelToArray($ucMemberModel);
			$friends['list'][$key] = $this->_pruneFriendAttributes($friend_attr);
        }
		$this->showJson($friends);
	}
	
	/*
	 *我的好友信息去除无用字段
	 */
	private function  _pruneFriendAttributes($friend_attr) {
		$useful_fields = array('member_id', 'member_avatar', 'member_fullname', 'member_mobile');
		foreach ($friend_attr as $key => $val) {
			if (!in_array($key, $useful_fields)) unset($friend_attr[$key]);
		}
		return $friend_attr;
	}
	
    /*
        ajax 获取invite_code
    */
    public function actionGetInviteCode() {
        $arr = array(
            'code' => 0,
            'msg' => 'ok',
            'value' => '',
        );
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $arr['code'] = 1;
            $arr['msg'] = '请登录后尝试';
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
            $invite_code_model = Yii::app()->getModule('friend')->getInviteCodeModel($member_id);
            $arr['value'] = $invite_code_model->invite_code;
        }

        $this->showJson($arr);
    }
    /*
        退出登录
    */
    public function actionLogout() {
        if(isset($_GET['logout_return_url'])&& !empty($_GET['logout_return_url'])){
            $return_url = $this->outPutString($_GET['logout_return_url']);
            //$params = array(
            //	'return_url' =>  $this->getString($_GET['logout_return_url']),
            //);
        }else{
            $return_url = $this->createAbsoluteUrl('site/index');
                //$params = array(
                //	'return_url' => $this->createAbsoluteUrl('site/index'),
                //);
        }
        Yii::app()->loginUser->logoutAndClearStates();
        //$ucenterLoginUrl = $this->createUCenterUrl('user/Logout', $params);
        $this->redirect($return_url);
    }
    /*
        我的任务
    */
    public function actionTask() {
		$this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();

        $taskModule = Yii::app()->getModule('mtask');
        $status = $_GET['status'];
        $condition = array();
        if ($status && is_int($status)) {
            $condition['status'] = $status;
        }
        $myTaskListAll = $taskModule->getMemberTaskList($member_id, $condition);
        $myTaskListFinished = $taskModule->getMemberTaskList($member_id, array('status'=>2));
        $myTaskListAchieved = $taskModule->getMemberTaskList($member_id, array('status'=>1));
        $shareCode = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;
        $csrfToken = Yii::app()->request->csrfToken;

		$arrRender=array(
			'gShowHeader' => true,
			'gShowFooter' => true,
			'pageTitle' => '我的任务',
            'myTaskListAll' => $myTaskListAll,
            'myTaskListFinished' => $myTaskListFinished,
            'myTaskListAchieved' => $myTaskListAchieved,
            'shareCode' => $shareCode,
            'token' => $csrfToken,
		);
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/task.tpl', $arrRender);
    }
    /*
        我的任务-AJAX分页
    */
	public function actionAjaxTask() {
		$this->checkLogin();
		
        $status = Yii::app()->request->getParam('status');
		$page = Yii::app()->request->getParam('page');
		$size = Yii::app()->request->getParam('size');
		
		$member_id = Yii::app()->loginUser->getUserId();
		$taskModule = Yii::app()->getModule('mtask');

        $condition = array();
        if ($status && is_int($status)) {
            $condition['status'] = $status;
        }
		
        $taskList = $taskModule->getMemberTaskList($member_id, $condition, $page, $size);
		foreach ($taskList['list'] as $idx => $task) {
			//$taskList['list'][$idx] = $task->toArray();
            $taskList['list'][$idx]['_reward_desc'] = $task['reward_type']==2 ? ('￥'.$task['reward_money']) : ($task['reward_points'].'积分');
		}
        $this->showJson($taskList);
	}
    /*
        编辑资料
    */
    public function actionEditProfile() {
        $this->checkLogin();

        $member_id = Yii::app()->loginUser->getUserId();
        $memberInfo = UcMember::model()->findByPk($member_id);
        $csrfToken = Yii::app()->request->csrfToken;
		$arrMsgStack = Yii::app()->loginUser->getFlashes();
		$arrRender=array(
			'gShowHeader' => true,
			'gShowFooter' => true,
			'pageTitle' => '编辑资料',
            'csrfToken' => $csrfToken,
            'memberInfo' => $memberInfo,
            'arrMsgStack' => $arrMsgStack,
		);
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/editprofile.tpl', $arrRender);
    }
    /*
        提交编辑资料
    */
    public function actionSubmitProfile() {
        $this->checkLogin();

        $member_id = Yii::app()->loginUser->getUserId();
        //$memberInfo = UcMember::model()->findByPk($member_id);
        $csrfToken = Yii::app()->request->csrfToken;
        $requestToken = $_POST['token'];
        if (empty($requestToken) || $csrfToken != $requestToken) {
            // set flash
            //Yii::app()->loginUser->setFlash('error', '请求失败，请稍后再试!');
            //$this->redirect($this->createAbsoluteUrl('my/editprofile'));
            //return $this->jsonError('请求失败，请稍后再试!');
        }
        
        // 检查参数
        $emailPattern = '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i';
        $member_email = isset($_POST['member_email']) ? $_POST['member_email'] : '';
        if ($member_email && !preg_match($emailPattern, $member_email)) {
            //Yii::app()->loginUser->setFlash('error', 'email格式错误，请重新填写');
            //$this->redirect($this->createAbsoluteUrl('my/editprofile'));
            return $this->jsonError('email格式错误，请重新填写');
        }

        $memberInfo = UcMember::model()->findByPk($member_id);
        // 昵称可以随便修改
        $_POST['member_nickname'] ? ($memberInfo->member_nickname = $_POST['member_nickname']) : 0;
        // 真实姓名和邮箱 只能改一次
        //if (empty($memberInfo->member_fullname) && $_POST['member_fullname']) {}
		//if (empty($memberInfo->member_email) && $member_email) {}
		$memberInfo->member_fullname = $_POST['member_fullname'];
		$memberInfo->member_email = $member_email;
        
        $_POST['member_avatar'] ? ($memberInfo->member_avatar = $_POST['member_avatar']) : 0;
        if (!$memberInfo->save()) {
            Yii::log('save profile failed!'.$memberInfo->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        } else {
            // 保存cookie
            $cookieParams = array(
                'member_id' => $memberInfo->member_id,
                'member_fullname' => $memberInfo->member_fullname,
                'member_nickname' => $memberInfo->member_nickname,
                'member_mobile' => $memberInfo->member_mobile,
            );
            Yii::app()->loginUser->setUserInfo($cookieParams);
            // 如果都完善了 增加完善信息事件
            if ($memberInfo->member_email
             && $memberInfo->member_fullname
             //&& $memberInfo->member_avatar
             && $memberInfo->member_nickname
            ) {
                $params = array();
                Yii::app()->getModule('event')->pushEvent($member_id, 'fill_avatar', $params);

                // 记录日志
                $logModel = new MemberInfoLogModel;
                $logModel->member_id = $member_id;
                $logModel->editor = $memberInfo->member_fullname;
                $logModel->role = '会员';
                $logModel->type = 2;
                $logModel->content = '通过M站完善信息';
                $logModel->create_time = date('Y-m-d H:i:s');
                $logModel->save();
            }
        }
        
        
        //Yii::app()->loginUser->setFlash('error', '保存成功');
        //$this->redirect($this->createAbsoluteUrl('my/index'));
        $this->jsonSuccess('保存成功');
    }
    /*
        上传头像照片
    */
    public function actionUploadAvatar() {
        $arrRet = array(
            'state' => 'FAILED',
            'msg' => '上传失败，请稍后再试。',
            'url' => '',
            '_msg' => '',
        );
        // 检查登录
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $member_id = 0;
            $arrRet['msg'] = '您没有登录，请登录后再试。';
            return $this->showJson($arrRet);
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
        }
        // 检查token
        $csrfToken = Yii::app()->request->csrfToken;
        $requestToken = $_POST['token'];
        if (empty($requestToken) || $csrfToken != $requestToken) {
            //$arrRet['msg'] = '请求失败，请稍后再试';
            //$arrRet['_msg'] = 'token error';
            //return $this->showJson($arrRet);
        }
        
        $savepath = Yii::app()->params['UPLOAD_AVATAR_SUBDIR'];//avatar
        $fileInfo = MyUploadFile::UploadBinaryFiles(array('savepath'=>$savepath, 'inputname'=>'file', 'namePrefix'=>$member_id.'_'));

        if ($fileInfo && $fileInfo['state']=='SUCCESS') {
            $arrRet['url'] = $fileInfo['urlpath'];
            $arrRet['state'] = 'SUCCESS';
            $arrRet['msg'] = '上传成功';
        } else {
            $arrRet['msg'] = '上传失败，请稍后再试。';
        }

        $this->showJson($arrRet);
    }
	
	/*
 	我的收藏列表页
    */
    public function actionMyFavor() {
		$this->checkLogin();
		
      	//获取用户的收藏列表数据
        $member_id	= Yii::app()->loginUser->getUserId();
        $favorList	= Yii::app()->getModule('mfavor')->getMemberFavorList($member_id,1,10);
		
        $arrRender = array(
			'gShowHeader'	=> false,
			'gShowFooter'	=> true,
			'pageTitle'		=>'我的房乎',
            'favorList'		=> $favorList,
        );
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/myfavor.tpl',$arrRender);
    }
    /*
        签到
    */
    public function actionCheckin() {
		$this->checkLogin();
        $checkNdayNum = 7;
		
      	//获取用户的收藏列表数据
        $member_id	= Yii::app()->loginUser->getUserId();
        $now = time();
        $startTime = date('Y-m-d 00:00:00', $now-86400*($checkNdayNum-1));
        // 7日签到记录
        $checkInLog	= Yii::app()->getModule('points')->getCheckInLog($member_id, $startTime);
        // 7日内连续签到事件
        $checkInNdayLog = Yii::app()->getModule('points')->getCheckInNdayLog($member_id, $startTime);
        $newCheckInLog = array();
        // 将7日内 发生连续签到事件之前的签到 去除掉 是上次check_in_nday成就的事件
        if ($checkInNdayLog) {
            $abortDay = substr($checkInNdayLog[0]->create_time, 0, 10).' 23:59:59';
            //echo 'abortDay='.$abortDay;exit;
            foreach ($checkInLog as $key=>$checkInOnce) {
                if ($checkInOnce->create_time>$abortDay) {
                    $newCheckInLog[] = $checkInOnce;
                }
            }
            if ($abortDay == date('Y-m-d 23:59:59', $now)) {
                $isCheckedToday = true;
            }
        } else {
            $newCheckInLog = $checkInLog;
        }
        // 计算下次发放连续签到的时间
        $startCheckInNday = '';
        // 计算连续签到
        $arrCheckedDays = array();
        $arrFutrueDays = array();
        $checkCount = 0;
        $theContinuedNum = 0;
        for ($i=0; $i<$checkNdayNum; ++$i) {
            // 从昨天往前数6天
            $arrCheckedDays[$i] = array(
                'day' => date('Y-m-d', $now - 86400*($i+1)),
                'isChecked' => false,
            );
            // 从今天往后数7天
            $arrFutrueDays[$i] = array(
                'day' => date('Y-m-d', $now + 86400*$i),
                'dayShort' => date('m.d', $now + 86400*$i),//用于前台显示
                'css' => '',
            );
            
            $cmpDayStart = $arrCheckedDays[$i]['day'].' 00:00:00';
            $cmpDayEnd   = $arrCheckedDays[$i]['day'].' 23:59:59';
            // 找第 $i 天是否已经签到
            foreach ($newCheckInLog as $checkInOnce) {
                if ($cmpDayStart <= $checkInOnce->create_time && $checkInOnce->create_time <= $cmpDayEnd) {
                    $arrCheckedDays[$i]['isChecked'] = true;
                    ++$checkCount;
                    break;
                }
            }
            if ($i+1 == $checkCount) {
                $theContinuedNum = $i+1;
            }
        }
        // 查找今天是否签到
        foreach ($newCheckInLog as $checkInOnce) {
            $cmpDayStart = date('Y-m-d', $now).' 00:00:00';
            //$cmpDayEnd   = date('Y-m-d ', $now).' 23:59:59';
            if ($cmpDayStart <= $checkInOnce->create_time) {
                $isCheckedToday = true;
                break;
            }
        }
        
        // 下一次领取连续7天奖励 0-6
        // 先计算下次gift的位置
        $nextGiftDay = $checkNdayNum - 1 - $theContinuedNum;
        $nextGiftDay = $nextGiftDay >= $checkNdayNum ? $checkNdayNum-1 : $nextGiftDay;
        
        // 连续签到天数 这一步算上今天
        $theContinuedNum += $isCheckedToday * 1;

        // 如果今天获得check_in_nday成就
        if ($checkInNdayLog && $checkInNdayLog[0]->create_time>=date('Y-m-d 00:00:00', $now)) {
            $theContinuedNum = $checkNdayNum-1 + $isCheckedToday * 1;
            $nextGiftDay = 0;
        }

        //$isCheckedToday = $arrCheckedDays[0]['isChecked'];

        $arrFutrueDays[0]['css'] = 'first';
        $arrFutrueDays[$nextGiftDay]['css'] .= ' gift';
        $arrFutrueDays[$checkNdayNum-1]['css'] .= ' last';
        $arrFutrueDays[0]['css'] .= $isCheckedToday ? ' active':'';

        $totalInfo = Yii::app()->getModule('points')->getMemberTotalInfo($member_id);

        // 热推
        $hotArtLimit = 4;
        $hotArtModels = HotArticleModel::model()->orderBy('t.weight,t.create_time desc')->findAll(array('condition'=>'status=2','limit'=>$hotArtLimit));

		$arrMsgStack = Yii::app()->loginUser->getFlashes();

        $arrRender = array(
			'gShowHeader'	    => true,
			'gShowFooter'	    => true,
			'pageTitle'		    => '签到赚积分',
            'checkInLog'	    => $newCheckInLog,
            'isCheckedToday'    => $isCheckedToday,
            'hotArtModels'      => $hotArtModels,
            'totalInfo'         => $totalInfo,
            'nextGiftDay'       => $nextGiftDay,
            'theContinuedNum'   => $theContinuedNum,
            'arrFutrueDays'     => $arrFutrueDays,
            'arrMsgStack'       => $arrMsgStack,
            'csrfToken'         => Yii::app()->request->csrfToken,
        );
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('my/checkin.tpl',$arrRender);
    }
    /*
        手动签到
    */
    public function actionSubmitCheckin() {
        $this->checkLogin();
        $member_id = Yii::app()->loginUser->getUserId();

        $requestToken = $_GET['token'];
        $csrfToken = Yii::app()->request->csrfToken;
        if ($requestToken && $csrfToken==$requestToken) {
            $now = time();
            $startTime = date('Y-m-d 00:00:00', $now);
            // 当日签到记录
            $checkInLog	= Yii::app()->getModule('points')->getCheckInLog($member_id, $startTime);
            if (empty($checkInLog)) {
                Yii::app()->getModule('event')->pushEvent($member_id, 'check_in');
            } else {
                Yii::log('already check in: mid='.$member_id.' startTime='.$startTime.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            }
        } else {
            Yii::log('token error: mid='.$member_id.' startTime='.$startTime.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            //Yii::app()->loginUser->setFlash('error', '请求失败，请稍后再试');
        }

        $this->redirect($this->createAbsoluteUrl('my/checkin'));
    }
}