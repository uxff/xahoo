<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>登录系统</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{$resourcePath}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{$resourcePath}/css/font-awesome.min.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="{$resourcePath}/css/ace-fonts.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{$resourcePath}/css/ace.min.css" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{$resourcePath}/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="{$resourcePath}/css/ace-rtl.min.css" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="{$resourcePath}/css/ace-ie.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="{$resourcePath}/css/ace.onpage-help.css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="{$resourcePath}/js/html5shiv.js"></script>
    <script src="{$resourcePath}/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-layout light-login">
<div class="main-container">
<div class="main-content">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="login-container">
<!--
<div class="center">
        <h1>
                <i class="ace-icon fa fa-leaf green"></i>
                <span class="red">Ares</span>
                <span class="white" id="id-text2">Application</span>
        </h1>
        <h4 class="blue" id="id-company-text">&copy; 北京中弘网络营销科技有限公司</h4>
                                                        </div>
                                                        -->
<div class="space-6"></div>

<div class="position-relative">
    <div id="login-box" class="login-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="ace-icon fa fa-coffee green"></i>
                    登录系统
                </h4>

                <div class="space-6"></div>

                <form id="login-form" action="backend.php?r=index/login" method="post">
                    <fieldset>
                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="text" class="form-control" name="LoginForm[username]" id="LoginForm_username" placeholder="用户名" />
                                                                                                                        <i class="ace-icon fa fa-user"></i>
                                                                                                                </span>
                        </label>

                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="password" class="form-control" name="LoginForm[password]" id="LoginForm_password"  placeholder="密码" />
                                                                                                                        <i class="ace-icon fa fa-lock"></i>
                                                                                                                </span>
                        </label>

                        <div class="space"></div>

                        <div class="clearfix">
                            <!--
                            <label class="inline">
                                    <input type="checkbox" name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" class="ace" />
                                    <span class="lbl"> 记住密码</span>
                            </label>
                            -->
                            <button type="submit" value="Login" class="width-35 pull-right btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-key"></i>
                                <span class="bigger-110">登录</span>
                            </button>
                        </div>

                        <div class="space-4"></div>
                    </fieldset>
                </form>


            </div><!-- /.widget-main -->
            <!--
            <div class="toolbar  clearfix center">
                    <div>
                            <a href="#" data-target="#signup-box" class="user-signup-link">
                                    注册
                                    <i class="ace-icon fa fa-arrow-right"></i>
                            </a>
                    </div>
            </div>
            -->
        </div><!-- /.widget-body -->
    </div><!-- /.login-box -->

    <div id="forgot-box" class="forgot-box widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header red lighter bigger">
                    <i class="ace-icon fa fa-key"></i>
                    Retrieve Password
                </h4>

                <div class="space-6"></div>
                <p>
                    Enter your email and to receive instructions
                </p>

                <form>
                    <fieldset>
                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="email" class="form-control" placeholder="Email" />
                                                                                                                        <i class="ace-icon fa fa-envelope"></i>
                                                                                                                </span>
                        </label>

                        <div class="clearfix">
                            <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                <i class="ace-icon fa fa-lightbulb-o"></i>
                                <span class="bigger-110">Send Me!</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div><!-- /.widget-main -->

            <div class="toolbar center">
                <a href="#" data-target="#login-box" class="back-to-login-link">
                    Back to login
                    <i class="ace-icon fa fa-arrow-right"></i>
                </a>
            </div>
        </div><!-- /.widget-body -->
    </div><!-- /.forgot-box -->

    <div id="signup-box" class="signup-box widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header green lighter bigger">
                    <i class="ace-icon fa fa-users blue"></i>
                    新用户注册
                </h4>

                <div class="space-6"></div>
                <p>输入注册信息: </p>

                <form>
                    <fieldset>
                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="email" class="form-control" placeholder="电子邮箱" />
                                                                                                                        <i class="ace-icon fa fa-envelope"></i>
                                                                                                                </span>
                        </label>

                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="text" class="form-control"  placeholder="用户名" />
                                                                                                                        <i class="ace-icon fa fa-user"></i>
                                                                                                                </span>
                        </label>

                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="password" class="form-control" placeholder="密码" />
                                                                                                                        <i class="ace-icon fa fa-lock"></i>
                                                                                                                </span>
                        </label>

                        <label class="block clearfix">
                                                                                                                <span class="block input-icon input-icon-right">
                                                                                                                        <input type="password" class="form-control" placeholder="确认密码" />
                                                                                                                        <i class="ace-icon fa fa-retweet"></i>
                                                                                                                </span>
                        </label>

                        <label class="block">
                            <input type="checkbox" class="ace" />
                                                                                                                <span class="lbl">
                                                                                                                        我同意
                                                                                                                        <a href="#">用户使用协议</a>
                                                                                                                </span>
                        </label>

                        <div class="space-24"></div>

                        <div class="clearfix">
                            <button type="reset" class="width-30 pull-left btn btn-sm">
                                <i class="ace-icon fa fa-refresh"></i>
                                <span class="bigger-110">重置</span>
                            </button>

                            <button type="button" class="width-65 pull-right btn btn-sm btn-success">
                                <span class="bigger-110">注册</span>

                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="toolbar center">
                <a href="#" data-target="#login-box" class="back-to-login-link">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    返回登录
                </a>
            </div>
        </div><!-- /.widget-body -->
    </div><!-- /.signup-box -->
</div><!-- /.position-relative -->
<!--
<div class="navbar-fixed-top align-right">
        <br />
        切换主题：
        &nbsp;
        <a id="btn-login-dark" href="#">Dark</a>
        &nbsp;
        <span class="blue">/</span>
        &nbsp;
        <a id="btn-login-blur" href="#">Blur</a>
        &nbsp;
        <span class="blue">/</span>
        &nbsp;
        <a id="btn-login-light" href="#">Light</a>
        &nbsp; &nbsp; &nbsp;
</div>
-->
</div>
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.main-content -->
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='{$resourcePath}/js/jquery.min.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='{$resourcePath}/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement)
        document.write("<script src='{$resourcePath}/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function ($) {
        $(document).on('click', '.toolbar a[data-target]', function (e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');//hide others
            $(target).addClass('visible');//show target
        });
    });



    //you don't need this, just used for changing background
    jQuery(function ($) {
        $('#btn-login-dark').on('click', function (e) {
            $('body').attr('class', 'login-layout');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-light').on('click', function (e) {
            $('body').attr('class', 'login-layout light-login');
            $('#id-text2').attr('class', 'grey');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-blur').on('click', function (e) {
            $('body').attr('class', 'login-layout blur-login');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'light-blue');

            e.preventDefault();
        });

    });
</script>
</body>
</html>
