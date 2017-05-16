<?php

class SiteController extends Controller {

        /**
         * 前台入口页面
         * @var string
         */
        public $layout = 'layouts/default.tpl';
        public $defaultAction = 'login';

        /**
         * Declares class-based actions.
         */
        public function actions() {
                return array(
                    // captcha action renders the CAPTCHA image displayed on the contact page
                    'captcha' => array(
                        'class' => 'CCaptchaAction',
                        'backColor' => 0xFFFFFF,
                    ),
                    // page action renders "static" pages stored under 'protected/views/site/pages'
                    // They can be accessed via: index.php?r=site/page&view=FileName
                    'page' => array(
                        'class' => 'CViewAction',
                    ),
                );
        }

        /**
         * This is the default 'index' action that is invoked
         * when an action is not explicitly requested by users.
         */
        public function actionIndex() {
                // renders the view file 'protected/views/site/index.php'
                // using the default layout 'protected/views/layouts/main.php'
                echo Yii::app()->user->name;
                echo " is Login";
                //$this->smartyRender('site/index.tpl');
        }

        public function actionWelcome() {

            $isGuest = Yii::app()->memberadmin->getIsGuest();

            // 未登录或者会话过期
            if ($isGuest) {
                $this->redirect(array('site/login'));
            }
            
            $this->layout = "layouts/ace.tpl";
            $this->smartyRender("site/welcome.tpl");
        }

        /**
         * This is the action to handle external exceptions.
         */
        public function actionError() {
                if ($error = Yii::app()->errorHandler->error) {
                        if (Yii::app()->request->isAjaxRequest) {
                                echo $error['message'];
                        } else {
                                $this->smartyRender('site/error.tpl', array('error' => $error));
                        }
                }
        }

        /**
         * Displays the contact page
         */
        public function actionContact() {
                $model = new ContactForm;
                if (isset($_POST['ContactForm'])) {
                        $model->attributes = $_POST['ContactForm'];
                        if ($model->validate()) {
                                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                                $headers = "From: $name <{$model->email}>\r\n" .
                                        "Reply-To: {$model->email}\r\n" .
                                        "MIME-Version: 1.0\r\n" .
                                        "Content-Type: text/plain; charset=UTF-8";

                                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                                $this->refresh();
                        }
                }
                $this->smartyRender('site/contact.tpl', array('model' => $model));
        }

        /**
         * Displays the login page
         */
        public function actionLogin() {
                $isGuest = Yii::app()->memberadmin->getIsGuest();
                
                $model = new MemberAdminLoginForm;
                // 判断是否处于登陆状态
                if ($isGuest) {
                    // collect user input data
                    if (isset($_POST['LoginForm'])) {
                        $model->attributes = $_POST['LoginForm'];
                        // validate user input and redirect to the previous page if valid
                        if ($model->validate() && $model->login()) {
                            $this->redirect(array('site/welcome'));
                        }
                    } else {
                        //如果是get请求，先执行一次logout操作
                        Yii::app()->memberadmin->logout();
                    } 
                } else { //已登录
                    $this->redirect(array('site/welcome'));
                }
                
                // display the login form
                $this->smartyRender('site/login.tpl', array('model' => $model));
        }

        /**
         * Logs out the current user and redirect to homepage.
         */
        public function actionLogout() {
                Yii::app()->memberadmin->logout();
                $this->redirect(array("site/login"));
        }

}
