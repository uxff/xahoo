<?php

class RBAC {

        public $accessNodes = array();
        private $viewIdentify;

        public function __construct() {
                //检查role
                if (Yii::app()->admin->getIsGuest()) {
                        $this->redirect(array("site/login"));
                } else {
                        if (Yii::app()->admin->getRole()) {
                                $role = Yii::app()->admin->getRole();
                        } else {
                                throw new CHttpException(403, '没有权限');
                        }
                        $roleAccess = OBJTool::convertModelToArray(SysAccess::model()->findAllByAttributes(array('role_id' => $role)));
                        if ($roleAccess) {
                                foreach ($roleAccess as $value) {
                                        $this->accessNodes[] = $value['node_id'];
                                }
                        } else {
                                throw new CHttpException(403, '没有权限');
                        }
                }
                $curController = strtolower(Yii::app()->controller->id);
                $curAction = strtolower(Yii::app()->controller->action->id);
                $this->viewIdentify = $curController . "/" . $curAction;
        }

        public static function init() {
                
        }

        public function checkAccess($viewIdentify = '') {
                $allowed = $this->getAllAllowed();
                //return true;
                if (!empty(Yii::app()->params->authDebug) && Yii::app()->params->authDebug) {
                        return true; //如果设置了debug 则权限设置不生效
                }
                if ($curController == 'api') {
                        return true; //api接口自己实现,api不继承这个类了 所以这里已经没用了
                }

                if (!empty($allowed[$curController]) && ($allowed[$curController] == "*" || in_array($curAction, $allowed[$curController]))) {
                        return true;
                }
                $viewNodeId = $this->getNodeId($viewIdentify);
                if ($viewNodeId) {
                        if (in_array($viewNodeId, $this->accessNodes)) {
                                return true;
                        } else {
                                return false;
                        }
                } else {
                        return false;
                }
        }

        private function getNodeId($viewIdentify = '') {
                if ($viewIdentify) {
                        $this->viewIdentify = $viewIdentify;
                }
                $viewNodeId = 0;
                $viewNodeRes = SysNode::model()->find('LOWER(name)=? and level=3', array($this->viewIdentify));

                if ($viewNodeRes) {
                        $viewNodeId = $viewNodeRes->id;
                }
                return $viewNodeId;
        }

        private function getAllAllowed() {
                return array(
                    'site' => array('login', 'logout', 'error', 'welcome'),
                    'webview' => "*",
                    'ajax' => "*",
                    'upload' => "*",
                    'index' => '*',
                );
        }

}

?>