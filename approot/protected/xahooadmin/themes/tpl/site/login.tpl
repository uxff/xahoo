<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登录</title>
<link rel="stylesheet" href="{$resourcePath}/css/login/fh_login.css" />
</head>
<body class="login-layout light-login" style="" old-backgrand="background:url({$resourcePath}/images/login/sea_background_01.jpg) no-repeat center">
    <!--new div start-->
    <div class="login_box">
        <div class="" "login_top" style="text-align:center;align:center;display:none">
            <a href="javascript:;" style="display:none"><img src="{$resourcePath}/images/login/login_logo_fh.png" alt=""></a>
            <div class="login_title">Xahoo后台管理系统</div>
        </div>
        <div class="login_cont">
            <div class="main" style="text-align:center">
                <div class="" "login_form">
                    <form id="login-form" action="backend.php?r=site/login" method="post">
                        <br/>
                        <h1 style="color:#517AC3">Xahoo后台管理系统</h1>
                        <br/>
                        <h3>用户登录</h3>
                        <br/>
                        <div>
                            <input type="text" name="LoginForm[username]" id="LoginForm_username" placeholder="用户名" tabindex="1"/>
                        </div>
                        <br/>
                        <div>
                            <input type="password" name="LoginForm[password]" id="LoginForm_password"  placeholder="密码" tabindex="2"/>
                        </div>
                        <br/>
                        <div>
                            <input type="submit" value="登 录" />
                        </div>
                        <br/>
                    </form>
                </div>
            </div>
        </div>
        <div class="login_bottom">
            <p>Copyright ©2016 xahoo.xenith.top. All Rights Reserved. Xahoo 版权所有</p>
        </div>
    </div>	
</body>
</html>
