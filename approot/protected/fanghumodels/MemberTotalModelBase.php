<?php

/**
 * This is the model class for table "fh_member_total".
 *
 * The followings are the available columns in table 'fh_member_total':
 * @property string $id
 * @property integer $accounts_id
 * @property string $member_id
 * @property integer $points_total
 * @property integer $points_gain
 * @property integer $points_consume
 * @property integer $level
 * @property double $money_total
 * @property double $money_gain
 * @property double $money_withdraw
 * @property integer $login_times
 * @property string $last_login
 * @property string $create_time
 * @property string $last_modified
 */
class MemberTotalModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_member_total';
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
                        array('accounts_id', 'required'),
                        array('accounts_id, points_total, points_gain, points_consume, level, login_times', 'numerical', 'integerOnly'=>true),
                        array('money_total, money_gain, money_withdraw', 'numerical'),
                        array('member_id', 'length', 'max'=>11),
                        array('last_login, create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, accounts_id, member_id, points_total, points_gain, points_consume, level, money_total, money_gain, money_withdraw, login_times, last_login, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'accounts_id' => '所属公众号',
                       'member_id' => '会员id',
                       'points_total' => '积分总数',
                       'points_gain' => '获赠的积分总数',
                       'points_consume' => '消费的积分总数',
                       'level' => '会员当前等级',
                       'money_total' => '金额余额',
                       'money_gain' => '金额获得',
                       'money_withdraw' => '金额提现',
                       'login_times' => '登录次数',
                       'last_login' => '最后登录时间',
                       'create_time' => '创建时间',
                       'last_modified' => '最后修改时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.accounts_id',$this->accounts_id);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.points_total',$this->points_total);
				$criteria->compare('t.points_gain',$this->points_gain);
				$criteria->compare('t.points_consume',$this->points_consume);
				$criteria->compare('t.level',$this->level);
				$criteria->compare('t.money_total',$this->money_total);
				$criteria->compare('t.money_gain',$this->money_gain);
				$criteria->compare('t.money_withdraw',$this->money_withdraw);
				$criteria->compare('t.login_times',$this->login_times);
				$criteria->compare('t.last_login',$this->last_login,true);
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
        public function toArray() {
            return OBJTool::convertModelToArray($this);
        }
}
