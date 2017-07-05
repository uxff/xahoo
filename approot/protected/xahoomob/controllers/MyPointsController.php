<?php
/**
 * 积分控制器
 * dongxiaoqin
 */
class MyPointsController extends BaseController
{
	const PAGE			= 1;
	const PAGE_SIZE		= 5;
	const MAX_PAGE_SIZE = 8;
	
    public function init() {
        parent::init();
		//加载积分模块
        Yii::app()->getModule('points');
		
		//检查是否登录
		$this->checkLogin();
    }

    /*
 	我的积分首页
    */
    public function actionIndex() {
		
      	//获取用户的总积分数
        $member_id				= Yii::app()->loginUser->getUserId();
        $totalInfo				= Yii::app()->getModule('points')->getMemberTotalInfo($member_id);
      
		// 获取积分明细
        $pointsHistory			= $this->_getPointsList(self::PAGE,self::PAGE_SIZE);
		
        // 首页轮播图
        $actPicsModel = PicSetModel::model()->orderBy('t.id desc')->with('pics')->find('t.used_type='.PicSetModel::USED_TYPE_ACTIVITY);
		
        $arrRender = array(
			'gShowHeader'	=> true,
			'gShowFooter'	=> true,
			'pageTitle'		=>'我的积分',
            'totalInfo'		=> $totalInfo,
            'pointsHistory'	=> $pointsHistory['list'],
            'actPicsModel' 	=> $actPicsModel,
        );
		
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('points/index.tpl',$arrRender);
    }
	
	/*
 	我的积分明细页面
    */
    public function actionPointsHistory() {
		
		// 获取积分明细
        $pointsHistory		= $this->_getPointsList(self::PAGE,self::MAX_PAGE_SIZE);
		$list				= $this->_groupByDate($pointsHistory['list']);
		
        $arrRender = array(
			'gShowHeader'	=> true,
			'gShowFooter'	=> true,
			'pageTitle'		=>'积分明细',
            'pointsHistory'	=> $list,
        );

		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('points/history.tpl',$arrRender);
    }
	
	/*
 	如何获取积分
    */
    public function actionPointsRule($keyword='', $pageNo=1, $pageSize=10) {
		
        $model = new PointsRuleModel();
        $model->unsetAttributes();  // clear any default values
        
        $mySearch 	= $model->mySearch();
        $arrData 	= $mySearch['list'];
        $pages 		= $mySearch['pages'];

        $arrRender = array(
			'gShowHeader'	=> true,
			'gShowFooter'	=> true,
			'pageTitle'		=>'积分规则',
            'arrData' 		=> $arrData,
            'pages' 		=> $pages,
            'route'			=>$this->getId().'/'.$this->getAction()->getId(),
        );
		
		$this->layout = "layouts/default_v2.tpl";
		$this->smartyRender('points/rule.tpl',$arrRender);
    }
	
	/*
 	我的积分列表数据查询
    */
    public function actionAjaxGetPointsList() {
		$page 		= Yii::app()->request->getParam('page');
		$pageSize	= Yii::app()->request->getParam('pageSize');
		$page		= $page ? $page : self::page;
		$pageSize	= $pageSize ? $pageSize : self::MAX_PAGE_SIZE;
		
		// 获取积分明细
        $result			= $this->_getPointsList($page,$pageSize);
		$result['list']	= $this->_groupByDate($result['list']);
		
		//返回json数据
		$this->showJson($result);
    }
	
	/*
 	查询积分列表并处理数据结构
    */
	private function _getPointsList($page,$pageSize){
		//查询积分明细列表
		$member_id	= Yii::app()->loginUser->getUserId();
    	$result		= Yii::app()->getModule('points')->getMemberPointsHistory($member_id,$page,$pageSize);
    	$list		= $result['list'];
		
    	if (!empty($list)) {
    		foreach($list as $k=>$v){
				$list[$k]['last_modified']	= substr($v['last_modified'], 0, 16);
				$list[$k]['points']			= $v['type'] == 1 ? "+".$v['points'] : "".$v['points'];
				$list[$k]['remark']			= $v['remark'];
				$list[$k]['class']			= $v['type'] == 1 ? "plus" : "minus";
    		}
			$result['list']	= $list;
    	}
		return $result;
	}
	
	/*
 	积分明细按年月分组处理
    */
	private function _groupByDate($list){
		$new_list			= array();
		
		if (!empty($list)) {
			foreach($list as $k=>$v){
				//按照月份日期进行分组
				$date				= explode("-",$v['last_modified']);
				$key 				= $date[0]."年".$date[1]."月";//年月
				$new_list[$key][] 	= $v;
			}
		}
		return $new_list;
	}
}