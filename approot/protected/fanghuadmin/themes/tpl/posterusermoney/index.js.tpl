<script src="{$resourcePath}/js/jquery-ui.custom.min.js"></script>
<script src="{$resourcePath}/js/jquery.ui.touch-punch.min.js"></script>
<script src="{$resourcePath}/js/bootbox.min.js"></script>
<script src="{$resourceBasePath}/laydate/laydate.js"></script>
<script src="{$resourceBasePath}/layer2/layer/layer.js"></script>
<script>
    var shNum = {$shNum};
    var dkNum = {$dkNum};
</script>
{literal}
<script type="text/javascript">
    function shenhe_confim(id,pid){

             layer.open({
                   title : '温馨提示',
                   content: '<p>请确认所选则的用户，提现金额是否都正确，审核通过后，请以红包发给用户</p>',
                   btn: ['审核通过', '审核不通过'],
                   yes: function(index, layero){
                        var url = 'backend.php?r=PosterUserMoney/EditStatus&id='+id+'&status='+3+'&pid='+pid+'&token='+$('#token').val();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                success: function(data){
                                    if(data.code == 1){
                                        layer.open({
                                           title : '温馨提示',
                                           content: data.msg || '审核通过操作成功',
                                           btn: ['确认'],
                                           yes: function(){
                                                location.reload();
                                           }
                                     });
                                       
                                    }else{
                                      layer.msg(data.msg)
                                    }
                                }
                                
                            })
                   },cancel: function(index){
                         var url = 'backend.php?r=PosterUserMoney/EditStatus&id='+id+'&status='+2+'&pid='+pid+'&token='+$('#token').val();
                             $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                success: function(data){
                                    if(data.code == 1){
                                        layer.open({
                                           title : '温馨提示',
                                           content: data.msg || '审核不通过操作成功',
                                           btn: ['确认'],
                                           yes: function(){
                                                location.reload();
                                           }
                                     });
                                    }else{
                                      layer.msg(data.msg)
                                    }
                                }
                                
                            })
                    }
             });
}


    function pay_confim(id,pid,money,member_id){
            
              
             layer.open({
                   title : '温馨提示',
                   content: '<p>请确认线下已完成红包付款，您确认将这些用户的提现状态设置为“已打款”吗？</p>',
                   btn: ['确认', '取消'],
                   yes: function(index, layero){
                        var url = 'backend.php?r=PosterUserMoney/EditStatus&id='+id+'&status='+4+'&pid='+pid+'&money=' +money+ '&member_id=' + member_id+'&token='+$('#token').val();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                success: function(data){
                                    if(data.code == 1){
                                        layer.open({
                                           title : '温馨提示',
                                           content: data.msg || '打款操作成功',
                                           btn: ['确认'],
                                           yes: function(){
                                                location.reload();
                                           }
                                     });
                                       
                                    }else{
                                      layer.msg(data.msg)
                                    }
                                }
                                
                            })
                   }
             });
}

</script>

