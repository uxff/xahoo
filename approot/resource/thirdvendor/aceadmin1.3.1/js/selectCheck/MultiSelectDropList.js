/************************************************
 * @authors:Hu gang
 * @description:
 * @date:2016-10-09
 * @version:
************************************************/

(function ($){
   
   $.fn.extend({
        MSDL: function (options){/*MultiSelectDropList*/
		 //各种属性参数
		 
		 var defaults = {
			width: '150',//下拉列表宽 
			maxheight: '180',//下拉列表最大高度
            data: [{'proID':1,'name':'北京市'},{'proID':2,'name':'天津市'}],//下拉列表中的数据
			selectallTxt: '全选',//全选文本
			selectokTxt: '确定',//确认文本
			callback:function(){alert('选择完毕')}
		 };
		 var options = $.extend(defaults, options);
		 
		 return this.each(function (){
		 
		 //插件实现代码
			//创建 input输入框
			//readonly:锁住键盘，不能向文本框输入内容
			var $ipt = $('<input type="text" readonly value="" class="select_rel" />');
			var $ipth = $('<input type="hidden" value="" name="poster[valid_area]" id="valid_area" class="select_id" />');
			$ipt.width(options.width-5);//设定文本框宽度
			
			var $this = $(this);
			$this.width(options.width);
			$ipt.appendTo($this);
			$ipth.appendTo($this);
		    
			//创建 下拉选项 
			
			//1.下拉选项包裹
			var $container = $('<div class="container"></div>');
		
			
			//2.创建 全选和确认按钮  top层 
			var $top = $('<div class="top"></div>');//外层div包裹
			var $all = $('<input type="checkbox" class="select_all"/><label>'+options.selectallTxt+'</label>');//全选
            var $btn = $('<div class="ok">'+options.selectokTxt+'</div>');
            $all.appendTo($top);
            $btn.appendTo($top);
			
			//3.下拉中的内容 content层
			var $content = $('<div class="content"></div>');//外层div包裹
			var count = options.data.length;
			var h = ( (count * 22) > parseInt(options.maxheight) ) ? options.maxheight : "'" + count * 22 + "'";
			$content.height(h);

			for(var i in options.data){
			  
			   var $list = $('<div><input type="checkbox" value='+options.data[i].proID+' /><label>'+options.data[i].name+'</label><br></div>');
			   $list.appendTo($content);
			}
           
			//4把top层和content层加到$container下
			$top.appendTo($container);
            $content.appendTo($container);	

            //把$container加到$(this)下
			$container.appendTo($this);	

			
            //js Effect
			var $dropList = $content.children().children('input');
			
			$all.change(function (){//点击all
				
				  var opt_arr = [];
				  var opt_id = [];
				  $dropList.each(function (){
					  if($all.is(':checked')){
						  $(this)[0].checked = 'checked';
						  opt_id.push($(this).val());
						  opt_arr.push($(this).next().text());
					  }else{
						  $(this)[0].checked = '';
						  opt_id = [];
						  opt_arr=[];
					  }
				  }); 
				  
				  $ipt.val(opt_arr.join(','));
				  $ipth.val(opt_arr.join(','));
			});
			
			$container.addClass('hidden');//开始隐藏
			
			$ipt.focus(function (){//文本框处于编辑
				$container.removeClass('hidden');
				$this.addClass('multi_select_focus');
			});
			
			$btn.click(function (){//点击 ok按钮 
			    $container.addClass('hidden');
				$this.removeClass('multi_select_focus');
				options.callback();
			});
			
			
			$dropList.change(function (){//勾选选项
				 var opt_arr = [];
				 var opt_id = [];
				 $dropList.each(function (){
				   if ($(this).is(':checked')){
				   		opt_id.push($(this).val());
				   		opt_arr.push($(this).next().text());
				   }
				 });
				 var $dropList_selected = $content.children().children('input:checked');
				 $ipt.val(opt_arr.join(','));
				 $ipth.val(opt_arr.join(','));
				 var o = $all[0];
				 var n1 = $dropList_selected.length;
				 var n2 = $dropList.length;
				 o.checked = (n1 === n2) ? 'checked' : '';
			});
		 });
	 },
   });
})(jQuery);