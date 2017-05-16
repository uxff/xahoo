<?php

/**
 * This is the model class for table "pm_order".
 *
 * The followings are the available columns in table 'pm_order':
 * @property integer $order_id
 * @property integer $customer_id
 * @property string $cusomter_name
 * @property string $cusomter_phone
 * @property integer $address_id
 * @property string $address_desc
 * @property string $logistics_name
 * @property string $logistics_url
 * @property string $logistics_no
 * @property string $shipper_name
 * @property string $shipper_date
 * @property string $remark
 * @property double $order_total
 * @property integer $order_status
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class PmOrderBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'pm_order';
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
                        array('customer_id, address_id, order_status, status', 'numerical', 'integerOnly'=>true),
                        array('order_total', 'numerical'),
                        array('cusomter_name, cusomter_phone', 'length', 'max'=>200),
                        array('address_desc, logistics_url, remark', 'length', 'max'=>255),
                        array('logistics_name, logistics_no, shipper_name', 'length', 'max'=>50),
                        array('shipper_date, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('order_id, customer_id, cusomter_name, cusomter_phone, address_id, address_desc, logistics_name, logistics_url, logistics_no, shipper_name, shipper_date, remark, order_total, order_status, status, create_time, last_modified', 'safe', 'on'=>'search'),
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
                'orderitems' => array(self::HAS_MANY, 'PmOrderItem', '', 'on' => 'orderitems.member_id = t.member_id'),
               );
       }        
       /**
        * @return array customized attribute labels (name=>label)
        */
       public function attributeLabels()
       {
               return array(

                       'order_id' => '主键',
                       'customer_id' => '用户ID',
                       'cusomter_name' => '客户姓名',
                       'cusomter_phone' => '客户手机',
                       'address_id' => '收货地址ID',
                       'address_desc' => '收货详细地址',
                       'logistics_name' => '物流公司名称',
                       'logistics_url' => '物流url',
                       'logistics_no' => '物流账号',
                       'shipper_name' => '发货人',
                       'shipper_date' => '发货日期',
                       'remark' => '备注',
                       'order_total' => '订单总额',
                       'order_status' => '订单状态',
                       'status' => '状态',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('customer_id',$this->customer_id);
				$criteria->compare('cusomter_name',$this->cusomter_name,true);
				$criteria->compare('cusomter_phone',$this->cusomter_phone,true);
				$criteria->compare('address_id',$this->address_id);
				$criteria->compare('address_desc',$this->address_desc,true);
				$criteria->compare('logistics_name',$this->logistics_name,true);
				$criteria->compare('logistics_url',$this->logistics_url,true);
				$criteria->compare('logistics_no',$this->logistics_no,true);
				$criteria->compare('shipper_name',$this->shipper_name,true);
				$criteria->compare('shipper_date',$this->shipper_date,true);
				$criteria->compare('remark',$this->remark,true);
				$criteria->compare('order_total',$this->order_total);
				$criteria->compare('order_status',$this->order_status);
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
