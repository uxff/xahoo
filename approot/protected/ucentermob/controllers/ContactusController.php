<?php

class ContactusController extends Controller {

        public function actionIndex() {
                $this->checkLogin();
                $return_url = $this->outPutString($_GET['return_url']);
                if (empty($return_url)) {
                        $return_url = $this->createAbsoluteUrl('user/index');
                }

                $member_id = Yii::app()->loginUser->getUserId();
                
                $xqsjIndexUrl = $this->createOtherAppUrl('XqsjServerName');
                $arrRender = array(
                    'xqsjIndexUrl' =>$xqsjIndexUrl,
                    'gShowHeader' => true,
                    'return_url' => $return_url,
                    'headerTitle' => '联系我们',
                );
                $this->smartyRender('contactus/index.tpl', $arrRender);
        }

}
