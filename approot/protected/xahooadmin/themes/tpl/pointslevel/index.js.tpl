<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>

{literal}
<!-- inline scripts related to this page -->
<script type="text/javascript">
    function delConfirm(callbackUrl) {
        bootbox.confirm("确认删除吗?", function(result) {
            if(result) {
                window.location.href=callbackUrl;
            }
        });
    }
</script>
{/literal}