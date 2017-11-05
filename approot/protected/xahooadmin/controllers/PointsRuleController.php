<?php

class PointsRuleController extends Controller
{
    public function init() {
        parent::init();
        Yii::app()->getModule('points');
        Yii::app()->getModule('mtask');
    }

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

        $model = new PointsRuleModel;
        $objModel = $this->loadModel($id);

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
        );
        $this->smartyRender('pointsrule/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PointsRuleModel;
        if (isset($_POST['PointsRuleModel'])) {
            $model->attributes = $_POST['PointsRuleModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->rule_id));
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'pointsRule-form',
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
            'modelName' => 'PointsRuleModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
        );

        $this->smartyRender('pointsrule/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
        if (isset($_POST['PointsRuleModel'])) {
            unset($_POST['PointsRuleModel']['rule_key']);
            //$updateModel->attributes = $_POST['PointsRuleModel'];
            // 可以修改为汉子
            $points = ($_POST['PointsRuleModel']['points'])*1;
            if ($points != 0) {
                $updateModel->points = $_POST['PointsRuleModel']['points'];
                $updateModel->points_desc = '';
            } else {
                $updateModel->points_desc = $_POST['PointsRuleModel']['points'];
                $updateModel->points = 0;
            }
            $updateModel->rule_name = $_POST['PointsRuleModel']['rule_name'];
            if ($updateModel->save()) {
                // 同步修改任务
                $taskTplModel = TaskTplModel::model()->find('rule_id=:rule_id', array(
                    ':rule_id' => $id,
                ));
                if ($taskTplModel) {
                    $taskTplModel->reward_points = $updateModel->points;
                    if (!$taskTplModel->save()) {
                        Yii::log('cannot sync task tpl('.$taskTplModel->task_id.') points by rule_id='.$rule_id.': '.$taskTplModel->lastError().' ', 'error', __METHOD__);
                    }
                } else {
                    //Yii::log('no task tpl use rule_id='.$rule_id.' ', 'warning', __METHOD__);
                }
                $this->redirect(array('index'));
            }
        }
        $model = new PointsRuleModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'pointsRule-form',
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
            'primaryKey'=>'rule_id',
            'modelName' => 'PointsRuleModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
        );

        $this->smartyRender('pointsrule/update.tpl', $arrRender);
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
        $model = new PointsRuleModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PointsRuleModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['PointsRuleModel'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'rule_id',
            'modelName' => 'PointsRuleModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
        );

        //smarty render
        $this->smartyRender('pointsrule/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('PointsRuleModel');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('pointsrule/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PointsRuleModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PointsRuleModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PointsRuleModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
