<?php
/**
* 
* coderxx@xqshijie.cn
* 2016-01-26
*/
class StasticCommand  extends CConsoleCommand 
{
    public function init() {
        Yii::import('application.common.extensions.*');
        Yii::import('application.common.components.*');
        Yii::import('application.xahoomodels.*');
    }
    
    public function actionIndex($dur = -1) {
        $this->actionStasticArticle((int)$dur);
        $this->actionStasticByDay((int)$dur);
    }
    
    // 统计文章 每天每文章访问数 
    public function actionStasticArticle($dur = -1, $includeToday = 0) {
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
                    Yii::log('save faild: '.$stasticModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
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
    public function actionStasticByDay($dur = -1, $includeToday = 0) {
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
                    Yii::log($day.' not exist, try to add: '.$ret.' @'.__FILE__.':'.__LINE__, 'warning', __METHOD__);
                } catch (CException $e) {
                    Yii::log('insert faild: '.$e->getMessage().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
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
            $points_add = Yii::app()->db->createCommand()
            ->select('sum(points) as points_add')
            ->from('fh_member_points_history')
            ->where('create_time>:start_time and create_time <:end_time and type=1', [':start_time'=>$startDay, ':end_time'=>$endDay])
            ->queryAll();
             // print_r($points_add);exit();
            $points_consume = Yii::app()->db->createCommand()
            ->select('sum(points) as points_consume')
            ->from('fh_member_points_history')
            ->where('create_time>:start_time and create_time <:end_time and type=2', [':start_time'=>$startDay, ':end_time'=>$endDay])
            ->queryAll();


            $arrAttr = [
                //'date'          => $day,
                'pv'            => $stasticInfo[0]['pv'] * 1,
                'uv'            => $stasticInfo[0]['uv'] * 1,
                'share_count'   => $stasticInfo[0]['share_count'] * 1,
                'reg_count'     => $regCountInfo[0]['reg_count'] * 1,
                'xqsj_pv'       => $xqsjVisitInfo[0]['pv'] * 1,
                'xqsj_uv'       => $xqsjVisitInfo[0]['uv'] * 1,
                'points_add'   => $points_add[0]['points_add']*1,
                'points_consume'=> $points_consume[0]['points_consume']*1,
            ];
            $stasticDayModel->attributes = $arrAttr;

            if (!$stasticDayModel->save()) {
                Yii::log('save faild: '.$stasticDayModel->lastError().' @'.__FILE__.':'.__LINE__, 'error', __METHOD__);
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
