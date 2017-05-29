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
 * @property integer $member_province
 * @property integer $member_city
 * @property integer $member_district
 * @property string $member_address
 * @property string $member_avatar
 * @property string $member_nickname
 * @property string $member_password
 * @property string $deal_password
 * @property string $signage
 * @property integer $parent_id
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 * @property integer $is_actived
 * @property integer $member_from
 * @property string $last_login
 * @property string $last_login_ip
 * @property integer $login_times
 */
class UcMemberBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public function tableName()
    {
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
                    'condition' => 't.status=1',
                ),
            );
    }


    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('member_mobile', 'required'),
                    array('member_gender, member_marriage_status, member_age, member_province, member_city, member_district, parent_id, status, is_actived, member_from, login_times', 'numerical', 'integerOnly'=>true),
                    array('member_fullname, member_email, member_nickname', 'length', 'max'=>64),
                    array('member_mobile, member_qq', 'length', 'max'=>16),
                    array('member_id_number, last_login_ip', 'length', 'max'=>20),
                    array('member_address, member_avatar', 'length', 'max'=>255),
                    array('signage', 'length', 'max'=>32),
                    array('member_password, deal_password', 'length', 'max'=>40),
                    array('create_time, last_login', 'safe'),
                                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('member_id, member_fullname, member_email, member_mobile, member_qq, member_id_number, member_gender, member_marriage_status, member_age, member_province, member_city, member_district, member_address, member_avatar, member_nickname, member_password, deal_password, signage, status, create_time, last_modified, is_actived, member_from, last_login, last_login_ip, login_times', 'safe', 'on'=>'search'),
            );
    }

   /**
    * @return array relational rules.
    */
   public function relations()
   {
           // NOTE: you may need to adjust the relation name and the related
           // class name for the relations automatically generated below.
           return array(
           );
   }        
   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels()
   {
           return array(

                   'member_id' => '会员id',
                   'member_fullname' => '全名',
                   'member_email' => 'email',
                   'member_mobile' => '手机号',
                   'member_qq' => 'QQ',
                   'member_id_number' => '身份id',
                   'member_gender' => '性别:0=未知;1=M;2=F',
                   'member_marriage_status' => '婚姻状态:0=未婚;1=已婚;2=离异;3=丧偶',
                   'member_age' => '年龄',
                   'member_province' => '省份',
                   'member_city' => '城市',
                   'member_district' => '地区',
                   'member_address' => '地址',
                   'member_avatar' => '头像url',
                   'member_nickname' => '昵称',
                   'member_password' => '密码',
                   'deal_password' => '支付密码',
                   'signage' => '邀请特征码',
                   'status' => '上级id',
                   'status' => '状态:1=激活;99=删除',
                   'create_time' => '创建时间',
                   'last_modified' => '最后更新时间',
                   'is_actived' => '是否激活(位):0=未激活;1=手机激活;2=邮件激活;4=身份证激活',
                   'member_from' => '来源',
                   'last_login' => '最后登录时间',
                   'last_login_ip' => '最后登录ip',
                   'login_times' => '登录次数',
           );
   }
    /**
     * 定义基础的搜索条件，不要改动
     * @return \CDbCriteria
     */
    public function getBaseCDbCriteria() {
            $criteria=new CDbCriteria;

            $criteria->compare('t.member_id',$this->member_id,true);
            $criteria->compare('t.member_fullname',$this->member_fullname,true);
            $criteria->compare('t.member_email',$this->member_email,true);
            $criteria->compare('t.member_mobile',$this->member_mobile,true);
            $criteria->compare('t.member_qq',$this->member_qq,true);
            $criteria->compare('t.member_id_number',$this->member_id_number,true);
            $criteria->compare('t.member_gender',$this->member_gender);
            $criteria->compare('t.member_marriage_status',$this->member_marriage_status);
            $criteria->compare('t.member_age',$this->member_age);
            $criteria->compare('t.member_province',$this->member_province);
            $criteria->compare('t.member_city',$this->member_city);
            $criteria->compare('t.member_district',$this->member_district);
            $criteria->compare('t.member_address',$this->member_address,true);
            $criteria->compare('t.member_avatar',$this->member_avatar,true);
            $criteria->compare('t.member_nickname',$this->member_nickname,true);
            $criteria->compare('t.member_password',$this->member_password,true);
            $criteria->compare('t.deal_password',$this->deal_password,true);
            $criteria->compare('t.signage',$this->signage,true);
            $criteria->compare('t.parent_id',$this->parent_id);
            $criteria->compare('t.status',$this->status);
            $criteria->compare('t.create_time',$this->create_time,true);
            $criteria->compare('t.last_modified',$this->last_modified,true);
            $criteria->compare('t.is_actived',$this->is_actived);
            $criteria->compare('t.member_from',$this->member_from);
            $criteria->compare('t.last_login',$this->last_login,true);
            $criteria->compare('t.last_login_ip',$this->last_login_ip,true);
            $criteria->compare('t.login_times',$this->login_times);
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
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=$this->getBaseCDbCriteria();

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
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
