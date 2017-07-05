<?php

/**
 * This is the model class for table "sys_admin_user".
 *
 * The followings are the available columns in table 'sys_admin_user':
 * @property integer $id
 * @property string $account
 * @property string $password
 * @property string $name
 * @property string $email
 * @property integer $create_time
 * @property integer $status
 * @property string $telephone
 */
class SysAdminUserBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'sys_admin_user';
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
                    array('password, email, account', 'required'),
                    array('status', 'numerical', 'integerOnly' => true),
                    array('email', 'email'),
                    array('account, name', 'length', 'max' => 32),
                    array('password, email', 'length', 'max' => 255),
                    array('telephone', 'length', 'max' => 15),
                    array('last_modified', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'update'),
//                        array('create_time,last_modified','default',
//                            'value'=>new CDbExpression('NOW()'),
//                            'setOnEmpty'=>false,'on'=>'insert'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, account, password, name, email, create_time, last_modified, status, telephone', 'safe', 'on' => 'search'),
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
                    'id' => '自增ID',
                    'account' => '用户账号',
                    'password' => '用户密码',
                    'name' => '用户姓名',
                    'email' => 'Email',
                    'create_time' => '创建时间',
                    'last_modified' => '最后更新时间',
                    'status' => '状态',
                    'telephone' => '电话',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('id', $this->id);
                $criteria->compare('account', $this->account, true);
                $criteria->compare('password', $this->password, true);
                $criteria->compare('name', $this->name, true);
                $criteria->compare('email', $this->email, true);
                $criteria->compare('create_time', $this->create_time);
                $criteria->compare('last_modified', $this->last_modified);
                $criteria->compare('status', $this->status);
                $criteria->compare('telephone', $this->telephone, true);
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
         * @return SysAdminUser the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

}
