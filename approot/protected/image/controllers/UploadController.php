<?php

/*
 * 此组件用来上传文件

 * @author hifang
 */

class UploadController extends Controller {

        //put your code here
        /**
         * @return array action filters
         */
//        public function filters() {
//                return array(
//                );
//        }
        private $_config = array();

        public function __construct($id, $module = null) {
                //$this->_config = require(Yii::getPathOfAlias('application.common.config') . DIRECTORY_SEPARATOR . 'imagethumb.php');
                parent::__construct($id, $module);
        }

        public function actionIndex() {
                $this->smartyRender("upload/create.tpl");
        }

        private function getFileName($cUpfile) {
                $news_name1 = date("YmdHis") . time() . rand(100, 999);
                $news_name = $news_name1 . "." . $cUpfile->extensionName;
                return $news_name;
        }

        public function actionPost() {
                $up_dir = $this->upload_dir();
                $upfile = CUploadedFile::getInstanceByName("upfile");
                $news_name = $this->getFileName($upfile);
                if (!is_null($upfile)) {
                        $up_rule = 'gif,jpg,png,bmp,jpeg';
                        $imagetype = strtolower($upfile->extensionName);

                        if (preg_match('/' . $upfile->extensionName . '/', $up_rule)) {
                                //判断图片大小
                                $filesize = $upfile->getSize();
                                if ($filesize > 10240 * 10240) {
                                        echo "<script>alert('请上传小于1M的图片');</script>";
                                        exit;
                                }

                                if ($upfile->saveAs($up_dir['ori'] . $news_name)) {
                                        $filesplit = "";
                                        $path = $up_dir['ori'] . $news_name;
                                        /*$im = null;

                                        if ($imagetype == 'gif') {
                                                $im = imagecreatefromgif($path);
                                        } else if ($imagetype == 'jpg') {
                                                $im = imagecreatefromjpeg($path);
                                        } else if ($imagetype == 'png') {
                                                $im = imagecreatefrompng($path);
                                        } else if ($imagetype == 'bmp') {
                                                $im = imagecreatefromwbmp($path);
                                        }
                                        
                                        foreach ($up_dir['thumb'] as $key => $value) {
                                                list($wid, $wei) = explode("x", $this->_config['allsize'][$key]);
                                                $thumbpath = $value . $news_name;
                                                CThumb::resizeImage($im, $wid, $wei, $thumbpath, ''); //
                                        }*/
                                        $source = $_POST['source'];
                                        $array = array(
                                            "state" => "SUCCESS",
                                            //"url" => Yii::app()->params['sitepath'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', $pathnew),
                                            
                                            'url' => $up_dir['url'] . $news_name,
                                            "title" => "",
                                            "original" => "",
                                            "type" => "",
                                            "size" => ""
                                        );


                                        if ($source == 'housethumb') {
                                                $model = new ZybHousePicture();

                                                $model->house_id = $_POST['house_id'];
                                                $model->picture_type = $_POST['picture_type'];
                                                $model->picture_url = $up_dir['url'] . $news_name;

                                                if (!$model->save()) {
                                                        return false;
                                                }
                                        }

                                        echo json_encode($array);
                                } else {
                                        
                                }
                        }
                }
        }

        private function upload_dir() {
//                $delimiter = '';
//                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
//                        $delimiter = '/';
//                } else {
//                        $delimiter = DIRECTORY_SEPARATOR;
//                }

                $root_folder = yii::app()->params['uploadPic']['basePath'];
                //创建upload根目录
                if (!file_exists($root_folder)) {
                        mkdir($root_folder);
                }

                $uppath = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR;
                //创建月份目录
                if (!file_exists($uppath)) {
                        mkdir($uppath, 0777);
                }
                $rtpath = $paths = array();
                //创建各尺寸目录
                $rtpath['ori'] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR;

                /*foreach ($this->_config['allsize'] as $value) {
                        $rtpath['thumb'][] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . $value . DIRECTORY_SEPARATOR;
                }*/

                /*foreach ($paths as $value) {
                        if (!file_exists($value)) {
                                mkdir($value, 0777);
                        }
                }*/
                $rtpath['url'] = yii::app()->params['uploadPic']['webPath'] . date("Ym") . "/";
                return $rtpath;
        }

}
