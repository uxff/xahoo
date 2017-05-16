{include file="../common/html_header.tpl"}
<!-- basic scripts -->
<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='{$resourcePath}/js/jquery.min.js'>" + "<" + "/script>");
</script>
<script type="text/javascript">
    var zhff = {
    "uploadImageUri" : "/fanghuadmin.php?r=upload/post",
    "uploadFileUri" : "/ucenterpc.php?r=account/postFile",
    }
</script>
<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
        window.jQuery || document.write("<script src='{$resourcePath}/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<body class="no-skin">
    <!-- #section:basics/navbar.layout -->
    {include file="../common/header_nav.tpl"}
    <!-- /section:basics/navbar.layout -->
    <div class="main-container" id="main-container">
        {literal} 
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>
        {/literal}

        <!-- #section:basics/sidebar -->
        {include file="../common/sidebar_menu.tpl"}
        <!-- /section:basics/sidebar -->

        <div class="main-content">
            <!-- #section:basics/content.breadcrumbs -->
            {include file="../common/breadcrumbs.tpl"}
            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">
                <!-- #section:settings.box -->
                <!-- /section:settings.box -->
                <!-- #section:basics/content.page_content_area -->
                {include file="$NACHO_PAGE_TPL_FILE"}
                <!-- /section:basics/content.page_content_area -->
            </div>
        </div>

        <div class="footer">
            <!-- #section:basics/footer -->
            {include file="../common/footer.tpl"}
            <!-- /section:basics/footer -->
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>

    </div>

    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) {
            document.write("<script src='{$resourcePath}/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        }
    </script>
    <script src="{$resourcePath}/js/bootstrap.min.js"></script>

    <!-- ace scripts -->
    <script src="{$resourcePath}/js/ace-elements.min.js"></script>
    <script src="{$resourcePath}/js/ace.min.js"></script>

    <!-- page specific plugin scripts -->
    {if !empty($NACHO_JS_TPL_FILE)}
    {include file="$NACHO_JS_TPL_FILE"}
    {/if}
</body>
</html>
