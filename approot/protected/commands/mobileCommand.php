<?php
/**
* 房否相关自动脚本
* coderdyc@qianjins.com
* 2015-12-23
*/
class mobileCommand  extends CConsoleCommand 
{
    /**
     * 订单支付7个工作日到期前2天自动发送短信 未加crontab处理
     */
    
    //D:\htdocs\xqshijie\main\protected\commands>D:\wamp\bin\php\php5.5.1\php console.php mobile Send
    public function actionSend($args){
        $Module = Yii::app()->getModule('mobile');
        $Module->sendSMS()->sendTask();
    }
}