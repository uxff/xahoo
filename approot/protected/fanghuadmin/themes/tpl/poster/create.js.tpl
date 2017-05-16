<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>

<!--date time picker-->
<link rel="stylesheet" href="{$resourcePath}/js/bootstrap-datetimepicker/css/datetimepicker.css" />
<script src="{$resourcePath}/js/bootstrap-datetimepicker/js/datetimepicker.min.js"></script>
<script type="text/javascript" src="{$resourcePath}/js/webuploader.js"></script>
<script type="text/javascript" src="{$resourcePath}/js/webuploader_config.js"></script>
<script type="text/javascript" src="{$resourcePath}/js/selectCheck/MultiSelectDropList.js"></script>
<script type="text/javascript" src="{$resourcePath}/js/selectCheck/city.js"></script>
<link rel="stylesheet" type="text/css" href="{$resourcePath}/css/webuploader_fanghuadmin.css"/>
<link href="{$resourcePath}/js/selectCheck/multi.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/javascript">
    $(function (){
		$('.multi_select').MSDL({
		    'width': '160',
		    'data': city,
		    'callback':function(){
		    	
		    }
		});
	});
    new uploadFile({
		'list':$('#board1_fileList'),//列表对象
		'pick':$("#board1_filePicker"),//选择图片对象
		'btn':$('#board1_ctlBtn'),//上传文件input对象
		'imgurl':$('#board1_pic'),//返回的url
		'fileSingleSizeLimit':1024*1024,   //设定单个文件大小
		'formData':{
			source:'project',
			picSizeArr: 640*906,
			returnFirstUrl:'1'
		}
	});
    if($('#board1_pic').val()){ $('#board1_fileList').show();}

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
		var beginTime = $('#time_start').val();
		var endTime = $('#time_end').val();
		var beginTimes = beginTime.substring(0, 10).split('-');
		var endTimes = endTime.substring(0, 10).split('-');
		
		if (endTime != "" && beginTime != ""){
			beginTime = new Date(beginTimes[1] + '/' + beginTimes[2] + '/' + beginTimes[0] + ' ' + beginTime.substring(10, 17)) + ':00';
			endTime = new Date(endTimes[1] + '/' + endTimes[2] + '/' + endTimes[0] + ' ' + endTime.substring(10, 17)) + ':00';
			var a = (Date.parse(endTime) - Date.parse(beginTime)) / 3600 / 1000;
			if (beginTimes && endTimes && a < 0) {
				alert('结束时间不能小于开始时间，请重新选择');
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
    
    function check_form_two(){
        var strP=/^\d+(\.\d+)?$/;
        var project_bonus_ceiling = $("#project_bonus_ceiling").val();
        var poster_accounts = $("#poster_accounts_id").val();
        var poster_project = $("#poster_project").val();
        var direct_fans_rewards = $("#direct_fans_rewards").val();
        var indirect_fans_rewards = $("#indirect_fans_rewards").val();
        var lowest_withdraw_sum = $("#lowest_withdraw_sum").val();
        var highest_withdraw_sum = $("#highest_withdraw_sum").val();
        var subscribe_rewards = $("#subscribe_rewards").val();
        var valid_area = $("#valid_area").val();
        var poster_rules = $("#poster_rules").val();
        var board1_pic = $("#board1_pic").val();
        if(poster_accounts == 0){
            alert('请选择公众号');
            return false;
        }
        if(poster_project == 0){
            alert('请选择项目');
            return false;
        }
        if(subscribe_rewards.length == 0 || !/^\d+(\.\d+)?$/.test(subscribe_rewards)){
            alert('请填写首次关注奖励金额');
            return false;            
        }
        if(project_bonus_ceiling.length == 0 || !/^\d+(\.\d+)?$/.test(direct_fans_rewards)){
            alert('请填写项目奖金上限');
            return false;            
        }
        if(direct_fans_rewards.length == 0 || !/^\d+(\.\d+)?$/.test(direct_fans_rewards)){
            alert('请填写直接粉丝奖励');
            return false;            
        }
        if(indirect_fans_rewards.length == 0 || !/^\d+(\.\d+)?$/.test(indirect_fans_rewards)){
            alert('请填写间接粉丝奖励');
            return false;            
        }
        if(lowest_withdraw_sum.length == 0 || !/^\d+(\.\d+)?$/.test(lowest_withdraw_sum)){
            alert('请填写最低提现金额');
            return false;            
        }
        if(highest_withdraw_sum.length == 0 || !/^\d+(\.\d+)?$/.test(highest_withdraw_sum)){
            alert('请填写最高提现金额');
            return false;            
        }
        if(valid_area.length == 0){
            alert('请选择海报有效区域');
            return false;            
        }
        if(poster_rules.length == 0){
            alert('请填写活动规则');
            return false;            
        }
        if(board1_pic == ''){
            alert('请上传封面图');
            return false;            
        } 
    }
				

</script>
{/literal}