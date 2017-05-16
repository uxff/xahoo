<?php
//Yii::import('application.common.extensions.AresUtil');
/**
 * Created by 【中弘集团】.
 * User: 张文庆
 * Date: 2015/7/15
 * Time: 20:00
 * Description: 新浪长连接转换成短链工具类
 */
Yii::import('application.common.extensions.shortUrl.sinaWeibo.ShortUrl');
class AreaShortUrl{

    /**
     * 获得短连接
     * @param $url //要转换的长连接
     * @return mixed
     */
    public static function getShortUrl($url) {
        return ShortUrl::getShortUrl($url);
    }

}



