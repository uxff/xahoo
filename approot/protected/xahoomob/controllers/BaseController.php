<?php

/**
 * 公用业务逻辑
 */
class BaseController extends Controller {
    
    public function init() {
        parent::init();
        $this->saveSignage();
    }
    public function addPoint($member_id, $action) {

        $objpointRule = $this->selectPoint($action);
        if (!empty($objpointRule)) {

            //写积分日志
            $this->addMemberPointLog($member_id, $objpointRule);

            //写贡献日志
            $this->addMemberContributionLog($member_id, $objpointRule);

            //更新会员总信息表(积分和贡献)
            $this->UpdateMemberTotal($member_id, $objpointRule);
        }
    }

    //更新会员总信息表
    public function UpdateMemberTotal($member_id, $objpointRule) {
        $MemberTotal = MemberTotal::model()->find("member_id={$member_id}");
        if (!empty($MemberTotal)) {
            $MemberTotal->total_point += $objpointRule->rule_point;
            $MemberTotal->total_contribute += $objpointRule->rule_contribution;
            $MemberTotal->last_modified = date('Y-m-d', time());
            $MemberTotal->update();
        }
    }

    //更新任务的点击数和积分数
    public function updateMemberToTask($member_id, $task_id) {
        //$objpointRule = $this->selectPoint('pro_click');
        $MemberToTask = MemberToTask::model()->find("member_id={$member_id} and task_id={$task_id} and status=1");
        if (!empty($MemberToTask)) {
            //$MemberToTask->total_point += $objpointRule->rule_point;
            $MemberToTask->total_click += 1;
            $MemberToTask->last_modified = date('Y-m-d H:i:s', time());
            $MemberToTask->update();
        }
    }

