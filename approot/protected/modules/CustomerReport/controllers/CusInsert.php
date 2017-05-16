<?php

class CusInsert extends insertInterface
{
    /**
     * 构建
     */
    public function __construct(){}
	
    /**
     * 测试
     */
//    public function test(){
//        echo 'test pass<br/>';
//        var_dump(parent::$OpType);
//        die;
//    }
    /**
     * 
     * @param type $arr 配置数据数组
     * @param type $sourceSex 来源 全产权预约/专题页面
     * @return boolean
     */
    public function insertApi($arr,$sourceSex = 1){
//        $arr = array(
//            'user_name' =>  '123123',
//            'user_sex' =>  '1',
//            'user_province' =>  '1',
//            'user_city' =>  '1001',
//            'user_county' =>  '1001002',
//            'user_phone' =>  '1231231231231',
//            'code' =>  '123123',
//            'building_id' =>  '39' ,
//        );
        $opType = parent::$OpType;
        
        if(empty($arr)) return;
        
        $clientReportObj = new ClientReport;
        $clientReportObj->cusName           = $arr['user_name'];
        $clientReportObj->cusSex            = $arr['user_sex'];
        $clientReportObj->cusTel            = $arr['user_phone'];
        $clientReportObj->cusProvinceId     = $arr['user_province'];
        $clientReportObj->sourceSex         = $sourceSex;
        $clientReportObj->sourceSexName     = $opType[$sourceSex];
        if(isset($arr['user_province'])){
            $Pinfo = SysRegion::model()->find( array(
                'condition' => 'sys_region_index=:par',
                'params' => array(':par'=>$arr['user_province'],),
                ));
//            $Pinfo = $this->convertModelToArray($Pinfo);
            $clientReportObj->cusProvince       = $Pinfo->sys_region_name;
        }
        $clientReportObj->cusCityId         = $arr['user_city'];
        if(isset($arr['user_city'])){
            $Cinfo = SysRegion::model()->find( array(
                'condition' => 'sys_region_index=:par',
                'params' => array(':par'=>$arr['user_city'],),
                ));
//            $Cinfo = $this->convertModelToArray($Cinfo);
            $clientReportObj->cusCity       = $Cinfo->sys_region_name;
        }
        $clientReportObj->cusAreaId         = $arr['user_county'];
        if(isset($arr['user_county'])){
            $Uinfo = SysRegion::model()->find( array(
                'condition' => 'sys_region_index=:par',
                'params' => array(':par'=>$arr['user_county'],),
                ));
//            $Uinfo = $this->convertModelToArray($Uinfo);
            $clientReportObj->cusArea       = $Uinfo->sys_region_name;
        }
        $clientReportObj->sourceId          = $arr['building_id'];
         if(isset($arr['building_id'])){
            $Binfo = QcqBuilding::model()->find( array(
                'condition' => 'building_id=:par',
                'params' => array(':par'=>$arr['building_id'],),
                ));
//            $Uinfo = $this->convertModelToArray($Binfo);
            $clientReportObj->sourceName       = $Binfo->building_name;
        }
        $bool = $clientReportObj->save();
        return $bool;
    }
    
}