<?php

/**
 * This is the model class for table "task_project".
 *
 * The followings are the available columns in table 'task_project':
 * @property string $project_id
 * @property string $project_name
 * @property string $project_homeurl
 * @property string $project_appkey
 * @property string $project_appsecret
 */
class TaskProjectBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'task_project';
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
                        array('project_name', 'length', 'max'=>20),
                        array('project_homeurl, project_appkey, project_appsecret', 'length', 'max'=>100),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('project_id, project_name, project_homeurl, project_appkey, project_appsecret', 'safe', 'on'=>'search'),
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

                       'project_id' => 'Project',
                       'project_name' => 'Project Name',
                       'project_homeurl' => 'Project Homeurl',
                       'project_appkey' => 'Project Appkey',
                       'project_appsecret' => 'Project Appsecret',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('project_id',$this->project_id,true);
				$criteria->compare('project_name',$this->project_name,true);
				$criteria->compare('project_homeurl',$this->project_homeurl,true);
				$criteria->compare('project_appkey',$this->project_appkey,true);
				$criteria->compare('project_appsecret',$this->project_appsecret,true);
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
