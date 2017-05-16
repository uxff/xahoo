<?php

class MemberController extends Controller
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

        $model = new MemberModel;
        $objModel = $this->loadModel($id);

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
        );
        $this->smartyRender('member/view.tpl', $arrRender);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new MemberModel;
        if (isset($_POST['Member'])) {
            $_POST['Member']['member_password'] = md5($_POST['Member']['member_password']);
            $model->attributes = $_POST['Member'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->member_id));
        }
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
                    'id' => 'member-form',
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
            'modelName' => 'Member',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements'=>$model->FormElements,
            'action' => 'Create',
            'errormsgs' => CHtml::errorSummary($model,'<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell'=>$js,
            'dataObj' => $model,
        );

        $this->smartyRender('member/create.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
        if (isset($_POST['Member'])) {
            $_POST['Member']['member_password'] = md5($_POST['Member']['member_password']);
                $updateModel->attributes = $_POST['Member'];
                if ($updateModel->save()) {
                        $this->redirect(array('view', 'id' => $updateModel->member_id));
                }
        }
        $model = new MemberModel;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'member-form',
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
            'primaryKey'=>'member_id',
            'modelName' => 'Member',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
        );

        $this->smartyRender('member/update.tpl', $arrRender);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        echo $_POST['url'];
    }

    /**
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $searchForm = 0;
        $model = new MemberModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Member'])) {
                $searchForm = 1;
                $model->attributes = $_GET['Member'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
        );

        //smarty render
        $this->smartyRender('member/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('Member');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('member/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Member the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MemberModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Member $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * show member basic information
     */
    public function actionDetail($id) {
        $member_id = $this->getInt($id);
        $detail_information = MemberModel::model()->findByPk($member_id);
        $member_total = MemberTotal::model()->findByAttributes(array('member_id' =>$member_id));
        $arrRender = array(
            'member_information' => $detail_information,
            'member_id' => $member_id,
            'member_total' => $member_total,
        );
        $this->smartyRender('member/memberdetail.tpl', $arrRender);
    }


    /**
     * task log of member
     */
    public function actionTaskArticle($id) {
        $searchForm = 0;
        $member_id = $this->getInt($id);
        $member = MemberModel::model()->findByPk($member_id);
        $model = new MemberToTask();
        $model->unsetAttributes();
        $model->member_id = $member_id;
        if (isset($_GET['Member'])) {
            $searchForm = 1;
            $model->attributes = $_GET['Member'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];
        $arrAttributeLabel = $model->attributeLabels();

        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );

        $this->smartyRender('member/membertaskarticle.tpl', $arrRender);
    }


    public function actionTaskBuilding($id) {
        $searchForm = 0;
        $member_id = $this->getInt($id);
        $member = MemberModel::model()->findByPk($member_id);
        $model = new MemberToTask();
        $model->unsetAttributes();
        $model->member_id = $member_id;
        if (isset($_GET['Member'])) {
            $searchForm = 1;
            $model->attributes = $_GET['Member'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];
        $arrAttributeLabel = $model->attributeLabels();

        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );

        $this->smartyRender('member/membertaskbuilding.tpl', $arrRender);
    }
    /**
     * point log of member
     */
    public function actionPointLog($id) {
        $searchForm = 0;
        $member_id = $this->getInt($id);
        $member = MemberModel::model()->findByPk($member_id);
        $model = new MemberPointLog();
        $model->unsetAttributes();
        $model->member_id = $member_id;
        if (isset($_GET['Member'])) {
            $searchForm = 1;
            $model->attributes = $_GET['Member'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];
        $arrAttributeLabel = $model->attributeLabels();

        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );

        $this->smartyRender('member/pointlog.tpl', $arrRender);

    }

    /**
     * brokerage log of member
     */
    public function actionBrokerageLog($id) {
        $searchForm = 0;
        $member_id = $this->getInt($id);
        $member = MemberModel::model()->findByPk($member_id);
        $model = new MemberBrokerageLog();
        $model->unsetAttributes();
        $model->member_id = $member_id;
        if (isset($_GET['Member'])) {
            $searchForm = 1;
            $model->attributes = $_GET['Member'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];
        $arrAttributeLabel = $model->attributeLabels();

        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );

        $this->smartyRender('member/memberbrokerage.tpl', $arrRender);

    }

    /**
     * brokerage log of member
     */
    public function actionFavorite($id) {
        $member_id = $this->getInt($id);
//        echo $id.'这里是会员任务收藏页面';
        //会员信息
        $member = MemberModel::model()->findByPk($member_id);
        $searchForm = 0;
        $member_id = $this->getInt($id);
        $model = new MemberFavorite();
        $model->unsetAttributes();
        $model->member_id = $member_id;
        if (isset($_GET['Member'])) {
            $searchForm = 1;
            $model->attributes = $_GET['MemberFavorite'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );
        $this->smartyRender('member/favorite.tpl', $arrRender);

    }

    /**
     * pages of addresses for members
     */
    public function actionAddress($id) {
        $searchForm = 0;
        $member_id = $this->getInt($id);
        $member = MemberModel::model()->findByPk($member_id);
        $model = new MemberAddress();
        $model->unsetAttributes();
        $model->member_id = $member_id;
        if (isset($_GET['Member'])) {
            $searchForm = 1;
            $model->attributes = $_GET['Member'];
        }
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];
        $arrAttributeLabel = $model->attributeLabels();
        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );

        $this->smartyRender('member/address.tpl', $arrRender);
    }

    /**
     * friends of member
     */
    public function actionRelations($id) {
        $member_id = $this->getInt($id);
        //查询当前会员信息
        $member = MemberModel::model()->findByPk($member_id);
//        //查询二度小伙伴信息
//        $partners = MemberRelation::model()->findAllByAttributes(array('parent_id' => $member_id));
        $partners = MemberRelation::model()->findAll("t.parent_tree like '%{$member_id}%'");
        $res = $this->RelationTree($partners);
        $max_degree = max($res['degree']);
        $arrRender = array(
            'member' => $member,
            'partners' => $res['list'],
            'res' => $res,
            'max_degree' => $max_degree,
        );

        $this->smartyRender('member/relations.tpl', $arrRender);

    }
    /**
     * ajax get member relations
     */
    public function actionGetRelations($id) {
        $member_id = $this->getInt($id);
        //查询所请求会员下一级的会员信息
        $partners = MemberRelation::model()->findAllByAttributes(array('parent_id' => $member_id));
        $response = array();
        if($partners == null){
            $response['state'] = false;
            echo json_encode($response);
            return false;
        }
        $degree = $this->Degree($partners[0]->parent_tree);
        $array = array();
        foreach($partners as $k =>$v){
            $array[$k]['member_id'] = $v->member->member_id;
            $array[$k]['member_name'] = $v->member->member_name;
            $array[$k]['member_avatar'] = $v->member->member_avatar;
            $array[$k]['parent_id'] = $v->member->parent_id;
        }

        $response['state'] = true;
        $response['degree'] = $degree;
        $response['data'] = $array;
        echo json_encode($response);

    }

    /**
     * 判断伙伴度数
     */
    private function Degree($tree) {
        $tree = trim($tree);
        $degree = count(explode(',', $tree));
        return $degree;
    }

    /**
     * 处理关系树
     */
    private function RelationTree($arr) {
        $respons = array();
        $degree_arr = array();
        foreach($arr as $key => $value){
            //计算度数
            $degree = substr_count($value->parent_tree, ',');
            $respons[$key]['member_id'] = $value->member->member_id;
            $respons[$key]['member_name'] = $value->member->member_name;
            $respons[$key]['member_avatar'] = $value->member->member_avatar;
            $respons[$key]['parent_id'] = $value->parent_id;
            $respons[$key]['degree'] = $degree + 1;
            $degree_arr[] = $degree + 1;
//            $respons[$degree + 2][]['member_id'] = $value->member->member_id;
//            $respons[$degree + 2][]['member_name'] = $value->member->member_name;
//            $respons[$degree + 2][]['member_avatar'] = $value->member->member_avatar;
        }

        $res = array();
        $res['list'] = $respons;
        $res['degree'] = $degree_arr;
        return $res;

    }

    /**
     * appointments of member
     */
    public function actionAppointment($id) {
        $searchForm = 0;
        $member = MemberModel::model()->findByPk($this->getInt($id));
        $model = new MemberAppointment();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MemberAppointment'])) {
            $searchForm = 1;
            $model->attributes = $_GET['MemberAppointment'];
        }
        $model->member_id = $this->getInt($id);
        $mySearch = $model->mySearch();
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'id',
            'modelName' => 'MemberAppointment',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'member'=>$member,
        );

        //smarty render
        $this->smartyRender('member/appointment.tpl', $arrRender);

    }

}
