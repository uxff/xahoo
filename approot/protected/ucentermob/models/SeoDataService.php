<?php
/**
 * meta  title  keywords  description
 * 
 */
class SeoDataService {
    
    //默认值
    const WEBSITE_NAME = 'xinqishijie.com';
    const DEFAULT_SIGN = '新奇世界';
    const META_TITLE = '新奇世界官网-旅游度假区 全家新趣处 文化旅游 旅游投资';
    const META_KEYWORDS = '旅游度假区，生态旅游，文化旅游，分权度假，旅游投资，投资理财，文化旅游投资，休闲养生旅游，新奇世界，逸乐通，休闲旅游景点';
    const META_DESCRIPTION = '新奇世界官网-您专属的旅游投资网站，全家旅游新趣处，旅居理财新选择，购买逸乐通卡，享受超30%年化收益。';
    const META_DELIMITER = ' ';
    static $metaArr = array();
    
    static function get_meta_data ($controllerId='site',$actionId='index',$extString='') {   	
    	switch( $controllerId ) {
			//首页meta
			case 'site':
				if ($actionId == 'zcsecurity') {
					self::$metaArr['title'] = '多重保障'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} elseif ($actionId == 'zcprocess') {
					self::$metaArr['title'] = '众筹流程'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} else if ($actionId == 'login') {
					self::$metaArr['title'] = '个人中心-登录'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} else if ($actionId == 'register') {
					self::$metaArr['title'] = '个人中心-注册'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} else {
					self::$metaArr['title'] = self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				}
				break;		 
			//项目页meta
			case 'project':
				//列表页meta
				if ($actionId == 'list') {
					self::$metaArr['title'] = '众筹项目列表 '.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = '众筹项目列表'.self::META_DELIMITER.self::META_DESCRIPTION;
				} else if ($actionId == 'detail' || $actionId == 'locationadvantage' || $actionId == 'placeorder' || $actionId == 'extrainfo'|| $actionId == 'listearnings'|| $actionId == 'projectcycle' ) {//项目详情页meta
					//根据modelId查找是否添加了meta数据
					$modelId = intval($_REQUEST['project_id']);
					$seoArr = array();
					$extString = '-';
					switch( $actionId ) {
							//项目介绍
							case 'detail':
									$extString .= '项目介绍';
									break;
							//区位优势
							case 'locationadvantage':
									$extString .= '区位优势';
									break;
							//重要说明
							case 'extrainfo':
									$extString .= '重要说明';
									break;
							//财务测算
							case 'listearnings':
									$extString .= '财务测算';
									break;
							//项目周期
							case 'projectcycle':
									$extString .= '项目周期';
									break;
							//参与众筹
							case 'placeorder':
									$extString .= '参与众筹';
									break;
					}
					
					/*if ($modelId != 0 ) {
						$seoObj = FqSeoData::model()->find(array('condition'=>'t.model_name="' . $controllerId . '" AND t.model_id="' . $modelId . '"'));
						$seoArr = is_object($seoObj) ? OBJTool::convertModelToArray($seoObj) : array();
					}*/
					//当前房源的信息
						$projectObj = ZcProject::model()->findByPk($modelId);
						$projectArr = is_object($projectObj) ? OBJTool::convertModelToArray($projectObj) : array();
					//title赋值
					if (!empty($seoArr['title'])) {
						self::$metaArr['title'] = $seoArr['title'].self::META_DELIMITER.$extString;
					} else {
						self::$metaArr['title'] = $projectArr['project_title'].self::META_DELIMITER.$projectArr['project_subtitle'].self::META_DELIMITER.$extString.self::META_DELIMITER. self::META_TITLE;
					} 
					//keywords赋值
					if (!empty($seoArr['keywords'])) {
						self::$metaArr['keywords'] = $seoArr['keywords'].self::META_DELIMITER.$extString;
					} else {
						self::$metaArr['keywords'] = '众筹旅游房产'. self::META_KEYWORDS;
					}
					//description赋值
					if (!empty($seoArr['description'])) {
						self::$metaArr['description'] = $seoArr['description'];
					} else {
						self::$metaArr['description'] = $projectArr['project_name'] . self::META_DESCRIPTION;
					}
						
				}
				break;
			//楼盘信息页meta
			case 'house':
				 if ($actionId == 'detail' || $actionId == 'intro' ) {//项目详情页meta
					//根据modelId查找是否添加了meta数据
					$modelId = intval($_REQUEST['house_id']);
					$seoArr = array();
					$extString = '-';
					switch( $actionId ) {
							//楼盘信息
							case 'detail':
									$extString .= '楼盘信息';
									break;
							//楼盘简介
							case 'intro':
									$extString .= '楼盘简介';
									break;
					}
					
					/*if ($modelId != 0 ) {
						$seoObj = FqSeoData::model()->find(array('condition'=>'t.model_name="' . $controllerId . '" AND t.model_id="' . $modelId . '"'));
						$seoArr = is_object($seoObj) ? OBJTool::convertModelToArray($seoObj) : array();
					}*/
					//当前房源的信息
						$houseObj = ZcProjectHouse::model()->findByPk($modelId);
						$houseArr = is_object($houseObj) ? OBJTool::convertModelToArray($houseObj) : array();
					//title赋值
					if (!empty($seoArr['title'])) {
						self::$metaArr['title'] = $seoArr['title'].self::META_DELIMITER.$extString;
					} else {
						self::$metaArr['title'] = $houseArr['house_name'].self::META_DELIMITER.$extString.self::META_DELIMITER. self::META_TITLE;
					} 
					//keywords赋值
					if (!empty($seoArr['keywords'])) {
						self::$metaArr['keywords'] = $seoArr['keywords'].self::META_DELIMITER.$extString;
					} else {
						self::$metaArr['keywords'] = '众筹旅游房产'. self::META_KEYWORDS;
					}
					//description赋值
					if (!empty($seoArr['description'])) {
						self::$metaArr['description'] = $seoArr['description'];
					} else {
						self::$metaArr['description'] = $houseArr['house_name'] . self::META_DESCRIPTION;
					}
						
				}
				break;
			//项目附属信息meta
			case 'projectextra':
				//列表页meta
				if ($actionId == 'newslist') {
					self::$metaArr['title'] = '众筹项目列表 '.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = '众筹项目列表'.self::META_DELIMITER.self::META_DESCRIPTION;
				} else if ($actionId == 'newslist' || $actionId == 'landinfo'|| $actionId == 'estateagentintro'|| $actionId == 'managecompany'|| $actionId == 'buildplan' || $actionId == 'thirdpartner' ) {//项目详情页meta
					$seoArr = array();
					switch( $actionId ) {
							//媒体报道
							case 'newslist':
									$extString .= '媒体报道';
									break;
							//土地信息公示
							case 'landinfo':
									$extString .= '土地信息公示';
									break;
							//开发商简介
							case 'estateagentintro':
									$extString .= '开发商介绍';
									break;
							//资产管理方
							case 'managecompany':
									$extString .= '资产管理方介绍';
									break;
							//建设计划
							case 'buildplan':
									$extString .= '建设计划';
									break;
							//合作伙伴
							case 'thirdpartner':
									$extString .= '合作伙伴';
									break;
					}
					
					//title赋值
					if (!empty($seoArr['title'])) {
						self::$metaArr['title'] = $seoArr['title'].self::META_DELIMITER.$extString;
					} else {
						self::$metaArr['title'] = $extString.self::META_DELIMITER. self::META_TITLE;
					} 
					//keywords赋值
					if (!empty($seoArr['keywords'])) {
						self::$metaArr['keywords'] = $seoArr['keywords'].self::META_DELIMITER.$extString;
					} else {
						self::$metaArr['keywords'] = '众筹旅游房产'. self::META_KEYWORDS;
					}
					//description赋值
					if (!empty($seoArr['description'])) {
						self::$metaArr['description'] = $seoArr['description'];
					} else {
						self::$metaArr['description'] = $projectArr['project_name'] . self::META_DESCRIPTION;
					}
						
				}
				break;
			//合同详情页meta
			case 'contract':
				//确认页meta
				if ($actionId == 'detail') {
					self::$metaArr['title'] = '合同详情'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '合同详情'.self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} 
				break;
			//资讯详情页meta
			case 'news':
				//确认页meta
				if ($actionId == 'detail') {
				//根据modelId查找是否添加了meta数据
					$modelId = intval($_REQUEST['news_id']);
					//当前房源的信息
					$newsObj = ZcNews::model()->findByPk($modelId);
					$newsArr = is_object($newsObj) ? OBJTool::convertModelToArray($newsObj) : array();
					self::$metaArr['title'] = $newsArr['news_title'].self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} 
				break;
			//资讯详情页meta
			case 'company':
				//确认页meta
				if ($actionId == 'detail') {
				//根据modelId查找是否添加了meta数据
					$modelId = intval($_REQUEST['company_id']);
					//当前房源的信息
					$companyObj = ZcServiceCompany::model()->findByPk($modelId);
					$companyArr = is_object($companyObj) ? OBJTool::convertModelToArray($companyObj) : array();
					self::$metaArr['title'] = $companyArr['company_name'].self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} 
				break;
			//订单页meta
			case 'order':
				//确认页meta
				if ($actionId == 'confirm') {
					self::$metaArr['title'] = '确认订单'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '确认订单'.self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} else if ($actionId == 'pay' || $actionId == 'result') {//支付结果页
					self::$metaArr['title'] = '确认支付信息'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '确认支付信息'.self::META_DELIMITER.self::META_KEYWORDS;
					self::$metaArr['description'] = '确认支付信息'.self::META_DELIMITER.self::META_DESCRIPTION;
				} else if ($actionId == 'detail') {//订单详情页
					self::$metaArr['title'] = '订单详情'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '订单详情'.self::META_DELIMITER.self::META_KEYWORDS;
					self::$metaArr['description'] = '订单详情'.self::META_DELIMITER.self::META_DESCRIPTION;
				} 
				break;
				
			//众筹收益meta
			case 'revenue':
				//确认页meta
				if ($actionId == 'list') {
					self::$metaArr['title'] = '众筹收益列表'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '众筹收益列表'.self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} elseif ($actionId == 'listinvest') {//支付结果页
					self::$metaArr['title'] = '认筹资产总值明细'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '认筹资产总值明细'.self::META_DELIMITER.self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DELIMITER.self::META_DESCRIPTION;
				} elseif ($actionId == 'listyesterdayincome') {//订单详情页
					self::$metaArr['title'] = '昨日收益总值明细'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '昨日收益总值明细'.self::META_DELIMITER.self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DELIMITER.self::META_DESCRIPTION;
				} elseif ($actionId == 'detail') {//订单详情页
					self::$metaArr['title'] = '收益详情'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = '收益详情'.self::META_DELIMITER.self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DELIMITER.self::META_DESCRIPTION;
				} 
				break;
			
			//个人中心meta
			case 'customer':
				if ($actionId == 'orderlist') {
					self::$metaArr['title'] = '众筹订单列表'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} elseif ($actionId == 'myfavorite') {
					self::$metaArr['title'] = '众筹收藏列表'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				} elseif ($actionId == 'index') {
					self::$metaArr['title'] = '个人中心'.self::META_DELIMITER.self::META_TITLE;
					self::$metaArr['keywords'] = self::META_KEYWORDS;
					self::$metaArr['description'] = self::META_DESCRIPTION;
				}
				break;
			default:
				self::$metaArr['title'] = self::META_TITLE;
				self::$metaArr['keywords'] = self::META_KEYWORDS;
				self::$metaArr['description'] = self::META_DESCRIPTION;
				break;
    	}
    	
    	return self::$metaArr;
  
	}
	
}