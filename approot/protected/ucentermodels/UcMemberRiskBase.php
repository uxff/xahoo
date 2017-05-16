<?php

/**
 * This is the model class for table "uc_member_risk".
 *
 * The followings are the available columns in table 'uc_member_risk':
 * @property integer $risk_id
 * @property integer $member_id
 * @property integer $card_check_status
 * @property integer $work_check_status
 * @property integer $credit_check_status
 * @property integer $income_check_status
 * @property string $desc
 * @property string $credit
 * @property string $operate_date
 * @property integer $member_company_type
 */
class UcMemberRiskBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_risk';
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
                        array('desc', 'required'),
                        array('member_id, card_check_status, work_check_status, credit_check_status, income_check_status,member_company_type', 'numerical', 'integerOnly'=>true),
                        array('credit', 'length', 'max'=>4),
                        array('operate_date', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('risk_id, member_id, card_check_status, work_check_status, credit_check_status, income_check_status, desc, credit, operate_date,member_company_type', 'safe', 'on'=>'search'),
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

                       'risk_id' => '自增ID',
                       'member_id' => '会员ID',
                       'card_check_status' => '身份证审核',
                       'work_check_status' => '工作审核',
                       'credit_check_status' => '信用审核',
                       'income_check_status' => '收入审核',
                       // 'desc' => '备注',
                       'credit' => '信用等级',
                       // 'operate_date' => '操作时间',
                       'member_company_type' => '类型',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.risk_id',$this->risk_id);
				$criteria->compare('t.member_id',$this->member_id);
				$criteria->compare('t.card_check_status',$this->card_check_status);
				$criteria->compare('t.work_check_status',$this->work_check_status);
				$criteria->compare('t.credit_check_status',$this->credit_check_status);
				$criteria->compare('t.income_check_status',$this->income_check_status);
				// $criteria->compare('t.desc',$this->desc,true);
				$criteria->compare('t.credit',$this->credit);
				// $criteria->compare('t.operate_date',$this->operate_date,true);
        $criteria->compare('t.member_company_type',$this->member_company_type);
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
