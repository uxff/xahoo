<?php

/**
 * This is the model class for table "fh_activity_lottery".
 *
 * The followings are the available columns in table 'fh_activity_lottery':
 * @property integer $id
 * @property string $member_id
 * @property string $member_mobile
 * @property string $member_name
 * @property string $prize
 * @property integer $product_id
 * @property integer $integral
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class FhActivityLotteryModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_activity_lottery';
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
                        array('member_id, member_mobile, integral', 'required'),
                        array('product_id, integral, status', 'numerical', 'integerOnly'=>true),
                        array('member_id', 'length', 'max'=>10),
                        array('member_mobile, member_name', 'length', 'max'=>20),
                        array('prize', 'length', 'max'=>50),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, member_mobile, member_name, prize, product_id, integral, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => 'ID',
                       'member_id' => '用户id',
                       'member_mobile' => '手机号码',
                       'member_name' => '用户昵称',
                       'prize' => '奖品',
                       'product_id' => '奖品id',
                       'integral' => '消耗积分',
                       'status' => '中奖状态',
                       'create_time' => '抽奖时间',
                       'last_modified' => '最后修改时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.member_mobile',$this->member_mobile,true);
				$criteria->compare('t.member_name',$this->member_name,true);
				$criteria->compare('t.prize',$this->prize,true);
				$criteria->compare('t.product_id',$this->product_id);
				$criteria->compare('t.integral',$this->integral);
				$criteria->compare('t.status',$this->status);
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
