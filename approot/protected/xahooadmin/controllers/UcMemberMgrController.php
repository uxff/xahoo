<?php
//Yii::import('application.ucenterpc.models.*');
//Yii::import('application.ucenterpc.components.*');
Yii::import('application.ucentermob.api.*');
//Yii::import('application.ucentermob.models.*');
Yii::import('application.ucentermob.components.UCenterActiveRecord');
Yii::import('application.ucentermodels.*');
//Yii::import('application.ucentermob.api.UCenterStatic');
//Yii::import('application.ucenterpc.controllers.BaseController');
Yii::import('application.modules.points.models.*');

class UcMemberMgrController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = new UcMember;
        $objModel = $this->loadModel($id);

        $pointsModule = Yii::app()->getModule('points');
        $inviteCodeModel = Yii::app()->getModule('friend')->getInviteCodeModel($id);
        $memberTotalInfo = Yii::app()->getModule('points')->getMemberTotalInfo($id);
        //$totalInfo = $pointsModule->getMemberTotalInfo($objModel->member_id);


		//查询会员信息操作的日志列表
		$logList	=  MemberInfoLogModel::getMemberInfoLog($id,1,10);

        $arrRender = array(
            'objModel' => $objModel,
            'attributeLabels' => $model->attributeLabels(),
            'inviteCodeModel' => $inviteCodeModel,
            'memberTotalInfo' => $memberTotalInfo,
            'arrUcMemberFrom' => UcMember::$ARR_MEMBER_FROM,
            'levelList' => Yii::app()->getModule('points')->getLevelList(),
            //'memberTotalInfo' => $totalInfo,
			'pages' 			=> $logList['pages'],//分页数据
			'logList' 			=> $logList['list'],//历史记录列表
			'arrType' 			=> MemberInfoLogModel::$ARR_TYPE,//历史记录的操作类型
        );
        $this->smartyRender('ucmembermgr/view.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
		$oldMember	 = $updateModel->attributes;

        $AresObj = new AresCryptDes(DES_KEY);
        if (isset($_POST['UcMember'])) {
            unset($_POST['UcMember']['member_mobile']);
            unset($_POST['UcMember']['member_password']);
            
            $updateModel->attributes = $_POST['UcMember'];
            //处理操作说明的内容
            $content = "";
            if ($oldMember['member_fullname'] != $_POST['UcMember']['member_fullname']){
                $content .= '会员名称为"'.$_POST['UcMember']['member_fullname'].'" ';
            }
            if ($oldMember['member_nickname'] != $_POST['UcMember']['member_nickname']){
                $content .= '会员昵称为"'.$_POST['UcMember']['member_nickname'].'" ';
            } 
            if ($oldMember['member_email'] != $_POST['UcMember']['member_email']){
                $content .= '会员邮箱为"'.$_POST['UcMember']['member_email'].'" ';
            }  
            if ($oldMember['member_id_number'] != $_POST['UcMember']['member_id_number']){
                $content .= '会员身份证号为"'.$_POST['UcMember']['member_id_number'].'" ';
            }  
            if ($oldMember['status'] != $_POST['UcMember']['status']){
                $status	 = $_POST['UcMember']['status'] == 1 ? "正常" : "禁用";
                $content .= '会员状态为"'.$status.'" ';
            } 
            if ($oldMember['member_address'] != $_POST['UcMember']['member_address']){
                $content .= '会员邮寄地址为"'.$_POST['UcMember']['member_address'].'" ';
            } 
            
            //保存会员信息修改，插入操作日志记录
            if ($updateModel->save()) {
                $editor 	= Yii::app()->memberadmin->name;		//操作人
                $role_id	= Yii::app()->memberadmin->role;		//角色ID
                $role_obj	= SysRole::model()->findByPk($role_id);
                $role_name	= $this->convertModelToArray($role_obj);//角色人
                
                //保存会员信息操作的历史记录
                if ($content) {
                    $member_id 	= $updateModel->member_id;
                    $editor		= Yii::app()->memberadmin->name;
                    $role		= $role_name['name'];
                    $type		= 1;			 //操作类型1：修改信息
                    $content	= "设置".$content;//操作说明
                    $logModel	= new MemberInfoLogModel;
                    $res 		= $logModel->add($member_id,$editor,$role,$type,$content);
                }
                $this->redirect(array('view', 'id' => $updateModel->member_id));
            }
        }
        $model = new UcMember;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'ucMemberMgr-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => false,
                'validateOnChange' => true,
            ),
        ));
        foreach ($model->FormElements as $attributeName => $value) {
                $form->error($model, $attributeName);
        }
		
        $this->endWidget();
        $js = '';
        Yii::app()->getClientScript()->render($js, 1);
        //render data
        $arrRender = array(
            'primaryKey'=>'member_id',
            'modelName' => 'UcMember',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
        );

        $this->smartyRender('ucmembermgr/update.tpl', $arrRender);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        //TODO
        //$this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $condition = array();

		if(isset($_GET['condition']['create_time_start']) && !empty($_GET['condition']['create_time_start'])){
            $start_time	= date('Y-m-d 00:00:00', strtotime($_GET['condition']['create_time_start']));
            $condition['start_time'] = $start_time;
        }
		
        if(isset($_GET['condition']['create_time_end']) && !empty($_GET['condition']['create_time_end'])){
            $end_time	= date('Y-m-d 23:59:59', strtotime($_GET['condition']['create_time_end']));
            $condition['end_time'] = $end_time;
        }

        $searchForm = 0;
        $model = new UcMember();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UcMember'])) {
                $searchForm = 1;
                $model->attributes = $_GET['UcMember'];
        }
        $mySearch = $model->mySearch($condition);
        $arrData = $mySearch['list'];
        $arrList = OBJTool::convertModelToArray($arrData);
        $pages = $mySearch['pages'];

        $pointsModule = Yii::app()->getModule('points');
        // 对每条记录查询membertotal数据
        $arrTotalInfo = array();
        foreach ($arrList as $key=>$objValue) {
            $totalInfo = $pointsModule->getMemberTotalInfo($objValue['member_id']);
            $arrList[$key]['totalInfo'] = $totalInfo->toArray();
            $arrTotalInfo[$key] = $totalInfo->toArray();
        }

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'UcMember',
            'conditionLevel' => '',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'arrList' => $arrList,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'arrUcMemberFrom' => UcMember::$ARR_MEMBER_FROM,
            'levelList' => Yii::app()->getModule('points')->getLevelList(),
            'arrTotalInfo' => $arrTotalInfo,
            'condition' => $condition,
        );

        //smarty render
        $this->smartyRender('ucmembermgr/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('UcMember');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('ucmembermgr/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UcMember the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UcMember::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UcMember $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 查询会员信息操作的日志列表
     */
    private function _getMemberInfoLog($member_id) {
      
		$member_id	= Yii::app()->request->getParam("id");
		$logList	=  MemberInfoLogModel::getMemberInfoLog($member_id);
    }
	
	/**
     * 添加会员信息操作日志的记录
     */
    public function actionCreateMemberInfoLog() {
		//获取参数
		$member_id 	= Yii::app()->request->getParam('member_id');
		$editor 	= Yii::app()->request->getParam('editor');
		$role 		= Yii::app()->request->getParam('role');
		$type		= Yii::app()->request->getParam('type');
		$content 	= Yii::app()->request->getParam('content');
		
		//校验参数不能为空
		if (empty($member_id) || empty($editor) || empty($role) || empty($type) || empty($content)){
			$res = array("status"=>0,"msg"=>"参数不能为空!");
		} else {
			//保存会员信息操作的历史记录
			$model = new MemberInfoLogModel;
			$res = $model->add($member_id,$editor,$role,$type,$content);
		}
		
		//返回JSON数据
		$this->showAjaxJson($res);
    }
}
