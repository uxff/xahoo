/************************************************
 * @authors:Hu gang
 * @description:
 * @date:2016-07-13
 * @version:
************************************************/

define(function(require){
	//JQuery模块
	require('../lib/jquery/jquery-1.10.1.min.js');
	//layer模块
	var css = require('../lib/layer/skin/layer.css','css|url');
	var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
	$($('head')[0]).find('title').after(linkTag);
	require('../lib/layer/layer.js');
	$(function(){
		var cash = {
			init:function(){
				var _this = this;
				this.push();
				this.allcash();
				$('.lot-btn').on('click',function(){
					inputVal = $('.cash-input').val()
					$(this).prop('disabled',1);
                    var withdraw_min = parseFloat($("#withdraw_min").val());
					if(inputVal == '' || inputVal < withdraw_min){
						_this.message('最低提现额'+withdraw_min+'元');
						$(this).prop('disabled',0);
					}else{
						_this.getcash();
					}
				})
			},
			getcash:function(){
				var _this = this;
	            var cash = $("#cash").val();
	            var project_id = $("#project_id").val();
                var token = $('#token').val();
	            layer.load(1);
	            $.ajax({
	                type: 'post',
	                url: 'index.php?r=WithdrawCash/GetCash&cash='+cash+'&project_id='+project_id+'&token='+token,
	                dataType: 'json',
	                success: function(data){
	                	layer.close(1);
	                	$(this).prop('disabled',0);
	                    if(data.code == 0){
	                        _this.message(data.msg);
	                        setTimeout(function(){window.location.href = "index.php?r=MyHaibao/MyReward"},3000);
                            if (data.value.token != undefined) {
                                $('#token').val(data.value.token);
                            }
	                    }else{
	                    	_this.message(data.msg);
                            if (data.value.token != undefined) {
                                $('#token').val(data.value.token);
                            }
	                    }
	                }
	            })
			},
			push:function(){
				$('.cash-input').on('input',function(){
					var allcash = $("#allcash").val();
					var	cash = $(this).val();
					if( (cash - allcash) >0 ){
						$(this).val(allcash);
					}
				})
			},
			message:function(txt){
				$('.cash-pop').text(txt);
				var DivWidth = $('.cash-pop').width();
				$('.cash-pop').css("margin-left","-"+DivWidth/2+"px").show();

				setTimeout(function(){$('.cash-pop').hide();},2000);
			},
			allcash:function(){
				var _this = this;
				$(".all_cash").on('click',function(){
					var allcash = $("#allcash").val();
		            if(allcash){
		                $("#cash").val(allcash);
		            }else{
		            	_this.message();
		            }
				})
			}
		}
		cash.init();
	})
})