<?php

/**
 * This is the model class for table "uc_third_part_login".
 *
 * The followings are the available columns in table 'uc_third_part_login':
 * @property string $uid
 * @property integer $member_id
 * @property string $screen_name
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $location
 * @property string $profile_image_url
 * @property string $create_time
 * @property string $access_token
 * @property integer $status
 * @property string $from
 */
class UcThirdPartLoginBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_third_part_login';
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
                        array('uid', 'required'),
                        array('member_id, status', 'numerical', 'integerOnly'=>true),
                        array('uid', 'length', 'max'=>64),
                        array('screen_name, name', 'length', 'max'=>30),
                        array('province, city, from', 'length', 'max'=>20),
                        array('location, profile_image_url', 'length', 'max'=>50),
                        array('create_time, access_token', 'length', 'max'=>100),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('uid, member_id, screen_name, name, province, city, location, profile_image_url, create_time, access_token, status, from', 'safe', 'on'=>'search'),
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

                       'uid' => '第三方识别编号',
                       'member_id' => '平台会员编号',
                       'screen_name' => '新浪显示名称',
                       'name' => '新浪姓名',
                       'province' => '省份',
                       'city' => '城市',
                       'location' => '所在位置',
                       'profile_image_url' => '个人资料头像链接',
                       'create_time' => '创建时间',
                       'access_token' => '访问令牌',
                       'status' => '登录状态',
                       'from' => '第三方平台',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('uid',$this->uid,true);
				$criteria->compare('member_id',$this->member_id);
				$criteria->compare('screen_name',$this->screen_name,true);
				$criteria->compare('name',$this->name,true);
				$criteria->compare('province',$this->province,true);
				$criteria->compare('city',$this->city,true);
				$criteria->compare('location',$this->location,true);
				$criteria->compare('profile_image_url',$this->profile_image_url,true);
				$criteria->compare('create_time',$this->create_time,true);
				$criteria->compare('access_token',$this->access_token,true);
				$criteria->compare('status',$this->status);
				$criteria->compare('from',$this->from,true);
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
