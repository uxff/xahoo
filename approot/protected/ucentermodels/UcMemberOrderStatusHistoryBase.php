<?php

/**
 * This is the model class for table "uc_member_order_status_history".
 *
 * The followings are the available columns in table 'uc_member_order_status_history':
 * @property string $history_id
 * @property integer $order_id
 * @property integer $order_status
 * @property string $status_comment
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberOrderStatusHistoryBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_order_status_history';
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
                        array('order_id, order_status', 'numerical', 'integerOnly'=>true),
                        array('status_comment', 'length', 'max'=>255),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('history_id, order_id, order_status, status_comment, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'history_id' => 'History',
                       'order_id' => 'Order',
                       'order_status' => 'Order Status',
                       'status_comment' => 'Status Comment',
                       'create_time' => 'Create Time',
                       'last_modified' => 'Last Modified',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('history_id',$this->history_id,true);
				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('order_status',$this->order_status);
				$criteria->compare('status_comment',$this->status_comment,true);
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
