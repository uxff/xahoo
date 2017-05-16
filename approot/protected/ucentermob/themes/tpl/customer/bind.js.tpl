<script>
{literal}
function send_verifycode(){

   var code = $('#code').val().trim();
   
   if(code.match(/[0-9]{4,6}/)==null){
      alert('验证码需是4到6位数字');
      return false ;
   }
 {/literal}  
 
   var rid = $('#requestid').val();
   var plat_id = $('#plat_id').val().trim();
   
   $.ajax({
        type: 'GET',
        url: gYiiCreateUrl('ajax', 'confirmBind'),
        data: { requestid:rid,validatecode:code,plat_id:plat_id },
        dataType: 'json',
        success: function(data) {
        
           if(data.error_code != undefined){
            	alert(data.error_msg);
            	
            	if(data.error_code == '600326'){
            	   window.location.href ='{yii_createurl c=house a=confirm order_id =$where.order_id}';
            	}
            	
           }else{
              alert('绑卡成功');
              window.location.href ='{yii_createurl c=checkout a=confirm order_id =$where.order_id}';
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

function send_bind_sms(){

   var plat_id = $('#plat_id').val().trim();
   
   var url = 'plat_id'+plat_id;
   
   $.ajax({
        type: 'GET',
        url: gYiiCreateUrl('ajax', 'askBind',url),
        dataType: 'json',
        success: function(data) {
        
           if(data.error_code != undefined){
            	alert(data.error_msg);
           }else{
              alert('绑卡成功');
              window.location.href ='{yii_createurl c=checkout a=confirm order_id =$where.order_id}';
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

function send_bind(){
time($('#send'));
var plat_id = $('#plat_id').val().trim();
$.ajax({
        type: 'GET',
        url: gYiiCreateUrl('ajax', 'SendBind')+'&plat_id='+plat_id,
        dataType: 'json',
        success: function(data) {
        
           if(data.error_code != undefined){
            	alert(data.error_msg);
           }else{
              alert('已发送，请注意查看');
              $('#requestid').val(data.requestid);
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
{if $lasttime != 0}
var wait= {$lasttime} ;  
time($('#send'));
{else}
var wait= 50 ; 
 $('#send').attr('onclick',"send_bind()"); 
{/if}


function time(o) {  
        if (wait == 0) {  
            $(o).text("获取验证码");        
            o.inner="获取验证码";  
            wait = {$waittime}; 
            $('#send').attr('onclick',"send_bind()"); 
        } else {  
            $(o).text("重新发送(" + wait + ")"); 
            wait--;  
            setTimeout(function() {  
                time(o)  
            },  
            1000);
            $('#send').removeAttr('click'); 
        }  
}  
</script>