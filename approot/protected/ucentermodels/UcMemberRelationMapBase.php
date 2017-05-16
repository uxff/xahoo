<?php

/**
 * This is the model class for table "uc_member_relation_map".
 *
 * The followings are the available columns in table 'uc_member_relation_map':
 * @property string $map_id
 * @property string $member_id
 * @property string $parent_id
 * @property integer $degree
 */
class UcMemberRelationMapBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_relation_map';
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
                        array('degree', 'numerical', 'integerOnly'=>true),
                        array('member_id, parent_id', 'length', 'max'=>11),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('map_id, member_id, parent_id, degree', 'safe', 'on'=>'search'),
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

                       'map_id' => '会员关系映射编号',
                       'member_id' => '会员编号',
                       'parent_id' => '上级会员编号',
                       'degree' => '深度度数',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('map_id',$this->map_id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('parent_id',$this->parent_id,true);
				$criteria->compare('degree',$this->degree);
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
