<?php

/**
 * This is the model class for table "uc_member_lottery_order".
 *
 * The followings are the available columns in table 'uc_member_lottery_order':
 * @property string $order_id
 * @property string $member_id
 * @property string $member_phone
 * @property integer $award_level
 * @property string $award_title
 * @property integer $is_received
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberLotteryOrderBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_lottery_order';
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
                        array('award_level, is_received, status', 'numerical', 'integerOnly'=>true),
                        array('member_id', 'length', 'max'=>11),
                        array('member_phone', 'length', 'max'=>20),
                        array('award_title', 'length', 'max'=>255),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('order_id, member_id, member_phone, award_level, award_title, is_received, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'order_id' => '编号',
                       'member_id' => '用户ID',
                       'member_phone' => '用户手机号',
                       'award_level' => '奖项等级1|一等奖,2|二等奖,3|三等奖,4|四等奖,5|五等奖,6|六等奖',
                       'award_title' => '奖项名称',
                       'is_received' => '是否领取',
                       'status' => '状态',
                       'create_time' => '创建时间',
                       'last_modified' => '修改时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.order_id',$this->order_id,true);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.member_phone',$this->member_phone,true);
				$criteria->compare('t.award_level',$this->award_level);
				$criteria->compare('t.award_title',$this->award_title,true);
				$criteria->compare('t.is_received',$this->is_received);
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
