<?php

class RoleController extends Controller {

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
//                        //array('allow', // allow all users to perform 'index' and 'view' actions
//                        //    'actions' => array('index', 'view'),
//                        //    'users' => array('*'),
//                        //),
//                        //array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                        //    'actions' => array('create', 'update'),
//                        //    'users' => array('@'),
//                        //),
//                        //array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                        //    'actions' => array('admin', 'delete'),
//                        //    'users' => array('admin'),
//                        //),
//                        //array('deny', // deny all users
//                        //    'users' => array('*'),
//                        //),
//                );
//        }

        /**
         * Displays a particular model.
         * @param integer $id the ID of the model to be displayed
         */
        public function actionView($id) {

                $model = new SysRole;
                $objModel = $this->loadModel($id);

                $arrRender = array(
                    'objModel' => $objModel,
                    'attributeLabels' => $model->attributeLabels(),
                );
                $this->smartyRender('role/view.tpl', $arrRender);
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate() {
                $model = new SysRole;
                if (isset($_POST['SysRole'])) {
                        $model->attributes = $_POST['SysRole'];
                        if ($model->save())
                                $this->redirect(array('view', 'id' => $model->id));
                }
                $arrAttributeLabels = $model->attributeLabels();
                $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'role-form',
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
                //render data
                $arrRender = array(
                    'modelName' => 'SysRole',
                    'attributes' => $model->getAttributes(),
                    'attributeLabels' => $arrAttributeLabels,
                    'FormElements' => $model->FormElements,
                    'action' => 'Create',
                    'errormsgs' => CHtml::errorSummary($model, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
                    'jsShell' => $js,
                    'dataObj' => $model,
                );

                $this->smartyRender('role/create.tpl', $arrRender);
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionUpdate($id) {
                $updateModel = $this->loadModel($id);
                if (isset($_POST['SysRole'])) {
                        $updateModel->attributes = $_POST['SysRole'];
                        if ($updateModel->save()) {
                                $this->redirect(array('view', 'id' => $updateModel->id));
                        }
                }
                $model = new SysRole;
                $arrAttributeLabels = $model->attributeLabels();
                $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'role-form',
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
                    'primaryKey' => 'id',
                    'modelName' => 'SysRole',
                    'attributes' => $model->getAttributes(),
                    'attributeLabels' => $arrAttributeLabels,
                    'FormElements' => $model->FormElements,
                    'action' => 'Update',
                    'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
                    'jsShell' => $js,
                    'model' => $updateModel,
                    'dataObj' => $updateModel,
                );

                $this->smartyRender('role/update.tpl', $arrRender);
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
        public function actionIndex($keyword = '', $pageNo = 1, $pageSize = 10) {
                $searchForm = 0;
                $model = new SysRole();
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['SysRole'])) {
                        $searchForm = 1;
                        $model->attributes = $_GET['SysRole'];
                }
                $mySearch = $model->mySearch();
                $arrData = $mySearch['list'];
                $pages = $mySearch['pages'];

                $arrAttributeLabel = $model->attributeLabels();
                unset($arrAttributeLabel['create_time']);
                //unset($arrAttributeLabel['last_modified']);
                $arrRender = array(
                    'modelId' => 'id',
                    'modelName' => 'SysRole',
                    'arrAttributeLabels' => $arrAttributeLabel,
                    'arrData' => $arrData,
                    'pages' => $pages,
                    'dataObj' => $model,
                    'searchForm' => $searchForm,
                    'route' => $this->getId() . '/' . $this->getAction()->getId(),
                );

                //smarty render
                $this->smartyRender('role/index.tpl', $arrRender);
        }

        /**
         * Manages all models.
         */
        public function actionAdmin() {
                $dataProvider = new CActiveDataProvider('SysRole');

                $data = $dataProvider->getData();

                //var_dump($data);
                //render data
                $arrRender = array(
                    'data' => $data,
                    'dataCount' => count($data),
                    'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
                );

                $this->smartyRender('role/admin.tpl', $arrRender);
        }

        /**
         * Returns the data model based on the primary key given in the GET variable.
         * If the data model is not found, an HTTP exception will be raised.
         * @param integer $id the ID of the model to be loaded
         * @return SysRole the loaded model
         * @throws CHttpException
         */
        public function loadModel($id) {
                $model = SysRole::model()->findByPk($id);
                if ($model === null)
                        throw new CHttpException(404, 'The requested page does not exist.');
                return $model;
        }

        /**
         * Performs the AJAX validation.
         * @param SysRole $model the model to be validated
         */
        protected function performAjaxValidation($model) {
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
        }

}
