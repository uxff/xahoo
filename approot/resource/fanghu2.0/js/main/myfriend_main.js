define(function(require){
	require('../lib/jquery/jquery-1.10.1.min.js');
	require('../lib/layer/layer.js');
	
	$(function(){
		
		// 触底加载列表分页
		window.onscroll=function(){	
		if ($(document).scrollTop() + $(window).height() >= $(document).height()) {
			    load_more();
		    }
		};
		
		// 各个tab的分页信息
		var settings = {
			"all-friends": {
				"page": 2,
				"size": 10,
				"is_last_page": false
			}
		};
		
		function load_more() {
			var current_tab_name = $(".list-tab:visible").attr("name");
			
			var tab_settings = settings[current_tab_name];

			if (tab_settings["is_last_page"]) return false;
			
			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',
				data: {page: tab_settings.page, size: tab_settings.size},
				
				success: function (res) {
					$.each(res.list, function (idx, line) {
						var main_line = generate_main_line(line);
						$(".list-tab:visible").append(main_line);
					});
					
                    ++settings[current_tab_name]["page"];
					if ((res.total / tab_settings.size)*1 <= settings[current_tab_name]["page"]) settings[current_tab_name]["is_last_page"] = true;
                    
				},
				
				error: function () {
					layer.msg("出错了，请重试");
				}
			});
		}

		// 生成列表行代码
		function generate_main_line(data) {
			var a = $(document.createElement("a"));
			a.addClass("friend_item");
			
			var div1 = $(document.createElement("div"));
			div1.addClass("fl friend_icon");
			
			var img = $(document.createElement("img"));
			if (data.member_avatar || false) img.attr({"src": data.member_avatar});
			else img.attr({"src": resource_path + '/images/integral/friend_icon.png'});
			
			div1.append(img);
			
			var div2 = $(document.createElement("div"));
			div2.addClass("fl");
			
			var p1 = $(document.createElement("p"));
			p1.addClass("friend_name");
			p1.html(data.member_fullname);
			
			var p2 = $(document.createElement("p"));
			p2.addClass("friend_phone");
			p2.html(data.member_mobile);
			
			div2.append(p1).append(p2);
			
			a.append(div1).append(div2);
			
			return a;
		}
		
	});
	
})
