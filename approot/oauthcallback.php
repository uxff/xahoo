<?php
$code = $_REQUEST['code'];
$info = '';
//echo $code;
if (empty($_REQUEST['state']))
{
        echo '未验证的请求。。。 code='.$code ;
        //redirect('/w/index.php');
}
else if ($_REQUEST['state'] == 'wb')
{

        $url = "/index.php?r=weibo/codetotoken&code=".$code;
        $info = 'oauth get code success. ';
        //echo "<a href='".$_SERVER['HTTP_HOST'].":/".$url."'>进入新浪微博</a>";
        //header("Location: $url");
}
else if ($_REQUEST['state'] == 'tx')
{
        //$url = "/w/index.php/Account/tx_auth?".http_build_query($_REQUEST);
        $info = 'oauth get code failed.';
        //echo "<a href='".$_SERVER['HTTP_HOST'].":/".$url."'>进入腾讯微博</a>";
        //header("Location: $url");

}
else
{
        $info = 'unknown state when oauth get code: state='.$_REQUEST['state'];

}
?>
<html>
<head>
<!--
<meta http-equiv="refresh" content="1;url=<?php echo $url; ?>">
-->
<?php #echo "<script>location.href='$url';</script>"; ?>
</head>
<body>
<?php echo $info;?>
<br/>
this page will auth go next. if not, <a href="<?php echo $url; ?>">click here go on</a>.

</body>
</html>
