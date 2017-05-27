<?php

class HotArticleController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = new HotArticleModel;
        $objModel = $this->loadModel($id);
        $arrType = HotArticleModel::$ARR_TYPE;
        $arrStatus = HotArticleModel::$ARR_STATUS;

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
            'arrType' => $arrType,
            'arrStatus' => $arrStatus,
        );
        $this->smartyRender('hotarticle/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new HotArticleModel;
        if (isset($_POST['HotArticleModel'])) {
			//判断url是否有"http://"
			$url = $_POST['HotArticleModel']['url'];

			if ( !empty($url) && !preg_match('/^(http:\/\/)|(https:\/\/)/',$url) ){
				$_POST['HotArticleModel']['url'] = "http://".$url;
			}	
				
				
            $model->attributes = $_POST['HotArticleModel'];
            $model->admin_id = Yii::app()->memberadmin->id;
            $model->admin_name = Yii::app()->memberadmin->name;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'hotArticle-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => false,
                        'validateOnChange' => true,
                    ),
                ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $arrType = HotArticleModel::$ARR_TYPE;
        $arrStatus = HotArticleModel::$ARR_STATUS;

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js,1);
        //报错信息处理
        $this->smarty->assign("errormsgs", CHtml::errorSummary($model));
        //render data
        $arrRender = array(
            'modelName' => 'HotArticleModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
            'arrType' => $arrType,
            'arrStatus' => $arrStatus,
        );

        $this->smartyRender('hotarticle/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
        if (isset($_POST['HotArticleModel'])) {
				
				//判断url是否有"http://"
				$url = $_POST['HotArticleModel']['url'];

				if ( !empty($url) && !preg_match('/^(http:\/\/)|(https:\/\/)/',$url) ){
					$_POST['HotArticleModel']['url'] = "http://".$url;
				}	
				
                $updateModel->attributes = $_POST['HotArticleModel'];
				
                if ($updateModel->save()) {
                        $this->redirect(array('view', 'id' => $updateModel->id));
                }
        }
        $model = new HotArticleModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'hotArticle-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => false,
                'validateOnChange' => true,
            ),
        ));
		
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $arrType = HotArticleModel::$ARR_TYPE;
        $arrStatus = HotArticleModel::$ARR_STATUS;

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js, 1);
        //render data
        $arrRender = array(
            'primaryKey'=>'id',
            'modelName' => 'HotArticleModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
            'arrType' => $arrType,
            'arrStatus' => $arrStatus,
        );

        $this->smartyRender('hotarticle/update.tpl', $arrRender);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //TODO
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        $token = $_GET['token'];
        if ($token == Yii::app()->request->csrfToken) {
            $this->loadModel($id)->delete();
        }
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {

        $condition = $_GET['condition'];

        $searchForm = 0;
        $model = new HotArticleModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HotArticleModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['HotArticleModel'];
        }
        

        $mySearch = $model->mySearch($condition);

        //$mySearch = $model->mySearch();
        

        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attrLabelsForList();//attributeLabels();
        $arrType = HotArticleModel::$ARR_TYPE;
        $arrStatus = HotArticleModel::$ARR_STATUS;

        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'id',
            'modelName' => 'HotArticleModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'arrType' => $arrType,
            'arrStatus' => $arrStatus,
            'token' => Yii::app()->request->csrfToken,
        );

        $this->smarty->assign('condition', $condition);
        //smarty render
        $this->smartyRender('hotarticle/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('HotArticleModel');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('hotarticle/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return HotArticleModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = HotArticleModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param HotArticleModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
