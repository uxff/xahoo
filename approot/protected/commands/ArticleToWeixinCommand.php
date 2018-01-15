<?php
/**
* 
* author: xdr
* date:   2016-01-26
* cmd:    php console.php ArticleToWeixin index --mpid=4 --origins=36kr+3,wx100000p+2 --limit=5
*/
class ArticleToWeixinCommand  extends CConsoleCommand 
{
    private $weObj;
    private $mpid;
    private $wechatOptions;
    private $adminOpenid = [
        '1' => ['oDizAwl-h6sqpuUW5PI_9tsasnoA'],
        '4' => ['oEkIsv4nTdjIcf1xw_bPdhiKkiu0'],
    ];

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

    public function actionIndex($mpid = 0, $appid = '', $aid = -1, $origins = '', $limit = 5) {
        $this->loadwechat($mpid, $appid);
        // 验证是否可用
        //$serverIp = $this->weObj->getServerIp();
        //print_r($serverIp);
        //$menu = $this->weObj->getMenu();
        //print_r($menu);
        Yii::log('mpid='.$mpid.' appid='.$appid.' aid='.$aid.' origins='.$origins.' limit='.$limit, 'warning', __METHOD__);

        $this->actionSyncArticle((int)$dur, 0, $aid, $origin, $limit);
        //单发消息
        //$this->weObj->sendCustomMessage();
    }
    
