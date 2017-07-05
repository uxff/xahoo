<?php

/**
 * This is the model class for table "member_brokerage_log".
 *
 * The followings are the available columns in table 'member_brokerage_log':
 * @property string $brokerage_id
 * @property string $member_id
 * @property integer $brokerage_before
 * @property integer $brokerage_after
 * @property string $brokerage_time
 */
class MemberBrokerageLogBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'member_brokerage_log';
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
                    array('brokerage_before, brokerage_after', 'numerical', 'integerOnly' => true),
                    array('member_id', 'length', 'max' => 11),
                    array('brokerage_time', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('brokerage_id, member_id, brokerage_before, brokerage_after, brokerage_time', 'safe', 'on' => 'search'),
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
//                       'brokerage_id' => '佣金日志id',
                    'member_id' => '会员id',
                    'brokerage_before' => '之前佣金',
                    'brokerage_after' => '之后佣金',
//                       'brokerage_time' => '创建时间',
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
                $criteria->compare('brokerage_before', $this->brokerage_before);
                $criteria->compare('brokerage_after', $this->brokerage_after);
                $criteria->compare('brokerage_time', $this->brokerage_time, true);
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
