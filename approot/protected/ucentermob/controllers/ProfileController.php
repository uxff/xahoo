<?php

class ProfileController extends Controller {

        /**
         * @return array action filters
         */
        public function filters() {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete', // we only allow deletion via POST request
                );
        }

        /**
         * 个人资料首页
         */
        public function actionIndex() {
				$return_url = $this->checkReturnUrl();
				$this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();
                $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                $arrMember = $this->convertModelToArray($objMember);

                $basic_number = 0;
                $member_name = $arrMember['member_fullname'];
                $member_sex = $arrMember['member_gender'];
                $member_marriage_status = $arrMember['member_marriage_status'];
                $member_birthday = $arrMember['member_birthday'];
                $member_qq = $arrMember['member_qq'];
                $basic_number +=!empty($member_name) ? 1 : 0;
                $basic_number += $member_sex != 0 ? 1 : 0;
                $basic_number += $member_marriage_status != 0 ? 1 : 0;
                $basic_number += $member_birthday != '0000-00-00' ? 1 : 0;
                $basic_number +=!empty($member_qq) ? 1 : 0;
                $basic_percent = $basic_number / 5 * 100;

                $account_number = 0;
                $is_email_actived = $arrMember['is_email_actived'];
                $is_mobile_actived = $arrMember['is_mobile_actived'];
                $is_idnumber_actived = $arrMember['is_idnumber_actived'];
                $SecurityQuestion_verified = UcMemberToSecurityQuestion::model()->count("member_id=:member_id and status=1", array(":member_id" => $member_id));
                $account_number += $is_email_actived != 0 ? 1 : 0;
                $account_number += $is_mobile_actived != 0 ? 1 : 0;
                $account_number += $is_idnumber_actived != 0 ? 1 : 0;
                $account_number += $SecurityQuestion_verified != 0 ? 1 : 0;
                $account_percent = $account_number / 4 * 100;

                $objAddress = UcMemberAddress::model()->find("member_id=:member_id and is_default=1", array(":member_id" => $member_id));
                if (!empty($objAddress)) {
                        $arrAddress = $this->convertModelToArray($objAddress);
                } else {
                        $arrAddress = array('consignee_name' => '', 'consignee_mobile' => '', 'address' => '');
                }

                $arrRender = array(
                    'gShowHeader' => true,
                    'headerTitle' => '个人资料',
                    'arrMember' => $arrMember,
                    'basic_percent' => $basic_percent,
                    'account_percent' => $account_percent,
                    'arrAddress' => $arrAddress,
                    'return_url' => $return_url,
                );
                $this->smartyRender('profile/index.tpl', $arrRender);
        }
        

        public function actionAvatar() {
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();
                if (!empty($_FILES)) {
                        //加载配置的宽高
                        $width = Yii::app()->params['uploadPic']['appUserPhotoWidth'];
                        $height = Yii::app()->params['uploadPic']['appUserPhotoHeight'];

                        $up_dir = $this->upload_dir();
                        //获取上传的图片的信息
                        $upfile = CUploadedFile::getInstanceByName("photo");
                        //获取文件的扩展名
                        $news_name = $this->getFileName($upfile);

                        if (!is_null($upfile)) {
                                $up_rule = 'gif,jpg,png,bmp,jpeg';
                                $imagetype = strtolower($upfile->extensionName);

                                if (preg_match('/' . $upfile->extensionName . '/', $up_rule)) {
                                        //判断图片大小
                                        $filesize = $upfile->getSize();
                                        if ($filesize > 10240 * 10240) {
                                                $status = 'fail'; //失败
                                                $message = '图片太大，请重新操作';
                                        } elseif ($upfile->saveAs($up_dir['ori'] . $news_name)) {
                                                $filesplit = "";
                                                $path = $up_dir['ori'] . $news_name;
                                                $im = null;

                                                if ($imagetype == 'gif') {
                                                        $im = imagecreatefromgif($path);
                                                } else if ($imagetype == 'jpg') {
                                                        $im = imagecreatefromjpeg($path);
                                                } else if ($imagetype == 'png') {
                                                        $im = imagecreatefrompng($path);
                                                } else if ($imagetype == 'bmp') {
                                                        $im = imagecreatefromwbmp($path);
                                                }

                                                foreach ($up_dir['thumb'] as $key => $value) {
                                                        $thumbpath = $value . $news_name;
                                                        CThumb::resizeImage($im, $width, $height, $thumbpath, ''); //
                                                }
                                                $status = 'success'; //成功
                                                $message = '上传成功';
                                        }
                                } else {
                                        $status = 'fail'; //失败
                                        $message = '图片类型错误,请重新操作';
                                }
                        } else {
                                $status = 'fail'; //失败
                                $message = '参数错误，请重新操作';
                        }

                        if ($status == 'success') {
                                //修改数据
                                $objCustomer = UcMember::model()->findByPk(array('member_id' => $member_id));
                                $objCustomer->member_avatar = $up_dir['url'] . $width . 'x' . $height . '/' . $news_name;

                                if ($objCustomer->update()) {
                                        $errMsg = '头像上传成功';
                                        Yii::app()->loginUser->setFlash('error', $errMsg);
                                        $this->redirect(array('profile/index'));
                                } else {
                                        //
                                        $errMsg = '上传失败';
                                        Yii::app()->loginUser->setFlash('error', $errMsg);
                                        $this->redirect(array('profile/avatar'));
                                }
                        } else {
                                //
                                $errMsg = $message;
                                Yii::app()->loginUser->setFlash('error', $errMsg);
                                $this->redirect(array('profile/avatar'));
                        }
                } else {
                        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                        $member_avatar = OBJTool::changeImageSize($objMember->member_avatar, '126x126', "o");
                        $arrMsgStack = Yii::app()->loginUser->getFlashes();
                        $arrRender = array(
                            'gShowHeader' => true,
                            'headerTitle' => '上传头像',
                            'member_id' => $member_id,
                            'arrMsgStack' => $arrMsgStack,
                            'member_avatar' => $member_avatar,
                            'return_url' => $this->createAbsoluteUrl('Profile/index'),
                        );
                        $this->smartyRender('profile/avatar.tpl', $arrRender);
                }
        }

        public function actionNick() {
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();
                if (isset($_POST['new_name'])) {
                        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                        $new_name = $this->getString($_POST['new_name']);
                        $objMember->member_nickname = $new_name; // 修改昵称
                        if ($objMember->update()) {
                                $errMsg = '修改成功';
								Yii::app()->loginUser->setUserInfo(array('signage' => $objMember->signage,'member_nickname'=>$new_name));
								$this->redirect($this->createAbsoluteUrl('profile/index'));
                        } else {
                                $errMsg = '修改失败';
                        }
                        Yii::app()->loginUser->setFlash('error', $errMsg);
                        $this->redirect($this->createAbsoluteUrl('profile/nick'));
                }
                $arrMsgStack = Yii::app()->loginUser->getFlashes();
                $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                $arrRender = array(
                    'gShowHeader' => true,
                    'headerTitle' => '设置昵称',
                    'nickName' => $objMember->member_nickname,
                    'arrMsgStack' => $arrMsgStack,
                    'return_url' => $this->createAbsoluteUrl('Profile/index'),
                );
                $this->smartyRender("profile/nick.tpl", $arrRender);
        }

        public function actionBasic() {
                $this->checkLogin();
                $member_id = Yii::app()->loginUser->getUserId();

                if (!empty($_POST['member'])) {

                        //$member_fullname = $this->getString($_POST['member']['member_fullname']);
                        $member_gender = $this->getInt($_POST['member']['member_gender']);
                        $member_marriage_status = $this->getInt($_POST['member']['member_marriage_status']);
                        $member_birthday = $this->getString($_POST['member']['member_birthday']);
                        $member_qq = $this->getString($_POST['member']['member_qq']);

                        $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                        //$objMember->member_fullname = $member_fullname;
                        $objMember->member_gender = $member_gender;
                        $objMember->member_marriage_status = $member_marriage_status;
                        $objMember->member_birthday = $member_birthday;
                        $objMember->member_qq = $member_qq;
                        $objMember->update();
                        $this->redirect($this->createAbsoluteUrl('profile/index'));
                }
                $objMember = UcMember::model()->findByPk(array('member_id' => $member_id));
                $arrMember = $this->convertModelToArray($objMember);
                $arrRender = array(
                    'gShowHeader' => true,
                    'headerTitle' => '基础资料',
                    'MemberData' => $arrMember,
                    'return_url' => $this->createAbsoluteUrl('Profile/index'),
                );
                $this->smartyRender("profile/basic.tpl", $arrRender);
        }
        
        //邀请列表
        public function actionInviteList(){
            $this->checkLogin();
            $member_id = Yii::app()->loginUser->getUserId();
            
            //邀请记录列表
    	    $paramsSql = array(
	            'select'=>array('member_mobile,create_time'),   //distinct 唯一性关键字
	            'condition' => 'parent_id='.$member_id.' AND member_mobile != :mobile',
	            'order' => 'create_time desc',
	            'params' => array(':mobile'=>''),
	    );
    	    $Invitelist = UcMember::model()->findall($paramsSql);
            if(count($Invitelist) > 0){
                foreach ($Invitelist as $key=>$value){
                    $Invitelist[$key]->member_mobile = empty($value->member_mobile)?'':substr_replace($value->member_mobile, '****', 3, 4);
                    $Invitelist[$key]->create_time = date('Y-m-d H:i',strtotime($value->create_time));
                }
            }
            
            // 获取当前用户信息
            $member_info = UcMember::model()->findByPk($member_id);
            
            //图片地址和目录
            $return_url = $this->createAbsoluteUrl('user/register');
            $invite_url = $this->createUCenterUrl('user/register', array('signage' => $member_info['signage'], 'return_url'=>$return_url));
            
            /*$PNG_TEMP_DIR_NAME = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR . 'qrcode' . DIRECTORY_SEPARATOR . $member_info['signage'] . DIRECTORY_SEPARATOR .'t' . md5($member_info['signage']) . '.png';
            $img_dir = 'upload/qrcode/'.$member_info['signage'].'/';
            if(!file_exists($PNG_TEMP_DIR_NAME)){
               if(!is_dir($img_dir)){
                   mkdir($img_dir);
               }
               require_once('phpqrcode/QR.php');
               $qr = new QR();
               $qr->config = array('data' => 'http://devhifang.fangfull.com/qjsucenter.php?r=user/login','pngWebDir' => $img_dir,'filename' => $PNG_TEMP_DIR_NAME );
               $qr->generatePng();
            }
            $invite_url = $img_dir . basename($PNG_TEMP_DIR_NAME);*/
            
            $arrRender = array(
                'gShowHeader' => true,
                'headerTitle' => '邀请记录',
                'invitelist' => $Invitelist,
                'encodedInviteUrl' => urlencode($invite_url),
            );
            $this->smartyRender("profile/inviteList.tpl", $arrRender);
        }

}
