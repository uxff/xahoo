<?php

/**
 * This is the model class for table "uc_member".
 *
 * The followings are the available columns in table 'uc_member':
 * @property string $member_id
 * @property string $member_fullname
 * @property string $member_email
 * @property string $member_mobile
 * @property string $member_qq
 * @property string $member_id_number
 * @property integer $member_gender
 * @property integer $member_marriage_status
 * @property integer $member_age
 * @property integer $member_mail_code
 * @property integer $member_province
 * @property integer $member_city
 * @property integer $member_district
 * @property string $member_birthday
 * @property string $member_address
 * @property string $member_avatar
 * @property string $member_nickname
 * @property string $member_password
 * @property string $deal_password
 * @property string $dealpwd_lock_time
 * @property integer $mod_dealpwd_num
 * @property string $signage
 * @property integer $has_children
 * @property string $parent_id
 * @property integer $is_newsletter
 * @property integer $is_email_actived
 * @property integer $is_mobile_actived
 * @property integer $is_idnumber_actived
 * @property integer $is_actived
 * @property integer $status
 * @property string $from
 * @property string $create_time
 * @property string $last_modified
 * @property string $member_finance_level
 * @property integer $member_residence_time
 * @property string $member_corporation
 * @property integer $member_company_type
 * @property integer $member_private_province
 * @property integer $member_private_city
 * @property integer $member_private_county
 * @property integer $is_agree_trade_privacy
 * @property string $member_business
 * @property string $member_business_address
 * @property integer $member_business_industry
 * @property integer $member_business_scale
 * @property integer $member_business_salary
 * @property integer $member_business_time
 * @property string $last_login
 * @property integer $fh_member_level
 * @property integer $fh_last_login
 */
