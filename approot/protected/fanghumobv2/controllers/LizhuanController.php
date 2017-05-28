<?php

class LizhuanController extends BaseController {

    /*
        立赚首页
    */
    public function actionIndex() {
        Yii::app()->params['accounts_id'] = isset($_GET['accounts_id'])?$_GET['accounts_id']:1;
        return $this->actionTaskTplList();
    }
    /*
        获取所有任务列表
    */
    public function actionTaskTplList() {
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $member_id = 0;
            $signage = '';
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
            $shareCode = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;
        }
        
		// 获取未领取任务列表
        $taskModule = Yii::app()->getModule('mtask');
        $myTaskListFinished = $taskModule->getMemberTaskList($member_id, array('status'=>2),1,8);//取八条数据
		
		//根据用户是否登录查询最新任务列表
		if (!empty($member_id)) {
			//不包含已完成任务的列表
			$taskTplList = TaskTplModel::model()->getMemberNewTaskTplList($member_id,1,8);
			$taskTplList = $taskTplList['list'];
		} else {
			$arrCondition = array(
				'condition' => 'status=2',
				'limit' => 8,
			);
			//获取所有最新任务列表
			$taskTplList = TaskTplModel::model()->orderBy('weight ASC , task_id desc')->findAll($arrCondition);
            foreach ($taskTplList as $k=>&$v) {
                $v = $v->toArray();
                if($v['reward_type']==1 && $v['reward_points'] > 0){
                    $taskTplList[$k]['_reward_desc'] = $v['reward_points'].'积分';
                }
                if($v['reward_type_money']==2 && $v['reward_money'] > 0){
                    $taskTplList[$k]['_reward_desc2'] = '￥'.$v['reward_money'];
                }
            }
		}
        $arrRender = array(
            'gShowHeader' 	=> true,
            'gShowFooter' 	=> true,
            'pageTitle' 	=> '任务',
            'logout_return_url' => $this->createAbsoluteUrl("task/index"),
            'taskTplList' 	=> $taskTplList,
            'isGuest' 		=> $isGuest,
            'myTaskListFinished' => $myTaskListFinished,
            'shareCode'     => $shareCode,
            'accounts_id'   => Yii::app()->params['accounts_id'],
        );
        $this->layout = "layouts/lizhuan.tpl";
        $this->smartyRender('lizhuan/index.tpl', $arrRender);
    }
    /*
        ajax 获取任务列表
        @param $page
        @param $pageSize
    */
    public function actionAjaxGetTaskTplList($accounts_id=1) {
		$page 		= Yii::app()->request->getParam('page');
		$pageSize 	= Yii::app()->request->getParam('pageSize');
		$page		= $page ? $page : 2;
		$pageSize	= $pageSize ? $pageSize : 8;
		$isGuest 	= Yii::app()->loginUser->getIsGuest();
		$member_id 	= $isGuest ? '' : Yii::app()->loginUser->getUserId();
		$taskModule = Yii::app()->getModule('mtask');
		
		//根据用户是否登录查询最新任务列表
		if (!empty($member_id)) {
			//不包含已完成任务的列表
			$taskTplList = TaskTplModel::model()->getMemberNewTaskTplList($member_id, $page, $pageSize);
			$total		 = $taskTplList['total'];
			$taskTplList = $taskTplList['list'];//$this->convertModelToArray($taskTplList['list']);
		} else {
			$arrCondition = array(
				'condition' => 'status=2',
			);
			//获取所有最新任务列表
			$total 			= TaskTplModel::model()->count($arrCondition);
			$taskTplList 	= TaskTplModel::model()->orderBy('weight ASC , task_id desc')->pagination($page, $pageSize)->findAll($arrCondition);
			$taskTplList	= $this->convertModelToArray($taskTplList);
		}
        foreach ($taskTplList as $k=>&$v) {
            if($v['reward_type']==1 && $v['reward_points'] > 0){
                $taskTplList[$k]['_reward_desc'] = $v['reward_points'].'积分';
            }
            if($v['reward_type_money']==2 && $v['reward_money'] > 0){
                $taskTplList[$k]['_reward_desc2'] = '￥'.$v['reward_money'];
            }
        }
		
		$arr = array(
				'list' 	=> $taskTplList,
				'page' 		=> $page,
				'pageSize' 	=> $pageSize,
				'total' 	=> $total,
                'accounts_id'=>$accounts_id
        );
		
        $this->showJson($arr);
    }
    /*
        我的已完成的任务
    */
    public function actionMyTaskList($status = 2) {
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $member_id = 0;
            $signage = '';
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
            //$arrMember = UCenterStatic::getUserProfile($member_id);
            //$signage = $arrMember['userProfile']['signage'];
        }

        $taskModule = Yii::app()->getModule('mtask');

        $status = (int)$status ;
        $arrCondition = array(
            'condition' => 'member_id="'.$member_id.'"',
            'limit' => 8,
        );
        if ($status!=0) {
            $arrConditon['condition'] = ' and status="'.$status.'"';
        }

        $taskInstList = MemberTaskModel::model()->with('task_tpl')->findAll($arrCondition);

        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'logout_return_url' => $this->createAbsoluteUrl("task/index"),
            'taskInstList' => $taskInstList,
        );
        $this->layout = "layouts/lizhuan.tpl";
        $this->smartyRender('lizhuan/mytasklist.tpl', $arrRender);
    }
    /*
        领取任务
            领取后 跳转到任务详情
    */
    public function actionJoinTask($taskTplId,$accounts_id=1) {
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $this->redirect($this->createAbsoluteUrl("user/login"), array('return_url'=>$this->createAbsoluteUrl('lizhuan/index')));
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
        }
        
        $taskModule = Yii::app()->getModule('mtask');
        $taskInst = TaskInst::makeInstByTpl($member_id, $taskTplId);
        if (!$taskInst) {
            $taskInst = $taskModule->dispatchTask($member_id, $taskTplId);
        }

        if ($taskInst) {
            // 任务已领取
            // 判断任务是否完成
            if ($taskInst->isTaskFinished()) {
            } else {
            }
        }
        $shareCode = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;
        // 如果本地连接 跳转到本地连接
        //$isLocalUrl = $this->isLocalUrl($taskInst->getModel()->task_tpl->task_url);
        //// task_type==2,3->完善信息和邀请注册的任务
        //if ($isLocalUrl || $taskInst->getModel()->task_tpl->task_type==2 || $taskInst->getModel()->task_tpl->task_type==3) {
        //    $nextUrl = $taskInst->getModel()->task_tpl->task_url .'&task_id='.$taskTplId.'&share_code='.$shareCode.'&accounts_id='.$accounts_id;
        //    $this->redirect($nextUrl);
        //} else {
            $nextUrl = $this->createAbsoluteUrl('lizhuan/show', array('task_id'=>$taskTplId, 'share_code'=>$shareCode, 'accounts_id'=>$accounts_id));
            $this->redirect($nextUrl);
        //}
    }
    /*
        show 分享后别人查看任务内容
    */
    public function actionShow() {
        $taskModule     = Yii::app()->getModule('mtask');
        $taskTplId      = $_GET['task_id'];
        $shareCode      = $_GET['share_code'];
        $accounts_id    = isset($_GET['accounts_id'])?$_GET['accounts_id']:1;

        $taskTplModel = TaskTplModel::model()->findByPk($taskTplId);
        if (!$taskTplModel) {
            $this->redirect($this->createAbsoluteUrl('lizhuan/index'));
        }

        //$isLocalUrl = $this->isLocalUrl($taskTplModel->task_url);
        //if ($isLocalUrl) {
        //    $nextUrl = $taskTplModel->task_url .'&task_id='.$taskTplId.'&share_code='.$shareCode.'&accounts_id='.$accounts_id;
        //    $this->redirect($nextUrl);
        //}
        
        $iframeUrl = $taskTplModel->task_url.'&showheader=0';
        $defaultArticleSurfaceUrl = Yii::app()->request->getHostInfo().$taskTplModel->surface_url;
        $csrfToken = Yii::app()->request->csrfToken;
        // 

        $selfUrl = Yii::app()->request->hostInfo. Yii::app()->request->url;
        $shareCallbackUrl = $this->createAbsoluteUrl('article/ajaxsharesuccess', array(
            'url' => $selfUrl,
            'task_id' => $taskTplId,
            'token' => Yii::app()->request->csrfToken,
            'accounts_id' => $accounts_id
        ));

        $member_id = Yii::app()->loginUser->getUserId();
        if ($member_id) {
            $myShareCode = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;
        } else {
            $myShareCode = '';
        }

        if ($shareCode && $shareCode!=$myShareCode) {
            //$taskTplId  = 0;//(int)$_GET['task_id'];
            $platId     = (int)$_GET['plat_type'];
            $platId     = $platId ? $platId : 2;
            $this->shareClicked($taskTplId, $shareCode, $platId);
        }

        $arrRender = array(
            'gShowHeader' => false,
            'gShowFooter' => true,
            //'signage' => $signage,
            'logout_return_url' => $this->createAbsoluteUrl("lizhuan/index"),
            //'articleModel' => $articleModel,
            'pageTitle' => $taskTplModel->task_name,
            // for share
            'visitUrl' => $selfUrl,//$this->_createArticleUrl($id, $shareCode, $taskTplId),
            'articleTitle' => $taskTplModel->task_name,
            'articleDesc' => '',//$taskTplModel->task_name,
            'articleSurfaceUrl' => $defaultArticleSurfaceUrl,
            'token' => $csrfToken,
            'shareCode' => $shareCode,
            'shareCallbackUrl' => $shareCallbackUrl,
            'iframeUrl' => $iframeUrl,
        );
        $this->layout = "layouts/default_v2.tpl";
        $this->smartyRender('lizhuan/show.tpl', $arrRender);


    }
    protected function isLocalUrl ($url) {
        $url = trim($url);
        $myServerHost = Yii::app()->request->getHostInfo();
        return strncmp($url, $myServerHost, strlen($myServerHost)) == 0;
    }
    /*
        任务分享被点击
            只派发任务分享奖励
            因为iframe包含article,不派发文章分享奖励
    */
    public function shareClicked($taskTplId, $shareCode, $platId = 2) {
        // 查询 shareCode
        $shareCodeModel = MemberInviteCodeModel::model()->find('invite_code=:code', array(':code'=>$shareCode));
        if (!$shareCodeModel) {
            Yii::log('share code not exist:'.$shareCode.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        // 查询文章的分享记录
        $shareLog = ShareLogModel::model()->find('article_id=:aid and use_invite_code=:share_code and plat_type=:plat_type', [
            ':aid'          => $id,
            ':share_code'   => $shareCode,
            ':plat_type'    => $platId,
        ]);
        // 
        if (!$shareLog) {
            Yii::log('aid('.$id.') not shared by:'.$shareCode.'('.$shareCodeModel->member_id.') @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            return false;
        } else {
            try {
                $shareLog->view_count += 1;
                $shareLog->save();
            } catch (Exception $e) {
                Yii::log('save share log view_count +=1 failed:'.$e->getMessage().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            }
        }

        if ($taskTplId) {
            $taskInst = TaskInst::makeInstByTpl($shareCodeModel->member_id, $taskTplId);
            if (!$taskInst) {
                Yii::log('he('.$shareCodeModel->member_id.') has no task:'.$taskTplId.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            } else {
                $taskInstModel = $taskInst->getModel();
                $taskInstModel->view_count = $taskInstModel->view_count + 1;
                if (!$taskInstModel->save()) {
                    Yii::log('save art view_count failed:mid=('.$shareCodeModel->member_id.') :'.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                }

                // 派发积分
                if ($taskInstModel->view_count<=1) {
                    
                    // 派发积分
                    $eventParam = array(
                        'taskTplId' => $taskTplId,
                    );
                    Yii::app()->getModule('event')->pushEvent($shareCodeModel->member_id, 'share_clicked', $eventParam);
                }
                return true;
            }
        }
    }
}
