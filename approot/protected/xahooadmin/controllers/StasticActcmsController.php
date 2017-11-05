<?php

class StasticActcmsController extends Controller
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
    public function actionIndex($page=1, $pageSize=10) {

        if (isset($_GET['export']) && !empty($_GET['export'])) {
            return $this->actionExport();
        }

        $startDay = null;//'2016-04-01 00:00:00';
        $endDay = null;//date('Y-m-d 23:59:59', time()-86400);
        //condition[create_time_start]
        if(isset($_GET['condition']['time_start']) && !empty($_GET['condition']['time_start']))
        {
            $startDay = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_start'])));
        }
        //condition[create_time_end]
        if(isset($_GET['condition']['time_end']) && !empty($_GET['condition']['time_end']))
        {
            $endDay = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_end'])));
        }

        //$startDay   = substr($start_time, 0, 10);
        //$endDay     = substr($end_time, 0, 10);

        $searchForm = 0;
        $model = new ArticleModel();
        $model->unsetAttributes();  // clear any default values
        $condition = [];
        if (isset($_GET['ArticleModel'])) {
            $searchForm = 1;
            $model->attributes = $_GET['ArticleModel'];
            $condition = $_GET['ArticleModel'];
        }
        //$model->attributes['status'] = 2;
        //$mySearch = $model->searchForStastic(['status'=> 2]);
        //$arrData = $mySearch['list'];
        $artList = StasticArticleModel::listArticle($startDay, $endDay, $page, $pageSize, $condition);
        $arrData = $artList['list'];
        //print_r($artList);exit;

        // 
        foreach ($arrData as $k=>$artObj) {
            $arrData[$k] = $artObj;//->toArray();
            //$stasticVisitInfo = ArticleVisitLogModel::stasticVisit($artObj['article_id'], $start_time, $end_time);
            //$stasticShareInfo = ShareLogModel::stasticVisit($artObj['article_id'], $start_time, $end_time);
            //$arrData[$k]['pv'] = $stasticVisitInfo[0]['pv']*1;
            //$arrData[$k]['uv'] = $stasticVisitInfo[0]['uv']*1;
            //$arrData[$k]['share_count'] = $stasticShareInfo[0]['share_count']*1;
        }
        
        //$pages = $mySearch['pages'];
        $pages = $artList['pages'];

        $arrAttributeLabel = $model->attrLabelsForList(); //$model->attributeLabels();
        // 项目分类
        //$arrType = ArticleModel::$ARR_TYPE;

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
            //'arrType' => ArticleModel::$ARR_TYPE,
            //'arrStatus' => ArticleModel::$ARR_STATUS,
        );

        $this->smarty->assign('condition', $_GET['condition']);
        //smarty render
        $this->smartyRender('stasticactcms/index.tpl', $arrRender);
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
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
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

    /**
     * export
     */
    public function actionExport() {

        $startDay = null;//'2016-04-01';
        $endDay = null;//date('Y-m-d', time()-86400);
        //condition[create_time_start]
        if(isset($_GET['condition']['time_start']) && !empty($_GET['condition']['time_start']))
        {
            $startDay = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_start'])));
        }
        //condition[create_time_end]
        if(isset($_GET['condition']['time_end']) && !empty($_GET['condition']['time_end']))
        {
            $endDay = date('Y-m-d', strtotime($this->getString($_GET['condition']['time_end'])));
        }

        $condition = $_GET['ArticleModel'];

        $reportData = [];

        $artList = StasticArticleModel::listArticle($startDay, $endDay, $page, 1000, $condition);
        $arrData = $artList['list'];
        //print_r($artList);exit;

        // 
        foreach ($arrData as $k=>$artObj) {
            //$arrData[$k] = $artObj;//->toArray();
            $reportData[$k] = [
                'id'            => $k+1,
                'title'         => $artObj['title'],
                'pv'            => $artObj['pv']*1,
                'uv'            => $artObj['uv']*1,
                'share_count'   => $artObj['share_count']*1,
            ];
            //$stasticVisitInfo = ArticleVisitLogModel::stasticVisit($artObj['article_id'], $start_time, $end_time);
            //$stasticShareInfo = ShareLogModel::stasticVisit($artObj['article_id'], $start_time, $end_time);
            //$arrData[$k]['pv'] = $stasticVisitInfo[0]['pv']*1;
            //$arrData[$k]['uv'] = $stasticVisitInfo[0]['uv']*1;
            //$arrData[$k]['share_count'] = $stasticShareInfo[0]['share_count']*1;
        }
        
        // 表头
        $ths = ['序号', '活动名称', 'PV', 'UV', '转发量'];
        // 文件名
        $filename = '活动报表_'.substr($startDay, 0, 10).'_'.substr($endDay, 0, 10).'.csv';
        // 下载
        $this->downloadCsv($reportData, $ths, $filename);
        //Yii::log('download over:'.$filename.' '.count($repoartData).'lines.'.' ', 'info', __METHOD__);
    }

    /*
        // 统计文章 每天每文章访问数 
        统计到表： fh_stastic_article
    */
    public function actionStasticArticle($dur = 1, $includeToday = 0) {
        $dayLength = $dur;
        $now = time();
        $today = date('Y-m-d', $now);
        if ($dayLength==-1) {
            $dayLength = (int)(($now - strtotime('2016-03-01')) / 86400);
        }

        // 查出所有的文章
        $artList = ArticleModel::model()->orderBy('t.id desc')->findAll();//('t.status = 2');
        // 查出在那天的文章

        foreach ($artList as $artObj) {
            // 每个文章的在线区间
            $arrRange = ArticleOperLogModel::queryRange($artObj->id);

            for ($i=0; $i<=$dayLength; ++$i) {
                $startDay = date('Y-m-d 00:00:00', $now-86400*($dayLength-$i));
                $endDay = date('Y-m-d 23:59:59', $now-86400*($dayLength-$i));
                $day = substr($startDay, 0, 10);

                if (!$includeToday && $day==$today) {
                    continue;
                }

                // 该文章该天是否在线
                $isOnline = $this->isOnlineDay($day, $arrRange);
                if (!$isOnline) {
                    // 该天不上线的不记录入库
                    continue;
                }
                // 该天上线的，记录入库

                $stasticModel = StasticArticleModel::model()->find('article_id=:aid and date=:day', [':day'=>$day, ':aid'=>$artObj->id]);
                if (empty($stasticModel)) {
                    $stasticModel = new StasticArticleModel;
                }

                $stasticVisitInfo = ArticleVisitLogModel::stasticVisit($artObj->id, $startDay, $endDay);
                $stasticShareInfo = ShareLogModel::stasticVisit($artObj->id, $startDay, $endDay);

                // 入库
                //$stasticModel = new StasticArticleModel;
                $arrAttr = [
                    'article_id'    => $artObj->id,
                    'title'         => $artObj->title,
                    'date'          => $day,
                    'pv'            => $stasticVisitInfo[0]['pv'] * 1,
                    'uv'            => $stasticVisitInfo[0]['uv'] * 1,
                    'share_count'   => $stasticShareInfo[0]['share_count'] * 1,
                ];
                $stasticModel->attributes = $arrAttr;

                if (!$stasticModel->save()) {
                    Yii::log('save faild: '.$stasticModel->lastError().' ', 'error', __METHOD__);
                    print_r($stasticModel->lastError());
                }
                echo "art=".$artObj->id." day=".$day." done\n";
            }
        }
        echo "done\n";
    }
    /*
        统计每天的 date pv uv share_count reg_count xqsj_pv xqsj_uv
        统计到表： fh_stastic_by_day
    */
    public function actionStasticByDay($dur = 1, $includeToday = 0) {
        $dayLength = $dur;
        $now = time();
        $today = date('Y-m-d', $now);
        if ($dayLength==-1) {
            $dayLength = (int)(($now - strtotime('2016-03-01')) / 86400);
        }

        // 查出所有的文章
        $artList = ArticleModel::model()->findAll('t.status = 2');

        for ($i=0; $i<=$dayLength; ++$i) {
            $startDay = date('Y-m-d 00:00:00', $now-86400*($dayLength-$i));
            $endDay = date('Y-m-d 23:59:59', $now-86400*($dayLength-$i));
            $day = substr($startDay, 0, 10);
            
            if (!$includeToday && $day==$today) {
                continue;
            }

            // 日期记录不存在，尝试创建
            $stasticDayModel = StasticByDayModel::model()->find('date=:day', [':day'=>$day]);
            if (empty($stasticDayModel)) {
                $stasticDayModel = new StasticByDayModel;
                $stasticDayModel->date = $day;
                // 防止抛错 报错
                try {
                    $ret = $stasticDayModel->save();
                    Yii::log($day.' not exist, try to add: '.$ret.' ', 'warning', __METHOD__);
                } catch (CException $e) {
                    Yii::log('insert faild: '.$e->getMessage().' ', 'error', __METHOD__);
                }
            }

            // 统计每日信息
            // 访问信息
            $stasticInfo = StasticArticleModel::stasticVisit($day);

            // 注册数
            $regCountInfo = StasticArticleModel::stasticRegCount($startDay, $endDay);
            //print_r($regCount);

            // 新奇世界访问数
            $xqsjVisitInfo = StasticArticleModel::stasticXqsjVisit($startDay, $endDay);
            //echo 'day='.$day;print_r($xqsjVisitInfo);

            $arrAttr = [
                //'date'          => $day,
                'pv'            => $stasticInfo[0]['pv'] * 1,
                'uv'            => $stasticInfo[0]['uv'] * 1,
                'share_count'   => $stasticInfo[0]['share_count'] * 1,
                'reg_count'     => $regCountInfo[0]['reg_count'] * 1,
                'xqsj_pv'       => $xqsjVisitInfo[0]['pv'] * 1,
                'xqsj_uv'       => $xqsjVisitInfo[0]['uv'] * 1,
            ];
            $stasticDayModel->attributes = $arrAttr;

            if (!$stasticDayModel->save()) {
                Yii::log('save faild: '.$stasticDayModel->lastError().' ', 'error', __METHOD__);
                print_r($stasticDayModel->lastError());
            }
            echo $day." done\n";
        }
        echo "done\n";
        
    }
    /*
        @param $day     '2016-03-01'
        @param $arrRange [['start'=>$startDay, 'end'=>$endDay], ['start'=>$startDay, 'end'=>$endDay]]
    */
    public function isOnlineDay($day, $arrRange) {
        $isOnline = 0;
        foreach ($arrRange as $range) {
            //$startDay = substr($range['start'], 0, 10);
            if (isset($range['start']) && strncmp($day, $range['start'], 10)>=0) {
                $isOnline = 1;
            }
            if (isset($range['end']) && strncmp($day, $range['end'], 10)>0) {
                $isOnline = 0;
            }
        }
        return $isOnline;
    }
}
