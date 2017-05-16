<?php

/**
 * This is the model class for table "uc_trading_platform_log".
 *
 * The followings are the available columns in table 'uc_trading_platform_log':
 * @property string $id
 * @property string $member_id
 * @property string $real_name
 * @property integer $platform_type
 * @property string $platform_account
 * @property string $member_mobile
 * @property integer $status
 * @property string $create_time
 */
class UcTradingPlatformLogBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_trading_platform_log';
        }
        public function init() {
                //$this->ares_register_behaviors();
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
                        array('platform_type, status', 'numerical', 'integerOnly'=>true),
                        array('member_id', 'length', 'max'=>11),
                        array('real_name', 'length', 'max'=>20),
                        array('platform_account', 'length', 'max'=>30),
                        array('member_mobile', 'length', 'max'=>16),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, real_name, platform_type, platform_account, member_mobile, status, create_time', 'safe', 'on'=>'search'),
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

                       'id' => '支付平编号',
                       'member_id' => '会员帐号',
                       'real_name' => '会员真实姓名',
                       'platform_type' => '支付平台类型',
                       'platform_account' => '支付平台帐号',
                       'member_mobile' => '会员手机帐号',
                       'status' => '状态',
                       'create_time' => '添加时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('id',$this->id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('real_name',$this->real_name,true);
				$criteria->compare('platform_type',$this->platform_type);
				$criteria->compare('platform_account',$this->platform_account,true);
				$criteria->compare('member_mobile',$this->member_mobile,true);
				$criteria->compare('status',$this->status);
				$criteria->compare('create_time',$this->create_time,true);
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
