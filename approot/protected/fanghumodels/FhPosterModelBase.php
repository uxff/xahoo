<?php

/**
 * This is the model class for table "fh_poster".
 *
 * The followings are the available columns in table 'fh_poster':
 * @property integer $id
 * @property integer $project_id
 * @property integer $accounts_id
 * @property string $direct_fans_rewards
 * @property string $indirect_fans_rewards
 * @property string $subscribe_rewards
 * @property string $project_bonus_ceiling
 * @property integer $project_fans_ceiling
 * @property string $lowest_withdraw_sum
 * @property string $highest_withdraw_sum
 * @property integer $poster_status
 * @property string $valid_begintime
 * @property string $valid_endtime
 * @property string $photo_url
 * @property integer $direct_fans_num
 * @property integer $indirect_fans_num
 * @property string $direct_fans_rewarded
 * @property string $indirect_fans_rewarded
 * @property string $all_rewarded
 * @property string $valid_area
 * @property string $poster_rules
 * @property string $create_time
 * @property string $last_modified
 */
class FhPosterModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_poster';
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
                        array('accounts_id, direct_fans_rewards, indirect_fans_rewards, project_bonus_ceiling, project_fans_ceiling, lowest_withdraw_sum, highest_withdraw_sum, valid_begintime, valid_endtime, photo_url', 'required'),
                        array('project_id, accounts_id, project_fans_ceiling, poster_status, direct_fans_num, indirect_fans_num', 'numerical', 'integerOnly'=>true),
                        array('direct_fans_rewards, indirect_fans_rewards, subscribe_rewards, lowest_withdraw_sum, highest_withdraw_sum', 'length', 'max'=>9),
                        array('project_bonus_ceiling, direct_fans_rewarded, indirect_fans_rewarded, all_rewarded', 'length', 'max'=>11),
                        array('photo_url', 'length', 'max'=>200),
                        array('valid_area', 'length', 'max'=>255),
                        array('poster_rules', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, project_id, accounts_id, direct_fans_rewards, indirect_fans_rewards, subscribe_rewards, project_bonus_ceiling, project_fans_ceiling, lowest_withdraw_sum, highest_withdraw_sum, poster_status, valid_begintime, valid_endtime, photo_url, direct_fans_num, indirect_fans_num, direct_fans_rewarded, indirect_fans_rewarded, all_rewarded, valid_area, poster_rules, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => 'id',
                       'project_id' => '项目ID',
                       'accounts_id' => '公众号ID',
                       'direct_fans_rewards' => '直接粉丝奖励',
                       'indirect_fans_rewards' => '间接粉丝奖励',
                       'subscribe_rewards' => '关注奖励',
                       'project_bonus_ceiling' => '项目奖金上限',
                       'project_fans_ceiling' => '项目粉丝上限',
                       'lowest_withdraw_sum' => '最低提现金额',
                       'highest_withdraw_sum' => '最高提现金额',
                       'poster_status' => '海报状态：1｜无效 2｜有效',
                       'valid_begintime' => '海报有效期开始时间',
                       'valid_endtime' => '海报有效期结束时间',
                       'photo_url' => '封面图url',
                       'direct_fans_num' => '直接粉丝数',
                       'indirect_fans_num' => '间接粉丝数',
                       'direct_fans_rewarded' => '已发出直接粉丝奖励',
                       'indirect_fans_rewarded' => '已发出间接粉丝奖励',
                       'all_rewarded' => '所有已发出奖励',
                       'valid_area' => '有效区域',
                       'poster_rules' => '活动规则',
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

       				$criteria->compare('t.id',$this->id);
				$criteria->compare('t.project_id',$this->project_id);
				$criteria->compare('t.accounts_id',$this->accounts_id);
				$criteria->compare('t.direct_fans_rewards',$this->direct_fans_rewards,true);
				$criteria->compare('t.indirect_fans_rewards',$this->indirect_fans_rewards,true);
				$criteria->compare('t.subscribe_rewards',$this->subscribe_rewards,true);
				$criteria->compare('t.project_bonus_ceiling',$this->project_bonus_ceiling,true);
				$criteria->compare('t.project_fans_ceiling',$this->project_fans_ceiling);
				$criteria->compare('t.lowest_withdraw_sum',$this->lowest_withdraw_sum,true);
				$criteria->compare('t.highest_withdraw_sum',$this->highest_withdraw_sum,true);
				$criteria->compare('t.poster_status',$this->poster_status);
				$criteria->compare('t.valid_begintime',$this->valid_begintime,true);
				$criteria->compare('t.valid_endtime',$this->valid_endtime,true);
				$criteria->compare('t.photo_url',$this->photo_url,true);
				$criteria->compare('t.direct_fans_num',$this->direct_fans_num);
				$criteria->compare('t.indirect_fans_num',$this->indirect_fans_num);
				$criteria->compare('t.direct_fans_rewarded',$this->direct_fans_rewarded,true);
				$criteria->compare('t.indirect_fans_rewarded',$this->indirect_fans_rewarded,true);
				$criteria->compare('t.all_rewarded',$this->all_rewarded,true);
				$criteria->compare('t.valid_area',$this->valid_area,true);
				$criteria->compare('t.poster_rules',$this->poster_rules,true);
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
