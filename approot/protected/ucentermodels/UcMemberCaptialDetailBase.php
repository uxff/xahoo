<?php

/**
 * This is the model class for table "uc_member_captial_detail".
 *
 * The followings are the available columns in table 'uc_member_captial_detail':
 * @property integer $detail_id
 * @property integer $member_id
 * @property string $product_name
 * @property string $source
 * @property string $project_name
 * @property string $amount_change
 * @property string $change_operater
 * @property string $date_time
 * @property string $desc
 * @property string $create_time
 * @property string $update_time
 * @property string $order_id
 * @property string $order_url
 */
class UcMemberCaptialDetailBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_captial_detail';
        }
        public function init() {
                // $this->ares_register_behaviors();
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
                        array('desc', 'required'),
                        array('member_id', 'numerical', 'integerOnly'=>true),
                        array('product_name, source, project_name, order_id, order_url', 'length', 'max'=>255),
                        array('amount_change', 'length', 'max'=>10),
                        array('change_operater', 'length', 'max'=>4),
                        array('date_time, create_time, update_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('detail_id, member_id, product_name, source, project_name, amount_change, change_operater, date_time, desc, create_time, update_time, order_id, order_url', 'safe', 'on'=>'search'),
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

                       'detail_id' => '自增ID',
                       'member_id' => '会员ID',
                       'product_name' => '产品名称',
                       'source' => '来源/用途',
                       'project_name' => '项目名称',
                       'amount_change' => '交易金额',
                       'change_operater' => '操作方向+/-',
                       'date_time' => '交易时间',
                       'desc' => '备注',
                       'create_time' => '创建时间',
                       'update_time' => '更新时间',
                       'order_id' => '订单ID',
                       'order_url' => '订单详情URL',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.detail_id',$this->detail_id);
				$criteria->compare('t.member_id',$this->member_id);
				$criteria->compare('t.product_name',$this->product_name,true);
				$criteria->compare('t.source',$this->source,true);
				$criteria->compare('t.project_name',$this->project_name,true);
				$criteria->compare('t.amount_change',$this->amount_change,true);
				$criteria->compare('t.change_operater',$this->change_operater,true);
				$criteria->compare('t.date_time',$this->date_time,true);
				$criteria->compare('t.desc',$this->desc,true);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.update_time',$this->update_time,true);
				$criteria->compare('t.order_id',$this->order_id,true);
				$criteria->compare('t.order_url',$this->order_url,true);
                return $criteria;
         }
        /**
           * custom defined scope
           * @param  integer $pageNo   页码
           * @param  integer $pageSize 每页大小
           * @return object
           */
          public function pagination($pageNo = 1, $pageSize = 20) {

            $offset = ($pageNo > 1) ? ($pageNo - 1) * $pageSize : 0;
            $limit = ($pageSize > 0) ? $pageSize : 20;

            $this->getDbCriteria()->mergeWith(array('limit' => $limit, 'offset' => $offset));

            return $this;
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