<script type="text/javascript">

  /*****************************
 * description 海报-批量操作
 * @author : sichaoyun
 * @date 2016-08-10  
 *******************************
 */

  var poster = {
     //初始化
     init : function(){
      this.check_all();
      this.check_once();
      this.batchreview();
      this.bulkpayments();
     },
     //批量审核
     batchreview  : function(){
        $('.batchreview').on('click',function(){
            var _this = $(this);
            if(_this.hasClass('btndisable')){
                return;
            }else{
                var id_arr = [],
                    pid_arr = [],
                    money_arr = [],
                    member_id_arr = [];
                var len = $('.table-hover .checklist:checked').size();
                $('.table-hover .checklist:checked').each(function(idx,item){
                     var _this = $(item);
                     var tr = _this.parents('tr');
                     var id = tr.attr('id');
                     var pid = tr.attr('pid');
                     var money = tr.attr('money');
                     var member_id = tr.attr('member_id');
                         id_arr.push(id);
                         pid_arr.push(pid);
                         money_arr.push(money);
                         member_id_arr.push(member_id);
                  });
                layer.open({
                   title : '提现审核',
                   content: '<p>请确认所选则的用户，提现金额是否都正确，审核通过后，请以红包发给用户</p><p>本次处理：'+ len +'人</p><p>待审核：'+ (shNum*1 - len*1) +'人</p>',
                   btn: ['审核通过', '关闭','不通过'],
                   yes: function(){
                         layer.msg('不要关闭窗口和刷新页面,请耐心等待', {icon: 16});
                         var url = '/backend.php?r=PosterUserMoney/MoreEditStatus';
                         poster.get_data(id_arr,3,pid_arr,money_arr,member_id_arr,url,'审核通过操作');
                   },cancel: function(){
                       
                },
                btn3 :  function(){
                         var url = '/backend.php?r=PosterUserMoney/MoreEditStatus';
                         poster.get_data(id_arr,2,pid_arr,money_arr,member_id_arr,url,'审核不通过操作');
                }
             });
            }
        })
     }, 
      //批量付款
     bulkpayments   : function(){
        $('.bulkpayments').on('click',function(){
            var _this = $(this);
            if(_this.hasClass('btndisable')){
                return;
            }else{
                var id_arr = [],
                    pid_arr = [],
                    money_arr = [],
                    member_id_arr = [];
                    var len = $('.table-hover .checklist:checked').size();
                $('.table-hover .checklist:checked').each(function(idx,item){
                     var _this = $(item);
                     var tr = _this.parents('tr');
                     var id = tr.attr('id');
                     var pid = tr.attr('pid');
                     var money = tr.attr('money');
                     var member_id = tr.attr('member_id');
                         id_arr.push(id);
                         pid_arr.push(pid);
                         money_arr.push(money);
                         member_id_arr.push(member_id);
                  });
                layer.open({
                   title : '付款',
                   content: '<p>请确认线下已完成红包付款，您确认将这些用户的提现状态设置为“已打款”吗？</p><p>本次处理：'+ len +'人</p><p>待打款：'+ (dkNum*1-len*1) +'人</p>',
                   btn: ['确认', '取消'],
                   yes: function(index, layero){
                         layer.msg('不要关闭窗口和刷新页面,请耐心等待', {icon: 16});
                         var url = '/backend.php?r=PosterUserMoney/MoreEditStatus';
                         poster.get_data(id_arr,4,pid_arr,money_arr,member_id_arr,url,'付款');
                   }
             });
            }
        })
     },
     get_data : function(id_arr,status,pid_arr,money_arr,member_id_arr,url,text){
         var data = {
             id : id_arr.join(','),
             status : status,
             pid : pid_arr.join(','),
             money : money_arr.join(','),
             member_id : member_id_arr.join(','),
             token : $('#token').val()
         }
         $.ajax({
            type: 'POST',
            url: url,
            data : data,
            dataType: 'json',
            success: function(data){
                //var tips = data == 1 ? '成功' : '失败'
                var tips = data.msg;
                //layer.alert(text + tips);
                layer.open({
                   title : '温馨提示',
                   content: text + tips,
                   btn: ['确认'],
                   yes: function(){
                        location.reload();
                   }
             });
            }
        })
     },
     //全选
     check_all : function(){
         $('#idTable .check_all').prop('checked',0);
         
         $('.check_all').on('click',function(){
            var _this = $(this),f = _this.prop('checked') ? 1 : 0;
            var arr = [],arr_pay = [];
            arr.length = 0;
            arr_pay.length = 0; 
            $('.table-hover').find('.checklist').each(function(){
                   var _self = $(this);
                   var status = _self.parents('tr').attr('status');
                   if(status !=1){
                      arr.push(1);
                   }
                   if(status !=3){
                      arr_pay.push(1);
                   }
                   _self.prop('checked',f);
            });
            if(f && arr.length == 0){
                $('.batchreview').removeClass('btndisable');
            }else{
                $('.batchreview').addClass('btndisable');
            }
            if(f && arr_pay.length == 0){
                $('.bulkpayments').removeClass('btndisable');
            }else{
                $('.bulkpayments').addClass('btndisable');
            }            
         })
     },
     // 单选
     check_once : function(){
         $('#idTable tbody').on('click',':checkbox',function(){
                var arr = [];
                $('.table-hover .checklist:checked').each(function(idx,item){
                     var _this = $(item);
                     var status = _this.parents('tr').attr('status');
                     arr.push(status);
                });
               
                poster.unique(arr);
                if(arr.length == 1 && arr[0] == 1){
                  $('.batchreview').removeClass('btndisable');
                }else{
                  $('.batchreview').addClass('btndisable');
                }
                if(arr.length == 1 && arr[0] == 3){
                  $('.bulkpayments').removeClass('btndisable');
                }else{
                  $('.bulkpayments').addClass('btndisable');
                }
           //全选状态打钩
          
          var len =  $('#idTable .checklist').length;
          var len_checked = $('#idTable .checklist:checked').length;
              if(len == len_checked){
                $('.check_all').prop('checked',1);
              }else{
                $('.check_all').prop('checked',0);
              }

         });
     },
     // 去重
     unique : function(arr){
         var obj = {},len = arr.length,i=0;
            for(;i < len;i++){
               if(typeof obj[arr[i]] == "undefined"){
                obj[arr[i]] = 1;
               }
             }
            arr.length = 0;
            for(var p in obj){
                arr[arr.length]=p;
            }
        
           return arr;
       }
    }

  poster.init();
</script>
{/literal}

