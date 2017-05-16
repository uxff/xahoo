<?php

/**
 * This is the model class for table "uc_member_lottery_config".
 *
 * The followings are the available columns in table 'uc_member_lottery_config':
 * @property string $config_id
 * @property integer $lottery_level
 * @property string $lottery_title
 * @property integer $lottery_amount
 * @property integer $lottery_stock
 * @property integer $lottery_chance
 * @property string $min_angle
 * @property string $max_angle
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberLotteryConfigBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_lottery_config';
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
                        array('lottery_level, lottery_amount, lottery_stock, lottery_chance, status', 'numerical', 'integerOnly'=>true),
                        array('lottery_title, min_angle, max_angle', 'length', 'max'=>255),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('config_id, lottery_level, lottery_title, lottery_amount, lottery_stock, lottery_chance, min_angle, max_angle, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'config_id' => '编号',
                       'lottery_level' => '奖项等级',
                       'lottery_title' => '奖项名称',
                       'lottery_amount' => '奖项金额',
                       'lottery_stock' => '奖项库存',
                       'lottery_chance' => '奖项概率',
                       'min_angle' => '最小角度(多个逗号分隔)',
                       'max_angle' => '最大角度(多个逗号分隔)',
                       'status' => '状态',
                       'create_time' => '创建时间',
                       'last_modified' => '修改时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.config_id',$this->config_id,true);
				$criteria->compare('t.lottery_level',$this->lottery_level);
				$criteria->compare('t.lottery_title',$this->lottery_title,true);
				$criteria->compare('t.lottery_amount',$this->lottery_amount);
				$criteria->compare('t.lottery_stock',$this->lottery_stock);
				$criteria->compare('t.lottery_chance',$this->lottery_chance);
				$criteria->compare('t.min_angle',$this->min_angle,true);
				$criteria->compare('t.max_angle',$this->max_angle,true);
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
}
