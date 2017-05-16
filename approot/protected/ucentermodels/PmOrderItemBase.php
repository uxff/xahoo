<?php

/**
 * This is the model class for table "pm_order_item".
 *
 * The followings are the available columns in table 'pm_order_item':
 * @property string $order_item_id
 * @property integer $order_id
 * @property integer $item_id
 * @property string $item_name
 * @property integer $item_quantity
 * @property double $item_price
 * @property double $final_price
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class PmOrderItemBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'pm_order_item';
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
                        array('order_id, item_id, item_quantity, status', 'numerical', 'integerOnly'=>true),
                        array('item_price, final_price', 'numerical'),
                        array('item_name', 'length', 'max'=>200),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('order_item_id, order_id, item_id, item_name, item_quantity, item_price, final_price, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'order_item_id' => '自动编号',
                       'order_id' => '订单ID',
                       'item_id' => '商品ID',
                       'item_name' => '商品名',
                       'item_quantity' => '商品数量',
                       'item_price' => '商品价格',
                       'final_price' => '下单价格',
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

       				$criteria->compare('order_item_id',$this->order_item_id,true);
				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('item_id',$this->item_id);
				$criteria->compare('item_name',$this->item_name,true);
				$criteria->compare('item_quantity',$this->item_quantity);
				$criteria->compare('item_price',$this->item_price);
				$criteria->compare('final_price',$this->final_price);
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
