<?php

/**
 * ApiBaseController class file
 */
class ApiBaseController extends Controller {
//        public function init() {
//                parent::init();
//                //验证请求
//                $token = !isset($_REQUEST['token']) ? '' : $this->getString($_REQUEST['token']);
//                $project_name = !isset($_REQUEST['source']) ? '' : $this->getString($_REQUEST['source']);
//                $time_sign = !isset($_REQUEST['time_sign']) ? '' : $this->getString($_REQUEST['time_sign']);
//                if (empty($token)) {
//                        // send error
//                        $this->sendApiError('token不能为空');
//                }
//                $arrSqlParams = array(
//                    'condition' => 'project_name="' . $project_name . '"',
//                );
//                $queryResult = TaskProject::model()->find($arrSqlParams);
//
//                $appkey = $queryResult->project_appkey;
//                $appsecret = $queryResult->project_appsecret;
//                $token_str = strtoupper(md5($appkey . $appsecret . $time_sign));
//                file_put_contents('token.log', $token_str.'=='.$appkey.$appsecret.$time_sign.$project_name);
//                if ($token_str != $token) {
//                        $this->sendApiError('token无效');
//                }
//        }

        public function getInt($str) {
                if (!isset($str)) {
                        return null;
                } else {
                        return intval($str);
                }
        }

        public function getString($str) {
                $str = trim($str);
                return addslashes($str);
        }

        public function getParam($name) {
                return Yii::app()->request->getParam($name);
        }

        public function sendResult($data=array(), $dataKey='') {

            //根据key格式话结果数组
            if($dataKey == '') {
                $result = empty($data) ? array() : $data;
            } else {
                $result = empty($data) ? array($dataKey=>array()) : array($dataKey=>$data);
            }

            //根据结果状态格式化返回结果
            $formatedData = array(
                'code' => '0',
                'errMsg' => 'success',
                'data' => $result,
            );

            //render
            echo CJSON::encode($formatedData);
            die();
        }

        public function sendApiError($message) {
                $formatedData = array(
                    'status' => 'fail',
                    'message' => $message,
                );
                //render
                $this->sendResult($formatedData);
                exit();
        }
}
