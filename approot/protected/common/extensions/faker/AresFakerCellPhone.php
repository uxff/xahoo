<?php
/*
 * 加载基础类
 */
require_once('AresFakerBase.php');

/**
 * 手机号码随机生成类
 *
 * @author liutao@fangfull.com
 * @date 2015/03/23 17:53:50
 */
class AresFakerCellPhone extends AresFakerBase {

    // 全国运营商号段
    protected static $operators = array(
        134, 135, 136, 137, 138, 139, 150, 151, 152, 157, 158, 159, 178, 182, 183, 184, 187, 188, // chinamobile
        147, // chinamobile digital
        130, 131, 132, 155, 156, 176, 185, 186, // chinaunicom
        145, // chinaunicom digital
        133, 153, 177, 180, 181, 189, // chinatelecom
        170, //other
    );

    // 后八位格式
    protected static $formats = array('########');
    
    /**
     * 生成随机手机号
     * 
     * @param  integer $count 生成手机号总数
     * @return array          手机号数组
     */
    public static function generate($count = 1) {
        $result = array();
        
        if (intval($count) >= 1) {
            for ($i=0; $i < $count; $i++) { 
                // 生成随机号段
                $phonePrefix = self::randomElement(self::$operators);
                // 生成随机号码
                $phoneNumber = self::numerify(self::randomElement(self::$formats));
                $result[] = $phonePrefix . $phoneNumber;
            }
        }
        
        return $result;
    }

}