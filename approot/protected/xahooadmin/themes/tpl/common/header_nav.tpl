<div id="navbar" class="navbar navbar-default">
        {literal} 
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>
        {/literal} 

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
                                        Xahoo<span class="hidden-xs">管理后台</span>
                                </small>
                        </a>

                        <!-- /section:basics/navbar.layout.brand -->

                        <!-- #section:basics/navbar.toggle -->

                        <!-- /section:basics/navbar.toggle -->
                </div>

                <!-- #section:basics/navbar.dropdown -->
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                        <ul class="nav ace-nav">
                                <li class="light-blue">
                                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                                <img class="nav-user-photo" src="{$resourcePath}/avatars/user.jpg" alt="Jason's Photo" />
                                                <span class="user-info">
                                                        <small>欢迎,</small>
                                                        {$loginUser}
                                                </span>

                                                <i class="ace-icon fa fa-caret-down"></i>
                                        </a>

                                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                                <!--  
                                                <li>
                                                    <a href="#">
                                                        <i class="ace-icon fa fa-cog"></i>
                                                        Settings
                                                    </a>
                                                </li>
                
                                                <li>
                                                    <a href="#">
                                                        <i class="ace-icon fa fa-user"></i>
                                                        Profile
                                                    </a>
                                                </li>
                                                
                                                <li class="divider"></li>
                                                -->
                                                {if $loginUser == 'Guest'}
                                                    <li>
                                                            <a href="backend.php?r=site/login">
                                                                    <i class="ace-icon fa fa-power-off"></i>
                                                                    登录系统
                                                            </a>
                                                    </li>
                                                {else}
                                                    <li>
                                                            <a href="backend.php?r=AdminUser/UpdatePassword">
                                                                    <i class="ace-icon fa fa-user"></i>
                                                                    修改密码
                                                            </a>
                                                    </li>
                                                    <li>
                                                            <a href="backend.php?r=site/logout">
                                                                    <i class="ace-icon fa fa-power-off"></i>
                                                                    退出登录
                                                            </a>
                                                    </li>
                                                {/if}
                                        </ul>
                                </li>

                                <!-- /section:basics/navbar.user_menu -->
                        </ul>
                </div>

                <!-- /section:basics/navbar.dropdown -->
        </div><!-- /.navbar-container -->
</div>