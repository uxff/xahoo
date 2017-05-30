<?php

/**
 * This is the model class for table "fh_member_task".
 *
 * The followings are the available columns in table 'fh_member_task':
 * @property integer $id
 * @property integer $task_id
 * @property string $member_id
 * @property integer $status
 * @property integer $reward_status
 * @property string $create_time
 * @property string $last_modified
 * @property string $finish_time
 * @property integer $dispatch_id
 * @property integer $view_count
 * @property integer $is_delete
 * @property string $remark
 * @property integer $rule_id
 * @property integer $step_count
 * @property integer $step_need_count
 */
class MemberTaskModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_member_task';
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
                        array('member_id, task_id, rule_id', 'required'),
                        array('task_id, reward_status, status, dispatch_id, is_delete, rule_id, step_count, step_need_count, view_count', 'numerical', 'integerOnly'=>true),
                        array('member_id', 'length', 'max'=>10),
                        array('remark', 'length', 'max'=>255),
                        array('create_time, finish_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, task_id, member_id, status, reward_status, create_time, last_modified, finish_time, dispatch_id, view_count, is_delete, remark, rule_id, step_count, step_need_count', 'safe', 'on'=>'search'),
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
                       'task_id' => '任务id',
                       'member_id' => '领取人id',
                       'status' => '任务状态：1=已领取；2=已完成',
                       'reward_status' => '奖励状态(位):0=未奖励;1=已积分奖励;2=已金额奖励;4=已实物奖励',
                       'create_time' => '创建时间',
                       'last_modified' => '最后修改时间',
                       'finish_time' => '完成时间',
                       'dispatch_id' => '最终奖励的积分',
                       'view_count' => '点击数',
                       'is_delete' => '是否删除 1=已软删除',
                       'remark' => '任务标记',
                       'rule_id' => '任务对应的规则id',
                       'step_count' => '进度统计(比如完成10个邀请，已分享100次)',
                       'step_need_count' => '进度目标：0=不限制 比如100=任务要求邀请好友100个',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id);
				$criteria->compare('t.task_id',$this->task_id);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.reward_status',$this->reward_status);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
				$criteria->compare('t.finish_time',$this->finish_time,true);
				$criteria->compare('t.dispatch_id',$this->dispatch_id);
				$criteria->compare('t.view_count',$this->view_count);
				$criteria->compare('t.is_delete',$this->is_delete);
				$criteria->compare('t.remark',$this->remark,true);
				$criteria->compare('t.rule_id',$this->rule_id);
				$criteria->compare('t.step_count',$this->step_count);
				$criteria->compare('t.step_need_count',$this->step_need_count);
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
