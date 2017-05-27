<?php

class NodeController extends Controller {
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

                $model = new SysNode;
                $objModel = $this->loadModel($id);

                $arrRender = array(
                    'objModel' => $objModel,
                    'attributeLabels' => $model->attributeLabels(),
                );
                $this->smartyRender('node/view.tpl', $arrRender);
        }

        /**
         * Creates a new model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         */
        public function actionCreate($pid = 0) {
                $model = new SysNode;
                if (isset($_POST['SysNode'])) {
                        $model->attributes = $_POST['SysNode'];
                        if ($model->save())
                                $this->redirect(array('index', 'pid' => $model->pid));
                }
                $arrAttributeLabels = $model->attributeLabels();
                $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'node-form',
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
                //
                $this->smarty->assign("errormsgs", CHtml::errorSummary($model));
                $parentNode = SysNode::model()->findByPk($pid);
                if ($parentNode) {
                    $parentNode->loadParent();
                }
                //render data
                $arrRender = array(
                    'parentNode' => $parentNode ? $parentNode->toArray() : null,
                    'pid' => $pid,
                    'modelName' => 'SysNode',
                    'attributes' => $model->getAttributes(),
                    'attributeLabels' => $arrAttributeLabels,
                    'FormElements' => $model->FormElements,
                    'action' => 'Create',
                    'errormsgs' => CHtml::errorSummary($model, '<i class="ace-icon fa fa-times"></i>错误'), //
                    'jsShell' => $js,
                    'dataObj' => $model,
                );

                $this->smartyRender('node/create.tpl', $arrRender);
        }

        /**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id the ID of the model to be updated
         */
        public function actionUpdate($id) {
                $updateModel = $this->loadModel($id);
                if (isset($_POST['SysNode'])) {
                        $updateModel->attributes = $_POST['SysNode'];
                        if ($updateModel->save()) {
                                $this->redirect(array('index', 'pid' => $updateModel->pid));
                        }
                }
                $model = new SysNode;
                $arrAttributeLabels = $model->attributeLabels();
                $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'node-form',
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
                    'modelName' => 'SysNode',
                    'attributes' => $model->getAttributes(),
                    'attributeLabels' => $arrAttributeLabels,
                    'FormElements' => $model->FormElements,
                    'action' => 'Update',
                    'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>错误'), //
                    'jsShell' => $js,
                    'model' => $updateModel,
                    'dataObj' => $updateModel,
                );

                $this->smartyRender('node/update.tpl', $arrRender);
        }

        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id) {
                //TODO
                $model = SysNode::model()->find($id);
                $model = $this->convertModelToArray($model);
                $list = array();

                //查询子级数据
                $del = SysNode::model()->findAllByAttributes(array('pid' => $id));

                //判断子级是是否存在
                if (!empty($del)) {
                        $del = $this->convertModelToArray($del);
                        foreach ($del as $val) {
                                $list[] = $val['id'];
                        }
                }

                if (!empty($list)) {
                        $result = SysNode::model()->findAllByAttributes(array('pid' => $list));
                        $result = $this->convertModelToArray($result);
                        foreach ($result as $key => $v) {
                                $list[] = $v['id'];
                        }
                }

                $list[] = $id;
                $delNodel = SysNode::model()->deleteByPk($list);
                if ($delNode > 0) {
                        //删除权限信息
                        $delAccess = SysAccess::model()->deleteAllByAttributes(array('node_id' => $list));
                }

                //$this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                }
        }

        /**
         * Lists all models.
         */
        public function actionIndex($pid = 0) {
                $searchForm = 0;
                $model = new SysNode();
                //$model->getNodeTree();
                //var_dump(SysNode::model());
                //print_r(SysNode::model()->getNodeTree());
                $model->unsetAttributes();  // clear any default values
                if (isset($_GET['SysNode'])) {
                        $searchForm = 1;
                        $model->attributes = $_GET['SysNode'];
                }
                $mySearch = $model->mySearch($pid);
                $arrData = $this->convertModelToArray($mySearch['list']);

                //显示父级名称
                $nodeName = array();
                if ($pid == 0) {
                        $nodeName[$pid] = '/';
                } else {
                        $nodeMsg = SysNode::model()->findByPk(array('id' => $pid));
                        $nodeMsg = $this->convertModelToArray($nodeMsg);
                        $nodeName[$pid] = $nodeMsg['remark'];
                }

                $pages = $mySearch['pages'];

                $arrAttributeLabel = $model->attributeLabels();
                unset($arrAttributeLabel['create_time']);
                unset($arrAttributeLabel['sort']);
                unset($arrAttributeLabel['icon']);
                //unset($arrAttributeLabel['last_modified']);

                $level = array('1' => '分组', '2' => 'controller', '3' => 'action');
                $display = array('1' => '显示','0'=>'不显示');
                $arrRender = array(
                	'display' => $display,
                    'nodeName' => $nodeName,
                    'level' => $level,
                    'pid' => $pid,
                    'modelId' => 'id',
                    'modelName' => 'SysNode',
                    'arrAttributeLabels' => $arrAttributeLabel,
                    'arrData' => $arrData,
                    'pages' => $pages,
                    'dataObj' => $model,
                    'searchForm' => $searchForm,
                    'route' => $this->getId() . '/' . $this->getAction()->getId(),
                );

                //smarty render
                $this->smartyRender('node/index.tpl', $arrRender);
        }

        /**
         * Manages all models.
         */
        public function actionAdmin() {
                $dataProvider = new CActiveDataProvider('SysNode');

                $data = $dataProvider->getData();

                //var_dump($data);
                //render data
                $arrRender = array(
                    'data' => $data,
                    'dataCount' => count($data),
                    'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
                );

                $this->smartyRender('node/admin.tpl', $arrRender);
        }

        /**
         * Returns the data model based on the primary key given in the GET variable.
         * If the data model is not found, an HTTP exception will be raised.
         * @param integer $id the ID of the model to be loaded
         * @return SysNode the loaded model
         * @throws CHttpException
         */
        public function loadModel($id) {
                $model = SysNode::model()->findByPk($id);
                if ($model === null) {
                        throw new CHttpException(404, 'The requested page does not exist.');
                }
                return $model;
        }

        /**
         * Performs the AJAX validation.
         * @param SysNode $model the model to be validated
         */
        protected function performAjaxValidation($model) {
                if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
                        echo CActiveForm::validate($model);
                        Yii::app()->end();
                }
        }

}
