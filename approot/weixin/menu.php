<?php
    define("APPID","wxf390a29799db62e4");
    define("SECRET","e27bf1e7338c2bd542d84983543e45da");
    class test{

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

        $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".SECRET;
                
            $test = new test();
        $access_token = $test->getSslPage($access_token);
        $access_token = json_decode($access_token);
        $access_token = $access_token->access_token;


$jsonmenu = '{
      "button":[
      {
            "name":"一级菜单1",
           "sub_button":[
            {
               "type":"click",
               "name":"菜单1.2.1",
               "key":"1.2.1"
            },
            {
               "type":"click",
               "name":"菜单1.2.2",
               "key":"1.2.2"
            },
            {
               "type":"click",
               "name":"菜单1.2.3",
               "key":"1.2.3"
            },
            {
               "type":"click",
               "name":"菜单1.2.4",
               "key":"1.2.4"
            },
            {
                "type":"view",
                "name":"菜单1.2.5",
                "url":"http://m.hao123.com/a/tianqi"
            }]
      

       },
       {
           "name":"一级菜单2",
           "sub_button":[
            {
               "type":"click",
               "name":"菜单2.2.1",
               "key":"2.2.1"
            },
            {
               "type":"click",
               "name":"菜单2.2.2",
               "key":"游戏"
            },
            {
                "type":"click",
                "name":"菜单2.2.3",
                "key":"笑话"
            }]
       

       }]
 }';


$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
