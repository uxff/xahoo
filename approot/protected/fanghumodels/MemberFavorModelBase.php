<?php

/**
 * This is the model class for table "fh_member_favor".
 *
 * The followings are the available columns in table 'fh_member_favor':
 * @property string $id
 * @property string $member_id
 * @property string $article_id
 * @property string $article_url
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class MemberFavorModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_member_favor';
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
                        array('member_id, article_id, article_url, status', 'required'),
                        array('status', 'numerical', 'integerOnly'=>true),
                        array('member_id, article_id', 'length', 'max'=>10),
                        array('article_url', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, article_id, article_url, status, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'member_id' => '用户id',
                       'article_id' => '文章id',
                       'article_url' => '文章地址',
                       'status' => '状态:1=有效',
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

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.article_id',$this->article_id,true);
				$criteria->compare('t.article_url',$this->article_url,true);
				$criteria->compare('t.status',$this->status);
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
