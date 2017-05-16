<?php

/**
 * This is the model class for table "jd_company_data".
 *
 * The followings are the available columns in table 'jd_company_data':
 * @property string $id
 * @property string $member_id
 * @property integer $sub_company_id
 * @property integer $borrow_id
 * @property string $file_path
 * @property string $file_ext
 * @property integer $data_type
 * @property integer $data_type2
 * @property string $create_time
 * @property string $last_modified
 * @property integer $audit_status
 * @property string $audit_remark
 * @property string $audit_time
 * @property string $audit_admin
 */
class JdCompanyDataBase extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public function tableName()
        {
                return 'jd_company_data';
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
                        array('member_id, file_path, file_ext, data_type, data_type2, work_order_id', 'required'),
                        array('sub_company_id, borrow_id, work_order_id, data_type, data_type2, audit_status', 'numerical', 'integerOnly'=>true),
                        array('member_id', 'length', 'max'=>20),
                        array('file_path', 'length', 'max'=>256),
                        array('file_ext', 'length', 'max'=>10),
                        array('audit_remark', 'length', 'max'=>256),
                        array('audit_admin', 'length', 'max'=>40),
                                        // The following rule is used by search().
                        // @todo Please remove those attributes that should not be searched.
                        array('id, member_id, sub_company_id, borrow_id, file_path, file_ext, data_type, data_type2, create_time, last_modified, audit_status, audit_remark, audit_time, audit_admin', 'safe', 'on'=>'search'),
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
                       'member_id' => '会员id',
                       'sub_company_id' => '会员公司id',
                       //'borrow_id' => '借贷项目id',
                       //'file_path' => '上传文件路径',
                       //'file_ext' => '文件类型',
                       //'data_type' => '资料类型',//： 1=公司资质 2=财务信息 3=法人信息
                       //'data_type2' => '资料具体类型： 参看代码',
                       //'create_time' => '创建时间',
                       //'last_modified' => '更新时间',
               			'credit_level' => '信用等级',
                       'audit_status' => '审核状态',
               		   //'pass_status' => '状态',
                       'audit_remark' => '审核备注',
                       'audit_time' => '审核时间',
                       'audit_admin' => '审核人',
               );
       }
        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria=new CDbCriteria;

       				$criteria->compare('t.id',$this->id,true);
				$criteria->compare('t.member_id',$this->member_id);
				$criteria->compare('t.sub_company_id',$this->sub_company_id);
				$criteria->compare('t.borrow_id',$this->borrow_id);
				$criteria->compare('t.work_order_id',$this->work_order_id);
				$criteria->compare('t.file_path',$this->file_path,true);
				$criteria->compare('t.file_ext',$this->file_ext,true);
				$criteria->compare('t.data_type',$this->data_type);
				$criteria->compare('t.data_type2',$this->data_type2);
				$criteria->compare('t.create_time',$this->create_time,true);
				$criteria->compare('t.last_modified',$this->last_modified,true);
				$criteria->compare('t.audit_status',$this->audit_status);
				$criteria->compare('t.audit_remark',$this->audit_remark,true);
				$criteria->compare('t.audit_time',$this->audit_time,true);
				$criteria->compare('t.audit_admin',$this->audit_admin,true);
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
