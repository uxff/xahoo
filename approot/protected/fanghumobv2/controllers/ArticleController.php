<?php

class ArticleController extends BaseController {

    /*
        资讯页
    */
    public function actionIndex($id=0) {
        if (!$id) {
            //return $this->showError();
            return $this->redirect($this->createAbsoluteUrl('site/index'));
        }
        return $this->actionShow($id);
    }
    /*
        资讯显示
    */
    public function actionShow($id) {
        $isGuest = Yii::app()->loginUser->getIsGuest();
        $accounts_id    = isset($_GET['accounts_id'])?$_GET['accounts_id']:1;
        $shareCode = $_GET['share_code'];
        $showHeader = intval($_GET['noheader'])==1 ? false : true;

        if ($isGuest) {
            $member_id = 0;
            $signage = '';
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
            //$arrMember = UCenterStatic::getUserProfile($member_id);
            //$signage = $arrMember['userProfile']['signage'];
            $myShareCode = Yii::app()->getModule('friend')->getInviteCodeModel($member_id)->invite_code;
            if (empty($shareCode)) {
                // 强制跳到有share_code的地址
                $this->saveShareCodeToCookie($myShareCode);
                $this->redirect(Yii::app()->request->hostInfo.Yii::app()->request->url.'&share_code='.$myShareCode);
            }
        }

        $articleModel = ArticleModel::model()->findByPk($id);
        if (!$articleModel) {
            return $this->showError('该文章不存在');
        } elseif ($articleModel->status != ArticleModel::STATUS_PUBLISHED) {
            return $this->showError('该页面已被删除，如有需要请联系管理员');
        }
        
        $this->logVisit($id, $member_id);

        if ($shareCode && $myShareCode && $shareCode!=$myShareCode) {
            $platId     = (int)$_GET['plat_type'];
            $platId     = $platId ? $platId : 2;
            $this->shareClicked($id, $shareCode, 0, $platId);
        }

		//$inviteCodeModel = Yii::app()->getModule('friend')->getInviteCodeModel($member_id);
        $protocol = Yii::app()->request->getIsSecureConnection() ? "https://" : "http://";
        
        $defaultArticleSurfaceUrl = $protocol.$_SERVER['HTTP_HOST'].'/resource/fanghu2.0/images/index/index_banner.jpg';
        $defaultArticleSurfaceUrl = strncmp($defaultArticleSurfaceUrl, $protocol, 4)==0 ? $defaultArticleSurfaceUrl : $protocol.$_SERVER['HTTP_HOST'].$defaultArticleSurfaceUrl;

        $csrfToken = Yii::app()->request->csrfToken;
        $shareCallbackUrl = $this->createAbsoluteUrl('article/ajaxsharesuccess', array(
            'url'=>($articleModel->visit_url) .'&'. http_build_query(array(
                        //'task_id' => $taskTplId,
                        'share_code' => $shareCode,
                        'plat_type' => 2,
                        'accounts_id'=>$accounts_id
                        )),
            'token' => Yii::app()->request->csrfToken,
        ));

        $visitUrl = $this->_createArticleUrl($id, $shareCode);

        $arrRender = array(
            'gShowHeader' => $showHeader,
            'gShowFooter' => $showHeader,
            //'signage' => $signage,
            'logout_return_url' => $this->createAbsoluteUrl("article/index"),
            'articleModel' => $articleModel,
            'pageTitle' => $articleModel->title,
            // for share
            'visitUrl' => $visitUrl,
            'articleTitle' => addcslashes($articleModel->title, "\n\r\t\'\""),
            'articleDesc' => addcslashes($articleModel->abstract, "\n\r\t\'\""),
            'articleSurfaceUrl' => $defaultArticleSurfaceUrl,
            'token' => $csrfToken,
            'shareCode' => $shareCode,
            'shareCallbackUrl' => $shareCallbackUrl,
            'iframeUrl' => $articleModel->outer_url,
        );
        $this->layout = "layouts/default_v2.tpl";
        $this->smartyRender('article/show.tpl', $arrRender);
    }
    /*
        
    */
    protected function _createArticleUrl($id, $shareCode) {
        $url = $this->createAbsoluteUrl('article/show', array(
            'id' => $id,
            'sign' => ArticleModel::makeSign($id),
            'share_code' => $shareCode,
        ));
        return $url;
    }
    /*
        一文章 一ip 一天记录一次
            根据 share_code 奖励
    */
    protected function logVisit($id, $visitor_mid=0) {
        $now = time();
        $ip = Tools::getUserHostAddress();
        $ipu = ip2long($ip);
        $dayStart = date('Y-m-d 00:00:00', $now);
        // 检查是否存在
        $arrSqlParam = array(
            'select' => 'id,create_time,use_invite_code',
            'condition' => 'article_id=:aid and visitor_ip_u=:ipu and create_time>=:day',
            'params' => array(
                ':ipu' => $ipu,
                ':aid' => $id,
                ':day' => $dayStart,
            ),
        );

        $shareCode = $_GET['share_code'];
        $platId = (int)$_GET['plat_type'];
        $platId = $platId ? $platId : 2;

        $url = Yii::app()->request->getHostInfo().Yii::app()->request->url;

        $logModel = new ArticleVisitLogModel;
        $logModel->article_id   = $id;
        $logModel->visitor_ip_u = $ipu;
        $logModel->visitor_ip_s = $ip;
        $logModel->plat_type    = $platId;
        $logModel->article_url  = $url;
        $logModel->visitor_mid  = $visitor_mid;
        $logModel->use_invite_code = $shareCode;
        $logModel->create_time  = date('Y-m-d H:i:s', $now);
        if (!$logModel->save()) {
            Yii::log('log visit error:aid='.$id.' ip:'.$ip.' day:'.$dayStart.' :'.$logModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
        }


        return true;
    }
    /*
        分享被点击
    */
    public function shareClicked($id, $shareCode, $taskTplId = 0, $platId = 2) {
        // 查询 shareCode
        $shareCodeModel = MemberInviteCodeModel::model()->find('invite_code=:code', array(':code'=>$shareCode));
        if (!$shareCodeModel) {
            Yii::log('share code not exist:'.$shareCode.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return false;
        }
        // 查询文章的分享记录
        $shareLog = ShareLogModel::model()->find('article_id=:aid and plat_type=:plat_type and use_invite_code=:share_code', [
            ':aid'          => $id,
            ':share_code'   => $shareCode,
            ':plat_type'    => $platId,
        ]);
        // 进入shareClicked,确保已经有sharelog
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
    /*
        完成分享 前端完成分享后回调
        @param string $url
            url 中必须有的参数：  plat_type task_id share_code
        @param string $token
    */
    public function actionAjaxShareSuccess() {

        Yii::log('CALLBACK:'.Yii::app()->request->url.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
        $isGuest = Yii::app()->loginUser->getIsGuest();
        if ($isGuest) {
            $member_id = 0;
            return $this->jsonError('请登录后再试');
        }else{
            $member_id = Yii::app()->loginUser->getUserId();
        }

        $task_id        = $_REQUEST['task_id'];
        $accounts_id    = isset($_REQUEST['accounts_id'])?$_REQUEST['accounts_id']:1;
        $shareUrl       = $_REQUEST['url'];
        $platId         = (int)$_REQUEST['plat_type'];
        $urlArr         = parse_url($shareUrl);
        $requestToken   = $_REQUEST['token'];
        $shareCode      = $_REQUEST['share_code'];
        if (!$requestToken) {
            return $this->jsonError('请求失败，请稍后再试', array('_msg'=>'empty token'));
        }
        else if ($requestToken != Yii::app()->request->csrfToken) {
            return $this->jsonError('请求失败，请稍后再试', array('_msg'=>'token illegal'));
        }
        elseif (!empty($task_id) && isset($urlArr['query'])) {            
            //更新金额奖励
            Yii::app()->getModule('mtask');
            $task_data = TaskTplModel::model()->findByPk($task_id);            
            $membertotalModel = MemberTotalModel::model()->find('member_id=:member_id and accounts_id=:accounts_id', array(':member_id'=>$member_id,':accounts_id'=>$accounts_id));
            if (!$membertotalModel) {
                $membertotalModel = new MemberTotalModel;
                $membertotalModel->member_id      = $member_id;
                $membertotalModel->accounts_id    = $accounts_id;//fh公众号ID
                $membertotalModel->points_total   = 0;
                $membertotalModel->points_gain    = 0;
                $membertotalModel->money_total    = $task_data->reward_money;
            }else{
               $membertotalModel->money_total    += $task_data->reward_money; 
            }            
            $res = $membertotalModel->save();
            if (!$ret) {
                Yii::log('CALLBACK err:'.'taskid->'.$task_id.'memberid->'.$member_id.'accountid->'.$accounts_id.'reward_money->'.$task_data->reward_money.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            }
            //$member_up = MemberTotalModel::model()->updateAll(['money_total'=>new CDbExpression('money_total+'.$task_data->reward_money)],'accounts_id=:accounts_id AND member_id=:member_id',[':accounts_id'=>$accounts_id,':member_id'=>$member_id]);
            
            $paramArr = parse_str($urlArr['query']);
            //if ($id) {
                // 记录分享 增加积分
                $eventParam = array(
                    'articleId'=>$id,
                    'platId' => $plat_type,
                    'shareCode'=>$share_code,
                    'visitUrl' => $shareUrl,
                    'articleUrl' => $shareUrl,
                    'taskTplId' => $task_id,
                );
                Yii::app()->getModule('event')->pushEvent($member_id, 'share', $eventParam);

                // 尝试完成任务
                //$eventParam = array(
                //    'articleId'=>$id,
                //    'platId' => $plat_type,
                //    'shareCode'=>$share_code,
                //    'visitUrl' => $shareUrl,
                //    'articleUrl' => $shareUrl,
                //    'taskTplId' => $task_id,
                //);
                //Yii::app()->getModule('event')->pushEvent($member_id, 'try_to_finish_task', $eventParam);
                Yii::log('share url:'.$shareUrl.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
            //} else {
            //    Yii::log('cannot parse_str:'.$urlArr['query'].' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            //    return $this->jsonError('分享失败，url参数不正确');
            //}
        } else {
            Yii::log('cannot parse_url:'.$shareUrl.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
            return $this->jsonError('分享失败，不是合法的url地址');
        }
        $this->jsonSuccess('分享成功');
    }
    /*
        文章不存在
    */
    protected function showError($error = '') {
        $arrRender = array(
            'gShowHeader' => true,
            'gShowFooter' => true,
            'refer' => $_SERVER['REQUEST_URL'],
            'error' => $error,
        );
        $this->layout = 'layouts/default_v2.tpl';
        $this->smartyRender('errorview/404.tpl', $arrRender);
    }
    /*
        文章不存在
    */
    public function actionShowError() {
        return $this->showError();
    }
    /*
        
    */
    protected function saveShareCodeToCookie($shareCode) {
        if ($shareCode) {
            $cookie = new CHttpCookie('invite_code', $shareCode);
            $cookie->expire = time()+60*60*24*30;
            Yii::app()->request->cookies['invite_code'] = $cookie;
        }
    }
}
