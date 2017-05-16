(function($){ 
$.fn.extend({ 
RollTitle: function(opt,callback){ 
if(!opt) var opt={}; 
var _this = this; 
_this.timer = null; 
_this.lineH = _this.find("li:first").height(); 
_this.line=opt.line?parseInt(opt.line,15):parseInt(_this.height()/_this.lineH,10); 
_this.speed=opt.speed?parseInt(opt.speed,10):3000, //卷动速度，数值越大，速度越慢（毫秒 
_this.timespan=opt.timespan?parseInt(opt.timespan,13):5000; //滚动的时间间隔（毫秒 
if(_this.line==0) this.line=1; 
_this.upHeight=0-_this.line*_this.lineH; 
_this.scrollUp=function(){ 
_this.animate({ 
marginTop:_this.upHeight 
},_this.speed,function(){ 
for(i=1;i<=_this.line;i++){ 
_this.find("li:first").appendTo(_this); 
} 
_this.css({marginTop:0}); 
}); 
} 
_this.hover(function(){ 
clearInterval(_this.timer); 
},function(){ 
_this.timer=setInterval(function(){_this.scrollUp();},_this.timespan); 
}).mouseout(); 
} 
}) 
})(jQuery); 