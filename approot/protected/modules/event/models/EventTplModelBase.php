<?php

/**
 * This is the model class for table "fh_event_tpl".
 *
 * The followings are the available columns in table 'fh_event_tpl':
 * @property integer $event_id
 * @property string $event_key
 * @property string $event_name
 * @property string $event_desc
 * @property string $event_class
 * @property string $event_next
 */
class EventTplModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_event_tpl';
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
                           'condition' => 't.status=1',
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
                        array('event_key, event_class', 'required'),
                        array('event_key', 'length', 'max'=>32),
                        array('event_name, event_desc, event_class, event_next, use_rule_key', 'length', 'max'=>255),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('event_id, event_key, event_name, event_desc, event_class, event_next, use_rule_key', 'safe', 'on'=>'search'),
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

                       'event_id' => '事件id',
                       'event_key' => '事件key',
                       'event_name' => '事件名称',
                       'event_desc' => '事件描述',
                       'event_class' => '类',
                       'event_next' => '下一个事件',
                       'use_rule_key' => '使用的规则',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.event_id',$this->event_id);
				$criteria->compare('t.event_key',$this->event_key,true);
				$criteria->compare('t.event_name',$this->event_name,true);
				$criteria->compare('t.event_desc',$this->event_desc,true);
				$criteria->compare('t.event_class',$this->event_class,true);
				$criteria->compare('t.event_next',$this->event_next,true);
				$criteria->compare('t.use_rule_key',$this->use_rule_key,true);
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
        public function toArray() {
            return OBJTool::convertModelToArray($this);
        }
}
