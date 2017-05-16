<?php

/**
 * This is the model class for table "sys_node".
 *
 * The followings are the available columns in table 'sys_node':
 * @property integer $id
 * @property string $url
 * @property string $name
 * @property string $title
 * @property integer $status
 * @property string $remark
 * @property integer $sort
 * @property integer $pid
 * @property integer $level
 * @property integer $display
 * @property string $icon
 */
class SysNodeBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'sys_node';
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
                    array('name, title, status, pid, level, url,', 'required'),
                    array('status, sort, pid, level, display', 'numerical', 'integerOnly' => true),
                    array('url', 'length', 'max' => 100),
                    array('name, icon', 'length', 'max' => 32),
                    array('title, remark', 'length', 'max' => 255),
                    array('create_time', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, url, name, title, status, remark, sort, pid, level, display, icon, create_time, last_modified', 'safe', 'on' => 'search'),
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
                    'id' => 'ID',
                    'url' => 'Url',
                    'name' => 'Name',
                    'title' => 'Title',
                    'status' => 'Status',
                    'remark' => 'Remark',
                    'sort' => 'Sort',
//                       'pid' => 'Pid',
                    'level' => '1: 分组;2:controller;3:action',
                    'display' => '是否显示',
                    'icon' => '图标',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('id', $this->id);
                $criteria->compare('url', $this->url, true);
                $criteria->compare('name', $this->name, true);
                $criteria->compare('title', $this->title, true);
                $criteria->compare('status', $this->status);
                $criteria->compare('remark', $this->remark, true);
                $criteria->compare('sort', $this->sort);
                $criteria->compare('pid', $this->pid);
                $criteria->compare('level', $this->level);
                $criteria->compare('display', $this->display);
                $criteria->compare('icon', $this->icon);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
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
