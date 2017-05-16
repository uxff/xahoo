<?php

/**
 * This is the model class for table "uc_member_cash_log".
 *
 * The followings are the available columns in table 'uc_member_cash_log':
 * @property string $cash_log_id
 * @property string $member_id
 * @property integer $order_id
 * @property string $order_numberid
 * @property double $cash_amount
 * @property integer $operate_type
 * @property string $description
 * @property double $cash_before
 * @property double $cash_after
 * @property string $source
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class UcMemberCashLogBase extends CActiveRecord
{
	
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'uc_member_cash_log';
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
           * custom defined scope
           * @param  integer $limit 数量
           * @return object
           */
          public function recently($limit = 5) {

            $this->getDbCriteria()->mergeWith(array('order' => 't.last_modified DESC', 'limit' => $limit));

            return $this;
          }

          /**
           * custom defined scope
           * @param  string $order
           * @return object
           */
          public function orderBy($order = 't.last_modified DESC') {

            if (!empty($order)) {
              $this->getDbCriteria()->mergeWith(array('order' => $order));
            }

            return $this;
          }
	

        /**
        * @return array validation rules for model attributes.
        */
        public function rules()
        {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                        array('order_id, operate_type, status', 'numerical', 'integerOnly'=>true),
                        array('cash_amount, cash_before, cash_after', 'numerical'),
                        array('member_id', 'length', 'max'=>11),
                        array('order_numberid, description', 'length', 'max'=>255),
                        array('source', 'length', 'max'=>25),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('cash_log_id, member_id, order_id, order_numberid, cash_amount, operate_type, description, cash_before, cash_after, source, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'cash_log_id' => 'Cash Log',
                       'member_id' => 'Member',
                       'order_id' => 'Order',
                       'order_numberid' => 'Order Numberid',
                       'cash_amount' => 'Cash Amount',
                       'operate_type' => 'Operate Type',
                       'description' => 'Description',
                       'cash_before' => 'Cash Before',
                       'cash_after' => 'Cash After',
                       'source' => 'Source',
                       'status' => 'Status',
                       'create_time' => 'Create Time',
                       'last_modified' => 'Last Modified',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('cash_log_id',$this->cash_log_id,true);
				$criteria->compare('member_id',$this->member_id,true);
				$criteria->compare('order_id',$this->order_id);
				$criteria->compare('order_numberid',$this->order_numberid,true);
				$criteria->compare('cash_amount',$this->cash_amount);
				$criteria->compare('operate_type',$this->operate_type);
				$criteria->compare('description',$this->description,true);
				$criteria->compare('cash_before',$this->cash_before);
				$criteria->compare('cash_after',$this->cash_after);
				$criteria->compare('source',$this->source,true);
				$criteria->compare('status',$this->status);
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
