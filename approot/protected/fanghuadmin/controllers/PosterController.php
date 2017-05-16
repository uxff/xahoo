<?php

class PosterController extends Controller
{

    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $sql = "";            
        $model = new FhPosterModel;
        $attributesArr = array();
        if (isset($_POST['poster'])) {
            if($_POST['poster']['project'] != ''){
                $sql .= " AND t.project_id = ".(int)$_POST['poster']['project'];
            }
            if($_POST['poster']['accounts_id'] != ''){
                $sql .= " AND t.accounts_id = ".(int)$_POST['poster']['accounts_id'];                
            }
            if($_POST['poster']['status'] != ''){
                $sql .= " AND t.poster_status = ".(int)$_POST['poster']['status'];                
            }
            $model->attributes = $attributesArr;
        }
        $mySearch = $model->mySearch2($sql);
        $listData =  $this->convertModelToArray($mySearch['list']);
        $projectData = Project::model()->findAll();
        $projectDatas= $this->convertModelToArray($projectData);
        $accounts = FhPosterAccountsModel::model()->findAll();
        $accountsData = $this->convertModelToArray($accounts);
        $pages = $mySearch['pages'];
        $arrRender = array(
            'accountsData' => $accountsData,
            'listData'=>$listData,
            'pages' => $pages,
            'projectDatas' => $projectDatas,
            'time' => date("Y-m-d"),
            'accounts_id' => $_POST['poster']['accounts_id'],
            'project_id' => $_POST['poster']['project'],
            'status' => $_POST['poster']['status'],
        );
        $this->smartyRender('poster/index.tpl', $arrRender);
    }
    public function actionCreate() {        
        $accounts = FhPosterAccountsModel::model()->findAll();
        $accountsData = $this->convertModelToArray($accounts);
        
        $projectData = Project::model()->findAll();
        $projectDatas= $this->convertModelToArray($projectData);
        $arrRender = array(
            'accountsData' => $accountsData,
            'projectDatas' =>$projectDatas,
            'banner_size_arr' =>'640*906',
        );
        $this->smartyRender('poster/create.tpl', $arrRender);
    }
    
    public function actionEdit() {
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($id != ''){
            $data = FhPosterModel::model()->findByPk($id);
            $datas = $this->convertModelToArray($data);
        }
        $accounts = FhPosterAccountsModel::model()->findAll();
        $accountsData = $this->convertModelToArray($accounts);
        $projectData = Project::model()->findAll();
        $projectDatas= $this->convertModelToArray($projectData);
        $arrRender = array(
            'poster' =>$datas,
            'projectDatas' =>$projectDatas,
            'banner_size_arr' =>'640*906',
            'accountsData' => $accountsData,
        );
        $this->smartyRender('poster/edit.tpl', $arrRender);
    }
    
    public function actionInsert(){
       // var_dump($_POST);die;
            $post = $_POST['poster'];
            $modela = new FhPosterModel;
            $data1  = array();
            $data1['project_id'] = $post['project'] ;
            $data1['accounts_id'] = $post['accounts_id'] ;
            $data1['direct_fans_rewards'] = $post['direct_fans_rewards'] ;
            $data1['indirect_fans_rewards'] =  $post['indirect_fans_rewards'] ;
            $data1['project_bonus_ceiling'] =  $post['project_bonus_ceiling'] ;
            $data1['project_fans_ceiling'] = $post['project_fans_ceiling'];
            $data1['lowest_withdraw_sum'] = $post['lowest_withdraw_sum'];
            $data1['highest_withdraw_sum'] = $post['highest_withdraw_sum'];
            $data1['subscribe_rewards'] = $post['subscribe_rewards'];
            $data1['photo_url'] = $post['photo_pic'];
            $data1['valid_begintime'] = $post['valid_begintime'];
            $data1['valid_endtime'] = $post['valid_endtime'];
            $data1['valid_area'] = $post['valid_area'];
            $data1['poster_rules'] = $post['poster_rules'];
            $data1['create_time'] = date("Y-m-d H:i:s");
            $data1['last_modified'] = date("Y-m-d H:i:s");
            $modela->attributes = $data1;
            if($modela->save()){
                $insertLog = $this->InsertLog($modela->id,'创建海报');
                $this->redirect(array('poster/index'));        
            }
    }
    public function actionUpdate(){
            $post = $_POST['poster'];
            if($post){
                $oldData = FhPosterModel::model()->findByPk($_GET['id']);
                $oldDatas= $this->convertModelToArray($oldData);
                $update = FhPosterModel::model()->updateByPk($_GET['id'],array(
                    'project_id'=>$post['project'],
                    'accounts_id' => $post['accounts_id'] ,
                    'direct_fans_rewards'=>$post['direct_fans_rewards'],
                    'indirect_fans_rewards'=>$post['indirect_fans_rewards'],
                    'project_bonus_ceiling'=>$post['project_bonus_ceiling'],
                    'project_fans_ceiling'=>$post['project_fans_ceiling'],
                    'lowest_withdraw_sum'=>$post['lowest_withdraw_sum'],
                    'highest_withdraw_sum'=>$post['highest_withdraw_sum'],
                    'subscribe_rewards'=>$post['subscribe_rewards'],
                    'photo_url'=>$post['photo_pic'],
                    'valid_begintime'=>$post['valid_begintime'],
                    'valid_endtime'=>$post['valid_endtime'],
                    'valid_area' => $post['valid_area'],
                    'poster_rules' => $post['poster_rules'],
                    'last_modified'=>date("Y-m-d H:i:s"),                    
                ));
                if($update){
                    FhMemberHaibaoModel::updateWithdrawLimitByPoster($_GET['id']);
                    $desc = '';
                    if($oldDatas['project_id'] != $post['project']){
                        $oldproject = Project::model()->findByPk($oldDatas['project_id']);
                        $oldprojects= $this->convertModelToArray($oldproject);
                        $newproject = Project::model()->findByPk($post['project']);
                        $newprojects= $this->convertModelToArray($newproject);
                        $desc = '项目由&nbsp;'.$oldprojects['project_name'].'&nbsp;变更为&nbsp;'.$newprojects['project_name'].'<br/>';
                    }  
                    if($oldDatas['accounts_id'] != $post['accounts_id']){
                        $oldaccounts = FhPosterAccountsModel::model()->findByPk($oldDatas['accounts_id']);
                        $oldaccounts= $this->convertModelToArray($oldproject);
                        $newaccounts = FhPosterAccountsModel::model()->findByPk($post['accounts_id']);
                        $newaccounts= $this->convertModelToArray($newproject);
                        $desc = '公众号由&nbsp;'.$oldprojects['accounts_name'].'&nbsp;变更为&nbsp;'.$newprojects['accounts_name'].'<br/>';
                    }        
                    if($oldDatas['subscribe_rewards'] != $post['subscribe_rewards']){
                        $desc .= '首次关注奖励由&nbsp;'.$oldDatas['subscribe_rewards'].'&nbsp;变更为&nbsp;'.round($post['subscribe_rewards'],2).'<br/>';
                    }      
                    if($oldDatas['direct_fans_rewards'] != $post['direct_fans_rewards']){
                        $desc .= '直接粉丝奖励由&nbsp;'.$oldDatas['direct_fans_rewards'].'&nbsp;变更为&nbsp;'.round($post['direct_fans_rewards'],2).'<br/>';
                    }                
                    if($oldDatas['indirect_fans_rewards'] != $post['indirect_fans_rewards']){
                        $desc .= '间接粉丝奖励由&nbsp;'.$oldDatas['indirect_fans_rewards'].'&nbsp;变更为&nbsp;'.round($post['indirect_fans_rewards'],2).'<br/>';
                    }                
                    if($oldDatas['project_bonus_ceiling'] != $post['project_bonus_ceiling']){
                        $desc .= '项目奖金上限由&nbsp;'.$oldDatas['project_bonus_ceiling'].'&nbsp;变更为&nbsp;'.round($post['project_bonus_ceiling'],2).'<br/>';
                    }                
                    if($oldDatas['project_fans_ceiling'] != $post['project_fans_ceiling']){
                        $desc .= '项目粉丝上限由&nbsp;'.$oldDatas['project_fans_ceiling'].'&nbsp;变更为&nbsp;'.$post['project_fans_ceiling'].'<br/>';
                    }                
                    if($oldDatas['lowest_withdraw_sum'] != $post['lowest_withdraw_sum']){
                        $desc .= '最低提现金额由&nbsp;'.$oldDatas['lowest_withdraw_sum'].'&nbsp;变更为&nbsp;'.round($post['lowest_withdraw_sum'],2).'<br/>';
                    }                
                    if($oldDatas['highest_withdraw_sum'] != $post['highest_withdraw_sum']){
                        $desc .= '最高提现金额由&nbsp;'.$oldDatas['highest_withdraw_sum'].'&nbsp;变更为&nbsp;'.round($post['highest_withdraw_sum'],2).'<br/>';
                    }            
                    if($oldDatas['valid_area'] != $post['valid_area']){
                        $desc .= '有效区域由&nbsp;'.$oldDatas['valid_area'].'&nbsp;变更为&nbsp;'.$post['valid_area'].'<br/>';
                    }           
                    if($oldDatas['poster_rules'] != $post['poster_rules']){
                        $desc .= '活动规则由&nbsp;'.$oldDatas['poster_rules'].'&nbsp;变更为&nbsp;'.$post['poster_rules'].'<br/>';
                    }                
                    if($oldDatas['valid_begintime'] != $post['valid_begintime'] && $post['valid_begintime'] != ''){
                        $desc .= '开始日期由&nbsp;'.$oldDatas['valid_begintime'].'&nbsp;变更为&nbsp;'.$post['valid_begintime'].'<br/>';
                    }                
                    if($oldDatas['valid_endtime'] != $post['valid_endtime'] && $post['valid_endtime'] != ''){
                        $desc .= '结束日期由&nbsp;'.$oldDatas['valid_endtime'].'&nbsp;变更为&nbsp;'.$post['valid_endtime'].'<br/>';
                    }                
                    if($oldDatas['photo_url'] != $post['photo_pic']){
                        $desc .= '封面图进行了重新上传'.'<br/>';
                    }
                    $insertLog = $this->InsertLog($_GET['id'],$desc);
                    $this->redirect(array('poster/index'));
                }
            }
            
    }

    public function actionView($pageNo=1, $pageSize=10){
        $id = isset($_GET['id'])?$_GET['id']:'';
        $attributesArr = array();
        if($id != ''){            
            $sql = ' AND pid = '.$id;
            $model = new FhPosterLogModel;
            $mySearch = $model->mySearch2($sql);
            $listData =  $this->convertModelToArray($mySearch['list']);
            $pages = $mySearch['pages'];
            $model->attributes = $attributesArr;
            $arrRender = array(
                'listData'=>$listData,
                'pages' => $pages,
            );
            $this->smartyRender('poster/view.tpl',$arrRender);
        }
    }

    public function actionSetStatus(){
        $code = false;
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($id != ''){
            $modela = new FhPosterModel;   
            $updatea = $modela->updateAll(array('poster_status'=>1));
            $updateb = $modela->updateByPk($id,array('poster_status'=>2));
            if($updateb){
                $code = true;
                $insertLog = $this->InsertLog($_GET['id'],'海报状态由&nbsp无效&nbsp变更为&nbsp有效');
            }            
        }
         echo json_encode($code);
    }
    public function actionSetStatusTwo(){
        $code = false;
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($id != ''){
            $modela = new FhPosterModel;   
            $update = $modela->updateByPk($id,array('poster_status'=>1));
            if($update){
                $code = true;
                $insertLog = $this->InsertLog($_GET['id'],'海报状态由&nbsp有效&nbsp变更为&nbsp无效');
            }            
        }
         echo json_encode($code);
    }
    public function InsertLog($id,$desc){
        $data2 = array();
        $modell = new FhPosterLogModel;
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