    // 统计文章 每天每文章访问数 
    // --origins=wx100000p,wx100000p,36kr+3,36kr
    public function actionSyncArticle($dur = -1, $includeToday = 0, $aid = -1, $origins = '', $limit = 5) {
        $dayLength = $dur;
        $now = time();
        $today = date('Y-m-d', $now-86400*7);
        if ($dayLength==-1) {
            $dayLength = (int)(($now - strtotime('2016-03-01')) / 86400);
        }

        $artList = [];
        // 查出在那天的文章
        if ($aid > 0) {
            $artList[] = ArticleModel::model()->find('id=:id', [':id'=>$aid]);
        } else {
            if ($origins) {
                $originMarks = explode(',', $origins);
                foreach ($originMarks as $originWithNum) {
                    $numMarks = explode('+', $originWithNum);
                    if (count($numMarks) == 0) {
                        continue;
                    }
                    $origin = $numMarks[0];
                    $num = intval($numMarks[1]) ? intval($numMarks[1]) : 1;


                    $preArtList = ArticleModel::model()->orderBy('t.id desc')->findAll('create_time >= :today and t.origin= :origin and type=0', [':today'=>$today.' 00:00:00', ':origin'=>$origin]);//('t.status = 2');
                    shuffle($preArtList);
                    
                    $artList = array_merge($artList, array_slice($preArtList, 0, $num));
                    Yii::log('selected  '.count($artList).' aids by origin='.$origin.' expected='.$num, 'warning', __METHOD__);
                    unset($preArtList);
                }
            } else {
                $artList = ArticleModel::model()->orderBy('t.id desc')->findAll('create_time >= :today', [':today'=>$today.' 00:00:00']);//('t.status = 2');
            }
        }
        //shuffle($artList);
        Yii::log('will sync aid='.$aid.'. selected count='.count($artList), 'warning', __METHOD__);

        $articles = ['articles'=>[]];
        $successNo = 0;

        foreach ($artList as $artObj) {

            if ($successNo>=$limit) {
                break;
            }

            // 替换文章内部图片
            //$imgUrls = preg_match_all('', $artObj->content)
            $theReplacedArticle = $this->replaceImgTag($artObj->content);
            $theNewContent = $theReplacedArticle['content'];
            Yii::log('after replaceImgTag: len(old content)='.strlen($artObj->content).' len(new content)='.strlen($theNewContent).' matchcount='.$theReplacedArticle['matchcount'], 'warning', __METHOD__);
            Yii::log('the replaced article pics uploaded:'.json_encode($theReplacedArticle['pics']), 'warning', __METHOD__);//pics=>[$urlOrigin, $urlUploaded, $localPath]

            if ($theReplacedArticle['pics'] == 0) {
                //
                continue;
            }

            if ($theReplacedArticle['matchcount'] == 0) {
                continue;
            }

            // 准备图文消息缩略图 缩略图必须使用永久素材media_id
            //$thumbMedia = $this->uploadImg($theFirstImg);//此接口返回url，不返回media_id

            list($firstImgWidth, $firstImgHeight) = getimagesize($theReplacedArticle['pics'][0][2]);

            $targetWidth = 500;
            $targetHeight = intval($firstImgHeight/($firstImgWidth/$targetWidth));

            $resizedThumbPath = $this->resizeImg($theReplacedArticle['pics'][0][2], $theReplacedArticle['pics'][0][2].'-'.$targetWidth.'x'.$targetHeight, $targetWidth, $targetHeight, 64*1024);

            if (!$resizedThumbPath) {
                Yii::log('resize failed and ignore: '.$theReplacedArticle['pics'][0][2], 'warning', __METHOD__);
                continue;
            }

            // 使用缩略图接口上传
            $thumbParam = ['media'=>'@'.$resizedThumbPath];//['media'=>'@/pathto/file.png'];
            //$thumbParam = ['media'=>'@'.'/tmp/xiaoqingxing.jpg'];
            //$thumbMedia = $this->weObj->uploadForeverMedia($thumbParam);// 返回url+media_id
            $thumbMedia = $this->weObj->UploadMedia($thumbParam, 'thumb');//false
            //$thumbMedia = $this->weObj->AlexUploadMedia($thumbParam, 'thumb');//false//invalid media size // 解决方法 使用小图片
            // 错误要用 $this->weObj->errMsg $this->weObj->errCode 来取
            Yii::log('after upload thumb Media param='.json_encode($thumbParam).' rets='.json_encode($thumbMedia). ' errMsg='.$this->weObj->errMsg.' '.$this->weObj->errCode, 'warning', __METHOD__);

            $articles['articles'][] = [
                // thumb_media_id 缩略图id // media_id 为空将导致发不出去
                'thumb_media_id' => $thumbMedia['thumb_media_id'],//'dHmuALCB4dZ597NUMweP4qlUWtw6579aRQ7BW7yZOjo',//$thumbMedia['media_id'],
                // author 作者
                'author' => $artObj->remark, // default null
                // 标题
                'title' => $artObj->title,
                // 阅读原文
                'content_source_url' => $artObj->outer_url, // default null
                // 内容
                'content' => $theNewContent,
                // 图文消息描述
                'digest' => '', // default null
                // 是否显示封面
                'show_cover_pic' => 1,// default null, 0 or 1
            ];
            $successNo++;
        }

        if (count($articles['articles']) == 0) {
            echo "no articles selected\n";
            return;
        }


        //exit;
        //echo 'will uploadnews:'. json_encode($articles)."\n";
            // 将替换后的html上传图文消息接口生成media_id
            $mpNewsMediaInfo = $this->weObj->uploadArticles($articles);
            // invalid media_id hint: [RSSvuA0469e604] 40007 // 解决方式 使用 thumb_media_id 
            Yii::log('after uploadArticles rets='.json_encode( $mpNewsMediaInfo). ' errMsg='.$this->weObj->errMsg.' '.$this->weObj->errCode, 'warning', __METHOD__);

            // 将media_id保存到本地，等待发送mp消息使用
            //$this->saveMedia($mpNewsMediaInfo['media_id'], 'NEWS', $this->mpid);

            // 群发只能用media_id发送 // 单发可回复图文消息,带上url

            // 准备群发
            $massSendParam = [
                // 群发使用 is_to_all=true  分组发使用 tag_id=1
                'filter' => ['is_to_all' => true, 'tag_id'=>1],
                // mpnews | voice | image | mpvideo => array( "media_id"=>"MediaId")
                //'msgtype' => ['mpnews' => $mpNewsMediaInfo['media_id']],
                'msgtype' => 'mpnews',
                'mpnews' => ['media_id'=>$mpNewsMediaInfo['media_id']],
                'send_ignore_reprint' => 0,
            ];

            $res = 'expected success.';//


            Yii::log('will sendGroupMassMessage res='.json_encode($res), 'warning', __METHOD__);
            $res = $this->weObj->sendGroupMassMessage($massSendParam);
            Yii::log('after sendGroupMassMessage res='.json_encode($res).'errMsg='.$this->weObj->errMsg.' '.$this->weObj->errCode, 'warning', __METHOD__);

            // mark as sent, type=9
            if ($res['errcode'] ==0 && $res['msg_id']) {
                echo "success done $successNo sendGroupMassMessage res=".json_encode($res)."\n";
                // success
                foreach ($artList as &$artObj) {
                    $artObj->type = 2;
                    $artObj->admin_id=1;
                    $artObj->admin_name = 'console';
                    $saveRet = $artObj->save();
                    if (!$saveRet) {
                        Yii::log('mark aid '.$artObj->id.' as success sent weixin falied:'.$artObj->lastError(), 'warning', __METHOD__);
                    }
                }
            } else {
                echo "done $successNo sendGroupMassMessage res=".json_encode($res)."\n";
            }
            //
            // 单发测试
            if (false)
            foreach ($this->adminOpenid[$this->mpid] as $openid) {
                // 发送非素材图文消息
                $singleMsg = ['touser'=>$openid, 'msgtype'=>'news', 'news'=>[
                    'articlecount'=>1, 'articles'=>[
                        'title'=>$artObj->title, 'description'=>$artObj->abstract, 'picurl'=>$theReplacedArticle['pics'][0], 'url'=>$artObj->outer_url]]];
                // 发送素材图文消息
                //$singleMsg = ['touser'=>$openid, 'msgtype'=>'mpnews', 'mpnews'=>['media_id'=>$mpNewsMediaInfo]];
                // 不能在没收到公众号事件的时候给用户回复消息，所以此发送无效
                $res = $this->weObj->sendCustomMessage($singleMsg);
                Yii::log('sendCustomMessage:'.json_encode($singleMsg).' res='.json_encode($res).' errMsg='.$this->weObj->errMsg.' '.$this->weObj->errCode, 'warning', __METHOD__);
            }
    }
    //protected function sendToMy

