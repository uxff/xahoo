<?php

/**
 * This is the model class for table "security_question".
 *
 * The followings are the available columns in table 'security_question':
 * @property string $id
 * @property string $question_text
 * @property string $answer_rule
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class SecurityQuestionBase extends CActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'security_question';
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

                        array('answer_type, status', 'numerical', 'integerOnly'=>true),
                        array('question_text', 'length', 'max'=>200),
                        array('answer_rule', 'length', 'max'=>100),
                        array('create_time, last_modified', 'safe'),
                        array('last_modified','default',
                            'value'=>new CDbExpression('NOW()'),
                            'setOnEmpty'=>false,'on'=>'update'),
                        array('create_time,last_modified','default',
                            'value'=>new CDbExpression('NOW()'),
                            'setOnEmpty'=>false,'on'=>'insert'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, question_text, answer_rule, answer_type, status, create_time, last_modified', 'safe', 'on'=>'search'),
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
                    'id' => '密保问题编号',
                    'question_text' => '密保问题内容',
                    'answer_rule' => '答案规则',
                    'status' => '密保问题状态',
                    'create_time' => '密保问题创建时间',
                    'last_modified' => '密保问题修改时间',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

       				$criteria->compare('id',$this->id,true);
				$criteria->compare('question_text',$this->question_text,true);
				$criteria->compare('answer_rule',$this->answer_rule,true);
				$criteria->compare('answer_type',$this->answer_type);
				$criteria->compare('status',$this->status);
				$criteria->compare('create_time',$this->create_time,true);
				$criteria->compare('last_modified',$this->last_modified,true);
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
