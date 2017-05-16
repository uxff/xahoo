<?php

/**
 * This is the model class for table "fh_article_visit_log".
 *
 * The followings are the available columns in table 'fh_article_visit_log':
 * @property string $id
 * @property string $article_id
 * @property string $article_url
 * @property integer $plat_type
 * @property string $visitor_ip_u
 * @property string $visitor_ip_s
 * @property string $visitor_mid
 * @property string $use_invite_code
 * @property string $create_time
 * @property string $last_modified
 */
class ArticleVisitLogModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_article_visit_log';
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
                        array('article_id, article_url, plat_type, visitor_ip_u, visitor_ip_s', 'required'),
                        array('plat_type', 'numerical', 'integerOnly'=>true),
                        array('article_id, visitor_ip_u, visitor_mid, use_invite_code', 'length', 'max'=>10),
                        array('article_url', 'length', 'max'=>255),
                        array('visitor_ip_s', 'length', 'max'=>16),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, article_id, article_url, plat_type, visitor_ip_u, visitor_ip_s, visitor_mid, use_invite_code, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'article_url' => '文章地址',
                       'plat_type' => '分享平台',
                       'visitor_ip_u' => '访问者id',
                       'visitor_ip_s' => '访问者ip字符串',
                       'visitor_mid' => '访问者用户id',
                       'use_invite_code' => '使用的邀请码',
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
				$criteria->compare('t.article_id',$this->article_id,true);
				$criteria->compare('t.article_url',$this->article_url,true);
				$criteria->compare('t.plat_type',$this->plat_type);
				$criteria->compare('t.visitor_ip_u',$this->visitor_ip_u,true);
				$criteria->compare('t.visitor_ip_s',$this->visitor_ip_s,true);
				$criteria->compare('t.visitor_mid',$this->visitor_mid,true);
				$criteria->compare('t.use_invite_code',$this->use_invite_code,true);
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
