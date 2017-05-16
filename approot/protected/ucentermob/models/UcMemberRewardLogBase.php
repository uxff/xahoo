<?php

/**
 * This is the model class for table "uc_member_reward_log".
 *
 * The followings are the available columns in table 'uc_member_reward_log':
 * @property integer $log_id
 * @property integer $member_id
 * @property integer $task_id
 * @property integer $order_id
 * @property string $order_numberid
 * @property integer $parent_id
 * @property integer $degree
 * @property double $reward_score
 * @property integer $operate_type
 * @property string $description
 * @property double $reward_before
 * @property double $reward_after
 * @property integer $status
 * @property string $source
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberRewardLogBase extends UCenterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_reward_log';
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
                        array('member_id, task_id, order_id, parent_id, degree, operate_type, status', 'numerical', 'integerOnly'=>true),
                        array('reward_score, reward_before, reward_after', 'numerical'),
                        array('order_numberid, description', 'length', 'max'=>255),
                        array('source', 'length', 'max'=>25),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('log_id, member_id, task_id, order_id, order_numberid, parent_id, degree, reward_score, operate_type, description, reward_before, reward_after, status, source, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'log_id' => '佣金日志id',
                       'member_id' => '会员id',
                       'task_id' => '任务id',
                       'order_id' => '订单id',
                       'order_numberid' => '订单编号',
                       'parent_id' => '小伙伴会员编号',
                       'degree' => '小伙伴的度数',
                       'reward_score' => '佣金分值',
                       'operate_type' => '操作类型',
                       'description' => '描述',
                       'reward_before' => '之前佣金数量',
                       'reward_after' => '之后佣金数量',
                       'status' => '状态',
                       'source' => '来源',
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

       				$criteria->compare('log_id',$this->log_id);
				$criteria->compare('member_id',$this->member_id);
				$criteria->compare('task_id',$this->task_id);
				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('order_numberid',$this->order_numberid,true);
				$criteria->compare('parent_id',$this->parent_id);
				$criteria->compare('degree',$this->degree);
				$criteria->compare('reward_score',$this->reward_score);
				$criteria->compare('operate_type',$this->operate_type);
				$criteria->compare('description',$this->description,true);
				$criteria->compare('reward_before',$this->reward_before);
				$criteria->compare('reward_after',$this->reward_after);
				$criteria->compare('status',$this->status);
				$criteria->compare('source',$this->source,true);
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
