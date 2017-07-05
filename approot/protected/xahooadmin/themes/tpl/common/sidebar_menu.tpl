<div id="sidebar" class="sidebar responsive">
        {literal}
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'fixed')
                } catch (e) {
                }
            </script>
        {/literal} 

        <ul class="nav nav-list">
                <!--
                <li class="">
                        <a href="#">
                                <i class="menu-icon fa fa-tachometer"></i>
                                <span class="menu-text"> 管理菜单 </span>
                        </a>

                        <b class="arrow"></b>
                </li>
                -->
                {foreach from=$menus item=item key=key}
                    <li class="{$item.active}">
                            <a href="{$item.url}" {if !empty($item.submenu)}class="dropdown-toggle"{/if}>
                                    <i class="menu-icon fa {$item.menu_icon}"></i>
                                    <span class="menu-text"> {$item.name} </span>

                                    {if !empty($item.submenu)}<b class="arrow fa fa-angle-down"></b>{/if}
                            </a>

                            <b class="arrow"></b>
                            {if !empty($item.submenu)}
                                <ul class="submenu">
                                        {foreach from=$item.submenu item=submenu}
                                            <li class="{$submenu.active}">
                                                    <a href="{$submenu.url}">
                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                            {$submenu.name}
                                                    </a>

                                                    <b class="arrow"></b>
                                            </li>
                                        {/foreach}

                                </ul>
                            {/if}
                    </li>
                    <!--
                    <li class="">
                            <a href="widgets.html">
                                    <i class="menu-icon fa fa-list-alt"></i>
                                    <span class="menu-text"> Widgets </span>
                            </a>

                            <b class="arrow"></b>
                    </li>
                    -->
                {/foreach}
        </ul><!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
        {literal}
            <script type="text/javascript">
                try {
                    ace.settings.check('sidebar', 'collapsed')
                } catch (e) {
                }
            </script>
        {/literal} 
</div>