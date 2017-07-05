<?php

//Yii::import('application.ucentermob.api.*');
//Yii::import('application.ucentermob.models.*');
Yii::import('application.ucentermob.components.UCenterActiveRecord');
//Yii::import('application.ucentermodels.*');
//Yii::import('application.ucentermob.api.UCenterStatic');
//Yii::import('application.common.extensions.sms.*');

class MemberReportController extends Controller
{
    public function init() {
        parent::init();
        Yii::app()->getModule('points');
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
     * Lists all models.
     */
    public function actionIndex($keyword='', $page=1, $pageSize=10) {
        $condition = $_GET['condition'];
        if ($_GET['export']) {
            return $this->export($condition);
        }
        $model = new UcMember();
        $model->unsetAttributes();  // clear any default values
        //if (isset($_GET['MemberTotalModel'])) {
        //        $searchForm = 1;
        //        $model->attributes = $_GET['MemberTotalModel'];
        //}
        $mySearch = $model->mySearchForReport2($condition, $page);
        //print_r($mySearch);exit;
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrLevel = Yii::app()->getModule('points')->getLevelList();
        $arrStatus = UcMember::$ARR_STATUS;
        $arrMemberFrom = UcMember::$ARR_MEMBER_FROM;
        //$arrAttributeLabel = $model->attributeLabels();
        //unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'UcMember',//'MemberTotalModel',
            //'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'condition' => $condition,
            'arrLevel' => $arrLevel,
            'arrMemberFrom' => $arrMemberFrom,
            'arrStatus' => $arrStatus,
            'totalInfo' => $mySearch['totalInfo'],
            //'order_by' =>
        );

        //smarty render
        $this->smartyRender('memberreport/index.tpl', $arrRender);
    }
    public function export($condition = []) {
        $mySearch = UcMember::model()->mySearchForReport2($condition, 1, 1000);
        // 此顺序要和查询的字段对应
        $ths = [
            '用户id','姓名','手机号码','积分余额','积分获得','积分消费','会员等级','金额余额','金额获得','金额提现','状态','注册来源','注册时间','最后登录时间'
        ];

        $arrLevel = Yii::app()->getModule('points')->getLevelList();
        $arrStatus = UcMember::$ARR_STATUS;
        $arrMemberFrom = UcMember::$ARR_MEMBER_FROM;

        //print_r($mySearch['list'][0]);exit;
        foreach ($mySearch['list'] as $k=>&$v) {
            $v['status']        = $arrStatus[$v['status']];
            //$v['level']         = $arrLevel[$v['level']];
            $v['member_from']   = $arrMemberFrom[$v['member_from']];
        }
        $name = 'Xahoo会员信息导出'.date('YmdHis').'.xls';
        $this->downloadXls($mySearch['list'], $ths, $name);

    }

    /**
     * Performs the AJAX validation.
     * @param MemberTotalModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
