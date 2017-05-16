<?php

/**
 * This is the model class for table "fh_task_tpl".
 *
 * The followings are the available columns in table 'fh_task_tpl':
 * @property integer $task_id
 * @property string $task_name
 * @property integer $task_type
 * @property string $task_desc
 * @property string $task_url
 * @property string $surface_url
 * @property integer $act_type
 * @property integer $reward_type
 * @property integer $reward_type_money
 * @property integer $integral_upper
 * @property integer $money_upper
 * @property integer $reward_points
 * @property double $reward_money
 * @property integer $rule_id
 * @property integer $step_need_count
 * @property integer $weight
 * @property integer $status
 * @property integer $flag
 * @property string $create_time
 * @property string $last_modified
 * @property integer $admin_id
 * @property string $admin_name
 */
class TaskTplModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_task_tpl';
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
                        array('task_name, surface_url, act_type, integral_upper, money_upper, last_modified, admin_id, admin_name', 'required'),
                        array('task_type, act_type, reward_type, reward_type_money, integral_upper, money_upper, reward_points, rule_id, step_need_count, weight, status, flag, admin_id', 'numerical', 'integerOnly'=>true),
                        array('reward_money', 'numerical'),
                        array('task_name', 'length', 'max'=>40),
                        array('task_desc, surface_url', 'length', 'max'=>1024),
                        array('task_url', 'length', 'max'=>255),
                        array('admin_name', 'length', 'max'=>32),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('task_id, task_name, task_type, task_desc, task_url, surface_url, act_type, reward_type, reward_type_money, integral_upper, money_upper, reward_points, reward_money, rule_id, step_need_count, weight, status, flag, create_time, last_modified, admin_id, admin_name', 'safe', 'on'=>'search'),
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

                       'task_id' => '任务id',
                       'task_name' => '任务名称',
                       'task_type' => '模板分类',
                       'task_desc' => '任务描述',
                       'task_url' => '任务url',
                       'surface_url' => '封面图',
                       'act_type' => '任务分类',
                       'reward_type' => '奖励类型',
                       'reward_type_money' => '奖励类型',
                       'integral_upper' => '积分上限',
                       'money_upper' => '金额上限',
                       'reward_points' => '积分分值',
                       'reward_money' => '奖励金额',
                       'rule_id' => '积分规则id',
                       'step_need_count' => '任务需要的进度数(比如邀请数)',
                       'weight' => '权重:越小排序越前',
                       'status' => '任务状态',
                       'flag' => '标记：1=普通；2=热推',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
                       'admin_id' => '创建人id',
                       'admin_name' => '创建人',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.task_id',$this->task_id);
				$criteria->compare('t.task_name',$this->task_name,true);
				$criteria->compare('t.task_type',$this->task_type);
				$criteria->compare('t.task_desc',$this->task_desc,true);
				$criteria->compare('t.task_url',$this->task_url,true);
				$criteria->compare('t.surface_url',$this->surface_url,true);
				$criteria->compare('t.act_type',$this->act_type);
				$criteria->compare('t.reward_type',$this->reward_type);
				$criteria->compare('t.reward_type_money',$this->reward_type_money);
				$criteria->compare('t.integral_upper',$this->integral_upper);
				$criteria->compare('t.money_upper',$this->money_upper);
				$criteria->compare('t.reward_points',$this->reward_points);
				$criteria->compare('t.reward_money',$this->reward_money);
				$criteria->compare('t.rule_id',$this->rule_id);
				$criteria->compare('t.step_need_count',$this->step_need_count);
				$criteria->compare('t.weight',$this->weight);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.flag',$this->flag);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
				$criteria->compare('t.admin_id',$this->admin_id);
				$criteria->compare('t.admin_name',$this->admin_name,true);
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
