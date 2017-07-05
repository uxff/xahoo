<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    {include file="../common/html_head_index.tpl"}
    <body>
        <!-- #section:basics/content.page_header -->
        {include file="../common/header_v2.tpl"}
        <!-- /section:basics/content.page_header -->
                <!-- page specific plugin scripts -->
                <!--
                <script type="text/javascript">
                    var _baseUrl = "{yii_createurl c='"+controllerId+"' a='"+actionId+"'}";
                </script>
                {literal}
                <script type="text/javascript">
                        function gYiiCreateUrl(controllerId, actionId, paramsStr) {
                                
                                if (_baseUrl.indexOf("?") != -1) {
                                        returnUrl = (paramsStr == "" || paramsStr == undefined) ? _baseUrl : _baseUrl + "&" + paramsStr;
                                } else {
                                        returnUrl = (paramsStr == "" || paramsStr == undefined) ? _baseUrl : _baseUrl + "?" + paramsStr;
                                }
                                return returnUrl;
                        }
                </script>
                {/literal}
                -->
        <!-- #section:basics/content.page_content_area -->
        {include file="$NACHO_PAGE_TPL_FILE"}
        <!-- /section:basics/content.page_content_area -->

        <!-- #section:basics/content.page_footer 底部不一样，暂时先不统一成一个文件-->
        {include file="../common/footer_v2.tpl"}
        <!-- /section:basics/content.page_footer -->


        {if !empty($NACHO_JS_TPL_FILE)}
            <!--NACHO_JS_TPL_FILE here not need to show -->
            {include file="$NACHO_JS_TPL_FILE"}
        {/if}

        <!-- #section:basics/footer.tracking_js -->
        {include file="../common/footer_tracking.tpl"}
        <!-- #section:basics/footer.tracking_js -->
    </body>
</html>