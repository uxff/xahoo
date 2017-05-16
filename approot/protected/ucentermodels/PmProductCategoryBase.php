<?php

/**
 * This is the model class for table "pm_product_category".
 *
 * The followings are the available columns in table 'pm_product_category':
 * @property integer $category_id
 * @property string $category_name
 * @property string $category_img_url
 * @property integer $parent_id
 * @property string $category_desc
 * @property integer $is_visible
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class PmProductCategoryBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'pm_product_category';
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
                        array('category_desc', 'required'),
                        array('parent_id, is_visible, status', 'numerical', 'integerOnly'=>true),
                        array('category_name, category_img_url', 'length', 'max'=>255),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('category_id, category_name, category_img_url, parent_id, category_desc, is_visible, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'category_id' => '分类id',
                       'category_name' => '分类名称',
                       // 'category_img_url' => '分类img',
                       // 'parent_id' => '分类父类ID',
                       // 'category_desc' => '分类描述',
                       'is_visible' => '是否显示',
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

       				$criteria->compare('category_id',$this->category_id);
				$criteria->compare('category_name',$this->category_name,true);
				$criteria->compare('category_img_url',$this->category_img_url,true);
				$criteria->compare('parent_id',$this->parent_id);
				$criteria->compare('category_desc',$this->category_desc,true);
				$criteria->compare('is_visible',$this->is_visible);
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
