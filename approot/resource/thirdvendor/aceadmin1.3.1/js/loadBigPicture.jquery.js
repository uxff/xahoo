$.fn.loadBigPicture = function(options) {    
     var defaults = {    
		 // foreground: 'red',    
		 // background: 'yellow'    
	 }; 
	 var opts = $.extend(defaults, options);    
	var oBig =	document.getElementById("big");	
	var oLoading =	oBig.getElementsByTagName("div")[0];
	$(this).each(function(index,element){
		//鼠标划过, 预加载图片插入容器并显示
		 this.onmouseover = function	()
		 {
			 var oImg	= document.createElement("img");
			 //图片预加载
			 var img = new Image();	
			 img.src = oImg.src =this.getAttribute('src-big');
			 //插入大图片
		 	 oBig.appendChild(oImg);
			 //鼠标移过样式
			 this.className ="active";
			//显示big
			oBig.style.display =oLoading.style.display = "block";
			//判断大图是否加载成功
			 img.complete	? oLoading.style.display = "none" :	(oImg.onload = function() {oLoading.style.display =	"none"; });
		 }
		  
		 //鼠标移动, 大图容器跟随鼠标移动
	   this.onmousemove = function(event)  {
		   var event = event ||	window.event; 
		   var iWidth =	document.documentElement.offsetWidth - event.clientX; 
		   //设置big的top值
		  oBig.style.top =	event.clientY-150+"px";
		  //设置big的left值, 如果右侧显示区域不够,	大图将在鼠标左侧显示.
		  oBig.style.left = (iWidth < oBig.offsetWidth	+ 10 ? event.clientX - oBig.offsetWidth	- 250 : event.clientX -120) + "px";
	   }

		//鼠标离开, 删除大图并隐藏大图容器
	 this.onmouseout	= function (){
		  this.className =	"";
		  oBig.style.display =	"none";
		 //移除大图片
		 oBig.removeChild(oBig.lastChild)
	 }

  })
 };