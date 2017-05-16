<?php
/**
* PHP 简单的一个Log类封装
*
* @author liutao & huangcw
* @date 2014/08/24 19:10:25
* @version $Revision: 1.1 $
* @todo
*
*  how to use:
*
*  AresLogManager::log_error(array('logKey' => '[Login]', 'desc' => 'login error', 'parameters' => $_REQUEST);
* 
*  AresLogManager::log_bi(array('logKey' => '[Register]', 'desc' => 'create new customer', 'parameters' => $_REQUEST, 'response' => $result));
*
*  AresLogManager::log_info(array('logKey' => '[Register]', 'desc' => 'send welcome email success', 'parameters' => $_REQUEST);
* 
*/

class AresLogManager extends CComponent {
    // For BI 每条都会记录
    const LOG_LEVEL_BI = 0;
    // 程序出错，造成网站某些页面不能访问
    const LOG_LEVEL_ERR = 1;
    // 程序的一些异常分支，不影响网站页面的访问
    const LOG_LEVEL_WARNING = 2;
    // 程序的运行信息，不影响网站页面的访问
    const LOG_LEVEL_INFO = 3;
    // 一些关键代码加debug信息，主要用于测试开发及在线debug
    const LOG_LEVEL_DEBUG = 4;
 
 
    // Log切分的控制
 
    // Log不切分
    const LOG_NOT_SPLIT = 0;
    // Log按照时间(天)切分
    const LOG_SPLIT_BY_TIME = 1;
    // Log按照Level切分
    const LOG_SPLIT_BY_LEVEL = 2;
    // Log按照时间和level一起切分
    const LOG_SPLIT_BY_TIME_AND_LEVEL = 3;
 
    // 用于按日志级别切分日志
    public static $logLevelWord = array('0'=>'BI',
                                        '1'=>'ERROR',
                                        '2'=>'WARNING',
                                        '3'=>'INFO',
                                        '4'=>'DEBUG',
                                        );
 
    // 默认的Log配置，可被config/main.php中配置覆盖(LOG_PATH,LOG_NAME,LOG_LEVEL,LOG_MAIL)
    public static $logPath = "/tmp/";
    public static $logFile = "app.log";
    public static $logLevel = 4;
    public static $logMail = "";
 
    public static function log($message,$level,$filename='',$splitType = 0) {
        // 确定默认的log级别
        if (!empty(Yii::app()->params['LOG_LEVEL'])) {
            self::$logLevel = Yii::app()->params['LOG_LEVEL'];
        }

        if ($level <= self::$logLevel) {
            // 确定log的Path
            if (!empty(Yii::app()->params['LOG_PATH'])) {
                self::$logPath = Yii::app()->params['LOG_PATH'];
            }
            // 确定log的Name
            if (trim($filename) != '') {
                self::$logFile = $filename;
            } else {
                if (!empty(Yii::app()->params['LOG_NAME'])) {
                    self::$logFile = Yii::app()->params['LOG_NAME'];
                }
            }
 
            // 根据log的参数确定文件名称
            $logFile = "";
            if ($splitType == self::LOG_SPLIT_BY_TIME) {
                $logFile = self::$logPath.self::$logFile."-".date('Y-m-d');
            } elseif ($splitType == self::LOG_SPLIT_BY_LEVEL) {
                $logFile = self::$logPath.self::$logFile."-".self::$logLevelWord[$level];
            } elseif ($splitType == self::LOG_SPLIT_BY_TIME_AND_LEVEL) {
                $logFile = self::$logPath.self::$logFile."-".self::$logLevelWord[$level]."-".date('Y-m-d');
            } else {
                $logFile = self::$logPath.self::$logFile;
            }

            // 日志文件处理 
            if (!is_file($logFile)) {
                touch($logFile);
                chmod($logFile, 0666);
            }
            error_log($message."\n",3,$logFile);
            
            // ERROR级别log处理
            if ($level == self::LOG_LEVEL_ERR) {
                if (!empty(Yii::app()->params['LOG_MAIL'])) {
                    // receiver
                    self::$logMail = Yii::app()->params['LOG_MAIL'];
                    
                    // message
                    $arrTmpMessage = json_decode($message,true);
                    $message = '[ '.$_SERVER['SERVER_NAME'].' ] error message:';
                    $message .= PHP_EOL;
                    $message .= '-------------------------------------------------------';
                    $message .= PHP_EOL.PHP_EOL;
                    $message .= var_export($arrTmpMessage, true);
                    // 邮件显示美化
                    $message = str_replace(' ', '&nbsp;&nbsp;', $message);
                    $message = nl2br($message);
                    $message = wordwrap($message, 70);
                    
                    // subject
                    $subject = 'PHP error_log message';
                    if (is_array($arrTmpMessage['logmessage']) && !empty($arrTmpMessage['logmessage']['logKey'])) {
                        $subject = $arrTmpMessage['logmessage']['logKey'];
                    }

                    // sendmail
                    $objMailer = new AresMailer();
                    $objMailer->clearLayout(); //不使用layout
                    $objMailer->setTo( self::$logMail );
                    $objMailer->setSubject( $subject );
                    $objMailer->setBody( $message );

                    $objMailer->send();
                    //mail(self::$logMail, $subject, $message, "Content-Type:text/plain;charset=utf-8");
                    //error_log($message,1,self::$logMail,"Content-Type:text/plain;charset=utf-8");
                }
            }
 
        }
    }

