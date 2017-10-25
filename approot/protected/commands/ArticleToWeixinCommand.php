<?php
/**
* 
* author: xdr
* date:   2016-01-26
* cmd:    php console.php ArticleToWeixin index --mpid 1 --appid 'xxx'
*/
class ArticleToWeixinCommand  extends CConsoleCommand 
{
    private $weObj;
    private $mpid;
    private $wechatOptions;

    public function init() {
        Yii::import('application.common.extensions.*');
        Yii::import('application.common.components.*');
        Yii::import('application.common.extensions.wechatlib.*');
        Yii::import('application.common.extensions.util.*');
        Yii::import('application.xahoomodels.*');

    }

    public function loadwechat($accountId = 0, $appid = '') {
        if ($accountId) {
            $mpModel = FhPosterAccountsModel::model()->find('id=:id',array(':id'=>$accountId));
        }
        else if ($appid) {
            $mpModel = FhPosterAccountsModel::model()->find('appid=:appid',array(':appid'=>$appid));
        }
        if ($mpModel) {
            $mpData = $mpModel->toArray();
            $this->mpid = $mpData['id'];
            $this->wechatOptions = [
                'token' => $mpData['token'],
                'appid' => $mpData['appid'],
                'appsecret' => $mpData['appsecret'],
                'EncodingAESKey' => $mpData['EncodingAESKey'],
            ];
            $this->weObj = new Wechat($this->wechatOptions);
            //$this->weObj->valid();


        } else {
            Yii::log('cannot load wechat obj',  'warning', __METHOD__);
        }   

    }

    public function actionIndex($mpid = 0, $appid = '') {
        $this->loadwechat($mpid, $appid);
        // 验证是否可用
        //$serverIp = $this->weObj->getServerIp();
        //print_r($serverIp);
        $menu = $this->weObj->getMenu();
        print_r($menu);

        //$this->actionSyncArticle((int)$dur);
    }
    
    // 统计文章 每天每文章访问数 
    public function actionSyncArticle($dur = -1, $includeToday = 0) {
        $dayLength = $dur;
        $now = time();
        $today = date('Y-m-d', $now);
        if ($dayLength==-1) {
            $dayLength = (int)(($now - strtotime('2016-03-01')) / 86400);
        }

        // 查出在那天的文章
        $artList = ArticleModel::model()->orderBy('t.id desc')->findAll('create_time >= :today', [':today'=>$today.' 00:00:00']);//('t.status = 2');

        foreach ($artList as $artObj) {
            // 每个文章的在线区间
            $arrRange = ArticleOperLogModel::queryRange($artObj->id);

            // 每个文章要搜索里面的图片 上传到mp
            // 然后将替换图片地址后的整个html上传到mp
            // 将media_id保存，等待发送mp消息使用
            // 群发只能用media_id发送
            // 单发可回复图文消息,带上url
        }
        echo "done\n";
    }
}
