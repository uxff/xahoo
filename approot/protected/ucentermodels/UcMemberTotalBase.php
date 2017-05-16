<?php

/**
 * This is the model class for table "uc_member_total".
 *
 * The followings are the available columns in table 'uc_member_total':
 * @property string $total_id
 * @property string $member_id
 * @property integer $total_contribute
 * @property integer $total_point
 * @property integer $total_point_consumed
 * @property double $total_reward
 * @property double $total_reward_withdraw
 * @property double $total_cash
 * @property double $total_cash_withdraw
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberTotalBase extends UCenterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_total';
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
                        array('member_id', 'required'),
                        array('total_contribute, total_point, total_point_consumed, status', 'numerical', 'integerOnly'=>true),
                        array('total_reward, total_reward_withdraw, total_cash, total_cash_withdraw, total_cash_coupon, total_cash_coupon_consumed', 'numerical'),
                        array('member_id', 'length', 'max'=>11),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('total_id, member_id, total_contribute, total_point, total_point_consumed, total_reward, total_reward_withdraw, total_cash_coupon, total_cash_coupon_consumed, total_cash, total_cash_withdraw, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'total_id' => 'Total',
                       'member_id' => 'Member',
                       'total_contribute' => 'Total Contribute',
                       'total_point' => 'Total Point',
                       'total_point_consumed' => 'Total Point Consumed',
                       'total_reward' => 'Total Reward',
                       'total_reward_withdraw' => 'Total Reward Withdraw',
                       'total_cash' => 'Total Cash',
                       'total_cash_withdraw' => 'Total Cash Withdraw',
                       'status' => 'Status',
                       'total_cash_coupon' => '现金券总额',
                       'total_cash_coupon_consumed' => '已消费现金券总额',
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

       				$criteria->compare('total_id',$this->total_id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('total_contribute',$this->total_contribute);
				$criteria->compare('total_point',$this->total_point);
				$criteria->compare('total_point_consumed',$this->total_point_consumed);
				$criteria->compare('total_reward',$this->total_reward);
				$criteria->compare('total_reward_withdraw',$this->total_reward_withdraw);
				$criteria->compare('total_cash',$this->total_cash);
				$criteria->compare('total_cash_withdraw',$this->total_cash_withdraw);
        $criteria->compare('total_cash_coupon',$this->total_cash_coupon);
        $criteria->compare('total_cash_coupon_consumed',$this->total_cash_coupon_consumed);
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
