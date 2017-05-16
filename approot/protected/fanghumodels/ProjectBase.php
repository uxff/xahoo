<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $project_id
 * @property string $project_name
 * @property integer $ff_item_id
 * @property integer $project_province
 * @property integer $project_city
 * @property integer $create_uid
 * @property string $create_username
 * @property integer $project_country
 * @property string $project_address
 * @property integer $project_status
 * @property string $project_map
 * @property string $project_cover
 * @property string $project_banner
 * @property string $project_strengths
 * @property string $project_property
 * @property string $project_label
 * @property string $project_tel
 * @property string $project_tel_ext
 * @property string $project_ylt_bg  
 * @property integer $tpl_id
 * @property integer $status
 * @property integer $project_weight
 * @property string $create_time
 * @property string $last_modified
 */
class ProjectBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'project';
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
                        array('project_name, ff_item_id, project_province, project_city, create_uid, create_username, project_country, project_address, project_status, project_map, project_cover, project_banner, project_property, project_label, project_tel, tpl_id', 'required'),
                        array('ff_item_id, project_province, project_city, create_uid, project_country, project_status, tpl_id, status', 'numerical', 'integerOnly'=>true),
                        array('project_name', 'length', 'max'=>64),
                        array('create_username', 'length', 'max'=>32),
                        array('project_address, project_cover, project_banner, project_strengths, project_property, project_label, project_ylt_bg', 'length', 'max'=>255),
                        array('project_tel,project_tel_ext', 'length', 'max'=>16),
                        array('create_time, last_modified', 'safe'),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('project_id, project_name, ff_item_id, project_province, project_city, create_uid, create_username, project_country, project_address, project_status, project_map, project_cover, project_banner, project_strengths, project_property, project_label, project_tel, project_ylt_bg, tpl_id, status, project_weight, create_time, last_modified', 'safe', 'on'=>'search'),
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

                       'project_id' => '项目id',
                       'project_name' => '项目名称',
                       'ff_item_id' => '项目归属id',
                       'project_province' => '项目省份',
                       'project_city' => '项目所在市',
                       'create_uid' => '创建人用户id',
                       'create_username' => '创建人姓名',
                       'project_country' => '项目所在区',
                       'project_address' => '项目地址',
                       'project_status' => '项目状态',
                       'project_map' => '项目景区地图',
                       'project_cover' => '项目封面图',
                       'project_banner' => '项目banner图',
                       'project_strengths' => '项目亮点',
                       'project_property' => '物业类型,多个物业用英文半角,隔开',
                       'project_label' => '主题标签,多个标签用英文半角,隔开',
                       'project_tel' => '联系电话',
                        'project_tel_ext' => '分机号',
                       'project_ylt_bg' => '项目详情页逸乐通背景图',
                       'tpl_id' => '模板id',
                       'status' => '状态',
                       'project_weight' => '权重',
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

       				$criteria->compare('t.project_id',$this->project_id);
				$criteria->compare('t.project_name',$this->project_name,true);
				$criteria->compare('t.ff_item_id',$this->ff_item_id);
				$criteria->compare('t.project_province',$this->project_province);
				$criteria->compare('t.project_city',$this->project_city);
				$criteria->compare('t.create_uid',$this->create_uid);
				$criteria->compare('t.create_username',$this->create_username,true);
				$criteria->compare('t.project_country',$this->project_country);
				$criteria->compare('t.project_address',$this->project_address,true);
				$criteria->compare('t.project_status',$this->project_status);
				$criteria->compare('t.project_map',$this->project_map,true);
				$criteria->compare('t.project_cover',$this->project_cover,true);
				$criteria->compare('t.project_banner',$this->project_banner,true);
				$criteria->compare('t.project_strengths',$this->project_strengths,true);
				$criteria->compare('t.project_property',$this->project_property,true);
				$criteria->compare('t.project_label',$this->project_label,true);
				$criteria->compare('t.project_tel',$this->project_tel,true);
				$criteria->compare('t.project_tel_ext',$this->project_tel,true);
				$criteria->compare('t.project_ylt_bg',$this->project_ylt_bg,true);
				$criteria->compare('t.tpl_id',$this->tpl_id);
				$criteria->compare('t.status',$this->status);
				$criteria->compare('t.project_weight',$this->project_weight,true);
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
