<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

        protected $smarty = '';
        public $_layoutTpl = 'layouts/ace.tpl';

        public function init() {
                $this->checkLogin();
                $this->smarty = Yii::app()->smarty;
                $this->smarty->_layoutTpl = $this->_layoutTpl;
        }

        /**
         * @var string the default layout for the controller view. Defaults to '//layouts/column1',
         * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
         */
        public $layout = 'layouts/ace.tpl';

        /**
         * @var array context menu items. This property will be assigned to {@link CMenu::items}.
         */
        public $menu = array();

        /**
         * @var array the breadcrumbs of the current page. The value of this property will
         * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
         * for more details on how to specify this property.
         */
        public $breadcrumbs = array();

        /**
         * process parameter to integer for security
         * 
         * @param  string           $str
         * @return integer|null     
         */
        public function getInt($str) {
                if (!isset($str)) {
                        return null;
                } else {
                        return intval($str);
                }
        }

        protected function checkNode($node_id, $access_id) {
                return in_array($node_id, $access_id);
        }

        protected function beforeAction($action) {
                $curController = strtolower($this->id);
                $curAction = strtolower($this->action->id);
                $viewIdentify = $curController . "/" . $curAction; //每个访问节点的唯一标识
                $allowed = $this->getAllAllowed();
                return true;
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

                if (Yii::app()->memberadmin->getIsGuest()) {
                        $this->redirect(array("site/login"));
                } else {

                        //查找访问的action对应的node,如果没有节点设置 则默认为可以访问。即不在配置中的节点均可自由访问，针对新增节点还未进行权限配置的情况
                        //拿controller对应的节点，拿action对应的节点 modify →
                        //通过controller和action确定的唯一标识获取
                        $viewNodeId = 0;
                        $viewNodeRes = SysNode::model()->find('LOWER(name)=? and level=3', array($viewIdentify));

                        if ($viewNodeRes) {
                                $viewNodeId = $viewNodeRes->id;
                        } else {
                                //throw new CHttpException(403, '没有权限');
                        }
                        /**
                          $controllerNodeId = $groupNodeId = $actionNodeId = 0;
                          $controllerNodeRes = SysNode::model()->find('LOWER(name)=? and level=2', array($curController));
                          if ($controllerNodeRes) {
                          $controllerNodeId = $controllerNodeRes->id;
                          } else {
                          //throw new CHttpException(403, '没有权限');
                          }
                          $actionNodeRes = SysNode::model()->find('LOWER(name)=:name and pid=:pid and  level=3', array(":name" => $curAction, ":pid" => $controllerNodeId));

                          if ($actionNodeRes) {
                          $actionNodeId = $actionNodeRes->id;
                          } else {
                          //throw new CHttpException(403, '没有权限');
                          }
                          $groupNodeRes = SysNode::model()->find('LOWER(name)=:name and  level=2 and pid=0', array(":name" => $curController . "/" . $curAction));
                          if ($groupNodeRes) {
                          $groupNodeId = $groupNodeRes->id;
                          } else {

                          }
                          if ($controllerNodeId || $actionNodeId || $groupNodeId) {

                          } else {
                          throw new CHttpException(403, '没有权限');
                          }
                         * 
                         */

                        //如果节点存在，则获取角色 角色获取不到则当前用户不具备访问系统的权限，即要求用户在创建时配置角色
                        if (Yii::app()->memberadmin->getRole()) {
                                $role = Yii::app()->memberadmin->getRole();
                        } else {
                                throw new CHttpException(403, '没有权限');
                        }

                        //echo $curNodeId;
                        $roleAccess = OBJTool::convertModelToArray(SysAccess::model()->findAllByAttributes(array('role_id' => $role)));
                        if ($roleAccess) {
                                $nodeIds = array();
                                foreach ($roleAccess as $value) {
                                        $nodeIds[] = $value['node_id'];
                                }
                                if (in_array($viewNodeId, $nodeIds)) {
                                        return true;
                                } else {
                                        throw new CHttpException(403, '没有权限');
                                }
                                /**
                                  if ($controllerNodeId && $actionNodeId) {
                                  if (in_array($actionNodeId, $nodeIds)) {
                                  return true;
                                  } else {
                                  throw new CHttpException(403, '没有权限');
                                  }
                                  } elseif ($groupNodeId) {
                                  if (in_array($groupNodeId, $nodeIds)) {
                                  return true;
                                  } else {
                                  throw new CHttpException(403, '没有权限');
                                  }
                                  } else {
                                  throw new CHttpException(403, '没有权限');
                                  }
                                 * *
                                 */
                        } else {
                                throw new CHttpException(403, '没有权限');
                        }
                }
                return true;
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

        /**
         * process parameter to string for security
         * 
         * @param  string $str 
         * @return string
         */
        public function getString($str) {
                $str = trim($str);
                return addslashes($str);
        }

        /**
         * process parameter to string for security
         * 
         * @param  string $str 
         * @return string
         */
        public function outPutString($str) {
                $str = trim($str);
                return htmlspecialchars($str, ENT_NOQUOTES);

        }

        public function getParam($name) {
                return Yii::app()->request->getParam($name);
        }

        /**
         * render a view with data
         * 
         * @param  string  $view   [description]
         * @param  array   $data   [description]
         * @param  boolean $return [description]
         * @return [type]          [description]
         *
         * @todo 完善此部分逻辑，提高渲染灵活性
         */
        public function smartyRender($view, $data = array(), $return = false) {
                // 设置layout布局文件
                if (!empty($this->layout)) {
                        $this->smarty->setLayoutTpl($this->layout);
                }

                // 后台resource路径
                $this->smarty->assign('resourcePath', Yii::app()->params['resourcePath']);
                $this->smarty->assign('resourceBasePath', Yii::app()->params['resourceBasePath']);

                // 指定配置变量
                if (!empty($data)) {
                        foreach ($data as $key => $val) {
                                $this->smarty->assign($key, $val);
                        }
                }
                //引入菜单
                $sideMenu = new MemberSideMenu();
                $menus = $sideMenu->getMenu();

                //设置登录信息
                $this->smarty->assign('loginUser', Yii::app()->memberadmin->name);
                //设置菜单
                $this->smarty->assign('menus', $menus);
                // 获取对应每个页面js文件名
                $jsFile = substr($view, 0, strrpos($view, '.tpl')) . '.js.tpl';
                // smarty渲染
                $this->smarty->display($view, $jsFile);
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

        public function showAjaxJson($arr) {
            header('Content-type: application/json');
            echo @json_encode($arr);
        }

        /**
         * 获取房乎前台绝对URL
         * 
         * @param  string·   $route     页面路由
         * @param  array     $params    页面参数列表
         * @return string               绝对路径
         */
        public function createFanghuServerUrl($route, $params = array()) {
                // 生成url
                $ucenterUrl = $this->createOtherAppUrl('FanghuServerName', $route, $params);

                return $ucenterUrl;
        }

        /**
         * 获取其他app的绝对URL
         * NOTE: 使用配置文件中XXServerName，没有设置则使用当前host
         * 
         * @param  string    $route     页面路由
         * @param  array     $params    页面参数列表
         * @return string               绝对路径
         */
        public function createOtherAppUrl($serverName, $route = '', $params = array()) {
                // 路由参数设置
                $urlRoute = '';
                $urlParams = array();
                if (!empty($route)) {
                        $urlRoute = $route;
                }
                if (!empty($params)) {
                        $urlParams = $params;
                }
                // 判断协议
                $schema = Yii::app()->getRequest()->getIsSecureConnection() ? 'https' : 'http';

                // 生成url
                $otherAppUrl = Yii::app()->params[$serverName];
                if (substr($otherAppUrl, 0, 4) != 'http') {
                    $otherAppUrl = $schema .'://'.$otherAppUrl;
                }
                if (empty($otherAppUrl)) {
                    $otherAppUrl = Yii::app()->getRequest()->getHostInfo($schema);
                    $otherAppUrl .= Yii::app()->createUrl($urlRoute, $urlParams);
                } else {
                        $url = Yii::app()->createUrl($urlRoute, $urlParams);
                        $replace = Yii::app()->getRequest()->getScriptUrl();
                        //left trim current script url
                        $otherAppUrl .= (stripos($url, $replace) === 0) ? substr_replace($url, '', 0, strlen($replace)) : $url;
                }

                return $otherAppUrl;
        }
        public function checkLogin() {
            if ($this->id != 'site' 
             //&& ($this->action->id != 'login' && $this->action->id != 'logout')
             ) {
                $adminId = Yii::app()->memberadmin->id;
                if (!$adminId) {
                    $this->redirect(array('site/login'));
                }
            }
            
        }

    // 导出为xml
    public function downloadCsv($data, $ths=[], $saveName = '') {
        if (empty($saveName)) {
            $saveName = date('YmdHis').'.csv';
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        //header("Content-Type:application/vnd.ms-execl");
        header("Content-type:text/csv");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$saveName.'"');
        header("Content-Transfer-Encoding:binary");

        $fp = fopen('php://output', 'w');

        // 输出头
        //$ths = array('订单编号','商户订单号','项目名称','客户姓名','身份证号','手机号','注册账号','支付平台','支付账号','支付用户名','卡价','优惠金额','认购总价','购买份数','实收金额','购买日期','订单状态','购卡方式','退款金额','退款手续费金额','申请退款日期','退款发起人','客户邮寄地址','备注');
        //$ths = FqFenquanOrder::model()->getReportAttrLabels();
        $thi = 0;
        foreach ($ths as &$thV) {
            //fputcsv($fp, $fields);
            $thV = mb_convert_encoding($thV, 'gbk', 'utf-8');
        }
        @fputcsv($fp, $ths);
        // 数据行
        if (!empty($data))
        foreach ($data as $row) {
            foreach($row as &$rowVal) {
                $rowVal = mb_convert_encoding($rowVal, 'gbk', 'utf-8');
                $rowVal = "\t".$rowVal;
            }
            @fputcsv($fp, $row);
        }

        @fclose($fp);
    }
    /*
        将搜索结果制作成xls内存对象
        @return PHPExcel $objPHPExcel
    */
    public function makeExcel($data, $xlxHeads=[]) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        //
        //$objPHPExcel->getActiveSheet()->setCellValue('A1', 'String');
        // 头行
        //$xlsHeads = array('订单编号','商户订单号','项目名称','客户姓名','身份证号','手机号','注册账号','支付平台','支付账号','支付用户名','卡价','优惠金额','应收金额','购买份数','实收金额','购买日期','订单状态','购卡方式','退款金额','退款手续费金额','申请退款日期','退款发起人','客户邮寄地址','备注');
        //$xlsHeads = FqFenquanOrder::model()->getReportAttrLabels();
        $thi = 0;
        foreach ($xlsHeads as $thV) {
            $thX = PHPExcel_Cell::stringFromColumnIndex($thi);
            $thY = '1';
            $objPHPExcel->getActiveSheet()->setCellValue($thX.$thY, $thV);
            ++$thi;
        }
        // 数据行
        
        return $objPHPExcel;
    }
    /*
        将内容直接让浏览器下载xls
        @param  PHPExcel $objPHPExcel   // php excel 操作对象 内存对象
        @param  string   $saveName      // 保存的文件名
        @param  格式
    */
    public function downloadExcel($objPHPExcel, $saveName) {
        //$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$saveName.'"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }
    /*
        将内容直接让浏览器下载xls
        @param  array    $data          // 数据内容 列表
        @param  array    $heads         // 表头
        @param  string   $saveName      // 保存的文件名
    */
    public function downloadXls($data=[], $heads=[], $saveName='') {
        //$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $thi = 0;
        // 写表头
        foreach ($heads as $thV) {
            $thX = PHPExcel_Cell::stringFromColumnIndex($thi);
            $thY = '1';
            $objPHPExcel->getActiveSheet()->setCellValue($thX.$thY, $thV);
            ++$thi;
        }
        // 写表内容
        foreach ($data as $lineNo=>$lineData) {
            $colNo = 0;
            // 行坐标
            $thY = $lineNo+2;
            foreach ($lineData as $colName=>$colValue) {
                // 列坐标
                $thX = PHPExcel_Cell::stringFromColumnIndex($colNo++);
                $objPHPExcel->getActiveSheet()->setCellValue($thX.$thY, $colValue);
            }
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$saveName.'"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }
}
