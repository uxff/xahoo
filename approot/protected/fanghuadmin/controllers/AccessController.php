<?php

class AccessController extends Controller
{

    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            //'postOnly + delete', // we only allow deletion via POST request
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules() {
//        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update'),
//                'users' => array('@'),
//            ),
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('admin', 'delete'),
//                'users' => array('admin'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = new SysAccess;
        $objModel = $this->loadModel($id);

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
        );
        $this->smartyRender('access/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SysAccess;
        if (isset($_POST['SysAccess'])) {
            $model->attributes = $_POST['SysAccess'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'access-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => false,
                        'validateOnChange' => true,
                    ),
                ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js,1);
        //报错信息处理
        $this->smarty->assign("errormsgs", CHtml::errorSummary($model));
        //render data
        $arrRender = array(
            'modelName' => 'SysAccess',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
        );

        $this->smartyRender('access/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($roleid) {
    	
    	$role_id = $this->getInt($roleid);
    	$node_ids = $_POST['node_ids'];
    	
    	//$all = SysAccess::model()->findAllByAttributes(array('role_id'=>$role_id));
    	$delete = SysAccess::model()->deleteAll('role_id=:role_id',array(':role_id'=>$role_id));
    	
    	foreach($node_ids as $val){
    		$model = new SysAccess();	
    		$model->node_id = $val;
    		$model->role_id = $role_id;
    		$model->save();
    	}
    	$this->redirect(array('index', 'roleid' => $roleid));
        /*$updateModel = $this->loadModel($id);
        if (isset($_POST['SysAccess'])) {
                $updateModel->attributes = $_POST['SysAccess'];
                if ($updateModel->save()) {
                        $this->redirect(array('view', 'id' => $updateModel->id));
                }
        }
        $model = new SysAccess;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'access-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => false,
                'validateOnChange' => true,
            ),
        ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js, 1);
        //render data
        $arrRender = array(
            'primaryKey'=>'id',
            'modelName' => 'SysAccess',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
        );

        $this->smartyRender('access/update.tpl', $arrRender);
        */
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //TODO
        $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $role_id = intval($_GET['roleid']);

        //$model = new SysAccess;
        //$access = $model->getNodesByRoleId($role_id);
        $allNodes = SysNode::model()->getNodeTree();
        
        //$access = SysAccess::model()->getNodesByRoleId($role_id);
        $access = SysAccess::model()->findAllByAttributes (array('role_id'=>$role_id));
        $access = $this->convertModelToArray($access);
		if(isset($access)){
			foreach($access as $val){
				$allNode[]=$val['node_id'];
			}
		}
        $arrRender = array(
        	'allNode' => $allNode,
            'role_id' => $role_id,
            'modelName' => 'SysAccess',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
        	'allNodes' => $allNodes,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
        );

        //smarty render
        $this->smartyRender('access/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('SysAccess');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('access/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SysAccess the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SysAccess::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SysAccess $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
