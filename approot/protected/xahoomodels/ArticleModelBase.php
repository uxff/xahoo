<?php

/**
 * This is the model class for table "fh_article".
 *
 * The followings are the available columns in table 'fh_article':
 * @property string $id
 * @property string $title
 * @property integer $type
 * @property string $content
 * @property string $outer_url
 * @property string $visit_url
 * @property string $surface_url
 * @property string $abstract
 * @property integer $status
 * @property string $remark
 * @property string $view_count
 * @property string $share_count
 * @property string $favor_count
 * @property string $comment_count
 * @property string $create_time
 * @property string $last_modified
 * @property integer $admin_id
 * @property string $admin_name
 */
class ArticleModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_article';
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
                        array('title, content, status, admin_id, admin_name', 'required'),
                        array('type, status, admin_id', 'numerical', 'integerOnly'=>true),
                        array('title, outer_url, visit_url, surface_url, remark', 'length', 'max'=>255),
                        array('abstract', 'length', 'max'=>500),
                        array('view_count, share_count, favor_count, comment_count, origin', 'length', 'max'=>10),
                        array('admin_name', 'length', 'max'=>32),
                        array('create_time, pubdate', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, title, type, content, outer_url, visit_url, surface_url, abstract, status, remark, view_count, share_count, favor_count, comment_count, pubdate, create_time, last_modified, admin_id, admin_name, origin', 'safe', 'on'=>'search'),
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

                       'id' => '活动ID',
                       'title' => '活动名称',
                       'type' => '活动分类',
                       'content' => '活动详情',
                       'outer_url' => '使用外部链接',
                       'visit_url' => 'URL',
                       //'abstract' => 'Abstract',
                       //'status' => '活动状态',
                       //'remark' => '备注',
                       //'view_count' => 'View Count',
                       //'share_count' => 'Share Count',
                       //'favor_count' => 'Favor Count',
                       //'comment_count' => 'Comment Count',
                       'admin_name' => '创建人',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
                       //'admin_id' => '创建人id',
               );
       }
       /**
        * @return array customized attribute labels (name=>label)
        */
       public function attrLabelsForList()
       {
               return array(

                       'id' => '序号',
                       'title' => '活动名称',
                       'visit_url' => '活动URL',
                       'type' => '活动分类',
                       //'content' => '活动详情',
                       //'visit_url' => 'Visit Url',
                       //'abstract' => 'Abstract',
                       //'status' => '活动状态',
                       //'remark' => '备注',
                       //'view_count' => 'View Count',
                       //'share_count' => 'Share Count',
                       //'favor_count' => 'Favor Count',
                       //'comment_count' => 'Comment Count',
                       'admin_name' => '创建人',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
                       //'admin_id' => '创建人id',
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
				$criteria->compare('t.type',$this->type);
				$criteria->compare('t.content',$this->content,true);
				$criteria->compare('t.outer_url',$this->outer_url,true);
				$criteria->compare('t.visit_url',$this->visit_url,true);
				$criteria->compare('t.surface_url',$this->surface_url,true);
				$criteria->compare('t.abstract',$this->abstract,true);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.remark',$this->remark,true);
				$criteria->compare('t.view_count',$this->view_count,true);
				$criteria->compare('t.share_count',$this->share_count,true);
				$criteria->compare('t.favor_count',$this->favor_count,true);
				$criteria->compare('t.pubdate',$this->pubdate,true);
				$criteria->compare('t.comment_count',$this->comment_count,true);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
				$criteria->compare('t.admin_id',$this->admin_id);
				$criteria->compare('t.admin_name',$this->admin_name,true);
				$criteria->compare('t.origin',$this->origin,true);
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
