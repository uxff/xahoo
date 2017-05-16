<?php

/**
 * This is the model class for table "uc_member_contribute_log".
 *
 * The followings are the available columns in table 'uc_member_contribute_log':
 * @property string $log_id
 * @property string $member_id
 * @property string $order_id
 * @property string $order_numberid
 * @property integer $task_id
 * @property string $item_name
 * @property double $contribute_score
 * @property integer $operate_type
 * @property integer $contribute_before
 * @property integer $contribute_after
 * @property integer $status
 * @property string $source
 * @property string $create_time
 * @property string $last_modified
 * @property string $description
 */
class PmAdminLogBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'pm_admin_log';
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
                        array('admin_id', 'numerical', 'integerOnly'=>true),
                        array('description,prameter,url', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                        array('log_id, url,admin_id, description, prameter, create_time', 'safe', 'on'=>'search'),
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

                       'log_id' => '日志id',
                       'admin_id' => '管理员编号',
                       'url' => 'url',
                       'prameter' => '请求参数',
                       'description' => '描述',
               			'create_time' => '创建时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;
       			$criteria->compare('log_id',$this->log_id);
				$criteria->compare('admin_id',$this->admin_id);
				$criteria->compare('url',$this->url);
				$criteria->compare('prameter',$this->prameter,true);
				$criteria->compare('description',$this->description,true);
				$criteria->compare('create_time',$this->create_time);
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
