<?php
/**
 * 微信
 * 与微信服务器对接
 * coderxx
 */
class WechatController extends BaseController {
    protected $weObj;
    protected $wechatOptions;
    protected $mpid;
    protected $mpModel;
    protected $directRewardPer;
    protected $indirectRewardPer;
    protected $upstreamModel;
    protected $rewardMoney;

    public function init() {
        parent::init();
        Yii::import('application.common.extensions.wechatlib.*');
        Yii::import('application.common.extensions.util.*');
        Yii::app()->getModule('points');
        $this->mpid = isset($_SESSION[Yii::app()->params['third_login_sess_name']]) ? $_SESSION[Yii::app()->params['third_login_sess_name']]['mpid'] : 0;
        $this->mpid = $this->mpid ? : intval($_GET['mpid'] ? : 1);
    }

    protected function getAccountOptions($mpid) {
        $this->mpModel = FhPosterAccountsModel::model()->find('id=:id',array(':id'=>$mpid));
        if (!empty($this->mpModel)) {
            $this->wechatOptions = $this->mpModel->toWechatOption();
        }

        return $this->wechatOptions;
    }

    public function actionIndex() {
        // 通过mpid参数来选择公众号

        $wechatOptions = $this->getAccountOptions($this->mpid);
        $this->weObj = new Wechat($wechatOptions);

        if (isset($_GET['echostr'])) {
            if ($this->weObj->valid()) {
                // 收到确认后，更新数据库状态为已确认状态
                if (empty($this->mpModel)) {
                    $this->mpModel = FhPosterAccountsModel::model()->find('id=:id',array(':id'=>$this->mpid));
                }
                $this->mpModel->status = FhPosterAccountsModel::STATUS_AUTHED;
                if (!$this->mpModel->save()) {
                    Yii::log('update FhPosterAccountsModel set status=STATUS_AUTHED error:'.$this->mpModel->lastError(), 'error', __METHOD__);
                }
            }
        }
        // 交给处理器
        $this->process();
    }
    // 处理微信服务器回调信息
    public function process() {
        $weObj = $this->weObj;
        $type = $weObj->getRev()->getRevType();
        $fromUser = $weObj->getRevFrom();

        file_put_contents('/tmp/xahoo_wechat_debug',var_export($weObj->getRevData(),true)."\n",FILE_APPEND);
        file_put_contents('/tmp/xahoo_wechat_debug',var_export($weObj->getRevFrom(),true)."\n",FILE_APPEND);

        switch($type) {
            case Wechat::MSGTYPE_TEXT:
                $weObj->text("您的留言已收到，正在努力寻找答案。")->reply();
                $revText = $weObj->getRevContent();
                $this->processText($fromUser, $revText);

                // 更新为活跃公众号
                $this->mpModel->status = FhPosterAccountsModel::STATUS_AUTHED;
                if (!$this->mpModel->save()) {
                    Yii::log('update FhPosterAccountsModel set status=STATUS_AUTHED error:'.$this->mpModel->lastError(), 'error', __METHOD__);
                }

                Yii::app()->end();
                break;
            case Wechat::MSGTYPE_EVENT:
                $this->processEvent();
                break;
            case Wechat::MSGTYPE_IMAGE:
                break;
            default:
                $weObj->text("我是Xahoo，有问题请留言！")->reply();
                break;
        }
    }
    /*
        处理菜单信息
    */
    public function processEvent() {
        $weObj = $this->weObj;
        //$type = $weObj->getRev()->getRevType();
        $fromUser = $weObj->getRevFrom();
        $eventInfo = $weObj->getRevEvent();

        switch ($eventInfo['event']) {
            case Wechat::EVENT_MENU_CLICK:
                // 处理点击菜单事件
                switch ($eventInfo['key']) {
                    case 'MENU_HAIBAO':
                        // 需要先注册的海报 // #8845 需求中下线
                        // 先回复空白消息
                        echo "";
                        //$weObj->text('正在生成专属海报，大约需要5秒时间')->reply();
                        $this->forceFlush();

                        $arrStr = [
                            'middle' => "在云上思考\n繁华中进步",
                        ];
                        $this->makeHaibao($fromUser, $arrStr, 1);

                        break;

                    case 'MENU_HAIBAO_COMMON':
                        // 默认海报 普通海报 不需要登录就生成海报
                        echo "";
                        $this->forceFlush();
                        if ($this->makeAccount($fromUser)) {
                            $arrStr = [
                                'middle' => "在云上思考\n繁华中进步",
                            ];
                            $this->makeHaibao($fromUser, $arrStr);
                        }
                        break;
                    case 'MENU_HAIBAO_DIY':
                        // 个性海报
                        // 需要补充信息: 昵称，手机号，一段文字描述
                        echo "";

                        // 获取当前有效海报
                        // 地域海报 按地域选择poster
                        //$posterModel = $this->choicePosterByLocation($addr);
                        $posterModel = FhPosterModel::model()->GetStartedModel($this->mpid);
                        if (empty($posterModel)) {
                            $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"本期活动已结束！查看红包和提现请点击【我的奖励】，红包到账时间：申请提现之日起的2-3个工作日。敬请关注下期活动！"]];
                            $weObj->sendCustomMessage($msg);
                            break;
                        } else {
                            // 如果有posterModel，但是尚未开始，则倒计时
                            $posterStartTimestamp = strtotime($posterModel->valid_begintime);
                            $timestampToStart = $posterStartTimestamp - time();
                            if (0 < $timestampToStart && $timestampToStart < 3600*24) {
                                    // 1 天内 回复倒计时消息
                                $atime = date('H小时i分s秒', $timestampToStart-3600*8);
                                $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"海报转发领红包倒计时".$atime."，敬请关注！"]];
                                $weObj->sendCustomMessage($msg);
                            } else if ($timestampToStart < 0) {
                                // 活动已开始，正在进行中
                                $return_url = $this->createAbsoluteUrl('myHaibao/DiyHaibao');
                                if ($this->makeAccount($fromUser)) {
                                    $loginUrl = $this->createAbsoluteUrl('wechat/authlogin', ['mpid'=>$this->mpid, 'return_url'=>$return_url]);
                                    $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"生成个性化海报，请点击<a href=\"$loginUrl\"> 这里 </a>，填写专属信息"]];
                                    $weObj->sendCustomMessage($msg);
                                } else {
                                    $this->checkIsBind($fromUser);
                                }
                            } else {
                                $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"很遗憾，本期活动刚结束！查看红包和提现请点击【我的奖励】，红包到账时间：申请提现之日起的2-3个工作日。敬请关注下期活动！"]];
                                $weObj->sendCustomMessage($msg);
                            }
                        }

                        break;
                    case 'MENU_ONLINE_ADVICE':
                        // 在线咨询
                        $msg = '亲您好，欢迎来到Xahoo，如果您对Xahoo有任何问题和建议，可随时留言，我们将及时与您取得联系，灰常感谢您对Xahoo的支持。';
                        $weObj->text($msg)->reply();
                        break;
                    default:
                        Yii::log('a click '.$eventInfo['key'].' from '.$fromUser.' ', 'warning', __METHOD__);
                        break;
                }
                break;

            case Wechat::EVENT_SUBSCRIBE:
                $msg = '【转发海报领红包活动】开始啦！
①关注Xahoo就领关注红包！
②点击【生成海报】菜单——普通用户选择【项目海报】
    ——经纪人选择【个性海报】 
