<?php

class ShopController extends Controller {

        public function actionIndex() {
                $this->checkLogin();
                $return_url = $this->outPutString($_GET['return_url']);
                if(empty($return_url)) {
                    $return_url = $this->createAbsoluteUrl('user/index');
                }
				
				$member_id = Yii::app()->loginUser->getUserId();

                $arrRender = array(
                    'gShowHeader' => true,
                    'return_url' => $return_url,
                    'headerTitle' => '积分商城',
                );
				$this->smartyRender('shop/index.tpl', $arrRender);
        }

}
