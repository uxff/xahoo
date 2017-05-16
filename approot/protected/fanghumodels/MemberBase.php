<?php

/**
 * This is the model class for table "member".
 *
 * The followings are the available columns in table 'member':
 * @property string $member_id
 * @property string $member_account
 * @property string $member_password
 * @property integer $member_from
 * @property integer $has_children
 * @property string $parent_id
 * @property string $member_level_id
 * @property string $member_name
 * @property integer $member_sex
 * @property string $member_birthday
 * @property string $member_mobile
 * @property integer $member_mobile_verified
 * @property string $member_nickname
 * @property string $member_email
 * @property integer $member_email_verified
 * @property string $member_avatar
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 * @property string $last_login
 * @property string $member_address
 */
class MemberBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'member';
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
                    array('member_mobile, member_password', 'required'),
                    array('member_from, has_children, member_sex, member_mobile_verified, member_email_verified, status', 'numerical', 'integerOnly' => true),
                    array('member_account', 'length', 'max' => 30),
                    array('member_password', 'length', 'max' => 36),
                    array('parent_id, member_name, member_mobile', 'length', 'max' => 20),
                    array('member_level_id', 'length', 'max' => 11),
                    array('member_nickname, member_email', 'length', 'max' => 50),
                    array('member_avatar', 'length', 'max' => 100),
                    array('member_address', 'length', 'max' => 255),
                    array('member_birthday, create_time, last_modified, last_login', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('member_id, member_account, member_password, member_from, has_children, parent_id, member_level_id, member_name, member_sex, member_birthday, member_mobile, member_mobile_verified, member_nickname, member_email, member_email_verified, member_avatar, status, create_time, last_modified, last_login, member_address', 'safe', 'on' => 'search'),
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
//                       'member_id' => '会员编号',
                    'member_account' => '会员帐号',
//                       'member_password' => '会员密码',
//                       'member_from' => '会员来源',
//                       'has_children' => '是否有小伙伴',
//                       'parent_id' => '会员上级编号',
//                       'member_level_id' => '会员等级ID',
                    'member_name' => '会员姓名',
                    'member_sex' => '性别',
                    'member_birthday' => '会员生日',
                    'member_mobile' => '会员手机号',
                    'member_mobile_verified' => '会员手机号是否认证',
                    'member_nickname' => '会员昵称',
                    'member_email' => '会员电子邮箱',
                    'member_email_verified' => '会员电子邮箱是否认证',
                    'member_avatar' => '会员头像',
                    'status' => '状态',
                    'create_time' => '会员注册时间',
                    'last_modified' => '会员信息修改时间',
                    'last_login' => '最后登录时间',
                    'member_address' => '会员地址',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('member_id', $this->member_id, true);
                $criteria->compare('member_account', $this->member_account, true);
                $criteria->compare('member_password', $this->member_password, true);
                $criteria->compare('member_from', $this->member_from);
                $criteria->compare('has_children', $this->has_children);
                $criteria->compare('parent_id', $this->parent_id, true);
                $criteria->compare('member_level_id', $this->member_level_id, true);
                $criteria->compare('member_name', $this->member_name, true);
                $criteria->compare('member_sex', $this->member_sex);
                $criteria->compare('member_birthday', $this->member_birthday, true);
                $criteria->compare('member_mobile', $this->member_mobile, true);
                $criteria->compare('member_mobile_verified', $this->member_mobile_verified);
                $criteria->compare('member_nickname', $this->member_nickname, true);
                $criteria->compare('member_email', $this->member_email, true);
                $criteria->compare('member_email_verified', $this->member_email_verified);
                $criteria->compare('member_avatar', $this->member_avatar, true);
                $criteria->compare('status', $this->status);
                $criteria->compare('create_time', $this->create_time, true);
                $criteria->compare('last_modified', $this->last_modified, true);
                $criteria->compare('last_login', $this->last_login, true);
                $criteria->compare('member_address', $this->member_address, true);
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

        public function toArray() {
            return OBJTool::convertModelToArray($this);
        }
}
