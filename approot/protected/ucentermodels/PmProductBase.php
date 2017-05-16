<?php

/**
 * This is the model class for table "pm_product".
 *
 * The followings are the available columns in table 'pm_product':
 * @property integer $product_id
 * @property integer $cateogry_id
 * @property string $product_name
 * @property string $brand_name
 * @property double $list_price
 * @property integer $member_level
 * @property integer $point_price
 * @property integer $product_total
 * @property string $product_intro
 * @property string $product_desc
 * @property string $remark
 * @property string $project_thumb
 * @property string $product_standard
 * @property string $product_pack
 * @property string $product_colour
 * @property integer $is_hot
 * @property integer $is_recommended
 * @property integer $creator_id
 * @property integer $is_visible
 * @property integer $is_purchase
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class PmProductBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'pm_product';
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
                        array('product_intro, product_desc, remark', 'required'),
                        array('cateogry_id, member_level, point_price, product_total, is_hot, is_recommended, creator_id, is_visible, is_purchase, status', 'numerical', 'integerOnly'=>true),
                        array('list_price', 'numerical'),
                        array('product_name, project_thumb, product_standard, product_pack, product_colour', 'length', 'max'=>255),
                        array('brand_name', 'length', 'max'=>50),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('product_id, cateogry_id, product_name, brand_name, list_price, member_level, point_price, product_total, product_intro, product_desc, remark, project_thumb, product_standard, product_pack, product_colour, is_hot, is_recommended, creator_id, is_visible, is_purchase, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'product_id' => '主键',
                       'cateogry_id' => '分类ID',
                       'product_name' => '产品名称',
                       'brand_name' => '商家',
                       'list_price' => '市场价格',
                       'member_level' => '等级',
                       'point_price' => '积分',
                       'product_total' => '库存数量',
                       'product_intro' => '商品介绍',
                       'product_desc' => '商品详情',
                       'remark' => '备注',
                       'project_thumb' => '商品封面图',
                       'product_standard' => '规格',
                       'product_pack' => '包装',
                       'product_colour' => '颜色',
                       'is_hot' => '是否热卖',
                       'is_recommended' => '是否推荐',
                       'creator_id' => '当前用户ID',
                       'is_visible' => '商品展示状态',
                       'is_purchase' => '是否采购状态',
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

       				$criteria->compare('product_id',$this->product_id);
				$criteria->compare('cateogry_id',$this->cateogry_id);
				$criteria->compare('product_name',$this->product_name,true);
				$criteria->compare('brand_name',$this->brand_name,true);
				$criteria->compare('list_price',$this->list_price);
				$criteria->compare('member_level',$this->member_level);
				$criteria->compare('point_price',$this->point_price);
				$criteria->compare('product_total',$this->product_total);
				$criteria->compare('product_intro',$this->product_intro,true);
				$criteria->compare('product_desc',$this->product_desc,true);
				$criteria->compare('remark',$this->remark,true);
				$criteria->compare('project_thumb',$this->project_thumb,true);
				$criteria->compare('product_standard',$this->product_standard,true);
				$criteria->compare('product_pack',$this->product_pack,true);
				$criteria->compare('product_colour',$this->product_colour,true);
				$criteria->compare('is_hot',$this->is_hot);
				$criteria->compare('is_recommended',$this->is_recommended);
				$criteria->compare('creator_id',$this->creator_id);
				$criteria->compare('is_visible',$this->is_visible);
				$criteria->compare('is_purchase',$this->is_purchase);
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