    //查积分规则
    public function selectPoint($action) {
        $pointRule = PointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => $action));
        if (!empty($pointRule)) {
            return $pointRule; //$pointRule->rule_point;
        }
    }

    //加贡献值
    public function addMemberContribute($member_id, $objpointRule) {
        $memberContribute = MemberContribute::model()->find('member_id=:member_id', array('member_id' => $member_id));
        if (!empty($memberContribute)) {
            $memberContribute->member_contribute_value += $objpointRule->rule_contribution;
            $memberContribute->update_time = date('Y-m-d', time());
            $memberContribute->update();
        } else {
            $MemberContribute = new MemberContribute();
            $MemberContribute->member_id = $member_id;
            $MemberContribute->member_contribute_value = $objpointRule->rule_contribution;
            $MemberContribute->create_time = date('Y-m-d', time());
            $MemberContribute->update_time = date('Y-m-d', time());
            $MemberContribute->insert();
        }
    }

    //查当前会员总信息
    public function selectMemberTotal($member_id) {
        $MemberTotal = MemberTotal::model()->find('member_id=:member_id', array('member_id' => $member_id));
        if (!empty($MemberTotal)) {
            return $MemberTotal;
        }
    }

    //写积分日志
    public function addMemberPointLog($member_id, $objpointRule) {

        $objMemberTotal = $this->selectMemberTotal($member_id);
        if (!empty($objMemberTotal)) {
            $point_before = $objMemberTotal->total_point;
        } else {
            $point_before = 0;
        }

        $MemberPointLog = new MemberPointLog();
        $MemberPointLog->member_id = $member_id;
        $MemberPointLog->rule_id = $objpointRule->rule_id;
        $MemberPointLog->rule_point = $objpointRule->rule_point;
        $MemberPointLog->operate_type = 1;
        $MemberPointLog->description = $objpointRule->rule_name;
        $MemberPointLog->point_before = $point_before;
        $MemberPointLog->point_after = $point_before + $objpointRule->rule_point;
        $MemberPointLog->create_time = date('Y-m-d', time());
        $MemberPointLog->insert();
    }

    //写贡献日志
    public function addMemberContributionLog($member_id, $objpointRule) {

        $objMemberTotal = $this->selectMemberTotal($member_id);
        if (!empty($objMemberTotal)) {
            $contribute_before = $objMemberTotal->total_contribute;
        } else {
            $contribute_before = 0;
        }

        $MemberContributeLog = new MemberContributeLog();
        $MemberContributeLog->member_id = $member_id;
        $MemberContributeLog->contribute_before = $contribute_before;
        $MemberContributeLog->contribute_after = $contribute_before + $objpointRule->rule_contribution;
        $MemberContributeLog->create_time = date('Y-m-d', time());
        $MemberContributeLog->insert();
    }

    //查会员
    public function selectMember($signage) {
        $MemberModel = MemberModel::model()->find("signage=:signage", array(":signage" => $signage));
        if (!empty($MemberModel)) {
            return $MemberModel;
        }
    }

    //查小伙伴
    public function selectMemberRelation($id) {
        $arr = array();

        $member_id = Yii::app()->loginUser->getUserId();
        $memberRelationLogin = MemberRelation::model()->find("member_id={$member_id}"); //当前登陆者的小伙伴深度

        $memberRelation = memberRelation::model()->findAll("parent_id={$id}");
        $result = $this->convertModelToArray($memberRelation);
        if (!empty($result)) {
            foreach ($result as $v) {
                $MemberModel = MemberModel::model()->find("member_id=:member_id", array(":member_id" => $v['member_id']));
                $v['parent_depth'] = $v['parent_depth'] - $memberRelationLogin->parent_depth;
                if ($v['parent_depth'] > 1) {
                    if (!empty($MemberModel->member_mobile)) {
                        $v['member_mobile'] = substr($MemberModel->member_mobile, 0, 3) . '*****' . substr($MemberModel->member_mobile, 8);
                    } else {
                        $v['member_mobile'] = '手机号未设置';
                    }
                    if (!empty($MemberModel->member_name)) {
                        $len = mb_strlen($MemberModel->member_name);
                        $v['member_name'] = mb_substr($MemberModel->member_name, 0, 1) . str_repeat('*', $len - 1);
                    } else {
                        $v['member_name'] = '姓名未设置';
                    }
                } else {
                    $v['member_name'] = $MemberModel->member_name;
                    $v['member_mobile'] = $MemberModel->member_mobile;
                }
                $v['member_nickname'] = $MemberModel->member_nickname;
                $v['member_avatar'] = $MemberModel->member_avatar;
                $v['create_time'] = $MemberModel->create_time;
                $v['has_children'] = $MemberModel->has_children;

                $arr[] = $v; //组合数组 
            }

            return $arr;
        }
    }

    //查小伙伴 递归
    public function selectMemberRelation1($id) {
        $arr = array();
        static $num = 0;
        $memberRelation = MemberRelation::model()->findAll("parent_id={$id}");
        $result = $this->convertModelToArray($memberRelation);
        if ($result) {

            foreach ($result as $v) {
                $MemberModel = MemberModel::model()->find("member_id=:member_id", array(":member_id" => $v['member_id']));
                $v['member_nickname'] = $MemberModel->member_nickname;
                $v['member_mobile'] = $MemberModel->member_mobile;
                $v['member_name'] = $MemberModel->member_name;
                $v['list'] = $this->selectMemberRelation1($v['member_id']);
                $arr[] = $v; //组合数组 
                $num +=1;
            }
            $arr['num'] = $num;
            return $arr;
        }
    }

    //查小伙伴数量 递归
    public function selectMemberRelationNum($id) {
        $arr = array();
        static $num = 0;
        $memberRelation = MemberRelation::model()->findAll("parent_id={$id}");
        $result = $this->convertModelToArray($memberRelation);
        if ($result) {
            foreach ($result as $v) {
                $this->selectMemberRelationNum($v['member_id']);
                $num +=1;
            }
            //return $num;
        }
        return $num;
    }

    //插入会员关系表
    public function addMemberRelation($member_id, $parent_id) {
        $MemberRelation = MemberRelation::model()->find("member_id=:member_id", array(":member_id" => $parent_id));
        if (!empty($MemberRelation)) {
            $parent_depth = $MemberRelation->parent_depth + 1;
            $parent_tree = empty($MemberRelation->parent_tree) ? $parent_id : $MemberRelation->parent_tree . ',' . $parent_id;
        } else {
            $parent_depth = 0;
            $parent_tree = '';
        }
        $MemberRelation = new MemberRelation();
        $MemberRelation->member_id = $member_id;
        $MemberRelation->parent_id = $parent_id;
        $MemberRelation->parent_depth = $parent_depth;
        $MemberRelation->parent_tree = $parent_tree;
        $MemberRelation->insert();
    }

    /**
     *
     * 图片上传处理func
     */
    public function getFileName($cUpfile) {
        $news_name1 = date("YmdHis") . time() . rand(100, 999);
        $news_name = $news_name1 . "." . $cUpfile->extensionName;
        return $news_name;
    }

    public function upload_dir() {

        $root_folder = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

        //创建upload根目录
        if (!file_exists($root_folder)) {
            mkdir($root_folder);
        }

        $uppath = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR;

        //创建月份目录
        if (!file_exists($uppath)) {
            mkdir($uppath, 0777);
        }
        $rtpath = $paths = array();
        //创建尺寸目录
        $rtpath['ori'] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . "o" . DIRECTORY_SEPARATOR;

        $rtpath['thumb'][] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . Yii::app()->params['uploadPic']['appUserPhotoWidth'] . 'x' . Yii::app()->params['uploadPic']['appUserPhotoHeight'] . DIRECTORY_SEPARATOR;

        foreach ($paths as $value) {
            if (!file_exists($value)) {
                mkdir($value, 0777);
            }
        }
        $rtpath['url'] = Yii::app()->params['uploadPic']['webPath'] . date("Ym") . "/";
        return $rtpath;
    }

    /**
     * 判断是否已经登录
     */
    public function checkLogin($return_url = '') {

        $isGuest = Yii::app()->loginUser->getIsGuest();
        // 未登录
        if ($isGuest) {
            $this->redirect($this->createAbsoluteUrl('site/login', ['return_url'=>$return_url]));
        } else {
            return Yii::app()->loginUser->getUserId();
        }
    }

    /**
     * 保存会员邀请标识
     */
    public function saveSignage() {
        if (!empty($_REQUEST['signage'])) {
            $signage = $this->getString($_REQUEST['signage']);
            $arrMember = UCenterStatic::getUserInfo($signage);
            if (!empty($arrMember)) {
                $cookie = new CHttpCookie('signage', $signage);
                $cookie->expire = time() + 60 * 60 * 24;  //有限期1天
                //$cookie->domain = substr(Yii::app()->request->hostInfo,  strpos(Yii::app()->request->hostInfo,"."));
                Yii::app()->request->cookies['signage'] = $cookie;
                //$cookie = Yii::app()->request->getCookies();
                //echo Yii::app()->request->cookies['signage'];
            }
        }
    }

    /**
     * 判断手机号是否注册过  格式是否正确
     *
     */
    public function _verifyMobile($mobiles = '', $mode = 0) {
        //get Mobile
        $mobile = trim($this->getString($mobiles));

        //查看手机号
        if (empty($mobile)) {
            $status = 'fail';
            $message = '请输入您的手机号';
        } elseif (AresValidator::isValidChineseMobile($mobile)) {
            $arrSqlParams = array(
                'condition' => 'member_mobile=' . $mobile,
            );
            $total = MemberModel::model()->count($arrSqlParams);

            if ($mode > 0) {
                if ($total > 0) {
                    $status = 'success';
                    $message = '该手机号为注册账户';
                } else {
                    $status = 'fail';
                    $message = '该手机号尚未注册';
                }
            } else {
                if ($total > 0) {
                    $status = 'fail';
                    $message = '该手机号已存在';
                } else {
                    $status = 'success';
                    $message = '该手机号尚未使用';
                }
            }
        } else {
            $status = 'fail';
            $message = '手机号格式不正确';
        }
        $result = array(
            'status' => $status,
            'message' => $message,
        );
        return $result;
    }

    /**
     * 判断邮箱是否注册过
     *
     */
    public function _verifyEmail($email = '') {

        $email = trim($this->getString($_GET['email']));

        //查找邮箱
        if (AresValidator::isValidEmail($email)) {
            $arrSqlParams = array(
                'condition' => 'member_email="' . $email . '"',
            );
            $total = MemberModel::model()->count($arrSqlParams);


            if ($total > 0) {
                $status = 'fail';
                $message = '该邮箱已存在';
            } else {
                $status = 'success';
                $message = '该邮箱尚未使用';
            }
        } else {
            $status = 'fail';
            $message = '邮箱格式不正确';
        }
        $result = array(
            'status' => $status,
            'message' => $message,
        );
        return $result;
    }

}
