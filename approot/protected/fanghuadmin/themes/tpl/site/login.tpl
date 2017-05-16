<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登录</title>
<link rel="stylesheet" href="{$resourcePath}/css/login/fh_login.css" />
</head>
<body class="login-layout light-login">
    <!--new div start-->
    <div class="login_box">
        <div class="login_top">
            <a href="javascript:;"><img src="{$resourcePath}/images/login/login_logo_fh.png" alt=""></a>
            <div class="login_title">后台管理系统</div>
        </div>
        <div class="login_cont" style="background:url({$resourcePath}/images/login/login_bg_fh.jpg) no-repeat center">
            <div class="main">
                <div class="login_form">
                    <form id="login-form" action="fanghuadmin.php?r=site/login" method="post">
                        <h3>用户登录</h3>
                        <div>
                            <input type="text" name="LoginForm[username]" id="LoginForm_username" placeholder="用户名" tabindex="1"/>
                        </div>
                        <div>
                            <input type="password" name="LoginForm[password]" id="LoginForm_password"  placeholder="密码" tabindex="2"/>
                        </div>
                        <div>
                            <input type="submit" value="登 录" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="login_bottom">
            <p>Copyright ©2016xqshijie.com. All Rights Reserved. 天津活力营销顾问有限公司 版权所有 津ICP备16004915号-3</p>
        </div>
    </div>	
</body>
</html>
