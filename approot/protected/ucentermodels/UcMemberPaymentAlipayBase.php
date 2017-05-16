<?php

/**
 * This is the model class for table "uc_member_payment_alipay".
 *
 * The followings are the available columns in table 'uc_member_payment_alipay':
 * @property string $payment_id
 * @property integer $order_id
 * @property string $subject
 * @property string $body
 * @property double $total_fee
 * @property string $trade_status
 * @property string $exterface
 * @property string $trade_no
 * @property string $buyer_email
 * @property string $buyer_id
 * @property string $out_trade_no
 * @property string $payment_type
 * @property string $seller_id
 * @property string $notify_id
 * @property string $notify_time
 * @property string $notify_type
 * @property string $agent_user_id
 * @property string $extra_common_param
 * @property integer $ipn_mode
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberPaymentAlipayBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_payment_alipay';
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
                        array('order_id, ipn_mode, status', 'numerical', 'integerOnly'=>true),
                        array('total_fee', 'numerical'),
                        array('subject, body, trade_status, exterface, trade_no, buyer_email, buyer_id, out_trade_no, payment_type, seller_id, notify_id, notify_type, agent_user_id, extra_common_param', 'length', 'max'=>255),
                        array('notify_time, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('payment_id, order_id, subject, body, total_fee, trade_status, exterface, trade_no, buyer_email, buyer_id, out_trade_no, payment_type, seller_id, notify_id, notify_time, notify_type, agent_user_id, extra_common_param, ipn_mode, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'payment_id' => 'Payment',
                       'order_id' => 'Order ID',
                       'subject' => 'Subject',
                       'body' => 'Body',
                       'total_fee' => 'Total Fee',
                       'trade_status' => 'Trade Status',
                       'exterface' => 'Exterface',
                       'trade_no' => 'Trade No',
                       'buyer_email' => 'Buyer Email',
                       'buyer_id' => 'Buyer',
                       'out_trade_no' => 'Out Trade No',
                       'payment_type' => 'Payment Type',
                       'seller_id' => 'Seller',
                       'notify_id' => 'Notify',
                       'notify_time' => 'Notify Time',
                       'notify_type' => 'Notify Type',
                       'agent_user_id' => 'Agent User',
                       'extra_common_param' => 'Extra Common Param',
                       'ipn_mode' => 'Ipn Mode',
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

       				$criteria->compare('payment_id',$this->payment_id,true);
				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('subject',$this->subject,true);
				$criteria->compare('body',$this->body,true);
				$criteria->compare('total_fee',$this->total_fee);
				$criteria->compare('trade_status',$this->trade_status,true);
				$criteria->compare('exterface',$this->exterface,true);
				$criteria->compare('trade_no',$this->trade_no,true);
				$criteria->compare('buyer_email',$this->buyer_email,true);
				$criteria->compare('buyer_id',$this->buyer_id,true);
				$criteria->compare('out_trade_no',$this->out_trade_no,true);
				$criteria->compare('payment_type',$this->payment_type,true);
				$criteria->compare('seller_id',$this->seller_id,true);
				$criteria->compare('notify_id',$this->notify_id,true);
				$criteria->compare('notify_time',$this->notify_time,true);
				$criteria->compare('notify_type',$this->notify_type,true);
				$criteria->compare('agent_user_id',$this->agent_user_id,true);
				$criteria->compare('extra_common_param',$this->extra_common_param,true);
				$criteria->compare('ipn_mode',$this->ipn_mode);
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
