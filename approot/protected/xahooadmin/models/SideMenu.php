<?php

class SideMenu {

        public function getMenu() {
                if (Yii::app()->admin->getIsGuest()) {
                        return array();
                }
                $arr = SysNode::model()->getNodeTree(Yii::app()->admin->getRole()); //
                //print_r($arr);
                $visitController = Yii::app()->getController()->id;
                $visitAction = Yii::app()->getController()->getAction()->id;
                $menus = array();
                $activeParent = $activeChild = '';
                foreach ($arr as $key => $value) {
                        if ($value['access'] && $value['display']) {
                                $menus[$key] = array(
                                    'name' => $value['title'],
                                    'url' => $value['url'],
                                    'menu_icon' => $value['icon'],
                                    'active' => '',
                                );
                                if (strtolower($value['name']) == strtolower($visitController) || strtolower($value['name']) == strtolower($visitController) . "/" . strtolower($visitAction)) {
                                        $menus[$key]['active'] = 'active open';
                                }
                                if ($value['child']) {
                                        $submenus = array();
                                        foreach ($value['child'] as $k => $v) {
                                                if ($v['access'] && $v['display']) {
                                                        $submenus[$k] = array(
                                                            'name' => $v['title'],
                                                            'url' => $v['url'],
                                                            'menu_icon' => 'fa-leaf',
                                                            'active' => '',
                                                        );
                                                        list($controller, ) = explode("/", strtolower($v['name']));
                                                        if ($controller == strtolower($visitController)) {
                                                                $menus[$key]['active'] = 'active open';
                                                                $submenus[$k]['active'] = 'active';
                                                        }
                                                }
                                        }
                                        $menus[$key]['submenu'] = $submenus;
                                }
                        }
                }
                return $menus;
        }

}

?>