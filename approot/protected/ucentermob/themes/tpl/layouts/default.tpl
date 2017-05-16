<!DOCTYPE html>
<html>
        {include file="../common/html_header.tpl"}
        <body>
                <!-- #section:basics/content.page_header -->
                {include file="../common/header_nav.tpl"}
                <!-- /section:basics/content.page_header -->

                <!-- #section:basics/content.page_content_area -->
                {include file="$NACHO_PAGE_TPL_FILE"}
                <!-- /section:basics/content.page_content_area -->

                <!-- #section:basics/content.page_footer -->
                {include file="../common/footer.tpl"}
                <!-- /section:basics/content.page_footer -->

                <!-- basic scripts -->
                <script src="{$resourceThirdVendorPath}/zepto1.0/zepto.js"></script>
                <script src="{$resourceThirdVendorPath}/zepto1.0/touch.js"></script>
                <script src="{$resourcePath}/js/base.js"></script>
                <!-- page specific plugin scripts -->
                <script type="text/javascript">
                    // namespace
                    var zhff = {
                        "httpServer": "{$httpServer}",
                        "httpsServer": "{$httpsServer}",
                        "currCtrlId": "{$gCurrCtrId}",
                        "isGuest": "{$gIsGuest}",
                    }
                    function toggleKey() {
                        if (document.getElementById('navcl').style.display == 'block') {
                            document.getElementById('navcl').style.display = 'none';
                        } else {
                            document.getElementById('navcl').style.display = 'block';
                        }
                    }
                    function gYiiCreateUrl(controllerId, actionId, paramsStr) {
                        var url = "{yii_createurl c='"+controllerId+"' a='"+actionId+"'}";
                        if (url.indexOf("?") != -1) {
                            returnUrl = (paramsStr == "" || paramsStr == undefined) ? url : url + "&" + paramsStr;
                        } else {
                            returnUrl = (paramsStr == "" || paramsStr == undefined) ? url : url + "?" + paramsStr;
                        }
                        return returnUrl;
                    }
                    $(function(){
                        var headerHeight = $(".header").height();
                        var footerHeight = $(".h-foot").height();
                        if($('.main-section').length>0){
                            $('.main-section').css('min-height',($(window).height()-headerHeight-footerHeight)+"px");
                        }
                    });
                </script>
                <script language="javascript">
                    $(function () {
                        var headerHeight = $(".header").height();
                        var footerHeight = $(".h-foot").height();
                        var errorHeight = 0;
                        if($(".msg-container").length>0){
                            errorHeight = $(".msg-container").height();
                        }
                        if ($('.main-section').length > 0) {
                            $('.main-section').css('min-height', ($(window).height() - headerHeight - footerHeight-errorHeight) + "px");
                        }
                    });
                </script>


                {if !empty($NACHO_JS_TPL_FILE)}
                    {include file="$NACHO_JS_TPL_FILE"}
                {/if}

                <!-- #section:basics/footer.tracking_js -->
                {include file="../common/footer_tracking.tpl"}
                <!-- #section:basics/footer.tracking_js -->
        </body>
</html>