
<!DOCTYPE html>
<html lang="en">
        <head>
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
                <meta charset="utf-8" />
                <title>404 Error Page - Xahoo项目系统提示</title>

                <meta name="description" content="404 Error Page" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

                <!-- bootstrap & fontawesome -->
                <link rel="stylesheet" href="{$resourcePath}/css/bootstrap.min.css" />
                <link rel="stylesheet" href="{$resourcePath}/css/font-awesome.min.css" />

                <!-- page specific plugin styles -->

                <!-- text fonts -->
                <link rel="stylesheet" href="{$resourcePath}/css/ace-fonts.css" />

                <!-- ace styles -->
                <link rel="stylesheet" href="{$resourcePath}/css/ace.min.css" id="main-ace-style" />

                <!--[if lte IE 9]>
                        <link rel="stylesheet" href="{$resourcePath}/css/ace-part2.min.css" />
                <![endif]-->
                <link rel="stylesheet" href="{$resourcePath}/css/ace-skins.min.css" />
                <link rel="stylesheet" href="{$resourcePath}/css/ace-rtl.min.css" />

                <!--[if lte IE 9]>
                  <link rel="stylesheet" href="{$resourcePath}/css/ace-ie.min.css" />
                <![endif]-->

                <!-- inline styles related to this page -->

                <!-- ace settings handler -->
                <script src="{$resourcePath}/js/ace-extra.min.js"></script>

                <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

                <!--[if lte IE 8]>
                <script src="{$resourcePath}/js/html5shiv.min.js"></script>
                <script src="{$resourcePath}/js/respond.min.js"></script>
                <![endif]-->
        </head>

        <body class="no-skin">
                <!-- #section:basics/navbar.layout -->
                <div id="navbar" class="navbar navbar-default">

                        <div class="navbar-container" id="navbar-container">
                                <!-- #section:basics/sidebar.mobile.toggle -->
                                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                                        <span class="sr-only">Toggle sidebar</span>

                                        <span class="icon-bar"></span>

                                        <span class="icon-bar"></span>

                                        <span class="icon-bar"></span>
                                </button>

                                <!-- /section:basics/sidebar.mobile.toggle -->
                                <div class="navbar-header pull-left">
                                        <!-- #section:basics/navbar.layout.brand -->
                                        <a href="#" class="navbar-brand">
                                                <small>
                                                        <i class="fa fa-leaf"></i>
                                                        Xahoo项目系统提示
                                                </small>
                                        </a>

                                        <!-- /section:basics/navbar.layout.brand -->

                                        <!-- #section:basics/navbar.toggle -->

                                        <!-- /section:basics/navbar.toggle -->
                                </div>

                                <!-- #section:basics/navbar.dropdown -->


                                <!-- /section:basics/navbar.dropdown -->
                        </div><!-- /.navbar-container -->
                </div>

                <!-- /section:basics/navbar.layout -->
                <div class="main-container" id="main-container">

                        <!-- #section:basics/sidebar -->


                        <!-- /section:basics/sidebar -->
                        <div class="main-content">
                                <!-- #section:basics/content.breadcrumbs -->


                                <!-- /section:basics/content.breadcrumbs -->
                                <div class="page-content">
                                        <!-- #section:settings.box -->
                                        <div class="ace-settings-container" id="ace-settings-container">
                                                <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                                        <i class="ace-icon fa fa-cog bigger-150"></i>
                                                </div>

                                                <div class="ace-settings-box clearfix" id="ace-settings-box">
                                                        <div class="pull-left width-50">
                                                                <!-- #section:settings.skins -->
                                                                <div class="ace-settings-item">
                                                                        <div class="pull-left">
                                                                                <select id="skin-colorpicker" class="hide">
                                                                                        <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                                                                        <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                                                                        <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                                                                        <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                                                                </select>
                                                                        </div>
                                                                        <span>&nbsp; Choose Skin</span>
                                                                </div>

                                                                <!-- /section:settings.skins -->

                                                                <!-- #section:settings.navbar -->
                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                                                                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                                                </div>

                                                                <!-- /section:settings.navbar -->

                                                                <!-- #section:settings.sidebar -->
                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                                                                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                                                </div>

                                                                <!-- /section:settings.sidebar -->

                                                                <!-- #section:settings.breadcrumbs -->
                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                                                                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                                                </div>

                                                                <!-- /section:settings.breadcrumbs -->

                                                                <!-- #section:settings.rtl -->
                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                                                                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                                                </div>

                                                                <!-- /section:settings.rtl -->

                                                                <!-- #section:settings.container -->
                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                                                                        <label class="lbl" for="ace-settings-add-container">
                                                                                Inside
                                                                                <b>.container</b>
                                                                        </label>
                                                                </div>

                                                                <!-- /section:settings.container -->
                                                        </div><!-- /.pull-left -->

                                                        <div class="pull-left width-50">
                                                                <!-- #section:basics/sidebar.options -->
                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                                                                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                                                </div>

                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                                                                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                                                </div>

                                                                <div class="ace-settings-item">
                                                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                                                                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                                                </div>

                                                                <!-- /section:basics/sidebar.options -->
                                                        </div><!-- /.pull-left -->
                                                </div><!-- /.ace-settings-box -->
                                        </div><!-- /.ace-settings-container -->

                                        <!-- /section:settings.box -->
                                        <div class="page-content-area">
                                                <div class="row">
                                                        <div class="col-xs-12">
                                                                <!-- PAGE CONTENT BEGINS -->

                                                                <!-- #section:pages/error -->
                                                                <div class="error-container">
                                                                        <div class="well">
                                                                                <h1 class="grey lighter smaller">
                                                                                        <span class="blue bigger-125">
                                                                                                <i class="ace-icon fa fa-sitemap"></i>
                                                                                                {$error.code}
                                                                                        </span>
                                                                                        {$error.message}
                                                                                </h1>

                                                                                <hr />
                                                                                <h3 class="lighter smaller">
                                                                                        请联系系统管理员
                                                                                        <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
                                                                                        On it！！
                                                                                </h3>

                                                                                <div>

                                                                                </div>

                                                                                <hr />
                                                                                <div class="space"></div>

                                                                                <div class="center">
                                                                                        <a href="javascript:history.back()" class="btn btn-grey">
                                                                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                                                                返回上一页
                                                                                        </a>

                                                                                        <a href="backend.php?r=site/login" class="btn btn-primary">
                                                                                                <i class="ace-icon fa fa-tachometer"></i>
                                                                                                切换账号
                                                                                        </a>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                                <!-- /section:pages/error -->

                                                                <!-- PAGE CONTENT ENDS -->
                                                        </div><!-- /.col -->
                                                </div><!-- /.row -->
                                        </div><!-- /.page-content-area -->
                                </div><!-- /.page-content -->
                        </div><!-- /.main-content -->

                        <div class="footer">
                                <div class="footer-inner">
                                        <!-- #section:basics/footer -->
                                        <div class="footer-content">
                                                <span class="bigger-120">
                                                        <span class="blue bolder">Xahoo</span>
                                                        Application &copy; 2014-2017
                                                </span>


                                        </div>

                                        <!-- /section:basics/footer -->
                                </div>
                        </div>

                        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                        </a>
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
                <script src="{$resourcePath}/js/bootstrap.min.js"></script>

                <!-- page specific plugin scripts -->

                <!-- ace scripts -->
                <script src="{$resourcePath}/js/ace-elements.min.js"></script>
                <script src="{$resourcePath}/js/ace.min.js"></script>

                <!-- inline scripts related to this page -->

                <!-- the following scripts are used in demo only for onpage help and you don't need them -->
                <link rel="stylesheet" href="{$resourcePath}/css/ace.onpage-help.css" />
                <link rel="stylesheet" href="../docs/assets/js/themes/sunburst.css" />

                <script type="text/javascript"> ace.vars['base'] = '..';</script>
                <script src="{$resourcePath}/js/ace/elements.onpage-help.js"></script>
                <script src="{$resourcePath}/js/ace/ace.onpage-help.js"></script>
                <script src="../docs/assets/js/rainbow.js"></script>
                <script src="../docs/assets/js/language/generic.js"></script>
                <script src="../docs/assets/js/language/html.js"></script>
                <script src="../docs/assets/js/language/css.js"></script>
                <script src="../docs/assets/js/language/javascript.js"></script>
        </body>
</html>
