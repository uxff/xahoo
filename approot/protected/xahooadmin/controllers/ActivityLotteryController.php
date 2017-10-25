<?php
/**
 * Created by PhpStorm.
 * User: coderdjc@xqshijie.cn
 * Date: 16-09-13
 **/

class ActivityLotteryController extends Controller
{

    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {    
        if (isset($_GET['export']) && !empty($_GET['export'])) {
            return $this->actionExportExcel();
        }
        $sql = "";       
        $condition = array();   
        $model = new FhActivityLotteryModel;
        if (isset($_GET['lottery'])) {    
            $condition['valid_begintime'] =$_GET['lottery']['valid_begintime'];  
            $condition['valid_endtime'] =$_GET['lottery']['valid_endtime'];  
            $condition['phone'] =$_GET['lottery']['phone'];  
            $condition['status'] =$_GET['lottery']['status'];
            if($_GET['lottery']['valid_begintime'] != '' && $_GET['lottery']['valid_endtime'] != ''){
                $sql .= " AND  (t.create_time >= "."'".$_GET['lottery']['valid_begintime']."'"." AND t.create_time <= "."'".$_GET['lottery']['valid_endtime']."'".")" ;   
            }
            if($_GET['lottery']['valid_begintime'] != '' && $_GET['lottery']['valid_endtime'] == ''){
                $sql .= " AND  (t.create_time >= "."'".$_GET['lottery']['valid_begintime']."'"." AND t.create_time <= "."'".date("Y-m-d H:i:s",time())."'".")" ;   
            }
            if($_GET['lottery']['valid_begintime'] == '' && $_GET['lottery']['valid_endtime'] != ''){
                $sql .= " AND t.create_time <= "."'".$_GET['lottery']['valid_endtime']."'" ;
            }
            if($_GET['lottery']['phone'] != ''){
                $sql .= " AND t.member_mobile like "."'%".$_GET['lottery']['phone']."%'";    
            }
            if($_GET['lottery']['status'] != ''){
                $sql .= " AND t.status = ".$_GET['lottery']['status'] ;
            }       
            $model->attributes = $_GET['lottery'];
        }
        $mySearch = $model->mySearch2($sql);
        $listData =  $this->convertModelToArray($mySearch['list']);
        //var_dump($listData);
        $pages = $mySearch['pages'];
        $arrRender = array(
            'listData'=>$listData,
            'pages' => $pages,
            'condition'=>$condition,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
        );
        $this->smartyRender('activitylottery/index.tpl', $arrRender);
    }
    

    public function actionExportExcel(){
        //整理数据---------------------------------
        $startDay = null;//'2016-04-01';
        $endDay = null;//date('Y-m-d', time()-86400);
        if(isset($_GET['lottery']['valid_begintime']) && !empty($_GET['lottery']['valid_begintime']))
        {
            $startDay = $this->getString($_GET['lottery']['valid_begintime']);
        }
        if(isset($_GET['lottery']['valid_endtime']) && !empty($_GET['lottery']['valid_endtime']))
        {
            $endDay = $this->getString($_GET['lottery']['valid_endtime']);
        }
        if(isset($_GET['lottery']['phone']) && !empty($_GET['lottery']['phone']))
        {
            $phone = $_GET['lottery']['phone'];
        }
        if(isset($_GET['lottery']['status']) && !empty($_GET['lottery']['status']))
        {
            $status = $this->getString($_GET['lottery']['status']);
        }
        $condition = $_GET['lottery'];
        $order = '';
        $reportData = [];
        $artList = FhActivityLotteryModel::listArticle($startDay, $endDay, $phone, $status, $order, $page, 1000, $condition);
        $arrData = $artList['list'];
        foreach ($arrData as $k=>$artObj) {
            if($artObj['status'] == '1'){
                $status = '未中奖';
            }elseif($artObj['status'] == '2'){
                $status = '已中奖';
            }
            $reportData[$k] = array(
                'id'            => $k+1,
                'create_time'   => $artObj['create_time'],
                'member_name'   => $artObj['member_name'],
                'member_mobile' => $artObj['member_mobile'],
                'prize'         => $artObj['prize'],
                'points'        => $artObj['points'],
                'status'        => $status,
            );
        }
        //生成Excel表格---------------------------------------
        $excel = new PHPExcel();
        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G');        
        //表头数组        
        $tableheader = array('序号', '抽奖时间', '会员昵称', '手机号码', '奖品','消耗积分','中奖情况');        
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
        $filename = '抽奖报表_'.substr($startDay, 0, 10).'_'.substr($endDay, 0, 10).'.xls';
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
