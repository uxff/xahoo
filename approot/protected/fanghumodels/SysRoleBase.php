<?php

/**
 * This is the model class for table "sys_role".
 *
 * The followings are the available columns in table 'sys_role':
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $remark
 * @property integer $access_status
 */
class SysRoleBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'sys_role';
        }

        public function init() {
                //$this->ares_register_behaviors();
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
                    array('name, status', 'required'),
                    array('status, access_status', 'numerical', 'integerOnly' => true),
                    array('name', 'length', 'max' => 32),
                    array('remark', 'length', 'max' => 255),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, name, status, remark, access_status', 'safe', 'on' => 'search'),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                // NOTE: you may need to adjust the relation name and the related
                // class name for the relations automatically generated below.
                return array(
//                   'users' => array(self::MANY_MANY,'SystemUser','sys_role_user(role_id,user_id)'),
                    'users' => array(self::MANY_MANY, 'SysAdminUser', 'sys_role_user(role_id,user_id)'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                return array(
                    'id' => '角色id',
                    'name' => '角色名',
                    'status' => '状态',
                    'remark' => '角色描述',
//                    'access_status' => '0,表示不可删除',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('id', $this->id);
                $criteria->compare('name', $this->name, true);
                $criteria->compare('status', $this->status);
                $criteria->compare('remark', $this->remark, true);
                $criteria->compare('access_status', $this->access_status);
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
         * @return SysRole the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

}
