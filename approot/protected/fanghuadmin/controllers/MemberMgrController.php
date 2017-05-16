<?php
Yii::import('application.ucentermob.api.*');
//Yii::import('application.ucentermob.models.*');
//Yii::import('application.ucentermob.components.*');
//Yii::import('application.ucentermodels.*');
//Yii::import('application.ucentermob.api.UCenterStatic');

class MemberMgrController extends Controller
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

        $model = new Member;
        $objModel = $this->loadModel($id);

        //$inviteCodeModel = MemberInviteCode::model()->find('member_id=:mid', array(':mid'=>$id));
        $inviteCodeModel = Yii::app()->getModule('friend')->getInviteCodeModel($id);
        $memberTotalInfo = Yii::app()->getModule('points')->getMemberTotalInfo($id);
        
		//查询会员信息操作的日志列表
		$logList	=  MemberInfoLogModel::getMemberInfoLog($id,1,5);
	
        $arrRender = array(
            'objModel'			=> $objModel,
            'attributeLabels'	=> $model->attributeLabels(),
            'inviteCodeModel' 	=> $inviteCodeModel,
            'memberTotalInfo' 	=> $memberTotalInfo,
            'arrMemberFrom' 	=> Member::$ARR_MEMBER_FROM,
            'levelList' 		=> Yii::app()->getModule('points')->getLevelList(),
			'pages' 			=> $logList['pages'],//分页数据
			'logList' 			=> $logList['list'],//历史记录列表
			'arrType' 			=> MemberInfoLogModel::$ARR_TYPE,//历史记录的操作类型
        );
		
        $this->smartyRender('membermgr/view.tpl', $arrRender);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $updateModel = $this->loadModel($id);
		$oldMember	 = $updateModel->attributes;
	
        if (isset($_POST['Member'])) {
            unset($_POST['Member']['member_mobile']);
            unset($_POST['Member']['member_password']);
                $updateModel->attributes = $_POST['Member'];
				
				//处理操作说明的内容
				$content = "";
				if ($oldMember['member_name'] != $_POST['Member']['member_name']){
					$content .= '会员名称为"'.$_POST['Member']['member_name'].'" ';
				}
				if ($oldMember['member_nickname'] != $_POST['Member']['member_nickname']){
					$content .= '会员昵称为"'.$_POST['Member']['member_nickname'].'" ';
				} 
				if ($oldMember['member_email'] != $_POST['Member']['member_email']){
					$content .= '会员邮箱为"'.$_POST['Member']['member_email'].'" ';
				}  
				if ($oldMember['member_id_number'] != $_POST['Member']['member_id_number']){
					$content .= '会员身份证号为"'.$_POST['Member']['member_id_number'].'" ';
				}  
				if ($oldMember['status'] != $_POST['Member']['status']){
					$status	 = $_POST['Member']['status'] == 1 ? "正常" : "禁用";
					$content .= '会员状态为"'.$status.'" ';
				} 
				if ($oldMember['member_address'] != $_POST['Member']['member_address']){
					$content .= '会员邮寄地址为"'.$_POST['Member']['member_address'].'" ';
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
						$model		= new MemberInfoLogModel;
						$res 		= $model->add($member_id,$editor,$role,$type,$content);
					}
					
					$this->redirect(array('view', 'id' => $updateModel->member_id));
                }
        }
        $model = new Member;
        $arrAttributeLabels = $model->attributeLabels();
        $form = $this->beginWidget('CSmartyValidatorJs', array(
            'id' => 'memberMgr-form',
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
            'modelName' => 'Member',
            'attributes' => $model->getAttributes(),
            'attributeLabels' => $arrAttributeLabels,
            'FormElements' => $model->FormElements,
            'action' => 'Update',
            'errormsgs' => CHtml::errorSummary($updateModel, '<i class="ace-icon fa fa-times"></i>请更正以下错误'), //报错信息处理
            'jsShell' => $js,
            'model' => $updateModel,
            'dataObj' => $updateModel,
        );

        $this->smartyRender('membermgr/update.tpl', $arrRender);
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
		$start_time	= "";
        $end_time	= "";
        date_default_timezone_set('PRC'); 
       
		if(isset($_GET['Member']['create_time_start']) && !empty($_GET['Member']['create_time_start'])){
            $start_time = $this->getString($_GET['Member']['create_time_start']); 
        }
		
        if(isset($_GET['Member']['create_time_end']) && !empty($_GET['Member']['create_time_end'])){
            $end_time = $this->getString($_GET['Member']['create_time_end']); 
        }
		
		
        $searchForm = 0;
        $model = new Member();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Member'])) {
                $searchForm = 1;
                $model->attributes = $_GET['Member'];
        }
		
        $mySearch = $model->mySearch($start_time,$end_time);
        $arrData = $mySearch['list'];
        $pages = $mySearch['pages'];

        $arrAttributeLabel = $model->attributeLabels();
        unset($arrAttributeLabel['create_time']);
        //unset($arrAttributeLabel['last_modified']);
        $arrRender = array(
            'modelId' => 'member_id',
            'modelName' => 'Member',
            'arrAttributeLabels' => $arrAttributeLabel,
            'arrData' => $arrData,
            'pages' => $pages,
            'dataObj'=>$model,
            'searchForm' => $searchForm,
            'route'=>$this->getId().'/'.$this->getAction()->getId(),
            'arrMemberFrom' => Member::$ARR_MEMBER_FROM,
            'levelList' => Yii::app()->getModule('points')->getLevelList(),
        );
		
		$this->smarty->assign('create_time_start', $start_time);
        $this->smarty->assign('create_time_end', $end_time);
		
        //smarty render
        $this->smartyRender('membermgr/index.tpl', $arrRender);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $dataProvider = new CActiveDataProvider('Member');

        $data = $dataProvider->getData();

        //var_dump($data);
        //render data
        $arrRender = array(
            'data' => $data,
            'dataCount' => count($data),
            'assetsPath' => 'assets/' . Yii::app()->params['assetsVersion'],
        );

        $this->smartyRender('membermgr/admin.tpl', $arrRender);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Member the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Member::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Member $model the model to be validated
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
