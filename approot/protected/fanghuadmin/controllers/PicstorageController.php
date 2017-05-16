<?php

class PicstorageController extends Controller
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

        $model = new PicStorageModel;
        $objModel = $this->loadModel($id);

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
        );
        $this->smartyRender('picstorage/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PicStorageModel;
        if (isset($_POST['PicStorageModel'])) {
            $model->attributes = $_POST['PicStorageModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'picstorage-form',
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
            'modelName' => 'PicStorageModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
        );

        $this->smartyRender('picstorage/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
        if (isset($_POST['PicStorageModel'])) {
                $updateModel->attributes = $_POST['PicStorageModel'];
                if ($updateModel->save()) {
                        $this->redirect(array('view', 'id' => $updateModel->id));
                }
        }
        $model = new PicStorageModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'picstorage-form',
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
            'modelName' => 'PicStorageModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
        );

        $this->smartyRender('picstorage/update.tpl', $arrRender);
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
        $searchForm = 0;
        $model = new PicStorageModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PicStorageModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['PicStorageModel'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'id',
            'modelName' => 'PicStorageModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
        );

        //smarty render
        $this->smartyRender('picstorage/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('PicStorageModel');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('picstorage/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PicStorageModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PicStorageModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PicStorageModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUploadpic() {
        $pic_storage_id		= (int)$_GET['pic_storage_id'];
        $pic_set_id			= (int)$_GET['pic_set_id'];
        $used_type			= (int)$_GET['used_type'];
		
        if (!$used_type) {
            $used_type = PicStorageModel::USED_TYPE_BANNER;
        }

        // 按照used_type归类
        $arrSavePath = array(
            '1' => 'banner',
            '2' => 'surface',
            '3' => 'surface',
            '4' => 'cms',
        );

        $savepath = isset($arrSavePath[$used_type]) ? $arrSavePath[$used_type] : 'cms';
        $fileInfo = MyUploadFile::UploadFiles(array('savepath'=>$savepath, 'inputname'=>'upfile'));
		
        $arr = array(
            'state' => 'FAILED',
            'msg' => '',
            'url' => '',
            'pic_storage_id' => '0',
            'type' => '',
            'size' => 0,
            //'fileInfo' => $fileInfo,
        );
		
        if ($fileInfo && $fileInfo['state']=='SUCCESS') {
            // 如果提供pic_storage_id则保存替换
            if (!$pic_storage_id) {
                $model = new PicStorageModel;
            } else {
                $model = PicStorageModel::model()->findByPk($pic_storage_id);
                if (!$model) {
                    $model = new PicStorageModel;
                } else {
                    // 如果存在旧图片，则删除
                    $oldFilePath = Yii::app()->params['uploadPic']['basePath'].'/../'.$model->file_path;
                }
            }
            $model->pic_set_id = $pic_set_id;
            $model->used_type = $used_type;
            $model->file_path = $fileInfo['urlpath'];
            $model->file_ext = $fileInfo['file_ext'];
            $model->link_url = '';
            if ($model->save()) {
                $arr['state'] = 'SUCCESS';
                $arr['url'] = $fileInfo['urlpath'];
                //$arr['fileInfo'] = $fileInfo;
                $arr['pic_storage_id'] = $model->id;
                $arr['type'] = $fileInfo['file_ext'];
                $arr['size'] = $fileInfo['size'];

                @unlink($oldFilePath);
                //$arr['url'] = ($_SERVER['SERVER_PORT']=='443'?'https://':'http://').Yii::app()->params['frontendDomain'].$arr['url'];
            } else {
                $arr['state'] = 'FAILED';
                $arr['msg'] = $model->getError();
            }
        } else {
            $arr = $fileInfo;
        }
        echo json_encode($arr);
        //$this->showAjaxJson($arr);
    }
    public function actionDeletepic($pic_storage_id) {
        $arr = array(
            'state' => 'SUCCESS',
            'msg' => 'ok',
        );
        $model = PicStorageModel::model()->findByPk($pic_storage_id);
        if ($model) {
            // 将对应的文件删除
            $fileSavedPath = Yii::app()->params['uploadPic']['basePath'].'/../'.$model->file_path;
            if (file_exists($fileSavedPath)) {
                @unlink($fileSavedPath);
            }
            $ret = $model->deleteByPk($pic_storage_id);
            if ($ret) {
                $arr['state'] = 'SUCCESS';
            } else {
                $arr['state'] = 'FAILED';
                $arr['msg'] = $model->getError();
            }
        } else {
            $arr['msg'] = 'not exist!';
        }
        $arr['fileSavedPath'] = $fileSavedPath;
        $this->showAjaxJson($arr);
    }
	
	

}
