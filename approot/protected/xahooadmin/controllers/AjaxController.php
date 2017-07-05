<?php
/**
 * AjaxController class file
 * @author zhaosen
 */

class AjaxController extends Controller {

    /**
     * @return array action filters
     */
    /**
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }
    */
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    /**
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete','test','ListCountry','ListState','ListCity'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    **/
    public function actionTest() {

        echo '1111';
    }

    /**
     * 获取所有国家列表
     *
     * @access public
     * @return void
     */
    public function actionListCountry() {
        //preprocess parameters

        // get Country List by model
        $queryResult = ZybCountry::model()->published()->findAll();
        
        
        //format
        $formatedData = array();
        if (!empty($queryResult)) {
            foreach ($queryResult as $key => $objCountry) {
                $formatedData[$key] = $objCountry->attributes;
            }
        }

        // send result
		echo json_encode($formatedData);
        //$this->sendResult($formatedData, 'countries');
    }


    /**
     * 获取所有地区列表
     *
     * @access public
     * @return void
     */
    public function actionListState() {
        //preprocess parameters
        $country_id = $this->getInt($_REQUEST['country_id']);
        
        // get State List by model and id
        $queryResult = ZybState::model()->published()->findAll('country_id=:country_id', array(':country_id'=>$country_id));
        
        //format
        $formatedData = array();
        if (!empty($queryResult)) {
            foreach ($queryResult as $key => $objState) {
                $formatedData[$key] = $objState->attributes;
            }
        }
		
        // send result
		echo json_encode($formatedData);
        //$this->sendResult($formatedData, 'states');
    }

    /**
     * 获取所有城市列表
     *
     * @access public
     * @return void
     */
    public function actionListCity() {
        //preprocess parameters
        $country_id = $this->getInt($_REQUEST['country_id']);
        $state_id = $this->getInt($_REQUEST['state_id']);
        
        // get city List by model and id
        $queryResult = ZybCity::model()->published()->findAll('country_id=:country_id AND state_id=:state_id', array(':country_id'=>$country_id, ':state_id'=>$state_id));
        
        //format
        $formatedData = array();
        if (!empty($queryResult)) {
            foreach ($queryResult as $key => $objCity) {
                $formatedData[$key] = $objCity->attributes;
            }
        }

        // send result
		echo json_encode($formatedData);
        //$this->sendResult($formatedData, 'cities');
    }
    
 		/**
         * Ajax获取相册列表
         * picture_id 图片id
         * picture_type 图片类型
         * house_id 房源id
         */
        public function  actionajaxThumb(){
        	
        	$id = $this->getInt($_POST['id']);
        	$picture_type = $this->getInt($_POST['picture_type']);
        	
        	//获取房源图片信息
        	$picMsg = ZybHousePicture::model()->findAllByAttributes(array('house_id' => $id,'picture_type'=>$picture_type));
        	$picMsg = $this->convertModelToArray($picMsg);
        	echo json_encode($picMsg);
        }
        
        /*
         * Ajax删除相册列表
         * picture_id 图片id
         * picture_type 图片类型
         * house_id 房源id
         */
        
        public function actionajaxDelThumb(){
        	
        	$picture_id = $this->getInt($_POST['picture_id']);
        	//删除图片
        	$delPic = ZybHousePicture::model()->deleteByPk(array('picture_id'=>$picture_id));
        	if($delPic>0){
        		echo '1';
        	}else{
        		echo '0';
        	}
        }

}