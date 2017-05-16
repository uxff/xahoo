<?php

/**
 * This is the model class for table "fq_fenquan_payment_yeepay".
 *
 * The followings are the available columns in table 'fq_fenquan_payment_yeepay':
 * @property integer $payment_id
 * @property string $requestid
 * @property integer $member_id
 * @property integer $project_id
 * @property string $subject
 * @property string $body
 * @property string $merchantaccount
 * @property string $orderid
 * @property string $yborderid
 * @property double $amount
 * @property string $identityid
 * @property integer $card_top
 * @property integer $card_last
 * @property integer $status
 * @property string $errorcode
 * @property string $errormsg
 * @property string $sign
 * @property string $last_modified
 * @property string $create_time
 */
class ZcPaymentYeepayBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'zc_payment_yeepay';
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
                        array('create_time', 'required'),
                        array('member_id, project_id, card_top, card_last, status', 'numerical', 'integerOnly'=>true),
                        array('amount', 'numerical'),
                        array('requestid, yborderid, identityid, errorcode', 'length', 'max'=>30),
                        array('subject', 'length', 'max'=>60),
                        array('body, errormsg', 'length', 'max'=>120),
                        array('merchantaccount', 'length', 'max'=>50),
                        array('orderid', 'length', 'max'=>13),
                        array('sign', 'length', 'max'=>32),
                        array('last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('payment_id, requestid, member_id, project_id, subject, body, merchantaccount, orderid, yborderid, amount, identityid, card_top, card_last, status, errorcode, errormsg, sign, last_modified, create_time', 'safe', 'on'=>'search'),
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

                       'payment_id' => '交易记录编号',
                       'requestid' => '请求流水号',
                       'member_id' => '用户编号',
                       'project_id' => '商品编号',
                       'subject' => '商品名称',
                       'body' => '商品描述',
                       'merchantaccount' => '商户编号',
                       'orderid' => '商户订单号',
                       'yborderid' => '易宝交易流水号',
                       'amount' => '交易金额',
                       'identityid' => '用户标识',
                       'card_top' => '卡号前6 位',
                       'card_last' => '卡号前4 位',
                       'status' => '支付状态，0：失败，1成功',
                       'errorcode' => '错误码',
                       'errormsg' => '错误信息',
                       'sign' => '签名',
                       'last_modified' => '最后修改时间',
                       'create_time' => '生成时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.payment_id',$this->payment_id);
				$criteria->compare('t.requestid',$this->requestid,true);
				$criteria->compare('t.member_id',$this->member_id);
				$criteria->compare('t.project_id',$this->project_id);
				$criteria->compare('t.subject',$this->subject,true);
				$criteria->compare('t.body',$this->body,true);
				$criteria->compare('t.merchantaccount',$this->merchantaccount,true);
				$criteria->compare('t.orderid',$this->orderid,true);
				$criteria->compare('t.yborderid',$this->yborderid,true);
				$criteria->compare('t.amount',$this->amount);
				$criteria->compare('t.identityid',$this->identityid,true);
				$criteria->compare('t.card_top',$this->card_top);
				$criteria->compare('t.card_last',$this->card_last);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.errorcode',$this->errorcode,true);
				$criteria->compare('t.errormsg',$this->errormsg,true);
				$criteria->compare('t.sign',$this->sign,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
				$criteria->compare('t.create_time',$this->create_time,true);
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
