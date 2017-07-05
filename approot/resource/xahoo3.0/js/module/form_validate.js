define(function(require,exports,module){
	
	require('../lib/jquery/jquery-1.10.1.min.js');
	
	var css = require('../lib/layer/skin/layer.css','css|url');
	var linkTag = $('<link href="' + css + '" rel="stylesheet" type="text/css" />');
	$($('head')[0]).find('title').after(linkTag);
	require('../lib/layer/layer.js');
	
	function Validate(container){
		this.container = $(container);
		this.inputs = this.container.find('.form-input');
	}
	
	module.exports = Validate;
	
	Validate.prototype.render = function(){
		
		var validate = this,
			flag = true;
		
		$(this.inputs).each(function(){
			var node = $(this);
			//手机号
			if(node.is('#phone,#brokerphone') &&!validate._phone(node) ){flag = false;return false;}
			//登录密码
			if(node.is('#password') && !validate._password(node,'请输入您的登陆密码')){flag = false;return false;}
			//验证码
			if(node.is('#reg_yzm','#vericode') && !validate._veri(node)){flag = false;return false;}
			//注册密码
			if(node.is('#reg_password') && !validate._regPassword(node,'请输入您的密码')){flag = false;return false;}
			//确认密码
			if(node.is('#pwd_repeat') && !validate._pwdRepeat(node,$('[name="reg[pwd]"]'))){flag = false;return false;}
			//姓名
			if(node.is('#user_name') && !validate._userName(node)){flag = false;return false;}
			//身份证
			if(node.is('#card_number') && !validate._ic(node)){flag = false;return false;}
		})
		return flag;
	}
	
	//验证手机号
	Validate.prototype._phone = function(o){
		var item = o;
		if(item.val() == "" || item.val() == item.attr('placeholder')){
		   layer.msg('请输入您的手机号码');
		   return false;
		}
		if(item.val()!="" && !/^(13[0-9]|14[57]|15[012356789]|17[03678]|18[0-9])\d{8}$/.test(item.val().trim())){
			layer.msg('请输入正确的手机号码');
			return false;
		}
		return true;
	}
	
	//验证密码
	Validate.prototype._password = function(o,b){
		var item = o;
		if(item.val() == "" || item.val() == item.attr('placeholder')){
		   layer.msg(b);
		   return false;
		}
		return true;
	}
	//验证注册密码
	Validate.prototype._regPassword = function(o,b){
		var item = o;
		
		if(item.val() == "" || item.val() == item.attr('placeholder')){
		   layer.msg(b);
		   return false;
		}
		if(item.val()!="" && !/^[\w\.\_]{6,8}$/.test(item.val().trim())) {
			layer.msg('密码必须为6-8位字符');
			return false;
		}
		return true;
	}
	//验证两次密码输入一致
	Validate.prototype._pwdRepeat = function(o,b){
		var item = o;
			if (item.val().trim() == "" || item.val() == item.attr('placeholder')){
				layer.msg('请填写确认密码');
				return false;
			} 
			if (item.val().trim() != b.val().trim()){
				layer.msg('两次密码输入不一致');
				return false;
			} 
		return true;
	}
	
	//验证姓名
	Validate.prototype._userName = function(o){
		var item = o;
		if(item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请填写真实姓名');
			return false;
		}
		if(item.val() != "" && !/^[\u4e00-\u9fa5]{2,20}$/.test(item.val().trim())){
			layer.msg('姓名支持2~20个汉字,不支持数字及其他字符');
			return false;
		}
		return true;
	}
	
	//验证验证码
	Validate.prototype._veri = function(o){
		var item = o;
		var re = /^\d{4}$/;
		if (item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请填写验证码');
		   return false;
		}
		if(!re.test(item.val().trim())){
			layer.msg('验证码不正确');
			return false;
		}
		return true;
	}
	
	//验证身份证号
	Validate.prototype._ic = function(o){
		var item = o;
		//验证是否为空或默认值
		if (item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请输入您的身份证号');
			return false;
		}
		//验证长度类型
		if(item.val() != "" && !/(^\d{15}$)|(^\d{17}(\d|X)$)/.test(item.val().trim().toUpperCase())){
			layer.msg('您输入的身份证号码不正确');
			return false;
		}
		//验证省份
		var vcity = { 11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",
			21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",
			33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",
			42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",
			51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",
			63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"
		};
		var province = item.val().substr(0,2);
		if(vcity[province] == undefined){
			layer.msg('您输入的身份证号码不正确');
			return false;
		}
		//校验日期
		if(checkBirthday(item) == false){
			layer.msg('您输入的身份证号码不正确');
			return false;
		}
		//校验位校验
		if(checkParity(item) == false){
			layer.msg('您输入的身份证号码不正确');
			return false;
		}
		return true;
	}
	
	//检查生日是否正确 
	checkBirthday = function(item){
		var card = item.val();
		var len = item.val().trim().toUpperCase().length;
		
		//身份证15位时，次序为省（3位）市（3位）年（2位）月（2位）日（2位）校验位（3位），皆为数字
		if(len == '15')	{
			var re_fifteen = /^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/;
			var arr_data = item.val().match(re_fifteen);
			var year = arr_data[2];
			var month = arr_data[3];
			var day = arr_data[4];
			var birthday = new Date('19'+year+'/'+month+'/'+day);
			return verifyBirthday('19'+year,month,day,birthday);
		}
		//身份证18位时，次序为省（3位）市（3位）年（4位）月（2位）日（2位）校验位（4位），校验位末尾可能为X
		if(len == '18')	{
			var re_eighteen = /^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/;
			var arr_data = item.val().trim().toUpperCase().match(re_eighteen);
			var year = arr_data[2];
			var month = arr_data[3];
			var day = arr_data[4];
			var birthday = new Date(year+'/'+month+'/'+day);
			return verifyBirthday(year,month,day,birthday);
		}
	}
	
	//校验日期
	verifyBirthday = function(year,month,day,birthday) {
		var now = new Date();
		var now_year = now.getFullYear();
		//年月日是否合理
		if(birthday.getFullYear() == year && (birthday.getMonth() + 1) == month && birthday.getDate() == day) {
			//判断年份的范围（3岁到100岁之间)
			var time = now_year - year;
			if(time >= 3 && time <= 100) {
				return true;
			}
			return false;
		}
		return false;
	};
	
	//校验位的检测  
	checkParity = function(item){  
	    //15位转18位  
	    card = changeFivteenToEighteen(item.val().trim().toUpperCase());
	    var len = card.length;  
	    if(len == '18')  
	    {  
	        var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);  
	        var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');  
	        var cardTemp = 0, i, valnum;  
	        for(i = 0; i < 17; i ++)  
	        {  
	            cardTemp += card.substr(i, 1) * arrInt[i];  
	        }  
	        valnum = arrCh[cardTemp % 11];  
	        if (valnum == card.substr(17, 1))  
	        {  
	            return true;
	        }  
	        return false;  
	    }  
	    return false;  
	};  
	
	//15位转18位
	changeFivteenToEighteen = function(card){
		if(card.length == '15'){  
	        var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);  
	        var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');  
	        var cardTemp = 0, i;    
	        card = card.substr(0, 6) + '19' + card.substr(6, card.length - 6);  
	        for(i = 0; i < 17; i ++)  
	        {  
	            cardTemp += card.substr(i, 1) * arrInt[i];  
	        }  
	        card += arrCh[cardTemp % 11];  
	        return card;  
	    }  
	    return card;  
	};
	
	//验证银行卡
	Validate.prototype._bankCard = function(o){
		var item = o;
		//验证是否为空或默认值
		if (item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请输入您的银行卡号');
			return false;
		}
		if (item.val().length < 16 || item.val().length > 19) {
			layer.msg('您输入的银行卡号码不正确');
			return false;
		}
		var num = /^\d*$/;  //全数字
		if (!num.exec(item.val())) {
			layer.msg("银行卡号必须全为数字");
			return false;
		}
		//开头6位
		var strBin="10,18,30,35,37,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,58,60,62,65,68,69,84,87,88,94,95,98,99";    
		if (strBin.indexOf(item.val().substring(0, 2))== -1) {
			layer.msg("银行卡号开头6位不符合规范");
			return false;
		}
		return true;
	}
	//验证城市
	Validate.prototype._cityName = function(o){
		var item = o;
		//验证是否为空或默认值
		if (item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请输入城市');
			return false;
		}
		var t =item.val().trim().replace(/[\u4e00-\u9fa5]/g,'');
		var total = (item.val().trim().length-t.length)*2+t.length;
		if(  total > 150 ){
			layer.msg('您输入城市名称过长');
			return false;
		}
		return true;
	}
	//验证银行卡ID
	Validate.prototype._bankId = function(o){
		var item = o;
		//验证是否为空或默认值
		if (item.val() == 0 || item.val() == item.attr('placeholder')){
			layer.msg('请选择开户银行');
			return false;
		}
		return true;
	}
	//验证支行
	Validate.prototype._bankBranch = function(o){
		var item = o;
		//验证是否为空或默认值
		if (item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请输入支行名称');
			return false;
		}
		var t =item.val().trim().replace(/[\u4e00-\u9fa5]/g,'');
		var total = (item.val().trim().length-t.length)*2+t.length;
		if(  total > 150 ){
			layer.msg('您输入支行名称过长');
			return false;
		}
		return true;
	}
	//验证邮箱
	Validate.prototype._email = function(o){
		var item = o;
		//验证是否为空或默认值

		if (item.val() == "" || item.val() == item.attr('placeholder')){
			layer.msg('请输入邮箱');
			return false;
		}
		if( item.val() != "" && !/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/.test(item.val().trim())){
			layer.msg('邮箱格式不正确');
			return false;
		}
		return true;
	}
	//验证昵称
	Validate.prototype._nicname = function(o){
		var item = o;
		//验证是否为空或默认值
		if (item.val() == 0 || item.val() == item.attr('placeholder')){
			layer.msg('请输入昵称');
			return false;
		}
		return true;
	}
})
