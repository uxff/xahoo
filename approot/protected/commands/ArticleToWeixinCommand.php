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
        //$menu = $this->weObj->getMenu();
        //print_r($menu);

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
            //$imgUrls = preg_match_all('', $artObj->content)
            $theNewContent = $this->replaceImgTag($artObj->content);

            // 准备缩略图
            //$thumbMedia = $this->uploadImg($theFirstImg);
            // 使用缩略图接口上传
            $thumbParam = ['media'=>'@/pathto/file.png'];
            $thumbMedia = $this->weObj->uploadForeverMedia($thumbParam);

            $articles = [[
                'thumb_media_id' => '',
                'author' => '', // null
                'title' => '',
                'content_source_url' => '', // null
                'content' => '',
                'digest' => '', // null
                'show_cover_pic' => '',// null
            ]];

            // 每个文章要搜索里面的图片 上传到mp
            $mediaInfo = $this->weObj->uploadArticles($articles);

            // 将media_id保存，等待发送mp消息使用
            // 然后将替换图片地址后的整个html上传到mp
            // 群发只能用media_id发送
            // 单发可回复图文消息,带上url


            $this->saveMedia($mediaInfo['media_id'], 'NEWS', $this->mpid);

            // 准备群发
            $massSendParam = [
                'filter' => ['is_to_all' => true, 'group_id' => 0],
                // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
                'msgtype' => ['mpnews' => $mediaInfo['media_id']],
            ];
            $res = $this->sendGroupMassMessage($massSendParam);
        }
        echo "done\n";
    }

    // 处理html中的img为微信的
    protected function replaceImgTag($html) {
        $str &= $html;
        $reg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
        preg_match_all($reg,$str,$mat);
        for($i=0;$i<count($mat[0]);$i++){
            echo 'MATCHED 0====>'.$mat[0][$i].' 1====>'.$mat[2][$i]."\n";
            $targetUrl = $this->uploadImg($mat[2][$i]);
            $str = str_replace($mat[2][$i], $targetUrl, $str);
        }
        return $str;
    }

    protected function uploadImg($imgUrl) {

        $localFile = $this->downloadImg($imgUrl);

        $data = ['media' => new CURLFile($localFile)];
        $res = $this->weObj->uploadImg($data);
        $newImgUrl = $res['url'];
        return $newImgUrl;
    }

    protected function downloadImg($url) {

        $path = $this->getPicRuntimePath().'mpimg_'.date('YmdHis').'_'.substr(md5(mt_rand()), 0, 8).'.jpg';
        Http::curldownload($url, $path);

        //Yii::log('保存一个图片('.$url.')到本地:'.$path, 'warning', __METHOD__);
        return $path;

    }
    public function getPicRuntimePath() {
        $dir = Yii::app()->runtimePath.'/mppic/';
        if (!file_exists($dir)) {
            if (@mkdir($dir, 0777, true)) {
                Yii::log('mkdir(runtimePath='.$dir.') success', 'warning', __METHOD__);
            } else {
                Yii::log('mkdir(runtimePath='.$dir.') error', 'error', __METHOD__);
            }
        }
        return $dir;
    }

}
