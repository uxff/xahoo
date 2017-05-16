<?php

/**
 * This is the model class for table "fh_lot_product".
 *
 * The followings are the available columns in table 'fh_lot_product':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $stock
 * @property integer $history_stock
 * @property double $rate
 * @property integer $status
 * @property string $extra
 * @property string $pic_url
 * @property string $create_time
 * @property string $last_modified
 */
class FhLotProductModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_lot_product';
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
                        //array('last_modified', 'required'),
                        array('stock, history_stock, status', 'numerical', 'integerOnly'=>true),
                        array('rate', 'numerical'),
                        array('name, desc, extra, pic_url', 'length', 'max'=>255),
                        array('create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, name, desc, stock, history_stock, rate, status, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'id' => '抽奖商品id',
                       'name' => '商品名称',
                       'desc' => '商品描述',
                       'stock' => '库存',
                       'history_stock' => '已发放库存',
                       'rate' => '中奖几率',
                       'status' => '状态',
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
				$criteria->compare('t.name',$this->name,true);
				$criteria->compare('t.desc',$this->desc,true);
				$criteria->compare('t.stock',$this->stock);
				$criteria->compare('t.history_stock',$this->history_stock);
				$criteria->compare('t.rate',$this->rate);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.extra',$this->extra,true);
				$criteria->compare('t.pic_url',$this->pic_url,true);
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
