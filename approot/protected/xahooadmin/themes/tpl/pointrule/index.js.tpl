<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>

{literal}
<!-- inline scripts related to this page -->
<script type="text/javascript">
    function delConfirm(delaction) {

        bootbox.confirm("确认删除吗?", function(result) {
            if(result) {
                var url = window.location.href;
                $.ajax({
                    url     :    delaction,
                    type    :    'post',
                    data    :    {'url':url},
                    success :    function (data) {
                        window.location.href = data;
                    }
                });
            }
        });
    }
</script>
{/literal}