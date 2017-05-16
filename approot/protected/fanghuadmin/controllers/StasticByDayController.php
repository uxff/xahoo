<?php

class StasticByDayController extends Controller
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
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {

        if (isset($_GET['export']) && !empty($_GET['export'])) {
            return $this->actionExport();
        }

        $start_time = '2016-04-01';
        $end_time = date('Y-m-d', time()-86400);
        
        ////condition[create_time_start]
        //if(isset($_GET['condition']['time_start']) && !empty($_GET['condition']['time_start']))
        //{
        //    $start_time = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_start'])));
        //}
        ////condition[create_time_end]
        //if(isset($_GET['condition']['time_end']) && !empty($_GET['condition']['time_end']))
        //{
        //    $end_time = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_end'])));
        //}
        //$condition = [
        //    'time_start'    => $start_time,
        //    'time_end'      => $end_time,
        //];
        $condition = $_GET['condition'];

        $searchForm = 0;
        $model = new StasticByDayModel();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StasticByDayModel'])) {
                $searchForm = 1;
                $model->attributes = $_GET['StasticByDayModel'];
        }
        $mySearch = $model->mySearch($condition);
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'id',
            'modelName' => 'StasticByDayModel',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'condition' => $condition,
        );

        //smarty render
        $this->smartyRender('stasticbyday/index.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return StasticByDayModel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = StasticByDayModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param StasticByDayModel $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * export
     */
    public function actionExport() {

        $start_time = '2016-04-01';
        $end_time = date('Y-m-d', time()-86400);
        //condition[create_time_start]
        if(isset($_GET['condition']['time_start']) && !empty($_GET['condition']['time_start']))
        {
            $start_time = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_start'])));
        }
        //condition[create_time_end]
        if(isset($_GET['condition']['time_end']) && !empty($_GET['condition']['time_end']))
        {
            $end_time = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_end'])));
        }

        $condition = $_GET['condition'];

        $arrData = StasticByDayModel::searchForReport($condition);
        $reportData = $arrData;

        // 
        foreach ($reportData as $k=>$artObj) {
            $reportData[$k]['id'] = $k+1;
        }

        // 表头
        $ths = ['序号', '日期', 'PV(活动累计)', 'UV(活动累计)', '转发量', '新增用户', '新奇访问用户','积分单日增量','积分单日消耗'];
        // 文件名
        $filename = '运营报表_'.substr($start_time, 0, 10).'_'.substr($end_time, 0, 10).'.csv';
        // 下载
        $this->downloadCsv($reportData, $ths, $filename);
    }

}
