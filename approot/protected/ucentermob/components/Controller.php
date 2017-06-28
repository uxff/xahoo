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

        // schema
        $schema = Yii::app()->getRequest()->getIsSecureConnection() ? 'https' : 'http';

        // resource路径
        $this->smarty->assign('resourcePath', Yii::app()->getRequest()->getHostInfo($schema) . Yii::app()->params['resourcePath']);
        $this->smarty->assign('protectedPath', Yii::app()->getRequest()->getHostInfo($schema) . '/protected');
        $this->smarty->assign('resourceThirdVendorPath', Yii::app()->getRequest()->getHostInfo($schema) . Yii::app()->params['resourceThirdVendorPath']);

        //  HTTP服务器地址
        $this->smarty->assign('httpServer', Yii::app()->getRequest()->getHostInfo('http'));
        $this->smarty->assign('httpsServer', Yii::app()->getRequest()->getHostInfo('https'));
        //
        $this->smarty->assign('indexUrl', Yii::app()->getRequest()->getHostInfo($schema));
        //帮助中心
        $this->smarty->assign('xqsjIndexUrl', $this->createXqsjUrl('site/index'));
        $this->smarty->assign('xqsjmobUcenterIndexUrl', $this->createXqsjUrl('customer/index'));
        $this->smarty->assign('mobHelpIndexUrl', $this->createXqsjUrl('help/index'));
        $this->smarty->assign('mobHelpAboutUrl', $this->createXqsjUrl('help/aboutUs'));
        // pageSize
        $this->smarty->assign('pageSize', Yii::app()->params['pageSize']);

        // 页头
        $this->smarty->assign('gShowHeader', true);
        // 显示页脚
        $this->smarty->assign('gShowFooter', true);
        // 是否登录状态
        $this->smarty->assign('gIsGuest', Yii::app()->loginUser->getIsGuest());
        //显示昵称
        if (Yii::app()->loginUser->getIsGuest()) {
            $this->smarty->assign('member_nickname', '');
            $this->smarty->assign('userUrl', '');
            //$urlReferrer = Yii::app()->request->urlReferrer;
            $this->smarty->assign('urlReferrer', $this->createOtherAppUrl('XqsjServerName','site/index'));
        } else {
            $userinfo = Yii::app()->loginUser->getUserInfo();
            if (!empty($userinfo['member_nickname'])) {
                $this->smarty->assign('member_nickname', $userinfo['member_nickname']);
            } else {
                $this->smarty->assign('member_nickname', substr_replace(Yii::app()->loginUser->getUserName(), '****', 3, 4));
            }
            $cookie = Yii::app()->request->getCookies();
            $return_url = $cookie['return_url']->value;
            $this->smarty->assign('userUrl', $return_url);
        }


        // 当前Controller ID
        // TODO 优化方案
        $this->smarty->assign('gCurrCtrId', strtolower($this->id));

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
     * 获取首页绝对URL
     * NOTE1: 使用配置文件中XqsjServerName，没有设置则使用当前host
     * NOTE2: UCenter不需要静态化操作
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public function createXqsjUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = $this->createOtherAppUrl('XqsjServerName', $route, $params);

        return $ucenterUrl;
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
     * 获取xahoo绝对URL
     * 
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public function createFanghuUrl($route, $params = array()) {
        // 生成url
        $ucenterUrl = $this->createOtherAppUrl('FanghuServerName', $route, $params);

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

    /**
     * [doGet description]
     * @param  [type]  $url     [description]
     * @param  array   $params  [description]
     * @param  array   $headers [description]
     * @param  integer $timeout [description]
     * @return [type]           [description]
     */
    public function doGet($url, $params = array(), $headers = array(), $timeout = 30) {
        // 初始化URL
        if (!empty($params) && is_array($params)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params, null, '&');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // 以返回的形式接收信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 设置为POST方式
        curl_setopt($ch, CURLOPT_GET, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        // 不验证https证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // 设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // 设置头信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // 发送数据
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl URL: ' . $url . ' with GET error:' . curl_error($ch);
        }

        // 不要忘记释放资源
        curl_close($ch);

        return $response;
    }

    /**
     * 发起一个post请求到指定接口
     * 
     * @param string   $url       请求的接口
     * @param array    $params    post参数
     * @param array    $headers   http头新新
     * @param integer  $timeout   超时时间
     * @return string  请求结果
     */
    public function doPost($url, $params = array(), $headers = array(), $timeout = 30) {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Accept: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // 以返回的形式接收信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 设置为POST方式
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        // 不验证https证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // 设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        // 设置头信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // 发送数据
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl URL: ' . $url . ' with POST error:' . curl_error($ch);
        }

        // 解析json为数组
        $arrResult = json_decode($response, true);

        // 不要忘记释放资源
        curl_close($ch);

        return $arrResult;
    }
    
    /**
     * 获取房否API地址
     *
     * @param  string·   $route     页面路由
     * @param  array     $params    页面参数列表
     * @return string               绝对路径
     */
    public function createFangFullApiUrl($route = '', $params = array()) {
        // 生成url
        $url = Yii::app()->params['FangFullServerName'];
        if (empty($url)) {
            $url = 'http://test.fangfull.com';
        }
        if (!empty($route)) {
            $url .= '/index.php?r='.$route;
        }
        if (!empty($params)) {
            $url .= '&'.http_build_query($params);
        }
    
        return $url;
    }

    /**
     * 判断是否已经登录
     */
    public function checkLogin($return_url = null) {
        if (empty($return_url)) {
            $retrn_url = $this->checkReturnUrl();
        }
        $Params = array(
            'return_url' => $return_url,
        );
        $isGuest = Yii::app()->loginUser->getIsGuest();
        // 未登录
        if ($isGuest) {
            $this->redirect($this->createAbsoluteUrl('user/login', $Params));
        } else {
            return Yii::app()->loginUser->getUserId();
        }
    }

    /**
     * 返回来源链接
     */
    public function checkReturnUrl() {
        if (!empty($_GET['return_url'])) {
            $return_url = $this->getString($_GET['return_url']);
            $cookie = new CHttpCookie('return_url', $return_url);
            $cookie->domain = substr(Yii::app()->request->hostInfo, strpos(Yii::app()->request->hostInfo, "."));
            $cookie->expire = time() + 60 * 60 * 24;  //有限期1天
            Yii::app()->request->cookies['return_url'] = $cookie;
            $cookie = Yii::app()->request->getCookies();
        } else {
            $cookie = Yii::app()->request->getCookies();
            if (isset($cookie['return_url'])) {
                $return_url = $cookie['return_url']->value;
            } else {
                $return_url = '/';
            }
        }
        return $return_url;
    }

    /**
     * 图片上传处理func
     */
    public function getFileName($cUpfile) {
        $news_name1 = date("YmdHis") . time() . rand(100, 999);
        $news_name = $news_name1 . "." . $cUpfile->extensionName;
        return $news_name;
    }

    public function upload_dir() {

        $root_folder = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

        //创建upload根目录
        if (!file_exists($root_folder)) {
            mkdir($root_folder);
        }

        $uppath = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR;

        //创建月份目录
        if (!file_exists($uppath)) {
            mkdir($uppath, 0777);
        }
        $rtpath = $paths = array();
        //创建尺寸目录
        $rtpath['ori'] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . "o" . DIRECTORY_SEPARATOR;

        $rtpath['thumb'][] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . Yii::app()->params['uploadPic']['appUserPhotoWidth'] . 'x' . Yii::app()->params['uploadPic']['appUserPhotoHeight'] . DIRECTORY_SEPARATOR;

        foreach ($paths as $value) {
            if (!file_exists($value)) {
                mkdir($value, 0777);
            }
        }
        $rtpath['url'] = Yii::app()->params['uploadPic']['webPath'] . date("Ym") . "/";
        return $rtpath;
    }

    /**
     * 会员注册初始化数据
     */
    public function MemberRegisterInit($member_id, $parent_id = 0) {

        $objpointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => 'register'));
        if (!empty($objpointRule)) {
            //写积分日志
            $MemberPointLog = new UcMemberPointLog();
            $MemberPointLog->member_id = $member_id;
            $MemberPointLog->rule_id = $objpointRule->rule_id;
            $MemberPointLog->rule_point = $objpointRule->rule_point;
            $MemberPointLog->operate_type = 1;
            $MemberPointLog->description = $objpointRule->rule_name;
            $MemberPointLog->point_before = 0;
            $MemberPointLog->point_after = $objpointRule->rule_point;
            $MemberPointLog->source = '';
            $MemberPointLog->create_time = date('Y-m-d H:i:s', time());
            $MemberPointLog->insert();

            //写贡献日志
            $MemberContributeLog = new UcMemberContributeLog();
            $MemberContributeLog->member_id = $member_id;
            $MemberContributeLog->contribute_before = 0;
            $MemberContributeLog->contribute_after = $objpointRule->rule_contribution;
            $MemberContributeLog->contribute_score = $objpointRule->rule_contribution;
            $MemberContributeLog->description = $objpointRule->rule_name;
            $MemberContributeLog->source = '';
            $MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
            $MemberContributeLog->insert();

            //初始化会员总信息表
            $UcMemberTotal = new UcMemberTotal();
            $UcMemberTotal->member_id = $member_id;
            $UcMemberTotal->total_point = $objpointRule->rule_point;
            $UcMemberTotal->total_contribute = $objpointRule->rule_contribution;
            $UcMemberTotal->create_time = date('Y-m-d H:i:s', time());
            $UcMemberTotal->last_modified = date('Y-m-d H:i:s', time());
            $UcMemberTotal->insert();
        }


        if ($parent_id != 0) {
            $objpointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => 'pro_register'));
            if (!empty($objpointRule)) {
                $objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $parent_id));
				if(!empty($objMemberTotal)){
					$point_before = $objMemberTotal->total_point;
					$contribute_before = $objMemberTotal->total_contribute;
					$objMemberTotal->total_point += $objpointRule->rule_point;
					$objMemberTotal->total_contribute += $objpointRule->rule_contribution;
					$objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
					$objMemberTotal->update();

					$MemberPointLog = new UcMemberPointLog();
					$MemberPointLog->member_id = $parent_id;
					$MemberPointLog->rule_id = $objpointRule->rule_id;
					$MemberPointLog->rule_point = $objpointRule->rule_point;
					$MemberPointLog->operate_type = 1;
					$MemberPointLog->description = $objpointRule->rule_name;
					$MemberPointLog->point_before = $point_before;
					$MemberPointLog->point_after = $point_before + $objpointRule->rule_point;
					$MemberPointLog->source = '';
					$MemberPointLog->create_time = date('Y-m-d H:i:s', time());
					$MemberPointLog->insert();

					$MemberContributeLog = new UcMemberContributeLog();
					$MemberContributeLog->member_id = $parent_id;
					$MemberContributeLog->contribute_score = $objpointRule->rule_contribution;
					$MemberContributeLog->contribute_before = $contribute_before;
					$MemberContributeLog->contribute_after = $contribute_before + $objpointRule->rule_contribution;
					$MemberContributeLog->source = '';
					$MemberContributeLog->description = $objpointRule->rule_name;
					$MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
					$MemberContributeLog->insert();

					//更新有小伙伴
					UcMember::model()->updateByPk($parent_id, array('has_children' => 1));
				}
            }
        }

        $MemberRelation = UcMemberRelation::model()->find('member_id=:member_id', array(':member_id' => $parent_id));
        if (!empty($MemberRelation)) {
            $parent_depth = $MemberRelation->parent_depth + 1;
            $parent_tree = empty($MemberRelation->parent_tree) ? $parent_id : $parent_id . ',' . $MemberRelation->parent_tree;
        } else {
            $parent_depth = 0;
            $parent_tree = '';
        }
        $MemberRelation = new UcMemberRelation();
        $MemberRelation->member_id = $member_id;
        $MemberRelation->parent_id = $parent_id;
        $MemberRelation->parent_depth = $parent_depth;
        $MemberRelation->parent_tree = $parent_tree;
        $MemberRelation->insert();

        if (0 != $MemberRelation->parent_id) {
            $this->_initRelationMap($MemberRelation->member_id, $MemberRelation->parent_tree, $MemberRelation->parent_id);
        }
    }

    /**
     * 添加积分贡献
     */
    public function addPoint($member_id, $action, $source = '') {

        $objpointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => $action));
        if (!empty($objpointRule)) {

            $objMemberTotal = UcMemberTotal::model()->find('member_id=:member_id', array('member_id' => $member_id));

			if(!empty($objMemberTotal)){
				//更新会员总信息表(积分和贡献)
				$objMemberTotal->total_point += $objpointRule->rule_point;
				$objMemberTotal->total_contribute += $objpointRule->rule_contribution;
				$objMemberTotal->last_modified = date('Y-m-d H:i:s', time());
				$objMemberTotal->update();

				$point_before = $objMemberTotal->total_point;
				$contribute_before = $objMemberTotal->total_contribute;

				//写积分日志
				$MemberPointLog = new UcMemberPointLog();
				$MemberPointLog->member_id = $member_id;
				$MemberPointLog->rule_id = $objpointRule->rule_id;
				$MemberPointLog->rule_point = $objpointRule->rule_point;
				$MemberPointLog->operate_type = 1;
				$MemberPointLog->description = $objpointRule->rule_name;
				$MemberPointLog->point_before = $point_before;
				$MemberPointLog->point_after = $point_before + $objpointRule->rule_point;
				$MemberPointLog->source = $source;
				$MemberPointLog->create_time = date('Y-m-d H:i:s', time());
				$MemberPointLog->insert();

				//写贡献日志
				$MemberContributeLog = new UcMemberContributeLog();
				$MemberContributeLog->member_id = $member_id;
				$MemberContributeLog->contribute_score = $objpointRule->rule_contribution;
				$MemberContributeLog->contribute_before = $contribute_before;
				$MemberContributeLog->contribute_after = $contribute_before + $objpointRule->rule_contribution;
				$MemberContributeLog->source = $source;
				$MemberContributeLog->description = $objpointRule->rule_name;
				$MemberContributeLog->create_time = date('Y-m-d H:i:s', time());
				$MemberContributeLog->insert();
			}
        }
    }

    /**
     * 检查积分日志
     */
    public function checkPointLog($member_id, $action) {
        $objpointRule = UcMemberPointRule::model()->find('rule_action=:rule_action and status=1', array('rule_action' => $action));
        if (!empty($objpointRule)) {
            $rule_id = $objpointRule->rule_id;
            $pointRuleNum = UcMemberPointLog::model()->count('rule_id=:rule_id and member_id=:member_id', array('rule_id' => $rule_id, 'member_id' => $member_id));
            if ($pointRuleNum > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * 初始化relation_map表信息
     */
    public function _initRelationMap($member_id, $parent_tree, $parent_id) {
        $parent_ids = explode(',', $parent_tree);
        foreach ($parent_ids as $k => $v) {
            $member_relation_map = new UcMemberRelationMap();
            $member_relation_map->member_id = $member_id;
            $member_relation_map->parent_id = $v;
            $member_relation_map->degree = $k + 1;
            $member_relation_map->insert();
        }
    }

    /**
     * 查小伙伴
     */
    public function selectMemberRelationMap($id, $page_no = 0, $page_size = 0) {

        $member_id = Yii::app()->loginUser->getUserId();
        $arr = array();
        $params = array(
            'condition' => 't.parent_id=:parent_id and t.degree<7',
            'params' => array(':parent_id' => $id),
            'order' => 'degree asc',
        );

        $total = UcMemberRelationMap::model()->count($params);
        if ($page_no == 0 && $page_size == 0) {
            $queryResult = UcMemberRelationMap::model()->with('member')->findAll($params);
        } else {
            $queryResult = UcMemberRelationMap::model()->with('member')->pagination($page_no, $page_size)->findAll($params);
        }
        $formatedData = $this->convertModelToArray($queryResult);


        if (!empty($formatedData)) {
            foreach ($formatedData as $v) {
                $temp = array();
                if ($v['degree'] > 1 || $member_id != $id) {
                    if (!empty($v['member']['member_mobile'])) {
                        $temp['member_mobile'] = substr($v['member'][
                                'member_mobile'], 0, 3) . '*****' . substr($v['member']['member_mobile'], 8);
                    } else {
                        $temp['member_mobile'] = '手机号未设置';
                    }
                    if (!empty($v['member']['member_fullname'])) {
                        $len = mb_strlen($v['member']['member_fullname']);
                        $temp['member_fullname'] = mb_substr($v['member']['member_fullname'], 0, 1) . str_repeat('*', $len - 1);
                    } else {
                        $temp['member_fullname'] = '姓名未设置';
                    }
                } else {
                    $temp['member_fullname'] = !empty($v['member']['member_fullname']) ? $v['member']['member_fullname'] : '姓名未设置';
                    $temp['member_mobile'] = !empty($v['member']['member_mobile']) ? $v['member']['member_mobile'] : '手机号未设置';
                }
                $temp['member_nickname'] = !empty($v['member']['member_nickname']) ? $v['member']['member_nickname'] : '昵称未设置';
                $temp['member_avatar'] = $v['member']['member_avatar'];
                $temp['create_time'] = $v['member']['create_time'];
                $temp['member_id'] = $v['member_id'];
                $temp['degree'] = $v['degree'];
                $arr[] = $temp;
            }
        }

        $fanghuUrl = $this->createFanghuUrl('Api/GetAppointmentInfo');
        $time_sign = time();
        $project_appkey = 'test';
        $project_appsecret = '123456';
        $token = strtoupper(md5($project_appkey . $project_appsecret . $time_sign));
        $status_key = array('1' => '预约', '2' => '到访', '3' => '签约', '4' => '成交');
        foreach ($arr as $k => $v) {
            $params = array(
                'time_sign' => $time_sign,
                'source' => 'fangfull',
                'member_id' => $arr[$k]['member_id'],
                'token' => $token,
            );
            $data = $this->doPost($fanghuUrl, $params);
            if ($data['data']) {
                $arr[$k]['status_time'] = date('Y-m-d', strtotime($data['data']['last_modified']));
                $arr[$k]['status_value'] = $status_key[$data['data']['status']];
            } else {
                $arr[$k]['status_time'] = '0000-00-00';
                $arr[$k]['status_value'] = '';
            }
        }
        $result = array(
            'list' => $arr,
            'total' => $total,
        );
        return $result;
    }

}
