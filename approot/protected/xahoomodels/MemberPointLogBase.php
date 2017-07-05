<?php

/**
 * This is the model class for table "member_point_log".
 *
 * The followings are the available columns in table 'member_point_log':
 * @property string $log_id
 * @property string $member_id
 * @property string $rule_id
 * @property integer $rule_point
 * @property integer $operate_type
 * @property string $description
 * @property integer $point_before
 * @property integer $point_after
 * @property string $create_time
 */
class MemberPointLogBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'member_point_log';
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
                    array('rule_point, operate_type, point_before, point_after', 'numerical', 'integerOnly' => true),
                    array('member_id, rule_id', 'length', 'max' => 11),
                    array('description', 'length', 'max' => 255),
                    array('create_time', 'safe'),
                    array('last_modified', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'update'),
                    array('create_time', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'insert'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('log_id, member_id, rule_id, rule_point, operate_type, description, point_before, point_after, create_time', 'safe', 'on' => 'search')
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                // NOTE: you may need to adjust the relation name and the related
                // class name for the relations automatically generated below.
                return array(
                    'rule' => array(self::HAS_ONE, 'PointRule', 'rule_id'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                return array(
                    'log_id' => '积分日志id',
                    'member_id' => '会员id',
                    'rule_id' => '积分规则',
                    'rule_point' => '积分分值',
                    'operate_type' => '操作类型',
                    'description' => '描述',
                    'point_before' => '之前积分数量',
                    'point_after' => '之后积分数量',
                    'create_time' => '创建时间',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('log_id', $this->log_id, true);
                $criteria->compare('member_id', $this->member_id, true);
                $criteria->compare('rule_id', $this->rule_id, true);
                $criteria->compare('rule_point', $this->rule_point);
                $criteria->compare('operate_type', $this->operate_type);
                $criteria->compare('description', $this->description, true);
                $criteria->compare('point_before', $this->point_before);
                $criteria->compare('point_after', $this->point_after);
                $criteria->compare('create_time', $this->create_time, true);
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