class UcMemberBase extends UCenterActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'uc_member';
    }

    public function init() {
        $this->ares_register_behaviors();
    }

    /**
     * 命名空间调用
     * 例：ZybCountry::model()->published()->findAll();
     * @return 在原有的搜索条件上加上condition
     * url:
     */
    public function scopes() {
        return array(
            'published' => array(
                'condition' => 'status=1',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            /**
              array('member_gender, member_marriage_status, member_age, member_mail_code, member_province, member_city, member_district, mod_dealpwd_num, has_children, is_newsletter, is_email_actived, is_mobile_actived, is_idnumber_actived, is_actived, status', 'numerical', 'integerOnly'=>true),
              array('member_fullname, member_email, member_mobile', 'length', 'max'=>128),
              array('member_qq, member_nickname, signage, from', 'length', 'max'=>16),
              array('member_id_number, parent_id', 'length', 'max'=>20),
              array('member_address', 'length', 'max'=>255),
              array('member_avatar', 'length', 'max'=>300),
              array('member_password, deal_password', 'length', 'max'=>36),
              array('member_birthday, dealpwd_lock_time, create_time, last_modified', 'safe'),
              // The following rule is used by search().
              // @todo Please remove those attributes that should not be searched.
              array('member_id, member_fullname, member_email, member_mobile, member_qq, member_id_number, member_gender, member_marriage_status, member_age, member_mail_code, member_province, member_city, member_district, member_birthday, member_address, member_avatar, member_nickname, member_password, deal_password, dealpwd_lock_time, mod_dealpwd_num, signage, has_children, parent_id, is_newsletter, is_email_actived, is_mobile_actived, is_idnumber_actived, is_actived, status, from, create_time, last_modified', 'safe', 'on'=>'search'),
             * 
             */
             array('member_gender, member_marriage_status, member_age, member_mail_code, member_province, member_city, member_district, mod_dealpwd_num, has_children, is_newsletter, is_email_actived, is_mobile_actived, is_idnumber_actived, is_actived, status, is_send, is_finance, member_work_province, member_work_city, member_work_county, member_company_industry, member_company_scale, member_work_time, member_work_salary, member_updatefinance, is_finance_check, member_residence_time, member_company_type, member_private_province, member_private_city, member_private_county, is_agree_trade_privacy, member_business_industry, member_business_scale, member_business_salary, member_business_time, fh_member_level', 'numerical', 'integerOnly'=>true),
            array('member_fullname, member_email, member_mobile', 'length', 'max' => 128),
            array('member_qq, member_nickname, member_from', 'length', 'max' => 16),
            array('signage', 'length', 'max' => 50),
            array('member_id_number', 'length', 'max' => 120),
            array('parent_id', 'length', 'max' => 20),
            array('member_address, member_name, member_company, member_company_address, member_corporation, member_business, member_business_address', 'length', 'max'=>255),
            array('member_avatar', 'length', 'max' => 300),
            array('member_password, deal_password', 'length', 'max' => 36),
            array('admin_id', 'length', 'max' => 11),
            array('member_birthday, dealpwd_lock_time, create_time, last_modified,last_login,fh_last_login', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('member_id, member_fullname, member_email, member_mobile, member_qq, member_id_number, member_gender, member_marriage_status, member_age, member_mail_code, member_province, member_city, member_district, member_birthday, member_address, member_avatar, member_nickname, member_password, deal_password, dealpwd_lock_time, mod_dealpwd_num, signage, has_children, parent_id, is_newsletter, is_email_actived, is_mobile_actived, is_idnumber_actived, is_actived, status, is_send, admin_id, member_from, create_time, last_modified, is_finance, member_name, member_work_province, member_work_city, member_work_county, member_company, member_company_industry, member_company_scale, member_company_address, member_work_time, member_work_salary, member_updatefinance, member_finance_level, is_finance_check, member_residence_time, member_corporation, member_company_type, member_private_province, member_private_city, member_private_county, is_agree_trade_privacy, member_business, member_business_address, member_business_industry, member_business_scale, member_business_salary, member_business_time,fh_last_login', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            /**
              'member_id' => '主键自增长',
              'member_fullname' => '全名',
              'member_email' => '邮箱',
              'member_mobile' => '手机',
              'member_qq' => '会员qq号',
              'member_id_number' => '会员身份证号',
              'member_gender' => '性别',
              'member_marriage_status' => '婚恋状态',
              'member_age' => '年龄',
              'member_mail_code' => '用户邮编',
              'member_province' => '会员省份编号',
              'member_city' => '会员城市编号',
              'member_district' => '会员区编号',
              'member_birthday' => '生日',
              'member_address' => '地址',
              'member_avatar' => '头像地址',
              'member_nickname' => '昵称',
              'member_password' => '密码',
              'deal_password' => '交易密码',
              'dealpwd_lock_time' => '交易密码锁定时间',
              'mod_dealpwd_num' => '交易密码修改次数',
              'signage' => '会员标识',
              'has_children' => '是否有小伙伴',
              'parent_id' => '会员上级编号',
              'is_newsletter' => '是否订阅newsletter',
              'is_email_actived' => '邮箱是否激活',
              'is_mobile_actived' => '手机是否激活',
              'is_idnumber_actived' => '是否通过身份验证',
              'is_actived' => '是否激活',
              'status' => '状态',
              'from' => '会员来源',
              'create_time' => '创建时间',
              'last_modified' => '最后更新时间',
             * 
             */
            'member_id' => 'ID',
            'member_fullname' => '姓名',
//            'member_email' => '邮箱',
            'member_mobile' => '手机号码',
//            'member_qq' => '会员qq号',
            'member_id_number' => '身份证号',
//            'member_gender' => '性别',
//            'member_marriage_status' => '婚恋状态',
//            'member_age' => '年龄',
//            'member_mail_code' => '用户邮编',
//            'member_province' => '会员省份编号',
//            'member_city' => '会员城市编号',
//            'member_district' => '会员区编号',
//            'member_birthday' => '生日',
//            'member_address' => '地址',
//            'member_avatar' => '头像地址',
//            'member_nickname' => '昵称',
//            'member_password' => '密码',
//            'deal_password' => '交易密码',
//            'dealpwd_lock_time' => '交易密码锁定时间',
//            'mod_dealpwd_num' => '交易密码修改次数',
//            'signage' => '会员标识',
//            'has_children' => '是否有小伙伴',
//            'parent_id' => '会员上级编号',
//            'is_newsletter' => '是否订阅newsletter',
//            'is_email_actived' => '邮箱是否激活',
//            'is_mobile_actived' => '手机是否激活',
//            'is_idnumber_actived' => '是否通过身份验证',
//            'is_actived' => '是否激活',
            'status' => '状态',
//            'is_send' => '是否给用户发短信,1发送,0未发送',
//            'admin_id' => '添加会员客服id',
            'member_from' => '注册来源',
            'create_time' => '注册时间',
            'last_login' => '最后登录时间',
            'last_modified' => '最后更新时间',
//            'is_finance' => '是否是理财用户',
//            'member_name' => '姓名',
//            'member_work_province' => '工作省份',
//            'member_work_city' => '工作城市',
//            'member_work_county' => '工作县',
//            'member_company' => '公司名称',
//            'member_company_industry' => '所属行业',
//            'member_company_scale' => '公司规模',
//            'member_company_address' => '公司地址',
//            'member_work_time' => '工作时间',
//            'member_work_salary' => '税后月薪',
//            'member_updatefinance' => '是否补充完升级金融用户所需资料',
//            'member_residence_time' => '居住时间',
//            'member_corporation' => '法人代表',
//            'member_company_type' => '公司类型',
              // 'member_private_province' => '私营省份',
              // 'member_private_city' => '私营城市',
              // 'member_private_county' => '私营县',
            // 'is_agree_trade_privacy' => '是否同意交易协议书',
//            'member_business' => 'Member Business',
//             'member_business_address' => 'Member Business Address',
//             'member_business_industry' => 'Member Business Industry',
//             'member_business_scale' => 'Member Business Scale',
//             'member_business_salary' => 'Member Business Salary',
//              'member_business_time' => 'Member Business Time',
        );
    }

    /**
     * 定义基础的搜索条件，不要改动
     * @return \CDbCriteria
     */
    public function getBaseCDbCriteria() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.member_id', $this->member_id, true);
        $criteria->compare('t.member_fullname', $this->member_fullname, true);
        $criteria->compare('t.member_email', $this->member_email, true);
        $criteria->compare('t.member_mobile', $this->member_mobile, true);
        $criteria->compare('t.member_qq', $this->member_qq, true);
        $criteria->compare('t.member_id_number', $this->member_id_number, true);
        $criteria->compare('t.member_gender', $this->member_gender);
        $criteria->compare('t.member_marriage_status', $this->member_marriage_status);
        $criteria->compare('t.member_age', $this->member_age);
        $criteria->compare('t.member_mail_code', $this->member_mail_code);
        $criteria->compare('t.member_province', $this->member_province);
        $criteria->compare('t.member_city', $this->member_city);
        $criteria->compare('t.member_district', $this->member_district);
        $criteria->compare('t.member_birthday', $this->member_birthday, true);
        $criteria->compare('t.member_address', $this->member_address, true);
        $criteria->compare('t.member_avatar', $this->member_avatar, true);
        $criteria->compare('t.member_nickname', $this->member_nickname, true);
        $criteria->compare('t.member_password', $this->member_password, true);
        $criteria->compare('t.deal_password', $this->deal_password, true);
        $criteria->compare('t.dealpwd_lock_time', $this->dealpwd_lock_time, true);
        $criteria->compare('t.mod_dealpwd_num', $this->mod_dealpwd_num);
        $criteria->compare('t.signage', $this->signage, true);
        $criteria->compare('t.has_children', $this->has_children);
        $criteria->compare('t.parent_id', $this->parent_id, true);
        $criteria->compare('t.is_newsletter', $this->is_newsletter);
        $criteria->compare('t.is_email_actived', $this->is_email_actived);
        $criteria->compare('t.is_mobile_actived', $this->is_mobile_actived);
        $criteria->compare('t.is_idnumber_actived', $this->is_idnumber_actived);
        $criteria->compare('t.is_actived', $this->is_actived);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.is_send', $this->is_send);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.member_from', $this->member_from);
        $criteria->compare('t.create_time', $this->create_time, true);

        $criteria->compare('t.last_modified',$this->last_modified,true);
        $criteria->compare('t.is_finance',$this->is_finance);
        $criteria->compare('t.member_name',$this->member_name,true);
        $criteria->compare('t.member_work_province',$this->member_work_province);
        $criteria->compare('t.member_work_city',$this->member_work_city);
        $criteria->compare('t.member_work_county',$this->member_work_county);
        $criteria->compare('t.member_company',$this->member_company,true);
        $criteria->compare('t.member_company_industry',$this->member_company_industry);
        $criteria->compare('t.member_company_scale',$this->member_company_scale);
        $criteria->compare('t.member_company_address',$this->member_company_address,true);
        $criteria->compare('t.member_work_time',$this->member_work_time);
        $criteria->compare('t.member_work_salary',$this->member_work_salary);
        $criteria->compare('t.member_updatefinance',$this->member_updatefinance);
        $criteria->compare('t.member_finance_level',$this->member_finance_level,true);
        $criteria->compare('t.is_finance_check',$this->is_finance_check);
        $criteria->compare('t.debt_ability',$this->debt_ability);
        $criteria->compare('t.audit_status',$this->audit_status);
        $criteria->compare('t.member_residence_time',$this->member_residence_time);
        $criteria->compare('t.member_corporation',$this->member_corporation,true);
        $criteria->compare('t.member_company_type',$this->member_company_type);
        $criteria->compare('t.member_private_province',$this->member_private_province);
        $criteria->compare('t.member_private_city',$this->member_private_city);
        $criteria->compare('t.member_private_county',$this->member_private_county);
        $criteria->compare('t.is_agree_trade_privacy',$this->is_agree_trade_privacy);
        $criteria->compare('t.member_business',$this->member_business,true);
        $criteria->compare('t.member_business_address',$this->member_business_address,true);
        $criteria->compare('t.member_business_industry',$this->member_business_industry);
        $criteria->compare('t.member_business_scale',$this->member_business_scale);
        $criteria->compare('t.member_business_salary',$this->member_business_salary);
        $criteria->compare('t.member_business_time',$this->member_business_time);
        $criteria->compare('t.fh_member_level',$this->fh_member_level);
        $criteria->compare('t.last_login',$this->last_login, true);
        $criteria->compare('t.fh_last_login',$this->fh_last_login, true);
        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = $this->getBaseCDbCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SysNode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
