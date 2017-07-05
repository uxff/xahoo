<?php

class SysNode extends SysNodeBase {

        /**
         * @return array validation rules for model attributes.
         */
        public function rules() {
                //新增的在这里面加，如果修改 需要修改父类中的Rules
                $curRules = array(
                );
                return array_merge(parent::rules(), $curRules);
        }

        /**
         * @return array relational rules.
         */
        public function relations() {
                $curRelations = array(
                    'parent' => array(self::HAS_ONE, 'SysNode', '', 'on' => 't.pid = parent.id'),
                );
                return array_merge(parent::relations(), $curRelations);
        }

        /**
         * 与Smarrty中的文本提示相对应，可以修改成中文提示
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels() {
                $curLables = array(
                );
                return array_merge(parent::attributeLabels(), $curLables);
        }

        public function mySearch($pid = 0) {
                // @todo Please modify the following code to remove attributes that should not be searched.
                $criteria = $this->getBaseCDbCriteria();
                $criteria->order = 'id desc';
                //为$criteria新增设置
                $criteria->compare("t.pid", $pid);
                $count = $this->count($criteria);
                $pager = new CPagination($count);
                $pager->pageSize = !empty(Yii::app()->params['pageSize']) ? Yii::app()->params['pageSize'] : 10;
                $pager->pageVar = 'page'; //修改分页参数，默认为page
                $pager->params = array('type' => 'msg'); //分页中添加其他参数
                $pager->applyLimit($criteria);
                $list = $this->published()->findAll($criteria);
                $pages = array(
                    'curPage' => $pager->currentPage + 1,
                    'totalPage' => ceil($pager->itemCount / $pager->pageSize),
                    'pageSize' => $pager->pageSize,
                    'totalCount' => $pager->itemCount,
                    'url' => preg_replace("/&page=\d*[^&]/", "", Yii::app()->request->getUrl()) . "&page=",
                );
                return array('pages' => $pages, 'list' => $list);
        }

        public function getNodeTree($roleid = 0) {
                $rtn = $this->findAll();
                $array = OBJTool::convertModelToArray($rtn);

                //如果角色不为空，则查询所有role下的节点
                $accessNodes = array();
                if ($roleid) {
                        $rtn = OBJTool::convertModelToArray(SysAccess::model()->findAll("role_id=:role_id", array(':role_id' => $roleid)));
                        if ($rtn) {
                                foreach ($rtn as $value) {
                                        $accessNodes[] = $value['node_id'];
                                }
                        }
                }
                foreach ($array as $key => $value) {
                        if (in_array($value['id'], $accessNodes)) {
                                $array[$key]['access'] = 1;
                        } else {
                                $array[$key]['access'] = 0;
                        }
                }
                return OBJTool::find_child($array);
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

        public function loadParent() {
            if ($this->pid != 0) {
                if ($this->parent) {
                    return $this->parent->loadParent();
                }
                return $this->parent = SysNode::model()->with('parent')->findByPk($this->pid);
            }
        }
}
