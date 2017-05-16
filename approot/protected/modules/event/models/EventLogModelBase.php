<?php

/**
 * This is the model class for table "fh_event_log".
 *
 * The followings are the available columns in table 'fh_event_log':
 * @property string $id
 * @property integer $event_id
 * @property string $event_key
 * @property string $sender_mid
 * @property string $params
 * @property string $create_time
 * @property string $last_modified
 * @property integer $status
 * @property integer $pre_event_id
 * @property string $pre_event_key
 */
class EventLogModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_event_log';
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
                        array('event_id, event_key, sender_mid', 'required'),
                        array('event_id, status, pre_event_id', 'numerical', 'integerOnly'=>true),
                        array('event_key, pre_event_key', 'length', 'max'=>32),
                        array('sender_mid', 'length', 'max'=>10),
                        array('params', 'length', 'max'=>1024),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, event_id, event_key, sender_mid, params, create_time, last_modified, status, pre_event_id, pre_event_key', 'safe', 'on'=>'search'),
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

                       'id' => '自增id',
                       'event_id' => '事件id',
                       'event_key' => '事件key',
                       'sender_mid' => '事件发起人id',
                       'params' => '事件参数,json',
                       'create_time' => '创建时间',
                       'last_modified' => '最后修改时间',
                       'status' => '状态',
                       'pre_event_id' => '前一个事件event_id',
                       'pre_event_key' => '前一个事件event_key',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.event_id',$this->event_id);
				$criteria->compare('t.event_key',$this->event_key,true);
				$criteria->compare('t.sender_mid',$this->sender_mid,true);
				$criteria->compare('t.params',$this->params,true);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.pre_event_id',$this->pre_event_id);
				$criteria->compare('t.pre_event_key',$this->pre_event_key,true);
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
