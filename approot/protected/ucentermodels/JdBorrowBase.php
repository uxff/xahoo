<?php

/**
 * This is the model class for table "jd_borrow".
 *
 * The followings are the available columns in table 'jd_borrow':
 * @property integer $borrow_id
 * @property integer $project_order_id
 * @property integer $project_id
 * @property integer $project_source
 * @property integer $borrow_uid
 * @property string $credit_level
 * @property string $borrow_name
 * @property integer $borrow_type
 * @property string $borrow_useage
 * @property string $borrow_desc
 * @property integer $borrow_duration
 * @property string $borrow_total
 * @property string $borrow_interest_rate
 * @property string $borrow_fee
 * @property string $annual_rate
 * @property string $receive_total
 * @property string $bid_total
 * @property string $bid_price
 * @property string $bid_min
 * @property string $bid_max
 * @property integer $repayment_type
 * @property string $repayment_total
 * @property string $repayment_total_finished
 * @property string $repayment_interest
 * @property string $fine_total
 * @property integer $is_recommend
 * @property string $borrow_publish_time
 * @property string $bid_start_time
 * @property string $bid_full_time
 * @property string $repayment_start_time
 * @property integer $repayment_duration
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class JdBorrowBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'jd_borrow';
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
                        array('project_order_id, project_id, project_source, borrow_uid, borrow_type, borrow_duration, repayment_type, is_recommend, repayment_duration, status', 'numerical', 'integerOnly'=>true),
                        array('credit_level', 'length', 'max'=>4),
                        array('borrow_name', 'length', 'max'=>32),
                        array('borrow_useage', 'length', 'max'=>500),
                        array('borrow_total, borrow_fee, receive_total, bid_total, bid_price, bid_min, bid_max, repayment_total, repayment_total_finished, repayment_interest, fine_total', 'length', 'max'=>15),
                        array('borrow_interest_rate, annual_rate', 'length', 'max'=>5),
                        array('borrow_desc, borrow_publish_time, bid_start_time, bid_full_time, repayment_start_time, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('borrow_id, project_order_id, project_id, project_source, borrow_uid, credit_level, borrow_name, borrow_type, borrow_useage, borrow_desc, borrow_duration, borrow_total, borrow_interest_rate, borrow_fee, annual_rate, receive_total, bid_total, bid_price, bid_min, bid_max, repayment_type, repayment_total, repayment_total_finished, repayment_interest, fine_total, is_recommend, borrow_publish_time, bid_start_time, bid_full_time, repayment_start_time, repayment_duration, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'borrow_id' => 'Borrow',
                       'project_order_id' => 'Project Order',
                       'project_id' => 'Project',
                       'project_source' => 'Project Source',
                       'borrow_uid' => 'Borrow Uid',
                       'credit_level' => 'Credit Level',
                       'borrow_name' => 'Borrow Name',
                       'borrow_type' => 'Borrow Type',
                       'borrow_useage' => 'Borrow Useage',
                       'borrow_desc' => 'Borrow Desc',
                       'borrow_duration' => 'Borrow Duration',
                       'borrow_total' => 'Borrow Total',
                       'borrow_interest_rate' => 'Borrow Interest Rate',
                       'borrow_fee' => 'Borrow Fee',
                       'annual_rate' => 'Annual Rate',
                       'receive_total' => 'Receive Total',
                       'bid_total' => 'Bid Total',
                       'bid_price' => 'Bid Price',
                       'bid_min' => 'Bid Min',
                       'bid_max' => 'Bid Max',
                       'repayment_type' => 'Repayment Type',
                       'repayment_total' => 'Repayment Total',
                       'repayment_total_finished' => 'Repayment Total Finished',
                       'repayment_interest' => 'Repayment Interest',
                       'fine_total' => 'Fine Total',
                       'is_recommend' => 'Is Recommend',
                       'borrow_publish_time' => 'Borrow Publish Time',
                       'bid_start_time' => 'Bid Start Time',
                       'bid_full_time' => 'Bid Full Time',
                       'repayment_start_time' => 'Repayment Start Time',
                       'repayment_duration' => 'Repayment Duration',
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

       				$criteria->compare('t.borrow_id',$this->borrow_id);
				$criteria->compare('t.project_order_id',$this->project_order_id);
				$criteria->compare('t.project_id',$this->project_id);
				$criteria->compare('t.project_source',$this->project_source);
				$criteria->compare('t.borrow_uid',$this->borrow_uid);
				$criteria->compare('t.credit_level',$this->credit_level,true);
				$criteria->compare('t.borrow_name',$this->borrow_name,true);
				$criteria->compare('t.borrow_type',$this->borrow_type);
				$criteria->compare('t.borrow_useage',$this->borrow_useage,true);
				$criteria->compare('t.borrow_desc',$this->borrow_desc,true);
				$criteria->compare('t.borrow_duration',$this->borrow_duration);
				$criteria->compare('t.borrow_total',$this->borrow_total,true);
				$criteria->compare('t.borrow_interest_rate',$this->borrow_interest_rate,true);
				$criteria->compare('t.borrow_fee',$this->borrow_fee,true);
				$criteria->compare('t.annual_rate',$this->annual_rate,true);
				$criteria->compare('t.receive_total',$this->receive_total,true);
				$criteria->compare('t.bid_total',$this->bid_total,true);
				$criteria->compare('t.bid_price',$this->bid_price,true);
				$criteria->compare('t.bid_min',$this->bid_min,true);
				$criteria->compare('t.bid_max',$this->bid_max,true);
				$criteria->compare('t.repayment_type',$this->repayment_type);
				$criteria->compare('t.repayment_total',$this->repayment_total,true);
				$criteria->compare('t.repayment_total_finished',$this->repayment_total_finished,true);
				$criteria->compare('t.repayment_interest',$this->repayment_interest,true);
				$criteria->compare('t.fine_total',$this->fine_total,true);
				$criteria->compare('t.is_recommend',$this->is_recommend);
				$criteria->compare('t.borrow_publish_time',$this->borrow_publish_time,true);
				$criteria->compare('t.bid_start_time',$this->bid_start_time,true);
				$criteria->compare('t.bid_full_time',$this->bid_full_time,true);
				$criteria->compare('t.repayment_start_time',$this->repayment_start_time,true);
				$criteria->compare('t.repayment_duration',$this->repayment_duration);
				$criteria->compare('t.status',$this->status);
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
