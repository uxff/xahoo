<?php

/**
 * This is the model class for table "member_appointment".
 *
 * The followings are the available columns in table 'member_appointment':
 * @property string $id
 * @property string $member_id
 * @property integer $task_building_id
 * @property string $source
 * @property double $deal_amount
 * @property string $name
 * @property string $tel
 * @property string $house_url
 * @property integer $status
 * @property integer $dealed
 * @property integer $order_id
 * @property string $order_numberid
 * @property string $remark
 * @property string $statusdate1
 * @property string $statusdate2
 * @property string $statusdate3
 * @property string $statusdate4
 * @property string $create_time
 * @property string $last_modified
 */
class MemberAppointmentBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'member_appointment';
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
                        array('task_building_id, status, dealed, order_id', 'numerical', 'integerOnly'=>true),
                        array('deal_amount', 'numerical'),
                        array('member_id', 'length', 'max'=>11),
                        array('source', 'length', 'max'=>25),
                        array('name, tel', 'length', 'max'=>20),
                        array('house_url, order_numberid', 'length', 'max'=>255),
                        array('remark', 'length', 'max'=>300),
                        array('statusdate1, statusdate2, statusdate3, statusdate4, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, task_building_id, source, deal_amount, name, tel, house_url, status, dealed, order_id, order_numberid, remark, statusdate1, statusdate2, statusdate3, statusdate4, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => '预约编号',
                       'member_id' => '会员编号',
                       'task_building_id' => '房源任务id',
                       'source' => '来源',
                       'deal_amount' => '成交总额',
                       'name' => '预约人姓名',
                       'tel' => '预约人电话',
                       'house_url' => '预约房源链接',
                       'status' => '预约状态',
                       'dealed' => '是否处理',
                       'order_id' => '订单ID',
                       'order_numberid' => '订单编号',
                       'remark' => '管理员备注',
                       'statusdate1' => '状态1时间',
                       'statusdate2' => '状态2时间',
                       'statusdate3' => '状态3时间',
                       'statusdate4' => '状态4时间',
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

       				$criteria->compare('id',$this->id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('task_building_id',$this->task_building_id);
				$criteria->compare('source',$this->source,true);
				$criteria->compare('deal_amount',$this->deal_amount);
				$criteria->compare('name',$this->name,true);
				$criteria->compare('tel',$this->tel,true);
				$criteria->compare('house_url',$this->house_url,true);
				$criteria->compare('status',$this->status);
				$criteria->compare('dealed',$this->dealed);
				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('order_numberid',$this->order_numberid,true);
				$criteria->compare('remark',$this->remark,true);
				$criteria->compare('statusdate1',$this->statusdate1,true);
				$criteria->compare('statusdate2',$this->statusdate2,true);
				$criteria->compare('statusdate3',$this->statusdate3,true);
				$criteria->compare('statusdate4',$this->statusdate4,true);
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
