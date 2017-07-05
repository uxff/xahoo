<?php

/**
 * This is the model class for table "member_address".
 *
 * The followings are the available columns in table 'member_address':
 * @property string $id
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $county_id
 * @property string $consignee_name
 * @property string $consignee_mobile
 * @property string $address
 * @property string $member_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_default
 */
class MemberAddressBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'member_address';
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
                    array('consignee_name, consignee_mobile, address, member_id', 'required'),
                    array('province_id, city_id, county_id, is_default', 'numerical', 'integerOnly' => true),
                    array('consignee_name', 'length', 'max' => 30),
                    array('consignee_mobile', 'length', 'max' => 20),
                    array('address', 'length', 'max' => 200),
                    array('member_id', 'length', 'max' => 11),
                    array('create_time, update_time', 'safe'),
                    array('update_time', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'update'),
                    array('create_time,update_time', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'insert'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, province_id, city_id, county_id, consignee_name, consignee_mobile, address, member_id, create_time, update_time, is_default', 'safe', 'on' => 'search'),
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
//                       'id' => '收货地址编号',
                    'province_id' => '省',
                    'city_id' => '市',
                    'county_id' => '区',
                    'consignee_name' => '收货人姓名',
                    'consignee_mobile' => '收货人手机号',
                    'address' => '收货地址',
//                       'member_id' => '收货地址所属会员编号',
//                       'create_time' => '创建时间',
//                       'update_time' => '修改时间',
//                       'is_default' => '是否是默认地址：0|不是,1|是',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('id', $this->id, true);
                $criteria->compare('province_id', $this->province_id);
                $criteria->compare('city_id', $this->city_id);
                $criteria->compare('county_id', $this->county_id);
                $criteria->compare('consignee_name', $this->consignee_name, true);
                $criteria->compare('consignee_mobile', $this->consignee_mobile, true);
                $criteria->compare('address', $this->address, true);
                $criteria->compare('member_id', $this->member_id, true);
                $criteria->compare('create_time', $this->create_time, true);
                $criteria->compare('update_time', $this->update_time, true);
                $criteria->compare('is_default', $this->is_default);
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
