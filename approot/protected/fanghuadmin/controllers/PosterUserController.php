<?php

class PosterUserController extends Controller
{

    public function actionIndex($keyword='', $pageNo=1, $pageSize=10) {
        $sql = "";            
        $model = new FhMemberHaibaoModel;
        $attributesArr = array();
        if (isset($_POST['poster'])) {
            if($_POST['poster']['name'] != ''){
                $sql .= " AND t.wx_nickname like "."'%".$_POST['poster']['name']."%'";
            }
            if($_POST['poster']['phone'] != ''){
                $sql .= " AND t.member_mobile like "."'%".$_POST['poster']['phone']."%'";                
            }
            if($_POST['poster']['type'] != ''){
                $sql .= " AND t.is_jjr = ".(int)$_POST['poster']['type'];                
            }
            if($_POST['poster']['project'] != ''){
                $sql .= " AND t.project_id = ".(int)$_POST['poster']['project'];                
            }
            $model->attributes = $attributesArr;
        }
        $mySearch = $model->mySearch2($sql);
        $listData =  $this->convertModelToArray($mySearch['list']);
        $projectData = Project::model()->findAll();
        $projectDatas= $this->convertModelToArray($projectData);
        $pages = $mySearch['pages'];
        $arrRender = array(
            'listData'=>$listData,
            'pages' => $pages,
            'projectDatas' => $projectDatas,
            'project_id' => $_POST['poster']['project'],
            'type' => $_POST['poster']['type'],
            'name' => $_POST['poster']['name'],
            'phone' => $_POST['poster']['phone'],
        );
        $this->smartyRender('posteruser/index.tpl', $arrRender);
    }
    

    public function actionView(){
        $id = isset($_GET['id'])?$_GET['id']:'';
        if($id != ''){            
            $model = new FhMemberHaibaoModel;
            $mySearch = $model->findByPk($id);
            $listData =  $this->convertModelToArray($mySearch);
            $arrRender = array(
                'listData'=>$listData,
            );
            $this->smartyRender('posteruser/view.tpl',$arrRender);
        }
    }

}
