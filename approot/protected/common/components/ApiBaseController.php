<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ApiBaseController extends CController {


    /**
     * format API result
     *
     * @param string $data
     * @param array  $dataKey 返回数据的key
     * @access public
     * @return void
     */
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

    /**
     * format API error result
     *
     * @param string $errMsg
     * @param string $errCode
     * @access public
     * @return void
     *
     * @todo 定义更多错误code
     */
    public function sendError($errMsg, $errCode='999999') {
        //根据结果状态格式化返回结果
        $formatedData = array(
            'code' => $errCode,
            'errMsg' => $errMsg,
            'data' => array(),
        );

        //render
        echo CJSON::encode($formatedData);
        die();
    }

    /**
     * process parameter to integer for security
     * 
     * @param  string           $str
     * @return integer|null     
     */
    public function getInt($str) {
        if (!isset($str)) {
            return null;
        } else {
            return intval($str);
        }
     }

    /**
     * process parameter to string for security
     * 
     * @param  string $str 
     * @return string
     */
    public function getString($str) {
        $str = trim($str);
        return addslashes($str);
    }

    /**
     * get request parameter
     * 
     * @param  string $name fieldname
     * @return array
     */
    public function getParam($name) {
        return Yii::app()->request->getParam($name);
    }

    /**
     * 将Yii模型对象转为数组(多维)
     * 
     * @param  object $models          [description]
     * @param  array $filterAttributes [description]
     * @return array                   [description]
     *
     * @todo 格式化
     */
    public function convertModelToArray($models, array $filterAttributes = null) {
        if ($models == null) {
            return array();
        } else {
            return OBJTool::convertModelToArray($models, $filterAttributes);
        }
    }

}