    /** 
     * 获取Log日志的基础信息 
     */
    public static function getLogBaseInfo() {
        //server
        $arrBaseInfo['SERVER_INFO'] = $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'];
        $arrBaseInfo['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
        $arrBaseInfo['time'] = date('Y-m-d H:i:s');
		$arrBaseInfo['ip'] = $_SERVER['REMOTE_ADDR'];
		
        //session
        // TODO解决掉无法读取_SESSION的问题
		$arrBaseInfo['session'] = @$_SESSION;
        if (isset($_SESSION['customer_id'])) {
            $arrBaseInfo['user_id'] = $_SESSION['customer_id'];
        } else {
            $arrBaseInfo['user_id'] = 0;
        }
		
		//request
        $arrBaseInfo['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
		$arrBaseInfo['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrBaseInfo['request_params'] = $_GET;    
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrBaseInfo['request_params'] = $_POST;
        } else {
            $arrBaseInfo['request_params'] = $_REQUEST;
		}

		return $arrBaseInfo;
	}
	 
 
    /**
     * 为了更方便的调用Log类，又封装了以下几个方法
     * 最主要的就是降log_error和log_debug默认按照error级别切分，其他都按照时间来进行切分
     */
    public static function log_error($message,$filename='',$splitType=self::LOG_SPLIT_BY_LEVEL) { 
        $arrLogInfo = self::getLogBaseInfo(); 
        $arrLogInfo['level'] = "ERROR"; 
        $arrLogInfo['logmessage'] = $message;
        $message = json_encode($arrLogInfo);
        self::log($message,self::LOG_LEVEL_ERR,$filename,$splitType);
    }
    public static function log_info($message,$filename='',$splitType=self::LOG_SPLIT_BY_TIME) {
        $arrLogInfo = self::getLogBaseInfo();
        $arrLogInfo['level'] = "INFO";
        $arrLogInfo['logmessage'] = $message;
        $message = json_encode($arrLogInfo);
        self::log($message,self::LOG_LEVEL_INFO,$filename,$splitType);
    }
    public static function log_bi($message,$filename='',$splitType=self::LOG_SPLIT_BY_TIME) {
        $arrLogInfo = self::getLogBaseInfo();
        $arrLogInfo['level'] = "BI";
        $arrLogInfo['logmessage'] = $message;
        $message = json_encode($arrLogInfo);
        self::log($message,self::LOG_LEVEL_BI,$filename,$splitType);
    }
    public static function log_warning($message,$filename='',$splitType=self::LOG_SPLIT_BY_TIME) {
        $arrLogInfo = self::getLogBaseInfo();
        $arrLogInfo['level'] = "WARNING";
        $arrLogInfo['logmessage'] = $message;
        $message = json_encode($arrLogInfo);
        self::log($message,self::LOG_LEVEL_WARNING,$filename,$splitType);
    }
    public static function log_debug($message,$filename='',$splitType = self::LOG_SPLIT_BY_LEVEL) {
        $arrLogInfo = self::getLogBaseInfo();
        $arrLogInfo['level'] = "DEBUG";
        $arrLogInfo['logmessage'] = $message;
        $message = json_encode($arrLogInfo);
        self::log($message,self::LOG_LEVEL_DEBUG,$filename,$splitType);
    }


}

