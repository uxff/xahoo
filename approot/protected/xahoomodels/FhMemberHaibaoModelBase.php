<?php

/**
 * This is the model class for table "fh_member_haibao".
 *
 * The followings are the available columns in table 'fh_member_haibao':
 * @property string $id
 * @property integer $accounts_id
 * @property string $member_id
 * @property integer $sns_bind_id
 * @property string $poster_id
 * @property string $member_mobile
 * @property string $member_fullname
 * @property string $wx_nickname
 * @property string $openid
 * @property integer $project_id
 * @property string $jjr_name
 * @property integer $is_jjr
 * @property integer $is_addr_right
 * @property string $desc
 * @property double $reward_money
 * @property integer $fans_total
 * @property integer $fans_first
 * @property integer $fans_second
 * @property double $withdraw_money
 * @property double $withdraw_max
 * @property double $withdraw_min
 * @property string $create_time
 * @property string $last_modified
 */
class FhMemberHaibaoModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_member_haibao';
        }
        public function init() {
                $this->ares_register_behaviors();
                Yii::app()->getModule('points');
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
                        array('accounts_id, poster_id, openid, withdraw_min', 'required'),
                        array('accounts_id, sns_bind_id, project_id, is_jjr, is_addr_right, fans_total, fans_first, fans_second', 'numerical', 'integerOnly'=>true),
                        array('reward_money, withdraw_money, withdraw_max, withdraw_min', 'numerical'),
                        array('member_id, member_mobile', 'length', 'max'=>20),
                        array('poster_id', 'length', 'max'=>10),
                        array('member_fullname, wx_nickname, jjr_name', 'length', 'max'=>128),
                        array('openid', 'length', 'max'=>40),
                        array('desc', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, accounts_id, member_id, sns_bind_id, poster_id, member_mobile, member_fullname, wx_nickname, openid, project_id, jjr_name, is_jjr, is_addr_right, desc, reward_money, fans_total, fans_first, fans_second, withdraw_money, withdraw_max, withdraw_min, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'accounts_id' => '所属公众号',
                       'member_id' => '用户id',
                       'sns_bind_id' => 'sns绑定id(当做sceneid) ',
                       'poster_id' => '海报id',
                       'member_mobile' => '用户手机号',
                       'member_fullname' => '用户姓名',
                       'wx_nickname' => '微信昵称',
                       'openid' => 'openid',
                       'project_id' => '项目id',
                       'jjr_name' => '经纪人姓名',
                       'is_jjr' => '会员类型',
                       'desc' => '海报说明',
                       'reward_money' => '累积奖励金额',
                       'fans_total' => '粉丝总数',
                       'fans_first' => '直接粉丝',
                       'fans_second' => '间接粉丝',
                       'withdraw_money' => '已提现金额',
                       'withdraw_max' => '累计最高提款金额',
                       'withdraw_min' => '最低提款金额',
                       'create_time' => '创建时间',
                       'last_modified' => '最后更新时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.accounts_id',$this->accounts_id);
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.sns_bind_id',$this->sns_bind_id);
				$criteria->compare('t.poster_id',$this->poster_id,true);
				$criteria->compare('t.member_mobile',$this->member_mobile,true);
				$criteria->compare('t.member_fullname',$this->member_fullname,true);
				$criteria->compare('t.wx_nickname',$this->wx_nickname,true);
				$criteria->compare('t.openid',$this->openid,true);
				$criteria->compare('t.project_id',$this->project_id);
				$criteria->compare('t.jjr_name',$this->jjr_name,true);
				$criteria->compare('t.is_jjr',$this->is_jjr);
				$criteria->compare('t.is_addr_right',$this->is_addr_right, true);
				$criteria->compare('t.desc',$this->desc,true);
				$criteria->compare('t.reward_money',$this->reward_money);
				$criteria->compare('t.fans_total',$this->fans_total);
				$criteria->compare('t.fans_first',$this->fans_first);
				$criteria->compare('t.fans_second',$this->fans_second);
				$criteria->compare('t.withdraw_money',$this->withdraw_money);
				$criteria->compare('t.withdraw_max',$this->withdraw_max);
				$criteria->compare('t.withdraw_min',$this->withdraw_min);
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
