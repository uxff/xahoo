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
			"all-points": {
				"page": 2,
				"size": 8,
				"is_last_page": false
			}
		};
		
		// 分页函数
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
					$.each(res.list, function (group, list) {
						if ($(".integral_con.grp-" + group).length <= 0) $("section[name=all-points]").append(generate_month_block(group));
						$.each(list, function (idx, line) {
							var main_li = generate_main_line(line);
							$(".integral_con.grp-" + group).append(main_li);
						});
						
					});
					
                    ++settings[current_tab_name]["page"];
					if ((res.total / tab_settings.size)*1 <= settings[current_tab_name]["page"]) settings[current_tab_name]["is_last_page"] = true;
                    
				},
				
				error: function () {
					layer.msg("出错了，请重试");
				}
			});
		}
		
		// 生成积分条目
		function generate_main_line(data) {
			var a = $(document.createElement("a"));
			a.addClass("integral_item");
			
			var div1 = $(document.createElement("div"));
			div1.addClass("fl");
			
			var p1 = $(document.createElement("p"));
			p1.addClass("ig_tl");
			p1.html(data.remark);
			
			var p2 = $(document.createElement("p"));
			p2.addClass("ig_time");
			p2.html(data.last_modified);
			
			div1.append(p1).append(p2);
			
			var div2 = $(document.createElement("div"));
			div2.addClass("fr");
			
			var span = $(document.createElement("span"));
			span.addClass("plus");
			span.html(data.points);
			
			div2.append(span);
			
			a.append(div1).append(div2);
			
			return a;			
		}
		
		// 生成月份区块
		function generate_month_block(group) {
			var div1 = $(document.createElement("div"));
			div1.addClass("integral_con grp-" + group);
			
			var div2 = $(document.createElement("div"));
			div2.addClass("integral_tl");
			div2.html(group);
			
			div1.append(div2);
			
			return div1;
		}
		
		// 翻译年月
		function translate_month(year_month) {
			var base_date = new Date(year_month + '-1');
			var result =  base_date.getFullYear() + "年" + (base_date.getMonth() + 1) + "月";
			return result;
		}

	});

})
