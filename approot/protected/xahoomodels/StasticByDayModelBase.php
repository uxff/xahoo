<?php

/**
 * This is the model class for table "fh_stastic_by_day".
 *
 * The followings are the available columns in table 'fh_stastic_by_day':
 * @property string $id
 * @property string $date
 * @property integer $pv
 * @property integer $uv
 * @property integer $share_count
 * @property integer $reg_count
 * @property integer $xqsj_pv
 * @property integer $xqsj_uv
 * @property string $create_time
 * @property string $last_modified
 */
class StasticByDayModelBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'fh_stastic_by_day';
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
                        array('date,points_add,points_consume', 'required'),
                        array('pv, uv, share_count, reg_count, xqsj_pv, xqsj_uv', 'numerical', 'integerOnly'=>true),
                        array('date, create_time', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, date, pv, uv, share_count, reg_count, xqsj_pv, xqsj_uv, points_add, points_consume, create_time, last_modified', 'safe', 'on'=>'search'),
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
                       'date' => '日期',
                       'pv' => 'PV',
                       'uv' => 'UV',
                       'share_count' => '转发量',
                       'reg_count' => '新增用户',
                       'xqsj_pv' => '新奇访问用户',
                       'xqsj_uv' => '新奇访问用户(uv)',
                       'points_add' => '积分单日增量',
                       'points_consume' => '积分单日消耗',
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
				$criteria->compare('t.date',$this->date,true);
				$criteria->compare('t.pv',$this->pv);
        $criteria->compare('t.uv',$this->uv);
        $criteria->compare('t.points_add,',$this->points_add);
				$criteria->compare('t.points_consume',$this->points_consume);
				$criteria->compare('t.share_count',$this->share_count);
				$criteria->compare('t.reg_count',$this->reg_count);
				$criteria->compare('t.xqsj_pv',$this->xqsj_pv);
				$criteria->compare('t.xqsj_uv',$this->xqsj_uv);
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
