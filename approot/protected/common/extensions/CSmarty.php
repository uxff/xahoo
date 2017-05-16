<?php

//require Smarty base clase
require_once(Yii::app()->basePath . "/common/vendor/Smarty/Smarty.class.php");

/**
 * Smarty
 */
class CSmarty extends Smarty {

        /**
         * 对象实例
         * @var object
         */
        protected static $_instance = NULL;

        /**
         * 模版布局文件
         * @var string
         */
        public $_layoutTpl = 'layouts/ace.tpl';

        /**
         * 获取单例对象
         * @return object smarty对象实例
         */
        public static function getInstance() {

                if (self::$_instance == NULL) {

                        self::$_instance = new CSmarty();
                }

                return self::$_instance;
        }

        public function setLayoutTpl($layoutTpl = '') {

                if (!empty($layoutTpl)) {
                        $this->_layoutTpl = $layoutTpl;
                }
        }

        /**
         * 初始化Smarty相关配置
         * @return [type] [description]
         */
        function init() {
                parent::__construct();

                //$webpatharr=Config::model()->findBySql('select vals from ct_config where `title`="templatepath"');
                //$webpath=$webpatharr['vals'];
                $app_path = Yii::app()->basePath;
                $app_path .= (!empty(Yii::app()->params['tplPath'])) ? Yii::app()->params['tplPath'] : "";
                $this->template_dir = $app_path . "/themes/tpl/";
                $this->compile_dir = $app_path . "/themes/tpl_c/";
                $this->config_dir = $app_path . "/tpl_conf/";

                $this->registerPlugin("modifier", "e", "htmlspecialchars");
                $this->registerPlugin("modifier", "trim", "trim");

                $this->compile_check = true;

                $this->caching = false;
                $this->force_compile = true;
                $this->cache_dir = $app_path . '/themes/cache';

                if (!is_dir($this->cache_dir)) {
                        mkdir($this->cache_dir, 0777);
                }

                $this->left_delimiter = '{';

                $this->right_delimiter = '}';

                $this->cache_lifetime = 300;

                //echo '<pre>';print_r($this->template_dir);echo '</pre>';
                //exit();
        }

        /**
         * 展示页面
         * 
         * @param  string  $pageTplFile 当前页面模版路径
         * @param  string  $jsTplFile   当前页面JS路径
         * @param  string  $cacheId     缓存ID
         * 
         * @return
         */
        //$template = NULL, $cache_id = NULL, $compile_id = NULL, $parent = NULL
        public function display($pageTplFile = null, $jsTplFile = null, $cacheId = null, $compile_id = NULL, $parent = NULL) {
                // 使用layout布局机制组合页面模版
                $this->assign('NACHO_PAGE_TPL_FILE', $pageTplFile);

                // 加载页面js文件，放在</body>标签前
                // NOTE: Smarty的属性template_dir声明为Array
                $jsTplFilePath = $this->template_dir[0] . $jsTplFile;
                if (file_exists($jsTplFilePath)) {
                        $this->assign('NACHO_JS_TPL_FILE', $jsTplFile);
                }

                // 最后的smarty显示处理，调用Smarty原始函数
                parent::display($this->_layoutTpl, $cacheId);
        }

}

?>