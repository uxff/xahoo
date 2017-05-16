<script>
 
 
		$(function(){
			pageMore('#clickmore1',addMore01,0); //初始化加载更多
		})
		
		function pageMore(clickmore,fn,j){
			var i = 2; //设置当前页数
			$(clickmore).click(function(){
				$.ajax({
					type:'GET',
					url:gYiiCreateUrl('Ajax', 'ListReward'),
					data:{ page: i , status:j},
					dataType:'json',
					beforeSend:function(){
						loadMask();     //添加遮罩层
						$(clickmore).html('加载中...');
					},
					success:function(data){
						if(data){ 
							//alert(data);
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
				if(array.member.member_avatar==''){
					array.member.member_avatar = "{$resourcePath}/imgs/h-per-head.png";
				}
				str += '<li class="listdash">';
				str += '<a class="detail clearfix"><img src="'+array.member.member_avatar+'" height="40" width="40"/>';
				str += '<div class="detail-body">';
				str += '<h4 class=""><span class="tit">'+array.member.member_nickname+'('+array.degree+'度小伙伴）</span><strong class="comm">+'+array.reward_score+'</strong></h4>';
				str += '<p class="">'+array.last_modified+'<span class="state">获得佣金</span></p>';
				str += '</div>';
				str += '</a></li>';
			});
			$("#morewrap1").append(str);
		}
	
</script>