<?php

/**
 * This is the model class for table "fh_poster_accounts".
 *
 * The followings are the available columns in table 'fh_poster_accounts':
 * @property integer $id
 * @property string $accounts_name
 * @property string $token
 * @property string $appid
 * @property string $appsecret
 * @property string $EncodingAESKey
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class FhPosterAccountsModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_poster_accounts';
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
                        array('accounts_name, token, appid, appsecret, create_time', 'required'),
                        array('status', 'numerical', 'integerOnly'=>true),
                        array('accounts_name, token', 'length', 'max'=>80),
                        array('appid', 'length', 'max'=>100),
                        array('appsecret, EncodingAESKey', 'length', 'max'=>180),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, accounts_name, token, appid, appsecret, EncodingAESKey, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => 'id',
                       'accounts_name' => '公众号名称',
                       'token' => '公众号token',
                       'appid' => 'appid',
                       'appsecret' => 'appsecret',
                       'EncodingAESKey' => 'EncodingAESKey',
                       'status' => '状态:1=未确认,2=已确认,9=无效',
                       'create_time' => '创建时间',
                       'last_modified' => '更新时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id);
				$criteria->compare('t.accounts_name',$this->accounts_name,true);
				$criteria->compare('t.token',$this->token,true);
				$criteria->compare('t.appid',$this->appid,true);
				$criteria->compare('t.appsecret',$this->appsecret,true);
				$criteria->compare('t.EncodingAESKey',$this->EncodingAESKey,true);
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
