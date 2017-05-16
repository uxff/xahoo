<?php

class PosterReportController extends Controller
{

    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {        
        if (isset($_POST['export']) && !empty($_POST['export'])) {
            return $this->actionExportExcel();
        }
        $condition = array('sql'=>'','order'=>'');
        $sql = "";          
        $order = '';  
        $model = new FhMemberHaibaoModel;
        $attributesArr = array();
        if (isset($_POST['poster'])) {     
            //if($_POST['poster']['valid_begintime'] != '' && $_POST['poster']['valid_endtime'] != ''){
            //    $sql .= " AND  (t.create_time >= "."'".$_POST['poster']['valid_begintime']."'"." AND t.create_time <= "."'".$_POST['poster']['valid_endtime']."'".")" ;   
            //}
            //if($_POST['poster']['valid_begintime'] != '' && $_POST['poster']['valid_endtime'] == ''){
            //    $sql .= " AND  (t.create_time >= "."'".$_POST['poster']['valid_begintime']."'"." AND t.create_time <= "."'".date("Y-m-d H:i:s",time())."'".")" ;   
            //}
            //if($_POST['poster']['valid_begintime'] == '' && $_POST['poster']['valid_endtime'] != ''){
            //    $sql .= " AND t.create_time <= "."'".$_POST['poster']['valid_endtime']."'" ;
            //}
            $condition['valid_begintime']   = $_POST['poster']['valid_begintime'];
            $condition['valid_endtime']     = $_POST['poster']['valid_endtime'];
            if($_POST['poster']['type'] == '1'){
                $order = "t.reward_money DESC" ;
            }
            if($_POST['poster']['type'] == '2'){
                $order = "t.fans_first DESC" ;
            }
            if($_POST['poster']['type'] == '3'){
                $order = "t.fans_second DESC" ;
            }       
            $model->attributes = $attributesArr;
            $condition['sql'] = $sql;
            $condition['order'] = $order;
        }
        $mySearch = $model->mySearch3($condition);
        $listData =  $this->convertModelToArray($mySearch['list']);
        $projectData = Project::model()->findAll();
        $projectDatas= $this->convertModelToArray($projectData);
        $pages = $mySearch['pages'];
        $arrRender = array(
            'listData'=>$listData,
            'pages' => $pages,
            'projectDatas' => $projectDatas,
            'project_id' => $_POST['poster']['project'],
            'type' => $_POST['poster']['type'],
            'name' => $_POST['poster']['name'],
            'phone' => $_POST['poster']['phone'],
            'condition' =>$condition,
        );
        $this->smartyRender('posterreport/index.tpl', $arrRender);
    }
    
     public function actionExport() {
        $startDay = null;//'2016-04-01';
        $endDay = null;//date('Y-m-d', time()-86400);
        if(isset($_POST['poster']['valid_begintime']) && !empty($_POST['poster']['valid_begintime']))
        {
            $startDay = date('Y-m-d', strtotime($this->getString($_POST['poster']['valid_begintime'])));
        }
        if(isset($_POST['poster']['valid_endtime']) && !empty($_POST['poster']['valid_endtime']))
        {
            $endDay = date('Y-m-d', strtotime($this->getString($_POST['poster']['valid_endtime'])));
        }
        
        if($_POST['poster']['type'] == '1'){
            $order = "t.reward_money DESC" ;
        }
        if($_POST['poster']['type'] == '2'){
            $order = "t.fans_first DESC" ;
        }
        if($_POST['poster']['type'] == '3'){
            $order = "t.fans_second DESC" ;
        } 
        $condition = $_POST['poster'];

        $reportData = [];

        $artList = FhMemberHaibaoModel::listArticle($startDay, $endDay, $order, $page, 1000, $condition);
        $arrData = $artList['list'];
        //var_dump($artList);exit;
        foreach ($arrData as $k=>$artObj) {
            $projectData = Project::model()->findByPk($artObj['project_id']);
            if($artObj['is_jjr'] == '1'){
                $is_jjr = '普通会员';
            }elseif($artObj['is_jjr'] == '2'){
                $is_jjr = '经纪人';
            }
            $reportData[$k] = [
                'id'            => $k+1,
                'member_mobile'         => $artObj['member_mobile'],
                'project'            => $projectData['project_name'],
                'member_fullname'            => $artObj['member_fullname'],
                'wx_nickname'   => $artObj['wx_nickname'],
                'is_jjr'   => $is_jjr,
                'reward_money'   => $artObj['reward_money'],
                'fans_first'   => $artObj['fans_first'],
                'fans_second'   => $artObj['fans_second'],
                'create_time'   => $artObj['create_time'],
            ];
        }
        // 表头
        $ths = ['序号', '手机号码', '所属项目', '会员姓名', '会员昵称','会员类型','奖励金额','直接粉丝','间接粉丝','扫码时间'];
        // 文件名
        $filename = '海报报表_'.substr($startDay, 0, 10).'_'.substr($endDay, 0, 10).'.csv';
        // 下载
        $this->downloadCsv($reportData, $ths, $filename);
        //Yii::log('download over:'.$filename.' '.count($repoartData).'lines.'.' @'.__FILE__.':'.__LINE__, 'info', __METHOD__);
    }

