<?php

/**
 * This is the model class for table "fh_redpack_log".
 *
 * The followings are the available columns in table 'fh_redpack_log':
 * @property string $id
 * @property string $member_id
 * @property string $openid
 * @property double $money
 * @property integer $oper_type
 * @property integer $oper_id
 * @property integer $status
 * @property string $merid
 * @property string $wx_billno
 * @property string $remark
 * @property string $post_data
 * @property string $wx_res
 * @property integer $operator_id
 * @property string $operator_name
 * @property string $create_time
 * @property string $last_modified
 */
class FhRedpackLogBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_redpack_log';
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
                        array('member_id, openid, money, merid, wx_billno, post_data, operator_id', 'required'),
                        array('oper_type, oper_id, status, operator_id', 'numerical', 'integerOnly'=>true),
                        array('money', 'numerical'),
                        array('member_id', 'length', 'max'=>10),
                        array('openid, wx_billno', 'length', 'max'=>40),
                        array('merid', 'length', 'max'=>32),
                        array('remark', 'length', 'max'=>255),
                        array('post_data, wx_res', 'length', 'max'=>1024),
                        array('operator_name', 'length', 'max'=>128),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, openid, money, oper_type, oper_id, status, merid, wx_billno, remark, post_data, wx_res, operator_id, operator_name, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'member_id' => '用户id',
                       'openid' => 'openid',
                       'money' => '金额(元)',
                       'oper_type' => '业务类型',
                       'oper_id' => '业务id(比如提现id)',
                       'status' => '状态',
                       'merid' => '商户号',
                       'wx_billno' => '微信平台订单id',
                       'remark' => '备注',
                       'post_data' => '请求数据',
                       'wx_res' => '微信平台返回',
                       'operator_id' => '操作人id',
                       'operator_name' => '操作人名称',
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
				$criteria->compare('t.member_id',$this->member_id,true);
				$criteria->compare('t.openid',$this->openid,true);
				$criteria->compare('t.money',$this->money);
				$criteria->compare('t.oper_type',$this->oper_type);
				$criteria->compare('t.oper_id',$this->oper_id);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.merid',$this->merid,true);
				$criteria->compare('t.wx_billno',$this->wx_billno,true);
				$criteria->compare('t.remark',$this->remark,true);
				$criteria->compare('t.post_data',$this->post_data,true);
				$criteria->compare('t.wx_res',$this->wx_res,true);
				$criteria->compare('t.operator_id',$this->operator_id);
				$criteria->compare('t.operator_name',$this->operator_name,true);
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
