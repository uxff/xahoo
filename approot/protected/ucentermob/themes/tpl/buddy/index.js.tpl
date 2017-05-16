<script>

        // JS实现选项卡切换
        window.onload = function() {
				tab('#tab li','#panel>.paneldiv');
                tab('#tab2 a', '#panel2>div');
        }
        function tab(tab, panel) {
                var tab = $(tab),
                        panel = $(panel),
                        i, j, len = tab.length, bindclick;
                bindclick = function(i) {
                        tab[i].onclick = function() {
                                for (j = 0; j < len; j++) {
                                        tab[j].className = tab[j].className.replace('active', '');
                                        panel[j].style.display = 'none';
                                }
                                panel[i].style.display = 'block';
                                tab[i].className += 'active';
                        };

                };
                for (i = 0; i < len; i++) {
                        bindclick(i);
                }
        }
		$(function(){
			pageMore('#clickmore1',addMore01,'zhongchou'); //初始化加载更多
			pageMore('#clickmore2',addMore02,'fenquan'); //初始化加载更多
			pageMore('#clickmore3',addMore03,'fangfull'); //初始化加载更多
			pageBuddyMore('#clickmore4',addMore04); //小伙伴加载更多
		})
		//分页
		function pageMore(clickmore,fn,j){
			var i = 2; //设置当前页数
			var buddy_id = "{$buddy_id}";
			$(clickmore).click(function(){
				$.ajax({
					type:'GET',
					url:gYiiCreateUrl('Ajax', 'ListBuildingBuddy'),
					data:{ page: i ,buddy_id:buddy_id, source:j},
					dataType:'json',
					beforeSend:function(){
						loadMask();     //添加遮罩层
						$(clickmore).html('加载中...');
					},
					success:function(data){
						if(data){ 
							fn(data);
							//console.log(data);
							if( (parseInt(i) * 10) >= parseInt($(clickmore).attr('alt')) ){
								$(clickmore).hide();
							}
							i++;   //+1,当再次加载时增加当前页码数
						}else{ 
							$(clickmore).hide(); 
							//alert('没有更多内容了！'); 
						} 
					},
					error: function(){
						alert('加载错误!');
					},
					complete:function(){
						removeMask();   //数据加载完成后删除遮罩层
						$(clickmore).html('点击加载更多');
					}
				})
			});
		}

		//分页
		function pageBuddyMore(clickmore,fn){
			var i = 2; //设置当前页数
			var buddy_id = "{$buddy_id}";
			$(clickmore).click(function(){
				$.ajax({
					type:'GET',
					url:gYiiCreateUrl('Ajax', 'ListBuddy'),
					data:{ page: i ,buddy_id:buddy_id},
					dataType:'json',
					beforeSend:function(){
						loadMask();     //添加遮罩层
						$(clickmore).html('加载中...');
					},
					success:function(data){
						if(data){ 
							fn(data);
							if( (parseInt(i) * 10) >= parseInt($(clickmore).attr('alt')) ){
								$(clickmore).hide();
							}
							i++;   //+1,当再次加载时增加当前页码数
						}else{ 
							$(clickmore).hide(); 
							//alert('没有更多内容了！'); 
						} 
					},
					error: function(){
						alert('加载错误!');
					},
					complete:function(){
						removeMask();   //数据加载完成后删除遮罩层
						$(clickmore).html('点击加载更多');
					}
				})
			});
		}
				
		function addMore01(data) {
			var str = "";
			$.each(data, function(index, array) {
				str += '<div class="log-item-box"><a class="tit clearfix" href=""><strong>' + array.task_building.building_name + '</strong>{*<span>认购:2份</span>*}</a><div class="log-item"><dl class="imgbg">';
				str += '<dt class="begin line"><span class="ok">认购</span><span class="date">' + array.statusdate3 + '</span></dt>';
				if(array.statusdate4=='0000-00-00'){
					str +='<dd class="end unok">清算</dd>';
				}else{
					str += '<dd class="end"><span class="ok">清算</span><span class="date">' + array.statusdate4 + '</span></dd>';
				}
				str += '</dl></div></div>';
			});
			$("#morewrap1").append(str);
		}
		function addMore02(data) {
			var str = "";
			$.each(data, function(index, array) {
				
				str += '<div class="log-item-box"><a class="tit clearfix" href=""><strong>' + array.task_building.building_name + '</strong>{*<span>认购:2份</span>*}</a><div class="log-item"><dl class="imgbg">';
				str += '<dt class="begin line"><span class="ok">认购</span><span class="date">' + array.statusdate3 + '</span></dt>';
				if(array.statusdate4=='0000-00-00'){
					str +='<dd class="end unok">清算</dd>';
				}else{
					str += '<dd class="end"><span class="ok">清算</span><span class="date">' + array.statusdate4 + '</span></dd>';
				}
				str += '</dl></div></div>';
			});
			$("#morewrap2").append(str);
		}
		function addMore03(data) {
			var str = "";
			
			$.each(data, function(index, array) {
				str += '<div class="log-item-box"><a class="tit clearfix"><strong>' + array.task_building.building_name + '</strong><span>{*海口市  *}均价'+ array.task_building.building_price +'</span></a><div class="log-item"><dl class="imgbg step4">';
				str += '<dd class="begin line step4"><span class="ok">预约</span><span class="date">' + array.statusdate1 + '</span></dd>';
				if(array.statusdate2=='0000-00-00'){
					str += '<dd class="next2 unok">到访</dd>';
				}else{
					str +='<dd class="next2"><span class="ok">到访</span><span class="date">' + array.statusdate2 + '</span></dd>';
				}
				if(array.statusdate3=='0000-00-00'){
					str += '<dd class="next3 unok">签约</dd>';
				}else{
					str +='<dd class="next3"><span class="ok">签约</span><span class="date">' + array.statusdate3 + '</span></dd>';
				}				
				if(array.statusdate4=='0000-00-00'){
					str +='<dd class="end unok">成交</dd>';
				}else{
					str +='<dd class="end"><span class="ok">成交</span><span class="date">' + array.statusdate4 + '</span></dd>';
				}					
				str +='</dl></div></div>';
			});
			$("#morewrap3").append(str);
		}		
		
		function addMore04(data) {
			var str = "";
			$.each(data, function(index, array) {
				if(array.member_avatar==''){
					array.member_avatar = "{$resourcePath}/imgs/h-per-head.png";
				}
				str += '<li><i class="level-' + array.degree + '"></i><a class="media" href="'+gYiiCreateUrl('buddy', 'index','id='+array.member_id+'')+'"><img class="media-left" src="' + array.member_avatar + '"  width="50px" height="50px" alt=""><div class="media-body"><h4 class="nick">' + array.member_nickname + '（' + array.member_fullname + '）</h4><p class="log clearfix"><span>' + array.member_mobile + '</span>';
				if(array.status_time){
					str += '<span>' + array.status_time + '</span><span>' + array.status_value + '</span>';
				}
				str += '</p></div></a></li>';
			});
			$("#morewrap4").append(str);
		}		
</script>