<?php

/**
 * This is the model class for table "fh_pic_set".
 *
 * The followings are the available columns in table 'fh_pic_set':
 * @property string $id
 * @property string $title
 * @property integer $type
 * @property integer $used_type
 * @property integer $circle_sec
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 * @property integer $author_id
 * @property string $author_name
 */
class PicSetModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_pic_set';
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
                        array('title, used_type, type, author_id, author_name', 'required'),
                        array('used_type, type, circle_sec, status, author_id', 'numerical', 'integerOnly'=>true),
                        array('title', 'length', 'max'=>255),
                        array('author_name', 'length', 'max'=>32),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, title, used_type, type, circle_sec, status, create_time, last_modified, author_id, author_name', 'safe', 'on'=>'search'),
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
                       'title' => '图片标题',
                       'used_type' => '使用类型',
                       'type' => '图片类型',
                       'circle_sec' => '轮播间隔',
                       //'status' => '状态',
                       'author_name' => '创建人',
                       'create_time' => '创建时间',
                       'last_modified' => '最后修改时间',
                       //'author_id' => '创建人id',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

                 	$criteria->compare('t.id',$this->id,true);
          				$criteria->compare('t.title',$this->title,true);
          				$criteria->compare('t.used_type',$this->used_type);
          				$criteria->compare('t.type',$this->type);
          				$criteria->compare('t.circle_sec',$this->circle_sec);
          				$criteria->compare('t.status',$this->status);
          				$criteria->compare('t.create_time',$this->create_time,true);
          				$criteria->compare('t.last_modified',$this->last_modified,true);
          				$criteria->compare('t.author_id',$this->author_id);
          				$criteria->compare('t.author_name',$this->author_name,true);
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
