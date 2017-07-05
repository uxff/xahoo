<?php

class PicsetController extends Controller
{

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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = new PicSetModel;
        //$objModel = $this->loadModel($id);
        $objModel = PicSetModel::model()->with('pics')->findByPk($id);

        $arrType = PicSetModel::$ARR_TYPE;

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
            'arrType' => $arrType,
            'arrUsedType' => PicSetModel::$ARR_USED_TYPE,
        );
        $this->smartyRender('picset/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PicSetModel;
        if (isset($_POST['PicSetModel'])) {
            $model->attributes = $_POST['PicSetModel'];
            $model->admin_id = Yii::app()->memberadmin->id;
            $model->admin_name = Yii::app()->memberadmin->name;

            $used_type = $_POST['PicSetModel']['used_type'];
            if ($testModel = PicSetModel::model()->find('used_type=:used_type', array(':used_type'=>$used_type))) {
                $errorMsg = PicSetModel::$ARR_USED_TYPE[$used_type].'已存在，请重新选择图片用途。';
            }

            if (empty($errorMsg) && $model->save()) {
                // 保存对应的图片成员
                $arrStorageId   = $_POST['pic_storage_id'];
                $arrLinkUrl     = $_POST['link_url'];
                $arrWeight      = $_POST['weight'];
                //Yii::log(__METHOD__ .': ')
                //print_r($arrStorageId);exit;
                if ($model->type == 1) {
                    asort($arrWeight);
                    
                }

                // 单张图片 只存一张
                if ($model->type==1) {
                    $i = 0;
                    foreach ($arrWeight as $pic_storage_id=>$v) {
                        ++$i;
                        $picStorageModel = PicStorageModel::model()->findByPk($pic_storage_id);
                        if ($picStorageModel) {
                            if ($i==1) {
                                $picStorageModel->pic_set_id = $model->id;
                                $picStorageModel->link_url = $arrLinkUrl[$pic_storage_id];
                                $picStorageModel->weight = $arrWeight[$pic_storage_id];
                                if (!$picStorageModel->save()) {
                                    Yii::log(__METHOD__ .': '.$picStorageModel->getError(), 'error', __FILE__ .':'.__LINE__);
                                }
                            } else {
                                $picStorageModel->delete();
                            }
                        } else {
                            Yii::log(__METHOD__ .': pic_storage_id('.$pic_storage_id.') not exist!', 'error', __FILE__ .':'.__LINE__);
                        }
                    }
                } else {
                    foreach ($arrWeight as $pic_storage_id=>$v) {
                        $picStorageModel = PicStorageModel::model()->findByPk($pic_storage_id);
                        if ($picStorageModel) {
                            $picStorageModel->pic_set_id = $model->id;
                            $picStorageModel->link_url = $arrLinkUrl[$pic_storage_id];
                            $picStorageModel->weight = $arrWeight[$pic_storage_id];
                            if (!$picStorageModel->save()) {
                                Yii::log(__METHOD__ .': '.$picStorageModel->getError(), 'error', __FILE__ .':'.__LINE__);
                            }
                        } else {
                            Yii::log(__METHOD__ .': pic_storage_id('.$pic_storage_id.') not exist!', 'error', __FILE__ .':'.__LINE__);
                        }
                    }
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'picSet-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => false,
                        'validateOnChange' => true,
                    ),
                ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $arrType = PicSetModel::$ARR_TYPE;

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js,1);
        //报错信息处理
        $this->smarty->assign("errormsgs", CHtml::errorSummary($model));
        $errorMsg = $errorMsg ? $errorMsg : CHtml::errorSummary($model, '<i class="ace-icon fa fa-times"></i>请更正以下错误');
        //render data
        $arrRender = array(
            'modelName' => 'PicSetModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => $errorMsg, //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
            'arrType' => $arrType,
            'arrUsedType' => PicSetModel::$ARR_USED_TYPE,
        );

        $this->smartyRender('picset/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //$updateModel = $this->loadModel($id);
        $updateModel = PicSetModel::model()->with('pics')->findByPk($id);
        if (!$updateModel) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        if (isset($_POST['PicSetModel'])) {
            $updateModel->attributes = $_POST['PicSetModel'];
            if ($updateModel->save()) {
                $model = $updateModel;
                // 保存对应的图片成员
                $arrStorageId   = $_POST['pic_storage_id'];
                $arrLinkUrl     = $_POST['link_url'];
                $arrWeight      = $_POST['weight'];
                    
                if ($model->type == 1) {
                    asort($arrWeight);
                    
                }

                // 单张图片 只存一张
                if ($model->type==1) {
                    $i = 0;
                    foreach ($arrWeight as $pic_storage_id=>$v) {
                        ++$i;
                        $picStorageModel = PicStorageModel::model()->findByPk($pic_storage_id);
                        if ($picStorageModel) {
                            if ($i==1) {
                                $picStorageModel->pic_set_id = $model->id;
                                $picStorageModel->link_url = $arrLinkUrl[$pic_storage_id];
                                $picStorageModel->weight = $arrWeight[$pic_storage_id];
                                if (!$picStorageModel->save()) {
                                    Yii::log(__METHOD__ .': '.$picStorageModel->getError(), 'error', __FILE__ .':'.__LINE__);
                                }
                            } else {
                                $picStorageModel->delete();
                            }
                        } else {
                            Yii::log(__METHOD__ .': pic_storage_id('.$pic_storage_id.') not exist!', 'error', __FILE__ .':'.__LINE__);
                        }
                    }
                } else {
                    foreach ($arrWeight as $pic_storage_id=>$v) {
                        $picStorageModel = PicStorageModel::model()->findByPk($pic_storage_id);
                        if ($picStorageModel) {
                            $picStorageModel->pic_set_id = $model->id;
                            $picStorageModel->link_url = $arrLinkUrl[$pic_storage_id];
                            $picStorageModel->weight = $arrWeight[$pic_storage_id];
                            if (!$picStorageModel->save()) {
                                Yii::log(__METHOD__ .': '.$picStorageModel->getError(), 'error', __FILE__ .':'.__LINE__);
                            }
                        } else {
                            Yii::log(__METHOD__ .': pic_storage_id('.$pic_storage_id.') not exist!', 'error', __FILE__ .':'.__LINE__);
                        }
                    }
                }
                $this->redirect(array('view', 'id' => $updateModel->id));
            }
        }
        $model = new PicSetModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'picSet-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => false,
                'validateOnChange' => true,
            ),
        ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $arrType = PicSetModel::$ARR_TYPE;

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js, 1);
        $errorMsg = $errorMsg ? $errorMsg : CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误');
        //render data
        $arrRender = array(
            'primaryKey'=>'id',
            'modelName' => 'PicSetModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => $errorMsg, //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
            'arrType' => $arrType,
            'arrUsedType' => PicSetModel::$ARR_USED_TYPE,
        );

        $this->smartyRender('picset/update.tpl', $arrRender);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //TODO
        //$this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {

        $condition = $_GET['condition'];

        $searchForm = 0;
        $model = new PicSetModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PicSetModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['PicSetModel'];
        }
        $mySearch = $model->mySearch($condition);

        //$mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();

        $arrType = PicSetModel::$ARR_TYPE;

        unset($arrAttributeLabel['circle_sec']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'id',
            'modelName' => 'PicSetModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'arrType' => $arrType,
            'arrUsedType' => PicSetModel::$ARR_USED_TYPE,
            'condition' => $condition,
        );

        //smarty render
        $this->smartyRender('picset/index.tpl', $arrRender);
    }




    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('PicSetModel');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('picset/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PicSetModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PicSetModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PicSetModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
