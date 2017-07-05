<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>

<!--date time picker-->
<link rel="stylesheet" href="{$resourcePath}/js/bootstrap-datetimepicker/css/datetimepicker.css" />
<script src="{$resourcePath}/js/bootstrap-datetimepicker/js/datetimepicker.min.js"></script>
<script type="text/javascript" src="{$resourcePath}/js/webuploader.js"></script>
<script type="text/javascript" src="{$resourcePath}/js/webuploader_config.js"></script>

<link rel="stylesheet" type="text/css" href="{$resourcePath}/css/webuploader_fanghuadmin.css">


{literal}
<script type="text/javascript">
    function check_form_two(){
        var appid = $("#appid").val();
        var token = $("#token").val();
        var appsecret = $("#appsecret").val();
        var accounts_name = $("#accounts_name").val();
        var EncodingAESKey = $("#EncodingAESKey").val();
        if(accounts_name == ''){
            alert('请输入公众号名称');
            return false;
        }
        if(token == ''){
            alert('请输入公众号token');
            return false;
        }
        if(appid == ''){
            alert('输入公众号的AppID');
            return false;
        }
        if(appsecret == ''){
            alert('输入公众号的AppSecret');
            return false;
        }
        //if(EncodingAESKey == ''){
        //    alert('请输入公众号的EncodingAESKey');
        //    return false;
        //}
    }
</script>
{/literal}