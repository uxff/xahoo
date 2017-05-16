<?php

/**
 * This is the model class for table "uc_member_finance_files".
 *
 * The followings are the available columns in table 'uc_member_finance_files':
 * @property integer $file_id
 * @property integer $project_id
 * @property integer $member_id
 * @property integer $file_type
 * @property string $file_extension
 * @property string $file_path
 * @property string $create_time
 * @property string $update_time
 */
class UcMemberFinanceFilesBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_finance_files';
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
                        array('project_id, member_id, file_type', 'numerical', 'integerOnly'=>true),
                        array('file_extension', 'length', 'max'=>52),
                        array('file_path', 'length', 'max'=>512),
                        array('create_time, update_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('file_id, project_id, member_id, file_type, file_extension, file_path, create_time, update_time', 'safe', 'on'=>'search'),
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

                       'file_id' => '自增ID',
                       'project_id' => '项目ID',
                       'member_id' => '借款人',
                       'file_type' => '文件类型',
                       'file_extension' => '文件后缀',
                       'file_path' => '文件路径',
                       'create_time' => '创建时间',
                       'update_time' => '更新时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.file_id',$this->file_id);
				$criteria->compare('t.project_id',$this->project_id);
				$criteria->compare('t.member_id',$this->member_id);
				$criteria->compare('t.file_type',$this->file_type);
				$criteria->compare('t.file_extension',$this->file_extension,true);
				$criteria->compare('t.file_path',$this->file_path,true);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.update_time',$this->update_time,true);
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
