<?php

/**
 * This is the model class for table "fh_money_withdraw".
 *
 * The followings are the available columns in table 'fh_money_withdraw':
 * @property string $id
 * @property string $member_id
 * @property integer $poster_id
 * @property double $withdraw_money
 * @property integer $status
 * @property string $remit_time
 * @property string $create_time
 * @property string $last_modified
 */
class FhMoneyWithdrawModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_money_withdraw';
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
                        array('member_id, withdraw_money', 'required'),
                        array('poster_id, status', 'numerical', 'integerOnly'=>true),
                        array('withdraw_money', 'numerical'),
                        array('member_id', 'length', 'max'=>20),
                        array('remit_time, create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, poster_id, withdraw_money, status, remit_time, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'member_id' => '会员id',
                       'poster_id' => '海报模板id',
                       'withdraw_money' => '提现金额',
                       'status' => '状态',
                       'remit_time' => '打款时间',
                       'create_time' => '提现申请时间',
                       'last_modified' => '最后更新时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.poster_id',$this->poster_id);
				$criteria->compare('t.withdraw_money',$this->withdraw_money);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.remit_time',$this->remit_time,true);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
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
