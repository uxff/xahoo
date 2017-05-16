<?php

/**
 * This is the model class for table "uc_member_contribute_log".
 *
 * The followings are the available columns in table 'uc_member_contribute_log':
 * @property string $log_id
 * @property string $member_id
 * @property string $order_id
 * @property string $order_numberid
 * @property integer $task_id
 * @property string $item_name
 * @property double $contribute_score
 * @property integer $operate_type
 * @property integer $contribute_before
 * @property integer $contribute_after
 * @property integer $status
 * @property string $source
 * @property string $create_time
 * @property string $last_modified
 * @property string $description
 */
class UcMemberContributeLogBase extends UCenterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_contribute_log';
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
                        array('member_id', 'required'),
                        array('task_id, operate_type, contribute_before, contribute_after, status', 'numerical', 'integerOnly'=>true),
                        array('contribute_score', 'numerical'),
                        array('member_id, order_id', 'length', 'max'=>11),
                        array('order_numberid', 'length', 'max'=>255),
                        array('item_name', 'length', 'max'=>225),
                        array('source', 'length', 'max'=>25),
                        array('create_time, last_modified, description', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('log_id, member_id, order_id, order_numberid, task_id, item_name, contribute_score, operate_type, contribute_before, contribute_after, status, source, create_time, last_modified, description', 'safe', 'on'=>'search'),
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

                       'log_id' => '贡献日志id',
                       'member_id' => '会员编号',
                       'order_id' => '订单id',
                       'order_numberid' => '订单编号',
                       'task_id' => '任务id',
                       'item_name' => '楼盘项目名称',
                       'contribute_score' => '贡献分值',
                       'operate_type' => '操作类型',
                       'contribute_before' => '之前贡献数量',
                       'contribute_after' => '之后贡献数量',
                       'status' => '状态',
                       'source' => '来源',
                       'create_time' => '创建时间',
                       'last_modified' => '修改时间',
                       'description' => '描述',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('log_id',$this->log_id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('order_id',$this->order_id,true);
				$criteria->compare('order_numberid',$this->order_numberid,true);
				$criteria->compare('task_id',$this->task_id);
				$criteria->compare('item_name',$this->item_name,true);
				$criteria->compare('contribute_score',$this->contribute_score);
				$criteria->compare('operate_type',$this->operate_type);
				$criteria->compare('contribute_before',$this->contribute_before);
				$criteria->compare('contribute_after',$this->contribute_after);
				$criteria->compare('status',$this->status);
				$criteria->compare('source',$this->source,true);
				$criteria->compare('create_time',$this->create_time,true);
				$criteria->compare('last_modified',$this->last_modified,true);
				$criteria->compare('description',$this->description,true);
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
