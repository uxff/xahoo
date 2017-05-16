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
class PmStorageBase extends CActiveRecord
{
	
	
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'pm_storage';
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
                        array('product_id,is_write,storage_id, admin_id, storage_num, status', 'numerical', 'integerOnly'=>true),
                        array('create_time, last_modified', 'safe'),
                        array('product_id,is_write,storage_time,storage_id, admin_id, storage_num, status, create_time, last_modified', 'safe', 'on'=>'search'),
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
               // 'orderitems' => array(self::HAS_MANY, 'PmOrderItem', '', 'on' => 'orderitems.member_id = t.member_id'),
               );
       }        
       /**
        * @return array customized attribute labels (name=>label)
        */
       public function attributeLabels()
       {
               return array(
                       'storage_id' => '入库ID',
                       'admin_id' => '录入人',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
               			'status' => '状态',
               			'storage_time' => '入库时间',
               			'is_write' => '是否入库',
               			'product_id' => '商品ID',
               			'storage_num' => '入库数',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       			$criteria->compare('storage_id',$this->storage_id);
       			$criteria->compare('product_id',$this->product_id);
				$criteria->compare('admin_id',$this->admin_id);
				$criteria->compare('storage_num',$this->storage_num,true);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('is_write',$this->is_write);
				$criteria->compare('storage_time',$this->storage_time);
				$criteria->compare('create_time',$this->create_time,true);
				$criteria->compare('last_modified',$this->last_modified,true);
				//if ($this->is_write)$criteria->join = 'LEFT JOIN users ON users.id=authorID'; 
				
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
