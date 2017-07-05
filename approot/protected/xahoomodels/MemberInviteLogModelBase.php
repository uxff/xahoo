<?php

/**
 * This is the model class for table "fh_member_invite_log".
 *
 * The followings are the available columns in table 'fh_member_invite_log':
 * @property string $id
 * @property string $inviter
 * @property string $invitee
 * @property integer $invite_type
 * @property integer $invite_status
 * @property string $invitee_acct
 * @property string $invite_code
 * @property string $create_time
 * @property string $last_modified
 */
class MemberInviteLogModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_member_invite_log';
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
                        array('inviter, invitee, invite_code', 'required'),
                        array('invite_type, invite_status', 'numerical', 'integerOnly'=>true),
                        array('inviter, invitee, invite_code', 'length', 'max'=>10),
                        array('invitee_acct', 'length', 'max'=>32),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, inviter, invitee, invite_type, invite_status, invitee_acct, invite_code, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'inviter' => '邀请人',
                       'invitee' => '被邀请人',
                       'invite_type' => '邀请方式:1=mobile;2=email',
                       'invite_status' => '状态:1=已接受邀请;2=拒绝',
                       'invitee_acct' => '被邀请人账号',
                       'invite_code' => '使用的邀请码',
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

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.inviter',$this->inviter,true);
				$criteria->compare('t.invitee',$this->invitee,true);
				$criteria->compare('t.invite_type',$this->invite_type);
				$criteria->compare('t.invite_status',$this->invite_status);
				$criteria->compare('t.invitee_acct',$this->invitee_acct,true);
				$criteria->compare('t.invite_code',$this->invite_code,true);
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