    public function actionExportExcel(){
        //整理数据---------------------------------
        $startDay = null;//'2016-04-01';
        $endDay = null;//date('Y-m-d', time()-86400);
        if(isset($_POST['poster']['valid_begintime']) && !empty($_POST['poster']['valid_begintime']))
        {
            //$startDay = date('Y-m-d', strtotime($this->getString($_POST['poster']['valid_begintime'])));
            $startDay = $this->getString($_POST['poster']['valid_begintime']);
        }
        if(isset($_POST['poster']['valid_endtime']) && !empty($_POST['poster']['valid_endtime']))
        {
            //$endDay = date('Y-m-d', strtotime($this->getString($_POST['poster']['valid_endtime'])));
            $endDay = $this->getString($_POST['poster']['valid_endtime']);
        }
        if($_POST['poster']['type'] == '1'){
            $order = "t.reward_money DESC" ;
        }
        if($_POST['poster']['type'] == '2'){
            $order = "t.fans_first DESC" ;
        }
        if($_POST['poster']['type'] == '3'){
            $order = "t.fans_second DESC" ;
        } 
        $condition = $_POST['poster'];

        $reportData = [];
        $artList = FhMemberHaibaoModel::listArticle($startDay, $endDay, $order, $page, 1000, $condition);
        $arrData = $artList['list'];
        foreach ($arrData as $k=>$artObj) {
            $projectData = Project::model()->findByPk($artObj['project_id']);
            if($artObj['is_jjr'] == '1'){
                $is_jjr = '普通会员';
            }elseif($artObj['is_jjr'] == '2'){
                $is_jjr = '经纪人';
            }
            $reportData[$k] = array(
                'id'            => $k+1,
                'member_mobile'         => $artObj['member_mobile'],
                'project'            => $projectData['project_name'],
                'member_fullname'            => $artObj['member_fullname'],
                'wx_nickname'   => $artObj['wx_nickname'],
                'is_jjr'   => $is_jjr,
                'reward_money'   => $artObj['reward_money'],
                'fans_first'   => $artObj['fans_first'],
                'fans_second'   => $artObj['fans_second'],
                'create_time'   => $artObj['create_time'],
            );
        }
        //生成Excel表格---------------------------------------
        $excel = new PHPExcel();
        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G','H','I','J');        
        //表头数组        
        $tableheader = array('序号', '手机号码', '所属项目', '会员姓名', '会员昵称','会员类型','奖励金额','直接粉丝','间接粉丝','扫码时间');        
        //填充表头信息        
        for($i = 0;$i < count($tableheader);$i++) {        
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");        
        }
        //表格数组
        $data = $reportData;        
        //填充表格信息        
        for ($i = 2;$i <= count($data) + 1;$i++) {        
            $j = 0;            
            foreach ($data[$i - 2] as $key=>$value) {            
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");                
                $j++;            
            }        
        }
        // 文件名
        $filename = '海报报表_'.substr($startDay, 0, 10).'_'.substr($endDay, 0, 10).'.xls';
        //创建Excel输入对象
        $write = new PHPExcel_Writer_Excel5($excel);        
        header("Pragma: public");        
        header("Expires: 0");        
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");        
        header("Content-Type:application/force-download");        
        header("Content-Type:application/vnd.ms-execl");        
        header("Content-Type:application/octet-stream");        
        header("Content-Type:application/download");        
        header('Content-Disposition:attachment;filename="'.$filename.'"');        
        header("Content-Transfer-Encoding:binary");        
        $write->save('php://output');        
    }
}
