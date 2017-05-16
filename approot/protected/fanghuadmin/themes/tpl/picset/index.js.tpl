
<!--
<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>
-->
<link rel="stylesheet" href="{$resourcePath}/js/bootstrap-datetimepicker/css/datetimepicker.css" />
<script src="{$resourcePath}/js/bootstrap-datetimepicker/js/datetimepicker.min.js"></script>



<!--
{literal}
<!-- inline scripts related to this page -->
<script type="text/javascript">

	/*


    function delConfirm(callbackUrl) {
        bootbox.confirm("确认删除吗?", function(result) {
            if(result) {
                window.location.href=callbackUrl;
            }
        });
    }

    */
</script>

<!--
{/literal}
-->


{literal}
<script type="text/javascript">

    jQuery(function ($) {
        $('.year-picker').datetimepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
			minView:2,
        })
		
            //show datepicker when clicking on the icon
                .next().on(ace.click_event, function () {
                    $(this).prev().focus();
                });
    });

	$('.lablediv1 input').on('change',function(){
		var beginTime = $('#create_time_start').val();
		var endTime = $('#create_time_end').val();
		var beginTimes = beginTime.substring(0, 10).split('-');
		var endTimes = endTime.substring(0, 10).split('-');
		
		if (endTime != "" && beginTime != ""){
			beginTime = new Date(beginTimes[1] + '/' + beginTimes[2] + '/' + beginTimes[0] + ' ' + beginTime.substring(10, 17)) + ':00';
			endTime = new Date(endTimes[1] + '/' + endTimes[2] + '/' + endTimes[0] + ' ' + endTime.substring(10, 17)) + ':00';
			var a = (Date.parse(endTime) - Date.parse(beginTime)) / 3600 / 1000;
			if (beginTimes && endTimes && a < 0) {
				alert(endTimes[0]+'结束时间不能小于开始时间，请重新选择');
				$(".btn-info").prop('disabled',true);
				return false;
			}else{
				$(".btn-info").prop('disabled',false);
			}
		}
		return true;
	})
	$('.lablediv1 input').on('keyup',function(){
		if($(this).val() == ''){
			if($(".btn-info").prop('disabled') == true){
				$(".btn-info").prop('disabled',false);
			}
		}
	})

</script>
{/literal}
