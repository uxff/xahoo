<?php

/**
 * This is the model class for table "uc_applications".
 *
 * The followings are the available columns in table 'uc_applications':
 * @property integer $appid
 * @property string $type
 * @property string $name
 * @property string $url
 * @property string $authkey
 * @property string $ip
 * @property string $viewprourl
 * @property string $apifilename
 * @property string $charset
 * @property string $dbcharset
 * @property integer $synlogin
 * @property integer $recvnote
 * @property string $extra
 * @property string $tagtemplates
 * @property string $allowips
 */
class UcApplicationsBase extends UCenterActiveRecord {

        /**
         * @return string the associated database table name
         */
        public function tableName() {
                return 'uc_applications';
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
        public function rules() {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                    array('viewprourl, extra, tagtemplates, allowips', 'required'),
                    array('synlogin, recvnote', 'numerical', 'integerOnly' => true),
                    array('type', 'length', 'max' => 16),
                    array('name', 'length', 'max' => 20),
                    array('url, authkey, viewprourl', 'length', 'max' => 255),
                    array('ip', 'length', 'max' => 15),
                    array('apifilename', 'length', 'max' => 30),
                    array('charset, dbcharset', 'length', 'max' => 8),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('appid, type, name, url, authkey, ip, viewprourl, apifilename, charset, dbcharset, synlogin, recvnote, extra, tagtemplates, allowips', 'safe', 'on' => 'search'),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                // NOTE: you may need to adjust the relation name and the related
                // class name for the relations automatically generated below.
                return array(
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                return array(
                    'appid' => 'Appid',
                    'type' => 'Type',
                    'name' => 'Name',
                    'url' => 'Url',
                    'authkey' => 'Authkey',
                    'ip' => 'Ip',
                    'viewprourl' => 'Viewprourl',
                    'apifilename' => 'Apifilename',
                    'charset' => 'Charset',
                    'dbcharset' => 'Dbcharset',
                    'synlogin' => 'Synlogin',
                    'recvnote' => 'Recvnote',
                    'extra' => 'Extra',
                    'tagtemplates' => 'Tagtemplates',
                    'allowips' => 'Allowips',
                );
        }

        /**
         * 定义基础的搜索条件，不要改动
         * @return \CDbCriteria
         */
        public function getBaseCDbCriteria() {
                $criteria = new CDbCriteria;

                $criteria->compare('appid', $this->appid);
                $criteria->compare('type', $this->type, true);
                $criteria->compare('name', $this->name, true);
                $criteria->compare('url', $this->url, true);
                $criteria->compare('authkey', $this->authkey, true);
                $criteria->compare('ip', $this->ip, true);
                $criteria->compare('viewprourl', $this->viewprourl, true);
                $criteria->compare('apifilename', $this->apifilename, true);
                $criteria->compare('charset', $this->charset, true);
                $criteria->compare('dbcharset', $this->dbcharset, true);
                $criteria->compare('synlogin', $this->synlogin);
                $criteria->compare('recvnote', $this->recvnote);
                $criteria->compare('extra', $this->extra, true);
                $criteria->compare('tagtemplates', $this->tagtemplates, true);
                $criteria->compare('allowips', $this->allowips, true);
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
        public function search() {
                // @todo Please modify the following code to remove attributes that should not be searched.

                $criteria = $this->getBaseCDbCriteria();

                return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your UCenterActiveRecord descendants!
         * @param string $className active record class name.
         * @return SysNode the static model class
         */
        public static function model($className = __CLASS__) {
                return parent::model($className);
        }

}
