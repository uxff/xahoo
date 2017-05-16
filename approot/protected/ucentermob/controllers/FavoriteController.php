<?php

class FavoriteController extends Controller {

        public function actionIndex() {
				//$return_url = $this->checkReturnUrl();
				$return_url  = $this->createXqsjUrl('customer/index');;
				$this->checkLogin();

				$member_id = Yii::app()->loginUser->getUserId();
				$fanghu_total = UcMemberFavorite::model()->count("member_id={$member_id} and task_source='fanghu' and status=1");
				$zhongchou_total = UcMemberFavorite::model()->count("member_id={$member_id} and task_source='zhongchou' and status=1");
				$fenquan_total = UcMemberFavorite::model()->count("member_id={$member_id} and task_source='fenquan' and status=1");

                $arrRender = array(
                    'gShowHeader' => true,
                    'return_url' => $return_url,
					'userUrl' => $return_url,
                    'headerTitle' => '我的收藏',
					'fanghu_total' => $fanghu_total,
					'zhongchou_total' => $zhongchou_total,
					'fenquan_total' => $fenquan_total,
					'fanghuUrl' => $this->createFanghuUrl('member/MyFavorite',array('return_url' => $return_url)),
					'zhongchouUrl' => $this->createXqsjZCServerUrl('customer/myFavorite',array('return_url' => $return_url)),
					'fenquanUrl' => $this->createXqsjFQServerUrl('customer/myFavorite',array('return_url' => $return_url)),
                );
				$this->smartyRender('favorite/index.tpl', $arrRender);
        }

}
