<?php

class MpaccountsController extends Controller
{

    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $sql = "";            
        $model = new FhPosterAccountsModel;
        $attributesArr = array();
        if (isset($_POST['poster'])) {
            if($_POST['poster']['accounts_name'] != ''){
                $sql .= " AND t.id = ".$_POST['poster']['accounts_name'];
            }
            $model->attributes = $attributesArr;
        }
        $mySearch   = $model->mySearch2($sql);
        $listData   =  $this->convertModelToArray($mySearch['list']);
        $pages      = $mySearch['pages'];
        
        $accounts = FhPosterAccountsModel::model()->findAll();
        $accountsData = $this->convertModelToArray($accounts);
        $arrRender = array(
            'accountsData'  =>  $accountsData,
            'listData'      =>  $listData,
            'pages'         =>  $pages,
            'accounts_name' =>  $_POST['poster']['accounts_name'],
            'mpurlPrefix'   =>  ($_SERVER['SERVER_PORT']=='443'?'https://':'http://').Yii::app()->params['frontendDomain'].'/index.php?r=wechat/index',
            'arrStatus'     =>  FhPosterAccountsModel::$ARR_STATUS,
        );
        $this->smartyRender('accounts/index.tpl', $arrRender);
    }
    public function actionCreate() {        
        $this->smartyRender('accounts/create.tpl', $arrRender);
    }
    
    public function actionEdit() {
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($id != ''){
            $accounts = FhPosterAccountsModel::model()->findByPk($id);
            $accountsData = $this->convertModelToArray($accounts);
        }
        $arrRender = array(
            'accountsData' =>$accountsData,
        );
        $this->smartyRender('accounts/edit.tpl', $arrRender);
    }

    public function actionEditmenu() {
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($id != ''){
            $mpAccountModel = FhPosterAccountsModel::model()->findByPk($id);
            $accountsData = $this->convertModelToArray($mpAccountModel);
            $weObj = $mpAccountModel->toWechatObj();
            $menu = $weObj->getMenu();
            if (isset($_POST['menu']) && !empty($_POST['menu'])) {
                $menu = $_POST['menu'];
                Yii::log('post menu='.$menu, 'warning', __METHOD__);
                $ret = $weObj->createMenu($menu);
                Yii::log('create menu ret='.json_encode($ret), 'warning', __METHOD__);
                $this->redirect(array('editmenu', 'id'=>$id));
            }
        }

        $arrRender = array(
            'accountsData' =>$accountsData,
            'mpMenu' => json_encode($menu, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE),
        );
        $this->smartyRender('accounts/edit.tpl', $arrRender);
    }

    public function actionInsert(){
            $post                       =   $_POST['poster'];
            $modela                     =   new FhPosterAccountsModel;
            $data1                      =   array();
            $data1['accounts_name']     =   $post['accounts_name'];
            $data1['token']             =   $post['token'] ;
            $data1['appid']             =   $post['appid'] ;
            $data1['appsecret']         =   $post['appsecret'] ;
            $data1['EncodingAESKey']    =   $post['EncodingAESKey'] ;
            $data1['status']            =   1;
            $data1['create_time']       =   date("Y-m-d H:i:s");
            $data1['last_modified']     =   date("Y-m-d H:i:s");
            $modela->attributes         =   $data1;
            $desc                       =   '新增公众号'.$data1['accounts_name'];
            if($modela->save()){
                $insertLog = $this->InsertLog($modela->id,$desc);
                $this->redirect(array('accounts/index'));        
                //$this->jsonSuccess('操作成功', ['return_url'=>$this->createUrl('accounts/index')]);
            }
            $this->jsonError('操作失败('.$modela->lastError().')');
    }
    public function actionUpdate(){
            $post = $_POST['poster'];
            if($post){
                $oldData = FhPosterAccountsModel::model()->findByPk($_GET['id']);
                $oldDatas= $this->convertModelToArray($oldData);
                $update = FhPosterAccountsModel::model()->updateByPk($_GET['id'],array(
                    'accounts_name'=>$post['accounts_name'],
                    'token'=>$post['token'],
                    'appid'=>$post['appid'],
                    'appsecret'=>$post['appsecret'],
                    'EncodingAESKey'=>$post['EncodingAESKey'],
                    'last_modified'=>date("Y-m-d H:i:s"),                    
                ));
                if($update){
                    $desc = '';
                    if($oldDatas['accounts_name'] != $post['accounts_name']){
                        $desc .= '公众号名称由&nbsp;'.$oldDatas['accounts_name'].'&nbsp;变更为&nbsp;'.$post['accounts_name'].'<br/>';
                    }
                    if($oldDatas['token'] != $post['token']){
                        $desc .= '公众号token由&nbsp;'.$oldDatas['token'].'&nbsp;变更为&nbsp;'.$post['token'].'<br/>';
                    }
                    if($oldDatas['appid'] != $post['appid']){
                        $desc .= 'appid由&nbsp;'.$oldDatas['appid'].'&nbsp;变更为&nbsp;'.$post['appid'].'<br/>';
                    }
                    if($oldDatas['appsecret'] != $post['appsecret']){
                        $desc .= 'appsecret&nbsp;'.$oldDatas['appsecret'].'&nbsp;变更为&nbsp;'.$post['appsecret'].'<br/>';
                    }
                    if($oldDatas['EncodingAESKey'] != $post['EncodingAESKey']){
                        $desc .= 'EncodingAESKey&nbsp;'.$oldDatas['EncodingAESKey'].'&nbsp;变更为&nbsp;'.$post['EncodingAESKey'].'<br/>';
                    }
                    $insertLog = $this->InsertLog($_GET['id'],$desc);
                    $this->redirect(array('accounts/index'));
                }
            }
            
    }

    public function actionView($pageNo=1, $pageSize=10){
        $id = isset($_GET['id'])?$_GET['id']:'';
        $attributesArr = array();
        if($id != ''){            
            $sql = ' AND pid = '.$id;
            $model = new FhPosterAccountsLogModel;
            $mySearch = $model->mySearch2($sql);
            $listData =  $this->convertModelToArray($mySearch['list']);
            $pages = $mySearch['pages'];
            $model->attributes = $attributesArr;
            $arrRender = array(
                'listData'=>$listData,
                'pages' => $pages,
            );
            $this->smartyRender('accounts/view.tpl',$arrRender);
        }
    }

    public function InsertLog($id,$desc){
        $data2 = array();
        $modell = new FhPosterAccountsLogModel;
        $data2['pid'] = (int)$id;
        $data2['username'] = $_SESSION['memberadmin__adminUser']['name'];
        $data2['userid'] = (int)$_SESSION['memberadmin__adminUser']['id'];
        $role = SysAdminUser::model()->with('role')->findByPk($data2['userid']);
        $roles= $this->convertModelToArray($role);
        $data2['userflag'] = $roles['role'][0]['name'];
        $data2['desc'] = $desc;
        $data2['create_time'] = date("Y-m-d H:i:s");
        $data2['last_modified'] = date("Y-m-d H:i:s");
        $modell->attributes = $data2;
        $modell->save();
    }
}
