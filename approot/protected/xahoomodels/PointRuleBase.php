<?php

/**
 * This is the model class for table "point_rule".
 *
 * The followings are the available columns in table 'point_rule':
 * @property string $rule_id
 * @property string $rule_name
 * @property string $rule_action
 * @property integer $rule_point
 * @property integer $rule_contribution
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class PointRuleBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'point_rule';
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
                    array('rule_point, rule_contribution, status', 'numerical', 'integerOnly' => true),
                    array('rule_name, rule_action', 'length', 'max' => 20),
                    array('create_time, last_modified', 'safe'),
                    array('last_modified', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'update'),
                    array('create_time,last_modified', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'insert'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('rule_id, rule_name, rule_action, rule_point, rule_contribution, status, create_time, last_modified', 'safe', 'on' => 'search'),
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
                    'rule_id' => '积分规则id',
                    'rule_name' => '积分规则名称',
                    'rule_action' => '积分动作',
                    'rule_point' => '积分分值',
                    'rule_contribution' => '贡献分值',
                    'status' => '状态',
                    'create_time' => '创建时间',
                    'last_modified' => '修改时间',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('rule_id', $this->rule_id, true);
                $criteria->compare('rule_name', $this->rule_name, true);
                $criteria->compare('rule_action', $this->rule_action, true);
                $criteria->compare('rule_point', $this->rule_point);
                $criteria->compare('rule_contribution', $this->rule_contribution);
                $criteria->compare('status', $this->status);
                $criteria->compare('create_time', $this->create_time, true);
                $criteria->compare('last_modified', $this->last_modified, true);
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
