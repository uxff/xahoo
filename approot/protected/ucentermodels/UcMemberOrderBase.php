<?php

/**
 * This is the model class for table "uc_member_order".
 *
 * The followings are the available columns in table 'uc_member_order':
 * @property string $order_id
 * @property integer $member_id
 * @property double $order_total
 * @property integer $order_type
 * @property integer $order_status
 * @property integer $payment_method
 * @property string $payment_vendor_code
 * @property string $order_extra
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberOrderBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_order';
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
                        array('member_id, order_type, order_status, payment_method, status', 'numerical', 'integerOnly'=>true),
                        array('order_total', 'numerical'),
                        array('payment_vendor_code', 'length', 'max'=>64),
                        array('order_extra, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('order_id, member_id, order_total, order_type, order_status, payment_method, payment_vendor_code, order_extra, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'order_id' => 'Order',
                       'member_id' => 'Member',
                       'order_total' => 'Order Total',
                       'order_type' => 'Order Type',
                       'order_status' => 'Order Status',
                       'payment_method' => 'Payment Method',
                       'payment_vendor_code' => 'Payment Vendor Code',
                       'order_extra' => 'Order Extra',
                       'status' => 'Status',
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

       				$criteria->compare('order_id',$this->order_id,true);
				$criteria->compare('member_id',$this->member_id);
				$criteria->compare('order_total',$this->order_total);
				$criteria->compare('order_type',$this->order_type);
				$criteria->compare('order_status',$this->order_status);
				$criteria->compare('payment_method',$this->payment_method);
				$criteria->compare('payment_vendor_code',$this->payment_vendor_code,true);
				$criteria->compare('order_extra',$this->order_extra,true);
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