    // 处理html中的img为微信的
    protected function replaceImgTag($html) {
        $ret = [
            'content' => null,//$html,
            'pics' => [],
            'matchcount' => 0,
        ];

        $str = $html;//&= $ret['content'];
        $reg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
        preg_match_all($reg,$str,$mat);

        for($i=0;$i<count($mat[0]);$i++){
            $localFile = null;
            if (substr($mat[2][$i], 0, 20) == 'http://mmbiz.qpic.cn'
             || substr($mat[2][$i], 0, 21) == 'https://mmbiz.qpic.cn') {
                $targetUrl = $mat[2][$i];
                echo 'when replaceImgTag MATCHED 0====>'.$mat[0][$i].' 1====>'.$mat[2][$i].' NONDEED UPLOAD'."\n";
            } else {
                $targetUrl = $this->uploadImg($mat[2][$i], $localFile);
                $str = str_replace($mat[2][$i], $targetUrl, $str);
                echo 'when replaceImgTag MATCHED 0====>'.$mat[0][$i].' 1====>'.$mat[2][$i].' UPLOADED='.$targetUrl."\n";
            }
            $ret['pics'][] = [$mat[2][$i], $targetUrl, $localFile];
            $ret['matchcount']++;
        }

        $ret['content'] = $str;
        return $ret;
    }

    protected function uploadImg($imgUrl, &$localFile, $type = '') {

        $localFile = $this->downloadImg($imgUrl);

        $data = ['media' => new CURLFile($localFile)];
        if (!empty($type)) {
            $data['type'] = $type;
        }
        // 使用【上传图文消息内的图片获取URL】接口，不占用5000个资源限制
        $res = $this->weObj->uploadImg($data);
        $newImgUrl = $res['url'];
        return $newImgUrl;
    }

    protected function downloadImg($url) {

        $sizeInfo = getimagesize($url);

        $targetSuffix = 'jpg';
        switch ($sizeInfo['mime']) {
        case 'image/jpeg':
        case 'image/jpg':
            $targetSuffix = 'jpg';
            break;
        case 'image/png':
            $targetSuffix = 'png';
            break;
        case 'image/gif':
            $targetSuffix = 'gif';
            break;
        case 'image/webm':
            $targetSuffix = 'webm';
            break;
        }


        $pathPre = $this->getPicRuntimePath().'mpimg_'.date('YmdHis').'_'.substr(md5(mt_rand()), 0, 8);
        $path = $pathPre.'.'.$targetSuffix;
        $res = Http::curldownload($url, $path);

        $headerArr = explode("\r\n", $res['header']);
        $contentType = 'Content-Type:';
        $contentTypeVal = '';
        foreach ($headerArr as $header) {
            if (substr($header, 0, strlen($contentType)) == $contentTypea) {
                $contentTypeVal = trim(substr($header, strlen($contentType)));
                break;
            }
        }

        Yii::log('contentType='.$contentTypeVal);

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
    public function resizeImg($sourcePath, $savePath, $targetWidth, $targetHeight, $limitFileSize = 1024*1024) {
        $bgSuffixArr = explode('.', $sourcePath);

        $bgSuffix = $bgSuffixArr[count($bgSuffixArr)-1];
        $bgSuffix = substr($bgSuffix, 0, 3);

        switch (strtolower($bgSuffix)) {
        case 'jpg':
        case 'jpe':
            $bgImageSrc = imagecreatefromjpeg($sourcePath);
            break;
        case 'png':
            $bgImageSrc = imagecreatefrompng($sourcePath);
            break;
        case 'gif':
            $bgImageSrc = imagecreatefromgif($sourcePath);
            break;
        default:
            $bgImageSrc = imagecreatefromjpeg($sourcePath);
            break;
        }

        if (!$bgImageSrc) {
            Yii::log('cannot open img as resource:'.$sourcePath,'warning', __METHOD__);
            return false;
        }

        list($srcWidth, $srcHeight) = getimagesize($sourcePath);

        //$color = imagecolorAllocate($bgSrc,255,255,255);
        //imagefill($bgSrc, 0, 0, $color);

        do {
            $bgSrc = imagecreatetruecolor($targetWidth, $targetHeight);

            imagecopyresized($bgSrc, $bgImageSrc, 0, 0, 0, 0, $targetWidth, $targetHeight, $srcWidth, $srcHeight);

            // write out target
            imagejpeg($bgSrc, $savePath, 75);

            // redo smaller size if file too big
            $imageSize = filesize($savePath);
            if ($imageSize <= $limitFileSize) {
                break;
            }

            Yii::log('retry resize image from '.$imageSize.' to '.$limitFileSize.' '.$sourcePath, 'warning', __METHOD__);
            $targetWidth = intval($targetWidth/1.4);
            $targetHeight = intval($targetHeight/1.4);

            imagedestroy($bgSrc);
        } while(true);

        imagedestroy($bgImageSrc);
        imagedestroy($bgSrc);

        return $savePath;
    }

}
