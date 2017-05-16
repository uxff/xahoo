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
                        array('total_contribute, total_point, total_point_consumed, status', 'numerical', 'integerOnly'=>true),
                        array('total_reward, total_reward_withdraw', 'numerical'),
                        array('member_id', 'length', 'max'=>11),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('total_id, member_id, total_contribute, total_point, total_point_consumed, total_reward, total_reward_withdraw, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'total_id' => '自增编号',
                       'member_id' => '会员编号',
                       'total_contribute' => '总贡献',
                       'total_point' => '总积分',
                       'total_point_consumed' => '消费积分',
                       'total_reward' => '佣金总额',
                       'total_reward_withdraw' => '佣金提取金额',
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

       				$criteria->compare('total_id',$this->total_id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('total_contribute',$this->total_contribute);
				$criteria->compare('total_point',$this->total_point);
				$criteria->compare('total_point_consumed',$this->total_point_consumed);
				$criteria->compare('total_reward',$this->total_reward);
				$criteria->compare('total_reward_withdraw',$this->total_reward_withdraw);
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
