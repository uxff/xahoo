<?php

class MobileModule extends CWebModule {

        public function init() {
                // this method is called when the module is being created
                // you may place code here to customize the module or the application
                // import the module-level models and components
                $this->setImport(array(
                    'mobile.controllers.*',
                    'mobile.models.*',
                    'application.models.*',
                    'application.components.*',
                    'application.controllers.*',
                ));
        }

        public function beforeControllerAction($controller, $action) {
                if (parent::beforeControllerAction($controller, $action)) {
                        // this method is called before any module controller action is performed
                        // you may place customized code here
                        return true;
                } else {
                        return false;
                }
        }
        
        public function sendSMS(){
            return new sendSMS;
        }

        /**
         * 将Yii模型对象转为数组(多维)
         *
         * @param  object $models          [description]
         * @param  array $filterAttributes [description]
         * @return array                   [description]
         *
         * @todo 格式化
         */
        public function convertModelToArray($models, array $filterAttributes = null) {
            return OBJTool::convertModelToArray($models, $filterAttributes);
        }
        
}
