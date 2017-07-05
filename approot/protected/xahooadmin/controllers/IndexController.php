<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-1-6
 * Time: 上午10:38
 */


class IndexController extends Controller{
    public $layout = 'layouts/ace.tpl';
    public $defaultAction = 'index';
    //会员后台管理首页
    public function actionIndex()
    {
        $this->smartyRender('index/index.tpl');
    }


    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'layouts/default.tpl';
        $model = new MemberAdminLoginForm;
        // collect user input data
//        var_dump($_POST);die;
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            var_dump($model->login());die;
            if ($model->login()) {//$model->validate() &&
                $this->redirect(array('index/welcome'));
            }
        }
        // display the login form
        $this->smartyRender('index/login.tpl', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array("site/login"));
    }

} 