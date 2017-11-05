<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

        protected $smarty = '';
        public $_layoutTpl = 'layouts/default.tpl';

        public function init() {
                $this->smarty = Yii::app()->smarty;
                $this->smarty->_layoutTpl = $this->_layoutTpl;
        }

        /**
         * @var string the default layout for the controller view. Defaults to '//layouts/column1',
         * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
         */
        public $layout = 'layouts/default.tpl';

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

        /**
         * get prameters from request
         * 
         * @param  string $name 请求参数
         * @return mixed
         */
        public function getParam($name) {
                return Yii::app()->request->getParam($name);
        }

        /**
         * [beforeAction description]
         * @param  [type] $action [description]
         * @return [type]         [description]
         */
        protected function beforeAction($action) {
                $curController = strtolower($this->id);
                $curAction = strtolower($this->action->id);

                return true;
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
                $_mz_utm_source = false;
                if(isset($_GET['_mz_utm_source'])){
                    $_mz_utm_source = $this->getInt($_GET['_mz_utm_source']);
                }
                $this->smarty->assign('_mz_utm_source', $_mz_utm_source);
                // schema
                $schema = Yii::app()->getRequest()->getIsSecureConnection() ? 'https' : 'http';

                //$jssdk = new JSSDK('wxfa0715ef755604a4', '4e71b452f06a732416d2d3a522c6ebc3');

                $weiChatAppId = Yii::app()->params['weichat']['AppId'];
                $weiChatAppScret = Yii::app()->params['weichat']['AppScret'];
                $jssdk = new JSSDK($weiChatAppId, $weiChatAppScret);

                $currentUrl = Yii::app()->request->getHostInfo() . Yii::app()->request->url;
                $signPackage = $jssdk->GetSignPackage($currentUrl);

                $this->smarty->assign('signPackage', $signPackage);

                $this->smarty->assign('currentUrl', Yii::app()->request->getHostInfo() . Yii::app()->request->url);
                // resource路径
                $this->smarty->assign('resourcePath', Yii::app()->getRequest()->getHostInfo($schema) . Yii::app()->params['resourcePath']);
                $this->smarty->assign('resourceThirdVendorPath', Yii::app()->getRequest()->getHostInfo($schema) . Yii::app()->params['resourceThirdVendorPath']);
                $this->smarty->assign('protectedPath', Yii::app()->getRequest()->getHostInfo($schema) . '/protected');

                //  HTTP服务器地址
                $this->smarty->assign('httpServer', Yii::app()->getRequest()->getHostInfo('http'));
                $this->smarty->assign('httpsServer', Yii::app()->getRequest()->getHostInfo('https'));
                //
                $this->smarty->assign('indexUrl', Yii::app()->getRequest()->getHostInfo($schema));

                // pageSize
                $this->smarty->assign('pageSize', Yii::app()->params['pageSize']);

                // 页头
                $this->smarty->assign('gShowHeader', false);
                // 显示页脚
                $this->smarty->assign('gShowFooter', true);
                // 是否登录状态
                $this->smarty->assign('gIsGuest', Yii::app()->loginUser->getIsGuest());
                //显示昵称
                if (Yii::app()->loginUser->getIsGuest()) {
                        $this->smarty->assign('member_nickname', '');
                } else {
                        $userinfo = Yii::app()->loginUser->getUserInfo();
                        if(!empty($userinfo['member_nickname'])){
                                $this->smarty->assign('member_nickname', $userinfo['member_nickname']);
                        }else{
                                $this->smarty->assign('member_nickname', substr_replace(Yii::app()->loginUser->getUserName(), '****', 3, 4));
                        }	
                }

                // 当前Controller ID
                // TODO 优化方案
                $this->smarty->assign('gCurrCtrId', strtolower($this->id));
                // 当前Action ID
                $this->smarty->assign('gCurrActId', strtolower($this->action->id));
                // php_self
                $this->smarty->assign('phpSelf', strtolower(substr($_SERVER['PHP_SELF'], 1)));

                // 百度tracking key
                $this->smarty->assign('baiduTrackingKey', Yii::app()->params['baiduTrackingKey']);

                // 指定配置变量
                if (!empty($data)) {
                        foreach ($data as $key => $val) {
                                $this->smarty->assign($key, $val);
                        }
                }

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

        /**
         * 获取用户中心绝对URL
         * NOTE1: 使用配置文件中UCenterServerName，没有设置则使用当前host
         * NOTE2: UCenter不需要静态化操作
         * 
         * @param  string·   $route     页面路由
         * @param  array     $params    页面参数列表
         * @return string               绝对路径
         */
        public function createUCenterUrl($route, $params = array()) {
                // 生成url
                $ucenterUrl = $this->createOtherAppUrl('UCenterServerName', $route, $params);

                return $ucenterUrl;
        }

        /**
         * 获取分权绝对URL
         * 
         * @param  string·   $route     页面路由
         * @param  array     $params    页面参数列表
         * @return string               绝对路径
         */
        public function createXqsjFQServerUrl($route, $params = array()) {
                // 生成url
                $ucenterUrl = $this->createOtherAppUrl('XqsjFQServerName', $route, $params);

                return $ucenterUrl;
        }

        /**
         * 获取众筹绝对URL
         * 
         * @param  string·   $route     页面路由
         * @param  array     $params    页面参数列表
         * @return string               绝对路径
         */
        public function createXqsjZCServerUrl($route, $params = array()) {
                // 生成url
                $ucenterUrl = $this->createOtherAppUrl('XqsjZCServerName', $route, $params);

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

        public function showJson($arr) {
            header('Content-type: application/json');
            $data = @json_encode($arr);
            header('Content-Length: '.strlen($data));
            echo $data;
            Yii::app()->end();
        }
        /*
            返回固定格式的错误
        */
        public function jsonData($msg, $code=1, $value = array(), $returnUrl = '') {
            $arr = array(
                'code' => $code,
                'msg' => $msg,
                'value' => $value,
                'returnurl' => $returnUrl,
            );
            return $this->showJson($arr);
        }
        /*
            返回固定格式的错误
        */
        public function jsonError($msg, $value = array(), $returnUrl = '', $code = 1) {
            return $this->jsonData($msg, $code, $value, $returnUrl);
        }
        /*
            返回固定格式的错误
        */
        public function jsonSuccess($msg, $value = array(), $returnUrl = '', $code = 0) {
            return $this->jsonData($msg, $code, $value, $returnUrl);
        }

        /*
            来源是微信的将openid绑定到session
            @param $sns_id  第三方帐号编号
            @param $appid   第三方官方appid
            @param $plat    第三方平台 1=微信 2=微博
        */
        public function setThirdPartSession($sns_id, $appid, $plat=1) {
            //session_start();
            if (!empty($openid) && !empty($appid)) {
                // 设置session
                $value = [
                    'sns_id' => $sns_id,
                    'appid'  => $appid,
                    'plat'   => $plat,
                ];
                $name = Yii::app()->params['third_login_sess_name'];//'thirdauth';
                $_SESSION[$name] = $value;
                //$cookie = new CHttpCookie($name, $openid);  
                //Yii::app()->request->cookies[$name] = $cookie;  
            } else {
                Yii::log('第三方登录信息为空: sns_id='.$sns_id.' appid='.$appid.' plat='.$plat.' ', 'warning', __METHOD__);
            }
        }
}
