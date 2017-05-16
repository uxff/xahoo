<?php
/*
 * 加载基础类
 */
require_once('AresFakerBase.php');

/**
 * 中文姓名随机生成类
 *
 * @author liutao@fangfull.com
 * @date 2015/03/23 17:53:50
 */
class AresFakerPerson extends AresFakerBase {
    
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    // 姓氏
    protected static $firstNameOperators = array(
        '任', '彭', '杨', '林', '毛', '胡', '陈', '雷', '龙',
        '丁', '万', '严', '于', '何', '余', '侯', '傅', '冯', '刘', '卢', '史', '叶',
        '吕', '吴', '周', '唐', '夏', '姚', '姜', '孔', '孙', '宋', '崔', '廖',
        '张', '徐', '方', '曹', '曾', '朱', '李', '杜', '梁', '武', '段', '江',
        '汪', '沈', '洪', '潘', '熊', '王', '田', '白', '秦', '程', '罗', '苏',
        '范', '莫', '萧', '董', '蒋', '蔡', '薛', '袁', '覃', '许', '谢', '谭',
        '贺', '贾', '赖', '赵', '邓', '邱', '邵', '邹', '郝', '郭', '金', '钟',
        '钱', '阎', '陆', '陶', '韦', '韩', '顾', '马', '高', '魏', '黄', '黎',
        '龚',
    );
    
    // 男士名字
    protected static $lastNameMaleOperators = array(
        '帅','慧','旭','宁','龙','林','欢','佳','阳','建华','亮','成','畅','建','云','洁','峰','建国','建军','柳','晨','瑞','桂荣',
        '志强','玉华','兵','雷','东','欣','博','丽华','彬','坤','想','淑华','荣','秀华','岩','杨','文','利','楠','建平','瑜','俊',
        '伟','强','磊','洋','勇','军','杰','涛','超','明','刚','平','辉','鹏','华','飞','英','鑫','波','斌','宇','浩','凯','健',
        '解放','援朝','红卫','跃进','东方','鹏飞','兴坤','德华','德威','靖宇','文龙','武','文武','文明','传文','传武','键','鸿儒','海林',
    );

    // 女士名字
    protected static $lastNameFemaleOperators = array(
        '芳','娜','敏','静','秀英','丽','艳','娟','霞','秀兰','燕','玲','桂英','丹','萍','红','玉兰','桂兰','梅','莉','玉珍','凤英','秀珍',
        '淑兰','丽丽','玉','秀芳','淑英','桂芳','琳','丹丹','桂香','桂芝','小红','金凤','红霞','桂花','璐','凤兰','帆','雪梅','诗慧','诗诗',
        '雪','婷','玉梅','晶','玉英','颖','红梅','倩','琴','兰英','淑珍','春梅','海燕','冬梅','秀荣','桂珍','莹','秀云','秀梅','丽娟','婷婷',
    );

    /**
     * 生成随机姓名
     * 
     * @param  integer $count  生成数目
     * @param  string  $gender 性别类型
     * @return array           姓名数组
     */
    public static function generate($count=1, $gender='') {
         $result = array();
        
        if (intval($count) >= 1) {
            for ($i=0; $i < $count; $i++) {
                // 生成随机姓氏
                $randFirstName = self::randomElement(self::$firstNameOperators);
                // 生成随机名字
                if ($gender === self::GENDER_MALE) {
                    $randLastName = self::randomElement(self::$lastNameMaleOperators);
                } elseif ($gender === self::GENDER_FEMALE) {
                    $randLastName = self::randomElement(self::$lastNameFemaleOperators);
                } else {
                    $randLastName = self::randomElement( array_merge(self::$lastNameMaleOperators, self::$lastNameFemaleOperators) );
                }
                
                // 格式: 姓氏+名字
                $result[] = $randFirstName . $randLastName;
            }
        }

        //
        return $result;
    }

}