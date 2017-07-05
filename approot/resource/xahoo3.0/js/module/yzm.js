define(function(require,exports,module){
	
	require('../lib/jquery/jquery-1.10.1.min.js');
	
	function Yzm(container){
		this.container = $(container);
	}
	
	module.exports = Yzm;
	
	Yzm.prototype.render = function(){
		if(this._yzphone()){return true;}
	}
	
	Yzm.prototype._fsYzm = function(){
		
		if(this.container.value == '获取验证码'){
			wait=60;
		}
		time(this.container);
	}
	
	Yzm.prototype._yzphone=function(){
		
		var val = $('#username').val();
		if(val == "" || val == $("#username").attr('placeholder')){
		   layer.msg('请输入您的手机号码');
		   return false;
		}
		if(val!="" && !/^(13[0-9]|14[57]|15[012356789]|17[0678]|18[0-9])\d{8}$/.test(val)){
			layer.msg('请输入正确的手机号码');
			return false;
		}
		return true;
	}
	//验证码倒计时
		var wait=60;
		function time(o) {
	        if (wait == 0) { 
	        	o.css({
	        		'font-size':'.75rem',
	        		'background-color':'#fff',
        		    'border': '.0833rem solid #f89ca3',
        		    'color':'#f89ca3'
	        	}).removeAttr('disabled').val('获取验证码');
	        	wait = 60;  
	        }else{
	        	o.css({
	        		'font-size':'.75rem',
	        		'background-color':'#939393',
	        		'border-color':'#f89ca3',
	        		'font-size':'.666rem',
	        		'color':'#fff'
	        	}).attr('disabled',true).val(wait + "秒后重新获取");
	            wait--;  
	            setTimeout(function() {  
	                time(o)  
	            },  
	            1000)  
	        }  
	    }  
})
