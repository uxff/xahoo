<?php

/**
 * This is the model class for table "fh_points_rule".
 *
 * The followings are the available columns in table 'fh_points_rule':
 * @property integer $rule_id
 * @property string $rule_key
 * @property string $rule_name
 * @property string $desc
 * @property integer $points
 * @property integer $points_desc
 * @property integer $status
 * @property integer $flag
 * @property string $create_time
 * @property string $last_modified
 */
class PointsRuleModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_points_rule';
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
                        array('rule_key, points', 'required'),
                        array('points, status, flag', 'numerical', 'integerOnly'=>true),
                        array('rule_key', 'length', 'max'=>32),
                        array('rule_name', 'length', 'max'=>40),
                        array('desc, points_desc', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('rule_id, rule_key, rule_name, desc, points, points_desc, status, create_time, last_modified, flag', 'safe', 'on'=>'search'),
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

                       'rule_id' => '规则id',
                       'rule_key' => '规则key',
                       'rule_name' => '中文名称',
                       'desc' => '规则描述',
                       'points' => '规则对应的积分数',
                       'status' => '状态：1=有效；2=无效',
                       'flag' => '标记',  // 1=普通规则;2=可变规则
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

       				$criteria->compare('t.rule_id',$this->rule_id);
				$criteria->compare('t.rule_key',$this->rule_key,true);
				$criteria->compare('t.rule_name',$this->rule_name,true);
				$criteria->compare('t.desc',$this->desc,true);
				$criteria->compare('t.points',$this->points);
				$criteria->compare('t.points_desc',$this->points_desc,true);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.flag',$this->flag);
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
