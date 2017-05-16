<?php

class adminController extends Controller
{

	/**
	 * 前台入口页面
	 * @var string
	 */
	public $layout = 'layouts/ace.tpl';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $arrSideMenu = array('0'=>array(
                                    'name'=>'UI & Elements',
                                    'model'=>'news',
                                    'menu-icon'=>'fa-tachometer',
                                    'submenu'=>array(
                                                    0=>array(
                                                        'name'=>'添加一个新',
                                                        'action'=>'add',
                                                        ),
                                                    1=>array(
                                                        'name'=>'新闻列表',
                                                        'action'=>'view',
                                                        )
                                        )),
                         );
		$this->smartyRender('site/index.tpl');
	}
    public function renderSideBar($arrayMenu)
    {
        $Menustr = "";
        foreach($arrMenu as $tmpMenu)
        {
            if(isset($tmpMenu['submenu']))
            {
                $hasSub = true;
            }else
            {
                $hasSub = false;
            }
            if(isset($tmp['active']))
            {
            }
        }
    }
}
