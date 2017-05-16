<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $objNew = $this->loadModel($id);

        //var_dump($objNew);
        //render data
        $arrRender = array(
            'objNew' => $objNew,
        );

        $this->smartyRender('<?php echo strtolower($this->controllerID); ?>/view.php', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new <?php echo $this->modelClass; ?>;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // Warning:先不做报错的处理
        // 需要在Controller里处理的变量
        //Form 表单所需要的变量
        //数据列对应的文本说明
        $LabelsArr = array();
        foreach ($model->getAttributes() as $key => $value) {
            $LabelsArr[$key] = $model->getAttributeLabel($key);
        }
        $this->smarty->assign("model", "<?php echo $this->modelClass; ?>"); //所使用的数据类
        $this->smarty->assign("attributes", $model->getAttributes()); //数据列
        $this->smarty->assign("attributes_label", $LabelsArr); //数据列对应的文本署名
        $this->smarty->assign("action","Create");

        if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
            $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
        }
        
        //报错信息处理
        $this->smarty->assign("errormsgs", CHtml::errorSummary($model));
        $this->smarty->display("<?php echo strtolower($this->controllerID); ?>/create.php");

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $objNewModel = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($objNewModel);
        //Form 表单所需要的变量
        //数据列对应的文本说明
        $LabelsArr = array();
        foreach ($model->getAttributes() as $key => $value) {
            $LabelsArr[$key] = $model->getAttributeLabel($key);
        }
        $this->smarty->assign("model", "<?php echo $this->modelClass; ?>"); //所使用的数据类
        $this->smarty->assign("attributes", $model->getAttributes()); //数据列
        $this->smarty->assign("attributes_label", $LabelsArr); //数据列对应的文本署名
        $this->smarty->assign("action","Update");
        if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
            $objNewModel->attributes = $_POST['<?php echo $this->modelClass; ?>'];
            if ($objNewModel->save()) {
                $this->redirect(array('view', 'id' => $objNewModel-><?php echo $this->tableSchema->primaryKey; ?>));
            }
        }
        
        //render data
        $arrRender = array(
            'objNewModel' => $objNewModel,
        );

        $this->smartyRender('<?php echo strtolower($this->controllerID); ?>/update.php', $arrRender);
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
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>');

        $newsData = $dataProvider->getData();
        //var_dump($newsData);
        //render data
        $arrRender = array(
            'data' => $newsData,
            'dataCount' => count($newsData),
        );
        $this->smartyRender('<?php echo strtolower($this->controllerID); ?>/index.php', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>');

        $newsData = $dataProvider->getData();

        //var_dump($newsData);
        //render data
        $arrRender = array(
            'data' => $newsData,
            'dataCount' => count($newsData),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('<?php echo strtolower($this->controllerID); ?>/admin.php', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return <?php echo $this->modelClass; ?> the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = <?php echo $this->modelClass; ?>::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param <?php echo $this->modelClass; ?> $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
