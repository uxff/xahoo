<?php

/**
 * This is the model class for table "fh_points_level".
 *
 * The followings are the available columns in table 'fh_points_level':
 * @property integer $level_id
 * @property integer $min_points
 * @property integer $max_points
 * @property string $name
 * @property string $desc
 * @property string $thumb_url
 * @property string $title
 * @property string $title2
 * @property string $create_time
 * @property string $last_modified
 */
class PointsLevelModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_points_level';
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
                        array('last_modified', 'required'),
                        array('min_points, max_points', 'numerical', 'integerOnly'=>true),
                        array('name, title, title2', 'length', 'max'=>40),
                        array('desc, thumb_url', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('level_id, min_points, max_points, name, desc, thumb_url, title, title2, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'level_id' => '等级id',
                       'min_points' => '等级最少需要的积分',
                       'max_points' => '等级需要的最多积分',
                       'name' => '等级名称',
                       'desc' => '等级描述',
                       'thumb_url' => '显示缩略图',
                       'title' => '等级头衔',
                       'title2' => '等级头衔2',
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

       				$criteria->compare('t.level_id',$this->level_id);
				$criteria->compare('t.min_points',$this->min_points);
				$criteria->compare('t.max_points',$this->max_points);
				$criteria->compare('t.name',$this->name,true);
				$criteria->compare('t.desc',$this->desc,true);
				$criteria->compare('t.thumb_url',$this->thumb_url,true);
				$criteria->compare('t.title',$this->title,true);
				$criteria->compare('t.title2',$this->title2,true);
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
