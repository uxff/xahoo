<?php

/**
 * This is the model class for table "fh_poster_accounts_log".
 *
 * The followings are the available columns in table 'fh_poster_accounts_log':
 * @property integer $id
 * @property integer $pid
 * @property string $username
 * @property integer $userid
 * @property string $userflag
 * @property string $desc
 * @property string $create_time
 * @property string $last_modified
 */
class FhPosterAccountsLogModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_poster_accounts_log';
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
                        array('pid, username, userid, userflag', 'required'),
                        array('pid, userid', 'numerical', 'integerOnly'=>true),
                        array('username', 'length', 'max'=>40),
                        array('userflag', 'length', 'max'=>80),
                        array('desc', 'length', 'max'=>255),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, pid, username, userid, userflag, desc, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'pid' => '公众号ID',
                       'username' => '操作人',
                       'userid' => '操作人ID',
                       'userflag' => '操作人角色',
                       'desc' => '详细操作说明',
                       'create_time' => '创建时间',
                       'last_modified' => '最后操作时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id);
				$criteria->compare('t.pid',$this->pid);
				$criteria->compare('t.username',$this->username,true);
				$criteria->compare('t.userid',$this->userid);
				$criteria->compare('t.userflag',$this->userflag,true);
				$criteria->compare('t.desc',$this->desc,true);
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
