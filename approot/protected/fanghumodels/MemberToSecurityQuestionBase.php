<?php

/**
 * This is the model class for table "member_to_security_question".
 *
 * The followings are the available columns in table 'member_to_security_question':
 * @property string $id
 * @property integer $member_id
 * @property integer $security_question_id_1
 * @property integer $security_question_id_2
 * @property integer $security_question_id_3
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 * @property string $answer_1
 * @property string $answer_2
 * @property string $answer_3
 */
class MemberToSecurityQuestionBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'member_to_security_question';
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
        public function rules()
        {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                        array('member_id, security_question_id_1, security_question_id_2, security_question_id_3, status', 'numerical', 'integerOnly'=>true),
                        array('answer_1, answer_2, answer_3', 'length', 'max'=>100),
                        array('create_time, last_modified', 'safe'),
                        array('last_modified','default',
                            'value'=>new CDbExpression('NOW()'),
                            'setOnEmpty'=>false,'on'=>'update'),
                        array('create_time,last_modified','default',
                            'value'=>new CDbExpression('NOW()'),
                            'setOnEmpty'=>false,'on'=>'insert'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, security_question_id_1, security_question_id_2, security_question_id_3, status, create_time, last_modified, answer_1, answer_2, answer_3', 'safe', 'on'=>'search'),
                );
        }

       /**
        * @return array relational rules.
        */
       public function relations()
       {
               // NOTE: you may need to adjust the relation name and the related
               // class name for the relations automatically generated below.
               return array(
               );
       }        
       /**
        * @return array customized attribute labels (name=>label)
        */
       public function attributeLabels()
       {
               return array(

                       'id' => '会员对应密保问题编号',
                       'member_id' => '会员编号',
                       'security_question_id_1' => '密保问题1编号',
                       'security_question_id_2' => '密保问题2编号',
                       'security_question_id_3' => '密保问题3编号',
                       'status' => '会员密保问题状态<0|无效,1|有效',
                       'create_time' => '创建时间',
                       'last_modified' => '修改时间',
                       'answer_1' => '会员密保问题1答案',
                       'answer_2' => '会员密保问题2答案',
                       'answer_3' => '会员密保问题3答案',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('id',$this->id,true);
				$criteria->compare('member_id',$this->member_id);
				$criteria->compare('security_question_id_1',$this->security_question_id_1);
				$criteria->compare('security_question_id_2',$this->security_question_id_2);
				$criteria->compare('security_question_id_3',$this->security_question_id_3);
				$criteria->compare('status',$this->status);
				$criteria->compare('create_time',$this->create_time,true);
				$criteria->compare('last_modified',$this->last_modified,true);
				$criteria->compare('answer_1',$this->answer_1,true);
				$criteria->compare('answer_2',$this->answer_2,true);
				$criteria->compare('answer_3',$this->answer_3,true);
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
        public function search()
        {
                // @todo Please modify the following code to remove attributes that should not be searched.

                $criteria=$this->getBaseCDbCriteria();

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
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
