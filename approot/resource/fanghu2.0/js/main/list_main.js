define(function(require){
	require('../lib/jquery/jquery-1.10.1.min.js');
	require('../lib/layer/layer.js');
	var Tab = require('../module/tab.js');
	
	var tab = new Tab(".task-list");
	
	tab.render();       
	//懒加载模式
	require('../lib/jquery-lazyload/jquery-lazyload.js');
	$(function(){
		//懒加载
		$("img").lazyload({effect: "fadeIn"});
		// 触底加载列表分页
		window.onscroll=function(){	
		if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
			    load_more();
			    //懒加载
				$("img").lazyload({effect: "fadeIn"});
		    }
		};
		
		// 各个tab的分页信息
		var settings = {
			"all-tasks": {
				"page": 2,
				"size": 8,
				"is_last_page": false,
				"status": 0,
				"show_sns": true,
				"show_hit_count": false,
				"show_participate_button": false
			},
			"pending-tasks": {
				"page": 2,
				"size": 8,
				"is_last_page": false,
				"status": 1,
				"show_sns": false,
				"show_hit_count": true,
				"show_participate_button": false
			},
			"completed-tasks": {
				"page": 2,
				"size": 8,
				"is_last_page": false,
				"status": 2,
				"show_sns": false,
				"show_hit_count": true,
				"show_participate_button": false
			},
			"new-tasks": {
				"page": 2,
				"size": 8,
				"is_last_page": false,
				"status": 3,
				"show_sns": false,
				"show_hit_count": false,
				"show_participate_button": true
			}
		};
		
		function load_more() {
			var current_tab_name = $(".list-tab:visible").attr("name");
			var status = 0;
			var show_sns = false;
			var show_main_line_additives = true;
			
			var tab_settings = settings[current_tab_name];

			if (tab_settings["is_last_page"]) return false;
			
			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',
				data: {page: tab_settings.page, pageSize: tab_settings.size},
				success: function (res) {
					$.each(res.list, function (idx, line) {
						
						var main_li = generate_main_line(line, tab_settings, res.accounts_id);
						//最新任务
						if (tab_settings.show_participate_button){
							var main_li = add_participate_btn(main_li, line, res.accounts_id);
							$(".list-tab:visible ul").append(main_li);
						}
						//已完成任务
						if (tab_settings.show_hit_count){
							var main_li = add_hit_count(main_li, line, res.accounts_id);
							$(".list-tab:visible ul").append(main_li);
						} 
						//所有任务
						//if (tab_settings.show_sns){
						//	$(".list-tab:visible ul").append(generate_sns_line(line));
						//}
					});
					
                    settings[current_tab_name]["page"]++;
					if ((res.total / tab_settings.size)*1 <= settings[current_tab_name]["page"]) settings[current_tab_name]["is_last_page"] = true;
                    
				},
				
				error: function () {
					layer.msg("出错了，请重试");
				}
			});
		}
		
		// 生成主<li>代码
		function generate_main_line(data, tab_settings, accounts_id) {
			var li = '<li>'+
                            '<a href="index.php?r=lizhuan/joinTask&taskTplId='+data.task_id+'&accounts_id='+accounts_id+'">'+
                            	'<div class="task_img">'+
                                	'<img src="'+data.surface_url+'">'+
                                '</div>'+
                                '<div class="fl task-info">'+
                                    '<h3>'+data.task_name+'</h3>'+
                                    '<p class="active"><i class="iconfont icon-money"></i>'+data["_reward_desc"]+'&nbsp;&nbsp;'+data["_reward_desc2"]+'</p>'+
                                '</div>'+
                            '</a>'+
                        '</li>';
			return li;
		}
		
		// 往主<li>添加点击次数显示
		function add_hit_count(main_li, data, accounts_id) {
			
			main_li = '<li>'+
                            '<a href="index.php?r=lizhuan/joinTask&taskTplId='+data.task_id+'&accounts_id='+accounts_id+'">'+
	                            '<div class="task_img">'+
	                                '<img src="'+data.surface_url+'">'+
                                '</div>'+
                                '<div class="fl task-info task-over">'+
                                    '<h3>'+data.task_name+'</h3>'+
                                    '<p class="active"><i class="iconfont icon-money"></i>'+data["_reward_desc"]+'<span>点击：'+data["view_count"]+'次</span></p>'+
                                '</div>'+
                            '</a>'+
                        '</li>';
			return main_li;
		}
		
		// 往主<li>添加我要参与按钮
		function add_participate_btn(main_li, data, accounts_id) {
			var div = '<div class="fr task-btnbox">'+
							'<a class="sm-btn" href="index.php?r=lizhuan/joinTask&taskTplId='+data.task_id+'&accounts_id='+accounts_id+'">我要参与</a>'+
						'</div>';
			main_li = main_li.replace('</a>','</a>'+div);
			return main_li;
		}
		
		// 生成“分享”<li>
		function generate_sns_line(data) {
			var li = '<li>'+
						'<a href="javascript:;">新浪微博</a>'+
					 '</li>'
			
			return li;
		}
	});
	
})
