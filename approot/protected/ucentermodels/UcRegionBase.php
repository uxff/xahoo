<?php

/**
 * This is the model class for table "uc_region".
 *
 * The followings are the available columns in table 'uc_region':
 * @property integer $sys_region_id
 * @property integer $parent_id
 * @property string $sys_region_lang
 * @property string $sys_region_name
 * @property integer $sys_region_level
 * @property integer $sys_region_index
 * @property string $phone_code
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcRegionBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_region';
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
                        array('parent_id, sys_region_level, sys_region_index, status', 'numerical', 'integerOnly'=>true),
                        array('sys_region_lang, sys_region_name, phone_code', 'length', 'max'=>50),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('sys_region_id, parent_id, sys_region_lang, sys_region_name, sys_region_level, sys_region_index, phone_code, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'sys_region_id' => '主键',
                       'parent_id' => '省市父级id',
                       'sys_region_lang' => '语言',
                       'sys_region_name' => '省市区名称',
                       'sys_region_level' => '省市区分级 ',
                       'sys_region_index' => '数据上级ID',
                       'phone_code' => '电话区号',
                       'status' => '状态',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('sys_region_id',$this->sys_region_id);
				$criteria->compare('parent_id',$this->parent_id);
				$criteria->compare('sys_region_lang',$this->sys_region_lang,true);
				$criteria->compare('sys_region_name',$this->sys_region_name,true);
				$criteria->compare('sys_region_level',$this->sys_region_level);
				$criteria->compare('sys_region_index',$this->sys_region_index);
				$criteria->compare('phone_code',$this->phone_code,true);
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
