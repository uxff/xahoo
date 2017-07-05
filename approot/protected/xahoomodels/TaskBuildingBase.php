<?php

/**
 * This is the model class for table "task_building".
 *
 * The followings are the available columns in table 'task_building':
 * @property string $task_id
 * @property string $task_title
 * @property string $task_url
 * @property string $task_img
 * @property integer $building_id
 * @property string $building_name
 * @property string $building_address
 * @property string $building_open_time
 * @property integer $building_price
 * @property string $building_detail
 * @property integer $brokerage_max
 * @property integer $dividend_ratio
 * @property integer $point_amount
 * @property integer $project
 * @property integer $status
 * @property integer $flag
 * @property string $create_time
 * @property string $last_modified
 */
class TaskBuildingBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'task_building';
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
        * @return array validation rules for model attributes.
        */
        public function rules()
        {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                        array('task_title, building_name, building_address', 'required'),
                        array('building_id, building_price, brokerage_max, dividend_ratio, point_amount, project, status, flag', 'numerical', 'integerOnly'=>true),
                        array('task_title, building_name', 'length', 'max'=>50),
                        array('task_url, building_address', 'length', 'max'=>200),
                        array('task_img', 'length', 'max'=>255),
                        array('building_open_time, building_detail, create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('task_id, task_title, task_url, task_img, building_id, building_name, building_address, building_open_time, building_price, building_detail, brokerage_max, dividend_ratio, point_amount, project, status, flag, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'task_id' => '任务编号',
                       'task_title' => '任务标题',
                       'task_url' => '任务',
                       'task_img' => '任务配图',
//                       'building_id' => '房源id',
                       'building_name' => '楼盘名称',
//                       'building_address' => '楼盘地址',
                       'building_open_time' => '开盘时间',
                       'building_price' => '楼盘价格',
//                       'building_detail' => '楼盘详情',
                       'brokerage_max' => '最高佣金',
                       'dividend_ratio' => '佣金比例',
                       'point_amount' => '积分数量',
//                       'project' => '规则所属项目',
                       'status' => '状态',
//                       'flag' => '类型',
//                       'create_time' => '创建时间',
//                       'last_modified' => '修改时间',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('task_id',$this->task_id,true);
				$criteria->compare('task_title',$this->task_title,true);
				$criteria->compare('task_url',$this->task_url,true);
				$criteria->compare('task_img',$this->task_img,true);
				$criteria->compare('building_id',$this->building_id);
				$criteria->compare('building_name',$this->building_name,true);
				$criteria->compare('building_address',$this->building_address,true);
				$criteria->compare('building_open_time',$this->building_open_time,true);
				$criteria->compare('building_price',$this->building_price);
				$criteria->compare('building_detail',$this->building_detail,true);
				$criteria->compare('brokerage_max',$this->brokerage_max);
				$criteria->compare('dividend_ratio',$this->dividend_ratio);
				$criteria->compare('point_amount',$this->point_amount);
				$criteria->compare('project',$this->project);
				$criteria->compare('status',$this->status);
				$criteria->compare('flag',$this->flag);
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
