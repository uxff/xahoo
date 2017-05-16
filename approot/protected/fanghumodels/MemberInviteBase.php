<?php

/**
 * This is the model class for table "member_invite".
 *
 * The followings are the available columns in table 'member_invite':
 * @property string $id
 * @property string $member_id
 * @property string $member_fullname
 * @property string $task_building_id
 * @property string $invite_name
 * @property string $invite_tel
 * @property integer $invite_id
 * @property string $invite_date
 * @property integer $dealed
 * @property string $remark
 * @property string $create_time
 * @property string $last_modified
 */
class MemberInviteBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'member_invite';
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
                        array('invite_id, dealed', 'numerical', 'integerOnly'=>true),
                        array('member_id, task_building_id', 'length', 'max'=>11),
                        array('member_fullname', 'length', 'max'=>128),
                        array('invite_name, invite_tel', 'length', 'max'=>20),
                        array('remark', 'length', 'max'=>300),
                        array('invite_date, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, member_fullname, task_building_id, invite_name, invite_tel, invite_id, invite_date, dealed, remark, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => '邀请id',
                       'member_id' => '邀请会员id',
                       'member_fullname' => '邀请会员姓名',
                       'task_building_id' => '房源任务id',
                       'invite_name' => '被邀请人姓名',
                       'invite_tel' => '被邀请人电话',
                       'invite_id' => '被邀请会员id',
                       'invite_date' => '邀请时间',
                       'dealed' => '是否处理',
                       'remark' => '备注',
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

       				$criteria->compare('id',$this->id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('member_fullname',$this->member_fullname,true);
				$criteria->compare('task_building_id',$this->task_building_id,true);
				$criteria->compare('invite_name',$this->invite_name,true);
				$criteria->compare('invite_tel',$this->invite_tel,true);
				$criteria->compare('invite_id',$this->invite_id);
				$criteria->compare('invite_date',$this->invite_date,true);
				$criteria->compare('dealed',$this->dealed);
				$criteria->compare('remark',$this->remark,true);
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
