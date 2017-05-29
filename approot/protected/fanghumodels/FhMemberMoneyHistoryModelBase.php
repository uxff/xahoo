<?php

/**
 * This is the model class for table "fh_member_money_history".
 *
 * The followings are the available columns in table 'fh_member_money_history':
 * @property string $id
 * @property integer $accounts_id
 * @property string $eid
 * @property string $member_id
 * @property double $money
 * @property integer $type
 * @property string $remark
 * @property string $create_time
 * @property string $last_modified
 */
class FhMemberMoneyHistoryModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_member_money_history';
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
                        array('accounts_id, member_id, money', 'required'),
                        array('accounts_id, type', 'numerical', 'integerOnly'=>true),
                        array('money', 'numerical'),
                        array('eid', 'length', 'max'=>16),
                        array('member_id', 'length', 'max'=>11),
                        array('remark', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, accounts_id, eid, member_id, money, type, remark, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'eid' => '事项标记',
                       'member_id' => '会员id',
                       'money' => '金额',
                       'type' => '金额操作类型',
                       'remark' => '备注',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更改时间',
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
				$criteria->compare('t.eid',$this->eid,true);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.money',$this->money);
				$criteria->compare('t.type',$this->type);
				$criteria->compare('t.remark',$this->remark,true);
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
