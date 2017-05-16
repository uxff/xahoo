<?php

/**
 * This is the model class for table "uc_member_relation".
 *
 * The followings are the available columns in table 'uc_member_relation':
 * @property string $relation_id
 * @property string $member_id
 * @property string $parent_id
 * @property integer $parent_depth
 * @property string $parent_tree
 */
class UcMemberRelationBase extends UCenterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_relation';
        }
        public function init() {
                //$this->ares_register_behaviors();
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
                        array('member_id, parent_id', 'required'),
                        array('parent_depth', 'numerical', 'integerOnly'=>true),
                        array('member_id, parent_id', 'length', 'max'=>11),
                        array('parent_tree', 'length', 'max'=>255),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('relation_id, member_id, parent_id, parent_depth, parent_tree', 'safe', 'on'=>'search'),
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

                       'relation_id' => '会员关系编号',
                       'member_id' => '会员编号',
                       'parent_id' => '伙伴邀请人编号',
                       'parent_depth' => '深度',
                       'parent_tree' => '父级树',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('relation_id',$this->relation_id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('parent_id',$this->parent_id,true);
				$criteria->compare('parent_depth',$this->parent_depth);
				$criteria->compare('parent_tree',$this->parent_tree,true);
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
         * Please note that you should have this exact method in all your UCenterActiveRecord descendants!
         * @param string $className active record class name.
         * @return SysNode the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }
}
