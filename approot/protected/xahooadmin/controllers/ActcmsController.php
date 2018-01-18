<?php

class ActcmsController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            //'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = new ArticleModel;
        $objModel = $this->loadModel($id);

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
            'arrType' => ArticleModel::$ARR_TYPE,
            'arrStatus' => ArticleModel::$ARR_STATUS,
        );
        $this->smartyRender('actcms/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ArticleModel;
        if (isset($_POST['ArticleModel'])) {
            $isUseOuterUrl = $_POST['isUseOuterUrl']*1;
            if ($isUseOuterUrl=='1' && empty($_POST['ArticleModel']['outer_url'])) {
                $errMsg = '您没有填写url '.$isUseOuterUrl;
            } elseif ($isUseOuterUrl=='0' && empty($_POST['ArticleModel']['content'])) {
                $errMsg = '您没有输入活动详情 '.$_POST['ArticleModel']['content'].$isUseOuterUrl;
            } else {
                $model->attributes = $_POST['ArticleModel'];
                if ($isUseOuterUrl==1) {
                    //unset($_POST['ArticleModel']['content']);
                    $model->content = '&nbsp;';
                } else {
                    //unset($_POST['ArticleModel']['outer_url']);
                    $model->outer_url = '';
                }
                $model->admin_id = Yii::app()->memberadmin->id;
                $model->admin_name = Yii::app()->memberadmin->name;

                // 查出第一张图片为封面图
                $imgpreg = '<img.*?src="(.*?)">';
                $ret = preg_match($imgpreg, $_POST['ArticleModel']['content'], $matched);
                if ($ret) {
                    $model->surface_url = $matched[1];
                }
                
                if ($model->save()) {
                    // 未发布不产生url
                    if ($model->status == ArticleModel::STATUS_PUBLISHED) {
                        $model->visit_url = $this->createFanghuServerUrl('article/show', array(
                            'id'=>$model->id,
                            'sign'=> $model->makeSign($model->id),
                        ));
                        $model->save();

                        // 如果是发布 增加统计记录
                        //StasticArticleModel::addStastic($model, date('Y-m-d'));
                    }
                    // 增加操作日志
                    ArticleOperLogModel::saveAnOper($model->id, 0, $model->status);

                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
            
            //$model->abstract = htmlspecialchars_decode(mb_substr(strip_tags($model->content), 0, 40));

        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'actcms-form',
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
        $errMsg = $errMsg ? $errMsg : CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误');
        $this->smarty->assign("errormsgs", CHtml::errorSummary($model));
        //render data
        $arrRender = array(
            'modelName' => 'ArticleModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => $errMsg, //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
            'isUseOuterUrl' => $isUseOuterUrl,
            'arrType' => ArticleModel::$ARR_TYPE,
            'arrStatus' => ArticleModel::$ARR_STATUS,
            'domain_str' => Yii::app()->params['FanghuServerDomain'],
        );

        $this->smartyRender('actcms/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
        $oldStatus = $updateModel->status;
        if (isset($_POST['ArticleModel'])) {
            $isUseOuterUrl = $_POST['isUseOuterUrl']*1;
            if ($isUseOuterUrl=='1' && empty($_POST['ArticleModel']['outer_url'])) {
                $errMsg = '您没有填写url '.$isUseOuterUrl;
            } elseif ($isUseOuterUrl=='0' && empty($_POST['ArticleModel']['content'])) {
                $errMsg = '您没有输入活动详情 '.$_POST['ArticleModel']['content'].$isUseOuterUrl;
            } else {
                $updateModel->attributes = $_POST['ArticleModel'];
                if ($isUseOuterUrl=='1') {
                    //$_POST['ArticleModel']['content'] = ' ';
                    // 必须有内容 坑爹的yii
                    $updateModel->content = '&nbsp;';
                } else {
                    //$_POST['ArticleModel']['outer_url'] = '';
                    $updateModel->outer_url = '';
                }
                //print_r($_POST);
                //print_r($updateModel->toArray());exit;

                //$updateModel->abstract = htmlspecialchars_decode(mb_substr(strip_tags($updateModel->content), 0, 40));

                // 查出第一张图片为封面图
                $imgpreg = '<img.*?src="(.*?)">';
                $ret = 0;//preg_match($imgpreg, $updateModel->content, $matched);
                if ($ret) {
                    $updateModel->surface_url = $matched[1];
                }
                
                // 未发布不产生url
                if ($updateModel->status == ArticleModel::STATUS_PUBLISHED) {
                    $updateModel->visit_url = $this->createFanghuServerUrl('article/show', array(
                        'id'=>$updateModel->id,
                        'sign'=> $updateModel->makeSign($updateModel->id),
                    ));

                    // 如果是发布 增加统计记录
                    //StasticArticleModel::addStastic($updateModel, date('Y-m-d'));
                } else {
                    $updateModel->visit_url = '';
                }

                if ($updateModel->save()) {
                    // 增加操作日志
                    ArticleOperLogModel::saveAnOper($updateModel->id, $oldStatus, $updateModel->status);

                    $this->redirect(array('view', 'id' => $updateModel->id));
                }
            }
        }
        $model = new ArticleModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'actcms-form',
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
            'modelName' => 'ArticleModel',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
            'isUseOuterUrl' => $updateModel->outer_url ? 1 : 0,
            'arrType' => ArticleModel::$ARR_TYPE,
            'arrStatus' => ArticleModel::$ARR_STATUS,
            'domain_str' => Yii::app()->params['FanghuServerDomain'],
        );

        $this->smartyRender('actcms/update.tpl', $arrRender);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //TODO
        $model = $this->loadModel($id);
        if ($model) {
            $model->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            return;
        }
        $this->jsonSuccess('ok');
    }

    /**
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {

        $condition = $_GET['condition'];

        $searchForm = 0;
        $model = new ArticleModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ArticleModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['ArticleModel'];
        }
        $mySearch = $model->mySearch($condition);
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attrLabelsForList(); //$model->attributeLabels();
        // 项目分类
        $arrType = ArticleModel::$ARR_TYPE;

        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'id',
            'modelName' => 'ArticleModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'arrType' => ArticleModel::$ARR_TYPE,
            'arrStatus' => ArticleModel::$ARR_STATUS,
            'condition' => $condition,
        );

        //smarty render
        $this->smartyRender('actcms/index.tpl', $arrRender);
    }






    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('ArticleModel');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('actcms/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ArticleModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ArticleModel::model()->findByPk($id);
        //if ($model === null)
            //throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ArticleModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
