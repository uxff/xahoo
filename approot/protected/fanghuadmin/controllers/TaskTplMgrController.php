<?php
//Yii::import('mtask.models.*');
//Yii::import('points.models.*');

class TaskTplMgrController extends Controller
{

    public function init() {
        parent::init();
        Yii::app()->getModule('mtask');
        Yii::app()->getModule('points');
    }
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

        $model = new TaskTplModel;
        $objModel = $this->loadModel($id);

        $arrTaskType = TaskTplModel::$ARR_TASK_TYPE;
        $arrActType = TaskTplModel::$ARR_ACT_TYPE;
        $arrStatus = TaskTplModel::$ARR_STATUS;

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
            'arrTaskType' => $arrTaskType,
            'arrActType' => $arrActType,
            'arrStatus' => $arrStatus,
        );
        $this->smartyRender('tasktplmgr/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new TaskTplModel;
        if (isset($_POST['TaskTplModel'])) {
            //$model->attributes = $_POST['TaskTplModel'];
            //$model->author_id = Yii::app()->memberadmin->id;
            //$model->author_name = Yii::app()->memberadmin->name;
            //// 如果是分享类型的 需要创建rule_id
            //if ($model->task_type == TaskTplModel::TASK_TYPE_SHARE) {
            //    $ruleModel = new PointsRuleModel;
            //    $ruleModel->rule_key = 'share_'.date('YmdHis_').mt_rand(100, 999);
            //    $ruleModel->rule_name = '任务：'.$model->task_name;
            //    $ruleModel->points = $model->reward_points;
            //    $ruleModel->flag = 2;
            //    $ruleModel->save();
            //}
            //if ($model->save()) {
            //    $this->redirect(array('view', 'id' => $model->task_id));
            //}
            // 以上操作模块化 在modules中完成
            $taskTplAttr = array(
                'TaskTplModel'=>$_POST['TaskTplModel'],
            );
            if($taskTplAttr['TaskTplModel']['reward_type_money'] == 2){
                $taskTplAttr['TaskTplModel']['reward_money'] = number_format($taskTplAttr['TaskTplModel']['reward_money'],2);
            }
            if($taskTplAttr['TaskTplModel']['reward_type'] == 1){
               $taskTplAttr['TaskTplModel']['reward_points']  = floor($taskTplAttr['TaskTplModel']['reward_points']);
            }
            if ($taskTplAttr['TaskTplModel']['task_type'] == TaskTplModel::TASK_TYPE_SHARE) {
            } else {
                $taskTplAttr['TaskTplModel']['task_type'] = TaskTplModel::TASK_TYPE_SHARE;
                //$errMsg = '只允许添加分享类型的任务！';
            }
            $taskTplAttr['TaskTplModel']['author_id'] = Yii::app()->memberadmin->id;
            $taskTplAttr['TaskTplModel']['author_name'] = Yii::app()->memberadmin->name;
            $taskTpl = Yii::app()->getModule('mtask')->addTaskTpl($taskTplAttr);
            if ($taskTpl && $taskTpl->task_id) {
                // 同步修改对应的文章的surface_url
                $this->syncArticle($taskTplAttr['TaskTplModel']['task_url'], $taskTplAttr['TaskTplModel']);
                $this->redirect(array('view', 'id' => $taskTpl->task_id));
            }
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'taskTplMgr-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => false,
                        'validateOnChange' => true,
                    ),
                ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $arrTaskType = TaskTplModel::$ARR_TASK_TYPE;
        $arrActType = TaskTplModel::$ARR_ACT_TYPE;
        $arrStatus = TaskTplModel::$ARR_STATUS;

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js,1);
        //报错信息处理
        $errMsg = $errMsg ? $errMsg : CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误');
        $this->smarty->assign("errormsgs", $errMsg);
        //render data
        $arrRender = array(
            'modelName' => 'TaskTplModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => $errMsg,//报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
            'arrTaskType' => $arrTaskType,
            'arrActType' => $arrActType,
            'arrStatus' => $arrStatus,
        );

        $this->smartyRender('tasktplmgr/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
        if (isset($_POST['TaskTplModel'])) {
                $updateModel->attributes = $_POST['TaskTplModel'];

                // 同步修改积分规则
                $rule_id = $updateModel->rule_id;
                $pointsRuleModel = PointsRuleModel::model()->find('rule_id=:rule_id', array(
                    ':rule_id' => $rule_id,
                ));
                if ($pointsRuleModel) {
                    $pointsRuleModel->points = $updateModel->reward_points;
                    if (!$pointsRuleModel->save()) {
                        Yii::log('cannot sync rule('.$rule_id.') points by task_id='.$id.': '.$taskTplModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                    }
                } else {
                    Yii::log('task tpl('.$id.') has no rule_id='.$rule_id.' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
                }

                if ($updateModel->save()) {
                    // 同步修改对应的文章的surface_url
                    $this->syncArticle($_POST['TaskTplModel']['task_url'], $_POST['TaskTplModel']);
                    $this->redirect(array('view', 'id' => $updateModel->task_id));
                }
        }
        $model = new TaskTplModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'taskTplMgr-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => false,
                'validateOnChange' => true,
            ),
        ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }

        $arrTaskType = TaskTplModel::$ARR_TASK_TYPE;
        $arrActType = TaskTplModel::$ARR_ACT_TYPE;
        $arrStatus = TaskTplModel::$ARR_STATUS;

        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js, 1);
        //render data
        $arrRender = array(
            'primaryKey'=>'task_id',
            'modelName' => 'TaskTplModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
            'arrTaskType' => $arrTaskType,
            'arrActType' => $arrActType,
            'arrStatus' => $arrStatus,
        );

        $this->smartyRender('tasktplmgr/update.tpl', $arrRender);
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
        $model = new TaskTplModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TaskTplModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['TaskTplModel'];
        }
        //$mySearch = $model->mySearch();

        $mySearch = $model->mySearch($condition);
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        $arrTaskType = TaskTplModel::$ARR_TASK_TYPE;
        $arrActType = TaskTplModel::$ARR_ACT_TYPE;
        $arrStatus = TaskTplModel::$ARR_STATUS;

        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'task_id',
            'modelName' => 'TaskTplModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'arrTaskType' => $arrTaskType,
            'arrActType' => $arrActType,
            'arrStatus' => $arrStatus,
            'token' => Yii::app()->request->csrfToken,
            'condition' => $condition,
        );

        //smarty render
        $this->smartyRender('tasktplmgr/index.tpl', $arrRender);
       
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('TaskTplModel');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('tasktplmgr/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TaskTplModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = TaskTplModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TaskTplModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
        @param string $url //url of article
        @param array  $taskTplAttr = ['surface_url'=>'xxxx.jpg']
    */
    protected function syncArticle($targetUrl, $taskTplAttr) {
        // preg_match id of article
        $urlParams = parse_url($targetUrl);
        $domainStr = $urlParams['scheme'].'://'.$urlParams['host'];
        $fanghuDomain = Yii::app()->params['FanghuServerDomain'];
        if (($domainStr==$fanghuDomain || $urlParams['host']==$fanghuDomain)) {
            parse_str($urlParams['query']);
            if ($id && $sign && ArticleModel::makeSign($id)==$sign) {
                if (isset($taskTplAttr['surface_url']) && !empty($taskTplAttr['surface_url'])) {
                    $articleModel = ArticleModel::model()->findByPk($id);
                    if ($articleModel) {
                        $articleModel->surface_url = $taskTplAttr['surface_url'];
                        if ($articleModel->save()) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
