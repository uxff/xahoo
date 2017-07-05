<?php

/**
 * This is the model class for table "fh_pic_storage".
 *
 * The followings are the available columns in table 'fh_pic_storage':
 * @property string $id
 * @property integer $pic_set_id
 * @property integer $used_type
 * @property string $file_path
 * @property string $file_ext
 * @property string $link_url
 * @property integer $is_local
 * @property integer $is_delete
 * @property integer $weight
 * @property string $create_time
 * @property string $last_modified
 */
class PicStorageModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_pic_storage';
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
                        array('pic_set_id, used_type, file_path, file_ext', 'required'),
                        array('pic_set_id, used_type, is_local, is_delete, weight', 'numerical', 'integerOnly'=>true),
                        array('file_path, link_url', 'length', 'max'=>255),
                        array('file_ext', 'length', 'max'=>10),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, pic_set_id, used_type, file_path, file_ext, link_url, is_local, is_delete, weight, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => '序号',
                       'pic_set_id' => '所属图库id',
                       'used_type' => '使用类型',
                       'file_path' => '文件路径',
                       'file_ext' => '文件类型',
                       'link_url' => '链接地址',
                       'is_local' => '是否是本服务器路径',
                       'is_delete' => '是否删除',
                       'weight' => '排序值:越小越靠前',
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
				$criteria->compare('t.pic_set_id',$this->pic_set_id);
				$criteria->compare('t.used_type',$this->used_type);
				$criteria->compare('t.file_path',$this->file_path,true);
				$criteria->compare('t.file_ext',$this->file_ext,true);
				$criteria->compare('t.link_url',$this->link_url,true);
				$criteria->compare('t.is_local',$this->is_local);
				$criteria->compare('t.is_delete',$this->is_delete);
				$criteria->compare('t.weight',$this->weight);
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
