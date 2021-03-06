<?php

/**
 * This is the model class for table "fh_stastic_article".
 *
 * The followings are the available columns in table 'fh_stastic_article':
 * @property integer $id
 * @property integer $article_id
 * @property string $title
 * @property string $date
 * @property integer $pv
 * @property integer $uv
 * @property integer $share_count
 * @property string $create_time
 * @property string $last_modified
 */
class StasticArticleModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_stastic_article';
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
                        array('article_id', 'required'),
                        array('article_id, pv, uv, share_count', 'numerical', 'integerOnly'=>true),
                        array('title', 'length', 'max'=>255),
                        array('date, create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, article_id, title, date, pv, uv, share_count, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'article_id' => '文章id',
                       'title' => '文章标题',
                       'date' => '统计日期',
                       'pv' => 'PV',
                       'uv' => 'UV',
                       'share_count' => '转发量',
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

       				$criteria->compare('t.id',$this->id);
				$criteria->compare('t.article_id',$this->article_id);
				$criteria->compare('t.title',$this->title,true);
				$criteria->compare('t.date',$this->date,true);
				$criteria->compare('t.pv',$this->pv);
				$criteria->compare('t.uv',$this->uv);
				$criteria->compare('t.share_count',$this->share_count);
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
