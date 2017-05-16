<?php

class AdminUserController extends Controller {

        /**
         * @return array action filters
         */
//        public function filters() {
//                return array(
//                    'accessControl', // perform access control for CRUD operations
//                        //'postOnly + delete', // we only allow deletion via POST request
//                );
//        }

        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
//        public function accessRules() {
//                return array(
//                    array('allow', // allow all users to perform 'index' and 'view' actions
//                        'actions' => array('index', 'view'),
//                        'users' => array('*'),
//                    ),
//                    array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                        'actions' => array('create', 'update'),
//                        'users' => array('@'),
//                    ),
//                    array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                        'actions' => array('admin', 'delete'),
//                        'users' => array('admin'),
//                    ),
//                    array('deny', // deny all users
//                        'users' => array('*'),
//                    ),
//                );
//        }

        /**
         * Displays a particular model.
         * @param integer $id the ID of the model to be displayed
         */
        public function actionView($id) {

                $model = new SysAdminUser;
                $objModel = $this->loadModel($id);

                $queryResult = SysAdminUser::model()->with('role')->findByPk($id);
                $roleResult = $this->convertModelToArray($queryResult['role']);
				$attributeLabels = $model->attributeLabels();
				unset($attributeLabels['password']);
                $arrRender = array(
                    'objModel' => $objModel,
                    'attributeLabels' => $attributeLabels,
                    'role' => $roleResult,
                );
                $this->smartyRender('adminuser/view.tpl', $arrRender);
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate() {
                $model = new SysAdminUser;
                if (isset($_POST['SysAdminUser'])) {
                        $model->attributes = $_POST['SysAdminUser'];
                        if ($model->save()) {
                                $RoleUserModel = new SysRoleUser;
                                $RoleUserModel->attributes = array('role_id' => $_POST['SysRoleUser']['role_id'], 'user_id' => $model->id);
                                $RoleUserModel->save();
                                $this->redirect(array('view', 'id' => $model->id));
                        }
                }
                $arrAttributeLabels = $model->attributeLabels();
                $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'adminUser-form',
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
                //报错信息处理
                $this->smarty->assign("errormsgs", CHtml::errorSummary($model));

                //查所有角色
                $queryResult = SysRole::model()->published()->findAll();
                $arrQueryResult = $this->convertModelToArray($queryResult);

                //render data
                $arrRender = array(
                    'modelName' => 'SysAdminUser',
                    'attributes' => $model->getAttributes(),
                    'attributeLabels' => $arrAttributeLabels,
                    'FormElements' => $model->FormElements,
                    'action' => 'Create',
                    'errormsgs' => CHtml::errorSummary($model, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
                    'jsShell' => $js,
                    'dataObj' => $model,
                    'role' => $arrQueryResult, //角色列表
                );

                $this->smartyRender('adminuser/create.tpl', $arrRender);
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionUpdate($id) {
//var_dump($_POST);die;
                $queryResult1 = SysAdminUser::model()->with('role')->findByPk($id);
                $arrQueryResult1 = $this->convertModelToArray($queryResult1);
                //print_r($arrQueryResult1);exit;

                $updateModel = $this->loadModel($id);
                if (isset($_POST['SysAdminUser'])) {
                		if(empty($_POST['SysAdminUser']['password'])){
                			unset($_POST['SysAdminUser']['password']);
                		}else{
                            $_POST['SysAdminUser']['password'] = md5( $_POST['SysAdminUser']['password']);
                        }                  		
                        $updateModel->attributes = $_POST['SysAdminUser']; 
                        if ($updateModel->save()) {
                                $roleuserResult = SysRoleUser::model()->findAll("user_id=:user_id", array(":user_id" => $updateModel->id));
                                //print_r($roleuserResult);exit;
                                if (!empty($roleuserResult)) {
                                        SysRoleUser::model()->updateAll(array('role_id' => $_POST['SysRoleUser']['role_id']), 'user_id=:user_id', array(':user_id' => $updateModel->id));
                                } else {
                                        $RoleUserModel = new SysRoleUser;
                                        $RoleUserModel->attributes = array('role_id' => $_POST['SysRoleUser']['role_id'], 'user_id' => $updateModel->id);
                                        $RoleUserModel->save();
                                }
                                $this->redirect(array('view', 'id' => $updateModel->id));
                        }
                }
                $model = new SysAdminUser;
                $arrAttributeLabels = $model->attributeLabels();
                $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'adminUser-form',
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

                //查所有角色
                $queryResult = SysRole::model()->published()->findAll();
                $arrQueryResult = $this->convertModelToArray($queryResult);
                
                //render data
                $arrRender = array(
                    'primaryKey' => 'id',
                    'modelName' => 'SysAdminUser',
                    'attributes' => $model->getAttributes(),
                    'attributeLabels' => $arrAttributeLabels,
                    'FormElements' => $model->FormElements,
                    'action' => 'Update',
                    'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
                    'jsShell' => $js,
                    'model' => $updateModel,
                    'dataObj' => $arrQueryResult1,
                    'role' => $arrQueryResult, //角色列表
                );
                $this->smartyRender('adminuser/update.tpl', $arrRender);
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id) {
                //TODO
                $AdminUsermodel = SysAdminUser::model()->findByPk($id);
                $AdminUsermodel->status = 99;
                $AdminUsermodel->save();
                //$this->loadModel($id)->delete();

                SysRoleUser::model()->deleteAll("user_id=:user_id", array(":user_id" => $id,));
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
        }

        /**
         * Lists all models.
         */
        public function actionIndex($keyword = '', $pageNo = 1, $pageSize = 10) {
                $searchForm = 0;
                $model = new SysAdminUser();
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['SysAdminUser'])) {
                        $searchForm = 1;
                        $model->attributes = $_GET['SysAdminUser'];
                }
                $mySearch = $model->mySearch();
                $arrData = $mySearch['list'];
                $arrData = $this->convertModelToArray($mySearch['list']);
                //print_r($arrData);exit;
                $pages = $mySearch['pages'];

                $arrAttributeLabel = $model->attributeLabels();
                unset($arrAttributeLabel['create_time']);
                unset($arrAttributeLabel['last_modified']);
                unset($arrAttributeLabel['password']);
                $arrRender = array(
                    'modelId' => 'id',
                    'modelName' => 'SysAdminUser',
                    'arrAttributeLabels' => $arrAttributeLabel,
                    'arrData' => $arrData,
                    'pages' => $pages,
                    'dataObj' => $model,
                    'searchForm' => $searchForm,
                    'route' => $this->getId() . '/' . $this->getAction()->getId(),
                );

                //smarty render
                $this->smartyRender('adminuser/index.tpl', $arrRender);
        }

        /**
         * Manages all models.
         */
        public function actionAdmin() {
                $dataProvider = new CActiveDataProvider('SysAdminUser');

                $data = $dataProvider->getData();

                //var_dump($data);
                //render data
                $arrRender = array(
                    'data' => $data,
                    'dataCount' => count($data),
                    'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
                );

                $this->smartyRender('adminuser/admin.tpl', $arrRender);
        }

        /**
         * Returns the data model based on the primary key given in the GET variable.
         * If the data model is not found, an HTTP exception will be raised.
         * @param integer $id the ID of the model to be loaded
         * @return SysAdminUser the loaded model
         * @throws CHttpException
         */
        public function loadModel($id) {
                $model = SysAdminUser::model()->findByPk($id);
                if ($model === null)
                        throw new CHttpException(404, 'The requested page does not exist.');
                return $model;
        }

        /**
         * Performs the AJAX validation.
         * @param SysAdminUser $model the model to be validated
         */
        protected function performAjaxValidation($model) {
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
        }
        public function actionUpdatePassword() {
            $id = $_SESSION['memberadmin__adminUser']['id'];
            $queryResult1 = SysAdminUser::model()->findByPk($id);
            $arrQueryResult1 = $this->convertModelToArray($queryResult1);
            $updateModel = $this->loadModel($id);

            $c = 0;
            if (isset($_POST['SysAdminUser'])) {
                if(empty($_POST['SysAdminUser']['password'])){
                    unset($_POST['SysAdminUser']['password']);
                }else{
                    $_POST['SysAdminUser']['password'] = md5( $_POST['SysAdminUser']['password']);
                }
                $updateModel->attributes = $_POST['SysAdminUser'];
                if ($updateModel->save()) {
                   $c = 1;
                }
            }

            //render data
            $arrRender = array(
                'primaryKey' => 'id',
                'modelName' => 'SysAdminUser',
                'action' => 'Update',
                'cResult'=> $c,
                'model' => $updateModel,
                'dataObj' => $arrQueryResult1,
            );
            $this->smartyRender('adminuser/updatepassword.tpl', $arrRender);
        }

}
