<?php

/**
 * This is the model class for table "point_task".
 *
 * The followings are the available columns in table 'point_task':
 * @property string $task_id
 * @property string $task_title
 * @property string $task_detail
 * @property string $task_url
 * @property string $task_reward
 * @property integer $task_category
 * @property string $task_img
 * @property integer $point_amount
 * @property integer $dividend_ratio
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class PointTaskBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'point_task';
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
                    array('task_title', 'required'),
                    array('task_category, point_amount, dividend_ratio, status', 'numerical', 'integerOnly' => true),
                    array('task_title', 'length', 'max' => 50),
                    array('task_url', 'length', 'max' => 200),
                    array('task_reward', 'length', 'max' => 30),
                    array('task_img', 'length', 'max' => 255),
                    array('task_detail, create_time, last_modified', 'safe'),
                    array('last_modified', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'update'),
                    array('create_time,last_modified', 'default',
                        'value' => new CDbExpression('NOW()'),
                        'setOnEmpty' => false, 'on' => 'insert'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('task_id, task_title, task_detail, task_url, task_reward, task_category, task_img, point_amount, dividend_ratio, status, create_time, last_modified', 'safe', 'on' => 'search'),
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
//                       'task_id' => '任务编号',
                    'task_title' => '任务标题',
                    'task_detail' => '任务详情',
                    'task_url' => '任务URL',
                    'task_reward' => '任务奖历',
                    'task_category' => '任务分类:',
                    'task_img' => '任务配图',
                    'point_amount' => '积分数量',
                    'dividend_ratio' => '佣金比例',
                    'status' => '状态',
//                       'create_time' => '创建时间',
//                       'last_modified' => '修改时间',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('task_id', $this->task_id, true);
                $criteria->compare('task_title', $this->task_title, true);
                $criteria->compare('task_detail', $this->task_detail, true);
                $criteria->compare('task_url', $this->task_url, true);
                $criteria->compare('task_reward', $this->task_reward, true);
                $criteria->compare('task_category', $this->task_category);
                $criteria->compare('task_img', $this->task_img, true);
                $criteria->compare('point_amount', $this->point_amount);
                $criteria->compare('dividend_ratio', $this->dividend_ratio);
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