③将自己生成的海报转发到朋友圈，只要你的朋友识别你生成的海报右下角的二维码并关注，你就可以领取红包奖励！
④你的朋友继续生成自己的海报并转发，此海报二维码被其他人识别并关注，你和你的朋友都可以领取红包奖励！
⑤本活动属于demo演示产品，活动中涉及的金额仅提供功能演示，不会实际发放。
';
                //$weObj->text($msg)->reply();
                $this->sendTextMessage($fromUser, $msg);
                echo '';
                $this->forceFlush();

                $data = $weObj->getRevData();
                Yii::log('收到一个关注： '.$fromUser.' qrscene='.$qrscene.' data='.json_encode($data).' ', 'warning', __METHOD__);

                // 为粉丝创建账号
                $memberModel = $this->makeAccount($fromUser);
                // 第一次关注后，才考虑建立粉丝关系
                // 如果已经关注过，则不建立粉丝关系
                if (!$this->dispatchSubscribeReward($fromUser, $memberModel->member_id)) {
                    // 派发成功表示第一次关注
                    break;
                }

                // 关注之后要给参数中的推荐人发放奖金
                // 收到一个粉丝关注，绑定粉丝关系，并派发奖励
                $qrscene = $eventInfo['key'];
                if ($qrscene && substr($qrscene, 0, 8)=='qrscene_') {
                    $fansOpenid = $fromUser;
                    $sceneid = substr($qrscene, 8);
                    $this->bindFans($fansOpenid, $sceneid);
                }

                break;
            case Wechat::EVENT_LOCATION:
                // 用户上报地理位置
                // 此处保存用户的位置信息 待生成海报的时候使用地域海报
                $data = $weObj->getRevData();
                Yii::log('LOCATION lat='.$data['Latitude'].' long='.$data['Longitude'].' openid='.$fromUser.' ', 'warning', __METHOD__);
                // 转换地理位置 从经纬度转换到地址描述后保存
                $locationInfo = GeoConvertor::LocationToAddr($data['Latitude'], $data['Longitude']);
                Yii::log('LOCATION convert ret='.$locationInfo['result']['formatted_address'].' openid='.$fromUser.' ', 'warning', __METHOD__);

                // 将地理位置写在uc_member_bind_sns对应的openid上
                $snsModel = UcMemberBindSns::model()->find('sns_id=:openid and member_id=:member_id', [':openid'=>$fromUser]);
                $formatted_address = GeoConvertor::GetAddress($locationInfo['result']['formatted_address']);
                $snsModel->location_address = $formatted_address;
                if (!$snsModel->save()) {
                   Yii::log('save snsModel failed:'.$snsModel->lastError().' ', 'warning', __METHOD__);
                }
                //Yii::log('SNSMODEL member_id='.$snsModel->member_id.' bind_id='.$snsModel->bind_id.' openid='.$fromUser.' ', 'warning', __METHOD__);
                break;
            default:
                //Yii::log('a event from '.$fromUser.' ', 'warning', __METHOD__);
                break;
        }
    }



    /*
        处理文本消息
    */
    public function processText($fromUser, $revText) {
        switch ($revText) {
            case 'the total':
                $count = Yii::app()->getModule('sns')->stasticSns(Yii::app()->params['fh_wechat_appid']);
                $msg = '当前关注数:'.$count['cnt']*1;
                $this->sendTextMessage($fromUser, $msg);
                break;
            default:
                break;
        }
    }
    /*
        为用户生成海报
    */
    public function makeHaibao($fromUser, $arrStr=[], $isCheckJjr=0) {
        $weObj = $this->weObj;
        $runtimePath = $this->getPicRuntimePath();// /tmp/
        
        // 检查是否绑定 如果没绑定则回复消息要求绑定
        $snsBindModel = $this->checkIsBind($fromUser);
        if (!$snsBindModel || !$snsBindModel->member_id) {
            Yii::log('这个用户没绑定: '.' from='.$fromUser.' ', 'warning', __METHOD__);
            return false;
        }

        $sceneid    = $snsBindModel->bind_id;
        $member_id  = $snsBindModel->member_id;
//Yii::log('sceneid='.$sceneid.' '.$fromUser.' ', 'warning', __METHOD__);

        // 获取经纪人信息
        if ($isCheckJjr==1) {
            $jjrInfo = $this->getJjrInfo($snsBindModel->member_mobile);
            //$arrStr = [
            //    'middle'    => $jjrInfo['jjr_name']."\n".$snsBindModel->member_mobile,
            //    'under'     => $underStr,
            //];
            if ($jjrInfo['jjr_type']==1) {
                $arrStr['middle'] = $jjrInfo['jjr_name']."\n".$snsBindModel->member_mobile;
            }
        }
        // 微信用户信息
        $wxUserInfo = $this->getWxUserInfo($fromUser);

        // 获取当前有效海报背景图
        // $snsModel = UcMemberBindSns::model()->find('sns_id=:openid and member_id=:member_id', [':openid'=>$fromUser,':member_id'=>$member_id]);

        $posterModel = FhPosterModel::model()->GetPosterApi();
        $isAddrRight = FhPosterModel::model()->GetPosterAddr($snsBindModel->location_address);
        $extParams = $jjrInfo;
        $extParams['is_addr_right'] = $isAddrRight;
        if (!$posterModel) {            
            Yii::log('没有可用海报模板: mid='.$member_id.' sid='.$sceneid.' from='.$fromUser.' ', 'warning', __METHOD__);
            // 回复消息没有海报 
            $btime = '2016-10-14 18:30:00';
            if($btime < date('Y-m-d H:i:s')){
                $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"本期活动已结束！查看红包和提现请点击【我的奖励】，红包到账时间：申请提现之日起的2-3个工作日。敬请关注下期活动！"]];
            }else{
                $atime = $this->setTime($btime);
                $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"半山半岛海报转发领红包倒计时".$atime."，敬请关注！"]];
            }  
            $weObj->sendCustomMessage($msg);
            return false;
        }
        
        if (empty($arrStr['_hide_wait_msg'])) {
            // 先回复一条消息 告诉海报正在生成
            $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>"正在生成专属海报，大约需要5秒时间"]];
            $weObj->sendCustomMessage($msg);
        }

        $memberHaibaoModel = $this->makeMemberHaibao($sceneid, $snsBindModel, $posterModel, $extParams);

        $bgpicPath = Yii::app()->basePath .'/..'. $posterModel->photo_url;
        Yii::log('memberHaibaoModel saved sid='.$sceneid.' mid='.$member_id.' oid='.$fromUser.' file_exists('.$bgpicPath.')='.file_exists($bgpicPath).' ', 'warning', __METHOD__);
        
        // 海报中显示元素:
        // 微信头像
        // 用户名称: 如果是经纪人 显示经纪人名称+手机号 否则显示"在别处是未来，在中弘是现在"
        // 显示带参数二维码
        // $this->makeHaibaoImage($bgpicPath, $avatarPath, $jjrInfo, $qrpicPath);

        $localAvatar = $runtimePath.'fanghu_wx_avatar_'.$sceneid.'_'.$fromUser.'.jpg';
        $localAvatar = $this->saveUrl($wxUserInfo['headimgurl'], $localAvatar);
        Yii::log('localAvatar='.$localAvatar.' '.$fromUser.' ', 'warning', __METHOD__);

        // 获取带参数二维码
        $qrcode = $weObj->getQRCode($sceneid, 0, 2592000);
        Yii::log('ticket='.$qrcode['ticket'].' '.$fromUser.' ', 'warning', __METHOD__);
        $qrurl = $weObj->getQRUrl($qrcode['ticket']);
        Yii::log('qrurl='.$qrurl.' '.$fromUser.' ', 'warning', __METHOD__);
        $localQrPath = $runtimePath.'fanghu_qr_'.$sceneid.'.jpg';
        $localQrPath = $this->saveUrl($qrurl, $localQrPath);
        Yii::log('localQrPath='.$localQrPath.' '.$fromUser.' ', 'warning', __METHOD__);

        //$bigImagePath = '/tmp/fanghu_20160329155119158.jpg';
        //$copyQrPath = $this->copyImage($bigImagePath, $localQrPath);

        // 准备好资料后，生成海报图片
        $localPosterPath = $runtimePath.'fanghu_m_poster_'.$sceneid.'.jpg';
        $localPosterPath = $this->makeHaibaoImage($bgpicPath, $localAvatar, $arrStr, $localQrPath, $localPosterPath);
        Yii::log('localPosterPath='.$localPosterPath.' '.$fromUser.' ', 'warning', __METHOD__);

        // 上传海报图片生成media_id
        //$uploadData = (['media'=>'@'.$localPosterPath]);
        $uploadData = (['media'=>new CurlFile($localPosterPath)]);//php 5.5 use
        $qrMediaInfo = $weObj->uploadMedia($uploadData, 'image');
        $mediaId = $qrMediaInfo['media_id'];
        Yii::log('mediaId='.$mediaId.' '.$fromUser.' qrMediaInfo='.json_encode($qrMediaInfo).' ', 'warning', __METHOD__);
        
        // 海报media_id发送给用户
        $msg = ["touser"=>$fromUser, "msgtype"=>'image', "image"=>["media_id"=>$mediaId]];
        $weObj->sendCustomMessage($msg);

        $msg = ["touser"=>$fromUser, "msgtype"=>'text', "text"=>["content"=>'海报生成完毕。分享海报被朋友关注后，可领取现金奖励。']];
        $weObj->sendCustomMessage($msg);

        return true;
    }
    /*
        生成海报model
    */
    public function makeMemberHaibao($sceneid, $snsBindModel, $posterModel, $extParams) {
        $sceneid    = $snsBindModel->bind_id;
        $member_id  = $snsBindModel->member_id;
        $fromUser   = $snsBindModel->sns_id;
        //$snsModel = $this->getBindSnsModel($openid, 1);

        // 生成海报记录 后面统计要用到 所以先保存
        $haibaoLog = new FhMemberHaibaoLogModel;
        $haibaoLog->accounts_id = $this->mpid;
        $haibaoLog->member_id   = $member_id;
        $haibaoLog->sns_bind_id = $snsBindModel->bind_id;
        $haibaoLog->poster_id   = $posterModel->id;
        $haibaoLog->create_time = date('Y-m-d H:i:s');
        if (!$haibaoLog->save()) {
            Yii::log('FhMemberHaibaoLogModel->save error:'.$haibaoLog->lastError().' ', 'error', __METHOD__);
        }

        // 微信用户信息
        $wxUserInfo = $this->getWxUserInfo($fromUser);

        // 获取用户是否生成海报
        $memberHaibaoModel = FhMemberHaibaoModel::model()->with('poster')->find('t.sns_bind_id=:bid and t.accounts_id=:accounts_id', [':bid'=>$sceneid, ':accounts_id'=>$this->mpid]);
        if (!$memberHaibaoModel) {
            Yii::log('这个用户没生成过海报: mid='.$member_id.' appid='.Yii::app()->params['appid'].' accounts_id='.$this->mpid.' sid='.$sceneid.' from='.$fromUser.' jjr='.$extParams['jjr_type'].':'.$extParams['jjr_name'].' ', 'warning', __METHOD__);
            //return false;

            // 生成新的用户海报数据记录
            $memberHaibaoModel = new FhMemberHaibaoModel;
            $memberHaibaoModel->accounts_id     = $this->mpid;
            $memberHaibaoModel->member_id       = $snsBindModel->member_id;//可能为空
            $memberHaibaoModel->sns_bind_id     = $snsBindModel->bind_id;
            $memberHaibaoModel->poster_id       = $posterModel->id;
            $memberHaibaoModel->member_mobile   = $snsBindModel->member_mobile;
            //$memberHaibaoModel->member_fullname = $extParams['jjr_name'];
            $memberHaibaoModel->wx_nickname     = $wxUserInfo['nickname'];
            $memberHaibaoModel->openid          = $fromUser;
            $memberHaibaoModel->project_id      = $posterModel->project_id;
            $memberHaibaoModel->create_time     = date('Y-m-d H:i:s');
            $memberHaibaoModel->last_modified   = date('Y-m-d H:i:s');
            $memberHaibaoModel->withdraw_max    = $posterModel->highest_withdraw_sum;
            $memberHaibaoModel->withdraw_min    = $posterModel->lowest_withdraw_sum;
            $memberHaibaoModel->is_addr_right   = $extParams['is_addr_right'] ? 1 : 0;
        } else {
            Yii::log('生成过海报: mid='.$member_id.' from='.$fromUser.' jjr='.$extParams['jjr_type'].':'.$extParams['jjr_name'].' ', 'warning', __METHOD__);

            // 可能sns上的已经更新 而haibao的没有更新
            if (!empty($snsBindModel->member_mobile) && empty($memberHaibaoModel->member_mobile)) {
                Yii::log('haibao fill mobile='.$snsBindModel->member_mobile.' bid='.$sceneid.' mid='.$member_id.' from='.$fromUser.' ', 'warning', __METHOD__);
                $tmp_id     = $memberHaibaoModel->member_id;
                $member_id  = $snsBindModel->member_id;
                $memberHaibaoModel->member_mobile   = $snsBindModel->member_mobile;
                $memberHaibaoModel->member_id       = $snsBindModel->member_id;
            }

            //$limitWithdraw = FhMemberHaibaoLogModel::countMax($sceneid);
            //Yii::log('limitWithdraw='.json_encode($limitWithdraw).' mid'.$member_id.' from='.$fromUser.' ', 'warning', __METHOD__);

            $memberHaibaoModel->withdraw_max    = $posterModel->highest_withdraw_sum;//$limitWithdraw['themax']*1.0;
            $memberHaibaoModel->withdraw_min    = $posterModel->lowest_withdraw_sum;//min($limitWithdraw['themin']*1.0, $posterModel->lowest_withdraw_sum);
            
            $memberHaibaoModel->poster_id       = $posterModel->id;
            $memberHaibaoModel->project_id      = $posterModel->project_id;
            $memberHaibaoModel->is_addr_right   = $extParams['is_addr_right'] ? 1 : 0;
        }

        // 判断是否经纪人
        if ($jjrInfo['jjr_type']) {
            $memberHaibaoModel->is_jjr      = $extParams['jjr_type'];
            $memberHaibaoModel->jjr_name    = $extParams['jjr_name'];
            //$memberHaibaoModel->save();
        }

        // 保存用户海报
        try {
            if (!$memberHaibaoModel->save()) {
                throw new CException('FhMemberHaibaoModel->save error:'.$memberHaibaoModel->lastError());
            }
            if ($tmp_id) {
                $ret = FhMemberHaibaoLogModel::model()->updateAll(['member_id'=>$member_id], 'member_id=:tmp_id', [':tmp_id'=>$tmp_id]);
                Yii::log('up haibao log: tmp_id='.$tmp_id.' mid='.$member_id.' from='.$fromUser.' ', 'warning', __METHOD__);
            }
        } catch (CException $e) {
            Yii::log('保存用户海报: bid='.$sceneid.' mid='.$member_id.' mobile='.$snsBindModel->member_mobile.' from='.$fromUser.' '.$e->getMessage().' ', 'error', __METHOD__);
            return false;
        }

        return $memberHaibaoModel;
    }
    /*
        强制输出 输出缓冲区后可以继续执行
        fpm 下 Connection 被nginx重写 不生效 所以这个函数是废话
    */
    public function forceFlush() {
        $size = ob_get_length();
        header("Content-Length: $size");
        header("Connection: Close");
        ob_flush();
        flush();
    }
    public function checkIsBind($openid, $return_url = '') {
        $weObj = $this->weObj;
        $bindMember = $this->getBindSnsModel($openid);
        if ($bindMember && $bindMember->member_id) {
            return $bindMember;
        }

        $return_url = $return_url ? $return_url : $this->createAbsoluteUrl('user/autoclose');

        $loginUrl = $this->createAbsoluteUrl('wechat/authlogin', ['mpid'=>$this->mpid, 'return_url'=>$return_url]);
        $msg = ["touser"=>$openid, "msgtype"=>'text', "text"=>["content"=>"生成海报，需要先登录\n<a href=\"$loginUrl\">立即登录</a>"]];
        $weObj->sendCustomMessage($msg);
        return false;
    }
    public function actionTestcheckisbind() {
        $openid = $_GET['openid'] ? $_GET['openid'] : 'oDizAwl-h6sqpuUW5PI_9tsasnoA';
        $ret = $this->checkIsBind($openid);
        echo 'ret=';print_r(OBJTool::convertModelToArray($ret));
    }
    public function getBindSnsModel($openid, $useCache = false) {
        static $arrInfo = [];
        if ($useCache && isset($arrInfo[$openid])) {
            return $arrInfo[$openid];
        }

        $appid = Yii::app()->params['fh_wechat_appid'];
        $snsModel = UcMemberBindSns::model()->find('sns_source=:source and sns_appid=:appid and sns_id=:oid', [
                ':oid'      =>$openid,
                ':appid'    =>$appid,
                ':source'   =>UcMemberBindSns::SNS_SOURCE_WECHAT,
            ]);

        //if ($snsModel) {
        //    return $snsModel->member_id;
        //}
        return $arrInfo[$openid] = $snsModel;
    }
    public function sendTextMessage($toUser, $msg) {
        $msg = ["touser"=>$toUser, "msgtype"=>'text', "text"=>["content"=>$msg]];
        return $this->weObj->sendCustomMessage($msg);
    }
    public function saveUrl($url, $path) {
        // 速度巨慢
        //ob_start();
        //readfile($url);
        //$content = ob_get_contents();
        //ob_end_clean();
        //@file_put_contents($path, $content);
        Http::curldownload($url, $path);

        Yii::log('保存一个图片('.$url.')到本地:'.$path.' ', 'warning', __METHOD__);
        return $path;
    }
    /*
        将二维码拷贝到背景中
    */
    public function makeHaibaoImage($bgImagePath, $avatarPath, $arrStr, $qrImagePath, $saveName) {
        $maxWidth = 640;
        $maxHeight = 906;
        // 生成海报背景+白背景
        list($bgWidth, $bgHeight) = getimagesize($bgImagePath);
        $radio = $maxWidth / $bgWidth;
        $bgAllWidth = $maxWidth;//$bgSizeWidth < $maxWidth ? $maxWidth : $bgSizeWidth;
        $bgAllHeight = intval($bgHeight*$radio);//$bgSizeHeight < $maxHeight ? $maxHeight : $bgSizeHeight;

        // 选择格式
        $bgSuffixArr = explode('.', $bgImagePath);
        $bgSuffix = $bgSuffixArr[count($bgSuffixArr)-1];
        switch (strtolower($bgSuffix)) {
            case 'jpg':
            case 'jpeg':
                $bgImageSrc = imagecreatefromjpeg($bgImagePath);
                break;
            case 'png':
                $bgImageSrc = imagecreatefrompng($bgImagePath);
                break;
            case 'gif':
                $bgImageSrc = imagecreatefromgif($bgImagePath);
                break;
            default:
                $bgImageSrc = imagecreatefromjpeg($bgImagePath);
                break;
        }
        if (!$bgImageSrc) {
            Yii::log('无法打开图片('.$bgImagePath.') '.$bgSuffix.' ', 'error', __METHOD__);
        }

        $bgAllHeightTail = $arrStr['under'] ? 270 : 200;
        $bgSrc = imagecreatetruecolor($bgAllWidth, $bgAllHeight + $bgAllHeightTail);
        $color = imagecolorAllocate($bgSrc,255,255,255);
        imagefill($bgSrc, 0, 0, $color);

        // 输出背景
        imagecopyresampled($bgSrc, $bgImageSrc, 0, 0, 0, 0, $bgAllWidth, $bgAllHeight, $bgWidth, $bgHeight);

        // 输出头像
        $avatarSrc = imagecreatefromjpeg($avatarPath);
        list($avatarWidth, $avatarHeight) = getimagesize($avatarPath);
        //imagecopyresampled($bgSrc, $qrImageSrc, 30, $bgAllHeight+30, 0, 0, 140, 140, $avatarWidth, $avatarHeight);//效率低,画质好
        imagecopyresized($bgSrc, $avatarSrc, 30, $bgAllHeight+30, 0, 0, 140, 140, $avatarWidth, $avatarHeight);
        
        // 输出文字
        $textColor = imagecolorAllocate($bgSrc,44,44,44);
        //$font = 'F:\Windows\Fonts\simhei.ttf';//'F:\Windows\Fonts\simsun.ttc';//'F:\Windows\Fonts\msyh.ttf';
        $font = Yii::app()->basePath.'/../resource/fonts/simhei.ttf';
        //$x = $arrStr[0];//"黑中介a\n黑中介b\n";//'黑中介';//换行也可以
        imagettftext($bgSrc, 20, 0, 190, $bgAllHeight+50+40, $textColor, $font, $arrStr['middle']);
        //imagestring($bgSrc, 5, 200+20, $bgAllHeight+30+20+40, $x, $textColor);//此方法不能输出中文

        if ($arrStr['under']) {
            // 输出横线
            //bool imageline ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
            imageline($bgSrc, 50, $bgAllHeight+200, $bgAllWidth-50, $bgAllHeight+200, $textColor);
            // 输出尾部文字
            $textLen = mb_strlen($arrStr['under']);
            $textLeft = $maxWidth / 2 - 21 * $textLen / 2;
            $textLeft = $textLeft > 0 ? $textLeft : 5;
            imagettftext($bgSrc, 16, 0, $textLeft, $bgAllHeight+200+40, $textColor, $font, $arrStr['under']);
        }
        

        // 输出二维码
        $qrImageSrc = imagecreatefromjpeg($qrImagePath);
        list($qrSizeWidth, $qrSizeHeight) = getimagesize($qrImagePath);
        //imagecopyresampled($bgSrc, $qrImageSrc, 30, $bgAllWidth+30, 0, 0, 140, 140, $qrSizeWidth, $qrSizeHeight);
        imagecopyresized($bgSrc, $qrImageSrc, $bgAllWidth-140-30, $bgAllHeight+30, 30, 30, 140, 140, $qrSizeWidth-60, $qrSizeHeight-60);

        imagejpeg($bgSrc, $saveName, 75);
        Yii::log('输出用户海报带二维码:'.$saveName.' ', 'warning', __METHOD__);

        imagedestroy($bgImageSrc);
        imagedestroy($qrImageSrc);
        imagedestroy($bgSrc);
        return $saveName;
    }
    public function actionTestcopy() {
        //$bigImagePath = '/tmp/loupan2.jpg';
        $bigImagePath = '/tmp/fanghu_20160329155119158.jpg';
        $dir = '/tmp/';
        $qrImagePath = '/tmp/fh_big_ewm.jpg';
        $jjrInfo = $this->getJjrInfo('15011111125');
        $arrStr = [$jjrInfo['jjr_name'], '15011111125'];
        $saveName = $dir.'final_'.$arrStr[1].'.jpg';
        $saveName = $this->makeHaibaoImage($bigImagePath, $qrImagePath, $arrStr, $qrImagePath, $saveName);
        echo '<img src="file://D:'.$saveName.'">';
        echo $saveName;
    }
    public function actionTestsaveurl() {
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQH%2F7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzlqa3lTbURtSEVkbEpnMnBOUmZLAAIEbXyhVwMEAI0nAA%3D%3D';
        $saveName = '/tmp/fh_big_ewm.jpg';
        $saveName = $this->saveUrl($url, $saveName);
        echo '<img src="'.$saveName.'">';
        echo $saveName;
    }
    public function actionTestmakehaibao() {
        $openid = $_GET['openid'] ? $_GET['openid'] : 'oDizAwl-h6sqpuUW5PI_9tsasnoA';
        $jjrInfo = ['jjr_name'=>"经纪人某\n15011111111",'jjr_type'=>1];
        $arrStr = [
            'middle' => "经纪人某\n15011111111",
            //'under'  => "欢迎生成Xahoo海报，",
        ];
        $this->makeHaibao($openid, $arrStr);
        echo 'done';
    }
    
    /*
        为扫码并关注公众号的用户绑定粉丝关系
        此操作在用户注册(user/register,user/bindFhOpenid)之前
            add UcMemberBindSns
            add FhMemberFansModel
    */
    public function bindFans($fansOpenid, $sceneid) {
        $bind_id = $sceneid;
        // 检查用户分享者用户是否注册
        $masterRegModel = UcMemberBindSns::model()->find('bind_id=:mid', [':mid'=>$bind_id]);
        if (!$masterRegModel) {
            Yii::log('二维码分享者不存在:'.$sceneid.' fansOpenid='.$fansOpenid.' ', 'error', __METHOD__);
            return false;
        }
        // 检查是不是绑定自己
        if ($masterRegModel->sns_id == $fansOpenid) {
            Yii::log('不能绑定分享者自己:'.$sceneid.' fansOpenid='.$fansOpenid.' ', 'error', __METHOD__);
            return false;
        }

        $member_id = $masterRegModel->member_id;
        $appid  = Yii::app()->params['fh_wechat_appid'];
        // 预先读取好粉丝信息
        $fansInfo = $this->getWxUserInfo($fansOpenid);

        try {
            // 粉丝注册 新增粉丝账号到注册数据库 但是没有member_id 如果过来注册将会绑定
            //$masterRegModel->member_id;
            // 判断是否注册 如果注册 绑定 如果没注册 则注册再绑定
            $fansRegModel = $this->getBindSnsModel($fansOpenid);
            
            if (!$fansRegModel) {
                // 此处粉丝没有注册 没有member_id
                $fansRegModel = new UcMemberBindSns;
                $fansRegModel->sns_id      = $fansOpenid;
                $fansRegModel->sns_appid   = $appid;
                $fansRegModel->sns_source  = UcMemberBindSns::SNS_SOURCE_WECHAT;
                $fansRegModel->create_time = date('Y-m-d H:i:s');
                $fansRegModel->save();
            } elseif ($fansRegModel->member_id == $member_id) {
                // sns 绑定多次 此举多余
                throw new CException('fans openid bind twice(openid='.$fansOpenid.')');
            }

            // 粉丝与海报分享者关系
            $fansModel = FhMemberFansModel::model()->find('fans_openid=:oid', [':oid'=>$fansOpenid]);
            if (empty($fansModel)) {
                // 判断是否绑定自己的粉丝 不能绑定自己的粉丝
                $masterParentModel = FhMemberFansModel::model()->find('fans_id=:mid', [':mid'=>$member_id]);
                if ($masterParentModel->member_id && $masterParentModel->member_id == $fansRegModel->member_id) {
                    // 不能关注自己的粉丝
                    throw new CException('cannot be fans of my fans:(parent mid='.$masterParentModel->member_id.', mid='.$member_id.')');
                }

                $fansModel = new FhMemberFansModel;
                $fansModel->member_id       = $member_id;
                $fansModel->fans_id         = $fansRegModel->member_id;
                $fansModel->fans_openid     = $fansOpenid;
                $fansModel->create_time     = date('Y-m-d H:i:s');
                $fansModel->save();
            } else {
                // 已绑定 不再派发奖励
                throw new CException('fans('.$fansModel->fans_id.','.$fansModel->fans_openid.') already bind on(mid='.$fansModel->member_id.')');
            }

            // 分享者的上级
            $this->upstreamModel = FhMemberFansModel::model()->find('fans_id=:mid', [':mid'=>$member_id]);

            // 给分享者派发奖励
            // 给分享者上级派发奖励
            if ($this->dispatchReward($member_id, $fansInfo)) {

                // 分分享者发送消息提醒
                $this->notifyMember($masterRegModel, $fansRegModel);
                // 为分享者的上级发送消息提醒
                if ($this->upstreamModel) {
                    $upstreamRegModel = UcMemberBindSns::model()->find('member_id=:mid', [':mid'=>$this->upstreamModel->member_id]);
                    $this->notifyUpstreamMember($upstreamRegModel, $masterRegModel, $fansRegModel);
                }
                Yii::log('已通知:'.' mid='.$member_id.' ', 'warning', __METHOD__);
            }
            $ret = true;
        
        } catch (CException $e) {
            Yii::log('bindFans error:'.$e->getMessage().', mid='.$member_id.' fansOpenid='.$fansOpenid.' ', 'error', __METHOD__);
            $ret = false;
        }
        return $ret;
    }
    public function actionTestbind() {
        $fansOpenid = $_GET['fans'] ? $_GET['fans'] : 'oDizAwoweWpp7WX9BWeVz-L1_EIE';
        $bind_id  = $_GET['bind_id'] ? $_GET['bind_id'] : 1005;
        $ret = $this->bindFans($fansOpenid, $bind_id);
        echo 'done:'.$ret;
    }
    /*
        派发奖励
    */
    public function dispatchReward($member_id, $fansInfo) {
        $trans = Yii::app()->db->beginTransaction();
        try {

            // 为分享者派发money 增加直接粉丝数 总粉丝数
            $this->dispatchMoneyToMember($member_id, 1, $fansInfo['nickname'].'扫码关注奖励');
            //Yii::log('已派发:'.' mid='.$member_id.' ', 'warning', __METHOD__);
            // 为分享者的上级派发money 增加二级粉丝数 总粉丝数
            if ($this->upstreamModel) {
                $this->dispatchMoneyToMember($this->upstreamModel->member_id, 2, $fansInfo['nickname'].'扫码关注奖励');
                //Yii::log('已给上级派发:'.' mid='.$member_id.' ', 'warning', __METHOD__);
            }

            // 提交
            $trans->commit();
            Yii::log('trans success!'.' mid='.$member_id.' ', 'warning', __METHOD__);
            $ret = true;
        } catch (CException $e) {
            Yii::log('trans error:'.$e->getMessage().' mid='.$member_id.' ', 'error', __METHOD__);
            $trans->rollback();
            $ret = false;
        }

        return $ret;
    }
    public function actionTestDispatchReward() {
        $fansOpenid = $_GET['fans'] ? $_GET['fans'] : 'oDizAwp-AhWwIUmTFmv89l6SqgmQ';
        $fansInfo = $this->getWxUserInfo($fansOpenid);
        $member_id = $_GET['member_id'] ? $_GET['member_id'] : 1009;
        $this->upstreamModel =  FhMemberFansModel::model()->find('fans_id=:mid', [':mid'=>$member_id]);;//$this->getBindSnsModel(1005);
        Yii::log('in :'.' mid='.$member_id.' ', 'warning', __METHOD__);
        $this->dispatchReward($member_id, $fansInfo);
        echo 'done';
    }
    /*
        @param $directLevel 1=直接粉丝 2=间接粉丝 //3=关注奖励
    */
    public function dispatchMoneyToMember($member_id, $directLevel, $remark='') {
        // 查找对应参加的海报
        Yii::log('#####SNSMODEL location_address region='.$region.' ', 'warning', __METHOD__);
        $memberPoster = FhMemberHaibaoModel::model()->with('poster')->find('t.member_id=:mid AND t.accounts_id=:accounts_id', [':mid'=>$member_id,':accounts_id'=>$this->mpid]);
        if (!$memberPoster) {
            //Yii::log('cannot find memberPoster:'.' mid='.$member_id.' ', 'error', __METHOD__);
            throw new CException('cannot find memberPoster: mid='.$member_id);
        }

        if ($memberPoster->poster->poster_status!=2) {
            //Yii::log('cannot find memberPoster:'.' mid='.$member_id.' ', 'error', __METHOD__);
            throw new CException('poster not ok: poster='.$memberPoster->poster->id);
        }

        //$rewardMoney = $directLevel==1 ? $memberPoster->poster->direct_fans_rewards : $memberPoster->poster->indirect_fans_rewards;
        $this->directRewardPer = $memberPoster->poster->direct_fans_rewards;
        $this->indirectRewardPer = $memberPoster->poster->indirect_fans_rewards;
        switch ($directLevel) {
            case 1:
                $rewardMoney = $memberPoster->poster->direct_fans_rewards;
                break;
            case 2:
                $rewardMoney = $memberPoster->poster->indirect_fans_rewards;
                break;
            case 3:
                $rewardMoney = $memberPoster->poster->subscribe_rewards;
                break;
            default:
                throw new CException('illegal directLevel: '.$directLevel);
                break;
        }
        // 不符合地域规则 不给奖励
        //if ($memberPoster->is_addr_right==0) {
        //    $rewardMoney = 0;
        //}
        $this->rewardMoney = $rewardMoney;

        // 个人奖励是否达到上限
        if ($memberPoster->reward_money + $rewardMoney > $memberPoster->withdraw_max) {
            throw new CException('个人奖金达到上限:poster_id='.$memberPoster->poster->id.' now='.$memberPoster->reward_money.'+plus='.$rewardMoney.'/all='.$memberPoster->withdraw_max.' mid='.$member_id.' ');
        }

        // 直接奖励 项目奖金是否达到上限
        if ($memberPoster->poster->project_bonus_ceiling>0 && ($memberPoster->poster->direct_fans_rewarded + $memberPoster->poster->indirect_fans_rewarded + $rewardMoney > $memberPoster->poster->project_bonus_ceiling)) {
            throw new CException('项目粉丝奖励达到上限:poster_id='.$memberPoster->poster->id.' now='.$memberPoster->poster->direct_fans_rewarded.'+plus='.$rewardMoney.'/all='.$memberPoster->poster->project_bonus_ceiling.' mid='.$member_id.' ');
        }
        
        // 直接奖励 项目奖金是否达到上限
        if ($memberPoster->poster->project_bonus_ceiling>0 && ($memberPoster->poster->all_rewarded + $rewardMoney > $memberPoster->poster->project_bonus_ceiling)) {
            throw new CException('项目所有奖励达到上限:poster_id='.$memberPoster->poster->id.' now='.$memberPoster->poster->all_rewarded.'+plus='.$rewardMoney.'/all='.$memberPoster->poster->project_bonus_ceiling.' mid='.$member_id.' ');
        }
        
        // 项目粉丝数是否达到上限
        if ($memberPoster->poster->project_fans_ceiling>0 && ($memberPoster->poster->direct_fans_num + $memberPoster->poster->indirect_fans_num >= $memberPoster->poster->project_fans_ceiling)) {
            throw new CException('项目粉丝数达到上限:poster_id='.$memberPoster->poster->id.' now='.$memberPoster->poster->direct_fans_num.'/all='.$memberPoster->poster->project_fans_ceiling.' mid='.$member_id.' @');
        }
        
        // 个人财富增加
        $memberTotal = MemberTotalModel::model()->find('member_id=:mid AND accounts_id=:accounts_id', [':mid'=>$member_id,':accounts_id'=>$this->mpid]);
        if (!$memberTotal) {
            $memberTotal = new MemberTotalModel;
            $memberTotal->accounts_id     = $this->mpid;
            $memberTotal->member_id         = $member_id;
            $memberTotal->create_time       = date('Y-m-d H:i:s', time());
            $memberTotal->money_total       = $rewardMoney;
            $memberTotal->money_gain        = $rewardMoney;
        } else {
            //$memberTotal->updateCounters('money_total=money_total+:money', 'member_id=:mid', [':money'=>$rewardMoney, ':mid'=>$member_id]);
            $memberTotal->money_total += $rewardMoney;
            $memberTotal->money_gain  += $rewardMoney;
        }

        if (!$memberTotal->save()) {
            throw new CException($memberTotal->lastError());
        }
        $eid = $directLevel == 3 ? FhMemberMoneyHistoryModel::EID_SUBSCRIBE_FH : $memberPoster->id;
        
        if ($rewardMoney > 0) {
            
            // 个人财富记录
            $moneyHistory = new FhMemberMoneyHistoryModel;
            $moneyHistory->accounts_id  = $this->mpid;
            $moneyHistory->member_id    = $member_id;
            $moneyHistory->money        = $rewardMoney;
            $moneyHistory->type         = FhMemberMoneyHistoryModel::TYPE_REWARD;
            $moneyHistory->remark       = $remark;
            $moneyHistory->create_time  = date('Y-m-d H:i:s', time());
            $moneyHistory->eid          = $eid;

            
            
            if (!$moneyHistory->save()) {
                throw new CException($moneyHistory->lastError());
            }
        }
        
        

        // 项目派发奖金数增加  // 项目粉丝数增加
        if ($directLevel==1) {
            // 直接粉丝
            $memberPoster->poster->direct_fans_rewarded   += $rewardMoney;
            $memberPoster->poster->direct_fans_num        += 1;
        } elseif ($directLevel==2) {
            // 直接粉丝
            $memberPoster->poster->indirect_fans_rewarded += $rewardMoney;
            $memberPoster->poster->indirect_fans_num      += 1;
        }
        $memberPoster->poster->all_rewarded += $rewardMoney;
        
        if (!$memberPoster->poster->save()) {
            throw new CException($memberPoster->poster->lastError());
        }
       

        // 个人海报派发
        $memberPoster->reward_money   += $rewardMoney;
        $memberPoster->fans_total     += $directLevel<3 ? 1 : 0;
        $memberPoster->fans_first     += $directLevel==1 ? 1 : 0;
        $memberPoster->fans_second    += $directLevel==2 ? 1 : 0;
       
        if (!$memberPoster->save()) {
            throw new CException($memberPoster->lastError());
        }
        

        Yii::log('will success: mid='.$member_id.' directLevel='.$directLevel.' money='.$rewardMoney.' ', 'warning', __METHOD__);
        // 
        return true;
    }
    public function notifyMember($masterRegModel, $fansRegModel) {
        //$masterWxInfo = $this->weObj->getUserInfo()
        //Yii::log('we notify user:'.$masterRegModel->member_id.' fans:'.$fansRegModel->sns_id.' ', 'warning', __METHOD__);
        $masterInfo = $this->getWxUserInfo($masterRegModel->sns_id);
        $fansInfo   = $this->getWxUserInfo($fansRegModel->sns_id);
        $memberTotal = MemberTotalModel::model()->find('member_id=:mid AND accounts_id=:accounts_id', [':mid'=>$masterRegModel->member_id,':accounts_id'=>$this->mpid]);
        $memberPoster   = FhMemberHaibaoModel::model()->find('t.member_id=:mid AND t.accounts_id=:accounts_id', [':mid'=>$masterRegModel->member_id,':accounts_id'=>$this->mpid]);

        $watchMyRewardUrl = $this->createAbsoluteUrl('myHaibao/myreward');
        $authToUrl = $this->createAbsoluteUrl('wechat/authlogin', ['mpid'=>$this->mpid, 'return_url'=>$watchMyRewardUrl]);
        $msg = sprintf("亲爱的%s，恭喜您获得一个粉丝！\n粉丝昵称: %s\n关注时间: %s\n奖励零钱: %.2f元\n当前余额: %.2f元\n奖励满%.0f元即可提现\n\n<a href=\"%s\">【查看我的奖励】</a>", 
            $masterInfo['nickname'], $fansInfo['nickname'], date('Y-m-d H:i', $fansInfo['subscribe_time']), $this->directRewardPer, $memberTotal->money_total*1.0, $memberPoster->withdraw_min, $authToUrl);
        $ret = $this->sendTextMessage($masterRegModel->sns_id, $msg);
        return $ret;
    }
    public function notifyUpstreamMember($upstreamModel, $masterRegModel, $fansRegModel) {
        //$masterWxInfo = $this->weObj->getUserInfo()
        //Yii::log('we notify upstream user:'.$upstreamModel->member_id.' fans:'.$fansRegModel->sns_id.' ', 'warning', __METHOD__);
        $upstreamInfo   = $this->getWxUserInfo($upstreamModel->sns_id);
        $masterInfo     = $this->getWxUserInfo($masterRegModel->sns_id);
        $fansInfo       = $this->getWxUserInfo($fansRegModel->sns_id);
        $memberTotal    = MemberTotalModel::model()->find('member_id=:mid AND accounts_id=:accounts_id', [':mid'=>$upstreamModel->member_id,':accounts_id'=>$this->mpid]);
        $memberPoster   = FhMemberHaibaoModel::model()->find('t.member_id=:mid AND t.accounts_id=:accounts_id', [':mid'=>$upstreamModel->member_id,':accounts_id'=>$this->mpid]);

        $watchMyRewardUrl = $this->createAbsoluteUrl('myHaibao/myreward');
        $authToUrl = $this->createAbsoluteUrl('wechat/authlogin', ['mpid'=>$this->mpid, 'return_url'=>$watchMyRewardUrl]);
        $msg = sprintf("亲爱的%s，恭喜您获得一个间接粉丝！\n粉丝昵称: %s\n推荐人: %s\n关注时间: %s\n奖励零钱: %.2f元\n当前余额: %.2f元\n奖励满%.0f元即可提现\n\n<a href=\"%s\">【查看我的奖励】</a>", 
            $upstreamInfo['nickname'], $fansInfo['nickname'], $masterInfo['nickname'], date('Y-m-d H:i', $fansInfo['subscribe_time']), $this->indirectRewardPer, $memberTotal->money_total*1.0, $memberPoster->withdraw_min, $authToUrl);
        $ret = $this->sendTextMessage($upstreamModel->sns_id, $msg);
        return $ret;
    }
    public function notifySubscribeReward($openid, $posterModel) {
        $masterInfo     = $this->getWxUserInfo($openid);
        
        $snsModel       = $this->getBindSnsModel($openid);
        $memberTotal    = MemberTotalModel::model()->find('member_id=:mid AND accounts_id=:accounts_id', [':mid'=>$snsModel->member_id,':accounts_id'=>$this->mpid]);

        $watchMyRewardUrl = $this->createAbsoluteUrl('myHaibao/myreward');
        $authToUrl = $this->createAbsoluteUrl('wechat/authlogin', ['mpid'=>$this->mpid, 'return_url'=>$watchMyRewardUrl]);

        $msg = sprintf("亲爱的%s，恭喜您获得关注奖励！\n关注时间: %s\n奖励零钱: %.2f元\n当前余额: %.2f元\n奖励满%.0f元即可提现\n\n<a href=\"%s\">【查看我的奖励】</a>", 
            $masterInfo['nickname'], date('Y-m-d H:i', $masterInfo['subscribe_time']), $posterModel->subscribe_rewards, $memberTotal->money_total*1.0, $posterModel->lowest_withdraw_sum, $authToUrl);

        $ret = $this->sendTextMessage($openid, $msg);
        return $ret;
    }
    public function actionTestnotify() {
        $masterOpenid = $_GET['master'] ? $_GET['master'] : 'oDizAwl-h6sqpuUW5PI_9tsasnoA';
        $fansOpenid   = $_GET['fansOpenid'] ? $_GET['fansOpenid'] : 'oDizAwp-BbBbBBmTFmv89l6SqgmQ';//'oDizAwp-AhWwIUmTFmv89l6SqgmQ';
        //$ret = $this->sendTextMessage($masterOpenid, 'yes we do ok');
        $masterRegModel = $this->getBindSnsModel($masterOpenid);
        //$fansRegModel = $this->getBindSnsModel($fansOpenid);
        $fansRegModel = new UcMemberBindSns;
        $fansRegModel->sns_id      = $fansOpenid;
        $fansRegModel->sns_appid   = $appid;
        $fansRegModel->sns_source  = UcMemberBindSns::SNS_SOURCE_WECHAT;
        $fansRegModel->create_time = date('Y-m-d H:i:s');
        //$fansRegModel->save();
        echo 'masterRegModel=';print_r($masterRegModel->toArray());echo 'fansRegModel=';print_r($fansRegModel->toArray());
        $this->notifyMember($masterRegModel, $fansRegModel);
    }
    public function getWxUserInfo($openid) {
        static $arrUserInfo = [];
        if (isset($arrUserInfo[$openid])) {
            return $arrUserInfo[$openid];
        }
        
        $info = $this->weObj->getUserInfo($openid);
        $arrUserInfo[$openid] = $info;
        return $info;
    }
    public function getJjrInfo($mobile) {
        $params = [
            'phone' => $mobile,
        ];
        $ret = Yii::app()->getModule('api')->FangfullApi($params)->getJjrInfo();
        $default = [
            'jjr_type'  => $ret['data']['isbroker'],
            'jjr_name'  => $ret['data']['brokername'],
            '_ret'      => $ret,
        ];
        //$default['jjr_name'] = $ret['data']['brokername'];
        
        return $default;
    }
    public function actionTestJjr($mobile = '15011111125') {
        //$mobile = $_GET['mobile'];
        $ret = $this->getJjrInfo($mobile);
        echo 'ret=';print_r($ret);
    }
    public function actionSetmenu() {
        $key = $_POST['key'];
        $token = $_POST['token'];
        $rightToken = '010115001100749';
        $rightKey = 'xdr';
        if ($rightKey == $key && $rightToken == $token) {
            //获取不同公众号的menu
            if(Yii::app()->params['appid'] == 'wx829d7b12c00c4a97'){
                $menu = $this->getHaibaoMenu();
            }elseif(Yii::app()->params['appid'] == 'wxea22dca227352ccf'){
                $menu = $this->getHaibaoMenu_test();
            }            
            $menu = @json_decode($menu, true);
            $weObj = $this->weObj;
            //$weObj->createMenu($menu);
            //print_r($menu);
            //echo 'success';
        } else {
            echo 'input';
        }
        
        $selfUrl = Yii::app()->request->url;
        $tpl = '<form action="'.$selfUrl.'" method="POST">key:<input name="key"/>token:<input name="token"/><input type="submit"></form>';
        echo $tpl;
        
    }
    public function actionTestoauth() {
        //getOauthRedirect($callback,$state='',$scope='snsapi_userinfo'){
        $callback = $this->createAbsoluteUrl('Wechat/authecho');
        $state = 'xahoo_poster';
        $scope = 'snsapi_base';
        $url = $this->weObj->getOauthRedirect($callback, $state, $scope);
        $this->redirect($url);
    }
    /*
        微信授权登录入口
            将跳转到微信授权页面 必须微信客户端打开此页
    */
    public function actionAuthlogin() {
		$return_url = $this->outPutString($_GET['return_url']);
        $this->mpid = intval($_GET['mpid']) ? : 1;
        $wechatOptions = $this->getAccountOptions($this->mpid);
        $this->weObj = new Wechat($wechatOptions);

        $callback = $this->createAbsoluteUrl('Wechat/authecho', ['mpid'=>$this->mpid, 'return_url'=>$return_url]);
        $state = 'xahoo_poster';
        $scope = 'snsapi_base';
        $url = $this->weObj->getOauthRedirect($callback, $state, $scope);
        $this->redirect($url);
    }
    /*
        微信服务器授权成功后回调此页
            此页会设置session，然后跳转到user/wxautologin 
    */
    public function actionAuthecho() {
        session_start();

        if (isset($_GET['return_url']) && !empty($_GET['return_url'])) {
            $return_url = $_GET['return_url'];
        }

        $this->mpid = intval($_GET['mpid']) ? : 1;
        $wechatOptions = $this->getAccountOptions($this->mpid);
        $this->weObj = new Wechat($wechatOptions);

        // 拿到code去取access_token
        $tokenInfo = $this->weObj->getOauthAccessToken();

        if (!$tokenInfo['access_token'] && !$tokenInfo['openid']) {
            Yii::log('oauth token error: '.json_encode($tokenInfo).' '.' ', 'warning', __METHOD__);
            $this->redirect($this->createAbsoluteUrl('user/login', ['oauth'=>'e', 'return_url'=>$return_url]));
            return false;
        }
        //$userInfo = $this->getWxUserInfo($tokenInfo['openid']);
        $sessionValue = [
            'mpid'      => $this->mpid,
            'sns_id'    => $tokenInfo['openid'],
            'appid'     => $wechatOptions['appid'],//Yii::app()->params['fh_wechat_appid'],
            'plat'      => UcMemberBindSns::SNS_SOURCE_WECHAT,
        ];
        $_SESSION[Yii::app()->params['third_login_sess_name']] = $sessionValue;
        Yii::log('oauth token success: '.json_encode($tokenInfo).' '.' ', 'warning', __METHOD__);

        $this->redirect($this->createAbsoluteUrl('user/wxautologin', ['return_url'=>$return_url]));
    }
    public function actionTestflush() {
        echo '';
        $this->forceFlush();
        sleep(2);
        echo '21000';
    }
    public function getPicRuntimePath() {
        $dir = Yii::app()->runtimePath.'/hbpic/';
        if (!file_exists($dir)) {
            if (@mkdir($dir, 0777, true)) {
                Yii::log('mkdir(runtimePath='.$dir.') success'.' ', 'warning', __METHOD__);
            } else {
                Yii::log('mkdir(runtimePath='.$dir.') error'.' ', 'error', __METHOD__);
            }
        }
        return $dir;
    }
    public function actionTesthaibaomax() {
        $member_id = $_GET['member_id'] ? $_GET['member_id'] : 1005;
        $ret = FhMemberHaibaoLogModel::countMax($member_id);
        echo 'ret=';print_r($ret);
        $count = Yii::app()->getModule('sns')->stasticSns(Yii::app()->params['fh_wechat_appid']);
        echo 'count(sns)=';print_r($count);
    }
    public function actionTestmakehaibaolog() {
        $haibaoList = FhMemberHaibaoModel::model()->findAll();
        if ($haibaoList)
        foreach ($haibaoList as $haibao) {
            $haibaoLog = FhMemberHaibaoLogModel::model()->find('member_id=:mid and poster_id=:pid', [':mid'=>$haibao->member_id, ':pid'=>$haibao->poster_id]);
            if (!$haibaoLog) {
                $haibaoLog = new FhMemberHaibaoLogModel;
                $haibaoLog->member_id = $haibao->member_id;
                $haibaoLog->sns_bind_id = $haibao->sns_bind_id;
                $haibaoLog->poster_id = $haibao->poster_id;
                if ($haibaoLog->save()) {
                    echo "made mid=".$haibao->member_id." \n";
                } else {
                    echo "made mid=".$haibao->member_id.' error:'.$haibaoLog->lastError()." \n";
                }
            }
        }
        echo 'done';
    }
    public function actionTestupwithdraw() {
        $ret = FhMemberHaibaoModel::updateWithdrawLimitByPoster($poster_id);
        //$ret = FhMemberHaibaoLogModel::countMax($member_id);
        echo 'ret=';print_r($ret);
    }
    /*
        为粉丝创建账号
    */
    public function makeAccount($openid) {
        $snsModule = Yii::app()->getModule('sns');
        $ret = $snsModule->makeAccountFromWxFanghu($openid);
        return $ret;
    }
    public function actionTestmakeaccount() {
        $openid = $_GET['openid'] ? $_GET['openid'] : 'oDizAwl-h6sqpuUW5PI_9tsasnoA';
        $ret = $this->makeAccount($openid);
        echo 'ret=';print_r(OBJTool::convertModelToArray($ret));
    }
    /*
        个性海报提交资料生成个性海报
    */
    public function actionAjaxDiyHaibao() {
        $member_id = Yii::app()->loginUser->getUserId();

        $wechatOptions = $this->getAccountOptions($this->mpid);
        $this->weObj = new Wechat($wechatOptions);

        $weObj = $this->weObj;
        $nick = $_POST['nickname'];
        $tel = $_POST['tel'];
        $desc = $_POST['desc'];
        
        $snsModel = UcMemberBindSns::model()->find('member_id=:mid', [':mid'=>$member_id]);
        if (empty($snsModel)) {
            $url = $this->createAbsoluteUrl('wechat/authlogin', ['mpid'=>$this->mpid]);
            $this->jsonError('页面过期,请重新登录', ['return_url'=>$url]);
        }

        $fromUser = $snsModel->sns_id;
        if (!$fromUser) {
            $this->jsonError('请在微信浏览器中操作。');
        }

        $arrStr = [
            'middle' => $nick."\n".$tel,
            'under'  => $desc,
            '_hide_wait_msg' => 1,
        ];
        
        //$snsModel = $this->getBindSnsModel($fromUser);
        if ($this->makeHaibao($fromUser, $arrStr)) {
            $this->jsonSuccess('提交成功');
        } else {
            $this->jsonError('服务器忙请稍后再试。');
        }
    }
    /*
        给关注用户发放红包
    */
    public function dispatchSubscribeReward($openid, $member_id) {
        //$member_id = $memberModel->member_id;
        $snsModel = $this->getBindSnsModel($openid, 1);
        
        if (empty($snsModel)) {
            Yii::log('no sns (openid='.$openid.') when dispatch'.' ', 'error', __METHOD__);
            return false;
        }

        
        if (!$member_id) {
            $member_id = $snsModel->member_id;
        }

        //$memberHaibaoModel = FhMemberHaibaoLogModel::model()->find('member_id=:mid', [':mid'=>$member_id]);
        $posterModel = FhPosterModel::model()->GetPosterApi();
        if (empty($posterModel)) {
            Yii::log('no poster ok(mid='.$member_id.') when dispatch'.' ', 'error', __METHOD__);
            return false;
        }
        // 钱不够时，自动关闭项目
        if ($posterModel->subscribe_rewards + $posterModel->all_rewarded > $posterModel->project_bonus_ceiling) {
            $posterModel->poster_status = 1;
            $posterModel->save();
            Yii::log('no enough money: (poster='.$posterModel->id.'), close it'.' ', 'error', __METHOD__);
            return false;
        }

        $this->makeMemberHaibao($snsModel->bind_id, $snsModel, $posterModel, []);

        $histKey = FhMemberMoneyHistoryModel::EID_SUBSCRIBE_FH;
        $ret = false;

        $trans = Yii::app()->db->beginTransaction();
        try {
            // 查看是否奖励过
            $moneyHistory = FhMemberMoneyHistoryModel::model()->find('member_id=:mid and eid=:eid and accounts_id=:accounts_id', [':mid'=>$member_id, ':eid'=>$histKey, ':accounts_id'=>$this->mpid]);
            if (!empty($moneyHistory)) {
                throw new CException('already got reward: '.$histKey);
            }
            
            $this->dispatchMoneyToMember($member_id, 3, '关注Xahoo公众号奖励');

            $trans->commit();
            $ret = true;
            Yii::log('dispatch subscribe trans ok(mid='.$member_id.',openid='.$openid.')'.' ', 'warning', __METHOD__);
        } catch (CException $e) {
            Yii::log('dispatch subscribe trans error:'.$e->getMessage().'(mid='.$member_id.',openid='.$openid.')'.' ', 'error', __METHOD__);
            $trans->rollback();
        }
        
        if ($ret) {
            $this->notifySubscribeReward($openid, $posterModel);
        }
        
        return $ret;
    }
    public function actionTestsubscribereward() {
        $openid = $_GET['openid'] ? $_GET['openid'] : 'oDizAwl-h6sqpuUW5PI_9tsasnoA';
        $memberModel = $this->makeAccount($openid);
        $ret = $this->dispatchSubscribeReward($openid, $memberModel->member_id);
        echo 'ret=';print_r($ret);
    }
    public function actionTestclear() {
        $sql1 = ['delete from fh_money_withdraw;','delete from fh_member_haibao;','delete from fh_member_haibao_log;','delete from fh_member_fans;','delete from fh_member_total;','delete from fh_member_money_history;'];
        $sql2 = 'delete from uc_member_bind_sns';
        try {
            
            foreach ($sql1 as $sql) {
                $ret = Yii::app()->db->createCommand($sql)->execute();
                echo 'ret=';print_r($ret);
            }
            $ret = Yii::app()->UCenterDb->createCommand($sql2)->execute();
            echo 'ret=';print_r($ret);
        } catch (CException $e) {
            echo $e->getMessage();
        }
        
    }
    // 重新为海报填写member_id
    public function actionFillmobileforhaibao() {
        //$memberHaibaoList = FhMemberHaibaoModel::model()->findAll('member_mobile like :mobile', [':mobile'=>'']);
        $limit = intval($_GET['limit']) ? intval($_GET['limit']) : 500;
        $like = $_GET['like'] ? $_GET['like'] : '';
        $sql = 'select * from fh_member_haibao where member_mobile like "'.$like.'" limit '.$limit;
        $sql = 'SELECT s.bind_id bind_id,s.member_id s_member_id,s.member_mobile s_member_mobile,h.member_id h_member_id,h.member_mobile h_member_mobile,th.money_total th_total,ts.money_total ts_total
 FROM uc_member_bind_sns s
 LEFT JOIN fanghu_db.fh_member_haibao h on h.sns_bind_id=s.bind_id
 LEFT JOIN fanghu_db.fh_member_total th on th.member_id=h.member_id
 LEFT JOIN fanghu_db.fh_member_total ts on ts.member_id=s.member_id
 where s.member_id != h.member_id';
        $sql = 'SELECT s.bind_id bind_id,s.member_id s_member_id,s.member_mobile s_member_mobile,h.member_id h_member_id,h.member_mobile h_member_mobile
 FROM uc_member_bind_sns s
 LEFT JOIN fanghu_db.fh_member_haibao h on h.sns_bind_id=s.bind_id
 where s.member_id != h.member_id limit '.$limit*1 .'';

        $memberHaibaoList = Yii::app()->db->createCommand($sql)->queryAll();
        echo "all selected mobile=".count($memberHaibaoList)."\n";
        print_r($memberHaibaoList);exit;
        
        $sql = 'UPDATE fanghu_db.fh_member_haibao h
 LEFT JOIN uc_member_bind_sns s on h.sns_bind_id=s.bind_id
 set h.member_id = s.member_id,h.member_mobile = s.member_mobile
 where s.member_id != h.member_id 
;';
        $ret = Yii::app()->db->createCommand($sql)->execute();
        echo 'ret=';print_r($ret);exit;

        $will = 0;
        $success = 0;
        if (!empty($memberHaibaoList))
        foreach ($memberHaibaoList as $haibao) {
            //$snsModel=UcMemberBindSns::model()->findByPk($haibao['bind_id']);
            if ($haibao['s_member_mobile'] != '') {
                $will ++;
                //$ret = FhMemberHaibaoModel::model()->updateAll('member_mobile=:mobile',$haibao['id'] [':mobile'=>$haibao['member_mobile']]);
                $sql = 'update fh_member_haibao set member_mobile="'.$haibao['s_member_id'].'",member_id="'.$haibao['s_member_mobile'].'" where sns_bind_id="'.$haibao['bind_id'].'"';
                try {
                    $ret = Yii::app()->db->createCommand($sql)->execute();
                    $success += $ret*1;
                    echo "up done: mobile=".$haibao['s_member_id'].' mid='.$haibao['s_member_mobile'].' oldmid='.$haibao['h_member_id'].' oldmob='.$haibao['h_member_mobile'].' sns_bind_id='.$haibao['bind_id']."\n";
                } catch (CException $e) {
                    echo 'error:'.$e->getMessage()."\n";
                }
            } else {
                
            }
            //$ret = $haibao->save();
        }
        echo "will =".$will." success=".$success."\n";
        //$sql = 'Select member_id,count(member_id) cnt from fh_member_haibao group by having cnt > 1';
        //$ret = Yii::app()->db->createCommand($sql)->queryAll();
        //echo 'ret=';print_r($ret[0]);
    }
    public function actionTestredpack() {
        $openid=$_GET['openid'] ? $_GET['openid'] : 'o2CgkuPI-QMsUSkWiNzbEirQt4RM';
        //$ret= $this->weObj->sendRedPack($openid, 100);
        $options = [];
        $options['act_name'] = 'haibao act';
        $options['send_name'] = 'haibao sender';
        $options['remwark'] = 'remark good';
        $options['wishing'] = 'wishing you better';
        $fhRedpack = new FanghuWechatRedpack($options);
        $ret = $fhRedpack->billno();
        $ret = $fhRedpack->sendRedPack($openid, 100);
        echo 'ret=';print_r($ret);
    }
    // 删除不合格提现记录
    public function actionTestclearrubbishwithdraw() {
        $sql = 'delete from fh_money_withdraw where withdraw_money<1.0';
        $ret = Yii::app()->db->createCommand($sql)->execute();
        echo 'ret=';print_r($ret);
    }
    /*
        海报菜单
    */
    protected function getHaibaoMenu() {
        return $menu = '
{
    "button":[
    {
        "name":"生成海报",
        "sub_button":[
        {
            "type":"click",
            "name":"项目海报",
            "key":"MENU_HAIBAO_COMMON"
        },
        {
            "type":"click",
            "name":"个性海报",
            "key":"MENU_HAIBAO_DIY"
        },
        {
            "type":"view",
            "name":"我的奖励",
            "url":"http://xahoo.xenith.top/index.php?r=wechat/authlogin&mpid=1&return_url=http%3A%2F%2Fxahoo.xenith.top%2Findex.php%3Fr%3DmyHaibao%2FmyReward%26accounts_id%3D2"
        }]
    },
    {
        "type":"view",
        "name":"积分任务",
        "url":"http://xahoo.xenith.top/index.php?r=lizhuan/index"
    },
    {
        "name":"服务中心",
        "sub_button":[
        {
            "type":"view",
            "name":"注册好礼",
            "url":"http://xahoo.xenith.top/index.php?r=user/register"
        },
        {
            "type":"view",
            "name":"我的积分",
            "url":"http://xahoo.xenith.top/index.php?r=myPoints/index"
        },
        {
            "type":"click",
            "name":"在线咨询",
            "key":"MENU_ONLINE_ADVICE"
        }]
    }]
}';
    }
    //倒计时
    public function setTime($date){
            $str = '';
            $begintime = time();
            $endtime = strtotime($date);
            //计算天数
            $timediff = $endtime-$begintime;
            $days = intval($timediff/86400);
            //计算小时数
            $remain = $timediff%86400;
            $hours = intval($remain/3600);
            //计算分钟数
            $remain = $remain%3600;
            $mins = intval($remain/60);
            //计算秒数
            $secs = $remain%60;
            $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
            if($res['hour']<=2){
                if($res['hour']){
                    $str .= $res['hour'].'小时';
                }
                if($res['min']){
                    $str .= $res['min'].'分';
                }
                if($res['sec']){
                    $str .= $res['sec'].'秒';
                }
            }else{
                if($res['day']){
                    $str .= $res['day'].'天';
                }
                if($res['hour']){
                    $str .= $res['hour'].'小时';
                }
            }            
            return $str;
        }
}
