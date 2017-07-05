<?php

/**
 * This is the model class for table "fh_article_oper_log".
 *
 * The followings are the available columns in table 'fh_article_oper_log':
 * @property string $id
 * @property string $article_id
 * @property integer $old_status
 * @property integer $new_status
 * @property integer $has_online_status
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $oper_time
 * @property string $create_time
 * @property string $last_modified
 */
class ArticleOperLogModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_article_oper_log';
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
                        array('article_id, new_status', 'required'),
                        array('old_status, new_status, has_online_status, admin_id', 'numerical', 'integerOnly'=>true),
                        array('article_id', 'length', 'max'=>10),
                        array('admin_name', 'length', 'max'=>32),
                        array('create_time, oper_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, article_id, old_status, new_status, has_online_status, admin_id, admin_name, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'old_status' => '旧的状态',
                       'new_status' => '新状态',
                       'has_online_status' => '是否相关上线操作',
                       'admin_id' => '操作人id',
                       'admin_name' => '操作人',
                       'oper_time' => '创建时间',
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
				$criteria->compare('t.article_id',$this->article_id,true);
				$criteria->compare('t.old_status',$this->old_status);
				$criteria->compare('t.new_status',$this->new_status);
				$criteria->compare('t.has_online_status',$this->has_online_status);
				$criteria->compare('t.admin_id',$this->admin_id);
				$criteria->compare('t.admin_name',$this->admin_name,true);
				$criteria->compare('t.oper_time',$this->oper_time,true);
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
