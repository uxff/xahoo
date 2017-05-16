<?php

/**
 * This is the model class for table "member_share_log".
 *
 * The followings are the available columns in table 'member_share_log':
 * @property string $log_id
 * @property string $member_id
 * @property string $task_id
 * @property integer $task_type
 * @property integer $share_type
 * @property string $create_time
 */
class MemberShareLogBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'member_share_log';
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
                    array('task_type, share_type', 'numerical', 'integerOnly' => true),
                    array('member_id, task_id', 'length', 'max' => 11),
                    array('create_time', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('log_id, member_id, task_id, task_type, share_type, create_time', 'safe', 'on' => 'search'),
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
                    'log_id' => '积分日志id',
                    'member_id' => '会员id',
                    'task_id' => '任务编号',
                    'task_type' => '任务类型',
                    'share_type' => '分享类型',
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
                $criteria->compare('task_id', $this->task_id, true);
                $criteria->compare('task_type', $this->task_type);
                $criteria->compare('share_type', $this->share_type);
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
