<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Test</title>
</head>
<body>
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


        $redirect_uri = urlencode("http://testhifang.fangfull.com/weixin/accredit.php");
        //授权URL 
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf390a29799db62e4&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=123#wechat_redirect";

        //基础access_token
        $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".SECRET;
                
            $test = new test();
        $access_token = $test->getSslPage($access_token);
        $access_token = json_decode($access_token);
        $access_token = $access_token->access_token;
        
        //获取菜单配置
        $menu_url = "https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=".$access_token;
            
        //删除菜单
        $menu_del = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token;



?>
    <div id="div">
    <a href="<?php echo $url; ?>">授权test</a><br/>
    <a href="<?php echo $menu_url;?>">获取菜单配置</a><br/>
   <!-- <a href="<?php echo $menu_del;?>">删除菜单</a> -->

    </div>
</body>
</html>
