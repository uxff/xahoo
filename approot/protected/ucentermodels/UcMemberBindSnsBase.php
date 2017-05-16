<?php

/**
 * This is the model class for table "uc_member_bind_sns".
 *
 * The followings are the available columns in table 'uc_member_bind_sns':
 * @property string $bind_id
 * @property string $member_id
 * @property string $member_mobile
 * @property string $sns_id
 * @property string $sns_appid
 * @property integer $sns_source
 * @property integer $status
 * @property string $location_address
 * @property string $create_time
 * @property string $last_modified
 */
Yii::import('application.ucentermob.components.UCenterActiveRecord');

class UcMemberBindSnsBase extends UCenterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_bind_sns';
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
                        array('sns_id', 'required'),
                        array('sns_source, status', 'numerical', 'integerOnly'=>true),
                        array('member_id', 'length', 'max'=>11),
                        array('member_mobile', 'length', 'max'=>20),
                        array('sns_id, sns_appid', 'length', 'max'=>255),
                        array('location_address', 'length', 'max'=>120),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('bind_id, member_id, member_mobile, sns_id, sns_appid, sns_source, status, location_address, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'bind_id' => 'Bind',
                       'member_id' => 'Member',
                       'member_mobile' => 'Member Mobile',
                       'sns_id' => 'Sns',
                       'sns_appid' => 'Sns Appid',
                       'sns_source' => 'Sns Source',
                       'status' => 'Status',
                       'location_address' => 'Location Address',
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

       				$criteria->compare('t.bind_id',$this->bind_id,true);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.member_mobile',$this->member_mobile,true);
				$criteria->compare('t.sns_id',$this->sns_id,true);
				$criteria->compare('t.sns_appid',$this->sns_appid,true);
				$criteria->compare('t.sns_source',$this->sns_source);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.location_address',$this->location_address,true);
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
