<script>

{literal}
function submit_renzheng(step){


  
    if(step == 1){
  
        var pwd = $('#pwd').val().trim();
        var pwd1 = $('#pwd1').val().trim();
        
        if(pwd==""||pwd1==""){
           alert('密码和确认密码两者均不能为空');
           return false ;
        }
        var passRule = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,18}$/;
        if(!passRule.test(pwd)){
           alert('请检使用符合要求的密码');
           return false ;
        }

        if(pwd != pwd1){
           alert('两次密码设置不一致');
           return false ;
        }
        
        
  }
  
  if(step == 2){
  
  
      var customerName = $('#real_name').val().trim();
        var customerID = $('#id_no').val().trim();
        
        if(customerName=="" ){
           alert('真实姓名不能为空');
           return false ;
        }
      if( customerName.length > 7 ){
           alert('姓名过长');
           return false ;
        }
        var IDRule = validateIdCard(customerID)
        if(customerID==""|| !IDRule[0]){
           alert('请保证填写了有效的身份证号');
           return false ;
        }
        
  
        var account = $('#platform_account').val().trim();
        var mobile = $('#member_mobile').val().trim();
        
        var cardNoCheckResult = luhmCheck(account);
        
        
        if(!cardNoCheckResult[0]){
        
           alert('请检查银行卡的正确性');
           return false ;
        }
        
        if(mobile.match(/1[0-9_]{10}/ig)==null){
           alert('手机号不正确');
           return false ;
        }
        
  }

  if(step ==1 ){
  	$('#myform').submit();
  }else{
  
    var formdata = $('#myform').serializeArray();
{/literal} 
  	$.ajax({
        type: 'POST',
        url: gYiiCreateUrl('ajax', 'Bind'),
        data: formdata,
        dataType: 'json',
        success: function(data){

           if(data.error_code!=undefined ){
            	alert(data.error_msg);
            	if(data.error_code == '600326'){
            	  window.location.href ='{yii_createurl c=checkout a=confirm order_id =$where.order_id}';
            	}
           }else{
              if(data.requestid!=undefined&&data.requestid!=""){
              	var params = 'requestid='+data.requestid+'&order_id={$where.order_id}'+'&plat_id='+data.plat_id;
                 window.location.href = gYiiCreateUrl('customer', 'Bind', params);
              }
           }
  
        },
        error: function() {
            alert('加载错误!');
        },
        complete: function() {
            removeMask();   //数据加载完成后删除遮罩层
            $('#more').html('点击加载更多');
        }
    })
  
  }
  
}
{if $error!=""}
alert('{$error}');
{/if}
</script>