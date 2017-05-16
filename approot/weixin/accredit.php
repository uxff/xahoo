<?php

    $code = $_GET['code'];
    $access_token = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf390a29799db62e4&secret=e27bf1e7338c2bd542d84983543e45da&code=$code&grant_type=authorization_code";
    $test = new test();

    $access_token = $test->getSslPage($access_token);

    $access_token = json_decode($access_token,true);

    $info = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token['access_token']."&openid=wxf390a29799db62e4&lang=zh_CN";

    $info = $test->getSslPage($info);

    var_dump($info);
class test {

     function getSslPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

     }

}
